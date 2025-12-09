<template>
<<<<<<< HEAD
  <!-- Header with Toggle Button -->
  <header class="topbar">
    <div class="header-left">
      <div class="title-row">
        <h1 class="logo">Teacher Evaluation System</h1>
        <div class="title-actions">
          <button class="portal-btn">Test Portal</button>
          <button class="toggle-btn" @click="toggle = !toggle">
            <span class="material-icons-outlined">
              {{ toggle ? 'close' : 'menu' }}
            </span>
            {{ toggle ? 'Close' : 'Menu' }}
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- Sidebar Overlay -->
  <div class="overlay" v-if="toggle" @click="toggle = false"></div>

  <!-- Sidebar -->
  <div class="side-bar" :class="{ 'active': toggle }">
    <div class="sidebar-header">
      <h3 class="sidebar-title">Test Portal</h3>
      <button class="sidebar-close" @click="toggle = false" aria-label="Close menu">
        <span class="material-icons-outlined">close</span>
      </button>
    </div>
    
    <div class="menu">
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu1 = !showMenu1">
          <span class="menu-text">Student</span>
          <span class="chevron-icon" :class="{ 'rotated': showMenu1 }">
            <span class="material-icons-outlined">expand_more</span>
          </span>
        </a>
        <div class="sub-menu" v-if="showMenu1">
          <a href="#" class="sub-item">Merged Answers</a>
          <a href="#" class="sub-item">Individual Answers</a>
        </div>
      </div>
      
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu2 = !showMenu2">
          <span class="menu-text">Teacher</span>
          <span class="chevron-icon" :class="{ 'rotated': showMenu2 }">
            <span class="material-icons-outlined">expand_more</span>
          </span>
        </a>
        <div class="sub-menu" v-if="showMenu2">
          <a href="#" class="sub-item">Merged Answers</a>
          <a href="#" class="sub-item">Individual Answers</a>
        </div>
      </div>
      
      <div class="item">
        <a href="#" class="menu-link">Scheduler</a>
      </div>
      
      <div class="item">
        <a href="#" class="menu-link">File Upload</a>
      </div>
      
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu3 = !showMenu3">
          <span class="menu-text">Accounts</span>
          <span class="chevron-icon" :class="{ 'rotated': showMenu3 }">
            <span class="material-icons-outlined">expand_more</span>
          </span>
        </a>
        <div class="sub-menu" v-if="showMenu3">
          <a href="#" class="sub-item">Add Teachers</a>
          <a href="#" class="sub-item">Delete Users</a>
        </div>
      </div>
      
      <div class="item">
        <a href="#" class="menu-link">Question Change</a>
      </div>
    </div>
    
    <div class="sidebar-footer">
      <button class="logout-btn sidebar-logout">
        <span class="material-icons-outlined logout-icon">logout</span>
        Logout
      </button>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content" :class="{ 'sidebar-active': toggle }">
    <div class="content">
      <div class="info-area">
        <h1>Welcome to the Teacher Evaluation System</h1>
        <p class="subtitle">Manage student and teacher evaluations, schedules, and account management from this portal</p>
        
        <div class="dashboard-cards">
          <div class="dashboard-card">
            <span class="card-icon">👥</span>
            <h3>Student Management</h3>
            <p>View and manage student evaluations and answers</p>
          </div>
          
          <div class="dashboard-card">
            <span class="card-icon">👨‍🏫</span>
            <h3>Teacher Management</h3>
            <p>Handle teacher evaluations and account management</p>
          </div>
          
          <div class="dashboard-card">
            <span class="card-icon">📅</span>
            <h3>Scheduler</h3>
            <p>Set evaluation schedules and deadlines</p>
          </div>
          
          <div class="dashboard-card">
            <span class="card-icon">📁</span>
            <h3>File Upload</h3>
            <p>Upload and manage system files and documents</p>
