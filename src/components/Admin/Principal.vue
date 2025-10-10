<template>

  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

<!-- Header -->
  <header class="topbar">
    <div>
      <span class="logo">Teacher Evaluation System</span>
      <br>
      <span class="breadcrumb">Principal Portal</span>
    </div>
    <div class="user-info">
      <span>Welcome, {{ fullname }}</span>
      <button class="logout-btn" @click="logout()">Logout</button>
    </div>

    <div class="error" v-if="isFailed">
      <span>Task failed to execute!</span>
    </div>

    <div class="success" v-if="isSuccess">
      <span>Task successfully executed!</span>
    </div>

     <!-- Added Navigation Bar -->
  <nav>
    <ul class="sidebar" ref="sidebar">
      <li @click="hideSidebar">
        <a href="#">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            height="26"
            viewBox="0 -960 960 960"
            width="26"
            fill="#e3e3e3"
          >
          <path
            d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"
          />
          </svg>
        </a>

      </li>
      <li><a href="#" @click.prevent="$router.push('/adminHome')">Home</a></li>
      <li><a href="#" @click.prevent="$router.push('/adminPrice')">Price</a></li>
      <li><a href="#" @click.prevent="$router.push('/adminUser')">Users</a></li>
      <li><a href="#" @click.prevent="$router.push('/adminControl')">Control Panel</a></li>
      <li><a href="#" @click.prevent="logout">Log Out</a></li>
    </ul>

    <ul>
      <li>
        <a href="#" @click.prevent="$router.push('/adminHome')"
          >Market Price Tracker-Admin</a>
      </li>
      <li class="hideMobile">
        <a href="#" @click.prevent="$router.push('/adminHome')">Home</a>
      </li>
      <li class="hideMobile">
        <a href="#" @click.prevent="$router.push('/adminPrice')">Price</a>
      </li>
      <li class="hideMobile">
        <a href="#" @click.prevent="$router.push('/adminUser')">Users</a>
      </li>
      <li class="hideMobile">
        <a href="#" @click.prevent="$router.push('/adminControl')">Control Panel</a>
      </li>
      <li class="hideMobile">
        <a href="#" @click.prevent="logout">Log Out</a>
      </li>
      <li class="menu-btn" @click="showSidebar">
        <a href="#">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            height="26"
            viewBox="0 -960 960 960"
            width="26"
            fill="#e3e3e3"
          >
            <path
              d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"
            />
          </svg>
        </a>
      </li>
    </ul>
  </nav>
  </header>

  <!-- Page Header -->    
  <div class="page-header">      
    <h2>Principal Dashboard</h2>
    <p>Manage teacher evaluations and view institutional performance metrics</p>
  </div>

  <!-- Stats -->
  <div class="stats-container">
    <div class="stat-card">👥<h3>{{ this.count }}</h3><p>Teachers</p></div>
    <div class="stat-card">🎓<h3>{{ this.count2 }}</h3><p>Students</p></div>
  </div>

  <!-- Tabs -->
  <div class="tabs">
    <div class="tab" :class="{ active: activeTab === 'student' }" @click="click('student')">Student Evaluations</div>
    <div class="tab" :class="{ active: activeTab === 'teacher' }" @click="click('teacher')">Teacher Evaluations</div>
    <div class="tab" :class="{ active: activeTab === 'evaluate' }" @click="click('evaluate')">Evaluate Teachers</div>
    <div class="tab" :class="{ active: activeTab === 'scheduling' }" @click="click('scheduling')">Create Schedule</div>
    <div class="tab" :class="{ active: activeTab === 'manage' }" @click="click('manage')">Manage Teacher Account</div>
  </div>

  <div v-if="activeModal === 'student'">
    <div class="teacher-header">
      <h3>Student Evaluations</h3>
    </div>

    <div class="teacher-container">
      <div class="card" v-for="newStudent in newStudents" :key="newStudents.id">
        <h3>{{ newStudent.firstname }} {{ newStudent.lastname }}</h3>
        <p>{{newStudent.subject}}</p>
        <span class="badge">Q{{ newStudent.quarter }} {{newStudent.year}}</span>
        <br><br>
        <button class="start" @click.prevent="$router.push({name: 'printable-form', params: {id: newStudent.teacher_id, evtid: newStudent.eval_id}})">View Evaluation</button>
      </div>
    </div>
  </div>

  <div v-if="activeModal === 'evaluate'">
    <!-- Teacher Section -->
    <div class="teacher-header">
      <h3>Evaluate Teachers</h3>
      <select class="dropdown">
        <option>All Departments</option>
        <option>Mathematics</option>
        <option>Physics</option>
        <option>English</option>
        <option>MAPEH</option>
        <option>Science</option>
      </select>
    </div>

    <!-- Teacher Cards -->
    <div class="teacher-container">
      <div class="teacher-card" >
        <h3>Dr. Sarah Johnson</h3>
        <p>Mathematics</p>
        <span class="badge">⭐ 4.2</span>
      </div>

      <div class="card" v-for="teacher in teachers" :key="teacher.id">
        <h3>{{ teacher.firstname }} {{ teacher.lastname }}</h3>
        <p>{{teacher.subject}}</p>
        <span class="badge">Q{{ teacher.quarter }} {{teacher.year}}</span>
        <br><br>
        <button class="start" @click.prevent="$router.push({name: 'teacher-eval', params: {id: teacher.id}})">Start Evaluation</button>
      </div>
    </div>
  </div>

  <div v-if="activeModal === 'teacher'">
    <div class="teacher-header">
      <h3>Teacher Evaluations</h3>
    </div>

    <div class="teacher-container">
      <div class="card" v-for="newteacher in newTeachers" :key="newteacher.id">
        <h3>{{ newteacher.firstname }} {{ newteacher.lastname }}</h3>
        <p>{{newteacher.subject}}</p>
        <span class="badge">Q{{ newteacher.quarter }} {{newteacher.year}}</span>
        <br><br>
        <button class="start" @click.prevent="$router.push({name: 'printable-form1', params: {id: newteacher.teacher_id, evtid: newteacher.evt_id}})">View Evaluation</button>
      </div>
    </div>
  </div>

  <div v-if="activeModal === 'scheduling'">
    <p>WIP to be implemented in Phase 2.</p>
    <p>Feature set:</p>
    <ul>
      <li>Create student schedules based on availability</li>
      <li>Set evaluation periods and deadlines</li>
      <li>Notify teachers and students of upcoming evaluations</li>
      <li>Create room schedules based on availability</li>
    </ul>
  </div>

  <div v-if="activeModal === 'manage'">
    <div class="content">
      <div class="tabs">
        <div class="tab" :class="{ active: activeTab1 === 'crtTeacher' }" @click="click2('crtTeacher')">Create Teachers</div>
        <div class="tab" :class="{ active: activeTab1 === 'rmTeacher' }" @click="click2('rmTeacher')">Remove Teachers</div>
      </div>

      <div class="container" v-if="activeTab1 === 'crtTeacher'">
        <div class="header">
          <h3 class="headText">Create new teacher users</h3>
        </div>

        <form method="post" @submit.prevent="createTeachers()">
          <label for="lsNm">Enter the First Name:</label>
          <input 
            type="text"
            v-model="firstNm"
            placeholder="Enter firstname"
            required 
            class="textField"
          />

          <label for="lsNm">Enter the Last Name:</label>
          <input type="text"
            v-model="lastNm"
            placeholder="Enter lastname"
            required
            class="textField"
          />

          <label for="email">Enter the Email:</label>
          <input type="text"
            v-model="email"
            placeholder="Enter email"
            required
            class="textField"
          />

          <label for="ps">Enter the Password:</label>
          <input type="password"
            v-model="pass"
            placeholder="Enter password"
            required
            class="textField"
          />

          <label for="conps">Confirm the password:</label>
          <input type="password"
            v-model="conpass"
            placeholder="Confirm password"
            required
            class="textField"
          />

          <button type="submit" class="start">Create Teacher</button>
        </form>
      </div>

      <div class="newContainer" v-if="activeTab1 === 'rmTeacher'">
        <div class="card" v-for="teacher in teachers" :key="teacher.id">
          <h3>{{ teacher.firstname }} {{ teacher.lastname }}</h3>
          <p>{{teacher.subject}}</p>
          <span class="badge">Q{{ teacher.quarter }} {{teacher.year}}</span>
          <br><br>
          <button class="start" @click.prevent="rmTeachers(id)">Remove Teacher</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { removeToken, getToken } from "../../utils/auth";

