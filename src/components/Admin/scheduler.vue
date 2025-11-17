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
          <svg class="chevron-icon" :class="{ 'rotated': showMenu1 }" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
>>>>>>> a4f7fe1 (fixed the sidebar)
      </div>
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu2 = !showMenu2">
          <span>Teacher</span>
          <svg class="chevron-icon" :class="{ 'rotated': showMenu2 }" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
          <svg class="chevron-icon" :class="{ 'rotated': showMenu3 }" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </a>
        <div class="sub-menu" v-if="showMenu3">
          <a href="#" @click="navigateAndClose('/principal')" class="sub-item">Add Teachers</a>
          <a href="#" @click="navigateAndClose('/principal')" class="sub-item">Delete Users</a>
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
>>>>>>> a4f7fe1 (fixed the sidebar)
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
>>>>>>> a4f7fe1 (fixed the sidebar)
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
<<<<<<< HEAD
      <main class="content-main">
        <div class="card current-times-card">
          <h2 class="card-title">Current Times</h2>
          <div class="times-display">
            <div class="time-item">
              <h3>Student:</h3>
              <p class="time-value">Time here</p>
            </div>
            <div class="time-item">
              <h3>Teacher:</h3>
              <p class="time-value">time here</p>
            </div>
=======
      <main class="main-content">
        <div class="card" style="margin-bottom: 40px">
          <div class="titles">
            <h1>Current Times</h1>
            <br />
            <h3>Time Start: {{ startendtime.time_start }}</h3>
            <h3>Date Start: {{ startendtime.date_start }}</h3>
            <h3>Time End: {{ startendtime.time_end }}</h3>
            <h3>Date End: {{ startendtime.date_end }}</h3>
>>>>>>> 7334c43 (finished the updating of the dynamic questions for the students)
          </div>
        </div>
        <div class="card form-card">
          <header class="header">
            <h1 class="title">Set Due Date</h1>
            <p class="subtitle">
              Define the submission deadline for this assignment.
            </p>
          </header>
<<<<<<< HEAD
          <form @submit.prevent="showtime()" class="form" method="POST">
=======
          <form @submit.prevent="this.setTime()" class="form" method="POST">
>>>>>>> 7334c43 (finished the updating of the dynamic questions for the students)
            <div class="form-grid">
              <div class="form-group">
                <label class="label" for="due-date">Due date</label>
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
                <label class="label" for="due-time">Time</label>
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
            <div class="form-group">
              <label class="label">End (Optional)</label>
              <p class="description">
                Set a final cutoff date and time after which submissions are no
                longer accepted.
              </p>
              <div class="form-grid">
                <div class="form-group">
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
      </main>
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
>>>>>>> a4f7fe1 (fixed the sidebar)
    };
  },

  methods: {
<<<<<<< HEAD
    navigateAndClose(route) {
      this.$router.push(route);
      // Close sidebar on mobile after navigation
      if (window.innerWidth <= 768) {
        document.getElementById('scheduler-nav-toggle').checked = false;
      }
    },
    logout() {
      localStorage.removeItem("userData");
      this.$router.push("/");
    },
    showtime() {
      console.log(this.times);
    },
=======
>>>>>>> 7334c43 (finished the updating of the dynamic questions for the students)
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
          const t = result.times || {};
          this.startendtime = {
            time_start: t.time_start,
            date_start: t.date_start,
            time_end: t.time_end,
            date_end: t.date_end,
          };
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
    //this.getTime();
=======
    this.getTime();
>>>>>>> 7334c43 (finished the updating of the dynamic questions for the students)
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
  background: #f9fafb;
}

/* ===== CONTENT AREA ===== */
.content {
  flex: 1;
  padding: 2rem 1.5rem;
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
  gap: 1.5rem;
}

/* ===== CARD STYLES ===== */
.card {
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
  border: 1px solid #e5e7eb;
  transition: box-shadow 0.2s ease, transform 0.2s ease;
}

.card:hover {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06);
}

.current-times-card {
  padding: 2rem;
}

.card-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #111827;
  margin: 0 0 1.5rem 0;
  padding-bottom: 1rem;
  border-bottom: 2px solid #e5e7eb;
}

.times-display {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1.5rem;
}

.time-item {
  padding: 1.25rem;
  background: #f9fafb;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
}

.time-item h3 {
  font-size: 0.875rem;
  font-weight: 600;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin: 0 0 0.5rem 0;
}

.time-value {
  font-size: 1.125rem;
  font-weight: 600;
  color: #111827;
  margin: 0;
}

.form-card {
  padding: 2rem;
}

.form-card .header {
  margin-bottom: 2rem;
  padding-bottom: 1.5rem;
  border-bottom: 2px solid #e5e7eb;
}

.form-card .title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #111827;
  margin: 0 0 0.5rem 0;
}

.form-card .subtitle {
  font-size: 0.875rem;
  color: #6b7280;
  margin: 0;
  line-height: 1.5;
}

/* ===== FORM STYLES ===== */
.form {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
}

.label {
  display: block;
  font-size: 0.875rem;
  font-weight: 600;
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
  padding-right: 1rem;
  width: 100%;
  border-radius: 0.5rem;
  border: 1px solid #d1d5db;
  background-color: #ffffff;
  color: #111827;
  height: 2.75rem;
  font-size: 0.875rem;
  transition: all 0.2s ease;
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

<<<<<<< HEAD
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

=======
>>>>>>> 7334c43 (finished the updating of the dynamic questions for the students)
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

  .content {
    padding: 1rem;
  }

  .container {
    max-width: 100%;
  }

  .current-times-card,
  .form-card {
    padding: 1.5rem;
  }

  .times-display {
    grid-template-columns: 1fr;
    gap: 1rem;
  }

  .form-grid {
    grid-template-columns: 1fr;
    gap: 1.25rem;
  }
}

@media (max-width: 480px) {
  .content {
    padding: 0.75rem;
  }

  .current-times-card,
  .form-card {
    padding: 1.25rem;
  }

  .card-title,
  .form-card .title {
    font-size: 1.25rem;
  }

  .side-bar {
    width: min(280px, 85%);
  }

  .times-display {
    gap: 0.75rem;
  }

  .time-item {
    padding: 1rem;
  }
}
</style>
