import {
  useUserStore,
  useTenantStore,
  useModuleStore,
  useTenantUserStore,
} from '../store';

export const clearStores = async () => {
  const stores = [
    useUserStore(),
    useTenantStore(),
    useModuleStore(),
    useTenantUserStore(),
  ];

  stores.forEach(store => store.$reset());
}