import TopicIndexView from '@/views/backend/topic/topic/IndexView.vue';
import TopicStoreView from '@/views/backend/topic/topic/StoreView.vue';

import { isLoggedIn } from '@/middlewares/authenticate';

const topicRoutes = [
  {
    path: '/topic/index',
    name: 'topic.index',
    component: TopicIndexView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/topic/store',
    name: 'topic.store',
    component: TopicStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/topic/update/:id(\\d+)',
    name: 'topic.update',
    component: TopicStoreView,
    beforeEnter: [isLoggedIn]
  }
];

export default topicRoutes;
