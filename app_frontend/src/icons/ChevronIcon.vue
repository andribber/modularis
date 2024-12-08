<script setup>
  const props = defineProps({
    size: {
      type: [Number, String],
      default: '24',
    }
  });
</script>

<template>
  <svg :width="props.size" :height="props.size" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M6 8.19999L0 2.19999L1.4 0.799988L6 5.39999L10.6 0.799988L12 2.19999L6 8.19999Z" fill="#747475"/>
  </svg>
</template>