<script setup>
  const props = defineProps({
    size: {
      type: [Number, String],
      default: '24',
    }
  });
</script>

<template>
  <svg :width="props.size" :height="props.size" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
    <g>
    <path d="M10,1V3a7,7,0,1,1-7,7H1a9,9,0,1,0,9-9Z"/>
    </g>
  </svg>
</template>