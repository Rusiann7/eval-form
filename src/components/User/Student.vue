<template>
  <div>
    <div v-if="isLoading" class="loading-screen">
      <div class="loading-spinner"></div>
      <p>Loading...</p>
    </div>

    <header>
      <div class="header-left">
        <input type="checkbox" id="student-nav-toggle" class="menu-checkbox" aria-hidden="true" />
        <div class="title-row">
          <h1>Teacher Evaluation System</h1>
          <div class="title-actions">
            <button class="portal-btn">Student Portal</button>
            <label for="student-nav-toggle" class="menu-toggle" aria-label="Toggle menu">
              <span></span>
              <span></span>
              <span></span>
            </label>
          </div>
        </div>
        <label for="student-nav-toggle" class="menu-overlay" aria-hidden="true"></label>
        <div class="menu-panel" role="dialog" aria-labelledby="student-nav-title">
          <div class="menu-header">
            <p id="student-nav-title" class="menu-title">Student Portal</p>
            <p class="menu-subtitle">Welcome, {{ fullname }} {{ lastname }}</p>
          </div>
          <label for="student-nav-toggle" class="menu-close" aria-label="Close menu"><span></span><span></span></label>
          <button class="logout-btn menu-logout" @click="logout()">Logout</button>
        </div>
      </div>
      <div class="user-section">
        <span class="user-greeting">Welcome, {{ fullname }} {{ lastname }}</span>
        <button class="logout-btn desktop-only" @click="logout()">Logout</button>
      </div>
    </header>

    <main>
      <div class="progress-section">
        <h3>Your Points: {{ count }}</h3>
        <h3>Your Rank: {{ badge }}</h3>
        <p>Track your evaluation completion points</p>
        <div class="progress-bar">
          <div class="progress-fill" :style="{ width: (count / goal) * 100 + '%' }"></div>
        </div>
        <div class="progress-text">{{ count }}/{{ goal }} Points</div>
      </div>

      <h2>My Teachers</h2>
      <p>Evaluate your teachers for this semester. Your feedback helps improve the learning experience.</p>

      <div class="teacher-controls">
        <div class="search-box">
          <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.35-4.35"></path>
          </svg>
          <input type="text" v-model="searchQuery" placeholder="Search teachers by name or subject..." class="search-input" />
        </div>
        <div class="filter-controls">
          <select v-model="sortBy" class="sort-select">
            <option value="name">Sort by Name</option>
            <option value="subject">Sort by Subject</option>
            <option value="quarter">Sort by Quarter</option>
          </select>
          <label class="toggle-label">
            <input type="checkbox" v-model="hideEvaluated" class="toggle-checkbox" />
            <span class="toggle-text">Hide Evaluated</span>
          </label>
        </div>
      </div>

      <div class="teachers">
        <div class="card" v-for="(teacher, index) in filteredTeachers" :key="`teacher-${teacher.id}-${index}`">
          <h3 v-if="teacher.evaluated === 'evaluated'">{{ teacher.firstname }} {{ teacher.lastname }}<span class="checkmark">✔</span></h3>
          <h3 v-else>{{ teacher.firstname }} {{ teacher.lastname }}</h3>
          <p>{{ teacher.subject }}</p>
          <span class="badge">Q{{ teacher.quarter }} {{ teacher.year }}</span>
          <span v-if="teacher.evaluated === 'evaluated'" class="badge evaluated">Evaluated</span>
          <br v-if="teacher.evaluated !== 'evaluated'" />
          <br v-if="teacher.evaluated !== 'evaluated'" />
          <button v-if="teacher.evaluated !== 'evaluated'" class="start" @click.prevent="$router.push({ name: 'student-eval', params: { id: teacher.id } })">Start Evaluation</button>
        </div>
        <div v-if="filteredTeachers.length === 0" class="no-results"><p>No teachers found matching your search criteria.</p></div>
      </div>
    </main>
  </div>
</template>

<script>
import { removeToken, getToken } from "../../utils/auth";

const url2 = "https://star-panda-literally.ngrok-free.app";

