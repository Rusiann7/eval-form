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

          <input
            class="input-shyte"
            type="file"
            @change="file = $event.target.files[0]"
          />
        </div>
        <div class="buttons">
          <button class="btn btn-primary" @click="Upload">Upload</button>
          <button class="btn btn-secondary">View Upload Guidelines</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const url1 = "https://rusiann7.helioho.st";
//const url2 = "https://star-panda-literally.ngrok-free.app";
const url2 = "http://localhost:8000";

export default {
  name: "file",
  data() {
    return {
      urlappphp: `${url2}/CSVImport.php`,
      showMenu1: false,
      showMenu2: false,
      showMenu3: false,
      showMenu4: false,
      isLoading: false,
      isSuccess: false,
      isFailed: false,
      file: null,
    };
  },

  methods: {
    async Upload() {
      try {
        this.isLoading = true;

        const form = new FormData();
        form.append("action", "uploadCSV");
        form.append("file", this.file);

        const response = await fetch(this.urlappphp, {
          method: "POST",
          body: form,
        });

        const result = await response.json();

        if (result.success) {
          this.isLoading = false;
          this.isSuccess = true;
        } else {
          this.isLoading = false;
          this.isFailed = true;
        }
      } catch (error) {
        this.isLoading = false;
        console.error(error);
      }
    },
  },
};
</script>

<style scoped>
/* Base Styles - Consistent with the first component */
* {
  font-family: "Inter", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

html {
  font-size: 16px;
}

@media (min-width: 768px) {
  html {
    font-size: 18px;
  }
}

@media (min-width: 1200px) {
  html {
    font-size: 20px;
  }
}

body {
  background-color: #ffffff;
  color: #000000;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  line-height: 1.6;
}

.material-icons {
  font-size: 1.5rem;
  vertical-align: middle;
}

/* Main Container */
.container {
  width: 100%;
  max-width: 800px;
  padding: 2rem;
  text-align: center;
  margin: 0 auto;
}

@media (min-width: 768px) {
  .container {
    padding: 3rem;
    max-width: 900px;
  }
}

/* Content Area */
.content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2.5rem;
  width: 100%;
}

/* Title */
.title {
  font-size: 2rem;
  font-weight: 700;
  color: #000000;
  margin: 0;
  text-align: center;
}

@media (min-width: 768px) {
  .title {
    font-size: 2.5rem;
  }
}

/* Upload Area */
.upload-area {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 16rem;
  height: 16rem;
  border: 3px dashed #d1d5db;
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.3s ease;
  background-color: #f9fafb;
  margin: 1rem auto;
}

.input-shyte {
  position: relative;
  top: 0.5rem;
  left: 3.7rem;
}
.upload-area:hover {
  background-color: #f3f4f6;
  border-color: #9ca3af;
  transform: scale(1.02);
}

@media (min-width: 768px) {
  .upload-area {
    width: 20rem;
    height: 20rem;
  }
}

.upload-icon {
  font-size: 5rem;
  color: #6b7280;
  transition: color 0.3s ease;
}

.upload-area:hover .upload-icon {
  color: #4b5563;
}

/* Buttons */
.buttons {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 1.5rem;
  width: 100%;
  padding-top: 2rem;
}

@media (min-width: 640px) {
  .buttons {
    flex-direction: row;
    gap: 2rem;
  }
}

.btn {
  font-weight: 600;
  padding: 1rem 2rem;
  border-radius: 0.5rem;
  border: 2px solid;
  cursor: pointer;
  font-size: 1.1rem;
  transition: all 0.2s ease;
  min-width: 12rem;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  text-decoration: none;
}

@media (min-width: 640px) {
  .btn {
    min-width: 14rem;
    padding: 1.25rem 2.5rem;
  }
}

.btn-primary {
  background-color: #000000;
  color: white;
  border-color: #000000;
}

.btn-primary:hover {
  background-color: #333333;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-primary:focus {
  outline: 3px solid #000000;
  outline-offset: 2px;
}

.btn-secondary {
  background-color: #ffffff;
  color: #1f2937;
  border-color: #1f2937;
}

.btn-secondary:hover {
  background-color: #f8f9fa;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-secondary:focus {
  outline: 3px solid #1f2937;
  outline-offset: 2px;
}

