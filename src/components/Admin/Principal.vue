<template>

<!-- Header -->
  <header class="topbar">
    <div>
      <span class="logo">Teacher Evaluation System</span>
      <span class="breadcrumb">Principal Portal</span>
    </div>
    <div class="user-info">
      <span>Welcome, Principal User</span>
      <a href="index.html" class="logout-btn">Logout</a>
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
    <div class="stat-card">📊<h3>4.4</h3><p>Avg Rating</p></div>
    <div class="stat-card">⚠️<h3>1</h3><p>Need Attention</p></div>
  </div>

  <!-- Tabs -->
  <div class="tabs">
    <div class="tab active">Teacher Evaluations</div>
    <div class="tab">Department Overview</div>
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
    <div class="teacher-card">
      <h3>Dr. Sarah Johnson</h3><p>Mathematics</p>
      <span class="badge">120 students</span><span class="badge">⭐ 4.2</span>
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
    };

</script>

<style>


</style>