<script setup>
  import AppLogo from '../../assets/AppLogo.vue'
</script>

<template>
  <div class="auth-background">
    <div class="card-container">
      <AppLogo />

      <slot />
    </div>
  </div>
</template>

<style scoped>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

  .auth-background {
    height: 100vh;
    width: 100vw;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(217.64deg, #62656C -5.84%, #151718 106.73%);
  }

  .card-container {
    width: 450px;
    background-color: var(--base-1);
    padding: 96px 32px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    flex-direction: column;
  }
</style>