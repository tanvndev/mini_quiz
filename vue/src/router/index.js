import { createRouter, createWebHistory } from 'vue-router';
import store from '@/store';

import DashboardView from '@/views/backend/DashboardView.vue';
import { FileManager } from '@/components/backend';
import { isLoggedIn } from '@/middlewares/authenticate';

import { authRoutes, userRoutes, topicRoutes } from '@/router/backend';

const routes = [
  {
    path: '/',
    redirect: '/dashboard'
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('@/components/backend/layouts/NotFound.vue')
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: DashboardView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/fileManager',
    name: 'fileManager',
    component: FileManager,
    beforeEnter: [isLoggedIn]
  },
  ...userRoutes,
  ...authRoutes,
  ...topicRoutes
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
});

router.beforeEach((to, from, next) => {
  store.dispatch('loadingStore/startLoading');
  next();
});

router.afterEach(() => {
  store.dispatch('loadingStore/stopLoading');
});

export default router;
