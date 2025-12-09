<template>
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap"
    rel="stylesheet"
  />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined"
    rel="stylesheet"
  />

  <!-- Sidebar -->
  <input
    type="checkbox"
    id="scheduler-nav-toggle"
    class="menu-checkbox"
    aria-hidden="true"
  />
  <label for="scheduler-nav-toggle" class="menu-overlay" aria-hidden="true"></label>
    
  <div class="side-bar">
    <div class="sidebar-header">
      <h3 class="sidebar-title">Principal Portal</h3>
      <label for="scheduler-nav-toggle" class="sidebar-close" aria-label="Close menu">
        <span></span>
        <span></span>
      </label>
    </div>
    <div class="menu">
      <div class="item">
<<<<<<< HEAD
        <a href="#" class="sub-btn" @click.stop="navigateAndClose('/principal'); showMenu1 = !showMenu1">
          <span>Student</span>
          <svg class="chevron-icon" :class="{ 'rotated': showMenu1 }" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </a>
        <div class="sub-menu" v-if="showMenu1">
          <a href="#" class="sub-item" @click="navigateAndClose('/principal')">Merged Answers</a>
          <a href="#" @click="navigateAndClose('/principal')" class="sub-item">Individual Answers</a>
        </div>
=======
        <a href="#" class="sub-btn" @click.stop="$router.push('/principal')"
          >Student</a
        >
>>>>>>> Development
      </div>
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu2 = !showMenu2">
          <span>Teacher</span>
          <svg class="chevron-icon" :class="{ 'rotated': showMenu2 }" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </a>
        <div class="sub-menu" v-if="showMenu2">
<<<<<<< HEAD
          <a href="#" class="sub-item" @click="navigateAndClose('/principal')">Merged Answers</a>
          <a href="#" @click="navigateAndClose('/principal')" class="sub-item">Individual Answers</a>
          <a href="#" @click="navigateAndClose('/principal')" class="sub-item">Evaluate Teachers</a>
        </div>
      </div>
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu3 = !showMenu3">
          <span>Account Management</span>
          <svg class="chevron-icon" :class="{ 'rotated': showMenu3 }" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </a>
        <div class="sub-menu" v-if="showMenu3">
          <a href="#" @click="navigateAndClose('/principal')" class="sub-item">Add Teachers</a>
          <a href="#" @click="navigateAndClose('/principal')" class="sub-item">Delete Users</a>
          <a href="#" @click="navigateAndClose('/principal')" class="sub-item">Edit Users</a>
=======
          <a href="#" @click="click('teacher')" class="sub-item"
            >Evaluation Answers</a
          >
          <a href="#" @click="click('evaluate')" class="sub-item"
            >Evaluate Teachers</a
          >
        </div>
      </div>
      <div class="item">
        <a href="#" @click.stop="$router.push('/principal')"
          >Account Management</a
        >
        <div class="sub-menu" v-if="showMenu3">
          <a href="#" @click="click2('crtTeacher')" class="sub-item"
            >Add Teachers</a
          >
          <a href="#" @click="click2('rmTeacher')" class="sub-item"
            >Delete Users</a
          >
          <a href="#" @click="click2('rmTeacher')" class="sub-item"
            >Edit Users</a
          >
>>>>>>> Development
        </div>
      </div>
      <div class="item">
        <a href="#" @click.prevent="navigateAndClose('/scheduler')">Scheduler</a>
      </div>
      <div class="item">
        <a href="#" @click.prevent="navigateAndClose('/fileupload')">File Upload</a>
      </div>
      <div class="item">
<<<<<<< HEAD
        <a href="#" @click.prevent="navigateAndClose('/changequestions')">Question Change</a>
=======
        <a href="#" @click.prevent="showMenu4 = !showMenu4">Question Change</a>

        <div class="sub-menu" v-if="showMenu4">
          <a
            href="#"
            @click.prevent="$router.push('/changequestions-student')"
            class="sub-item"
            >Chnage Student Questions</a
          >
          <a
            href="#"
            @click.prevent="$router.push('/changequestions-teacher')"
            class="sub-item"
            >Change Teacher Questions</a
          >
        </div>
