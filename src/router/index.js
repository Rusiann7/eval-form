import { createRouter, createWebHistory } from 'vue-router'
import { isAuthenticated } from '../utils/auth'

const Dashboard = () => import('../components/Dashboard.vue')
const Student = () =>import('../components/User/Student.vue')
const Teacher = () => import('../components/User/Teacher.vue')
const Principal = () => import('../components/Admin/Principal.vue')
const newDashboard = () => import('../components/newDashboard.vue')
const StEval = () => import('../components/evalforms/student.vue')

const routes = [
  {
    path: '/',
    name: 'Dashboard',
    component: Dashboard,
    meta: { title: 'Dashboard', requiresAuth: false }
  },

  {
    path: '/student',
    name: 'Student',
    component: Student,
    meta: {title: 'Student Form', requiresAuth: false }
  },

  {
    path: '/teacher',
    name: 'Teacher',
    component: Teacher,
    meta: {title: 'Teacher Form', requiresAuth: false }
  },

  {
    path: '/principal',
    name: 'Principal',
    component: Principal,
    meta: { title: 'Principal Dashboard', requiresAuth: false }
  },
  
  {
    path: '/new-dashboard',
    name: 'newDashboard',
    component: newDashboard,
    meta: { title: 'Dashboard', requiresAuth: false }
  },

  {
    path: '/student-eval/:id',
    name: 'student-eval',
    component: StEval,
    meta: {title: 'Student Evaluation', requiresAuth: false}
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