=======
  <div class="app-container">
    <button class="toggle-btn" @click="toggle = !toggle">
      <span class="material-icons">{{ toggle ? 'close' : 'menu' }}</span>
      {{ toggle ? 'Close Sidebar' : 'Open Sidebar' }}
    </button>

    <transition name="sidebar">
      <div class="side-bar" v-if="toggle">
        <div class="menu">
          <div class="item">
            <a href="#" class="sub-btn" @click.stop="showMenu1 = !showMenu1">
              <span class="material-icons">school</span>
              <span>Student</span>
              <span class="material-icons dropdown-icon">
                {{ showMenu1 ? 'expand_less' : 'expand_more' }}
              </span>
            </a>
            <transition name="submenu">
              <div class="sub-menu" v-if="showMenu1">
                <a href="#" class="sub-item">
                  <span class="material-icons">merge</span>
                  Merged Answers
                </a>
                <a href="#" class="sub-item">
                  <span class="material-icons">person</span>
                  Individual Answers
                </a>
              </div>
            </transition>
          </div>
          
          <div class="item">
            <a href="#" class="sub-btn" @click.stop="showMenu2 = !showMenu2">
              <span class="material-icons">person</span>
              <span>Teacher</span>
              <span class="material-icons dropdown-icon">
                {{ showMenu2 ? 'expand_less' : 'expand_more' }}
              </span>
            </a>
            <transition name="submenu">
              <div class="sub-menu" v-if="showMenu2">
                <a href="#" class="sub-item">
                  <span class="material-icons">merge</span>
                  Merged Answers
                </a>
                <a href="#" class="sub-item">
                  <span class="material-icons">person</span>
                  Individual Answers
                </a>
              </div>
            </transition>
          </div>
          
          <div class="item">
            <a href="#">
              <span class="material-icons">schedule</span>
              <span>Scheduler</span>
            </a>
          </div>
          
          <div class="item">
            <a href="#">
              <span class="material-icons">cloud_upload</span>
              <span>File Upload</span>
            </a>
          </div>
          
          <div class="item">
            <a href="#" class="sub-btn" @click.stop="showMenu3 = !showMenu3">
              <span class="material-icons">account_circle</span>
              <span>Accounts</span>
              <span class="material-icons dropdown-icon">
                {{ showMenu3 ? 'expand_less' : 'expand_more' }}
              </span>
            </a>
            <transition name="submenu">
              <div class="sub-menu" v-if="showMenu3">
                <a href="#" class="sub-item">
                  <span class="material-icons">person_add</span>
                  Add Teachers
                </a>
                <a href="#" class="sub-item">
                  <span class="material-icons">person_remove</span>
                  Delete Users
                </a>
              </div>
            </transition>
          </div>
          
          <div class="item">
            <a href="#">
              <span class="material-icons">help</span>
              <span>Question Change</span>
            </a>
          </div>
        </div>
      </div>
    </transition>

    <div class="content" :class="{ 'sidebar-open': toggle }">
      <div class="main">
        <div class="info-area">
          <h1 class="welcome-title">Welcome to the Dashboard</h1>
          <p class="welcome-text">Select an option from the sidebar to get started.</p>
          <div class="stats-grid">
            <div class="stat-card">
              <span class="material-icons stat-icon">school</span>
              <h3>Students</h3>
              <p class="stat-number">245</p>
            </div>
            <div class="stat-card">
              <span class="material-icons stat-icon">person</span>
              <h3>Teachers</h3>
              <p class="stat-number">42</p>
            </div>
            <div class="stat-card">
              <span class="material-icons stat-icon">assignment</span>
              <h3>Evaluations</h3>
              <p class="stat-number">1,245</p>
            </div>
            <div class="stat-card">
              <span class="material-icons stat-icon">trending_up</span>
              <h3>Active</h3>
              <p class="stat-number">98%</p>
            </div>
>>>>>>> Development
          </div>
        </div>
      </div>
    </div>
    
    <!-- Overlay for mobile -->
    <transition name="fade">
      <div class="overlay" v-if="toggle" @click="toggle = false"></div>
    </transition>
  </div>
