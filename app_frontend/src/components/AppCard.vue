<script setup />

<template>
  <div class="app-card-container">
    <slot />
  </div>
</template>

<style scoped>
  .app-card-container {
    border-radius: 12px;
    padding: 18px;
    border: 1px solid var(--text-2);
    flex: 1;
  }
</style>