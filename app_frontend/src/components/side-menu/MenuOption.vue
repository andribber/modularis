<script setup>
  import { computed, defineEmits, ref } from 'vue';
  import { useRoute } from 'vue-router';

  import RightArrowIcon from '../../icons/RightArrowIcon.vue';

  const emit = defineEmits(['select']);
  const route = useRoute();
  const props = defineProps({
    selected: {
      type: Boolean,
      default: false,
    },

    option: {
      type: Object,
      required: true,
    },
  });

  const show_groups = ref(true);
  const getIconClass = computed(() => props.option.fill ? 'fill' : 'stroke');
  const hasGroupSelected = computed(() => !! props.option.groups?.find(group => getSelectedClass(group)));
  const getSelectedGroupClass = computed(() => hasGroupSelected.value ? 'group-selected' : '');
  const getSelectedClass = (option) => route.path.startsWith(`/${option.slug}`) ? 'selected' : '';

  const handleClickGroupItem = (option) => {
    emit('select', option, props.option)
  };
  const handleClick = () => {
    if (props.option.groups) {
      return show_groups.value = ! show_groups.value;
    }

    emit('select', props.option);
  }
</script>

<template>
  <div class="menu-option" :class="[getSelectedClass(props.option), getSelectedGroupClass]" @click="handleClick" >
    <div class="indicator-container">
      <div class="indicator" />
    </div>

    <div class="menu-content-container">
      <component class="option-icon" :class="getIconClass" :is="props.option.icon" />
      <span>{{ props.option.text }}</span>
    </div>

  </div>

  <template v-if="show_groups">
    <div v-for="(group, index) in props.option.groups" :key="index" class="menu-option" :class="getSelectedClass(group)" @click="handleClickGroupItem(group)">
      <div class="indicator-container group">
        <div class="indicator" />
      </div>

      <div class="menu-content-container">
        <RightArrowIcon class="option-icon stroke" />
        <span>{{ group.text }}</span>
      </div>
    </div>
  </template>
</template>

<style scoped>
  .menu-option {
    display: flex;
    height: 60px;
    align-items: center;
    cursor: pointer;
    color: var(--text-contrast-4);
  }

  .menu-option:hover { background-color: #1c1e1f; }
  .indicator-container { width: 32px; }
  .indicator-container.group { width: 64px; }
  .indicator {
    height: 32px;
    width: 4px;
    background-color: transparent;
  }

  .menu-content-container {
    display: flex;
    gap: 12px;
    align-items: center;
    font-weight: 500;
  }

  .option-icon { width: 24px; }

  .menu-option:not(.selected,.group-selected):hover .menu-content-container { color: var(--text-contrast-7) }
  .menu-option:not(.selected,.group-selected):hover .menu-content-container .option-icon.fill * { fill: var(--text-contrast-7) }
  .menu-option:not(.selected,.group-selected):hover .menu-content-container .option-icon.stroke * { stroke: var(--text-contrast-7) }

  .group-selected .menu-content-container { color: var(--text-contrast-9) }
  .group-selected .menu-content-container .option-icon.fill * { fill: var(--text-contrast-9) }
  .group-selected .menu-content-container .option-icon.stroke * { stroke: var(--text-contrast-9) }

  .selected .menu-content-container { color: var(--text-contrast-9) }
  .selected .menu-content-container .option-icon.fill * { fill: var(--text-contrast-9) }
  .selected .menu-content-container .option-icon.stroke * { stroke: var(--text-contrast-9) }
  .selected .indicator { background-color: var(--text-contrast-9); }

  .option-icon.fill * { fill: var(--text-contrast-4) }
  .option-icon.stroke * { stroke: var(--text-contrast-4) }
</style>