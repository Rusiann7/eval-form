<template>
  <!--sidebar-->
  <div class="side-bar">
    <div class="menu">
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="$router.push('/principal')"
          >Student</a
        >
      </div>
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu2 = !showMenu2"
          >Teacher</a
        >
        <div class="sub-menu" v-if="showMenu2">
          <a href="#" @click="click('teacher')" class="sub-item"
            >Evaluation Answers</a
          >
          <a href="#" @click="click('evaluate')" class="sub-item"
            >Evaluate Teachers</a
          >
        </div>
      </div>
      <div class="item">
        <a href="#" @click.stop="$router.push('/principal')"
          >Account Management</a
        >
        <div class="sub-menu" v-if="showMenu3">
          <a href="#" @click="click2('crtTeacher')" class="sub-item"
            >Add Teachers</a
          >
          <a href="#" @click="click2('rmTeacher')" class="sub-item"
            >Delete Users</a
          >
          <a href="#" @click="click2('rmTeacher')" class="sub-item"
            >Edit Users</a
          >
        </div>
      </div>
      <div class="item">
        <a href="#" @click.prevent="$router.push('/scheduler')">Scheduler</a>
      </div>
      <div class="item">
        <a href="#" @click.prevent="$router.push('/fileupload')">File Upload</a>
      </div>

      <div class="item">
        <a href="#" @click.prevent="showMenu4 = !showMenu4">Question Change</a>

        <div class="sub-menu" v-if="showMenu4">
          <a
            href="#"
            @click.prevent="$router.push('/changequestions-student')"
            class="sub-item"
            >Chnage Student Questions</a
          >
          <a
            href="#"
            @click.prevent="$router.push('/changequestions-teacher')"
            class="sub-item"
            >Change Teacher Questions</a
          >
        </div>
      </div>
    </div>
  </div>

  <!--end of sidebar-->

  <!--main content-->
  <div class="main-content">
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"
    />

    <div class="container">
      <div class="content">
        <h1 class="title">File Upload</h1>
        <div class="upload-area">
          <span class="material-icons upload-icon">upload_file</span>
        </div>
        <div class="buttons">
          <button class="btn btn-primary">Send</button>
          <button class="btn btn-secondary">View Upload Guidelines</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "file",
  data() {
    return {
      showMenu1: false,
      showMenu2: false,
      showMenu3: false,
      showMenu4: false,
    };
  },
};
</script>

<style scoped>
* {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;

  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

.container {
  width: 100%;
  max-width: 28rem;
  padding: 2rem;
  text-align: center;
}

.content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2rem;
}

.title {
  font-size: 1.25rem;
  font-weight: 500;
  color: #374151;
}

.dark .title {
  color: #d1d5db;
}

.upload-area {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 12rem;
  height: 12rem;
  border: 2px dashed #d1d5db;
  border-radius: 50%;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.upload-area:hover {
  background-color: #f9fafb;
}

.dark .upload-area {
  border-color: #4b5563;
}

.dark .upload-area:hover {
  background-color: #1f2937;
}

.upload-icon {
  font-size: 3rem;
  color: #9ca3af;
}

.dark .upload-icon {
  color: #6b7280;
}

.buttons {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 1rem;
  width: 100%;
  padding-top: 1rem;
}

@media (min-width: 640px) {
  .buttons {
    flex-direction: row;
  }
}

.btn {
  font-weight: 500;
  padding: 0.5rem 1.5rem;
  border-radius: 0.375rem;
  border: none;
  cursor: pointer;
  font-family: inherit;
  font-size: 1rem;
  transition: all 0.2s ease;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

@media (min-width: 640px) {
  .btn {
    width: auto;
  }
}

.btn-primary {
  background-color: #111827;
  color: white;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

.btn-primary:hover {
  opacity: 0.9;
}

.btn-primary:focus {
  outline: none;
  box-shadow: 0 0 0 2px #111827, 0 0 0 4px rgba(255, 255, 255, 0.8);
}

.dark .btn-primary:focus {
  box-shadow: 0 0 0 2px #111827, 0 0 0 4px #121212;
}

.btn-secondary {
  background-color: #e5e7eb;
  color: #1f2937;
}

.dark .btn-secondary {
  background-color: #374151;
  color: #e5e7eb;
}

.btn-secondary:hover {
  background-color: #d1d5db;
}

.dark .btn-secondary:hover {
  background-color: #4b5563;
}

.btn-secondary:focus {
  outline: none;
  box-shadow: 0 0 0 2px #9ca3af, 0 0 0 4px rgba(255, 255, 255, 0.8);
}

.dark .btn-secondary:focus {
  box-shadow: 0 0 0 2px #6b7280, 0 0 0 4px #121212;
}

.side-bar {
  background: #f8f9fa;
  width: 250px;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  overflow-y: auto;
  z-index: 999;
  border-right: 1px solid #ddd;
  flex-shrink: 0;
}

.side-bar .menu {
  width: 100%;
  margin-top: 80px;
}

.side-bar .menu .item {
  cursor: pointer;
  position: relative;
}

.side-bar .menu .item a {
  color: rgb(0, 0, 0);
  text-decoration: none;
  display: block;
  padding: 5px 30px;
  line-height: 60px;
  font-size: 16px;
  border-bottom: 1px solid #eee;
}

.side-bar .menu .item a:hover {
  background: rgba(0, 0, 0, 0.898);
  transition: 0.3s ease;
  color: white;
}

.side-bar .menu .item i {
  margin-right: 15px;
}

.side-bar .menu .item .sub-menu {
  background: #e9ecef;
  position: relative;
  z-index: 1000;
}

.side-bar .menu .item .sub-menu a {
  padding-left: 60px;
  border-bottom: 1px solid #ddd;
}

.side-bar .menu .item .sub-menu a:hover {
  background: rgba(0, 0, 0, 0.898);
  color: white;
}

.main-content {
  margin-left: 250px;
  flex: 1;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}
</style>
