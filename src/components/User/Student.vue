<template>

  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <header>
    <div>
      <h1>Teacher Evaluation System</h1>
      <button class="portal-btn">Student Portal</button>
    </div>
    <div class="user-section">
      <span>Welcome, {{ fullname }} {{ lastname }}</span>
      <button class="logout-btn" @click="logout()">Logout</button>
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
        <div class="progress-fill" :style="{width: ( count / goal * 100 + '%')}"></div>
      </div>
      <div class="progress-text">{{ count }}/{{ goal }} Points</div>
    </div>
    <br>

    <h2>My Teachers</h2>
    <p>Evaluate your teachers for this semester. Your feedback helps improve the learning experience.</p>

    <div class="teachers">
      <!-- Card 1 -->
      <div class="card">
        <h3>Dr. Sarah Johnson <span class="checkmark">✔</span></h3>
        <p>Mathematics</p>
        <span class="badge">Q1 2024</span>
        <span class="badge evaluated">Evaluated</span>
      </div>

      <!-- Card 2 -->
      <div class="card" v-for="teacher in teachers" :key="teacher.id">
        <h3>{{ teacher.firstname }} {{ teacher.lastname }}</h3>
        <p>{{teacher.subject}}</p>
        <span class="badge">Q{{ teacher.quarter }} {{teacher.year}}</span>
        <br><br>
        <button class="start" @click.prevent="$router.push({name: 'student-eval', params: {id: teacher.id}})">Start Evaluation</button>
      </div>
    </div>
  </main>
</template>

<script>  
import { removeToken, getToken } from "../../utils/auth";

const url1 = "https://rusiann7.helioho.st"
const url2 = "https://star-panda-literally.ngrok-free.app"

  export default {
    name: 'Student',
    data() {
      return {
        urlappphp: `${url2}/Getter.php`,
        urlappphp2: `${url2}/Getter-f.php`,
        urlappphp3: `${url2}/pointsGetter.php`,
        teachers: [],
        finishedTeachers: [],
        count: 0,
        isLoading: false,
        fullname: JSON.parse(localStorage.getItem("userData") || "{}").fullname || "Student Name",
        lastname: JSON.parse(localStorage.getItem("userData") || "{}").lastname || "Student Name",
        stid: JSON.parse(localStorage.getItem("userData") || "{}").id || null,
        badge: null,
        goal: 0
      }
    },

    methods: {

      async getTeachers() {
        try {
          this.isLoading = true;

          const response = await fetch(this.urlappphp, {
            method: 'POST',
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ action: "getTeachers", id: this.stid})
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
                
            this.count = result.points;
            this.points();
            this.isLoading = false;

          }else {
            console.error("Error fetching teachers:", result.message);
            this.isLoading = false;
          }

        }catch(error){
          console.error("Error fetching teachers:", error);
        }
      },

      async getTeachersCompleted() {
        try {
          this.isLoading = true;

          const response = await fetch(this.urlappphp2, {
            method: 'POST',
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ action: "getTeachersCompleted", id: this.stid})
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
                
            this.isLoading = false;

          }else {
            console.error("Error fetching teachers:", result.message);
            this.isLoading = false;
          }

        }catch(error){
          console.error("Error fetching teachers:", error);
        }
      },

      async getPoints(){
        try {
          this.isLoading = true;

          const response = await fetch(this.urlappphp3, {
            method: 'POST',
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ action: "getPoints", id: this.stid})
          });

          const result = await response.json();

          if (result.success) {
                
            this.count = result.points;
            this.points();
            this.isLoading = false;

          }else {
            console.error("Error fetching ponts:", result.message);
            this.isLoading = false;
          }

        }catch(error){
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
        }catch (error) {
          console.error("Logout error:", error);
        }
      },

      skipLogin(){
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
    }
  }
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', Arial, sans-serif;
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

header h1 {
  font-size: 1.25rem;
  font-weight: bold;
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

.logout-btn {
  border: none;
  background: #f3f4f6;
  padding: 0.5rem 1rem;
  border-radius: 12px;
  cursor: pointer;
  transition: background 0.2s;
}

.logout-btn:hover {
  background: #e5e7eb;
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
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
  transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
  header {
    padding: 1rem;
    flex-direction: column;
    align-items: flex-start;
  }
  
  .user-section {
    width: 100%;
    justify-content: space-between;
  }
  
  main {
    padding: 1rem;
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