<script setup>
  import { ref, defineEmits } from 'vue';

  import InputText from 'primevue/inputtext';
  import Button from 'primevue/button';

  const name = ref('');
  const emit = defineEmits(['close', 'delete']);
</script>

<template>
  <div class="danger-text">Essa ação não pode ser desfeita!</div>
  <div class="description">Tem certeza que deseja apagar a sua organização?</div>

  <div class="actions-container">
    <Button type="button" label="Cancelar" severity="secondary" @click="emit('cancel')"></Button>
    <Button severity="danger" type="button" label="Apagar" @click="emit('delete', { name })"></Button>
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