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
<<<<<<< HEAD
    <p>Evaluate your colleagues and view feedback received from peers</p>
=======
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
>>>>>>> cc803d6 (change button color in teacher)
  </div>

  <!-- Stats -->
  <div class="stats-container">
    <div class="stat-card">👥<h3>{{ this.count }}</h3><p>Colleagues</p></div>
    <div class="stat-card">✅<h3>2</h3><p>Completed</p></div>
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
      <span class="badge">Q{{ teacher.quarter }} {{teacher.year}}</span>
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

const url1 = "https://rusiann7.helioho.st"
const url2 = "https://star-panda-literally.ngrok-free.app"

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

          }else {
            console.error("Error fetching teachers:", result.message);
          }

        }catch(error){
          console.error("Error fetching teachers:", error);
          this.isLoading = false;
        }
      },

      logout() {
        try {
          removeToken();
          this.localUserData = {};
          this.$router.replace("/");
        }catch (error) {
          console.error("Logout error:", error);
        }
      },

      skipLogin(){
        const token = getToken();

        if (!token) {
          console.error("No token found, redirecting to login.");
          this.$router.replace("/new-Dashboard");
        };
      },
    },

    mounted(){
      this.getTeachers();
      this.skipLogin();
      this.id = localStorage.getItem("userData") || "";
    }
  }
</script>
<style scoped>
/* Global */
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

.title-row h1 {
  flex: 1;
}

.title-actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.logo { 
  font-weight: bold;
  font-size: 1.125rem;
  margin: 0;
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

.user-section {
  display: flex;
  align-items: center;
  gap: 1rem;
  font-size: 0.875rem;
  flex-wrap: wrap;
}

.desktop-only {
  display: inline-flex;
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
  background: rgba(255,255,255,0.95);
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
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

.menu-checkbox:checked ~ .menu-toggle {
  display: none;
}

.menu-checkbox:checked ~ .menu-panel {
  transform: translateX(0);
  opacity: 1;
  pointer-events: auto;
}

.menu-checkbox:checked ~ .menu-overlay {
  display: block;
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
  box-shadow: -6px 0 24px rgba(15,23,42,0.15);
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
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
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
  padding: 0.85rem 1rem;
  border-radius: 12px;
  font-size: 0.95rem;
  justify-content: flex-start;
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
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.role-card:hover { 
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.icon {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  border-radius: 50%;
  padding: 1rem;
  display: inline-block;
}

.student { background: #eaf1ff; color: #0066ff; }
.teacher { background: #e9f9ee; color: #2ecc71; }
.admin   { background: #f6eaff; color: #9b59b6; }

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

.btn-admin   { 
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
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
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

/* Teacher Controls */
.teacher-controls {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin: 0 1.5rem 1.5rem;
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
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.teacher-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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

  .teacher-controls {
    margin: 0 1rem 1.5rem;
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
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

<<<<<<< HEAD
</style>
=======
.class-card {
  background-color: #000;
  color: #fff;
  border-radius: 15px;
  padding: 10px;
  cursor: pointer;
}
</style>
>>>>>>> cc803d6 (change button color in teacher)
