<template>
  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <!-- Header -->
  <header>
    <div class="header-left">
      <input
        type="checkbox"
        id="teacher-nav-toggle"
        class="menu-checkbox"
        aria-hidden="true"
      />
      <div class="title-row">
        <h1>Teacher Evaluation System</h1>
        <div class="title-actions">
          <button class="portal-btn">Teacher Portal</button>
          <label
            for="teacher-nav-toggle"
            class="menu-toggle"
            aria-label="Toggle menu"
          >
            <span></span>
            <span></span>
            <span></span>
          </label>
        </div>
      </div>
      <label
        for="teacher-nav-toggle"
        class="menu-overlay"
        aria-hidden="true"
      ></label>
      <div class="menu-panel" role="dialog" aria-labelledby="teacher-nav-title">
        <div class="menu-header">
          <p id="teacher-nav-title" class="menu-title">Teacher Portal</p>
          <p class="menu-subtitle">Welcome, {{ fullname }} {{ lastname }}</p>
        </div>
        <label
          for="teacher-nav-toggle"
          class="menu-close"
          aria-label="Close menu"
        >
          <span></span>
          <span></span>
        </label>
        <button class="logout-btn menu-logout" @click="logout()">
          <svg
            class="logout-icon"
            width="16"
            height="16"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg>
          Logout
        </button>
      </div>
    </div>
    <div class="user-section">
      <span class="user-greeting">Welcome, {{ fullname }} {{ lastname }}</span>
      <button class="logout-btn desktop-only" @click="logout()">
        <svg
          class="logout-icon"
          width="16"
          height="16"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
          <polyline points="16 17 21 12 16 7"></polyline>
          <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
        Logout
      </button>
    </div>
  </header>

  <!-- Page Title -->
  <div class="page-header">
    <h2>Teacher Portal</h2>
    <p>Evaluate your colleagues and view feedback received from peers</p>
  </div>

  <!--Verify Status-->
  <div v-if="verified === '1'" class="verify-container">
    <div class="verify-card verified">
      <div class="verify-header">
        <p class="verify-title">Account Verification</p>
        <p class="verify-subtitle">Your account is now verified</p>
      </div>
      <div class="verify-status">
        <span class="checkmark">✔</span>
      </div>
    </div>
  </div>

  <div v-if="(verified === '0') & (active === 'code')" class="verify-container">
    <div class="verify-card">
      <div class="verify-header">
        <p class="verify-title">Account Verification</p>
        <p class="verify-subtitle">Verify your account to continue</p>
      </div>
      <button @click="verifyCode" class="verify-btn">Send Code</button>
    </div>
  </div>

  <div
    v-if="(verified === '0') & (active === 'input')"
    class="verify-container"
  >
    <div class="verify-card">
      <div class="verify-header">
        <p class="verify-title">Account Verification</p>
        <p class="verify-subtitle">
          Enter the verification code sent to your email
        </p>
      </div>
      <form method="post" @submit.prevent="verifyInput" class="verify-form">
        <input
          type="text"
          v-model="verify"
          placeholder="Enter verification code"
          class="verify-input"
        />
        <button type="submit" class="verify-btn">Submit</button>
      </form>
    </div>
  </div>

  <!-- Stats -->
  <div class="stats-container">
    <div class="stat-card">
      <div class="stat-icon">👥</div>
      <h3>{{ count }}</h3>
      <p>Colleagues</p>
    </div>
    <div class="stat-card">
      <div class="stat-icon">✅</div>
      <h3>2</h3>
      <p>Completed</p>
    </div>
  </div>

  <!-- Search & Filters -->
  <div class="teacher-controls">
    <div class="search-box">
      <svg
        class="search-icon"
        width="18"
        height="18"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
      >
        <circle cx="11" cy="11" r="8"></circle>
        <path d="m21 21-4.35-4.35"></path>
      </svg>
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search teachers by name or subject..."
        class="search-input"
      />
    </div>
    <div class="filter-controls">
      <select v-model="sortBy" class="sort-select">
        <option value="name">Sort by Name</option>
        <option value="subject">Sort by Subject</option>
        <option value="quarter">Sort by Quarter</option>
      </select>
      <label class="toggle-label">
        <input
          type="checkbox"
          v-model="hideEvaluated"
          class="toggle-checkbox"
        />
        <span class="toggle-text">Hide Evaluated</span>
      </label>
    </div>
  </div>

  <!-- Teacher Cards -->
  <div class="teacher-container">
    <div
      class="teacher-card"
      v-for="(teacher, idx) in filteredTeachers"
      :key="`t-${teacher.id}-${idx}`"
    >
      <h3 v-if="teacher.evaluated === 'evaluated'">
        {{ teacher.firstname }} {{ teacher.lastname
        }}<span class="checkmark">✔</span>
      </h3>
      <h3 v-else>{{ teacher.firstname }} {{ teacher.lastname }}</h3>
      <p>{{ teacher.subject }}</p>
      <span class="badge">Q{{ teacher.quarter }} {{ teacher.year }}</span>
      <span v-if="teacher.evaluated === 'evaluated'" class="badge evaluated"
        >Evaluated</span
      >
      <br v-if="teacher.evaluated !== 'evaluated'" /><br
        v-if="teacher.evaluated !== 'evaluated'"
      />
      <button
        v-if="teacher.evaluated !== 'evaluated'"
        class="start"
        @click.prevent="
          $router.push({ name: 'teacher-eval', params: { id: teacher.id } })
        "
      >
        Start Evaluation
      </button>
    </div>
    <div v-if="filteredTeachers.length === 0" class="no-results">
      <p>No teachers found matching your search criteria.</p>
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
      urlappphp: `${url2}/Getter.php`,
      teachers: [],
      count: 0,
      isLoading: false,
      searchQuery: "",
      sortBy: "name",
      hideEvaluated: false,
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
          body: JSON.stringify({ action: "getTeachers" }),
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

    verifyCode() {
      // Implementation for verify code
      this.active = "input";
    },

    verifyInput() {
      // Implementation for verify input
      this.verified = "1";
    },
  },

  computed: {
    filteredTeachers() {
      let list = this.teachers.slice();

      if (this.searchQuery.trim()) {
        const q = this.searchQuery.toLowerCase().trim();
        list = list.filter(
          (t) =>
            `${t.firstname} ${t.lastname}`.toLowerCase().includes(q) ||
            t.subject.toLowerCase().includes(q)
        );
      }

      if (this.hideEvaluated) {
        list = list.filter((t) => t.evaluated !== "evaluated");
      }

      return [...list].sort((a, b) => {
        if (this.sortBy === "name") {
          const aName = `${a.firstname} ${a.lastname}`.toLowerCase();
          const bName = `${b.firstname} ${b.lastname}`.toLowerCase();
          return aName.localeCompare(bName);
        }
        if (this.sortBy === "subject") {
          return a.subject.localeCompare(b.subject);
        }
        if (this.sortBy === "quarter") {
          if (a.year !== b.year) return a.year - b.year;
          return a.quarter - b.quarter;
        }
        return 0;
      });
    },
  },

  mounted() {
    this.getTeachers();
    this.skipLogin();
    this.id = localStorage.getItem("userData") || "";
  },
};
</script>

