import QuestionIndexView from '@/views/backend/question/question/IndexView.vue';
import QuestionStoreView from '@/views/backend/question/question/StoreView.vue';

import { isLoggedIn } from '@/middlewares/authenticate';

const questionRoutes = [
  {
    path: '/question/index',
    name: 'question.index',
    component: QuestionIndexView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/question/store',
    name: 'question.store',
    component: QuestionStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/question/update/:id(\\d+)',
    name: 'question.update',
    component: QuestionStoreView,
    beforeEnter: [isLoggedIn]
  }
];

export default questionRoutes;