export default {
  name: "Student",
  data() {
    return {
      urlappphp: `${url2}/Getter.php`,
      urlappphp2: `${url2}/Getter-f.php`,
      urlappphp3: `${url2}/pointsGetter.php`,
      teachers: [],
      count: 0,
      isLoading: false,
      fullname: JSON.parse(localStorage.getItem("userData") || "{}").fullname || "Student Name",
      lastname: JSON.parse(localStorage.getItem("userData") || "{}").lastname || "Student Name",
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
      let filtered = this.teachers.slice();
      if (this.searchQuery.trim()) {
        const query = this.searchQuery.toLowerCase().trim();
        filtered = filtered.filter(
          (t) =>
            t.firstname.toLowerCase().includes(query) ||
            t.lastname.toLowerCase().includes(query) ||
            `${t.firstname} ${t.lastname}`.toLowerCase().includes(query) ||
            t.subject.toLowerCase().includes(query)
        );
      }
      if (this.hideEvaluated) filtered = filtered.filter((t) => t.evaluated !== "evaluated");
      const sorted = [...filtered].sort((a, b) => {
        if (this.sortBy === "name") return `${a.firstname} ${a.lastname}`.toLowerCase().localeCompare(`${b.firstname} ${b.lastname}`.toLowerCase());
        if (this.sortBy === "subject") return a.subject.localeCompare(b.subject);
        if (this.sortBy === "quarter") return (a.quarter - b.quarter) || (a.year - b.year);
        return 0;
      });
      return sorted;
    },
  },

  methods: {
    async getTeachers() {
      try {
        this.isLoading = true;
        const response = await fetch(this.urlappphp, { method: "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify({ action: "getTeachers", id: this.stid }) });
        const result = await response.json();
        if (result.success) this.teachers = result.teachers.map((teacher) => ({ ...teacher }));
        this.isLoading = false;
      } catch (e) { console.error(e); this.isLoading = false; }
    },

    async getPoints() {
      try {
        this.isLoading = true;
        const response = await fetch(this.urlappphp3, { method: "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify({ action: "getPoints", id: this.stid }) });
        const result = await response.json();
        if (result.success) { this.count = result.points; this.points(); }
        this.isLoading = false;
      } catch (e) { console.error(e); this.isLoading = false; }
    },

    points() {
      if (this.count >= 500) { this.badge = "Maxed"; this.goal = 500; }
      else if (this.count >= 400) { this.badge = "Professional"; this.goal = 500; }
      else if (this.count >= 300) { this.badge = "Expert"; this.goal = 400; }
      else if (this.count >= 200) { this.badge = "Intermediate"; this.goal = 300; }
      else if (this.count >= 100) { this.badge = "Newbie"; this.goal = 200; }
      else { this.badge = "Beginner"; this.goal = 100; }
    },

    logout() { try { removeToken(); this.$router.replace('/'); } catch (e) { console.error(e); } },

    skipLogin() { const token = getToken(); if (!token) this.$router.replace('/new-Dashboard'); },
  },

  mounted() { this.getTeachers(); this.skipLogin(); this.getPoints(); },
};
</script>

<style scoped>
* { margin: 0; padding: 0; box-sizing: border-box; font-family: "Segoe UI", Arial, sans-serif; }
body { background: #f8f9fa; color: #333; line-height: 1.6; font-size: clamp(15px, 1.4vw, 18px); }
header { display:flex; justify-content:space-between; align-items:center; padding:1rem 1.5rem; border-bottom:1px solid #e5e7eb; background:#fff; flex-wrap:wrap; gap:1rem; }
.title-row { display:flex; align-items:center; justify-content:space-between; width:100%; gap:1rem; }
header h1 { font-size:clamp(1.2rem,2.8vw,1.6rem); font-weight:700; }
.portal-btn { background:#f3f4f6; padding:0.6rem 1.1rem; border-radius:12px; font-size:clamp(0.95rem,1.6vw,1.05rem); border:none; }
.menu-toggle { display:none; width:36px; height:36px; border-radius:10px; border:1px solid #e5e7eb; background:rgba(255,255,255,0.95); box-shadow:0 2px 8px rgba(0,0,0,0.08); align-items:center; justify-content:center; flex-direction:column; gap:4px; }
.menu-toggle span { width:16px; height:2px; background:#111827; border-radius:999px; }
.menu-panel { position:fixed; top:0; right:0; width:min(340px,88%); height:100vh; background:#fff; border-left:1px solid #e5e7eb; box-shadow:-6px 0 24px rgba(15,23,42,0.15); padding:4.5rem 1.75rem 2rem; transform:translateX(100%); opacity:0; pointer-events:none; transition:transform .3s, opacity .3s; z-index:40; }
.menu-overlay { display:none; position:fixed; inset:0; background:rgba(17,24,39,0.55); z-index:35; }
.logout-btn { border:none; background:#f3f4f6; padding:.5rem 1rem; border-radius:12px; cursor:pointer; display:inline-flex; align-items:center; gap:.5rem; }
main { padding:1.5rem; max-width:1200px; margin:0 auto; }
main h2 { font-size:clamp(1.4rem,3vw,1.9rem); margin-bottom:.5rem; }
main p { font-size:clamp(0.98rem,1.6vw,1.12rem); color:#6b7280; margin-bottom:1.5rem; }
.teacher-controls { display:flex; flex-direction:column; gap:1rem; margin-bottom:1.5rem; padding:1rem; background:#fff; border:1px solid #e5e7eb; border-radius:12px; }
.search-box { position:relative; display:flex; align-items:center; }
.search-icon { position:absolute; left:.75rem; color:#6b7280; pointer-events:none; }
.search-input { width:100%; padding:.8rem .85rem .8rem 2.6rem; border:1px solid #d1d5db; border-radius:10px; font-size:clamp(0.98rem,1.6vw,1.05rem); }
.filter-controls { display:flex; gap:1rem; align-items:center; flex-wrap:wrap; }
.sort-select { padding:.8rem 1rem; border:1px solid #d1d5db; border-radius:10px; font-size:clamp(0.98rem,1.6vw,1.05rem); background:#fff; cursor:pointer; flex:1; min-width:180px; }
.toggle-label { display:flex; align-items:center; gap:.5rem; }
.toggle-checkbox { width:20px; height:20px; accent-color:#000; }
.no-results { grid-column:1/-1; text-align:center; padding:3rem 1rem; color:#6b7280; }
.teachers { display:grid; grid-template-columns:repeat(auto-fill, minmax(300px,1fr)); gap:1.25rem; }
.card { border:1px solid #ddd; border-radius:12px; padding:1.25rem; background:#fff; box-shadow:0 1px 3px rgba(0,0,0,0.05); }
.card h3 { font-size:clamp(1.02rem,1.8vw,1.18rem); margin-bottom:.5rem; }
.card p { font-size:clamp(0.98rem,1.6vw,1.05rem); color:#666; margin-bottom:.75rem; }
.badge { display:inline-block; padding:.28rem .85rem; font-size:clamp(0.78rem,1.1vw,0.95rem); border-radius:8px; background:#f3f4f6; margin-right:.5rem; margin-bottom:.5rem; }
.badge.evaluated { background:#e5e7eb; color:#333; }
.checkmark { color:#10b981; font-weight:700; margin-left:.5rem; }
.card button { width:100%; padding:.85rem; border:1px solid #ddd; border-radius:10px; cursor:pointer; font-weight:600; font-size:clamp(0.98rem,1.4vw,1.05rem); }
.card .start { background:#000; color:#fff; }
.progress-section { margin-top:2.5rem; border:1px solid #ddd; border-radius:12px; padding:1.25rem; background:#fff; }
.progress-fill { height:100%; background:#000; transition:width .3s ease; }
.progress-text { font-size:clamp(0.9rem,1.2vw,1rem); text-align:right; color:#333; }
.loading-screen { position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.7); display:flex; justify-content:center; align-items:center; flex-direction:column; z-index:3000; color:white; }
.loading-spinner { border:4px solid rgba(255,255,255,0.3); border-radius:50%; border-top:4px solid #fff; width:3.2rem; height:3.2rem; animation:spin 1s linear infinite; margin-bottom:.75rem; }
@keyframes spin { to { transform:rotate(360deg); } }
@media (max-width:768px) { header { padding:1rem; flex-direction:column; align-items:flex-start; } .title-actions .portal-btn { display:none; } .desktop-only { display:none; } .menu-toggle { display:flex; } .teachers { grid-template-columns:1fr; } }
@media (max-width:480px) { header h1 { font-size:clamp(1rem,5vw,1.25rem); } main h2 { font-size:clamp(1.2rem,6vw,1.5rem); } .progress-section { padding:1rem; } }
.sr-only { position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0; }

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
            background: rgba(17,24,39,0.55);
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
            font-size: clamp(1.4rem, 3vw, 1.9rem);
            margin-bottom: 0.5rem;
          }

          main p {
            font-size: clamp(0.98rem, 1.6vw, 1.12rem);
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
            padding: 0.8rem 0.85rem 0.8rem 2.6rem;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: clamp(0.98rem, 1.6vw, 1.05rem);
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
            padding: 0.8rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: clamp(0.98rem, 1.6vw, 1.05rem);
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
            font-size: clamp(0.98rem, 1.4vw, 1.02rem);
            color: #374151;
          }

          .toggle-checkbox {
            width: 20px;
            height: 20px;
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
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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
            font-size: clamp(1.02rem, 1.8vw, 1.18rem);
            margin-bottom: 0.5rem;
          }

          .card p {
            font-size: clamp(0.98rem, 1.6vw, 1.05rem);
            color: #666;
            margin-bottom: 0.75rem;
          }

          /* Badges */
          .badge {
            display: inline-block;
            padding: 0.28rem 0.85rem;
            font-size: clamp(0.78rem, 1.1vw, 0.95rem);
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
            padding: 0.85rem;
            border: 1px solid #ddd;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: clamp(0.98rem, 1.4vw, 1.05rem);
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
            font-size: clamp(1rem, 1.8vw, 1.12rem);
            margin-bottom: 0.5rem;
          }

          .progress-section p {
            font-size: clamp(0.9rem, 1.2vw, 1rem);
            color: #666;
            margin-bottom: 1rem;
          }

          .progress-bar {
            height: 10px;
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
            font-size: clamp(0.9rem, 1.2vw, 1rem);
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
            width: 3.2rem;
            height: 3.2rem;
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
              font-size: clamp(1rem, 5vw, 1.25rem);
            }

            main h2 {
              font-size: clamp(1.2rem, 6vw, 1.5rem);
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
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
}

main p {
  font-size: 0.875rem;
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
  font-size: 1rem;
  margin-bottom: 0.5rem;
}

.card p {
  font-size: 0.875rem;
  color: #666;
  margin-bottom: 0.75rem;
}

/* Badges */
.badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  font-size: 0.75rem;
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
