<template>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap"
    rel="stylesheet"
  />
  <link
    href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet"
  />

  <link
    href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined"
    rel="stylesheet"
  />

  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0&icon_names=add"
  />

  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0&icon_names=arrow_upward"
  />

  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0&icon_names=arrow_downward"
  />

  <!--sidebar-->
  <Sidebar
    :isNavOpen="isNavOpen"
    @close="closeNav"
    @navigate="click"
    @navigate2="click2"
  />
  <!-- Main content container -->
  <div class="main-content">
    <!-- Header -->

    <div class="content">
      <div class="container">
        <button
          class="menu-trigger"
          @click="isNavOpen = true"
          aria-label="Open menu"
        >
          <span class="material-icons">menu</span>
        </button>
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
                  Set a final cutoff date and time after which submissions are
                  no longer accepted.
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
            </form>
          </div>
        </main>
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from "../../component/sidebar.vue";

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
      },
      startendtime: {},
      isLoading: false,
      showMenu1: false,
      showMenu2: false,
      showMenu3: false,
      showMenu4: false,
      isNavOpen: false,
    };
  },

  components: { Sidebar },

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

    closeNav() {
      this.isNavOpen = false;
    },
    click(tabName) {
      this.activeTab = tabName;
      this.activeModal = tabName;
    },
    click2(tabName) {
      this.activeTab1 = tabName;
      this.activeModal = "manage";
    },
  },

  mounted() {
    this.getTime();
  },
};
</script>

<style scoped>
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
  box-shadow:
    0 8px 16px -1px rgba(0, 0, 0, 0.1),
    0 4px 8px -1px rgba(0, 0, 0, 0.06);
  padding: 2rem;
  margin-bottom: 2.5rem;
  border: 2px solid #e5e7eb;
  transition: all 0.3s ease;
}

.card:hover {
  transform: translateY(-4px);
  box-shadow:
    0 16px 32px -2px rgba(0, 0, 0, 0.15),
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
}

.subtitle {
  color: #6b7280;
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
}

.form-grid {
  display: grid;
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
}

.label {
  display: block;
  font-size: 1.1rem;
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.75rem;
}

.description {
  font-size: 1rem;
  color: #6b7280;
  margin-bottom: 1rem;
  line-height: 1.5;
}

.input-container {
  position: relative;
  width: 100%;
}

.input-icon {
  position: absolute;
  left: 1.25rem;
  top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
  pointer-events: none;
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
}

.input-field:focus {
  outline: none;
  border-color: #000000;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

.input-field:hover {
  border-color: #9ca3af;
}

.button-container {
  padding-top: 2rem;
  display: flex;
  justify-content: center;
}

.button {
  width: 100%;
  max-width: 300px;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.75rem;
  padding: 1.25rem 2rem;
  border: 2px solid transparent;
  border-radius: 0.75rem;
  box-shadow:
    0 4px 6px -1px rgba(0, 0, 0, 0.1),
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
