import QuizzIndexView from '@/views/backend/quizz/quizz/IndexView.vue';
import QuizzStoreView from '@/views/backend/quizz/quizz/StoreView.vue';

import { isLoggedIn } from '@/middlewares/authenticate';
import { isAdmin } from '@/middlewares/authorization';

const quizzRoutes = [
  {
    path: '/quizz/index',
    name: 'quizz.index',
    component: QuizzIndexView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/quizz/store',
    name: 'quizz.store',
    component: QuizzStoreView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/quizz/update/:id(\\d+)',
    name: 'quizz.update',
    component: QuizzStoreView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/quizz/:canonical(\\w+)',
    name: 'quizz.do',
    component: () => import('@/views/backend/quizz/quizz/DoView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/quizz/history/:id(\\d+)',
    name: 'quizz.history',
    component: () => import('@/views/backend/quizz/history/HistoryDetailView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/quizz/history/index',
    name: 'quizz.history.index',
    component: () => import('@/views/backend/quizz/history/IndexView.vue'),
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/quizz/history/user',
    name: 'quizz.history.user',
    component: () => import('@/views/backend/quizz/history/HistoryListView.vue'),
    beforeEnter: [isLoggedIn]
  }
];

export default quizzRoutes;
