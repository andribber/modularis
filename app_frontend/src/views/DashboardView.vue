<script setup>
  import { computed, onMounted, ref } from 'vue';
  import { useRouter } from 'vue-router';
  import { useToast } from 'primevue/usetoast';

  import Button from 'primevue/button';
  import Dialog from 'primevue/dialog';

  import SectionHeader from '../components/SectionHeader.vue';
  import AppCard from '../components/AppCard.vue'
  import AppLoading from '../components/AppLoading.vue';
  import DashboardEmployeeItem from '../components/employee/DashboardEmployeeItem.vue';
  import DashboardTeamItem from '../components/teams/DashboardTeamItem.vue';
  import DashboardFinancialItem from '../components/finantial/DashboardFinancialItem.vue';
  import ServiceModal from '../components/side-menu/ServiceModal.vue';

  import {
    useUserStore,
    useModuleStore,
    useTenantStore,
  } from '../store';

  const router = useRouter();
  const toast = useToast();

  // User

  const userStore = useUserStore();
  const tenantStore = useTenantStore();

  const getIntroduction = computed(() => `Olá, ${userStore.user?.name}!`);

  // Modules

  const moduleStore = useModuleStore();
  const request_pending = ref(true);
  const service_request_pending = ref(false);
  const selected_service = ref('');
  const selected_module = ref('');
  const service_modal_visible = ref(false);

  const getEmployeesModule = computed(() => moduleStore.modules.find(module => module.name === 'employees') || []);
  const getFinantialModule = computed(() => moduleStore.modules.find(module => module.name === 'finantial') || []);

  const getEmployees = computed(() => moduleStore.employees.slice(0, 4));
  const getTeams = computed(() => moduleStore.teams.slice(0, 4));
  const getFinancials = computed(() => moduleStore.financial.slice(0, 4));

  const hasEmployeeModule = computed(() => !! getEmployeesModule.value?.id);
  const hasFinancialModule = computed(() => !! getFinantialModule.value?.id);

  const viewEmployees = () => router.push('/employee');
  const viewTeams = () => router.push('/team');
  const viewFinancials = () => router.push('/finantial');

  const closeServiceModal = () => service_modal_visible.value = false;
  const contractService = async () => {
    service_request_pending.value = true;
    await moduleStore.contractModule({
      tenant_id: tenantStore.tenant.id,
      module: selected_service.value,
    });

    toast.add({ severity: 'success', summary: 'Sucesso!', detail: 'Serviço contratado com sucesso', life: 3000 });

    closeServiceModal();
    service_request_pending.value = false;
    selected_service.value = '';
    router.push(`/${selected_module.value}`);
  };

  const openContract = (service, module) => {
    selected_service.value = service;
    selected_module.value = module;
    service_modal_visible.value = true;
  };

  onMounted(async () => {
    request_pending.value = true;

    await Promise.allSettled([
      moduleStore.fetchEmployees({
        tenant_id: tenantStore.tenant.id,
        module: getEmployeesModule.value.id,
      }),
      moduleStore.fetchTeams({
        tenant_id: tenantStore.tenant.id,
        module: getEmployeesModule.value.id,
      }),
      moduleStore.fetchFinancial({
        tenant_id: tenantStore.tenant.id,
        module: getFinantialModule.value.id,
      }),
    ]);

    request_pending.value = false;
  });
</script>

<template>
  <SectionHeader :title="getIntroduction" description="Aqui está um resumo da sua conta" />

  <div class="dashboard-container">
    <AppCard class="custom-card">
      <div class="card-header-container">
        <span class="card-header">Funcionários</span>
        <span class="card-description">Veja um resumo dos funcionários</span>
      </div>

      <div class="module-container">
        <div v-if="request_pending" class="loading-container">
          <AppLoading />
        </div>

        <template v-else-if="getEmployees.length">
          <DashboardEmployeeItem v-for="employee in getEmployees" :key="employee.id" :employee="employee" />
        </template>

        <div class="empty-container" v-else>
          Sua organização não possui funcionários

          <Button v-if="hasEmployeeModule" size="small" @click="viewEmployees">Ver</Button>
          <Button v-else size="small" @click="openContract('employees', 'employee')">Contratar</Button>
        </div>
      </div>

      <div class="see-all-content" v-if="getEmployees.length">
        <Button @click="viewEmployees">Ver todos</Button>
      </div>
    </AppCard>

    <AppCard class="custom-card">
      <div class="card-header-container">
        <span class="card-header">Times</span>
        <span class="card-description">Veja um resumo dos times</span>
      </div>

      <div class="module-container">
        <div v-if="request_pending" class="loading-container">
          <AppLoading />
        </div>

        <template v-else-if="getTeams.length">
          <DashboardTeamItem v-for="team in getTeams" :key="team.id" :team="team" />
        </template>

        <div class="empty-container" v-else>
          Sua organização não possui times

          <Button v-if="hasEmployeeModule" size="small" @click="viewTeams">Ver</Button>
          <Button v-else size="small" @click="openContract('employees', 'team')">Contratar</Button>
        </div>
      </div>

      <div class="see-all-content" v-if="getTeams.length">
        <Button @click="viewTeams">Ver todos</Button>
      </div>
    </AppCard>

    <AppCard class="custom-card">
      <div class="card-header-container">
        <span class="card-header">Financeiro</span>
        <span class="card-description">Veja um resumo do financeiro</span>
      </div>

      <div class="module-container">
        <div v-if="request_pending" class="loading-container">
          <AppLoading />
        </div>

        <template v-else-if="getFinancials.length">
          <DashboardFinancialItem v-for="financial in getFinancials" :key="financial.id" :financial="financial" />
        </template>

        <div class="empty-container" v-else>
          Sua organização não possui registros

          <Button v-if="hasFinancialModule" size="small" @click="viewFinancials">Ver</Button>
          <Button v-else size="small" @click="openContract('finantial', 'finantial')">Contratar</Button>
        </div>
      </div>

      <div class="see-all-content" v-if="getFinancials.length">
        <Button @click="viewFinancials">Ver todos</Button>
      </div>
    </AppCard>
  </div>

  <Dialog v-model:visible="service_modal_visible" modal header="Contratar serviço" :style="{ width: '28rem' }">
    <ServiceModal
      :request_pending="service_request_pending"
      :selected_service="selected_service"
      @cancel="closeServiceModal"
      @contract="contractService"
    />
  </Dialog>
</template>

<style scoped>
  .borderless,
  .borderless:hover,
  .borderless:focus { border: none !important }

  .dashboard-container {
    padding: 8px 40px;
    width: 100%;
    gap: 10px;
    display: flex;
  }

  .custom-card {
    height: calc(100vh - 200px);
    display: flex;
    flex-direction: column;
  }

  .card-header-container {
    display: flex;
    flex-direction: column;
  }

  .card-header {
    font-size: 1.5rem;
    font-weight: 600;
  }

  .card-description { color: var(--text-5) }
  .module-container {
    display: flex;
    gap: 10px;
    margin-top: 10px;
    flex: 1;
    flex-direction: column;
    overflow-y: auto;
  }

  .loading-container {
    display: flex;
    justify-content: center;
    width: 100%;
  }

  .empty-container {
    display: flex;
    justify-content: center;
    flex-direction: column;
    gap: 10px;
    width: 100%;
    height: 100%;
    color: var(--text-4);
    align-items: center;
  }

  .see-all-content {
    align-items: flex-end;
    display: flex;
    padding: 20px 0 0;
  }
</style>