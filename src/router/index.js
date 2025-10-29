import { createRouter, createWebHistory } from 'vue-router' //vue router import
import { isAuthenticated } from '../utils/auth' //auth import

const Student = () =>import('../components/User/Student.vue') //loads components 
const Teacher = () => import('../components/User/Teacher.vue')
const Principal = () => import('../components/Admin/Principal.vue')
const newDashboard = () => import('../components/newDashboard.vue')
const StEval = () => import('../components/evalforms/student.vue')
const TcEval = () => import('../components/evalforms/teacher.vue')
const printable = () => import('../components/evalforms/eval-form-student.vue')
const printable1 = () => import('../components/evalforms/eval-form-teacher.vue')
const testSidebar = () => import('../components/Testing/testSidebar.vue')
const pageError = () => import('../components/notFound.vue')
const yes = () => import('../components/file.vue')
const scheduler = () => import('../components/Admin/scheduler.vue')

const routes = [
  {
    path: '/', //url
    name: 'Dashboard', //component
    component: newDashboard, //component to be loaded
    meta: { title: 'Dashboard', requiresAuth: false } //meta data
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
    path: '/printable-form-student/:id/:tcrid/:evtid',
    name: 'printable-form',
    component: printable,
    meta: {title: 'Printable Form Students', requiresAuth: false}
  },

  {
    path: '/printable-form-teacher/:id/:tcrid/:evtid',
    name: 'printable-form1',
    component: printable1,
    meta: {title: 'Printable Form Teachers', requiresAuth: false}
  },

  {
    path: '/testSidebar',
    name: 'testSidebar',
    component: testSidebar,
    meta: {title: 'Testing', requiresAuth: false}
  },

  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: pageError,
    meta: {title: '404 Page not found', requiresAuth: false }
  },

  {
    path: '/yessssssssssssssssssssssssssssssssssssss',
    name: 'yes',
    component: yes,
    meta: {title: 'Hello', requiresAuth: false }
  },

  {
    path: '/scheduler',
    name: 'Scheduler',
    component: scheduler,
    meta: {title: 'Scheduler', requiresAuth: false}
  }
]

const router = createRouter({ //create the routes and history
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => { //jwt token auth guard and verification
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated()) {
      next({ path: '/login', query: { redirect: to.fullPath } })
    } else {
      next()
    }
  } else {
    next()
  }

  if (to.meta?.title) { //display the title of the page
    document.title = to.meta.title
  }
})

export default router //export the router as a varaible
