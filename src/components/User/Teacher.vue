<template>

<!-- Header -->
  <header class="topbar">
    <div>
      <span class="logo">Teacher Evaluation System</span>
      <span class="breadcrumb">Teacher Portal</span>
    </div>
    <div class="user-info">
      <span>Welcome, Teacher User</span>
      <a href="index.html" class="logout-btn">Logout</a>
    </div>
  </header>

  <!-- Page Title -->
  <div class="page-header">
    <h2>Teacher Portal</h2>
    <p>Evaluate your colleagues and view feedback received from peers</p>
  </div>

  <!-- Stats -->
  <div class="stats-container">
    <div class="stat-card">👥<h3>{{ count }}</h3><p>Colleagues</p></div>
    <div class="stat-card">✅<h3>2</h3><p>Completed</p></div>
    <div class="stat-card">📊<h3>4.5</h3><p>Avg Rating</p></div>
    <div class="stat-card">📩<h3>3</h3><p>Received</p></div>
  </div>

  <!-- Tabs -->
  <div class="tabs">
    <div class="tab active">Evaluate Colleagues</div>
    <div class="tab">My Feedback</div>
  </div>

  <!-- Teacher Cards -->
    <div class="teacher-container">
        <div class="teacher-card">
          <h3>Dr. Sarah Johnson</h3><p>Mathematics</p>
          <button class="btn btn-dark">Start Evaluation</button>
        </div>

        <div class="teacher-card" v-for="teacher in teachers" :key="teacher.id">
          <h3>{{ teacher.firstname }} {{ teacher.lastname }}</h3>
          <p>{{teacher.subject}}</p>
          <button class="btn btn-light">Update Evaluation</button>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'Teacher',
        data() {
          return {
            urlappphp: "https://rusiann7.helioho.st/Getter.php",
            teachers: [],
            count: 0,
          }
        },

        methods: {
          async getTeachers() {
            
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
                this.count = result.count;

              }else {
                console.error("Error fetching teachers:", result.message);
              }

            }catch(error){
              console.error("Error fetching teachers:", error);
            }
          }
        },

        mounted(){
          this.getTeachers();
        }
    }

</script>