</template>

<script>
export default {
<<<<<<< HEAD
  name: "TestSidebar",
=======
  name: "SidebarComponent",
>>>>>>> Development
  data() {
    return {
      showMenu1: false,
      showMenu2: false,
      showMenu3: false,
      toggle: false,
    };
  },
};
</script>

<style scoped>
<<<<<<< HEAD
/* ===== CSS RESET & BASE STYLES ===== */
=======
>>>>>>> Development
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

<<<<<<< HEAD
body {
  font-size: 16px;
  line-height: 1.6;
  background: #f9fafb;
  color: #1a1a1a;
}

/* ===== IMPROVED TYPOGRAPHY - LARGER TEXT ===== */
h1 { font-size: 1.875rem; }
h2 { font-size: 1.625rem; }
h3 { font-size: 1.375rem; }
p, span, label, button, input, select, a { 
  font-size: 1.0625rem; 
}

@media (min-width: 768px) {
  h1 { font-size: 2.25rem; }
  h2 { font-size: 2rem; }
  h3 { font-size: 1.75rem; }
  p, span, label, button, input, select, a { 
    font-size: 1.125rem; 
  }
}

@media (min-width: 1024px) {
  h1 { font-size: 2.5rem; }
  h2 { font-size: 2.25rem; }
  h3 { font-size: 2rem; }
  p, span, label, button, input, select, a { 
    font-size: 1.25rem; 
  }
}

/* ===== TOPBAR STYLES ===== */
.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.25rem 1.5rem;
  border-bottom: 1px solid #e5e7eb;
  background: white;
  z-index: 30;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.header-left {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  flex-wrap: wrap;
  width: 100%;
}

.title-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  gap: 1rem;
}

.logo {
  font-weight: bold;
  color: #111827;
  font-size: 1.25rem;
  margin: 0;
}

.title-actions {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.portal-btn {
  background: #f3f4f6;
  padding: 0.75rem 1.25rem;
  border-radius: 12px;
  cursor: pointer;
  border: none;
  transition: background 0.2s;
  white-space: nowrap;
  font-weight: 500;
  font-size: 1.0625rem;
}

.portal-btn:hover {
  background: #e5e7eb;
}

.toggle-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.25rem;
  background: #000;
  color: white;
  border: none;
  border-radius: 12px;
  cursor: pointer;
  font-weight: 500;
  font-size: 1.0625rem;
  transition: background 0.3s ease;
}

.toggle-btn:hover {
  background: #1a1a1a;
}

/* ===== SIDEBAR STYLES ===== */
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(17, 24, 39, 0.55);
  backdrop-filter: blur(1px);
  z-index: 35;
  cursor: pointer;
=======
.app-container {
  min-height: 100vh;
  position: relative;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
}

/* Toggle Button */
.toggle-btn {
  position: fixed;
  top: 1rem;
  left: 1rem;
  z-index: 1001;
  padding: 0.75rem 1.25rem;
  background: #0f172a;
  color: white;
  border: none;
  border-radius: 0.5rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 1rem;
  font-weight: 500;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
>>>>>>> Development
}

.toggle-btn:hover {
  background: #1e293b;
  transform: translateY(-2px);
  box-shadow: 0 6px 8px -1px rgba(0, 0, 0, 0.15);
}

.toggle-btn .material-icons {
  font-size: 1.25rem;
}

/* Sidebar Styles */
.side-bar {
<<<<<<< HEAD
  background: #ffffff;
  width: 320px;
=======
  background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
  width: 280px;
>>>>>>> Development
  height: 100vh;
  position: fixed;
  top: 0;
  left: -320px;
  overflow-y: auto;
<<<<<<< HEAD
  z-index: 40;
  border-right: 1px solid #e5e7eb;
  box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
  display: flex;
  flex-direction: column;
  transition: left 0.3s ease;
=======
  z-index: 1000;
  box-shadow: 4px 0 20px rgba(0, 0, 0, 0.2);
}

