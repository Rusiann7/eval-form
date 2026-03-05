<template>
  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <header>
    <div class="header-left">
      <input
        type="checkbox"
        id="student-nav-toggle"
        class="menu-checkbox"
        aria-hidden="true"
      />
      <div class="title-row">
        <h1>Teacher Evaluation System</h1>
        <div class="title-actions">
          <button class="portal-btn">Student Portal</button>
          <label
            for="student-nav-toggle"
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
        for="student-nav-toggle"
        class="menu-overlay"
        aria-hidden="true"
      ></label>
      <div class="menu-panel" role="dialog" aria-labelledby="student-nav-title">
        <div class="menu-header">
          <p id="student-nav-title" class="menu-title">Student Portal</p>
          <p class="menu-subtitle">Welcome, {{ fullname }} {{ lastname }}</p>
        </div>
        <label
          for="student-nav-toggle"
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

  <!-- Main Content -->
  <main>
    <!-- Points Section -->
    <div class="progress-section">
      <h3>Your Points: {{ count }}</h3>
      <h3>Your Rank: {{ badge }}</h3>
      <p>Track your evaluation completion points</p>
      <div class="progress-bar">
        <div
          class="progress-fill"
          :style="{ width: (count / goal) * 10 + '%' }"
        ></div>
      </div>
      <div class="progress-text">{{ count }}/{{ goal }} Points</div>
    </div>
    <br />

    <h2>My Teachers</h2>
    <p>
      Evaluate your teachers for this semester. Your feedback helps improve the
      learning experience.
    </p>

    <!-- Search and Filter Controls -->
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

    <div class="teachers">
      <div
        class="card"
        v-for="(teacher, index) in filteredTeachers"
        :key="`teacher-${teacher.id}-${index}`"
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
            $router.push({ name: 'student-eval', params: { id: teacher.id } })
          "
        >
          Start Evaluation
        </button>
      </div>
      <div v-if="filteredTeachers.length === 0" class="no-results">
        <p>No teachers found matching your search criteria.</p>
      </div>
    </div>
  </main>
</template>

<script>
import { removeToken, getToken } from "../../utils/auth";

const url1 = "https://rusiann7.helioho.st";
//const url2 = "https://star-panda-literally.ngrok-free.app";
const url2 = "http://localhost:8080";

export default {
  name: "Student",
  data() {
    return {
      urlappphp: `${url2}/Getter.php`,
      urlappphp2: `${url2}/Getter-f.php`,
      urlappphp3: `${url2}/pointsGetter.php`,
      teachers: [],
      finishedTeachers: [],
      count: 0,
      isLoading: false,
      fullname:
        JSON.parse(localStorage.getItem("userData") || "{}").fullname ||
        "Student Name",
      lastname:
        JSON.parse(localStorage.getItem("userData") || "{}").lastname ||
        "Student Name",
      stid: JSON.parse(localStorage.getItem("userData") || "{}").id || null,
      badge: null,
      goal: 0,
      searchQuery: "",
      sortBy: "name",
      hideEvaluated: false,
    };
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

      // I filter out evaluated if hideEvaluated is true
      if (this.hideEvaluated) {
        filtered = filtered.filter(
          (teacher) => teacher.evaluated !== "evaluated"
        );
      }

      // Pang sort ng mga teachers
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
      try {
        this.isLoading = true;

        const response = await fetch(this.urlappphp, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ action: "getTeachers", id: this.stid }),
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

          //this.count = result.points;
          this.isLoading = false;
        } else {
          console.error("Error fetching teachers:", result.message);
          this.isLoading = false;
        }
      } catch (error) {
        console.error("Error fetching teachers:", error);
      }
    },

    async getTeachersCompleted() {
      try {
        this.isLoading = true;

        const response = await fetch(this.urlappphp2, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            action: "getTeachersCompleted",
            id: this.stid,
          }),
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

          this.isLoading = false;
        } else {
          console.error("Error fetching teachers:", result.message);
          this.isLoading = false;
        }
      } catch (error) {
        console.error("Error fetching teachers:", error);
      }
    },

    async getPoints() {
      try {
        this.isLoading = true;

        const response = await fetch(this.urlappphp3, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ action: "getPoints", id: this.stid }),
        });

        const result = await response.json();

        if (result.success) {
          this.count = result.points;
          this.points();
          this.isLoading = false;
        } else {
          console.error("Error fetching ponts:", result.message);
          this.isLoading = false;
        }
      } catch (error) {
        console.error("Error fetching points:", error);
      }
    },

    points() {
      if (this.count >= 500) {
        this.badge = "Maxed";
        this.goal = 500;
      } else if (this.count >= 400) {
        this.badge = "Professional";
        this.goal = 500;
      } else if (this.count >= 300) {
        this.badge = "Expert";
        this.goal = 400;
      } else if (this.count >= 200) {
        this.badge = "Intermediate";
        this.goal = 300;
      } else if (this.count >= 100) {
        this.badge = "Newbie";
        this.goal = 200;
      } else {
        this.badge = "Beginner";
        this.goal = 100;
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
        return;
      }
    },
  },

  mounted() {
    this.getTeachers();
    this.id = localStorage.getItem("userData") || "";
    this.skipLogin();
    this.getPoints();
  },
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Segoe UI", Arial, sans-serif;
}

