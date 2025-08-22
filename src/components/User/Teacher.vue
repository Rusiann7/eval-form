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
    <div class="stat-card">👥<h3>5</h3><p>Colleagues</p></div>
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
          <span class="badge">8 years</span>
          <button class="btn btn-dark">Start Evaluation</button>
        </div>

        <div class="teacher-card">
          <h3>Prof. Michael Chen</h3><p>Physics</p>
          <span class="badge">12 years</span>
          <button class="btn btn-light">Update Evaluation</button>
        </div>

        <div class="teacher-card">
          <h3>Ms. Emily Rodriguez</h3><p>English</p>
          <span class="badge">5 years</span>
          <button class="btn btn-dark">Start Evaluation</button>
        </div>

        <div class="teacher-card">
          <h3>Dr. James Wilson</h3><p>Chemistry</p>
          <span class="badge">15 years</span>
          <button class="btn btn-dark">Start Evaluation</button>
        </div>

        <div class="teacher-card">
          <h3>Prof. Lisa Brown</h3><p>Biology</p>
          <span class="badge">10 years</span>
          <button class="btn btn-light">Update Evaluation</button>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'Teacher',
    }

</script>