.sidebar-enter-active,
.sidebar-leave-active {
  transition: transform 0.3s ease;
}

.sidebar-enter-from,
.sidebar-leave-to {
  transform: translateX(-100%);
}

.sidebar-enter-to,
.sidebar-leave-from {
  transform: translateX(0);
>>>>>>> Development
}

.side-bar.active {
  left: 0;
}

.sidebar-header {
  padding: 1.75rem 1.5rem;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #f9fafb;
  position: relative;
}

.sidebar-title {
  font-size: 1.375rem;
  font-weight: 700;
  color: #111827;
  margin: 0;
}

.sidebar-close {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  border: 1px solid #e5e7eb;
  background: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background 0.2s ease, border-color 0.2s ease;
}

.sidebar-close:hover {
  background: #f3f4f6;
  border-color: #d1d5db;
}

/* ===== MENU STYLES ===== */
.menu {
  width: 100%;
<<<<<<< HEAD
  padding: 1rem 0;
  flex: 1;
}

.menu .item {
  cursor: pointer;
  position: relative;
}

.menu .item a {
  color: #374151;
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 1.5rem;
  font-size: 1.0625rem;
  font-weight: 500;
  border-bottom: 1px solid #f3f4f6;
  transition: all 0.2s ease;
}

.menu .item a:hover {
  background: #f9fafb;
  color: #111827;
}

.menu-text {
  flex: 1;
}

.chevron-icon {
  transition: transform 0.2s ease;
  color: #6b7280;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

.chevron-icon.rotated {
  transform: rotate(180deg);
}

.sub-menu {
  background: #f9fafb;
  position: relative;
  border-left: 3px solid #e5e7eb;
  margin-left: 1.5rem;
}

.sub-menu a {
  padding-left: 2rem;
  padding-right: 1.5rem;
  font-size: 1rem;
  color: #6b7280;
  border-bottom: 1px solid #f3f4f6;
}

.sub-menu a:hover {
  background: #f3f4f6;
  color: #111827;
  border-left-color: #28b928;
}

/* ===== FOOTER ===== */
.sidebar-footer {
  padding: 1.25rem 1.5rem;
  border-top: 1px solid #e5e7eb;
  background: #f9fafb;
}

.logout-btn {
  width: 100%;
  padding: 1rem;
  border-radius: 10px;
  font-size: 1.0625rem;
  justify-content: flex-start;
  background: #ffffff;
  border: 1px solid #e5e7eb;
  color: #374151;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  font-weight: 500;
  transition: all 0.2s ease;
}

.logout-btn:hover {
  background: #f3f4f6;
  border-color: #d1d5db;
}

.logout-icon {
  color: #dc2626;
}

/* ===== MAIN CONTENT ===== */
.main-content {
  min-height: 100vh;
  transition: margin-left 0.3s ease;
  background: #f9fafb;
=======
  padding: 5rem 0 2rem 0;
}

.side-bar .menu .item {
  position: relative;
}

.side-bar .menu .item a {
  color: #e2e8f0;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem 1.5rem;
  font-size: 1.125rem;
  font-weight: 500;
  transition: all 0.3s ease;
  border-left: 4px solid transparent;
}

.side-bar .menu .item a:hover {
  background: rgba(255, 255, 255, 0.1);
  border-left-color: #3b82f6;
  color: #ffffff;
  padding-left: 2rem;
}

.side-bar .menu .item .material-icons:not(.dropdown-icon) {
  font-size: 1.5rem;
  width: 1.5rem;
  text-align: center;
}

.dropdown-icon {
  margin-left: auto;
  font-size: 1.25rem;
  transition: transform 0.3s ease;
}

.sub-btn {
  justify-content: space-between;
}

.sub-menu {
  background: rgba(30, 41, 59, 0.8);
  overflow: hidden;
>>>>>>> Development
}

.submenu-enter-active,
.submenu-leave-active {
  transition: all 0.3s ease;
  max-height: 200px;
}

.submenu-enter-from,
.submenu-leave-to {
  opacity: 0;
  max-height: 0;
}

.submenu-enter-to,
.submenu-leave-from {
  opacity: 1;
  max-height: 200px;
}

.sub-menu .sub-item {
  padding: 0.875rem 1.5rem 0.875rem 4rem;
  font-size: 1rem;
  border-left: 4px solid transparent;
}

.sub-menu .sub-item:hover {
  background: rgba(59, 130, 246, 0.1);
  border-left-color: #60a5fa;
}

.sub-menu .sub-item .material-icons {
  font-size: 1.25rem;
}

/* Content Area */
.content {
<<<<<<< HEAD
  padding: 2rem 1.75rem;
  max-width: 1400px;
  margin: 0 auto;
  width: 100%;
}

.info-area {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 3rem;
  border-radius: 20px;
  color: white;
  margin-bottom: 2rem;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.info-area h1 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  font-weight: 700;
}

.subtitle {
  font-size: 1.25rem;
  opacity: 0.9;
  max-width: 800px;
  line-height: 1.6;
}

/* ===== DASHBOARD CARDS ===== */
.dashboard-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.75rem;
  margin-top: 2rem;
}

