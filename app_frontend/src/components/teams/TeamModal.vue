<script setup>
  import { defineProps, defineEmits, computed, ref, onMounted } from 'vue';

  import Button from 'primevue/button';
  import InputText from 'primevue/inputtext';
  import Select from 'primevue/select';

  import { useModuleStore } from '../../store';

  const emit = defineEmits(['cancel', 'create']);
  const props = defineProps({
    request_pending: {
      type: Boolean,
      required: true,
    },
    edit_team: {
      type: Object,
      default: null,
    },
  });

  const moduleStore = useModuleStore();
  const getEmployees = computed(() => moduleStore.employees);

  const name = ref('');
  const description = ref('');
  const leader = ref(null);

  const getActionLabel = computed(() => props.edit_team ? 'Editar' : 'Criar');

  const handleEdit = () => {
    const body = {
      team_id: props.edit_team.id,
      ...(name.value !== props.edit_team.name && { name: name.value }),
      ...(description.value !== props.edit_team.description && { description: description.value }),
      ...(leader.value && leader.value.id !== props.edit_team.leader_id && { leader_id: leader.value.id }),
    }

    emit('create', body);
  };

  const handleCreate = () => {
    if (props.edit_team) {
      return handleEdit();
    }

    const body = {
      name: name.value,
      description: description.value,
      leader_id: leader.value.id,
    }

    emit('create', body)
  }

  onMounted(() => {
    if (props.edit_team) {
      name.value = props.edit_team.name;
      description.value = props.edit_team.description;
      leader.value = moduleStore.employees.find(employee => employee.id === props.edit_team.leader_id);
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
      <label for="description">Descrição *</label>
      <InputText v-model="description" size="small" id="description" />
    </div>

    <div class="input-container">
      <label for="leader">Líder *</label>
      <Select v-model="leader" size="small" :options="getEmployees" optionLabel="name" />
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