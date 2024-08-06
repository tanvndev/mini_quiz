import UserIndexView from '@/views/backend/user/user/IndexView.vue';
import UserStoreView from '@/views/backend/user/user/StoreView.vue';
import UserCatalogueIndexView from '@/views/backend/user/catalogue/IndexView.vue';
import UserCatalogueStoreView from '@/views/backend/user/catalogue/StoreView.vue';
import UserCataloguePermissionView from '@/views/backend/user/catalogue/PermissionVue.vue';
import PermissionCatalogueIndexView from '@/views/backend/user/permission/IndexView.vue';
import PermissionCatalogueStoreView from '@/views/backend/user/permission/StoreView.vue';

import { isLoggedIn } from '@/middlewares/authenticate';
import { isAdmin } from '@/middlewares/authorization';

const userRoutes = [
  {
    path: '/user/index',
    name: 'user.index',
    component: UserIndexView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/user/store',
    name: 'user.store',
    component: UserStoreView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/user/update/:id(\\d+)',
    name: 'user.update',
    component: UserStoreView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/user/catalogue/index',
    name: 'user.catalogue.index',
    component: UserCatalogueIndexView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/user/catalogue/store',
    name: 'user.catalogue.store',
    component: UserCatalogueStoreView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/user/catalogue/update/:id(\\d+)',
    name: 'user.catalogue.update',
    component: UserCatalogueStoreView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/user/catalogue/permission',
    name: 'user.catalogue.permission',
    component: UserCataloguePermissionView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/permission/index',
    name: 'permission.index',
    component: PermissionCatalogueIndexView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/permission/store',
    name: 'permission.store',
    component: PermissionCatalogueStoreView,
    beforeEnter: [isLoggedIn, isAdmin]
  },
  {
    path: '/permission/update/:id(\\d+)',
    name: 'permission.update',
    component: PermissionCatalogueStoreView,
    beforeEnter: [isLoggedIn, isAdmin]
  }
];

export default userRoutes;