>>>>>>> Development
      </div>
    </div>
    <div class="sidebar-footer">
      <button class="logout-btn sidebar-logout" @click="logout()">
        <svg class="logout-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
          <polyline points="16 17 21 12 16 7"></polyline>
          <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
        Logout
      </button>
    </div>
  </div>

  <!-- Main content container -->
  <div class="main-content">
    <!-- Header -->
    <header class="topbar">
      <div class="header-left">
        <div class="title-row">
          <h1 class="logo">Teacher Evaluation System</h1>
          <div class="title-actions">
            <button class="portal-btn">Principal Portal</button>
            <label
              for="scheduler-nav-toggle"
              class="menu-toggle"
              aria-label="Toggle menu"
            >
              <span></span>
              <span></span>
              <span></span>
            </label>
          </div>
        </div>
      </div>
      <div class="user-section">
        <span class="user-greeting">Welcome, {{ fullname }} {{ lastname }}</span>
        <button class="logout-btn desktop-only" @click="logout()">
          <svg class="logout-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg>
          Logout
        </button>
      </div>
    </header>

<<<<<<< HEAD
    <div class="content">
      <div class="container">
        <main class="content-main">
          <!-- Current Times Card -->
          <div class="card current-times-card">
            <h2 class="card-title">Current Schedule</h2>
            <div class="times-display">
              <div class="time-section">
                <h3>Start Time</h3>
                <div class="time-item">
                  <span class="time-label">Time:</span>
                  <span class="time-value">{{ startendtime.time_start || 'Not Set' }}</span>
                </div>
                <div class="time-item">
                  <span class="time-label">Date:</span>
                  <span class="time-value">{{ startendtime.date_start || 'Not Set' }}</span>
=======
  <div class="content">
    <div class="container">
      <main class="main-content">
        <div class="card" style="margin-bottom: 40px">
          <div class="titles">
            <h1>Current Times</h1>
            <br />
            <h3>Time Start: {{ startendtime.time_start }}</h3>
            <h3>Date Start: {{ startendtime.date_start }}</h3>
            <h3>Time End: {{ startendtime.time_end }}</h3>
            <h3>Date End: {{ startendtime.date_end }}</h3>
          </div>
        </div>
        <div class="card">
          <header class="header">
            <h1 class="title">Set Due Date</h1>
            <p class="subtitle">
              Define the submission deadline for this assignment.
            </p>
          </header>
          <form @submit.prevent="this.setTime()" class="form" method="POST">
            <div class="form-grid">
              <div class="form-group">
                <label class="label" for="due-date">Due date</label>
                <div class="input-container">
                  <span class="material-icons-outlined input-icon">
                    calendar_today
                  </span>
                  <input
                    class="input-field"
                    name="due-date"
                    type="date"
                    v-model="times.dateset"
                    required
                  />
>>>>>>> Development
                </div>
              </div>
              <div class="time-section">
                <h3>End Time</h3>
                <div class="time-item">
                  <span class="time-label">Time:</span>
                  <span class="time-value">{{ startendtime.time_end || 'Not Set' }}</span>
                </div>
                <div class="time-item">
                  <span class="time-label">Date:</span>
                  <span class="time-value">{{ startendtime.date_end || 'Not Set' }}</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Form Card -->
          <div class="card form-card">
            <header class="header">
              <h1 class="title">Set Evaluation Schedule</h1>
              <p class="subtitle">
                Define the start and end dates for student and teacher evaluations
              </p>
            </header>
            <form @submit.prevent="setTime()" class="form" method="POST">
              <div class="form-section">
                <h3 class="section-title">Start Time</h3>
                <p class="section-description">When evaluations should become available</p>
                <div class="form-grid">
                  <div class="form-group">
                    <label class="label" for="due-date">Start Date <span class="required">*</span></label>
                    <div class="input-container">
                      <span class="material-icons-outlined input-icon">
                        calendar_today
                      </span>
                      <input
                        class="input-field"
                        id="due-date"
                        name="due-date"
                        type="date"
                        v-model="times.dateset"
                        required
                      />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="label" for="due-time">Start Time <span class="required">*</span></label>
                    <div class="input-container">
                      <span class="material-icons-outlined input-icon">
                        schedule
                      </span>
                      <input
                        class="input-field"
                        id="due-time"
                        name="due-time"
                        type="time"
                        v-model="times.timeset"
                        required
                      />
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-section">
                <h3 class="section-title">End Time</h3>
                <p class="section-description">When evaluations will close (Optional)</p>
                <div class="form-grid">
                  <div class="form-group">
                    <label class="label" for="end-date">End Date</label>
                    <div class="input-container">
                      <span class="material-icons-outlined input-icon">
                        event_busy
                      </span>
                      <input
                        class="input-field"
                        id="end-date"
                        name="end-date"
                        type="date"
                        v-model="times.dateend"
                      />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="label" for="end-time">End Time</label>
                    <div class="input-container">
                      <span class="material-icons-outlined input-icon">
                        access_time
                      </span>
                      <input
                        class="input-field"
                        id="end-time"
                        name="end-time"
                        type="time"
                        v-model="times.timeend"
                      />
                    </div>
                  </div>
                </div>
              </div>

              <div class="checkbox-container">
                <div class="checkbox-wrapper">
                  <input
                    class="checkbox"
                    id="countdown-timer"
                    name="countdown-timer"
                    type="checkbox"
                    v-model="times.countdownTimer"
                  />
                </div>
                <div class="checkbox-label-container">
                  <label class="checkbox-label" for="countdown-timer">
                    Show Countdown Timer
                  </label>
                  <p class="checkbox-description">
                    Display a countdown timer for students and teachers
                  </p>
                </div>
              </div>

              <div class="button-container">
                <button class="button" type="submit" :disabled="isLoading">
                  <span class="material-icons-outlined">save</span>
                  {{ isLoading ? 'Saving...' : 'Save Schedule' }}
                </button>
              </div>
            </form>
          </div>
        </main>
      </div>
    </div>
  </div>