const url1 = "https://rusiann7.helioho.st"
const url2 = "https://star-panda-literally.ngrok-free.app"

  export default {
    name: 'Principal',
    data() {
      return {
        urlappphp: `${url2}/Getter.php`,
        urlappphp2: `${url2}/viewEvaluations.php`,
        urlappphp3: `${url2}/viewEvaluationt.php`,
        teachers: [],
        newTeachers: [],
        newStudents: [],
        count: 0,
        count2: 0,
        isLoading: false,
        isSuccess: true,
        isFailed: false,
        fullname: JSON.parse(localStorage.getItem("userData") || "{}").fullname || "Student Name",
        activeModal: "student",
        activeTab: "student",
        activeTab1: "crtTeacher",
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
                
            this.count = result.total;
            this.isLoading = false;

          }else {
            console.error("Error fetching teachers:", result.message);
            this.isLoading = false;
          }

        }catch(error){
          console.error("Error fetching teachers:", error);
        }
      },

      async getStudentbyid() {
        try {
          this.isLoading = true;

          const response = await fetch(this.urlappphp4, {
            method: "POST",
            headers: {
              "Content-type": "application/json",
            },
            body: JSON.stringify({
              action: "getstudentbyid",
              evt: this.$route.params.evtid,
            }),
          });

          const result = await response.json();

          if (result.success) {
            this.name = result.student;
            this.isLoading = false;
          } else {
            console.log("Server error:", result.message);
          }
        } catch (error) {
          console.log(error);
          this.isLoading = false;
        }
      },

      async getSteval(){
        try{
          this.isLoading = true;

          const response = await fetch(this.urlappphp2, {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({
              action: "getEvaluations",
            })
          });

          const result = await response.json();

          if(result.success){
            this.newStudents = result.evaluations.map(evaluation => ({
              id: evaluation.id,
              teacher_id: evaluation.teacher_id,
              eval_id: evaluation.eval_id,
              firstname: evaluation.teacher.firstname,
              lastname: evaluation.teacher.lastname,
              subject: evaluation.teacher.subject,
              quarter: evaluation.teacher.quarter,
              year: evaluation.teacher.year,
            }));

            this.count2 = result.total;
            this.isLoading = false;
          }

        }catch(error){
          console.log(error);
          this.isLoading = false;
        }
      },

      async getTceval(){
        try{
          this.isLoading = true;

          const response = await fetch(this.urlappphp3, {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({
              action: "getEvaluationt",
            })
          });

          const result = await response.json();

          if(result.success){
            this.newTeachers = result.evaluations.map(evaluation => ({
              id: evaluation.id,
              teacher_id: evaluation.teacher_id,
              eval_id: evaluation.eval_id,
              firstname: evaluation.teacher.firstname,
              lastname: evaluation.teacher.lastname,
              subject: evaluation.teacher.subject,
              quarter: evaluation.teacher.quarter,
              year: evaluation.teacher.year,
            }));

            this.count2 = result.total;
            this.isLoading = false;
          }

        }catch(error){
          console.log(error);
          this.isLoading = false;
        }
      },

      async rmTeachers(id){
        try{
          this.isLoading

          const response = await fetch(this.urlappphp4, {
            method: 'POST',
            headers: {"Content-Type": "application/json" },
            body: JSON.stringify({action: "rmTeachers", id: id})
          });

          const result = await response.json();

          if(result.success){
            this.modal

            this.isLoading = false;
          }

        }catch(error){
          console.error(error)
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

      toggleModal(modal) {
        this.activeModal = modal;  
      },

      click(tabName){
        this.activeTab = tabName;
        this.toggleModal(tabName); // your existing function
      },

      click2(tabName){
        this.activeTab1 = tabName;
        this.activeModal = 'manage';
      },
    },

    mounted() {
      this.getTeachers();
      this.id = localStorage.getItem("userData") || "";
      this.skipLogin();
      this.getSteval();
      this.getTceval();
    }
  };
