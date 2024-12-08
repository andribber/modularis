<script setup>
  const props = defineProps({
    employee: {
      type: Object,
      default: null,
    },
  });
</script>

<template>
  <div class="data-container">
    <div>
      <span class="bold">Nome: </span>
      <span>{{ props.employee.name }}</span>
    </div>

    <div>
      <span class="bold">E-mail: </span>
      <span>{{ props.employee.email }}</span>
    </div>

    <div>
      <span class="bold">Ocupação: </span>
      <span>{{ props.employee.occupation }}</span>
    </div>

    <div>
      <span class="bold">Salário: </span>
      <span>R${{ props.employee.salary }}</span>
    </div>

    <div>
      <span class="bold">Nome do banco: </span>
      <span>{{ props.employee.bank_account.bank_name }}</span>
    </div>

    <div>
      <span class="bold">Conta: </span>
      <span>{{ props.employee.bank_account.account }}</span>
    </div>

    <div>
      <span class="bold">Código do banco: </span>
      <span>{{ props.employee.bank_account.bank_code }}</span>
    </div>

    <div>
      <span class="bold">Times: </span>
      <span v-if="! props.employee.teams || ! props.employee.teams.length">Sem times</span>
    </div>

    <template v-if="props.employee.teams && props.employee.teams.length">
      <div class="teams-section">
        <div class="team-container" v-for="team in props.employee.teams" :key="team.id">
          <span class="bold employee-name">{{ team.name }}</span>
          <div>
            <span class="bold">Descrição: </span>
            <span>{{ team.description }}</span>
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
  .teams-section {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 45vh;
    overflow-y: auto;
  }

  .team-container {
    display: flex;
    flex-direction: column;
    gap: 4px;
    font-size: 14px;
    border-radius: 8px;
    border: 1px solid var(--text-3);
    padding: 4px 10px;
  }
</style>