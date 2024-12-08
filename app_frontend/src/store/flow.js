import { defineStore }  from 'pinia';

export const useFlowStore = defineStore('flow', {
  state: () => ({
    app_request_pending: false
  }),
  actions: {
    async setAppRequestPending(value) {
      this.app_request_pending = value;
    },
  }
});