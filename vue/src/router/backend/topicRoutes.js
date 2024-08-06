import TopicIndexView from '@/views/backend/topic/topic/IndexView.vue';
import TopicStoreView from '@/views/backend/topic/topic/StoreView.vue';

import { isLoggedIn } from '@/middlewares/authenticate';
import { isAdmin } from '@/middlewares/authorization';

const topicRoutes = [
  {
    path: '/topic/index',
    name: 'topic.index',
    component: TopicIndexView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/topic/store',
    name: 'topic.store',
    component: TopicStoreView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/topic/update/:id(\\d+)',
    name: 'topic.update',
    component: TopicStoreView,
    beforeEnter: [isLoggedIn, isAdmin]
  }
];

export default topicRoutes;
