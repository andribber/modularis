import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useModuleStore, useTenantStore } from '../store';

export function useModuleLoader() {
  const route = useRoute();
  const moduleStore = useModuleStore();
  const tenantStore = useTenantStore();
  const fetch_request_pending = ref(true);
  const create_request_pending = ref(false);
  const edit_request_pending = ref(false);
  const delete_request_pending= ref(false);

  const getService = computed(() => route.path.replace('/', ''));
  const getModuleName = computed(() => ['employee', 'team'].includes(getService.value) ? 'employees' : 'finantial');
  const getModule = computed(() => moduleStore.modules.find((module) => module.name === getModuleName.value));

  const fetchModule = async () => {
    if (getModule.value?.id) {
      fetch_request_pending.value = true;
      await moduleStore.executeModule({
        tenant_id: tenantStore.tenant.id,
        module: getModule.value.id,
        body: {
          service: getService.value,
          action: 'index',
          instructions: {},
        },
      });

      fetch_request_pending.value = false;
    }
  };

  const createModuleItem = async (body) => {
    create_request_pending.value = true;
    await moduleStore.executeModule({
      tenant_id: tenantStore.tenant.id,
      module: getModule.value.id,
      body: {
        service: getService.value,
        action: 'create',
        instructions: body,
      },
    });

    create_request_pending.value = false;
  };

  const editModuleItem = async (body) => {
    delete_request_pending.value = true;
    await moduleStore.executeModule({
      tenant_id: tenantStore.tenant.id,
      module: getModule.value.id,
      body: {
        service: getService.value,
        action: 'edit',
        instructions: body,
      },
    });

    delete_request_pending.value = false;
  };

  const deleteModuleItem = async (body) => {
    edit_request_pending.value = true;
    await moduleStore.executeModule({
      tenant_id: tenantStore.tenant.id,
      module: getModule.value.id,
      body: {
        service: getService.value,
        action: 'delete',
        instructions: body,
      },
    });

    edit_request_pending.value = false;
  }

  onMounted(fetchModule);

  return {
    fetch_request_pending,
    create_request_pending,
    edit_request_pending,
    delete_request_pending,
    getModuleName,
    getModule,
    fetchModule,
    createModuleItem,
    editModuleItem,
    deleteModuleItem,
  };
}
