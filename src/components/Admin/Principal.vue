<template>

<!-- Header -->
  <header class="topbar">
    <div>
      <span class="logo">Teacher Evaluation System</span>
      <span class="breadcrumb">Principal Portal</span>
    </div>
    <div class="user-info">
      <span>Welcome, Principal User</span>
      <button class="logout-btn" @click="logout()">Logout</button>
    </div>
  </header>

  <!-- Page Header -->    
  <div class="page-header">      
    <h2>Principal Dashboard</h2>
    <p>Manage teacher evaluations and view institutional performance metrics</p>
  </div>

  <!-- Stats -->
  <div class="stats-container">
    <div class="stat-card">👥<h3>5</h3><p>Teachers</p></div>
    <div class="stat-card">🎓<h3>560</h3><p>Students</p></div>
  </div>

  <!-- Tabs -->
  <div class="tabs">
    <div class="tab active">Student Evaluations</div>
    <div class="tab"> Teacher Evaluations</div>
    <div class="tab">Peer Overview</div>
  </div>

  <!-- Teacher Section -->
  <div class="teacher-header">
    <h3>Teacher Evaluations</h3>
    <select class="dropdown">
      <option>All Departments</option>
      <option>Mathematics</option>
      <option>Physics</option>
      <option>English</option>
      <option>Chemistry</option>
      <option>Biology</option>
    </select>
  </div>

  <!-- Teacher Cards -->
  <div class="teacher-container">
    <div class="teacher-card" v-for="value in source">
      <h3>Dr. Sarah Johnson</h3>
      <p>Mathematics</p>
      <span class="badge">⭐ 4.2</span>
      <button class="btn btn-light">Update Evaluation</button>
    </div>
  </div>
</template>

<script>

  export default {
    name: 'Principal',
    data() {
      return {

      }
    },

    method: {

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
}

.logo { font-weight: bold; }
.breadcrumb {
  background: #f1f3f5;
  padding: 5px 12px;
  border-radius: 8px;
  font-size: 14px;
  margin-left: 10px;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 15px;
  font-size: 14px;
}

.logout-btn {
  background: #fff;
  border: 1px solid #ccc;
  padding: 6px 12px;
  border-radius: 6px;
  cursor: pointer;
  text-decoration: none;
  color: #000;
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
  gap: 10px;
  padding: 0 40px;
  margin: 20px 0;
}
.tab {
  background: #f1f3f5;
  padding: 8px 16px;
  border-radius: 20px;
  font-size: 14px;
  cursor: pointer;
}
.tab.active { background: #000; color: #fff; }

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

</style>