<template>

  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <header>
    <div>
      <h1>Teacher Evaluation System</h1>
      <button class="portal-btn" @click="$router.push('/')">Student Portal</button>
    </div>
    <div class="user-section">
      <span>Welcome, {{ fullname }}</span>
      <button class="logout-btn" @click="logout()">Logout</button>
    </div>
  </header>

  <!-- Main Content -->
  <main>
    <h2>My Teachers</h2>
    <p>Evaluate your teachers for this semester. Your feedback helps improve the learning experience.</p>

    <div class="teachers">
      <!-- Card 1 -->
      <div class="card">
        <h3>Dr. Sarah Johnson <span class="checkmark">✔</span></h3>
        <p>Mathematics</p>
        <span class="badge">Q1 2024</span>
        <span class="badge evaluated">Evaluated</span>
        <br><br>
        <button class="update">⭐ Update Evaluation</button>
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

    <!-- Progress Section -->
    <div class="progress-section">
      <h3>Evaluation Progress</h3>
      <p>Track your evaluation completion status</p>
      <div class="progress-bar">
        <div class="progress-fill" :style="{width: ( 5 / count * 100 + '%')}"></div>
      </div>
      <div class="progress-text">2/{{ count }} completed</div>
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
        teachers: [],
        count: 0,
        isLoading: false,
        fullname: JSON.parse(localStorage.getItem("userData") || "{}").fullname || "Student Name",
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
                
            this.count = result.count;
            this.isLoading = false;

          }else {
            console.error("Error fetching teachers:", result.message);
            this.isLoading = false;
          }

        }catch(error){
          console.error("Error fetching teachers:", error);
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
    }
  }
</script>

<style scoped>

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: Arial, sans-serif;
}

body {
  background: #fff;
  color: #333;
}

/* Navbar */
header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 40px;
  border-bottom: 1px solid #ddd;
}

header h1 {
  font-size: 18px;
  font-weight: bold;
}

.portal-btn {
  background: #f3f4f6;
  padding: 5px 12px;
  border-radius: 12px;
  font-size: 12px;
  cursor: pointer;
  border: none;
}

.user-section {
  display: flex;
  align-items: center;
  gap: 15px;
}

.logout-btn {
  border: none;
  background: #f3f4f6;
  padding: 6px 14px;
  border-radius: 12px;
  cursor: pointer;
}

main {
  padding: 30px 40px;
}

main h2 {
  font-size: 22px;
  margin-bottom: 8px;
}

main p {
  font-size: 14px;
  color: #555;
  margin-bottom: 25px;
}

.teachers {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 20px;
}

.card {
  border: 1px solid #ddd;
  border-radius: 12px;
  padding: 20px;
  background: #fff;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.card h3 {
  font-size: 16px;
  margin-bottom: 5px;
}

.card p {
  font-size: 14px;
  color: #666;
  margin-bottom: 10px;
}

.badge {
  display: inline-block;
  padding: 4px 10px;
  font-size: 12px;
  border-radius: 8px;
  background: #f3f4f6;
  margin-right: 5px;
}

.badge.evaluated {
  background: #e5e7eb;
  color: #333;
}

.checkmark {
  color: green;
  font-weight: bold;
  margin-left: 6px;
}

.card button {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 8px;
  cursor: pointer;
  font-weight: bold;
  font-size: 14px;
}

.card .start {
  background: #000;
  color: #fff;
}

.card .update {
  background: #fff;
  color: #333;
}

.progress-section {
  margin-top: 40px;
  border: 1px solid #ddd;
  border-radius: 12px;
  padding: 20px;
}

.progress-section h3 {
  font-size: 16px;
  margin-bottom: 5px;
}

.progress-section p {
  font-size: 13px;
  color: #666;
  margin-bottom: 15px;
}

.progress-bar {
  height: 8px;
  border-radius: 6px;
  background: #e5e7eb;
  overflow: hidden;
  margin-bottom: 8px;
}

.progress-fill {
  height: 100%;
  background: #000;
}

.progress-text {
  font-size: 13px;
  text-align: right;
  color: #333;
}

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
  margin-bottom: 10px;
  z-index: 3000;
}
</style>