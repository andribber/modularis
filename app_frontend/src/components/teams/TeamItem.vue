<script setup>
  import { computed, defineProps, defineEmits, ref } from 'vue';

  import Button from 'primevue/button';
  import TieredMenu from 'primevue/tieredmenu';

  import { useModuleStore } from '../../store';

  // Actions

  const moduleStore = useModuleStore();

  const emit = defineEmits(['edit', 'delete']);
  const actionsMenu = ref(null);
  const openActions = (event) => {
    actionsMenu.value.toggle(event);
  };

  const actions = computed(() => [
    {
      label: 'Editar',
      icon: 'pi pi-pencil',
      command: () => emit('edit', props.team),
    },
    {
      label: 'Deletar',
      icon: 'pi pi-trash',
      command: () => emit('delete', props.team),
    },
  ]);

  const getLeader = computed(() => {
    if (props.team.leader) {
      return props.team.leader?.name;
    }

    return moduleStore.employees.find(employee => employee.id === props.team.leader_id)?.name || 'Não encontrado';
  })

  const props = defineProps({
    team: {
      type: Object,
      required: true,
    },
  });
</script>

<template>
  <div>
    <div class="team-container">
      <div class="header">
        <span class="name">{{ props.team.name }}</span>

        <div class="actions-container">
          <Button @click="openActions" icon="pi pi-ellipsis-h" size="small" variant="outlined" class="borderless" />
          <TieredMenu :model="actions" ref="actionsMenu" id="overlay_menu" popup />
        </div>
      </div>

      <div class="data-container">
        <div class="data">
          <span>{{ props.team.description }}</span>
        </div>

        <div class="data">
          <span>Líder:</span>
          <span>{{ getLeader }}</span>
        </div>

        <div class="see-more-container">
          <Button @click="emit('show', props.team)" label="Ver mais" variant="link" class="grey-link" size="small" />
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .team-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 10px;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
  }

  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .name {
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

  .borderless,
  .borderless:hover,
  .borderless:focus { border: none !important }

  .data-container {
    display: flex;
    flex-direction: column;
    gap: 5px;
  }

  .data {
    display: flex;
    gap: 5px;
    font-size: 14px;
    font-weight: 500;
    line-height: 16px;
  }
</style>