<style scoped>
/* Global Styles */
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
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 1.5rem;
  border-bottom: 1px solid #ddd;
  background: #fff;
  flex-wrap: wrap;
  gap: 1rem;
}

.header-left {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  flex-wrap: wrap;
  position: relative;
}

.title-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  gap: 1rem;
}

.title-row h1 {
  flex: 1;
}

.title-actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

header h1 {
  font-size: 1.25rem;
  font-weight: bold;
  margin: 0;
}

.user-section {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  gap: 1rem;
  flex-wrap: wrap;
}

.menu-checkbox {
  display: none;
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

.menu-toggle:focus-visible {
  outline: 2px solid #111827;
  outline-offset: 3px;
}

.menu-panel {
  position: fixed;
  top: 0;
  right: 0;
  width: min(280px, 80%);
  height: 100vh;
  background: #ffffff;
  border-left: 1px solid #e5e7eb;
  box-shadow: -6px 0 24px rgba(15, 23, 42, 0.15);
  padding: 4.5rem 1.75rem 2rem;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  transform: translateX(100%);
  opacity: 0;
  pointer-events: none;
  transition: transform 0.3s ease, opacity 0.3s ease;
  z-index: 40;
}

.menu-header {
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #e5e7eb;
}

.menu-title {
  font-size: 1.2rem;
  font-weight: 700;
  color: #111827;
}

.menu-subtitle {
  font-size: 0.9rem;
  color: #4b5563;
}

.menu-close {
  align-self: flex-end;
  width: 36px;
  height: 36px;
  border-radius: 10px;
  border: 1px solid #e5e7eb;
  background: #f9fafb;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background 0.2s ease, border-color 0.2s ease;
  position: absolute;
  top: 1.25rem;
  right: 1.25rem;
  z-index: 41;
}

.menu-close span {
  position: absolute;
  width: 16px;
  height: 2px;
  background: #111827;
  border-radius: 999px;
}

.menu-close span:first-child {
  transform: rotate(45deg);
}

.menu-close span:last-child {
  transform: rotate(-45deg);
}

.menu-close:hover {
  background: #eef2ff;
  border-color: #d1d5db;
}

.menu-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(17, 24, 39, 0.55);
  backdrop-filter: blur(1px);
  z-index: 35;
  cursor: pointer;
}

