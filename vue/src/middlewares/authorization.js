import store from '@/store';

const isAdmin = (to, from, next) => {
  const isLoggedIn = store.getters['authStore/isLoggedIn'];
  const role = store.getters['authStore/getRole'];

  if (!isLoggedIn) {
    next({ name: 'login' });
  } else if (role != 'admin') {
    next({ name: 'home' });
  } else {
    next();
  }
};

export { isAdmin };
