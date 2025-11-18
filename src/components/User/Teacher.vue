<template>
  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <!-- Header -->
  <header class="topbar">
    <div>
      <span class="logo">Teacher Evaluation System</span>
      <p class="breadcrumb">Teacher Portal</p>
    </div>
    <div class="user-info">
      <span>Welcome, {{ fullname }} {{ lastname }}</span>
      <button class="logout-btn" @click="logout()">Logout</button>
    </div>
  </header>

  <!-- Page Title -->
  <div class="page-header">
    <h2>Teacher Portal</h2>
    <p>Evaluate your colleagues</p>
  </div>

  <!--Verify Input-->
  <div v-if="verified === '1'" class="stats-container">
    <h3>Your account is now verified <span class="checkmark">✔</span></h3>
  </div>

  <!--Verify Status-->
  <div class="stats-container" v-if="(verified === '0') & (active === 'code')">
    <div class="stat-card">
      <h3>Verify your account:</h3>
      <br />
      <button @click="verifyCode" class="class-card">Send Code</button>
    </div>
  </div>

  <div class="stats-container" v-if="(verified === '0') & (active === 'input')">
    <div class="stat-card">
      <h3>Verify your account:</h3>
      <br />
      <form method="post" @submit.prevent="verifyInput">
        <input type="text" v-model="verify" />
        <button type="submit">Submit</button>
      </form>
    </div>
  </div>

  <!-- Stats -->
  <div class="stats-container">
    <div class="stat-card">
      👥
      <h3>{{ this.count }}</h3>
      <p>Colleagues</p>
    </div>
    <div class="stat-card">
      ✅
      <h3>2</h3>
      <p>Completed</p>
    </div>
  </div>

  <!-- Teacher Cards -->
  <div class="teacher-container">
    <div
      class="teacher-card"
      v-for="teacher in teachers.filter((t) => t.evaluated === 'evaluated')"
      :key="teacher.id"
    >
      <h3>
        {{ teacher.firstname }} {{ teacher.lastname
        }}<span class="checkmark">✔</span>
      </h3>
      <p>{{ teacher.subject }}</p>
      <span class="badge">Q{{ teacher.quarter }} {{ teacher.year }}</span>
      <br /><br />
      <span class="badge evaluated">Evaluated</span>
    </div>

    <div
      class="teacher-card"
      v-for="teacher in teachers.filter((t) => t.evaluated === 'not evaluated')"
      :key="teacher.id"
    >
      <h3>{{ teacher.firstname }} {{ teacher.lastname }}</h3>
      <p>{{ teacher.subject }}</p>
      <span class="badge">Q{{ teacher.quarter }} {{ teacher.year }}</span>
      <br /><br />
      <button
        class="btn btn-dark"
        @click.prevent="
          $router.push({ name: 'teacher-eval', params: { id: teacher.id } })
        "
      >
        Start Evaluation
      </button>
    </div>
  </div>
</template>

<script>
import { removeToken, getToken } from "../../utils/auth";

const url1 = "https://rusiann7.helioho.st";
const url2 = "https://star-panda-literally.ngrok-free.app";
//const url2 = "http://localhost:8000";