</script>

<style scoped>

*{
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Global */
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  background: #fff;
  color: #1a1a1a;
}

header {
  text-align: center;
  margin: 40px 0 20px;
}

header h1 {
  font-size: 24px;
  font-weight: bold;
}

header p {
  font-size: 16px;
  color: #555;
}

/* Topbar (for portals) */
.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 40px;
  border-bottom: 1px solid #eee;
  flex-wrap: wrap;
  gap: 15px;
}

.logo { 
  font-weight: bold; 
  font-size: 18px;
}

.breadcrumb {
  background: #f1f3f5;
  padding: 5px 12px;
  border-radius: 8px;
  font-size: 14px;
  margin-left: 10px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 200px;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 15px;
  font-size: 14px;
  flex-wrap: wrap;
}

.logout-btn {
  background: #fff;
  border: 1px solid #ccc;
  padding: 6px 12px;
  border-radius: 6px;
  cursor: pointer;
  text-decoration: none;
  color: #000;
  transition: all 0.2s ease;
  white-space: nowrap;
}

/* Tablet */
@media (max-width: 768px) {
  .topbar {
    padding: 12px 20px;
    gap: 12px;
  }
  
  .logo {
    font-size: 16px;
  }
  
  .breadcrumb {
    font-size: 13px;
    padding: 4px 10px;
    margin-left: 8px;
    max-width: 150px;
  }
  
  .user-info {
    gap: 12px;
    font-size: 13px;
  }
  
  .logout-btn {
    padding: 5px 10px;
    font-size: 13px;
  }
}

