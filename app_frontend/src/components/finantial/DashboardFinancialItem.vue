<script setup>
  import { defineProps, computed } from 'vue';

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

  const props = defineProps({
    financial: {
      type: Object,
      required: true,
    },
  });

  const getTypeColor = computed(() => {
    if (props.financial.type === TYPES.expense) {
      return 'type-danger';
    }

    if (props.financial.type === TYPES.income) {
      return 'type-success';
    }

    return 'type-info'
  })

  const getStatusColor = computed(() => {
    if (props.financial.status === STATUS.canceled) {
      return 'status-canceled';
    }

    if (props.financial.status === STATUS.paid) {
      return 'status-paid';
    }

    if (props.financial.status === STATUS.processing) {
      return 'status-processing';
    }

    return 'status-waiting-payment';
  });

</script>

<template>
  <div class="data-container">
    <div class="data-header">
      <span class="data-name">{{ props.financial.description }}</span>
      <span class="data-occupation">R${{ props.financial.amount }}</span>
    </div>

    <div>
      <span class="bold">Tipo: </span>
      <span :class="getTypeColor">{{ types_translations[props.financial.type] }}</span>
    </div>

    <div class="align-center">
      <span class="bold">Status: </span>
      <span class="finance-status" :class="getStatusColor">{{ statuses_translations[props.financial.status] }}</span>
    </div>
  </div>
</template>

<style scoped>
  .data-container {
    display: flex;
    flex-direction: column;
    gap: 8px;
    border-radius: 6px;
    border: 1px solid var(--text-3);
    padding: 6px 10px;
  }

  .bold { font-weight: 700; }
  .data-header {
    display: flex;
    flex-direction: column;
  }

  .data-name {
    font-size: 1.2rem;
    font-weight: 600;
  }

  .data-occupation {
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--text-4);
  }

  .finance-status {
    font-size: 12px;
    font-weight: 500;
    border-radius: 12px;
    padding: 1px 10px;
  }

  .align-center {
    display: flex;
    gap: 6px;
    align-items: center;
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