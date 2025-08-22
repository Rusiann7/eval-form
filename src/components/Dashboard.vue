<template>
    <header>
        <h1>Teacher Evaluation System</h1>
        <p>Select your role to access the evaluation platform</p>
      </header>

      <div class="role-container">
        <div class="role-card">
          <div class="icon student">🎓</div>
          <h3>Student</h3>
          <p>Evaluate your teachers and provide feedback</p>
          <router-link to="/student" class="btn btn-student">Access Student Portal</router-link>
        </div>

        <div class="role-card">
          <div class="icon teacher">👥</div>
          <h3>Teacher</h3>
          <p>Evaluate your colleagues and peers</p>
          <router-link to="/teacher" class="btn btn-teacher">Access Teacher Portal</router-link>
        </div>

        <div class="role-card">
          <div class="icon admin">👑</div>
          <h3>Principal/Supervisor</h3>
          <p>Evaluate teachers and manage assessments</p>
          <router-link to="/principal" class="btn btn-admin">Access Admin Portal</router-link>
        </div>
      </div>
</template>

<script>

    export default {
      name: 'Dashboard',
    };

</script>

<style>

/* Global */
body {
  font-family: Arial, sans-serif;
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