.dashboard-card {
  background: white;
  border-radius: 16px;
  padding: 2rem 1.5rem;
  text-align: center;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border: 1px solid #e5e7eb;
}

.dashboard-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.card-icon {
  font-size: 3rem;
  margin-bottom: 1.25rem;
  display: block;
}

.dashboard-card h3 {
  color: #111827;
  margin-bottom: 0.75rem;
  font-weight: 600;
}

.dashboard-card p {
  color: #6b7280;
  line-height: 1.5;
  margin: 0;
}

/* ===== RESPONSIVE DESIGN ===== */

/* Tablet */
@media (max-width: 1024px) {
  .side-bar {
    width: 300px;
    left: -300px;
  }
  
  .dashboard-cards {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
  }
  
  .info-area {
    padding: 2.5rem;
  }
  
  .info-area h1 {
    font-size: 2.25rem;
  }
}

@media (max-width: 768px) {
  .topbar {
    padding: 1rem;
    flex-direction: column;
    align-items: stretch;
    gap: 1rem;
  }
  
  .title-row {
    flex-wrap: wrap;
  }
  
  .logo {
    font-size: 1.125rem;
  }
  
  .title-actions {
    gap: 0.75rem;
  }
  
  .portal-btn {
    display: none;
  }
  
  .toggle-btn {
    padding: 0.75rem 1rem;
  }
  
  .content {
    padding: 1.5rem 1rem;
  }
  
  .info-area {
    padding: 2rem 1.5rem;
  }
  
  .info-area h1 {
    font-size: 2rem;
  }
  
  .subtitle {
    font-size: 1.125rem;
  }
  
  .dashboard-cards {
    grid-template-columns: 1fr;
    gap: 1.25rem;
  }
  
  .dashboard-card {
    padding: 1.75rem 1.25rem;
  }
  
  .side-bar {
    width: 100%;
    left: -100%;
  }
}

/* Mobile */
@media (max-width: 480px) {
  .topbar {
    padding: 0.875rem 1rem;
  }
  
  .logo {
    font-size: 1rem;
  }
  
  .toggle-btn {
    font-size: 1rem;
    padding: 0.625rem 0.875rem;
  }
  
  .content {
    padding: 1rem 0.875rem;
  }
  
  .info-area {
    padding: 1.5rem 1rem;
    border-radius: 16px;
  }
  
  .info-area h1 {
    font-size: 1.75rem;
  }
  
  .subtitle {
    font-size: 1rem;
  }
  
  .dashboard-card {
    padding: 1.5rem 1rem;
  }
  
  .card-icon {
    font-size: 2.5rem;
  }
}