</template>

<script>
const url1 = "https://rusiann7.helioho.st";
const url2 = "https://star-panda-literally.ngrok-free.app";

export default {
  name: "Schedule",
  data() {
    return {
      timegetterphp: `${url2}/timeGetter.php`,
      timesettierphp: `${url2}/startEvalSMTP.php`,
      times: {
        timeset: "",
        dateset: "",
        timeend: "",
        dateend: "",
        countdownTimer: false,
      },
      startendtime: {},
      isLoading: false,
      showMenu1: false,
      showMenu2: false,
      showMenu3: false,
<<<<<<< HEAD
      fullname: "",
      lastname: "",
=======
      showMenu4: false,
>>>>>>> Development
    };
  },

  methods: {
    async setTime() {
      try {
        this.isLoading = true;

        const response = await fetch(this.timesettierphp, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "setTime",
            time_start: this.times.timeset,
            date_start: this.times.dateset,
            time_end: this.times.timeend,
            date_end: this.times.dateend,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.isLoading = false;
          this.getTime();
          alert("Schedule saved successfully!");
        } else {
          this.isLoading = false;
          alert("Error saving schedule. Please try again.");
        }
      } catch (error) {
        this.isLoading = false;
        console.error(error);
        alert("Error saving schedule. Please try again.");
      }
    },

    async getTime() {
      try {
        this.isLoading = true;

        const response = await fetch(this.timegetterphp, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "getTime",
          }),
        });

        const result = await response.json();

        if (result.success) {
          const t = result.times || {};
          this.startendtime = {
            time_start: t.time_start,
            date_start: t.date_start,
            time_end: t.time_end,
            date_end: t.date_end,
          };
<<<<<<< HEAD
          
          // Pre-fill form with existing values
          this.times.timeset = t.time_start || "";
          this.times.dateset = t.date_start || "";
          this.times.timeend = t.time_end || "";
          this.times.dateend = t.date_end || "";
          
=======
>>>>>>> Development
          this.isLoading = false;
        } else {
          this.isLoading = false;
        }
      } catch (error) {
        this.isLoading = false;
        console.error(error);
      }
    },

    navigateAndClose(route) {
      this.$router.push(route);
      if (window.innerWidth <= 768) {
        document.getElementById('scheduler-nav-toggle').checked = false;
      }
    },
    
    logout() {
      localStorage.removeItem("userData");
      this.$router.push("/");
    },
  },

  mounted() {
<<<<<<< HEAD
    // Initialize user data
    const userData = localStorage.getItem("userData");
    if (userData) {
      try {
        const user = JSON.parse(userData);
        this.fullname = user.fullname || "";
        this.lastname = user.lastname || "";
      } catch (e) {
        console.error("Error parsing user data:", e);
      }
    }
=======
>>>>>>> Development
    this.getTime();
  },
};
</script>

<style scoped>
<<<<<<< HEAD
/* ===== CSS RESET & BASE STYLES ===== */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

body {
  font-size: 16px;
  line-height: 1.6;
}

/* ===== IMPROVED TYPOGRAPHY - LARGER TEXT ===== */
h1 { font-size: 1.875rem; }
h2 { font-size: 1.625rem; }
h3 { font-size: 1.375rem; }
p, span, label, button, input, select { 
  font-size: 1.0625rem; 
}

@media (min-width: 768px) {
  h1 { font-size: 2.25rem; }
  h2 { font-size: 2rem; }
  h3 { font-size: 1.75rem; }
  p, span, label, button, input, select { 
    font-size: 1.125rem; 
  }
}

@media (min-width: 1024px) {
  h1 { font-size: 2.5rem; }
  h2 { font-size: 2.25rem; }
  h3 { font-size: 2rem; }
}

