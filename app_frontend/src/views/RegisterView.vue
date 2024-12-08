<script setup>
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';

  import AuthBase from '../components/auth/AuthBase.vue'

  import InputText from 'primevue/inputtext';
  import IconField from 'primevue/iconfield';
  import InputIcon from 'primevue/inputicon';
  import Password from 'primevue/password';
  import Button from 'primevue/button';

  import { useUserStore } from '../store';

  const store = useUserStore();
  const router = useRouter();

  const request_pending = ref(false);
  const name = ref('');
  const email = ref('');
  const password = ref('');
  const password_confirmation = ref('');

  const handleRegister = async () => {
    request_pending.value = true;
    await store.register({
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value
    });
    request_pending.value = false;
    router.push('/dashboard');
  }
</script>

<template>
  <AuthBase>
    <p>
      REGISTRAR
    </p>

    <div class="input-containers">
      <IconField class="container-full-width">
        <InputIcon class="pi pi-user" />
        <InputText v-model="name" placeholder="Usuário" />
      </IconField>

      <IconField class="container-full-width">
        <InputIcon class="pi pi-at" />
        <InputText v-model="email" placeholder="E-mail" />
      </IconField>

      <IconField>
        <InputIcon class="pi pi-lock z-index-1" />
        <Password  v-model="password" placeholder="Senha" class="container-full-width w-100 custom-password-input" :feedback="false" toggleMask />
      </IconField>

      <IconField>
        <InputIcon class="pi pi-verified z-index-1" />
        <Password v-model="password_confirmation" placeholder="Confirmar a senha" class="container-full-width w-100 custom-password-input" :feedback="false" toggleMask />
      </IconField>

      <Button @click="handleRegister" :disabled="request_pending">Criar</Button>

      <div class="extra-info-container">
        <span>Já possui uma conta? <router-link router-link to="/login">Entrar</router-link></span>
      </div>
    </div>
  </AuthBase>
</template>

<style scoped>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

  .card-container p {
    font-size: 30px;
    font-weight: 700;
    font-family: "Poppins", system-ui, Avenir, Helvetica, Arial, sans-serif;
  }

  .input-containers {
    display: flex;
    flex-direction: column;
    gap: 32px;
    width: 100%;
  }

  .extra-info-container {
    display: flex;
    justify-content: center;
  }

  .without-box-shadow { box-shadow: none; }
  .w-100 { width: 100%; }
  .z-index-1 { z-index: 1; }

  ::v-deep.custom-password-input input { padding-inline-start: calc((var(--p-form-field-padding-x) * 2) + var(--p-icon-size)); }
  ::v-deep.container-full-width input { width: 100%; }
</style>