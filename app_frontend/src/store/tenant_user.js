import { defineStore }  from 'pinia';

import attachUser  from '../api/tenant_user/attachUser';
import fetchUsers  from '../api/tenant_user/fetchUsers';
import detachUser  from '../api/tenant_user/detachUser';
import updateUserRole from '../api/tenant_user/updateUserRole';

import { handleRequest } from '../helpers/handleRequest';

export const useTenantUserStore = defineStore('tenant_user', {
  state: () => ({
    tenant_users: [],
  }),
  actions: {
    async fetchUsers({ tenant_id }) {
      await handleRequest(async () => {
        const { data } = await fetchUsers(tenant_id);

        this.tenant_users = data;
      });
    },
    async attachUser({ tenant_id, body }) {
      await handleRequest(async () => {
        const { data } = await attachUser(tenant_id, body);

        this.tenant_users.unshift(data[0]);
      });
    },
    async detachUser({ tenant_id, user_id }) {
      await handleRequest(async () => {
        await detachUser(tenant_id, user_id);

        this.tenant_users.filter(user => user.id !== user_id);
      });
    },
    async updateUserRole({ tenant_id, user_id, body }) {
      await handleRequest(async () => {
        const { data } = await updateUserRole(tenant_id, user_id, body);

        this.tenant_users.map(user => {
          if (user.id === user_id) {
            return data;
          }

          return user;
        })
      });
    }
  },
});