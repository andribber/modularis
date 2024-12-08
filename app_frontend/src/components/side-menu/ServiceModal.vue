<script setup>
  import { ref, defineEmits, defineProps, computed } from 'vue';

  import Button from 'primevue/button';

  const name = ref('');
  const emit = defineEmits(['close', 'create']);
  const props = defineProps({
    request_pending: {
      type: Boolean,
      required: true,
    },
    selected_service: {
      type: String,
      default: '',
    }
  });

  const getService = computed(() => {
    if (props.selected_service === 'finantial') {
      return ' Financeiro';
    }

    return ' Colaboradores';
  });
</script>

<template>
  <div>
    <span>Você está prestes a contratar o serviço</span>
    <span class="bold-text">{{ getService }}</span>
    <span>.</span>
  </div>
  <div class="description">Tem certeza que deseja continuar?</div>

  <div class="actions-container">
    <Button :disabled="request_pending" type="button" label="Cancelar" severity="secondary" @click="emit('cancel')"></Button>
    <Button :disabled="request_pending" type="button" label="Contratar" @click="emit('contract', selected_service)"></Button>
  </div>
</template>

<style scoped>
  .description {
    color: var(--text-6);
    margin-bottom: 2rem;
  }

  .bold-text { font-weight: 600; }
  .actions-container {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
  }

  .input-label { width: 40px; }
  .input-custom { flex: 1; }
</style>