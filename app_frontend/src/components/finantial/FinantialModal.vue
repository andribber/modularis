<script setup>
  import { ref, computed, onMounted } from 'vue';

  import Button from 'primevue/button';
  import InputText from 'primevue/inputtext';
  import Select from 'primevue/select';

  import { useTenantUserStore } from '../../store';

  import { STATUS, TYPES } from '../../enums/financial';

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

  const default_option = { user: { name: 'Selecione uma opção', id: null } };

  const tenantUserStore = useTenantUserStore();
  const getTenantUser = computed(() => [
    default_option,
    ...tenantUserStore.tenant_users,
  ]);

  const getTypes = computed(() => Object.values(TYPES).map(type => ({
    value: type,
    label: types_translations[type],
  })));

  const getStatuses = computed(() => Object.values(STATUS).map(status => ({
    value: status,
    label: statuses_translations[status],
  })));

  const emit = defineEmits(['cancel', 'create']);
  const props = defineProps({
    request_pending: {
      type: Boolean,
      required: true,
    },
    edit_finance: {
      type: Object,
      default: null,
    },
  });

  const amount = ref('');
  const description = ref('');
  const user = ref({});
  const status = ref('');
  const type = ref('');

  const getActionLabel = computed(() => props.edit_finance ? 'Editar' : 'Criar');

  const handleSalary = (amount) => {
    if (!amount) return "0.00";

    const sanitized = amount.replace(/[^\d.,]/g, "");
    const normalized = sanitized.replace(",", ".");
    const formatted = parseFloat(normalized).toFixed(2);

    return formatted;
  };

  const handleEdit = () => {
    const body = {
      finance_id: props.edit_finance.id,
      ...(amount.value !== props.edit_finance.amount && { amount: handleSalary(amount.value) }),
      ...(description.value !== props.edit_finance.description && { description: description.value }),
      ...(status.value && status.value.value !== props.edit_finance.status && { status: status.value.value }),
      ...(type.value && type.value.value !== props.edit_finance.type && { type: type.value.value }),
      ...(user.value && user.value.user.id !== props.edit_finance.user.id && { user_id: user.value.user.id }),
    }

    emit('create', body);
  };

  const handleCreate = () => {
    if (props.edit_finance) {
      return handleEdit();
    }

    const body = {
      amount: handleSalary(amount.value),
      description: description.value,
      user_id: user.value.user?.id,
      status: status.value.value,
      type: type.value.value,
    };

    emit('create', body);
  };

  onMounted(() => {
    user.value = default_option;

    if (props.edit_finance) {
      amount.value = props.edit_finance.amount;
      description.value = props.edit_finance.description;
      status.value = getStatuses.value.find(status => status.value === props.edit_finance.status);
      type.value = getTypes.value.find(type => type.value === props.edit_finance.type);

      const tenant_user = getTenantUser.value.find(user => user.user.id === props.edit_finance.user?.id);

      if (tenant_user?.id) {
        user.value = tenant_user;
      }

      return;
    }

    status.value = getStatuses.value.find(status => status.value === 'waiting_payment');
    type.value = getTypes.value.find(type => type.value === 'adjust');
  })
</script>

<template>
    <div class="modal-container">
      <div class="input-container">
        <label for="amount">Valor *</label>
        <InputText v-model="amount" size="small" id="amount" />
      </div>

      <div class="input-container">
        <label for="description">Descrição *</label>
        <InputText v-model="description" size="small" id="description" />
      </div>

      <div class="input-container">
        <label for="user">Usuário</label>
        <Select v-model="user" size="small" :options="getTenantUser" optionLabel="user.name" />
      </div>

      <div class="input-container">
        <label for="type">Tipo</label>
        <Select v-model="type" size="small" :options="getTypes" optionLabel="label" />
      </div>

      <div class="input-container">
        <label for="status">Status</label>
        <Select v-model="status" size="small" :options="getStatuses" optionLabel="label" />
      </div>
    </div>

  <div class="actions-container">
    <Button :disabled="request_pending" type="button" label="Cancelar" severity="secondary" @click="emit('cancel')"></Button>
    <Button :disabled="request_pending" type="button" :label="getActionLabel" @click="handleCreate"></Button>
  </div>
</template>

<style scoped>
  .modal-container {
    margin-bottom: 2rem;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .input-container {
    gap: .5rem;
    display: flex;
    flex-direction: column;
  }

  .actions-container {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
  }
</style>