/* ===== TOPBAR STYLES ===== */
.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.25rem 1.5rem;
  border-bottom: 1px solid #e5e7eb;
  flex-wrap: wrap;
  gap: 1rem;
  position: sticky;
  top: 0;
  background: white;
  z-index: 30;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.header-left {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  flex-wrap: wrap;
}

.title-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  gap: 1rem;
}

.logo {
  font-weight: bold;
  margin: 0;
  color: #111827;
  font-size: 1.25rem;
}

.title-actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.portal-btn {
  background: #f3f4f6;
  padding: 0.75rem 1.25rem;
  border-radius: 12px;
  cursor: pointer;
  border: none;
  transition: background 0.2s;
  white-space: nowrap;
  font-weight: 500;
}

.portal-btn:hover {
  background: #e5e7eb;
}

.user-section {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  flex-wrap: wrap;
}

.user-greeting {
  color: #374151;
  white-space: nowrap;
  font-weight: 500;
}

.desktop-only {
  display: inline-flex;
}

.menu-toggle {
  display: none;
  width: 44px;
  height: 44px;
  border-radius: 10px;
  border: 1px solid #d1d5db;
  background: rgba(255, 255, 255, 0.95);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  cursor: pointer;
  transition: all 0.2s ease;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 5px;
  position: relative;
  z-index: 45;
  flex-shrink: 0;
}

.menu-toggle span {
  width: 20px;
  height: 2.5px;
  background: #111827;
  border-radius: 999px;
  transition: transform 0.25s ease, opacity 0.25s ease;
}

.menu-toggle:focus-visible {
  outline: 2px solid #111827;
  outline-offset: 3px;
}

.logout-btn {
  background: #f3f4f6;
  border: 1px solid #e5e7eb;
  padding: 0.75rem 1.25rem;
  border-radius: 12px;
  cursor: pointer;
  text-decoration: none;
  color: #374151;
  transition: all 0.2s ease;
  white-space: nowrap;
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  font-weight: 500;
}

.logout-btn:hover {
  background: #e5e7eb;
  border-color: #d1d5db;
}

.logout-icon {
  flex-shrink: 0;
  color: #dc2626;
  stroke: #dc2626;
}

/* ===== MAIN CONTENT ===== */
.main-content {
  flex: 1;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  overflow-x: hidden;
  margin-left: 320px;
  width: calc(100% - 320px);
  transition: margin-left 0.3s ease, width 0.3s ease;
  background: #f9fafb;
}

/* ===== CONTENT AREA ===== */
.content {
  flex: 1;
  padding: 2rem 1.75rem;
  overflow-y: auto;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  width: 100%;
}

.content-main {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

/* ===== CARD STYLES ===== */
.card {
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  border: 1px solid #e5e7eb;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
  transform: translateY(-2px);
}

.current-times-card {
  padding: 2.5rem;
}

.card-title {
  font-size: 1.75rem;
  font-weight: 700;
  color: #111827;
  margin: 0 0 2rem 0;
  padding-bottom: 1.25rem;
  border-bottom: 2px solid #e5e7eb;
}

.times-display {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
}

.time-section {
  padding: 1.5rem;
  background: #f9fafb;
  border-radius: 12px;
  border: 1px solid #e5e7eb;
}

.time-section h3 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #111827;
  margin: 0 0 1.25rem 0;
  padding-bottom: 0.75rem;
  border-bottom: 1px solid #e5e7eb;
}

.time-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.75rem 0;
  border-bottom: 1px solid #eef2f7;
}

.time-item:last-child {
  border-bottom: none;
}

.time-label {
  font-size: 1.0625rem;
  font-weight: 500;
  color: #6b7280;
}

.time-value {
  font-size: 1.25rem;
  font-weight: 600;
  color: #111827;
  background: #ffffff;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
  min-width: 180px;
  text-align: center;
}

.form-card {
  padding: 2.5rem;
}

.form-card .header {
  margin-bottom: 2.5rem;
  padding-bottom: 1.5rem;
  border-bottom: 2px solid #e5e7eb;
}

.form-card .title {
  font-size: 1.75rem;
  font-weight: 700;
  color: #111827;
  margin: 0 0 0.75rem 0;
}

.form-card .subtitle {
  font-size: 1.125rem;
  color: #6b7280;
  margin: 0;
  line-height: 1.5;
}

/* ===== FORM STYLES ===== */
.form {
  display: flex;
  flex-direction: column;
  gap: 2.5rem;
}

.form-section {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  padding: 1.5rem;
  background: #f9fafb;
  border-radius: 12px;
  border: 1px solid #e5e7eb;
}

