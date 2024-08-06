import QuestionIndexView from '@/views/backend/question/question/IndexView.vue';
import QuestionStoreView from '@/views/backend/question/question/StoreView.vue';

import { isLoggedIn } from '@/middlewares/authenticate';
import { isAdmin } from '@/middlewares/authorization';

const questionRoutes = [
  {
    path: '/question/index',
    name: 'question.index',
    component: QuestionIndexView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/question/store',
    name: 'question.store',
    component: QuestionStoreView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/question/update/:id(\\d+)',
    name: 'question.update',
    component: QuestionStoreView,
    beforeEnter: [isLoggedIn, isAdmin]
  }
];

export default questionRoutes;