/* Mobile */
@media (max-width: 480px) {
  .topbar {
    padding: 10px 16px;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }
  
  .logo-breadcrumb-container {
    display: flex;
    align-items: center;
    width: 100%;
    justify-content: space-between;
  }
  
  .logo {
    font-size: 16px;
  }
  
  .breadcrumb {
    font-size: 12px;
    padding: 4px 8px;
    margin-left: 0;
    max-width: 120px;
  }
  
  .user-info {
    width: 100%;
    justify-content: space-between;
    gap: 8px;
    font-size: 12px;
  }
  
  .logout-btn {
    padding: 4px 8px;
    font-size: 12px;
  }
}

/* Small mobile */
@media (max-width: 360px) {
  .topbar {
    padding: 8px 12px;
  }
  
  .user-info {
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
  }
  
  .logout-btn {
    align-self: stretch;
    text-align: center;
  }
}

/* Large screens */
@media (min-width: 1200px) {
  .topbar {
    padding: 20px 60px;
  }
  
  .logo {
    font-size: 20px;
  }
  
  .breadcrumb {
    font-size: 15px;
    max-width: 300px;
  }
}

/* Role Cards */
.role-container {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin: 40px auto;
  flex-wrap: wrap;
  max-width: 1000px;
}

.role-card {
  background: #fff;
  border: 1px solid #eee;
  border-radius: 12px;
  padding: 30px 20px;
  width: 280px;
  text-align: center;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  transition: transform 0.2s ease;
}

.role-card:hover { transform: translateY(-5px); }

.icon {
  font-size: 40px;
  margin-bottom: 15px;
  border-radius: 50%;
  padding: 15px;
  display: inline-block;
}