body {
  background: #f8f9fa;
  color: #333;
  line-height: 1.6;
}

/* Header */
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

.user-section {
  display: flex;
  align-items: center;
  gap: 1rem;
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

.menu-checkbox:checked ~ .title-row .menu-toggle {
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
  text-align: left;
}

.menu-checkbox:checked + .menu-toggle span:nth-child(1) {
  transform: translateY(6px) rotate(45deg);
}

.menu-checkbox:checked + .menu-toggle span:nth-child(2) {
  opacity: 0;
}

.menu-checkbox:checked + .menu-toggle span:nth-child(3) {
  transform: translateY(-6px) rotate(-45deg);
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

/* Main Content */
main {
  padding: 1.5rem;
  max-width: 1200px;
  margin: 0 auto;
}

main h2 {
  font-size: 1.65rem;
  margin-bottom: 0.5rem;
}

main p {
  font-size: 0.975rem;
  color: #555;
  margin-bottom: 1.5rem;
}

/* Teacher Controls */
.teacher-controls {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-bottom: 1.5rem;
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

/* Teachers Grid */
.teachers {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 1.25rem;
}

/* Cards */
.card {
  border: 1px solid #ddd;
  border-radius: 12px;
  padding: 1.25rem;
  background: #fff;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.card h3 {
  font-size: 1.05rem;
  margin-bottom: 0.5rem;
}

.card p {
  font-size: 0.95rem;
  color: #666;
  margin-bottom: 0.75rem;
}

/* Badges */
.badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  font-size: 0.82rem;
  border-radius: 8px;
  background: #f3f4f6;
  margin-right: 0.5rem;
  margin-bottom: 0.5rem;
}

.badge.evaluated {
  background: #e5e7eb;
  color: #333;
}

.checkmark {
  color: #10b981;
  font-weight: bold;
  margin-left: 0.5rem;
}

/* Buttons */
.card button {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  font-size: 0.875rem;
  transition: all 0.2s;
}

.card .start {
  background: #000;
  color: #fff;
}

.card .start:hover {
  background: #333;
}

.card .update {
  background: #fff;
  color: #333;
}

.card .update:hover {
  background: #f9fafb;
}

/* Progress Section */
.progress-section {
  margin-top: 2.5rem;
  border: 1px solid #ddd;
  border-radius: 12px;
  padding: 1.25rem;
  background: #fff;
}

.progress-section h3 {
  font-size: 1rem;
  margin-bottom: 0.5rem;
}

.progress-section p {
  font-size: 0.8125rem;
  color: #666;
  margin-bottom: 1rem;
}

.progress-bar {
  height: 8px;
  border-radius: 6px;
  background: #e5e7eb;
  overflow: hidden;
  margin-bottom: 0.5rem;
}

.progress-fill {
  height: 100%;
  background: #000;
  transition: width 0.3s ease;
}

.progress-text {
  font-size: 0.8125rem;
  text-align: right;
  color: #333;
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

  .menu-checkbox:checked ~ .title-row .menu-toggle {
    display: none !important;
  }

  .user-greeting {
    display: none;
  }

  main {
    padding: 1rem;
  }

  .teacher-controls {
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

  .teachers {
    grid-template-columns: 1fr;
    gap: 1rem;
  }

  .card {
    padding: 1rem;
  }
}

@media (max-width: 480px) {
  header h1 {
    font-size: 1.125rem;
  }

  main h2 {
    font-size: 1.25rem;
  }

  .user-section {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.75rem;
  }

  .progress-section {
    padding: 1rem;
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
</style>
