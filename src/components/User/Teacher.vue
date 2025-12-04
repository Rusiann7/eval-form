<template>
  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <!-- Header -->
  <header class="topbar">
    <div class="header-left">
      <input
        type="checkbox"
        id="teacher-nav-toggle"
        class="menu-checkbox"
        aria-hidden="true"
      />
      <div class="title-row">
        <h1 class="logo">Teacher Evaluation System</h1>
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
      <div class="menu-panel" role="dialog" aria-labelledby="teacher-nav-title">
        <div class="menu-header">
          <p id="teacher-nav-title" class="menu-title">Teacher Portal</p>
          <p class="menu-subtitle">Welcome, {{ fullname }} {{ lastname }}</p>
        </div>
        <label for="teacher-nav-toggle" class="menu-close" aria-label="Close menu">
          <span></span>
          <span></span>
        </label>
        <button class="logout-btn menu-logout" @click="logout()">
          <svg class="logout-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg>
          Logout
        </button>
      </div>
      <label for="teacher-nav-toggle" class="menu-overlay" aria-hidden="true"></label>
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

  <!-- Page Title -->
  <div class="page-header">
    <h2>Teacher Portal</h2>
    <p>Evaluate your colleagues and view feedback received from peers</p>
  </div>

  <!-- Verify Status -->
  <div v-if="verified === '1'" class="stats-container">
    <h3>Your account is now verified <span class="checkmark">✔</span></h3>
  </div>

  <div class="stats-container" v-if="(verified === '0') && (active === 'code')">
    <div class="stat-card">
      <h3>Verify your account:</h3>
      <br />
      <button @click="verifyCode" class="verify-btn">Send Code</button>
    </div>
  </div>

  <div class="stats-container" v-if="(verified === '0') && (active === 'input')">
    <div class="stat-card">
      <h3>Verify your account:</h3>
      <br />
      <form method="post" @submit.prevent="verifyInput">
        <input type="text" v-model="verify" class="verify-input" />
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

  <!-- Tabs -->
  <div class="tabs">
    <div class="tab active">Evaluate Colleagues</div>
  </div>

  <!-- Search and Filter Controls -->
  <div class="teacher-controls">
    <div class="search-box">
      <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"></circle>
        <path d="m21 21-4.35-4.35"></path>
      </svg>
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search colleagues by name or subject..."
        class="search-input"
      />
    </div>
    <div class="filter-controls">
      <select v-model="sortBy" class="sort-select">
        <option value="name">Sort by Name</option>
        <option value="subject">Sort by Subject</option>
        <option value="quarter">Sort by Quarter</option>
      </select>
    </div>
  </div>

  <!-- Teacher Cards -->
  <div class="teacher-container">
    <div
      class="teacher-card"
      v-for="(teacher, index) in filteredTeachers"
      :key="`teacher-${teacher.id}-${index}`"
    >
      <h3>{{ teacher.firstname }} {{ teacher.lastname }}</h3>
      <p>{{ teacher.subject }}</p>
      <span class="badge">Q{{ teacher.quarter }} {{ teacher.year }}</span>
      <br><br>
      <button class="btn btn-dark" @click.prevent="$router.push({name: 'teacher-eval', params: {id: teacher.id}})">Start Evaluation</button>
    </div>
    <div v-if="filteredTeachers.length === 0" class="no-results">
      <p>No colleagues found matching your search criteria.</p>
    </div>
  </div>
</template>

<script>
import { removeToken, getToken } from "../../utils/auth";

const url1 = "https://rusiann7.helioho.st";
const url2 = "https://star-panda-literally.ngrok-free.app";