.section-title {
  font-size: 1.375rem;
  font-weight: 600;
  color: #111827;
  margin: 0;
=======
/* ===== BASE STYLES ===== */
* {
  font-family: "Inter", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

html {
  font-size: 16px;
}

@media (min-width: 768px) {
  html {
    font-size: 18px;
  }
}

@media (min-width: 1200px) {
  html {
    font-size: 20px;
  }
}

body {
  background-color: #ffffff;
  color: #1f2937;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  line-height: 1.6;
}

.material-icons-outlined {
  font-size: 1.5rem;
  vertical-align: middle;
}

/* ===== INPUT STYLES ===== */
input[type="date"]::-webkit-calendar-picker-indicator,
input[type="time"]::-webkit-calendar-picker-indicator {
  cursor: pointer;
  opacity: 0.6;
  transition: opacity 0.2s ease;
}

input[type="date"]::-webkit-calendar-picker-indicator:hover,
input[type="time"]::-webkit-calendar-picker-indicator:hover {
  opacity: 1;
}

/* ===== CONTENT LAYOUT ===== */
.content {
  background-color: #f9fafb;
  min-height: 100vh;
  max-width: 100%;
  padding: 1rem;
}

@media (min-width: 768px) {
  .content {
    padding: 2rem;
  }
}

.container {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 1rem;
  max-width: 100%;
}

@media (min-width: 768px) {
  .container {
    padding: 2rem;
  }
}

.main-content {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
}

/* ===== CURRENT TIMES CARD ===== */
.card {
  background-color: #ffffff;
  border-radius: 1rem;
  box-shadow: 0 8px 16px -1px rgba(0, 0, 0, 0.1),
    0 4px 8px -1px rgba(0, 0, 0, 0.06);
  padding: 2rem;
  margin-bottom: 2.5rem;
  border: 2px solid #e5e7eb;
  transition: all 0.3s ease;
}

.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 16px 32px -2px rgba(0, 0, 0, 0.15),
    0 8px 16px -2px rgba(0, 0, 0, 0.1);
}

.titles {
  padding: 1rem 0;
}

.titles h1 {
  font-size: 2rem;
  font-weight: 700;
  color: #000000;
  margin-bottom: 1rem;
}

@media (min-width: 768px) {
  .titles h1 {
    font-size: 2.5rem;
  }
}

.titles h3 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #374151;
  margin: 0.5rem 0;
  line-height: 1.6;
}

.titles h3:first-of-type {
  margin-top: 1rem;
}

/* ===== FORM CARD ===== */
.header {
  margin-bottom: 2.5rem;
  text-align: center;
}

.title {
  font-size: 2rem;
  font-weight: 700;
  color: #000000;
  margin: 0 0 0.5rem 0;
}

@media (min-width: 768px) {
  .title {
    font-size: 2.5rem;
  }
>>>>>>> Development
}

.section-description {
  font-size: 1.0625rem;
  color: #6b7280;
<<<<<<< HEAD
  margin: 0;
  line-height: 1.5;
=======
  font-size: 1.1rem;
  margin-top: 0.5rem;
  margin-bottom: 0;
  line-height: 1.6;
}

/* ===== FORM STYLES ===== */
.form {
  display: flex;
  flex-direction: column;
  gap: 2rem;
>>>>>>> Development
}

.form-grid {
  display: grid;
<<<<<<< HEAD
  grid-template-columns: repeat(2, 1fr);
  gap: 1.75rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
=======
  grid-template-columns: 1fr;
  gap: 2rem;
}

@media (min-width: 768px) {
  .form-grid {
    grid-template-columns: 1fr 1fr;
    gap: 2.5rem;
  }
}

.form-group {
  margin-bottom: 0.5rem;
>>>>>>> Development
}

.label {
  display: block;
<<<<<<< HEAD
  font-size: 1.0625rem;
=======
  font-size: 1.1rem;
>>>>>>> Development
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.75rem;
}

