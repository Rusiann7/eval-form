import { createRouter, createWebHistory } from 'vue-router'
import { isAuthenticated } from '../utils/auth'

//const Dashboard = () => import('../components/Dashboard.vue')
const Student = () =>import('../components/User/Student.vue')
const Teacher = () => import('../components/User/Teacher.vue')
const Principal = () => import('../components/Admin/Principal.vue')
const newDashboard = () => import('../components/newDashboard.vue')
const StEval = () => import('../components/evalforms/student.vue')
const TcEval = () => import('../components/evalforms/teacher.vue')
const printable = () => import('../components/evalforms/eval-form-student.vue')
const printable1 = () => import('../components/evalforms/eval-form-teacher.vue')

const routes = [
  {
    path: '/',
    name: 'Dashboard',
    component: newDashboard,
    meta: { title: 'Dashboard', requiresAuth: false }
  },

  {
    path: '/student',
    name: 'Student',
    component: Student,
    meta: {title: 'Student Form', requiresAuth: true }
  },

  {
    path: '/teacher',
    name: 'Teacher',
    component: Teacher,
    meta: {title: 'Teacher Form', requiresAuth: true }
  },

  {
    path: '/principal',
    name: 'Principal',
    component: Principal,
    meta: { title: 'Principal Dashboard', requiresAuth: false }
  },

  {
    path: '/student-eval/:id',
    name: 'student-eval',
    component: StEval,
    meta: {title: 'Student Evaluation', requiresAuth: true}
  },

  {
    path: '/teacher-eval/:id',
    name: 'teacher-eval',
    component: TcEval,
    meta: {title: 'Teacher Evalutaion', requiresAuth: true}
  },

  {
    path: '/printable-form/:id',
    name: 'printable-form',
    component: printable,
    meta: {title: 'Printable Form Students', requiresAuth: false}
  },

  {
    path: '/printable-form/:id',
    name: 'printable-form1',
    component: printable1,
    meta: {title: 'Printable Form Teachers', requiresAuth: false}
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated()) {
      next({ path: '/login', query: { redirect: to.fullPath } })
    } else {
      next()
    }
  } else {
    next()
  }

  if (to.meta?.title) {
    document.title = to.meta.title
  }
})

export default router