export default {
  name: 'Teacher',
  data() {
    return {
      urlappphp: `${url2}/Getter.php`,
      teachers: [],
      count: 0,
      isLoading: false,
      fullname: JSON.parse(localStorage.getItem("userData") || "{}").fullname || "Teacher Name",
      lastname: JSON.parse(localStorage.getItem("userData") || "{}").lastname || "Teacher Name",
      searchQuery: "",
      sortBy: "name",
      verified: '0',
      active: 'code',
      verify: ''
    }
  },

  computed: {
    filteredTeachers() {
      // Start with a fresh copy of teachers array
      let filtered = this.teachers.slice();

      // Filter by search query
      if (this.searchQuery.trim()) {
        const query = this.searchQuery.toLowerCase().trim();
        filtered = filtered.filter(
          (teacher) =>
            teacher.firstname.toLowerCase().includes(query) ||
            teacher.lastname.toLowerCase().includes(query) ||
            `${teacher.firstname} ${teacher.lastname}`
              .toLowerCase()
              .includes(query) ||
            teacher.subject.toLowerCase().includes(query)
        );
      }

      // Sort the filtered results - create a new sorted array
      const sorted = [...filtered].sort((a, b) => {
        if (this.sortBy === "name") {
          const nameA = `${a.firstname} ${a.lastname}`.toLowerCase();
          const nameB = `${b.firstname} ${b.lastname}`.toLowerCase();
          return nameA.localeCompare(nameB);
        } else if (this.sortBy === "subject") {
          return a.subject.localeCompare(b.subject);
        } else if (this.sortBy === "quarter") {
          if (a.quarter !== b.quarter) {
            return a.quarter - b.quarter;
          }
          return a.year - b.year;
        }
        return 0;
      });

      return sorted;
    },
  },

  methods: {
    async getTeachers() {
      this.isLoading = true;
          
      try {
        const response = await fetch(this.urlappphp, {
          method: 'POST',
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ action: "getTeachers"})
        });

        const result = await response.json();

        if (result.success) {
          this.teachers = result.teachers.map(teacher => ({
            id: teacher.id,
            firstname: teacher.firstname,
            lastname: teacher.lastname,
            subject: teacher.subject,
            quarter: teacher.quarter,
            year: teacher.year
          }));

          this.count = result.total;
          this.isLoading = false;

        } else {
          console.error("Error fetching teachers:", result.message);
        }

      } catch(error) {
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
      this.active = 'input';
    },
    
    verifyInput() {
      // Implementation for verify input
      this.verified = '1';
    }
  },

  mounted() {
    this.getTeachers();
    this.skipLogin();
    this.id = localStorage.getItem("userData") || "";
  }
}
</script>

<style scoped>
/* Global Styles */
* {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

/* Improved Typography - Larger Text */
h1 { font-size: 1.75rem; }
h2 { font-size: 1.5rem; }
h3 { font-size: 1.25rem; }
p, span, label, button, input, select { 
  font-size: 1rem; 
}

@media (min-width: 768px) {
  h1 { font-size: 2rem; }
  h2 { font-size: 1.75rem; }
  h3 { font-size: 1.5rem; }
  p, span, label, button, input, select { 
    font-size: 1.125rem; 
  }
}

@media (min-width: 1024px) {
  h1 { font-size: 2.25rem; }
  h2 { font-size: 2rem; }
  h3 { font-size: 1.75rem; }
}

/* Topbar */
.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.25rem 1.5rem;
  border-bottom: 1px solid #eee;
  flex-wrap: wrap;
  gap: 1rem;
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
  font-weight: 500;
}

.desktop-only {
  display: inline-flex;
}

/* Menu System */
.menu-checkbox {
  display: none;
}

.menu-toggle {
  display: none;
  width: 44px;
  height: 44px;
  border-radius: 10px;
  border: 1px solid #d1d5db;
  background: rgba(255,255,255,0.95);
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  cursor: pointer;
  transition: all 0.2s ease;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 5px;
  position: relative;
  z-index: 45;
}

.menu-toggle span {
  width: 20px;
  height: 2.5px;
  background: #111827;
  border-radius: 999px;
  transition: transform 0.25s ease, opacity 0.25s ease;
}

.menu-panel {
  position: fixed;
  top: 0;
  right: 0;
  width: min(320px, 90%);
  height: 100vh;
  background: #ffffff;
  border-left: 1px solid #e5e7eb;
  box-shadow: -6px 0 24px rgba(15,23,42,0.15);
  padding: 5rem 2rem 2rem;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  transform: translateX(100%);
  opacity: 0;
  pointer-events: none;
  transition: transform 0.3s ease, opacity 0.3s ease;
  z-index: 40;
}

.menu-checkbox:checked ~ .menu-panel {
  transform: translateX(0);
  opacity: 1;
  pointer-events: auto;
}

.menu-checkbox:checked ~ .menu-overlay {
  display: block;
}

