<template>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap"
    rel="stylesheet"
  />
  <link
    href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet"
  />

  <link
    href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined"
    rel="stylesheet"
  />

  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0&icon_names=add"
  />

  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0&icon_names=arrow_upward"
  />

  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0&icon_names=arrow_downward"
  />

  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <div class="error" v-if="isFailed">
    <span>Task failed to execute!</span>
  </div>

  <div class="success" v-if="isSuccess">
    <span>Task successfully executed!</span>
  </div>

  <!--sidebar-->
  <div class="side-bar">
    <div class="menu">
      <div class="item">
        <a
          href="#"
          class="sub-btn"
          @click.stop="
            $router.push('/principal');
            showMenu1 = !showMenu1;
          "
          >Student</a
        >
        <div class="sub-menu" v-if="showMenu1">
          <a href="#" class="sub-item">Merged Answers</a>
          <a href="#" @click="click('student')" class="sub-item"
            >Individual Answers</a
          >
        </div>
      </div>
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu2 = !showMenu2"
          >Teacher</a
        >
        <div class="sub-menu" v-if="showMenu2">
          <a href="#" class="sub-item">Merged Answers</a>
          <a href="#" @click="click('teacher')" class="sub-item"
            >Individual Answers</a
          >
          <a href="#" @click="click('evaluate')" class="sub-item"
            >Evaluate Teachers</a
          >
        </div>
      </div>
      <div class="item">
        <a
          href="#"
          @click.stop="
            $router.push('/principal');
            showMenu3 = !showMenu3;
          "
          >Account Management</a
        >
        <div class="sub-menu" v-if="showMenu3">
          <a href="#" @click="click2('crtTeacher')" class="sub-item"
            >Add Teachers</a
          >
          <a href="#" @click="click2('rmTeacher')" class="sub-item"
            >Delete Users</a
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
        <a href="#" @click.prevent="$router.push('/changequestions')"
          >Question Change</a
        >
      </div>
    </div>
  </div>

  <!--end of sidebar-->

  <div class="main-content">
    <div class="container">
      <header class="header">
        <div class="search-container">
          <span class="material-icons search-icon">search</span>
          <input
            aria-label="Search"
            class="search-input"
            placeholder="Search Bar"
            type="text"
          />
        </div>

        <div class="header-buttons">
          <button class="btn-primary">
            Add
            <span class="material-symbols-outlined"> add </span>
          </button>
        </div>
      </header>

      <!--main-->
      <!--top part-->

      <main class="main">
        <div class="section" v-for="header in headers" :key="header.header_id">
          <div class="section-header">
            <div class="section-title">
              <p class="title-text" v-if="!header.editing">
                {{ header.header }}
              </p>
              <input
                class="search-input"
                type="text"
                v-model="header.header"
                v-if="header.editing"
              />
              <button
                class="btn-section"
                v-if="header.editing"
                @click="
                  (header.editing = false),
                    changeHeader(header.header_id, header.header),
                    (isSuccess = true)
                "
              >
                <span class="material-icons">edit</span>
                Edit
              </button>
            </div>
            <div class="section-actions">
              <button class="btn-section" @click="header.editing = true">
                <span class="material-icons">edit</span>
                Edit
              </button>
              <button class="btn-section">
                <span class="material-icons">delete</span>
                Remove
              </button>
            </div>
          </div>

          <!--questions-->
          <div class="questions-container">
            <div
              class="question-card"
              v-for="question in header.questions"
              :key="question.question_id"
            >
              <div class="question-content">
                <button class="btn-question">
                  <span class="material-symbols-outlined"> arrow_upward </span>
                </button>
                <button class="btn-question">
                  <span class="material-symbols-outlined">
                    arrow_downward
                  </span>
                </button>
                <div class="question-text">
                  <p>{{ question.question }}</p>
                </div>
                <div class="question-actions">
                  <button class="btn-question">
                    <span class="material-icons">edit</span>
                    Edit
                  </button>
                  <button class="btn-question">
                    <span class="material-icons">delete</span>
                    Remove
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
const url1 = "https://rusiann7.helioho.st";
const url2 = "https://star-panda-literally.ngrok-free.app";

