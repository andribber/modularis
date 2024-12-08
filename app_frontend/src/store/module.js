import { defineStore }  from 'pinia';

import { useToast } from "primevue/usetoast";

import fetchModules  from '../api/module/fetchModules';
import contractModule  from '../api/module/contractModule';
import executeModule from '../api/module/executeModule';
import attachUser from '../api/module/attachUser';
import detachUser from '../api/module/detachUser';

import { handleRequest } from '../helpers/handleRequest';

export const useModuleStore = defineStore('module', {
  state: () => ({
    modules: [],
    module: {},
    employees: [],
    teams: [],
    financial: [],
    toast: useToast(),
  }),
  actions: {
    async fetchModules({ tenant_id }) {
      await handleRequest(async () => {
        const { data } = await fetchModules(tenant_id);

        this.modules = data;
      });
    },
    async contractModule({ tenant_id, module }) {
      await handleRequest(async () => {
        await contractModule(tenant_id, module);
        await this.fetchModules({ tenant_id });
      });
    },
    async executeModule({ tenant_id, module, body }) {
      await handleRequest(async () => {
        const response = await executeModule(tenant_id, module, body);

        if (body.action === 'index') {
          this.module = response;
        }

        if (body.action === 'create') {
          this.module.result.push(response.result);
          this.toast.add({ severity: 'success', summary: 'Criado com sucesso!', detail: 'Seu recurso foi criado com sucesso', life: 3000 });
        }

        if (body.action === 'edit') {
          this.module.result = this.module.result.map((item) => {
            if (item.id === response.result.id) {
              return {
                ...item,
                ...response.result,
              };
            }

            return item;
          });

          this.toast.add({ severity: 'success', summary: 'Editado com sucesso!', detail: 'Seu recurso foi editado com sucesso', life: 3000 });
        }

        if (body.action === 'delete') {
          this.module.result = this.module.result.filter((item) => item.id !== body.instructions.item_id);
          this.toast.add({ severity: 'success', summary: 'Deletado com sucesso!', detail: 'Seu recurso foi deletado com sucesso', life: 3000 });
        }
      });
    },
    async attachUser({ tenant_id, module, body }) {
      await handleRequest(async () => {
        await attachUser(tenant_id, module, body);
      });
    },
    async detachUser({ tenant_id, module, body }) {
      await handleRequest(async () => {
        await detachUser(tenant_id, module, body);
      });
    },
    async fetchEmployees({ tenant_id, module }) {
      await handleRequest(async () => {
        const response = await executeModule(tenant_id, module, {
          service: 'employee',
          action: 'index',
          instructions: {},
        });

        this.employees = response.result;
      }, () => this.employees = []);
    },
    async fetchTeams({ tenant_id, module }) {
      await handleRequest(async () => {
        const response = await executeModule(tenant_id, module, {
          service: 'team',
          action: 'index',
          instructions: {},
        });

        this.teams = response.result;
      }, () => this.teams = []);
    },
    async fetchFinancial({ tenant_id, module }) {
      await handleRequest(async () => {
        const response = await executeModule(tenant_id, module, {
          service: 'finantial',
          action: 'index',
          instructions: {},
        });

        this.financial = response.result;
      }, () => this.financial = []);
    }
  }
});