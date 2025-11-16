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
          <svg class="chevron-icon" :class="{ 'rotated': showMenu1 }" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
          <svg class="chevron-icon" :class="{ 'rotated': showMenu2 }" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
          <svg class="chevron-icon" :class="{ 'rotated': showMenu3 }" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </a>
        <div class="sub-menu" v-if="showMenu3">
          <a href="#" @click="navigateAndClose('/principal')" class="sub-item">Add Teachers</a>
          <a href="#" @click="navigateAndClose('/principal')" class="sub-item">Delete Users</a>
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
        <svg class="logout-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
          <svg class="logout-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
      <main class="main-content">
        <div class="card" style="margin-bottom: 40px">
          <h1>Current Times</h1>
          <br />
          <h3>Student:</h3>
          <h4>Time here</h4>
          <h3>Teacher:</h3>
          <h4>time here</h4>
        </div>
        <div class="card">
          <header class="header">
            <h1 class="title">Set Due Date</h1>
            <p class="subtitle">
              Define the submission deadline for this assignment.
            </p>
          </header>
          <form @submit.prevent="this.showtime()" class="form" method="POST">
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
                </div>
              </div>
              <div class="form-group">
                <label class="label" for="due-time">Time</label>
                <div class="input-container">
                  <span class="material-icons-outlined input-icon">
                    schedule
                  </span>
                  <input
                    class="input-field"
                    name="due-time"
                    type="time"
                    v-model="times.timeset"
                    required
                  />
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="label">End</label>
              <p class="description">
                Set a final cutoff date and time after which submissions are no
                longer accepted.
              </p>
              <div class="form-grid">
                <div>
                  <div class="input-container">
                    <span class="material-icons-outlined input-icon">
                      event_busy
                    </span>
                    <input
                      class="input-field"
                      name="end-date"
                      type="date"
                      v-model="times.dateend"
                      required
                    />
                  </div>
                </div>
                <div>
                  <div class="input-container">
                    <span class="material-icons-outlined input-icon">
                      access_time
                    </span>
                    <input
                      class="input-field"
                      name="end-time"
                      type="time"
                      v-model="times.timeend"
                      required
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="button-container">
              <button class="button" type="submit">
                <span class="material-icons-outlined">save</span>
                Save Settings
              </button>
            </div>
            <div class="checkbox-label-container">
              <label class="checkbox-label" for="countdown-timer"
                >Countdown Timer</label
              >
              <p class="checkbox-description">
                Display a countdown timer for students.
              </p>
            </div>
          </div>
          <div class="button-container">
            <button class="button" type="submit">
              <span class="material-icons-outlined">save</span>
              Save Settings
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
const url1 = "https://rusiann7.helioho.st";
const url2 = "https://star-panda-literally.ngrok-free.app";

export default {
  name: "schedule",
  data() {
    return {
      timegetterphp: `${url2}/time.php`,
      timesettierphp: `${url2}/startEvalSMTP.php`,
      times: {
        timeset: "",
        dateset: "",
        timeend: "",
        dateend: "",
      },
      startendtime: {},
      isLoading: false,
      showMenu1: false,
      showMenu2: false,
      showMenu3: false,
    };
  },

  methods: {
    showtime() {
      console.log(this.times);
    },
    async setTime() {
      try {
        this.isLoading = true;

        const response = await fetch(this.timesettierphp, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "setTime",
            timess: this.times,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.isLoading = false;
          this.getTime();
        } else {
          this.isLoading = false;
        }
      } catch (error) {
        this.isLoading = false;
        console.error(error);
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
          this.startendtime = this.result;
          this.isLoading = false;
        } else {
          this.isLoading = false;
        }
      } catch (error) {
        this.isLoading = false;
        console.error(error);
      }
    },
  },

  mounted() {
    //this.getTime();
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

.material-icons-outlined {
  font-size: 20px;
}

input[type="date"]::-webkit-calendar-picker-indicator {
  cursor: pointer;
  filter: invert(0.5);
}

input[type="time"]::-webkit-calendar-picker-indicator {
  cursor: pointer;
  filter: invert(0.5);
}

/* ===== TOPBAR STYLES ===== */
.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 1.5rem;
  border-bottom: 1px solid #e5e7eb;
  flex-wrap: wrap;
  gap: 1rem;
  position: sticky;
  top: 0;
  background: white;
  z-index: 30;
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
  font-size: 1.125rem;
  margin: 0;
  color: #111827;
}