.menu-logout {
  width: 100%;
  padding: 0.85rem 1rem;
  border-radius: 12px;
  font-size: 0.95rem;
  justify-content: flex-start;
}

.menu-checkbox:checked ~ .menu-panel {
  transform: translateX(0);
  opacity: 1;
  pointer-events: auto;
}

.menu-checkbox:checked ~ .menu-overlay {
  display: block;
  position: fixed;
  inset: 0;
  background: rgba(17, 24, 39, 0.55);
  backdrop-filter: blur(2px);
  z-index: 30;
  cursor: pointer;
}
.portal-btn {
  background: #f3f4f6;
  padding: 0.5rem 1rem;
  border-radius: 12px;
  font-size: 0.875rem;
  cursor: pointer;
  border: none;
  transition: background 0.2s;
}

.portal-btn:hover {
  background: #e5e7eb;
}

.logout-btn {
  border: none;
  background: #f3f4f6;
  padding: 0.5rem 1rem;
  border-radius: 12px;
  cursor: pointer;
  transition: background 0.2s;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
}

.logout-btn:hover {
  background: #e5e7eb;
}

.logout-icon {
  color: #dc2626;
  stroke: #dc2626;
}

.logout-icon {
  flex-shrink: 0;
  color: #dc2626;
  stroke: #dc2626;
}

/* Page Headers */
.page-header {
  padding: 1.875rem 1.5rem 0.625rem;
}

.page-header h2 {
  margin: 0;
  font-size: 1.4rem;
  margin-bottom: 0.5rem;
}

.page-header p {
  color: #555;
  font-size: 0.975rem;
}

/* Stats */
.stats-container {
  display: flex;
  gap: 1.5rem;
  padding: 1.5rem;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
}

.stat-card {
  flex: 1;
  min-width: 180px;
  background: #fff;
  border-radius: 16px;
  padding: 1.75rem 1.5rem;
  text-align: center;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-5px);
}

.stat-card h3 {
  margin: 0.625rem 0 0;
  font-size: 1.25rem;
}

.stat-card p {
  color: #555;
  font-size: 0.975rem;
}

/* Verify Account Section */
.verify-container {
  padding: 1.25rem 1.5rem;
  max-width: 600px;
  margin: 0 auto;
}

.verify-card {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  padding: 1.75rem;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}

.verify-card.verified {
  border-color: #10b981;
  background: #f0fdf4;
}

.verify-header {
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #e5e7eb;
  margin-bottom: 1.25rem;
}

.verify-card.verified .verify-header {
  border-bottom-color: #10b981;
}

.verify-title {
  font-size: 1.2rem;
  font-weight: 700;
  color: #111827;
  margin: 0;
}

