<template>
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
  name: "SidebarComponent",
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
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

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
  background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
  width: 280px;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  overflow-y: auto;
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
}

.side-bar .menu {
  width: 100%;
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
  
  .toggle-btn {
    display: none;
  }
  
  .overlay {
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
}
</style> 