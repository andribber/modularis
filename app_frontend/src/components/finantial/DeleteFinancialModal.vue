<script setup>
  import { defineEmits, defineProps, computed } from 'vue';

  import Button from 'primevue/button';

  const emit = defineEmits(['close', 'delete']);
  const props = defineProps({
    delete_finance: {
      type: Object,
      required: true,
    },
  });

  const getBody = computed(() => ({
    finance_id: props.delete_finance.id,
    item_id: props.delete_finance.id,
  }))
</script>

<template>
  <div class="danger-text">Essa ação não pode ser desfeita!</div>
  <div class="description">Tem certeza que deseja apagar o registro?</div>

  <div class="actions-container">
    <Button type="button" label="Cancelar" severity="secondary" @click="emit('cancel')"></Button>
    <Button severity="danger" type="button" label="Apagar" @click="emit('delete', getBody)"></Button>
  </div>
</template>

<style scoped>
  .danger-text { color: var(--danger-color-2) }
  .description {
    color: var(--text-6);
    margin-bottom: 2rem;
  }

  .actions-container {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
  }

  .input-label { width: 40px; }
  .input-custom { flex: 1; }
</style>