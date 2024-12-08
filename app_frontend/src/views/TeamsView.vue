<script setup>
  import { ref, computed, onMounted } from 'vue';
  import { useRouter } from 'vue-router';

  import Dialog from 'primevue/dialog';

  import { useModuleLoader } from '../composables/useModuleLoader';

  import SectionHeader from '../components/SectionHeader.vue';
  import TeamModal from '../components/teams/TeamModal.vue';
  import DeleteTeamModal from '../components/teams/DeleteTeamModal.vue'
  import AppLoading from '../components/AppLoading.vue';
  import TeamItem from '../components/teams/TeamItem.vue';
  import TeamDataModal from '../components/teams/TeamDataModal.vue';

  import Button from 'primevue/button';

  import { useModuleStore, useTenantStore } from '../store';

  const router = useRouter();
  const moduleStore = useModuleStore();
  const tenantStore = useTenantStore();

  const getResult = computed(() => moduleStore.module.result || []);
  const getEmployeesModule = computed(() => moduleStore.modules.find(module => module.name === 'employees'));

  // Create
  const create_modal_visible = ref(false);
  const handleCreate = (body) => {
    createModuleItem(body);
    create_modal_visible.value = false;
  }

  // Edit
  const edit_modal_visible = ref(false);
  const edit_team = ref(null);
  const handleOpenEditTeamModal = (team) => {
    edit_modal_visible.value = true;
    edit_team.value = team;
  }

  const handleEdit = (body) => {
    editModuleItem(body);
    handleCancelEdit();
  };

  const handleCancelEdit = () => {
    edit_modal_visible.value = false;
    edit_team.value = null;
  }

  // Delete
  const delete_modal_visible = ref(false);
  const delete_team = ref(null);
  const handleOpenDeleteTeamModal = (team) => {
    delete_modal_visible.value = true;
    delete_team.value = team;
  }

  const handleCancelDelete = () => {
    delete_modal_visible.value = false;
    delete_team.value = null;
  }

  const handleDelete = (body) => {
    deleteModuleItem(body);
    handleCancelDelete();
  }

  // Show
  const show_modal_visible = ref(false);
  const show_team = ref(null);
  const handleOpenShowTeamModal = (team) => {
    show_modal_visible.value = true;
    show_team.value = team;
  }

  const {
    fetch_request_pending,
    create_request_pending,
    edit_request_pending,
    delete_request_pending,
    createModuleItem,
    editModuleItem,
    deleteModuleItem,
  } = useModuleLoader();

  onMounted(() => {
    if (! getEmployeesModule.value?.id) {
      return router.push('/dashboard');
    }

    moduleStore.fetchEmployees({
      tenant_id: tenantStore.tenant.id,
      module: getEmployeesModule.value.id,
    })
  });
</script>

<template>
  <SectionHeader title="Times">
    <template #actions>
      <Button label="Criar time" size="small" icon="pi pi-plus"  iconPos="right" @click="create_modal_visible = true" />
    </template>
  </SectionHeader>

  <div class="section-container">
    <template v-if="fetch_request_pending">
      <div class="loading-container">
        <AppLoading />
      </div>
    </template>

    <template v-else-if="getResult.length">
      <div class="teams-container">
        <TeamItem
          v-for="team in getResult"
          :key="team.id"
          :team="team"
          @edit="handleOpenEditTeamModal"
          @delete="handleOpenDeleteTeamModal"
          @show="handleOpenShowTeamModal"
        />
      </div>
    </template>

    <template v-else>
      <span class="empty-container">
        Sua organização não possui nenhum time cadastrado.
      </span>
    </template>
  </div>

  <Dialog v-model:visible="create_modal_visible" modal header="Criar time" :style="{ width: '28rem' }">
    <TeamModal
      :request_pending="create_request_pending"
      @cancel="create_modal_visible = false"
      @create="handleCreate"
    />
  </Dialog>

  <Dialog v-model:visible="edit_modal_visible" modal header="Editar time" :style="{ width: '28rem' }">
    <TeamModal
      :request_pending="edit_request_pending"
      :edit_team="edit_team"
      @cancel="edit_modal_visible = false"
      @create="handleEdit"
    />
  </Dialog>

  <Dialog v-model:visible="delete_modal_visible" modal header="Deletar time" :style="{ width: '28rem' }">
    <DeleteTeamModal
      :request_pending="delete_request_pending"
      :delete_team="delete_team"
      @cancel="handleCancelDelete"
      @delete="handleDelete"
    />
  </Dialog>

  <Dialog v-model:visible="show_modal_visible" modal header="Dados do time" :style="{ width: '28rem' }">
    <TeamDataModal :team="show_team" />
  </Dialog>
</template>

<style scoped>
  .section-container {
    display: flex;
    gap: 10px;
    width: 100%;
    padding: 8px 40px;
  }

  .loading-container {
    display: flex;
    justify-content: center;
    width: 100%;
  }


  .teams-container {
    display: grid;
    gap: 10px;
    width: 100%;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  }

  .empty-container { color: var(--text-5) }
</style>