.student { background: #eaf1ff; color: #0066ff; }
.teacher { background: #e9f9ee; color: #2ecc71; }
.admin   { background: #f6eaff; color: #9b59b6; }

.role-card h3 { margin: 10px 0 5px; font-size: 18px; }
.role-card p { color: #555; font-size: 14px; margin-bottom: 20px; }

.btn {
  display: inline-block;
  padding: 12px 20px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: bold;
  text-decoration: none;
  cursor: pointer;
  border: none;
}

.btn-student { background: #000; color: #fff; }
.btn-teacher { background: #f1f3f5; color: #000; }
.btn-admin   { background: #fff; border: 1px solid #ccc; color: #000; }

/* Page Headers */
.page-header { padding: 30px 40px 10px; }
.page-header h2 { margin: 0; font-size: 20px; }
.page-header p { color: #555; font-size: 14px; }

/* Stats */
.stats-container {
  display: flex;
  gap: 20px;
  padding: 20px 40px;
  flex-wrap: wrap;
}
.stat-card {
  flex: 1;
  min-width: 150px;
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  text-align: center;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}
.stat-card h3 { margin: 10px 0 0; font-size: 18px; }
.stat-card p { color: #555; font-size: 14px; }

/* Tabs */
.tabs {
  display: flex;
  gap: 8px;
  padding: 0 20px;
  margin: 20px 0;
  flex-wrap: wrap;
  justify-content: center;
}

.tab {
  background: #f1f3f5;
  padding: 8px 16px;
  border-radius: 20px;
  font-size: 14px;
  cursor: pointer;
  text-align: center;
  flex: 1 0 auto;
  min-width: fit-content;
  transition: all 0.2s ease;
}

.tab.active { 
  background: #000; 
  color: #fff; 
}

/* Tablet */
@media (max-width: 768px) {
  .tabs {
    padding: 0 16px;
    gap: 6px;
  }
  
  .tab {
    padding: 6px 12px;
    font-size: 13px;
    flex: 1 0 calc(50% - 6px);
    max-width: calc(50% - 6px);
  }
}

/* Mobile */
@media (max-width: 480px) {
  .tabs {
    padding: 0 12px;
    gap: 4px;
    margin: 16px 0;
  }
  
  .tab {
    padding: 6px 10px;
    font-size: 12px;
    flex: 1 0 100%;
    max-width: 100%;
    border-radius: 12px;
  }
}

/* Large screens */
@media (min-width: 1200px) {
  .tabs {
    padding: 0 60px;
    gap: 12px;
  }
  
  .tab {
    padding: 10px 20px;
    font-size: 15px;
  }
}

/* Teacher Section */
.teacher-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 40px;
  margin-bottom: 20px;
}
.dropdown {
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
}

/* Teacher Cards */
.teacher-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 20px;
  padding: 0 40px 40px;
}
.teacher-card {
  border: 1px solid #eee;
  border-radius: 12px;
  padding: 20px;
  background: #fff;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}
.teacher-card h3 { margin: 0; font-size: 16px; }
.teacher-card p { color: #555; margin: 5px 0 10px; font-size: 14px; }

.badge {
  display: inline-block;
  background: #f1f3f5;
  padding: 4px 10px;
  font-size: 12px;
  border-radius: 20px;
  margin: 0 5px 10px 0;
}
.badge.rating { background: #ffe6e6; color: #c0392b; font-weight: bold; }

.btn-dark { background: #000; color: #fff; }
.btn-light { background: #f1f3f5; color: #000; }

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

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.success, .error {
  position: fixed;
  top: 20px ;
  left: 50%;
  transform: translateX(-50%);
  padding: 20px 30px;
  border-radius: 8px;
  font-weight: 500;
  z-index: 1000;
  text-align: center;
  min-width: 300px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  animation: slideIn 0.3s ease-out, timeout 6s linear forwards;
}

.success {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.error {
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

.success span, .error span {
  display: block;
}

/* Progress bar for timeout */
.success::after, .error::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  height: 4px;
  background: currentColor;
  opacity: 0.3;
  animation: progress 5s linear forwards;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateX(-50%) translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
  }
}

@keyframes timeout {
  0% {
    opacity: 1;
    visibility: visible;
  }
  70% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    visibility: hidden;
  }
}

@keyframes progress {
  0% {
    width: 100%;
  }
  100% {
    width: 0%;
  }
}


nav {
  background-color: #2d333f;
  box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.1);
  position: fixed;
  top: 0;
  z-index: 100;
  margin: 0;
  padding: 0;
  width: 100%;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

nav ul {
  width: 100%;
  list-style: none;
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin: 0;
  padding: 0;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

nav li {
  height: 50px;
  margin: 0;
  padding: 0;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

nav a {
  height: 100%;
  padding: 0 30px;
  text-decoration: none;
  display: flex;
  align-items: center;
  color: #e3e3e3;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  font-weight: 500;
  font-size: 15px;
  letter-spacing: 0.5px;
}

nav li:first-child a {
  font-size: 18px;
  font-weight: 600;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

nav a:hover {
  background-color: #3a4252;
  color: white;
}

nav a:active {
  background-color: #4a5568;  /* pressed state */
}

nav li:first-child {
  margin-right: auto;
}

.sidebar {
  position: fixed;
  top: 0;
  right: 0;
  height: 100vh;
  width: 250px;
  z-index: 999;
  background-color: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  box-shadow: -10px 0 10px rgba(0, 0, 0, 0.1);
  display: none;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  margin: 0;
  padding: 0;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

.sidebar li {
  width: 100%;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

.sidebar a {
  width: 100%;
  font-size: 16px;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

.sidebar a:hover {
  background-color: #3a4252;
}

.menu-btn {
  display: none;
}

.menu-btn:hover {
  background-color: #3a4252;
}

@media (max-width: 800px) {
  .hideMobile {
    display: none;
  }
  .menu-btn {
    display: block;
  }
}

@media (max-width: 400px) {
  .sidebar {
    width: 100%;
  }
}
</style>