<<<<<<< HEAD
.required {
  color: #dc2626;
  margin-left: 2px;
=======
.description {
  font-size: 1rem;
  color: #6b7280;
  margin-bottom: 1rem;
  line-height: 1.5;
>>>>>>> Development
}

.input-container {
  position: relative;
  width: 100%;
}

.input-icon {
  position: absolute;
<<<<<<< HEAD
  left: 1rem;
=======
  left: 1.25rem;
>>>>>>> Development
  top: 50%;
  transform: translateY(-50%);
  color: #6b7280;
  pointer-events: none;
<<<<<<< HEAD
  z-index: 1;
  font-size: 1.25rem;
}

.input-field {
  padding-left: 3rem;
  padding-right: 1rem;
  width: 100%;
  border-radius: 12px;
  border: 1.5px solid #d1d5db;
  background-color: #ffffff;
  color: #111827;
  height: 3.5rem;
  font-size: 1.125rem;
  transition: all 0.3s ease;
=======
  font-size: 1.5rem;
}

.input-field {
  padding-left: 3.5rem;
  width: 100%;
  border-radius: 0.75rem;
  border: 2px solid #d1d5db;
  background-color: #ffffff;
  color: #111827;
  height: 3.5rem;
  font-size: 1.1rem;
  transition: all 0.2s ease;
  font-family: inherit;
>>>>>>> Development
}

.input-field:focus {
  outline: none;
<<<<<<< HEAD
  border-color: #000;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
  background-color: #ffffff;
=======
  border-color: #000000;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
>>>>>>> Development
}

.input-field:hover {
  border-color: #9ca3af;
<<<<<<< HEAD
  background-color: #f9fafb;
}

/* ===== CHECKBOX STYLES ===== */
.checkbox-container {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  padding: 1.5rem;
  background: #f9fafb;
  border-radius: 12px;
  border: 1px solid #e5e7eb;
}

.checkbox-wrapper {
  display: flex;
  align-items: center;
  margin-top: 0.25rem;
}

.checkbox {
  width: 1.5rem;
  height: 1.5rem;
  border-radius: 6px;
  border: 2px solid #d1d5db;
  cursor: pointer;
  accent-color: #000;
  transition: all 0.2s ease;
}

.checkbox:focus {
  outline: 2px solid #000;
  outline-offset: 2px;
}

.checkbox:checked {
  background-color: #000;
  border-color: #000;
}

.checkbox-label-container {
  flex: 1;
}

.checkbox-label {
  font-size: 1.125rem;
  font-weight: 600;
  color: #374151;
  display: block;
  margin-bottom: 0.5rem;
  cursor: pointer;
}

.checkbox-description {
  font-size: 1rem;
  color: #6b7280;
  margin: 0;
  line-height: 1.5;
=======
>>>>>>> Development
}

/* ===== BUTTON STYLES ===== */
.button-container {
<<<<<<< HEAD
  padding-top: 1.5rem;
  border-top: 1px solid #e5e7eb;
  margin-top: 1rem;
=======
  padding-top: 2rem;
  display: flex;
  justify-content: center;
>>>>>>> Development
}

.button {
  width: 100%;
  max-width: 300px;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.75rem;
  padding: 1.25rem 2rem;
<<<<<<< HEAD
  border: none;
  border-radius: 12px;
  font-size: 1.25rem;
  font-weight: 600;
  color: #ffffff;
  background-color: #000;
  cursor: pointer;
  transition: all 0.3s ease;
}

.button:hover:not(:disabled) {
  background-color: #1a1a1a;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.button:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.2);
}

/* ===== MENU CHECKBOX ===== */
.menu-checkbox {
  display: none;
}

/* ===== MENU OVERLAY ===== */
.menu-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(17, 24, 39, 0.55);
  backdrop-filter: blur(1px);
  z-index: 35;
  cursor: pointer;
}

.menu-checkbox:checked ~ .menu-overlay {
  display: block;
}

/* ===== SIDEBAR ===== */
.side-bar {
  background: #ffffff;
  width: 320px;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  overflow-y: auto;
  z-index: 40;
  border-right: 1px solid #e5e7eb;
  box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
  display: flex;
  flex-direction: column;
  transition: transform 0.3s ease;
}

.sidebar-header {
  padding: 1.75rem 1.5rem;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #f9fafb;
  position: relative;
}

.sidebar-title {
  font-size: 1.375rem;
  font-weight: 700;
  color: #111827;
  margin: 0;
}

.sidebar-close {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  border: 1px solid #e5e7eb;
  background: #ffffff;
  display: none;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background 0.2s ease, border-color 0.2s ease;
  position: relative;
}

.sidebar-close span {
  position: absolute;
  width: 18px;
  height: 2px;
  background: #111827;
  border-radius: 999px;
}

.sidebar-close span:first-child {
  transform: rotate(45deg);
}

.sidebar-close span:last-child {
  transform: rotate(-45deg);
}

.sidebar-close:hover {
  background: #f3f4f6;
  border-color: #d1d5db;
=======
  border: 2px solid transparent;
  border-radius: 0.75rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
    0 2px 4px -1px rgba(0, 0, 0, 0.06);
  font-size: 1.1rem;
  font-weight: 600;
  color: #ffffff;
  background-color: #000000;
  transition: all 0.2s ease;
  cursor: pointer;
  font-family: inherit;
}

