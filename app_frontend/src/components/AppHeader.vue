<script setup>
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';

  import TieredMenu from 'primevue/tieredmenu';

  import ChevronIcon from '../icons/ChevronIcon.vue';

  import EmptyUser from '../assets/empty-user.png';

  import { useUserStore } from '../store';

  const store = useUserStore();
  const router = useRouter();

  const profileMenu = ref(null);
  const menuItems = ref([
    { label: 'Sair', command: async () => {
      await store.logout();
      router.push('/login');
    } },
  ]);

  const openProfileMenu = (event) => profileMenu.value.toggle(event);
</script>

<template>
  <header class="header-container">
    <div class="header-content">
      <div class="lateral-content">
        <div class="profile-container" @click="openProfileMenu">
          <span style="font-weight: 500">{{ store.user?.name }}</span>
          <img class="profile-photo" :src="EmptyUser" alt="profile-photo" />
          <ChevronIcon size="12" />
        </div>

        <TieredMenu :model="menuItems" ref="profileMenu" popup />
      </div>
    </div>
  </header>
</template>

<style scoped>
  .header-container {
    height: 68px;
    border-bottom: 1px solid var(--text-2);
    display: flex;
    align-items: center;
  }

  .header-content {
    padding: 0 60px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: flex-end
  }

  .without-box-shadow { box-shadow: none; }
  .lateral-content {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .notification-container {
    width: 40px;
    height: 40px;
    border: 1px solid var(--base-4);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-4);
    position: relative;
    cursor: pointer;
  }

  .notification-popup {
    position: absolute;
    top: 0;
    right: 0;
    width: 10px;
    height: 10px;
    background-color: var(--info-color-4);
    border-radius: 50%;
  }

  .profile-container {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
  }

  .profile-photo {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background-color: rgb(240, 240, 240);
    padding: 8px;
  }
</style>