<script setup>
  import { defineProps, defineEmits, ref, computed } from 'vue';

  import Button from 'primevue/button';
  import InputText from 'primevue/inputtext';
  import Select from 'primevue/select';

  const USER_ROLES = {
    admin: 'admin',
    viewer: 'viewer',
  };

  const emit = defineEmits(['close', 'create']);
  const props = defineProps({
    request_pending: {
      type: Boolean,
      required: true,
    },
  })

  const email = ref('');
  const role = ref('');

  const roles = computed(() => Object.values(USER_ROLES).map(role => ({
    role: getLabel(role),
    slug: role,
  })));

  const getLabel = (role) => role === 'admin' ? 'Administrador' : 'Visualizador';

  const handleCreate = () => {
    emit('create', {
      members: [{
        email: email.value,
        role: role.value.slug,
      }]
    });
  };
</script>

<template>
  <div class="modal-container">
    <div class="input-container">
      <label for="email">E-mail *</label>
      <InputText v-model="email" size="small" id="email" />
    </div>

    <div class="input-container">
      <label for="role">Função *</label>
      <Select v-model="role" size="small" :options="roles" optionLabel="role" />
    </div>
  </div>

  <div class="actions-container">
    <Button :disabled="request_pending" type="button" label="Cancelar" severity="secondary" @click="emit('close')"></Button>
    <Button :disabled="request_pending" type="button" label="Criar" @click="handleCreate"></Button>
  </div>
</template>

<style scoped>
  .actions-container {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
  }

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
</style>