export default {
  name: "Teacher",
  data() {
    return {
      urlappphp: `${url2}/Getter-f.php`,
      vfcode: `${url2}/emailVerifySMTP.php`,
      vfinput: `${url2}/emailVerifyCode.php`,
      vfchecker: `${url2}/verificationChecker.php`,
      teachers: [],
      count: 0,
      fullname:
        JSON.parse(localStorage.getItem("userData") || "{}").fullname ||
        "Teacher Name",
      lastname:
        JSON.parse(localStorage.getItem("userData") || "{}").lastname ||
        "Teacher Name",
      usrid: JSON.parse(localStorage.getItem("userData") || "{}").id || null,
      email: JSON.parse(localStorage.getItem("userData") || "{}").email || null,
      verify: null,
      verified: 0,
      active: "code",
      isLoading: false,
    };
  },

  methods: {
    async getTeachers() {
      this.isLoading = true;

      try {
        const response = await fetch(this.urlappphp, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ action: "getTeachers", id: this.usrid }),
        });

        const result = await response.json();

        if (result.success) {
          this.teachers = result.teachers.map((teacher) => ({
            id: teacher.id,
            firstname: teacher.firstname,
            lastname: teacher.lastname,
            subject: teacher.subject,
            quarter: teacher.quarter,
            year: teacher.year,
            evaluated: teacher.evaluated,
          }));

          this.count = result.total;
          this.isLoading = false;
        } else {
          console.error("Error fetching teachers:", result.message);
        }
      } catch (error) {
        console.error("Error fetching teachers:", error);
        this.isLoading = false;
      }
    },

    async verifyInput() {
      this.isLoading = true;

      const response = await fetch(this.vfinput, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          action: "verifyCode",
          email: this.email,
          code: this.verify,
        }),
      });

      const result = await response.json();

      if (result.success) {
        this.isLoading = false;
        this.verifyCheck();
      } else {
        console.error("Error");
      }
    },

    async verifyCode() {
      this.isLoading = true;

      const response = await fetch(this.vfcode, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          action: "verifySMTP",
          email: this.email,
        }),
      });

      const result = await response.json();

      if (result.success) {
        (this.isLoading = false), (this.active = "input");
      } else {
        console.error("Error");
      }
    },

    async verifyCheck() {
      this.isLoading = true;

      const response = await fetch(this.vfchecker, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          action: "verify",
          email: this.email,
        }),
      });

      const result = await response.json();

      if (result.success) {
        this.isLoading = false;

        this.verified = result.verified;
        console.log(this.verified);
      }
    },

    logout() {
      try {
        removeToken();
        this.localUserData = {};
        this.$router.replace("/");
      } catch (error) {
        console.error("Logout error:", error);
      }
    },

    skipLogin() {
      const token = getToken();

      if (!token) {
        console.error("No token found, redirecting to login.");
        this.$router.replace("/new-Dashboard");
      }
    },
  },

  mounted() {
    this.getTeachers();
    this.skipLogin();
    this.id = localStorage.getItem("userData") || "";
    this.verifyCheck();
  },
};
</script>
<style scoped>
/* Global */
* {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  margin: 0;
  background: #fff;
  color: #1a1a1a;
  line-height: 1.6;
}

header {
  text-align: center;
  margin: 2.5rem 0 1.25rem;
  padding: 0 1rem;
}

header h1 {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 0.5rem;
}

header p {
  font-size: 1rem;
  color: #555;
  max-width: 600px;
  margin: 0 auto;
}

/* Topbar (for portals) */
.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 1.5rem;
  border-bottom: 1px solid #eee;
  flex-wrap: wrap;
  gap: 1rem;
}

.logo {
  font-weight: bold;
  font-size: 1.125rem;
}

.breadcrumb-container {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.breadcrumb {
  background: #f1f3f5;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  font-size: 0.875rem;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 1rem;
  font-size: 0.875rem;
  flex-wrap: wrap;
}

.logout-btn {
  background: #fff;
  border: 1px solid #ccc;
  padding: 0.5rem 1rem;
  border-radius: 6px;
  cursor: pointer;
  text-decoration: none;
  color: #000;
  transition: all 0.2s;
  font-size: 0.875rem;
}

.logout-btn:hover {
  background: #f8f9fa;
}

/* Role Cards */
.role-container {
  display: flex;
  justify-content: center;
  gap: 1.25rem;
  margin: 2.5rem auto;
  flex-wrap: wrap;
  max-width: 1000px;
  padding: 0 1rem;
}

.role-card {
  background: #fff;
  border: 1px solid #eee;
  border-radius: 12px;
  padding: 1.875rem 1.25rem;
  width: min(280px, 100%);
  text-align: center;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.role-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.icon {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  border-radius: 50%;
  padding: 1rem;
  display: inline-block;
}

.student {
  background: #eaf1ff;
  color: #0066ff;
}
.teacher {
  background: #e9f9ee;
  color: #2ecc71;
}
.admin {
  background: #f6eaff;
  color: #9b59b6;
}

.role-card h3 {
  margin: 0.625rem 0 0.5rem;
  font-size: 1.125rem;
}

.role-card p {
  color: #555;
  font-size: 0.875rem;
  margin-bottom: 1.25rem;
}

.btn {
  display: inline-block;
  padding: 0.75rem 1.25rem;
  border-radius: 8px;
  font-size: 0.875rem;
  font-weight: bold;
  text-decoration: none;
  cursor: pointer;
  border: none;
  transition: all 0.2s;
  width: 100%;
}

.btn-student {
  background: #000;
  color: #fff;
}

.btn-student:hover {
  background: #333;
}

.btn-teacher {
  background: #f1f3f5;
  color: #000;
}

.btn-teacher:hover {
  background: #e9ecef;
}

.btn-admin {
  background: #fff;
  border: 1px solid #ccc;
  color: #000;
}

.btn-admin:hover {
  background: #f8f9fa;
}

/* Page Headers */
.page-header {
  padding: 1.875rem 1.5rem 0.625rem;
}

.page-header h2 {
  margin: 0;
  font-size: 1.25rem;
  margin-bottom: 0.5rem;
}

.page-header p {
  color: #555;
  font-size: 0.875rem;
}

/* Stats */
.stats-container {
  display: flex;
  gap: 1.25rem;
  padding: 1.25rem 1.5rem;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
}

.stat-card {
  flex: 1;
  min-width: 150px;
  background: #fff;
  border-radius: 12px;
  padding: 1.25rem;
  text-align: center;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  transition: transform 0.2s ease;
}

.stat-card:hover {
  transform: translateY(-2px);
}

.stat-card h3 {
  margin: 0.625rem 0 0;
  font-size: 1.125rem;
}

.stat-card p {
  color: #555;
  font-size: 0.875rem;
}

/* Tabs */
.tabs {
  display: flex;
  gap: 0.625rem;
  padding: 0 1.5rem;
  margin: 1.25rem 0;
  flex-wrap: wrap;
}

.tab {
  background: #f1f3f5;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all 0.2s;
  border: none;
}

.tab:hover {
  background: #e9ecef;
}

.tab.active {
  background: #000;
  color: #fff;
}

/* Teacher Section */
.teacher-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 1.5rem;
  margin-bottom: 1.25rem;
  flex-wrap: wrap;
  gap: 1rem;
}

.dropdown {
  padding: 0.5rem 1rem;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 0.875rem;
  background: #fff;
  cursor: pointer;
}

/* Teacher Cards */
.teacher-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.25rem;
  padding: 0 1.5rem 2.5rem;
}