/* Sidebar - Updated to match first component */
.side-bar {
  background: #f8f9fa;
  width: 100%;
  height: auto;
  position: relative;
  border-right: none;
  border-bottom: 1px solid #ddd;
  z-index: 100;
}

@media (min-width: 1024px) {
  .side-bar {
    width: 280px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    border-right: 1px solid #ddd;
    border-bottom: none;
  }
}

.side-bar .menu {
  width: 100%;
  margin-top: 0;
  padding: 1rem 0;
}

@media (min-width: 1024px) {
  .side-bar .menu {
    margin-top: 80px;
  }
}

.side-bar .menu .item {
  cursor: pointer;
  position: relative;
}

.side-bar .menu .item a {
  color: rgb(0, 0, 0);
  text-decoration: none;
  display: block;
  padding: 1rem 1.5rem;
  line-height: 1.5;
  font-size: 1.1rem;
  font-weight: 500;
  border-bottom: 1px solid #eee;
  transition: all 0.2s ease;
}

.side-bar .menu .item a:hover {
  background: rgba(0, 0, 0, 0.898);
  color: white;
  padding-left: 2rem;
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
  padding-left: 3rem;
  font-size: 1rem;
  border-bottom: 1px solid #ddd;
}

.side-bar .menu .item .sub-menu a:hover {
  background: rgba(0, 0, 0, 0.898);
  color: white;
}

/* Main Content - Updated to match first component */
.main-content {
  margin-left: 0;
  flex: 1;
  max-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  max-width: 100%;
  padding: 1rem;
}

@media (min-width: 1024px) {
  .main-content {
    margin-left: 280px;
    padding: 2rem;
  }
}

/* Mobile-specific adjustments */
@media (max-width: 640px) {
  .container {
    padding: 1.5rem;
  }

  .title {
    font-size: 1.75rem;
  }

  .upload-area {
    width: 14rem;
    height: 14rem;
  }

  .upload-icon {
    font-size: 4rem;
  }

  .btn {
    width: 100%;
    max-width: 20rem;
    padding: 0.875rem 1.5rem;
  }
}

/* Tablet adjustments */
@media (min-width: 641px) and (max-width: 1023px) {
  .container {
    padding: 2.5rem;
  }

  .side-bar {
    height: auto;
    position: relative;
  }

  .main-content {
    margin-left: 0;
    padding: 1.5rem;
  }

  .upload-area {
    width: 18rem;
    height: 18rem;
  }
}

/* Large screen adjustments */
@media (min-width: 1600px) {
  .container {
    max-width: 1200px;
  }

  .upload-area {
    width: 24rem;
    height: 24rem;
  }

  .upload-icon {
    font-size: 6rem;
  }
}

/* Focus states for accessibility */
button:focus,
a:focus {
  outline: 3px solid #000000;
  outline-offset: 2px;
}

/* Remove dark mode styles that aren't needed */
.dark .title,
.dark .upload-area,
.dark .upload-icon,
.dark .btn-primary:focus,
.dark .btn-secondary,
.dark .btn-secondary:hover,
.dark .btn-secondary:focus {
  /* Remove dark mode overrides since we're not using dark mode */
  all: unset;
  /* Use light mode styles instead */
}

/* File Upload Specific Enhancements */
.upload-area.file-over {
  border-color: #10b981;
  background-color: #d1fae5;
}

.upload-area.file-over .upload-icon {
  color: #10b981;
}

.file-info {
  margin-top: 1.5rem;
  font-size: 1.1rem;
  color: #6b7280;
}

.file-info.has-file {
  color: #059669;
  font-weight: 600;
}

/* Progress Bar for Upload */
.progress-bar {
  width: 100%;
  max-width: 24rem;
  height: 0.5rem;
  background-color: #e5e7eb;
  border-radius: 0.25rem;
  overflow: hidden;
  margin: 1.5rem auto;
}

.progress {
  height: 100%;
  background-color: #10b981;
  transition: width 0.3s ease;
}

@media (min-width: 768px) {
  .progress-bar {
    max-width: 32rem;
    height: 0.75rem;
  }
}
</style>
