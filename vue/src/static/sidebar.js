const sidebar = [
  // {
  //   id: 'dashboard_sidebar',
  //   icon: 'fas fa-home-lg-alt',
  //   name: 'Dashboard',
  //   route: 'dashboard',
  //   subMenu: []
  // },
  {
    id: 'home_sidebar',
    icon: 'fas fa-home-lg-alt',
    name: 'Trang chủ',
    route: 'home',
    role: ['admin', 'student'],
    subMenu: []
  },
  {
    id: 'user_sidebar',
    icon: 'fas fa-users-medical',
    name: 'Thành viên',
    route: '',
    role: ['admin'],
    subMenu: [
      {
        name: 'QL Thành viên',
        route: 'user.index',
        role: ['admin']
      },
      {
        name: 'QL Nhóm thành viên',
        route: 'user.catalogue.index',
        role: ['admin']
      },
      {
        name: 'QL Quyền',
        route: 'permission.index',
        role: ['admin']
      }
    ]
  },
  {
    id: 'topic_sidebar',
    icon: 'fas fa-book',
    name: 'Chủ đề',
    route: 'topic.index',
    role: ['admin'],
    subMenu: []
  },
  {
    id: 'question_sidebar',
    icon: 'fas fa-university',
    name: 'Ngân hàng câu hỏi',
    route: 'question.index',
    role: ['admin'],
    subMenu: []
  },
  {
    id: 'quizz_sidebar',
    icon: 'fas fa-question-circle',
    name: 'Bài kiểm tra',
    route: 'quizz.index',
    role: ['admin'],
    subMenu: []
  },
  {
    id: 'history_user_sidebar',
    icon: 'fas fa-history',
    name: 'Bài làm của bạn',
    route: 'quizz.history.user',
    role: ['admin', 'student'],
    subMenu: []
  },
  {
    id: 'history_sidebar',
    icon: 'fas fa-history',
    name: 'Lịch sử làm bài',
    route: 'quizz.history.index',
    role: ['admin'],
    subMenu: []
  }
];
export default sidebar;
