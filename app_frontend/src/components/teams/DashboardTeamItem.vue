<script setup>
  import { defineProps } from 'vue';

  const props = defineProps({
    team: {
      type: Object,
      required: true,
    },
  });
</script>

<template>
  <div class="data-container">
    <div class="data-header">
      <span class="data-name">{{ props.team.name }}</span>
      <span class="data-occupation">Líder: {{ props.team.leader.name }}</span>
    </div>

    <div>
      <span class="bold">Descrição: </span>
      <span>{{ props.team.description }}</span>
    </div>

    <div>
      <span class="bold">Quantidade de integrantes: </span>
      <span>{{ props.team.employees.length }}</span>
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
</style>