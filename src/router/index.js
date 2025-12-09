import { createRouter, createWebHistory } from "vue-router"; //vue router import
import { isAuthenticated } from "../utils/auth"; //auth import

const Student = () => import("../components/User/Student.vue"); //loads components
const Teacher = () => import("../components/User/Teacher.vue");
const Principal = () => import("../components/Admin/Principal.vue");
const newDashboard = () => import("../components/newDashboard.vue");
const RegisterStudent = () => import("../components/Register/Student.vue");
const StEval = () => import("../components/evalforms/student.vue");
const TcEval = () => import("../components/evalforms/teacher.vue");
const printable = () => import("../components/evalforms/eval-form-student.vue");
const printable1 = () =>
  import("../components/evalforms/eval-form-teacher.vue");
const testSidebar = () => import("../components/Testing/testSidebar.vue");
const pageError = () => import("../components/notFound.vue");
const yes = () => import("../components/file.vue");
const scheduler = () => import("../components/Admin/scheduler.vue");
const changeQuestions = () => import("../components/Admin/ChangeQuestions.vue");
const fileUpload = () => import("../components/Admin/fileuploader.vue");
const test = () => import("../components/Testing/test.vue");
const graph = () => import("../components/Admin/perf-graph.vue");
const modal = () => import("../components/Testing/modal.vue");
const changeQuestiont = () => import("../components/Admin/ChangeQuestiont.vue");
const printablemerge = () =>
  import("../components/evalforms/eval-form-student-merge.vue");
const printablemerge1 = () =>
  import("../components/evalforms/eval-form-teacher-merge.vue");
const graphT = () => import("../components/Admin/perf-grapht.vue");

const routes = [
  {
    path: "/", //url
    name: "Dashboard", //component
    component: newDashboard, //component to be loaded
    meta: { title: "Dashboard", requiresAuth: false }, //meta data
  },

  {
    path: "/register/student",
    name: "RegisterStudent",
    component: RegisterStudent,
    meta: { title: "Register Student", requiresAuth: false },
  },

  {
    path: "/student",
    name: "Student",
    component: Student,
    meta: { title: "Student Form", requiresAuth: true },
  },

  {
    path: "/teacher",
    name: "Teacher",
    component: Teacher,
    meta: { title: "Teacher Form", requiresAuth: true },
  },

  {
    path: "/principal",
    name: "Principal",
    component: Principal,
    meta: { title: "Principal Dashboard", requiresAuth: true },
  },

  {
    path: "/student-eval/:id",
    name: "student-eval",
    component: StEval,
    meta: { title: "Student Evaluation", requiresAuth: true },
  },

  {
    path: "/teacher-eval/:id",
    name: "teacher-eval",
    component: TcEval,
    meta: { title: "Teacher Evalutaion", requiresAuth: true },
  },

  {
    path: "/printable-form-student/:id/:tcrid/:evtid",
    name: "printable-form",
    component: printable,
    meta: { title: "Printable Form Students", requiresAuth: true },
  },

  {
    path: "/printable-form-teacher/:id/:tcrid/:evtid",
    name: "printable-form1",
    component: printable1,
    meta: { title: "Printable Form Teachers", requiresAuth: true },
  },

  {
    path: "/testSidebar",
    name: "testSidebar",
    component: testSidebar,
    meta: { title: "Testing", requiresAuth: false },
  },

  {
    path: "/:pathMatch(.*)*",
    name: "NotFound",
    component: pageError,
    meta: { title: "404 Page not found", requiresAuth: false },
  },

  {
    path: "/yessssssssssssssssssssssssssssssssssssss",
    name: "yes",
    component: yes,
    meta: { title: "Hello", requiresAuth: true },
  },

  {
    path: "/scheduler",
    name: "Scheduler",
    component: scheduler,
    meta: { title: "Scheduler", requiresAuth: false },
  },

  {
    path: "/changequestions-student",
    name: "Change-Questions",
    component: changeQuestions,
    meta: { title: "Change Questions", requiresAuth: false },
  },

  {
    path: "/fileupload",
    name: "fileupload",
    component: fileUpload,
    meta: { title: "Upload", requiresAuth: false },
  },

  {
    path: "/test",
    name: "test",
    component: test,
    meta: { title: "Test", requiresAuth: false },
  },

  {
    path: "/performance-graph/:id",
    name: "PerformanceGraph",
    component: graph,
    meta: { title: "Performance Graph", requiresAuth: false },
  },

  {
    path: "/performance-graph/:id",
    name: "PerformanceGraphT",
    component: graphT,
    meta: { title: "Performance Graph", requiresAuth: false },
  },

  {
    path: "/modal",
    name: "ModalItem",
    component: modal,
    meta: { title: "Item", requiresAuth: false },
  },

  {
    path: "/changequestions-teacher",
    name: "Change-Question-t",
    component: changeQuestiont,
    meta: { title: "Change Questions", requiresAuth: false },
  },

  {
    path: "/printable-form-students-merge/:tcrid/:evtid",
    name: "printable-form2",
    component: printablemerge,
    meta: { title: "Printable Form", requiresAuth: false },
  },

  {
    path: "/printable-form-teacher-merge/:tcrid/:evtid",
    name: "printable-form3",
    component: printablemerge1,
    meta: { title: "Printable Form", requiresAuth: false },
  },
];

const router = createRouter({
  //create the routes and history
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  //jwt token auth guard and verification
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!isAuthenticated()) {
      next({ path: "/login", query: { redirect: to.fullPath } });
    } else {
      next();
    }
  } else {
    next();
  }

  if (to.meta?.title) {
    //display the title of the page
    document.title = to.meta.title;
  }
});

export default router; //export the router as a varaible
