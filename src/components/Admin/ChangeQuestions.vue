<template>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap"
    rel="stylesheet"
  />
  <link
    href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet"
  />

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
          <button class="btn-secondary">Send</button>
          <button class="btn-primary">
            Send
            <span class="material-icons">send</span>
          </button>
        </div>
      </header>

      <!--main-->
      <!--top part-->

      <main class="main">
        <draggable
          v-model="headers"
          group="header"
          @start="drag = true"
          @end="drag = false"
          item-key="header.header_id"
        >
          <template #item="{ element: header }"> </template>
          <div class="section">
            <div class="section-header">
              <div class="section-title">
                <p class="title-text">{{ header.header }}</p>
              </div>
              <div class="section-actions">
                <button class="btn-section">
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
            <draggable
              v-model="headers"
              group="questions"
              @start="drag = true"
              @end="drag = false"
              item-key="question.question_id"
            >
              <div class="questions-container">
                <div
                  class="question-card"
                  v-for="question in header.question"
                  :key="question.question_id"
                >
                  <div class="question-content">
                    <div class="question-text">
                      <p>Question</p>
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
            </draggable>
          </div>
        </draggable>

        <!--second questions-->
        <div class="section">
          <div class="section-header">
            <div class="section-title">
              <p class="title-text">Header 2</p>
            </div>
            <div class="section-actions">
              <button class="btn-section">
                <span class="material-icons">edit</span>
                Edit
              </button>
              <button class="btn-section">
                <span class="material-icons">delete</span>
                Remove
              </button>
            </div>
          </div>
          <div class="questions-container">
            <div class="question-card">
              <div class="question-content">
                <div class="question-text">
                  <p>A third question to show the pattern</p>
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
            <div class="question-card">
              <div class="question-content">
                <div class="question-text">
                  <p>Fourth question example in the second header</p>
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
import draggable from "vuedraggable";

const url1 = "https://rusiann7.helioho.st";
const url2 = "https://star-panda-literally.ngrok-free.app";

export default {
  components: {
    draggable,
  },
  data() {
    return {
      drag: false,
      urlappphp: `${url2}/questions.php`,
      headers: [],
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
          this.headers = result.headers;
          this.isLoading = false;
        } else {
          console.error("server error:", error);
        }
      } catch (error) {
        console.error(error);
        this.isLoading = false;
      }
    },
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
</style>
