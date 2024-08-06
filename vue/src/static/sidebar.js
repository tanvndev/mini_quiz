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
    subMenu: []
  },
  {
    id: 'user_sidebar',
    icon: 'fas fa-users-medical',
    name: 'Thành viên',
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
    name: 'Chủ đề',
    route: 'topic.index',
    subMenu: []
  },
  {
    id: 'question_sidebar',
    icon: 'fas fa-university',
    name: 'Ngân hàng câu hỏi',
    route: 'question.index',
    subMenu: []
  },
  {
    id: 'quizz_sidebar',
    icon: 'fas fa-question-circle',
    name: 'Bài kiểm tra',
    route: 'quizz.index',
    subMenu: []
  },
  {
    id: 'history_user_sidebar',
    icon: 'fas fa-history',
    name: 'Bài làm của bạn',
    route: 'quizz.history.user',
    subMenu: []
  },
  {
    id: 'history_sidebar',
    icon: 'fas fa-history',
    name: 'Lịch sử làm bài',
    route: 'quizz.history.index',
    subMenu: []
  }
];
export default sidebar;
