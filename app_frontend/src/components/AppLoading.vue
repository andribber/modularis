<script setup>
  import SpinnerIcon from '../icons/SpinnerIcon.vue';

  const props = defineProps({
    size: {
      type: [Number, String],
      default: '24',
    }
  });
</script>

<template>
  <SpinnerIcon class="spin-animation" :size="props.size" />
</template>

<style scoped>
  .spin-animation {
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>