.title-actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.portal-btn {
  background: #f3f4f6;
  padding: 0.5rem 1rem;
  border-radius: 12px;
  font-size: 0.875rem;
  cursor: pointer;
  border: none;
  transition: background 0.2s;
  white-space: nowrap;
}

.portal-btn:hover {
  background: #e5e7eb;
}

.user-section {
  display: flex;
  align-items: center;
  gap: 1rem;
  font-size: 0.875rem;
  flex-wrap: wrap;
}

.user-greeting {
  color: #374151;
  white-space: nowrap;
}

.desktop-only {
  display: inline-flex;
}

.menu-toggle {
  display: none;
  width: 36px;
  height: 36px;
  border-radius: 10px;
  border: 1px solid #d1d5db;
  background: rgba(255, 255, 255, 0.95);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  cursor: pointer;
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 4px;
  position: relative;
  z-index: 45;
  flex-shrink: 0;
}

.menu-toggle span {
  width: 16px;
  height: 2px;
  background: #111827;
  border-radius: 999px;
  transition: transform 0.25s ease, opacity 0.25s ease;
}

.logout-btn {
  background: #f3f4f6;
  border: 1px solid #e5e7eb;
  padding: 0.5rem 1rem;
  border-radius: 12px;
  cursor: pointer;
  text-decoration: none;
  color: #374151;
  transition: all 0.2s ease;
  white-space: nowrap;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.875rem;
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
  margin-left: 280px;
  width: calc(100% - 280px);
  transition: margin-left 0.3s ease, width 0.3s ease;
}

/* ===== PAGE HEADER ===== */
.page-header {
  padding: 1.5rem 1.5rem 0.625rem;
}

.page-header h2 {
  margin: 0;
  font-size: 1.25rem;
  font-weight: 600;
  color: #111827;
}

.page-header p {
  color: #6b7280;
  font-size: 0.875rem;
  margin-top: 0.5rem;
  line-height: 1.5;
}

/* ===== CONTENT WRAPPER ===== */
.content-wrapper {
  padding: 1.25rem 1.5rem 2.5rem;
  flex: 1;
}

.form-card {
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  padding: 2rem;
  max-width: 800px;
  margin: 0 auto;
  border: 1px solid #e5e7eb;
}

.form-header {
  margin-bottom: 2rem;
  padding-bottom: 1.5rem;
  border-bottom: 1px solid #e5e7eb;
}

.form-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #111827;
  margin: 0 0 0.5rem 0;
}

.form-subtitle {
  font-size: 0.875rem;
  color: #6b7280;
  margin: 0;
  line-height: 1.5;
}

/* ===== FORM STYLES ===== */
.form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
}

.label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.5rem;
}

.required {
  color: #dc2626;
  margin-left: 2px;
}

.description {
  font-size: 0.75rem;
  color: #6b7280;
  margin-bottom: 0.75rem;
  line-height: 1.5;
}

.input-container {
  position: relative;
}

.input-icon {
  position: absolute;
  left: 0.875rem;
  top: 50%;
  transform: translateY(-50%);
  color: #6b7280;
  pointer-events: none;
  z-index: 1;
}

.input-field {
  padding-left: 2.5rem;
  width: 85%;
  border-radius: 0.5rem;
  border: 1px solid #d1d5db;
  background-color: #f9fafb;
  color: #111827;
  height: 2.75rem;
  font-size: 0.875rem;
  transition: all 0.3s ease;
}

