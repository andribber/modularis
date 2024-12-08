<script setup>
  import { computed } from 'vue';

  import { useModuleStore } from '../../store';

  const moduleStore = useModuleStore();

  const props = defineProps({
    team: {
      type: Object,
      required: true,
    },
  })

  const getLeader = computed(() => {
    if (props.team.leader) {
      return props.team.leader?.name;
    }

    return moduleStore.employees.find(employee => employee.id === props.team.leader_id)?.name || 'Não encontrado';
  })
</script>

<template>
  <div class="data-container">
    <div>
      <span class="bold">Nome: </span>
      <span>{{ props.team.name }}</span>
    </div>

    <div>
      <span class="bold">Líder: </span>
      <span>{{ getLeader }}</span>
    </div>

    <template v-if="props.team.employees && props.team.employees.length">
      <span class="bold">Funcionários:</span>
      <div class="employees-section">
        <div class="employee-container" v-for="employee in props.team.employees" :key="employee.id">
          <span class="bold employee-name">{{ employee.name }}</span>

          <div>
            <span class="bold">Email: </span>
            <span>{{ employee.name }}</span>
          </div>

          <div>
            <span class="bold">Ocupação: </span>
            <span>{{ employee.occupation }}</span>
          </div>

          <div>
            <span class="bold">Salário: </span>
            <span>R${{ employee.salary }}</span>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<style scoped>
  .data-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .bold { font-weight: 700; }
  .employees-section {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 45vh;
    overflow-y: auto;
  }

  .employee-container {
    display: flex;
    flex-direction: column;
    gap: 4px;
    font-size: 14px;
    border-radius: 8px;
    border: 1px solid var(--text-3);
    padding: 4px 10px;
  }

  .employee-name { font-size: 16px; }
</style>