.verify-subtitle {
  font-size: 0.9rem;
  color: #4b5563;
  margin: 0;
}

.verify-status {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem 0;
}

.verify-status .checkmark {
  font-size: 2rem;
  color: #10b981;
}

.verify-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.verify-input {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid #d1d5db;
  border-radius: 10px;
  font-size: 0.95rem;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.verify-input:focus {
  outline: none;
  border-color: #000;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

.verify-btn {
  width: 100%;
  padding: 0.85rem 1rem;
  background: #000;
  color: #fff;
  border: none;
  border-radius: 10px;
  font-size: 0.95rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s, transform 0.1s;
}

.verify-btn:hover {
  background: #333;
  transform: translateY(-1px);
}

.verify-btn:active {
  transform: translateY(0);
}

/* Tabs */
.tabs {
  display: flex;
  gap: 0.75rem;
  padding: 0 1.5rem;
  margin: 1.5rem 0;
  flex-wrap: wrap;
}

.tab {
  background: #f1f3f5;
  padding: 0.875rem 1.5rem;
  border-radius: 12px;
  cursor: pointer;
  transition: all 0.2s;
  border: none;
  font-weight: 500;
}

.tab:hover {
  background: #e9ecef;
}

.tab.active {
  background: #000;
  color: #fff;
}

/* Teacher Controls */
.teacher-controls {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
  margin: 0 1.5rem 2rem;
  padding: 1.5rem;
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 16px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.teacher-controls {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin: 1.25rem 1.5rem;
  padding: 1rem;
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.search-box {
  position: relative;
  display: flex;
  align-items: center;
}

.search-icon {
  position: absolute;
  left: 0.75rem;
  color: #6b7280;
  pointer-events: none;
}

.search-input {
  width: 100%;
  padding: 0.75rem 0.75rem 0.75rem 2.5rem;
  border: 1px solid #d1d5db;
  border-radius: 10px;
  font-size: 0.875rem;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.search-input:focus {
  outline: none;
  border-color: #000;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

.filter-controls {
  display: flex;
  gap: 1rem;
  align-items: center;
  flex-wrap: wrap;
}

.sort-select {
  padding: 0.75rem 1rem;
  border: 1px solid #d1d5db;
  border-radius: 10px;
  font-size: 0.875rem;
  background: #fff;
  cursor: pointer;
  transition: border-color 0.2s, box-shadow 0.2s;
  flex: 1;
  min-width: 180px;
}

.sort-select:focus {
  outline: none;
  border-color: #000;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

.toggle-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
  user-select: none;
  font-size: 0.875rem;
  color: #374151;
}

.toggle-checkbox {
  width: 18px;
  height: 18px;
  cursor: pointer;
  accent-color: #000;
}

.toggle-text {
  font-weight: 500;
}

.dropdown {
  padding: 0.5rem 1rem;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 0.875rem;
  background: #fff;
  cursor: pointer;
  transition: border-color 0.2s, box-shadow 0.2s;
  flex: 1;
  min-width: 200px;
  font-size: 1rem;
}

.sort-select:focus {
  outline: none;
  border-color: #000;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

/* Teacher Container */
.teacher-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 350px));
  gap: 1.25rem;
  padding: 0 1.5rem 2.5rem;
  justify-content: start;
}

.no-results {
  grid-column: 1 / -1;
  text-align: center;
  padding: 3rem 1rem;
  color: #6b7280;
}

.no-results p {
  font-size: 1rem;
  margin: 0;
}

.teacher-card {
  border: 1px solid #eee;
  border-radius: 16px;
  padding: 1.75rem;
  background: #fff;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.teacher-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

.teacher-card h3 {
  margin: 0;
  font-size: 1.05rem;
}

.teacher-card p {
  color: #555;
  margin: 0.5rem 0 0.75rem;
  font-size: 0.95rem;
}

.teacher-card button {
  width: auto;
  padding: 0.75rem 1.25rem;
  border: 1px solid #ddd;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  font-size: 0.95rem;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.25rem;
}

.teacher-card .start {
  background: #000;
  color: #fff;
}

.teacher-card .start:hover {
  background: #333;
}

.badge {
  display: inline-block;
  background: #f1f3f5;
  padding: 0.25rem 0.75rem;
  font-size: 0.82rem;
  border-radius: 20px;
  font-weight: 600;
}

.btn {
  display: inline-block;
  padding: 1rem 1.5rem;
  border-radius: 10px;
  font-weight: 600;
  text-decoration: none;
  cursor: pointer;
  border: none;
  transition: all 0.2s;
  width: 100%;
  font-size: 1rem;
}

.btn-dark {
  background: #000;
  color: #fff;
}

.btn-dark:hover {
  background: #333;
  transform: translateY(-2px);
}

/* No Results */
.no-results {
  grid-column: 1 / -1;
  text-align: center;
  padding: 4rem 1rem;
  color: #6b7280;
}

.btn-light:hover {
  background: #e9ecef;
}

/* Responsive Design */
@media (max-width: 768px) {
  header {
    padding: 1rem;
    flex-direction: column;
    align-items: flex-start;
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

  .title-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .title-actions .portal-btn {
    display: none;
  }

  .menu-toggle {
    display: flex;
  }

  .menu-checkbox:checked ~ .title-row .menu-toggle {
    display: none !important;
  }

  .user-section {
    width: 100%;
    justify-content: space-between;
    gap: 0.75rem;
  }

  .desktop-only {
    display: none;
  }

  .user-greeting {
    display: none;
  }

  .page-header {
    padding: 1.5rem 1rem 0.5rem;
  }

  .teacher-header {
    flex-direction: column;
    align-items: flex-start;
  }

  .teacher-controls {
    margin: 1rem 1rem 1.25rem;
    padding: 0.75rem;
  }

  .filter-controls {
    flex-direction: column;
    align-items: stretch;
    gap: 0.75rem;
  }

  .sort-select {
    width: 100%;
    min-width: unset;
  }

  .stats-container {
    padding: 1rem;
  }

  .stat-card {
    min-width: calc(50% - 0.625rem);
  }

  .verify-container {
    padding: 1rem;
  }

  .verify-card {
    padding: 1.5rem;
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

  .teacher-card button {
    width: 100%;
    justify-content: center;
  }
}

@media (max-width: 480px) {
  header h1 {
    font-size: 1.125rem;
  }

  .user-section {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.75rem;
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

  .verify-container {
    padding: 0.75rem;
  }

  .verify-card {
    padding: 1.25rem;
  }

  .verify-title {
    font-size: 1.1rem;
  }

  .verify-subtitle {
    font-size: 0.85rem;
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
  background-color: rgba(0, 0, 0, 0.85);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  z-index: 3000;
  color: white;
}

.loading-spinner {
  border: 5px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top: 5px solid #ffffff;
  width: 60px;
  height: 60px;
  animation: spin 1s linear infinite;
  margin-bottom: 1.5rem;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

/* Responsive Design */
@media (max-width: 768px) {
  .topbar {
    flex-direction: column;
    align-items: stretch;
    padding: 1rem;
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
    margin-top: 0.5rem;
  }

  .desktop-only {
    display: none;
  }

  .menu-toggle {
    display: flex;
  }

  .user-greeting {
    display: none;
  }

  .page-header {
    padding: 1.5rem 1rem 0.75rem;
  }

  .stats-container {
    padding: 1rem;
    gap: 1rem;
  }

  .stat-card {
    min-width: calc(50% - 0.5rem);
    padding: 1.5rem 1rem;
  }

  .tabs {
    padding: 0 1rem;
    margin: 1rem 0;
  }

  .teacher-controls {
    margin: 0 1rem 1.5rem;
    padding: 1.25rem;
  }

  .filter-controls {
    flex-direction: column;
    align-items: stretch;
    gap: 1rem;
  }

  .sort-select {
    width: 100%;
    min-width: unset;
  }

  .teacher-container {
    padding: 0 1rem 2rem;
    grid-template-columns: 1fr;
  }
}
</style>
