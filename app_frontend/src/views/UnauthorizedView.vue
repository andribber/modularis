<script setup>
  import { useRouter } from 'vue-router';

  import Button from 'primevue/button';

  const router = useRouter();

  const backToLobby = () => {
    router.push('/');
  }
</script>

<template>
  <div class="centralized">
    <div class="error-code">403</div>
    <div class="error-title">Sem autorização!</div>
    <div class="error-description">Você não tem autorização para acessar o conteúdo</div>
    <Button @click="backToLobby" class="back-button">Página inicial</Button>
  </div>
</template>

<style scoped>
  .centralized {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    height: 80vh;
  }

  .error-code {
    font-size: 82px;
    font-weight: 700;
  }

  .error-title {
    font-size: 32px;
    font-weight: 600;
  }

  .error-description {
    font-size: 18px;
    font-weight: 400;
    text-align: center;
  }

  .back-button { margin-top: 32px; }
</style>