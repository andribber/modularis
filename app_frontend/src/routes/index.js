import { createWebHistory, createRouter } from 'vue-router'
import { jwtDecode } from "jwt-decode";

import DashboardView from '../views/DashboardView.vue'
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'
import FinancialView from'../views/FinancialView.vue'
import UnauthorizedView from '../views/UnauthorizedView.vue'
import EmployeesView from '../views/EmployeesView.vue';
import TeamsView from '../views/TeamsView.vue';
import PermissionsView from '../views/PermissionsView.vue';

import {
  useUserStore,
  useTenantStore,
  useFlowStore,
  useModuleStore,
} from '../store';

const routes = [
  { path: '/', redirect: '/dashboard' },
  { path: '/dashboard', component: DashboardView, },
  { path: '/login', component: LoginView, meta: { auth: true } },
  { path: '/register', component: RegisterView, meta: { auth: true } },
  { path: '/finantial', component: FinancialView },
  { path: '/employee', component: EmployeesView },
  { path: '/team', component: TeamsView },
  { path: '/permissions', component: PermissionsView },
  { path: '/unauthorized', component: UnauthorizedView },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach(async (to, from, next) => {
  const userStore = useUserStore();
  const tenantStore = useTenantStore();
  const flowStore = useFlowStore();
  const moduleStore = useModuleStore();
  const token = localStorage.getItem('@auth');

  try {
    if (token) {
      const actions = [];

      if (! userStore.user) {
        actions.push(userStore.fetchUser());
      }

      if (! tenantStore.tenant) {
        const { tenant_id } = jwtDecode(token);
        actions.push(tenantStore.fetchTenant({ tenant_id }));
        actions.push(moduleStore.fetchModules({ tenant_id }));
      }

      if (actions.length) {
        flowStore.setAppRequestPending(true);
        await Promise.all(actions);
        flowStore.setAppRequestPending(false);
      }
    }
  } catch (err) {
    localStorage.removeItem('@auth');

    return next('/login');
  }

  if (token && ! userStore.user) {
    localStorage.removeItem('@auth');
  }

  if (! userStore.user && !to.meta.auth) {
    return next('/login');
  }

  if (userStore.user && to.meta.auth) {
    return next('/dashboard');
  }

  next();
});

export default router;