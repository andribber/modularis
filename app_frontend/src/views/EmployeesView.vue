<script setup>
  import { ref, computed, onMounted } from 'vue';
  import { useRouter } from 'vue-router';

  import Dialog from 'primevue/dialog';
  import Button from 'primevue/button';

  import { useModuleLoader } from '../composables/useModuleLoader';

  import SectionHeader from '../components/SectionHeader.vue';
  import EmployeeModal from '../components/employee/EmployeeModal.vue';
  import DeleteEmployeeModal from '../components/employee/DeleteEmployeeModal.vue'
  import EmployeeItem from '../components/employee/EmployeeItem.vue';
  import AppLoading from '../components/AppLoading.vue';
  import EmployeeDataModal from '../components/employee/EmployeeDataModal.vue';

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
  const edit_employee = ref(null);
  const handleOpenEditEmployeeModal = (employee) => {
    edit_modal_visible.value = true;
    edit_employee.value = employee;
  }

  const handleEdit = (body) => {
    editModuleItem(body);
    handleCancelEdit();
  };

  const handleCancelEdit = () => {
    edit_modal_visible.value = false;
    edit_employee.value = null;
  }

  // Delete
  const delete_modal_visible = ref(false);
  const delete_employee = ref(null);
  const handleOpenDeleteEmployeeModal = (employee) => {
    delete_modal_visible.value = true;
    delete_employee.value = employee;
  }

  const handleCancelDelete = () => {
    delete_modal_visible.value = false;
    delete_employee.value = null;
  }

  const handleDelete = (body) => {
    deleteModuleItem(body);
    handleCancelDelete();
  }

  // Show
  const show_modal_visible = ref(false);
  const show_employee = ref(null);
  const handleOpenShowEmployeeModal = (employee) => {
    show_modal_visible.value = true;
    show_employee.value = employee;
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

    moduleStore.fetchTeams({
      tenant_id: tenantStore.tenant.id,
      module: getEmployeesModule.value.id,
    })
  });
</script>

<template>
  <SectionHeader title="Funcionários">
    <template #actions>
      <Button label="Criar funcionário" size="small" icon="pi pi-plus"  iconPos="right" @click="create_modal_visible = true" />
    </template>
  </SectionHeader>

  <div class="section-container">
    <template v-if="fetch_request_pending">
      <div class="loading-container">
        <AppLoading />
      </div>
    </template>

    <template v-else-if="getResult.length">
      <div class="employees-container">
        <EmployeeItem
          v-for="employee in getResult"
          :key="employee.id"
          :employee="employee"
          @edit="handleOpenEditEmployeeModal"
          @delete="handleOpenDeleteEmployeeModal"
          @show="handleOpenShowEmployeeModal"
        />
      </div>
    </template>

    <template v-else>
      <span class="empty-container">
        Sua organização não possui funcionários cadastrados.
      </span>
    </template>
  </div>

  <Dialog v-model:visible="create_modal_visible" modal header="Criar funcionário" :style="{ width: '28rem' }">
    <EmployeeModal
      :request_pending="create_request_pending"
      @cancel="create_modal_visible = false"
      @create="handleCreate"
    />
  </Dialog>

  <Dialog v-model:visible="edit_modal_visible" modal header="Editar funcionário" :style="{ width: '28rem' }">
    <EmployeeModal
      :request_pending="edit_request_pending"
      :edit_employee="edit_employee"
      @cancel="handleCancelEdit"
      @create="handleEdit"
    />
  </Dialog>

  <Dialog v-model:visible="delete_modal_visible" modal header="Deletar funcionário" :style="{ width: '28rem' }">
    <DeleteEmployeeModal
      :request_pending="delete_request_pending"
      :delete_employee="delete_employee"
      @cancel="handleCancelDelete"
      @delete="handleDelete"
    />
  </Dialog>

  <Dialog v-model:visible="show_modal_visible" modal header="Dados do funcionário" :style="{ width: '28rem' }">
    <EmployeeDataModal :employee="show_employee" />
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

  .employees-container {
    display: grid;
    gap: 10px;
    width: 100%;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  }

  .empty-container { color: var(--text-5) }
</style>