.teacher-card {
  border: 1px solid #eee;
  border-radius: 12px;
  padding: 1.25rem;
  background: #fff;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.teacher-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.teacher-card h3 {
  margin: 0;
  font-size: 1rem;
}

.teacher-card p {
  color: #555;
  margin: 0.5rem 0 0.75rem;
  font-size: 0.875rem;
}

.badge {
  display: inline-block;
  background: #f1f3f5;
  padding: 0.25rem 0.75rem;
  font-size: 0.75rem;
  border-radius: 20px;
  margin: 0 0.5rem 0.75rem 0;
}

.badge.rating {
  background: #ffe6e6;
  color: #c0392b;
  font-weight: bold;
}

.card-buttons {
  display: flex;
  gap: 0.75rem;
  margin-top: 1rem;
}

.card-buttons .btn {
  flex: 1;
  padding: 0.75rem;
  font-size: 0.875rem;
}

.btn-dark {
  background: #000;
  color: #fff;
  border: none;
}

.btn-dark:hover {
  background: #333;
}

.btn-light {
  background: #f1f3f5;
  color: #000;
  border: none;
}

.btn-light:hover {
  background: #e9ecef;
}

/* Responsive Design */
@media (max-width: 768px) {
  .topbar {
    flex-direction: column;
    align-items: flex-start;
    padding: 1rem;
  }

  .breadcrumb-container {
    width: 100%;
    justify-content: flex-start;
  }

  .user-info {
    width: 100%;
    justify-content: space-between;
  }

  .page-header {
    padding: 1.5rem 1rem 0.5rem;
  }

  .teacher-header {
    flex-direction: column;
    align-items: flex-start;
  }

  .stats-container {
    padding: 1rem;
  }

  .stat-card {
    min-width: calc(50% - 0.625rem);
  }

  .tabs {
    padding: 0 1rem;
  }

  .teacher-container {
    padding: 0 1rem 2rem;
    grid-template-columns: 1fr;
  }

  .card-buttons {
    flex-direction: column;
  }
}

@media (max-width: 480px) {
  header {
    margin: 2rem 0 1rem;
  }

  header h1 {
    font-size: 1.25rem;
  }

  .role-container {
    margin: 2rem auto;
  }

  .role-card {
    width: 100%;
    max-width: 280px;
  }

  .stats-container {
    gap: 1rem;
  }

  .stat-card {
    min-width: 100%;
  }

  .tabs {
    gap: 0.5rem;
  }

  .tab {
    padding: 0.5rem 0.875rem;
    font-size: 0.8125rem;
  }

  .teacher-header {
    align-items: stretch;
  }

  .dropdown {
    width: 100%;
  }
}

/* Utility Classes */
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}

/* Loading Screen */
.loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  z-index: 3000;
  color: white;
}

.loading-spinner {
  border: 4px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top: 4px solid #ffffff;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
  margin-bottom: 0.75rem;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.class-card {
  background-color: #000;
  color: #fff;
  border-radius: 10px;
  padding: 10px;
  cursor: pointer;
}
</style>