.input-field:focus {
  outline: none;
  border-color: #000;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

.input-field:hover {
  border-color: #c1c9d2;
}

.checkbox-container {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  padding: 1rem;
  background: #f9fafb;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
}

.checkbox-wrapper {
  display: flex;
  align-items: center;
  margin-top: 0.125rem;
}

.checkbox {
  width: 1.125rem;
  height: 1.125rem;
  border-radius: 4px;
  border: 1.5px solid #d1d5db;
  cursor: pointer;
  accent-color: #000;
}

.checkbox:focus {
  outline: 2px solid #000;
  outline-offset: 2px;
}

.checkbox-label-container {
  flex: 1;
}

.checkbox-label {
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  display: block;
  margin-bottom: 0.25rem;
  cursor: pointer;
}

.checkbox-description {
  font-size: 0.8125rem;
  color: #6b7280;
  margin: 0;
  line-height: 1.5;
}

.button-container {
  padding-top: 1rem;
  border-top: 1px solid #e5e7eb;
  margin-top: 0.5rem;
}

.button {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.5rem;
  padding: 0.875rem 1.5rem;
  border: none;
  border-radius: 8px;
  font-size: 0.9375rem;
  font-weight: 600;
  color: #ffffff;
  background-color: #000;
  cursor: pointer;
  transition: all 0.3s ease;
}

.button:hover {
  background-color: #1a1a1a;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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
  width: 280px;
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
  padding: 1.5rem 1.25rem;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #f9fafb;
  position: relative;
}

.sidebar-title {
  font-size: 1.125rem;
  font-weight: 700;
  color: #111827;
  margin: 0;
}

.sidebar-close {
  width: 32px;
  height: 32px;
  border-radius: 8px;
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
  width: 14px;
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
  padding: 0.75rem 0;
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
  padding: 0.875rem 1.25rem;
  font-size: 0.9375rem;
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
  margin-left: 1.25rem;
}

.side-bar .menu .item .sub-menu a {
  padding-left: 1.25rem;
  padding-right: 1.25rem;
  font-size: 0.875rem;
  color: #6b7280;
  border-bottom: 1px solid #f3f4f6;
}

.side-bar .menu .item .sub-menu a:hover {
  background: #f3f4f6;
  color: #111827;
  border-left-color: #000;
}

.sidebar-footer {
  padding: 1rem 1.25rem;
  border-top: 1px solid #e5e7eb;
  background: #f9fafb;
}

.sidebar-logout {
  width: 100%;
  padding: 0.75rem 1rem;
  border-radius: 8px;
  font-size: 0.9375rem;
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
@media (max-width: 768px) {
  .topbar {
    padding: 1rem;
    gap: 1rem;
  }

  .header-left {
    width: 100%;
  }

  .title-row {
    width: 100%;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
  }

  .title-actions .portal-btn {
    display: none;
  }

  .user-section {
    width: 100%;
    justify-content: space-between;
    gap: 0.75rem;
  }

  .desktop-only {
    display: none;
  }

  .menu-toggle {
    display: flex;
  }

  .menu-checkbox:checked ~ .menu-toggle {
    display: none !important;
  }

  .user-greeting {
    display: none;
  }

  .side-bar {
    transform: translateX(-100%);
    box-shadow: 2px 0 24px rgba(15, 23, 42, 0.15);
  }

  .menu-checkbox:checked ~ .side-bar {
    transform: translateX(0);
  }

  .sidebar-close {
    display: flex;
  }

  .main-content {
    margin-left: 0 !important;
    width: 100% !important;
    max-width: 100% !important;
  }

  .page-header {
    padding: 1.25rem 1rem 0.5rem;
  }

  .content-wrapper {
    padding: 1rem;
  }

  .form-card {
    padding: 1.5rem;
  }

  .form-grid {
    grid-template-columns: 1fr;
    gap: 1.25rem;
  }
}

@media (max-width: 480px) {
  .form-card {
    padding: 1.25rem;
  }

  .form-title {
    font-size: 1.25rem;
  }

  .side-bar {
    width: min(280px, 85%);
  }
}
</style>
