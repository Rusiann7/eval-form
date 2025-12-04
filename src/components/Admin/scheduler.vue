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
      </div>
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu2 = !showMenu2">
          <span>Teacher</span>
          <svg class="chevron-icon" :class="{ 'rotated': showMenu2 }" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </a>
        <div class="sub-menu" v-if="showMenu2">
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
        </div>
      </div>
      <div class="item">
        <a href="#" @click.prevent="navigateAndClose('/scheduler')">Scheduler</a>
      </div>
      <div class="item">
        <a href="#" @click.prevent="navigateAndClose('/fileupload')">File Upload</a>
      </div>
      <div class="item">
        <a href="#" @click.prevent="navigateAndClose('/changequestions')">Question Change</a>
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
      fullname: "",
      lastname: "",
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
          
          // Pre-fill form with existing values
          this.times.timeset = t.time_start || "";
          this.times.dateset = t.date_start || "";
          this.times.timeend = t.time_end || "";
          this.times.dateend = t.date_end || "";
          
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
    this.getTime();
  },
};
</script>

<style scoped>
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
}

.section-description {
  font-size: 1.0625rem;
  color: #6b7280;
  margin: 0;
  line-height: 1.5;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.75rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.label {
  display: block;
  font-size: 1.0625rem;
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.5rem;
}

.required {
  color: #dc2626;
  margin-left: 2px;
}

.input-container {
  position: relative;
}

.input-icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #6b7280;
  pointer-events: none;
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
}

.input-field:focus {
  outline: none;
  border-color: #000;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
  background-color: #ffffff;
}

.input-field:hover {
  border-color: #9ca3af;
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
}

/* ===== BUTTON STYLES ===== */
.button-container {
  padding-top: 1.5rem;
  border-top: 1px solid #e5e7eb;
  margin-top: 1rem;
}

.button {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.75rem;
  padding: 1.25rem 2rem;
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
}

.side-bar .menu {
  width: 100%;
  padding: 1rem 0;
  flex: 1;
}

.side-bar .menu .item {
  cursor: pointer;
  position: relative;
}

.side-bar .menu .item a {
  color: #374151;
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 1.5rem;
  font-size: 1.0625rem;
  font-weight: 500;
  border-bottom: 1px solid #f3f4f6;
  transition: all 0.2s ease;
}

.side-bar .menu .item a:hover {
  background: #f9fafb;
  color: #111827;
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
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  font-size: 1rem;
  color: #6b7280;
  border-bottom: 1px solid #f3f4f6;
}

.side-bar .menu .item .sub-menu a:hover {
  background: #f3f4f6;
  color: #111827;
  border-left-color: #000;
}

.sidebar-footer {
  padding: 1.25rem 1.5rem;
  border-top: 1px solid #e5e7eb;
  background: #f9fafb;
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