.button:hover {
  background-color: #333333;
  transform: translateY(-2px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.button:focus {
  outline: 3px solid #000000;
  outline-offset: 2px;
}

.button:active {
  transform: translateY(0);
}

/* ===== SIDEBAR ===== */
.side-bar {
  background: #f8f9fa;
  width: 100%;
  height: auto;
  position: relative;
  border-right: none;
  border-bottom: 1px solid #ddd;
  z-index: 100;
}

@media (min-width: 1024px) {
  .side-bar {
    width: 280px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    border-right: 1px solid #ddd;
    border-bottom: none;
  }
>>>>>>> Development
}

.side-bar .menu {
  width: 100%;
<<<<<<< HEAD
  padding: 1rem 0;
  flex: 1;
=======
  margin-top: 0;
  padding: 1rem 0;
}

@media (min-width: 1024px) {
  .side-bar .menu {
    margin-top: 80px;
  }
>>>>>>> Development
}

.side-bar .menu .item {
  cursor: pointer;
  position: relative;
}

.side-bar .menu .item a {
  color: #374151;
  text-decoration: none;
<<<<<<< HEAD
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 1.5rem;
  font-size: 1.0625rem;
  font-weight: 500;
  border-bottom: 1px solid #f3f4f6;
=======
  display: block;
  padding: 1rem 1.5rem;
  line-height: 1.5;
  font-size: 1.1rem;
  font-weight: 500;
  border-bottom: 1px solid #eee;
>>>>>>> Development
  transition: all 0.2s ease;
}

.side-bar .menu .item a:hover {
<<<<<<< HEAD
  background: #f9fafb;
  color: #111827;
=======
  background: rgba(0, 0, 0, 0.898);
  color: white;
  padding-left: 2rem;
>>>>>>> Development
}

.side-bar .menu .item .sub-btn {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
}

.chevron-icon {
  transition: transform 0.2s ease;
  color: #6b7280;
  flex-shrink: 0;
}

.chevron-icon.rotated {
  transform: rotate(180deg);
}

.side-bar .menu .item .sub-menu {
  background: #f9fafb;
  position: relative;
  border-left: 3px solid #e5e7eb;
  margin-left: 1.5rem;
}

.side-bar .menu .item .sub-menu a {
<<<<<<< HEAD
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  font-size: 1rem;
  color: #6b7280;
  border-bottom: 1px solid #f3f4f6;
=======
  padding-left: 3rem;
  font-size: 1rem;
  border-bottom: 1px solid #ddd;
>>>>>>> Development
}

.side-bar .menu .item .sub-menu a:hover {
  background: #f3f4f6;
  color: #111827;
  border-left-color: #000;
}

<<<<<<< HEAD
.sidebar-footer {
  padding: 1.25rem 1.5rem;
  border-top: 1px solid #e5e7eb;
  background: #f9fafb;
=======
/* ===== MAIN CONTENT AREA ===== */
.content {
  margin-left: 0;
  flex: 1;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  max-width: 100%;
  padding-top: 1rem;
}

@media (min-width: 1024px) {
  .content {
    margin-left: 280px;
    padding-top: 0;
  }
}

/* ===== RESPONSIVE ADJUSTMENTS ===== */
@media (max-width: 640px) {
  .container {
    padding: 1rem;
  }

  .main-content {
    padding: 0.5rem;
  }

  .card {
    padding: 1.5rem;
    margin-bottom: 2rem;
  }

  .titles h1 {
    font-size: 1.75rem;
  }

  .titles h3 {
    font-size: 1.1rem;
  }

  .title {
    font-size: 1.75rem;
  }

  .subtitle {
    font-size: 1rem;
  }

  .label {
    font-size: 1rem;
  }

  .input-field {
    height: 3rem;
    font-size: 1rem;
    padding-left: 3rem;
  }

  .input-icon {
    left: 1rem;
    font-size: 1.25rem;
  }

  .button {
    padding: 1rem 1.5rem;
    font-size: 1rem;
  }
}

@media (min-width: 641px) and (max-width: 1023px) {
  .container {
    padding: 1.5rem;
  }

  .side-bar {
    height: auto;
    position: relative;
  }

  .content {
    margin-left: 0;
  }

  .card {
    max-width: 800px;
    margin: 0 auto 2.5rem;
  }
}

@media (min-width: 1400px) {
  .main-content {
    max-width: 1400px;
  }

  .card {
    padding: 3rem;
  }
}

/* ===== FOCUS STATES FOR ACCESSIBILITY ===== */
button:focus,
input:focus,
select:focus {
  outline: 3px solid #000000;
  outline-offset: 2px;
}

/* ===== LOADING STATE ===== */
.loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.85);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  z-index: 3000;
  color: white;
}

.loading-spinner {
  border: 6px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top: 6px solid #ffffff;
  width: 60px;
  height: 60px;
  animation: spin 1s linear infinite;
  margin-bottom: 1.5rem;
  z-index: 3000;
}

.loading-screen p {
  font-size: 1.5rem;
  font-weight: 500;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

/* ===== SUCCESS/ERROR MESSAGES ===== */
.success,
.error {
  position: fixed;
  top: 1.5rem;
  left: 50%;
  transform: translateX(-50%);
  padding: 1.5rem 2rem;
  border-radius: 0.75rem;
  font-weight: 600;
  z-index: 1000;
  text-align: center;
  min-width: 300px;
  max-width: 90%;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  animation: slideIn 0.3s ease-out;
  font-size: 1.1rem;
}

.success {
  background-color: #10b981;
  color: #ffffff;
  border: 2px solid #059669;
}

.error {
  background-color: #ef4444;
  color: #ffffff;
  border: 2px solid #dc2626;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateX(-50%) translateY(-30px);
  }
  to {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
  }
>>>>>>> Development
}

.sidebar-logout {
  width: 100%;
  padding: 1rem;
  border-radius: 10px;
  font-size: 1.0625rem;
  justify-content: flex-start;
  background: #ffffff;
  border: 1px solid #e5e7eb;
  color: #374151;
}

.sidebar-logout:hover {
  background: #f3f4f6;
  border-color: #d1d5db;
}

/* ===== RESPONSIVE DESIGN ===== */

/* Tablet */
@media (max-width: 1024px) {
  .main-content {
    margin-left: 0;
    width: 100%;
  }
  
  .side-bar {
    transform: translateX(-100%);
    box-shadow: 2px 0 24px rgba(15, 23, 42, 0.15);
  }
  
  .menu-toggle {
    display: flex;
  }
  
  .sidebar-close {
    display: flex;
  }
  
  .form-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
}

@media (max-width: 768px) {
  .topbar {
    padding: 1rem;
    flex-direction: column;
    align-items: stretch;
    gap: 1rem;
  }
  
  .title-row {
    flex-wrap: wrap;
  }
  
  .title-actions .portal-btn {
    display: none;
  }
  
  .user-section {
    width: 100%;
    justify-content: space-between;
    gap: 1rem;
  }
  
  .desktop-only {
    display: none;
  }
  
  .user-greeting {
    display: none;
  }
  
  .content {
    padding: 1.5rem 1rem;
  }
  
  .container {
    max-width: 100%;
  }
  
  .current-times-card,
  .form-card {
    padding: 1.75rem;
  }
  
  .times-display {
    grid-template-columns: 1fr;
    gap: 1.25rem;
  }
  
  .time-section {
    padding: 1.25rem;
  }
  
  .form-grid {
    grid-template-columns: 1fr;
    gap: 1.25rem;
  }
  
  .input-field {
    height: 3rem;
  }
  
  .side-bar {
    width: min(300px, 85%);
  }
}

/* Mobile */
@media (max-width: 480px) {
  .content {
    padding: 1rem;
  }
  
  .current-times-card,
  .form-card {
    padding: 1.5rem;
  }
  
  .card-title,
  .form-card .title {
    font-size: 1.5rem;
  }
  
  .section-title {
    font-size: 1.25rem;
  }
  
  .times-display {
    gap: 1rem;
  }
  
  .time-section {
    padding: 1rem;
  }
  
  .time-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
  }
  
  .time-value {
    width: 100%;
    text-align: left;
    padding: 0.5rem;
  }
  
  .form-section {
    padding: 1rem;
  }
  
  .button {
    padding: 1rem 1.5rem;
    font-size: 1.125rem;
  }
  
  .side-bar {
    width: 100%;
  }
}

/* High contrast support */
@media (prefers-contrast: high) {
  .input-field,
  .checkbox {
    border-width: 2px;
  }
  
  .time-value {
    border: 1px solid currentColor;
  }
}

/* Focus visibility for accessibility */
button:focus-visible,
input:focus-visible,
select:focus-visible,
.checkbox:focus-visible {
  outline: 2px solid #4a6da7;
  outline-offset: 2px;
}

/* Material icons adjustments */
.material-icons-outlined {
  font-size: 1.25rem;
}

/* Date and time input adjustments */
input[type="date"]::-webkit-calendar-picker-indicator,
input[type="time"]::-webkit-calendar-picker-indicator {
  cursor: pointer;
  filter: invert(0.5);
  opacity: 0.7;
  width: 1.25rem;
  height: 1.25rem;
}

input[type="date"]::-webkit-calendar-picker-indicator:hover,
input[type="time"]::-webkit-calendar-picker-indicator:hover {
  opacity: 1;
}
</style> 