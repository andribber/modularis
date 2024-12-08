<script setup>
  import { defineProps, defineEmits, ref, onMounted, computed } from 'vue';
  import { uuid } from 'vue-uuid';

  import Button from 'primevue/button';
  import InputText from 'primevue/inputtext';
  import Select from 'primevue/select';
  import MultiSelect from 'primevue/multiselect';

  import { useModuleStore } from '../../store';

  const emit = defineEmits(['cancel', 'create']);
  const props = defineProps({
    request_pending: {
      type: Boolean,
      required: true,
    },
    edit_employee: {
      type: Object,
      default: null,
    },
  });

  const moduleStore = useModuleStore();
  const getTeams = computed(() => moduleStore.teams);

  const name = ref('');
  const email = ref('');
  const occupation = ref('');
  const salary = ref(0);
  const teams = ref([]);
  const registry = ref(uuid.v4());
  const bank_name = ref('');
  const account = ref('');
  const bank_code = ref('');

  const getActionLabel = computed(() => props.edit_employee ? 'Editar' : 'Criar');

  const handleSalary = (salary) => {
    if (!salary) return "0.00";

    const sanitized = salary.replace(/[^\d.,]/g, "");
    const normalized = sanitized.replace(",", ".");
    const formatted = parseFloat(normalized).toFixed(2);

    return formatted;
  };

  const handleCreate = () => {
    if (props.edit_employee) {
      return handleEdit();
    }

    const body = {
      name: name.value,
      email: email.value,
      occupation: occupation.value,
      salary: handleSalary(salary.value),
      registry: registry.value,
      bank_account: {
        bank_name: bank_name.value,
        account: account.value,
        bank_code: bank_code.value,
      }
    }

    if (teams.value.length) {
      body.teams = teams.value.map(team => ({ team_id: team.id }));
    }

    emit('create', body);
  }

  const handleEdit = () => {
    const body = {
      employee_id: props.edit_employee.id,
      ...(name.value !== props.edit_employee.name && { name: name.value }),
      ...(email.value !== props.edit_employee.email && { email: email.value }),
      ...(occupation.value !== props.edit_employee.occupation && { occupation: occupation.value }),
      ...(salary.value !== props.edit_employee.salary && { salary: salary.value }),
      ...(bank_name.value !== props.edit_employee.bank_account.bank_name && { bank_name: bank_name.value }),
      ...(account.value !== props.edit_employee.bank_account.account && { account: account.value }),
      ...(bank_code.value !== props.edit_employee.bank_account.bank_code && { bank_code: bank_code.value }),
    }

    const originalTeamIds = props.edit_employee.teams.map(team => team.id).sort();
    const updatedTeamIds = teams.value.map(team => team.id).sort();

    if (JSON.stringify(originalTeamIds) !== JSON.stringify(updatedTeamIds)) {
      body.teams = teams.value.map(team => ({ team_id: team.id }));
    }

    emit('create', body);
  };

  onMounted(() => {
    if (props.edit_employee) {
      name.value = props.edit_employee.name;
      email.value = props.edit_employee.email;
      occupation.value = props.edit_employee.occupation;
      salary.value = props.edit_employee.salary;
      bank_name.value = props.edit_employee.bank_account.bank_name;
      account.value = props.edit_employee.bank_account.account;
      bank_code.value = props.edit_employee.bank_account.bank_code;
      teams.value = getTeams.value.filter(team =>
        props.edit_employee.teams.some(editTeam => editTeam.id === team.id));
    }
  })
</script>

<template>
  <div class="modal-container">
    <div class="input-container">
      <label for="name">Nome *</label>
      <InputText v-model="name" size="small" id="name" />
    </div>

    <div class="input-container">
      <label for="email">E-mail *</label>
      <InputText v-model="email" size="small" id="email" />
    </div>

    <div class="input-container">
      <label for="occupation">Ocupação *</label>
      <InputText v-model="occupation" size="small" id="occupation" />
    </div>

    <div class="input-container">
      <label for="salary">Salário *</label>
      <InputText v-model="salary" size="small" id="salary" />
    </div>

    <div class="input-container">
      <label for="team">Time</label>
      <MultiSelect v-model="teams" size="small" :options="getTeams" optionLabel="name" filter />
    </div>

    <div class="input-container">
      <label for="bank-name">Nome do banco *</label>
      <InputText v-model="bank_name" size="small" id="bank-name" />
    </div>

    <div class="input-container">
      <label for="account">Conta *</label>
      <InputText v-model="account" size="small" id="account" />
    </div>

    <div class="input-container">
      <label for="bank-code">Código do banco *</label>
      <InputText v-model="bank_code" size="small" id="bank-code" />
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

  .input-label { width: 40px; }
  .input-custom { flex: 1; }
</style>