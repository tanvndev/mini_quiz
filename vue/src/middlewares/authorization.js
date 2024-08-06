import store from '@/store';

const isAdmin = (to, from, next) => {
  const isLoggedIn = store.getters['authStore/isLoggedIn'];
  const role = store.getters['authStore/getRole'];
  console.log(role);

  if (!isLoggedIn) {
    next({ name: 'login' });
  } else if (role != 'admin') {
    store.dispatch('antStore/showMessage', {
      type: 'error',
      message: 'Bạn không có quyền thực hiện thao tác.'
    });

    next({ name: 'home' });
  } else {
    next();
  }
};

export { isAdmin };
