import QuizzIndexView from '@/views/backend/quizz/quizz/IndexView.vue';
import QuizzStoreView from '@/views/backend/quizz/quizz/StoreView.vue';

import { isLoggedIn } from '@/middlewares/authenticate';

const quizzRoutes = [
  {
    path: '/quizz/index',
    name: 'quizz.index',
    component: QuizzIndexView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/quizz/store',
    name: 'quizz.store',
    component: QuizzStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/quizz/update/:id(\\d+)',
    name: 'quizz.update',
    component: QuizzStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/quizz/:canonical(\\w+)',
    name: 'quizz.do',
    component: () => import('@/views/backend/quizz/quizz/DoView.vue'),
    beforeEnter: [isLoggedIn]
  }
];

export default quizzRoutes;
