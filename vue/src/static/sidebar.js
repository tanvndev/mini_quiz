const sidebar = [
  {
    id: 'dashboard_sidebar',
    icon: 'fas fa-home-lg-alt',
    name: 'Dashboard',
    route: 'dashboard',
    subMenu: []
  },
  {
    id: 'user_sidebar',
    icon: 'fas fa-users-medical',
    name: 'QL Thành viên',
    route: '',
    subMenu: [
      {
        name: 'QL Thành viên',
        route: 'user.index'
      },
      {
        name: 'QL Nhóm thành viên',
        route: 'user.catalogue.index'
      },
      {
        name: 'QL Quyền',
        route: 'permission.index'
      }
    ]
  },
  {
    id: 'topic_sidebar',
    icon: 'fas fa-book',
    name: 'QL chủ đề',
    route: '',
    subMenu: [
      {
        name: 'QL chủ đề',
        route: 'topic.index'
      }
    ]
  }
];
export default sidebar;