.menu-header {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  padding-bottom: 1.5rem;
  border-bottom: 1px solid #e5e7eb;
}

.menu-title {
  font-size: 1.4rem;
  font-weight: 700;
  color: #111827;
}

.menu-subtitle {
  color: #4b5563;
}

.menu-close {
  position: absolute;
  top: 1.5rem;
  right: 1.5rem;
  width: 44px;
  height: 44px;
  border-radius: 10px;
  border: 1px solid #e5e7eb;
  background: #f9fafb;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background 0.2s ease;
  z-index: 41;
}

.menu-close span {
  position: absolute;
  width: 20px;
  height: 2.5px;
  background: #111827;
  border-radius: 999px;
}

.menu-close span:first-child {
  transform: rotate(45deg);
}

.menu-close span:last-child {
  transform: rotate(-45deg);
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

/* Logout Button */
.logout-btn {
  background: #fff;
  border: 1px solid #ccc;
  padding: 0.75rem 1.25rem;
  border-radius: 8px;
  cursor: pointer;
  text-decoration: none;
  color: #000;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  font-weight: 500;
}

.logout-btn:hover {
  background: #f8f9fa;
}

.logout-icon {
  flex-shrink: 0;
  color: #dc2626;
  stroke: #dc2626;
}

.menu-logout {
  width: 100%;
  padding: 1rem;
  border-radius: 12px;
  justify-content: flex-start;
  margin-top: auto;
}

/* Page Header */
.page-header { 
  padding: 2rem 1.5rem 1rem; 
}

.page-header h2 { 
  margin: 0 0 0.75rem; 
}

.page-header p { 
  color: #555; 
  line-height: 1.6;
}

/* Stats Container */
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
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  transition: transform 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-5px);
}

.stat-icon {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

.stat-card h3 { 
  margin: 0.5rem 0; 
  font-size: 2rem;
}

.stat-card p { 
  color: #666; 
  margin: 0;
}

/* Verify Section */
.checkmark {
  color: #10b981;
  font-size: 1.5em;
  vertical-align: middle;
}

.verify-btn {
  background: #000;
  color: #fff;
  border: none;
  padding: 0.875rem 1.75rem;
  border-radius: 10px;
  cursor: pointer;
  font-weight: 600;
  transition: background 0.2s;
  width: 100%;
  font-size: 1rem;
}

.verify-btn:hover {
  background: #333;
}

.verify-input {
  width: 100%;
  padding: 0.875rem;
  border: 1px solid #d1d5db;
  border-radius: 10px;
  margin-bottom: 1rem;
  font-size: 1rem;
}

.verify-input:focus {
  outline: none;
  border-color: #000;
  box-shadow: 0 0 0 3px rgba(0,0,0,0.1);
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

.search-box {
  position: relative;
  display: flex;
  align-items: center;
}

.search-icon {
  position: absolute;
  left: 1rem;
  color: #6b7280;
  pointer-events: none;
}

.search-input {
  width: 100%;
  padding: 1rem 1rem 1rem 3rem;
  border: 1px solid #d1d5db;
  border-radius: 12px;
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
  padding: 1rem;
  border: 1px solid #d1d5db;
  border-radius: 12px;
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
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
  padding: 0 1.5rem 3rem;
}

.teacher-card {
  border: 1px solid #eee;
  border-radius: 16px;
  padding: 1.75rem;
  background: #fff;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.teacher-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}

.teacher-card h3 { 
  margin: 0 0 0.5rem; 
}

.teacher-card p { 
  color: #555; 
  margin: 0 0 1rem; 
  font-weight: 500;
}

.badge {
  display: inline-block;
  background: #f1f3f5;
  padding: 0.5rem 1rem;
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

.no-results p {
  font-size: 1.125rem;
  margin: 0;
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
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
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

@media (max-width: 480px) {
  .topbar {
    padding: 0.875rem;
  }
  
  .logo {
    font-size: 1.125rem;
  }
  
  .stat-card {
    min-width: 100%;
  }
  
  .tabs {
    gap: 0.5rem;
  }
  
  .tab {
    padding: 0.75rem 1rem;
    flex: 1;
    text-align: center;
  }
  
  .teacher-card {
    padding: 1.5rem;
  }
  
  .btn, .verify-btn {
    padding: 0.875rem;
  }
}
</style> 