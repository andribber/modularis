<script setup>
  import { ref, computed, onMounted } from 'vue';
  import { useRouter } from 'vue-router';

  import DataTable from 'primevue/datatable';
  import Column from 'primevue/column';
  import IconField from 'primevue/iconfield';
  import InputIcon from 'primevue/inputicon';
  import Button from 'primevue/button';
  import InputText from 'primevue/inputtext';
  import Dialog from 'primevue/dialog';

  import { useModuleLoader } from '../composables/useModuleLoader';

  import FinantialModal from '../components/finantial/FinantialModal.vue';
  import DeleteFinancialModal from '../components/finantial/DeleteFinancialModal.vue';

  import SectionHeader from '../components/SectionHeader.vue';
  import { useTenantStore, useTenantUserStore, useModuleStore } from '../store';

  import { STATUS, TYPES } from '..//enums/financial';

  const router = useRouter();
  const tenantUserStore = useTenantUserStore();
  const tenantStore = useTenantStore();
  const moduleStore = useModuleStore();

  const types_translations = {
    adjust: 'Ajuste',
    income: 'Renda',
    expense: 'Despesa',
  }

  const statuses_translations = {
    canceled: 'Cancelado',
    paid: 'Pago',
    processing: 'Processando',
    waiting_payment: 'Aguardando pagamento',
  }

  const getFinantialModule = computed(() => moduleStore.modules.find(module => module.name === 'finantial'));

  // Create
  const create_modal_visible = ref(false);
  const handleCreate = (body) => {
    createModuleItem(body);
    create_modal_visible.value = false;
  }

  // Edit
  const edit_modal_visible = ref(false);
  const edit_finance = ref(null);
  const handleOpenEditTeamModal = (team) => {
    edit_modal_visible.value = true;
    edit_finance.value = team;
  }

  const handleEdit = (body) => {
    editModuleItem(body);
    handleCancelEdit();
  };

  const handleCancelEdit = () => {
    edit_modal_visible.value = false;
    edit_finance.value = null;
  }

  // Delete
  const delete_modal_visible = ref(false);
  const delete_finance = ref(null);
  const handleOpenDeleteFinancialModal = (financial) => {
    delete_modal_visible.value = true;
    delete_finance.value = financial;
  }

  const handleCancelDelete = () => {
    delete_modal_visible.value = false;
    delete_finance.value = null;
  }

  const handleDelete = (body) => {
    deleteModuleItem(body);
    handleCancelDelete();
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

  const filters = ref('');
  const tenant_user_request_pending = ref(false);

  const getFinancialItems = computed(() => {
    let financials = moduleStore.module.result?.map((financial, index) => ({
      index: index + 1,
      id: financial.id,
      amount: financial.amount,
      description: financial.description,
      type: financial.type,
      status: financial.status,
      created_at: financial.created_at,
      user: tenantUserStore.tenant_users.find(tenant_user => tenant_user.user.id === financial.user_id)?.user || null,
    })) || [];

    if (filters.value) {
      financials = financials.filter(financial => {
        return financial.description.toLowerCase().includes(filters.value.toLowerCase());
      });
    }

    return financials;
  })

  const hasUser = (finance) => !! finance.user;
  const getUser = (finance) => {
    if (hasUser(finance)) {
      return finance.user.name;
    }

    return 'Sem usuário';
  }

  const getTypeColor = (type) => {
    if (type === TYPES.expense) {
      return 'type-danger';
    }

    if (type === TYPES.income) {
      return 'type-success';
    }

    return 'type-info'
  }

  const getStatusColor = (status) => {
    if (status === STATUS.canceled) {
      return 'status-canceled';
    }

    if (status === STATUS.paid) {
      return 'status-paid';
    }

    if (status === STATUS.processing) {
      return 'status-processing';
    }

    return 'status-waiting-payment';
  };

  const formatDate = (timestamp) => {
    const date = new Date(timestamp * 1000);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');

    return `${day}/${month}/${year} ${hours}:${minutes}`;
  };

  onMounted(async () => {
    if (! getFinantialModule.value?.id) {
      return router.push('/dashboard');
    }

    tenant_user_request_pending.value = true;
    await tenantUserStore.fetchUsers({ tenant_id: tenantStore.tenant.id });
    tenant_user_request_pending.value = false;
  });
</script>

<template>
  <SectionHeader title="Financeiro">
    <template #actions>
      <Button label="Criar registro" size="small" icon="pi pi-plus"  iconPos="right" @click="create_modal_visible = true" />
    </template>
  </SectionHeader>

  <DataTable
    :value="getFinancialItems"
    :rows="getFinancialItems.length"
    :totalRecords="getFinancialItems.length"
    tableStyle="min-width: 50rem"
    class="custom-table"
    dataKey="code"
  >
    <template #header>
      <div class="table-header">
        <div class="left-actions">
          <IconField>
              <InputIcon><i class="pi pi-search" /></InputIcon>
              <InputText v-model="filters" placeholder="Buscar" />
          </IconField>
        </div>
      </div>
    </template>

    <template #empty>
      <div class="empty-table">
        Nenhum registro encontrado.
      </div>
    </template>

    <Column field="index" header="#" />
    <Column field="description" header="Descrição" />
    <Column header="Valor">
      <template #body="slotProps">
        R${{ slotProps.data.amount }}
      </template>
    </Column>

    <Column header="Status">
      <template #body="slotProps">
        <div class="finance-status-container">
          <div class="finance-status" :class="getStatusColor(slotProps.data.status)">
            {{ statuses_translations[slotProps.data.status] }}
          </div>
        </div>
      </template>
    </Column>

    <Column header="Tipo">
      <template #body="slotProps">
        <span :class="getTypeColor(slotProps.data.type)">
          {{ types_translations[slotProps.data.type] }}
        </span>
      </template>
    </Column>

    <Column header="Usuário">
      <template #body="slotProps">
        <span :class="{ 'userless' : ! hasUser(slotProps.data) }">
          {{ getUser(slotProps.data) }}
        </span>
      </template>
    </Column>

    <Column header="Criado em">
      <template #body="slotProps">
        {{ formatDate(slotProps.data.created_at) }}
      </template>
    </Column>

    <Column>
      <template #body="slotProps">
        <div class="actions-container">
          <Button size="small" icon="pi pi-pencil" @click="handleOpenEditTeamModal(slotProps.data)" />
          <Button size="small" icon="pi pi-trash" class="p-button-danger" @click="handleOpenDeleteFinancialModal(slotProps.data)" />
        </div>
      </template>
    </Column>
  </DataTable>

  <Dialog v-model:visible="create_modal_visible" modal header="Criar registro" :style="{ width: '28rem' }">
    <FinantialModal
      :request_pending="create_request_pending"
      @cancel="create_modal_visible = false"
      @create="handleCreate"
    />
  </Dialog>

  <Dialog v-model:visible="edit_modal_visible" modal header="Editar registro" :style="{ width: '28rem' }">
    <FinantialModal
      :request_pending="edit_request_pending"
      :edit_finance="edit_finance"
      @cancel="edit_modal_visible = false"
      @create="handleEdit"
    />
  </Dialog>

  <Dialog v-model:visible="delete_modal_visible" modal header="Apagar registro" :style="{ width: '28rem' }">
    <DeleteFinancialModal
      :request_pending="delete_request_pending"
      :delete_finance="delete_finance"
      @cancel="handleCancelDelete"
      @delete="handleDelete"
    />
  </Dialog>
</template>

<style scoped>
  .custom-table {
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #dde4ee;
  }

  .empty-table  {
    width: 100%;
    display: flex;
    justify-content: center
  }

  ::v-deep tr > th,
  ::v-deep .p-datatable-header,
  ::v-deep .p-paginator {
    background-color: #F4F7FC;
  }

  ::v-deep tr:nth-child(odd) > td {
    background-color: #FFF;
  }

  ::v-deep tr:nth-child(even) > td {
    background-color: #F9FAFC;
  }

  ::v-deep .p-datatable-paginator-bottom {
    border-bottom: none;
  }

  .table-header {
    display: flex;
    gap: 10px;
    justify-content: space-between;
  }

  .left-actions {
    display: flex;
    gap: 10px;
  }

  .actions-container {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
  }

  .userless { color: var(--text-4) }
  .finance-status-container {
    display: flex;
    align-items: center;
  }

  .finance-status {
    font-size: 12px;
    font-weight: 500;
    border-radius: 12px;
    padding: 1px 10px;
  }

  .status-canceled {
    background-color: var(--danger-color-1);
    color: var(--danger-color-2);
  }

  .status-paid {
    background-color: var(--success-color-1);
    color: var(--success-color-2);
  }

  .status-processing {
    background-color: var(--info-color-1);
    color: var(--info-color-3);
  }

  .status-waiting-payment {
    background-color: var(--warning-color-1);
    color: var(--warning-color-3);
  }

  .type-danger { color: var(--danger-color-2); }
  .type-success { color: var(--success-color-2); }
  .type-info { color: var(--info-color-3); }
</style>