export default {
  name: "chQuestions",
  data() {
    return {
      urlappphp: `${url2}/questions.php`,
      chHeaderphp: `${url2}/headerChangerS.php`,
      headers: [],
      showMenu1: false,
      showMenu2: false,
      showMenu3: false,
      isLoading: false,
      isSuccess: false,
      isFailed: false,
    };
  },

  methods: {
    async getQuestions() {
      try {
        this.isLoading = true;

        const response = await fetch(this.urlappphp, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ action: "getQuestions" }),
        });

        const result = await response.json();

        if (result.success) {
          this.headers = result.headers.map((h) => ({ ...h, editing: false }));
          this.isLoading = false;
        } else {
          console.error("server error:", error);
        }
      } catch (error) {
        console.error(error);
        this.isLoading = false;
      }
    },

    async changeHeader(headerId, headername) {
      console.log(headerId, headername);

      try {
        this.isLoading = true;

        const response = await fetch(this.chHeaderphp, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "changeHeaders",
            id: headerId,
            newHeader: headername,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.isLoading = false;
          this.isSuccess = true;
          this.getQuestions();
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

  watch: {
    isSuccess(newVal) {
      if (newVal) {
        setTimeout(() => {
          this.isSuccess = false;
        }, 6000);
      }
    },

    isFailed(newVal) {
      if (newVal) {
        setTimeout(() => {
          this.isFailed = false;
        }, 6000);
      }
    },
  },

  mounted() {
    this.getQuestions();
  },
};
</script>

<style scoped>
/* Base Styles */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

body {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  background-color: #ffffff;
  color: #000000;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.material-icons {
  font-size: 1.25rem;
  vertical-align: middle;
}

/* Layout */
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 1rem;
}

@media (min-width: 768px) {
  .container {
    padding: 2rem;
  }
}

/* Header */
.header {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  gap: 1rem;
}

@media (min-width: 640px) {
  .header {
    flex-direction: row;
  }
}

/* Search */
.search-container {
  position: relative;
  width: 100%;
  flex-grow: 1;
  max-width: 24rem;
}

.search-icon {
  position: absolute;
  left: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
}

.search-input {
  width: 100%;
  padding-left: 2.5rem;
  padding-right: 1rem;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
  background-color: #ffffff;
  border: 1px solid #000000;
  border-radius: 0.375rem;
  transition: all 0.15s ease-in-out;
}

.search-input:focus {
  outline: none;
  ring: 2px solid #000000;
  border-color: #000000;
}

/* Buttons */
.header-buttons {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.btn-primary,
.btn-secondary,
.btn-section,
.btn-question {
  font-weight: 600;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  transition: all 0.15s ease-in-out;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
  border: 1px solid;
}

.btn-primary {
  background-color: #000000;
  color: #ffffff;
  border-color: #000000;
}

.btn-primary:hover {
  background-color: #1f2937;
}

.btn-secondary {
  background-color: #ffffff;
  color: #000000;
  border-color: #000000;
}

.btn-secondary:hover {
  background-color: #f3f4f6;
}

/* Main Content */
.main {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

/* Sections */
.section {
  background-color: #000000;
  color: #ffffff;
  border-radius: 0.5rem;
  padding: 1rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

@media (min-width: 640px) {
  .section {
    padding: 1.5rem;
  }
}

.section-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
}

@media (min-width: 640px) {
  .section-header {
    flex-direction: row;
  }
}

.section-title {
  flex-grow: 1;
  width: 100%;
}

.title-text {
  font-weight: 600;
  font-size: 1.125rem;
  line-height: 1.75rem;
}

.section-actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  flex-shrink: 0;
}

.btn-section {
  background-color: #000000;
  color: #ffffff;
  border-color: #ffffff;
}

.btn-section:hover {
  background-color: #1f2937;
}

/* Questions */
.questions-container {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.question-card {
  background-color: #ffffff;
  color: #000000;
  border-radius: 0.5rem;
  border: 1px solid #000000;
  padding: 1rem;
}

.question-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
}

@media (min-width: 640px) {
  .question-content {
    flex-direction: row;
  }
}

.question-text {
  flex-grow: 1;
  width: 100%;
}

.question-text p {
  color: #000000;
}

.question-actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  flex-shrink: 0;
}

.btn-question {
  background-color: #ffffff;
  color: #000000;
  border-color: #000000;
}

.btn-question:hover {
  background-color: #f3f4f6;
}

/* Responsive Design */
@media (min-width: 640px) {
  .container {
    padding: 1rem;
  }

  .header {
    flex-direction: row;
  }

  .section-header {
    flex-direction: row;
  }

  .question-content {
    flex-direction: row;
  }
}

/* Focus states for accessibility */
button:focus,
input:focus {
  outline: 2px solid #000000;
  outline-offset: 2px;
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
}

/* ===== LOADING & FEEDBACK STATES ===== */
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
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.success,
.error {
  position: fixed;
  top: 20px;
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

.success span,
.error span {
  display: block;
}

/* Progress bar for timeout */
.success::after,
.error::after {
  content: "";
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
</style>
