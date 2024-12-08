import { defineStore }  from 'pinia';

import fetchTenant from '../api/tenant/fetchTenant';
import fetchTenants from '../api/tenant/fetchTenants';
import changeTenant from '../api/tenant/changeTenant';
import createTenant from '../api/tenant/createTenant';
import deleteTenant from '../api/tenant/deleteTenant';
import editTenant  from '../api/tenant/editTenant';

import { handleRequest } from '../helpers/handleRequest';
import { clearStores } from '../helpers/clearStores';

export const useTenantStore = defineStore('tenant', {
  state: () => ({
    tenant: null,
    tenants: [],
  }),
  actions: {
    async fetchTenant({ tenant_id }) {
      await handleRequest(async () => {
        const { data } = await fetchTenant(tenant_id);
        this.tenant = data;
      });
    },
    async fetchTenants() {
      await handleRequest(async () => {
        const { data } = await fetchTenants();

        this.tenants = data;
      });
    },
    async changeTenant({ tenant }) {
      await handleRequest(async () => {
        const { data } = await changeTenant(tenant.id);
        clearStores();

        localStorage.setItem('@auth', data.token);
        this.tenant = tenant;
      });
    },
    async createTenant(body) {
      await handleRequest(async () => {
        const { data } = await createTenant(body);

        this.tenants.unshift(data);
      });
    },
    async deleteTenant({ tenant_id }) {
      await handleRequest(async () => {
        await deleteTenant(tenant_id);

        this.tenants = this.tenants.filter(tenant => tenant.id !== tenant_id);
      });
    },
    async editTenant({ tenant_id, body }) {
      await handleRequest(async () => {
        const { data } = await editTenant(tenant_id, body);

        this.tenant = data;
        this.tenants = this.tenants.map(tenant => {
          if (tenant.id === tenant_id) {
            return data;
          }

          return tenant;
        });
      });
    }
  }
});