<script setup>
  import { computed, defineProps, defineEmits, ref } from 'vue';

  import Button from 'primevue/button';
  import TieredMenu from 'primevue/tieredmenu';

  const emit = defineEmits(['edit', 'delete', 'show']);
  const actionsMenu = ref(null);
  const actions = computed(() => [
    {
      label: 'Editar',
      icon: 'pi pi-pencil',
      command: () => emit('edit', props.employee),
    },
    {
      label: 'Deletar',
      icon: 'pi pi-trash',
      command: () => emit('delete', props.employee),
    },
  ]);

  const openActions = (event) => {
    actionsMenu.value.toggle(event);
  };

  const props = defineProps({
    employee: {
      type: Object,
      required: true,
    },
  });
</script>

<template>
  <div class="employee-container">
    <div class="header">
      <span class="name">{{ employee.name }}</span>

      <div class="actions-container">
        <Button @click="openActions" icon="pi pi-ellipsis-h" size="small" variant="outlined" class="borderless" />
        <TieredMenu :model="actions" ref="actionsMenu" id="overlay_menu" popup />
      </div>
    </div>

    <div class="occupation">
      {{ employee.occupation }}
    </div>

    <div class="data-container">
      <div class="data">
        <span>Conta: </span>
        <span>{{ employee.bank_account.account }}</span>
      </div>

      <div class="data">
        <span>Email: </span>
        <span>{{ employee.email }}</span>
      </div>

      <div class="see-more-container">
        <Button @click="emit('show', props.employee)" label="Ver mais" variant="link" class="grey-link" size="small" />
      </div>
    </div>
  </div>
</template>

<style scoped>
  .employee-container {
    padding: 10px 12px 10px 16px;
    border-radius: 12px;
    border: 1px solid var(--text-2);
  }

  .actions-container {
    display: flex;
    align-items: center;
    gap: 4px;
  }

  .borderless,
  .borderless:hover,
  .borderless:focus { border: none !important }

  .header {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .header .name {
    font-size: 18px;
    font-weight: 700;
    white-space: nowrap;
    width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .grey-link {
    color: var(--text-5);
    padding: 0px;
    min-width: 58px;
  }

  .occupation {
    color: var(--text-5);
    font-size: 12px;
    font-weight: 400;
    margin-bottom: 4px;;
  }

  .data-container {
    display: flex;
    flex-direction: column;
    line-height: 16px;
  }

  .see-more-container { margin-top: 8px; }
  .data span {
    font-size: 14px;
    font-weight: 500;
  }
</style>