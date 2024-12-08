<script setup>
  import { onMounted, ref, watchEffect } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import axios from 'axios';

  import Toast from 'primevue/toast';

  import AppLogo from './assets/AppLogo.vue'

  import SideMenu from './components/side-menu/SideMenu.vue';
  import AppHeader from './components/AppHeader.vue';
  import AppLoading from './components/AppLoading.vue';

  import { useFlowStore } from './store';
  import { useToast } from 'primevue/usetoast';

  const auth_layout = ref(false);
  const route = useRoute();
  const router = useRouter();
  const toast = useToast();

  const store = useFlowStore();

  watchEffect(() => auth_layout.value = route.meta.auth || false);

  onMounted(() => {
    axios.interceptors.response.use(
    response => response,
    error => {
      if (error.response) {
        if (error.response.status === 403 && route.fullPath !== '/dashboard') {
          return router.push('/unauthorized');
        }

        if (error.response.status === 422) {
          const message = error.response.data.message || 'Erro de validação'
          toast.add({ severity: 'error', summary: 'Erro!', detail: message, life: 3000 });
        }
      }

      return Promise.reject(error);
    }
  );
  })
</script>

<template>
  <Toast />

  <template v-if="! auth_layout">
    <div class="app-container">
      <div class="loading-app-container" v-if="store.app_request_pending">
        <AppLogo />
        <AppLoading size="36" />
      </div>

      <template v-else>
        <SideMenu />
        <div class="main-content-container">
          <AppHeader />
          <main class="main-containeer">
            <RouterView />
          </main>
        </div>
      </template>
    </div>
  </template>

  <template v-else>
    <RouterView />
  </template>
</template>

<style scoped>
  .app-container {
    position: relative;
    display: flex;
    height: 100vh;
  }

  .main-content-container {
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .loading-app-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: white;
    flex-direction: column;
    gap: 36px;
  }

  .main-containeer { padding: 20px; }
</style>