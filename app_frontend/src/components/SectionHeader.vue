<script setup>
  const props = defineProps({
    title: {
      type: String,
      required: true,
    },

    description: {
      type: String,
      default: '',
    },
  });
</script>

<template>
  <div class="section-header-container">
    <div class="header-content">
      <p class="header-title">{{ props.title }}</p>
      <p v-if="props.description" class="header-description">{{ props.description }}</p>
    </div>

    <div class="header-actions">
      <slot name="actions" />
    </div>
  </div>
</template>

<style scoped>
  .section-header-container {
    display: flex;
    gap: 10px;
    width: 100%;
    padding: 8px 40px;
    justify-content: space-between;
  }

  .header-title {
    font-size: 28px;
    font-weight: 700;
    line-height: 34px;
    margin: 0px 0px 8px;
  }

  .header-description {
    font-size: 16px;
    font-weight: 400;
    color: var(--text-5);
    margin: 0px;
  }

  .header-actions {
    display: flex;
    gap: 10px;
    align-items: flex-start;
  }
</style>