/* Desktop - Sidebar always visible */
@media (min-width: 1025px) {
=======
  min-height: 100vh;
  padding: 2rem;
  background: #f8fafc;
  transition: padding-left 0.3s ease;
}

.info-area {
  background: white;
  border-radius: 1rem;
  padding: 2.5rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  max-width: 1200px;
  margin: 0 auto;
}

.welcome-title {
  font-size: 2.25rem;
  font-weight: 700;
  color: #0f172a;
  margin-bottom: 1rem;
  line-height: 1.2;
}

.welcome-text {
  font-size: 1.25rem;
  color: #64748b;
  margin-bottom: 2.5rem;
  line-height: 1.6;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1.5rem;
  margin-top: 2rem;
}

.stat-card {
  background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
  border-radius: 0.75rem;
  padding: 1.5rem;
  text-align: center;
  border: 1px solid #e2e8f0;
  transition: all 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.stat-icon {
  font-size: 2.5rem;
  color: #3b82f6;
  margin-bottom: 0.75rem;
}

.stat-card h3 {
  font-size: 1.125rem;
  color: #475569;
  margin-bottom: 0.5rem;
  font-weight: 600;
}

.stat-number {
  font-size: 2rem;
  font-weight: 700;
  color: #0f172a;
}

/* Overlay */
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 999;
  backdrop-filter: blur(2px);
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Responsive Design */
@media (min-width: 1024px) {
  .content {
    padding-left: calc(280px + 2rem);
  }
  
>>>>>>> Development
  .toggle-btn {
    display: none;
  }
  
  .overlay {
<<<<<<< HEAD
    display: none !important;
  }
  
  .side-bar {
    left: 0;
  }
  
  .main-content.sidebar-active {
    margin-left: 320px;
  }
  
  .main-content {
    margin-left: 320px;
    transition: margin-left 0.3s ease;
  }
}

/* High contrast support */
@media (prefers-contrast: high) {
  .dashboard-card {
    border: 2px solid #e5e7eb;
  }
  
  .menu .item a {
    border-bottom: 2px solid #f3f4f6;
  }
}

/* Focus visibility for accessibility */
button:focus-visible,
a:focus-visible {
  outline: 2px solid #4a6da7;
  outline-offset: 2px;
}

/* Material icons adjustments */
.material-icons-outlined {
  font-size: 1.25rem;
=======
    display: none;
  }
}

@media (max-width: 1023px) {
  .side-bar {
    z-index: 1000;
  }
  
  .content {
    padding-left: 2rem;
  }
  
  .info-area {
    padding: 1.5rem;
  }
  
  .welcome-title {
    font-size: 1.875rem;
  }
  
  .welcome-text {
    font-size: 1.125rem;
  }
}

@media (max-width: 768px) {
  .side-bar {
    width: 100%;
    max-width: 320px;
  }
  
  .toggle-btn {
    top: 0.5rem;
    left: 0.5rem;
    padding: 0.625rem 1rem;
    font-size: 0.875rem;
  }
  
  .content {
    padding: 1rem;
  }
  
  .info-area {
    padding: 1.25rem;
    margin-top: 3.5rem;
  }
  
  .welcome-title {
    font-size: 1.5rem;
  }
  
  .welcome-text {
    font-size: 1rem;
  }
  
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
  }
  
  .stat-card {
    padding: 1rem;
  }
  
  .stat-number {
    font-size: 1.5rem;
  }
}

@media (max-width: 480px) {
  .stats-grid {
    grid-template-columns: 1fr;
  }
  
  .side-bar .menu .item a {
    font-size: 1rem;
    padding: 0.875rem 1.25rem;
  }
  
  .sub-menu .sub-item {
    padding: 0.75rem 1.25rem 0.75rem 3.5rem;
  }
}

/* Scrollbar Styling */
.side-bar::-webkit-scrollbar {
  width: 6px;
}

.side-bar::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.1);
}

.side-bar::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.3);
  border-radius: 3px;
}

.side-bar::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.4);
>>>>>>> Development
}
</style> 