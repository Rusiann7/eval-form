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
          <button class="btn-primary" @click="isEditing = !isEditing">
            Add
            <svg
              xmlns="http://www.w3.org/2000/svg"
              height="24px"
              viewBox="0 -960 960 960"
              width="24px"
              fill="#FFFFFF"
            >
              <path
                d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"
              />
            </svg>
          </button>

          <input
            type="text"
            v-model="newHeader"
            class="search-input"
            v-if="isEditing"
          />
          <button class="btn-primary" @click="addHeader()" v-if="isEditing">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              height="24px"
              viewBox="0 -960 960 960"
              width="24px"
              fill="#FFFFFF"
            >
              <path
                d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"
              />
            </svg>
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
                    changeHeader(header.header_id, header.header)
                "
              >
                <span class="material-icons">edit</span>
                Edit
              </button>
            </div>
            <div class="section-actions">
              <button
                class="btn-section"
                @click="header.editing = !header.editing"
              >
                <span class="material-icons">edit</span>
                Edit
              </button>

              <button class="btn-section" @click="header.addQ = !header.addQ">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  height="24px"
                  viewBox="0 -960 960 960"
                  width="24px"
                  fill="#FFFFFF"
                >
                  <path
                    d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"
                  />
                </svg>
                Add question
              </button>

              <input
                type="text"
                class="search-input"
                v-if="header.addQ"
                v-model="newQuestion"
              />
              <button
                class="btn-section"
                @click="addQuestion(header.header_id)"
                v-if="header.addQ"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  height="24px"
                  viewBox="0 -960 960 960"
                  width="24px"
                  fill="#FFFFFF"
                >
                  <path
                    d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"
                  />
                </svg>
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
                <div class="question-text">
                  <p v-if="!question.editing">{{ question.question }}</p>
                  <input
                    type="text"
                    v-if="question.editing"
                    v-model="question.question"
                    class="search-input"
                  />
                  <button
                    class="btn-question"
                    v-if="question.editing"
                    @click="
                      (question.editing = false),
                        changeQuestion(question.question_id, question.question)
                    "
                  >
                    <span class="material-icons">edit</span>
                    Edit
                  </button>
                </div>

                <div class="question-actions">
                  <button
                    class="btn-question"
                    @click="question.editing = !question.editing"
                  >
                    <span class="material-icons">edit</span>
                    Edit
                  </button>
                  <button
                    class="btn-question"
                    @click="rmQuestion(question.question_id)"
                  >
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
      urlappphp: `${url2}/questiont.php`,
      chHeaderphp: `${url2}/headerChangerT.php`,
      chQuestionphp: `${url2}/questionChangeT.php`,
      rmQuestionphp: `${url2}/questionDeleteT.php`,
      addQuestionphp: `${url2}/addQuestionT.php`,
      addheaderphp: `${url2}/addHeaderT.php`,
      headers: [],
      newQuestion: "",
      newHeader: "",
      header_version: null,
      showMenu1: false,
      showMenu2: false,
      showMenu3: false,
      showMenu4: false,
      isLoading: false,
      isSuccess: false,
      isFailed: false,
      isEditing: false,
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
          body: JSON.stringify({ action: "getTeacherQuestions" }),
        });

        const result = await response.json();

        if (result.success) {
          this.headers = result.headers.map((h) => ({
            ...h,
            editing: false,
            addQ: false,
          }));
          this.header_version = result.header_ver;
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

    async changeQuestion(questionId, questionname) {
      try {
        this.isLoading = true;

        const response = await fetch(this.chQuestionphp, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "chQuestions",
            id: questionId,
            question: questionname,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.isLoading = false;
          this.isSuccess = true;
          this.getQuestions();
        }
      } catch (error) {
        this.isLoading = false;
        this.isFailed = true;
        console.error(error);
      }
    },

    async rmQuestion(qId) {
      try {
        this.isLoading = true;

        const response = await fetch(this.rmQuestionphp, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "delQuestion",
            id: qId,
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

    async addQuestion(hId) {
      try {
        this.isLoading = true;

        const response = await fetch(this.addQuestionphp, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "addQuestion",
            question: this.newQuestion,
            id: hId,
            identifier: this.header_version,
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

    async addHeader() {
      try {
        this.isLoading = true;

        const response = await fetch(this.addheaderphp, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "addHeader",
            header: this.newHeader,
            identifier: this.header_version,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.isLoading = false;
          this.isSuccess = true;
          this.isEditing = false;
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
    this.newQuestion = "";
    this.newHeader = "";
  },
};
</script>

<style scoped>
<<<<<<< HEAD
/* Base Styles */
=======
/* Base Styles - Improved with larger text and better responsiveness */
>>>>>>> Development
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
<<<<<<< HEAD
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

body {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
=======
  font-family: "Inter", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
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
  font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
    Oxygen, Ubuntu, sans-serif;
>>>>>>> Development
  background-color: #ffffff;
  color: #000000;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
<<<<<<< HEAD
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
=======
  line-height: 1.6;
}

.material-icons {
  font-size: 1.5rem;
  vertical-align: middle;
}

.material-symbols-outlined {
  font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
}

/* Layout */
.container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 1.5rem;
  width: 100%;
>>>>>>> Development
}

@media (min-width: 768px) {
  .container {
<<<<<<< HEAD
    padding: 2rem;
=======
    padding: 2.5rem;
>>>>>>> Development
  }
}

/* Header */
.header {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
<<<<<<< HEAD
  align-items: center;
  margin-bottom: 2rem;
  gap: 1rem;
=======
  align-items: stretch;
  margin-bottom: 2.5rem;
  gap: 1.5rem;
  width: 100%;
>>>>>>> Development
}

@media (min-width: 640px) {
  .header {
    flex-direction: row;
<<<<<<< HEAD
=======
    align-items: center;
>>>>>>> Development
  }
}

/* Search */
.search-container {
  position: relative;
  width: 100%;
  flex-grow: 1;
<<<<<<< HEAD
  max-width: 24rem;
=======
  max-width: 32rem;
>>>>>>> Development
}

.search-icon {
  position: absolute;
<<<<<<< HEAD
  left: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
=======
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
  font-size: 1.5rem;
>>>>>>> Development
}

.search-input {
  width: 100%;
<<<<<<< HEAD
  padding-left: 2.5rem;
  padding-right: 1rem;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
  background-color: #ffffff;
  border: 1px solid #000000;
  border-radius: 0.375rem;
  transition: all 0.15s ease-in-out;
=======
  padding: 1rem 1rem 1rem 3.5rem;
  font-size: 1.1rem;
  background-color: #ffffff;
  border: 2px solid #000000;
  border-radius: 0.5rem;
  transition: all 0.2s ease-in-out;
  min-height: 3.5rem;
>>>>>>> Development
}

.search-input:focus {
  outline: none;
<<<<<<< HEAD
  ring: 2px solid #000000;
=======
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
>>>>>>> Development
  border-color: #000000;
}

/* Buttons */
.header-buttons {
  display: flex;
  align-items: center;
<<<<<<< HEAD
  gap: 0.75rem;
=======
  gap: 1rem;
  flex-wrap: wrap;
>>>>>>> Development
}

.btn-primary,
.btn-secondary,
.btn-section,
.btn-question {
  font-weight: 600;
<<<<<<< HEAD
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  transition: all 0.15s ease-in-out;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
  border: 1px solid;
=======
  padding: 1rem 1.5rem;
  border-radius: 0.5rem;
  transition: all 0.2s ease-in-out;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  cursor: pointer;
  border: 2px solid;
  font-size: 1.1rem;
  min-height: 3.5rem;
  white-space: nowrap;
>>>>>>> Development
}

.btn-primary {
  background-color: #000000;
  color: #ffffff;
  border-color: #000000;
}

.btn-primary:hover {
<<<<<<< HEAD
  background-color: #1f2937;
=======
  background-color: #333333;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
>>>>>>> Development
}

.btn-secondary {
  background-color: #ffffff;
  color: #000000;
  border-color: #000000;
}

.btn-secondary:hover {
<<<<<<< HEAD
  background-color: #f3f4f6;
=======
  background-color: #f8f9fa;
  transform: translateY(-2px);
>>>>>>> Development
}

/* Main Content */
.main {
  display: flex;
  flex-direction: column;
<<<<<<< HEAD
  gap: 2rem;
=======
  gap: 2.5rem;
  width: 100%;
>>>>>>> Development
}

/* Sections */
.section {
  background-color: #000000;
  color: #ffffff;
<<<<<<< HEAD
  border-radius: 0.5rem;
  padding: 1rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
=======
  border-radius: 1rem;
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
    0 2px 4px -1px rgba(0, 0, 0, 0.06);
>>>>>>> Development
}

@media (min-width: 640px) {
  .section {
<<<<<<< HEAD
    padding: 1.5rem;
=======
    padding: 2rem;
>>>>>>> Development
  }
}

.section-header {
  display: flex;
  flex-direction: column;
<<<<<<< HEAD
  align-items: center;
  gap: 1rem;
}

@media (min-width: 640px) {
  .section-header {
    flex-direction: row;
=======
  align-items: stretch;
  gap: 1.5rem;
  width: 100%;
}

@media (min-width: 768px) {
  .section-header {
    flex-direction: row;
    align-items: center;
>>>>>>> Development
  }
}

.section-title {
  flex-grow: 1;
  width: 100%;
}

.title-text {
<<<<<<< HEAD
  font-weight: 600;
  font-size: 1.125rem;
  line-height: 1.75rem;
=======
  font-weight: 700;
  font-size: 1.5rem;
  line-height: 1.4;
  margin: 0;
}

@media (min-width: 768px) {
  .title-text {
    font-size: 1.75rem;
  }
>>>>>>> Development
}

.section-actions {
  display: flex;
  align-items: center;
<<<<<<< HEAD
  gap: 0.75rem;
  flex-shrink: 0;
=======
  gap: 1rem;
  flex-wrap: wrap;
  justify-content: flex-start;
}

@media (min-width: 768px) {
  .section-actions {
    justify-content: flex-end;
  }
>>>>>>> Development
}

.btn-section {
  background-color: #000000;
  color: #ffffff;
  border-color: #ffffff;
<<<<<<< HEAD
}

.btn-section:hover {
  background-color: #1f2937;
=======
  padding: 0.75rem 1.25rem;
  font-size: 1rem;
  min-height: auto;
}

.btn-section:hover {
  background-color: #333333;
  border-color: #ffffff;
>>>>>>> Development
}

/* Questions */
.questions-container {
  display: flex;
  flex-direction: column;
<<<<<<< HEAD
  gap: 1rem;
=======
  gap: 1.25rem;
>>>>>>> Development
}

.question-card {
  background-color: #ffffff;
  color: #000000;
<<<<<<< HEAD
  border-radius: 0.5rem;
  border: 1px solid #000000;
  padding: 1rem;
=======
  border-radius: 0.75rem;
  border: 2px solid #000000;
  padding: 1.5rem;
  transition: all 0.2s ease;
}

.question-card:hover {
  transform: translateX(4px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
>>>>>>> Development
}

.question-content {
  display: flex;
  flex-direction: column;
<<<<<<< HEAD
  align-items: center;
  gap: 1rem;
=======
  align-items: stretch;
  gap: 1.5rem;
  width: 100%;
>>>>>>> Development
}

@media (min-width: 640px) {
  .question-content {
    flex-direction: row;
<<<<<<< HEAD
=======
    align-items: center;
>>>>>>> Development
  }
}

.question-text {
  flex-grow: 1;
  width: 100%;
}

.question-text p {
  color: #000000;
<<<<<<< HEAD
=======
  font-size: 1.25rem;
  line-height: 1.5;
  margin: 0;
>>>>>>> Development
}

.question-actions {
  display: flex;
  align-items: center;
<<<<<<< HEAD
  gap: 0.75rem;
=======
  gap: 1rem;
>>>>>>> Development
  flex-shrink: 0;
}

.btn-question {
  background-color: #ffffff;
  color: #000000;
  border-color: #000000;
<<<<<<< HEAD
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
=======
  padding: 0.75rem 1.25rem;
  font-size: 1rem;
  min-height: auto;
}

.btn-question:hover {
  background-color: #f8f9fa;
>>>>>>> Development
}

/* Focus states for accessibility */
button:focus,
input:focus {
<<<<<<< HEAD
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
=======
  outline: 3px solid #000000;
  outline-offset: 2px;
}

/* Sidebar */
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
>>>>>>> Development
}

.side-bar .menu {
  width: 100%;
<<<<<<< HEAD
  margin-top: 80px;
=======
  margin-top: 0;
  padding: 1rem 0;
}

@media (min-width: 1024px) {
  .side-bar .menu {
    margin-top: 80px;
  }
>>>>>>> Development
}

.side-bar .menu .item {
  cursor: pointer;
  position: relative;
}

.side-bar .menu .item a {
  color: rgb(0, 0, 0);
  text-decoration: none;
  display: block;
<<<<<<< HEAD
  padding: 5px 30px;
  line-height: 60px;
  font-size: 16px;
  border-bottom: 1px solid #eee;
=======
  padding: 1rem 1.5rem;
  line-height: 1.5;
  font-size: 1.1rem;
  font-weight: 500;
  border-bottom: 1px solid #eee;
  transition: all 0.2s ease;
>>>>>>> Development
}

.side-bar .menu .item a:hover {
  background: rgba(0, 0, 0, 0.898);
<<<<<<< HEAD
  transition: 0.3s ease;
  color: white;
=======
  color: white;
  padding-left: 2rem;
>>>>>>> Development
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
<<<<<<< HEAD
  padding-left: 60px;
=======
  padding-left: 3rem;
  font-size: 1rem;
>>>>>>> Development
  border-bottom: 1px solid #ddd;
}

.side-bar .menu .item .sub-menu a:hover {
  background: rgba(0, 0, 0, 0.898);
  color: white;
}

<<<<<<< HEAD
.main-content {
  margin-left: 250px;
=======
/* Main Content Area */
.main-content {
  margin-left: 0;
>>>>>>> Development
  flex: 1;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
<<<<<<< HEAD
  justify-content: center;
}

/* ===== LOADING & FEEDBACK STATES ===== */
=======
  justify-content: flex-start;
  max-width: 100%;
  padding-top: 1rem;
}

@media (min-width: 1024px) {
  .main-content {
    margin-left: 280px;
    padding-top: 0;
  }
}

/* Loading & Feedback States */
>>>>>>> Development
.loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
<<<<<<< HEAD
  background-color: rgba(0, 0, 0, 0.7);
=======
  background-color: rgba(0, 0, 0, 0.85);
>>>>>>> Development
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  z-index: 3000;
  color: white;
}

.loading-spinner {
<<<<<<< HEAD
  border: 4px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top: 4px solid #ffffff;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
  margin-bottom: 10px;
  z-index: 3000;
}

=======
  border: 6px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top: 6px solid #ffffff;
  width: 60px;
  height: 60px;
  animation: spin 1s linear infinite;
  margin-bottom: 1.5rem;
  z-index: 3000;
}

.loading-screen p {
  font-size: 1.5rem;
  font-weight: 500;
}

>>>>>>> Development
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
<<<<<<< HEAD
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
=======
  top: 1.5rem;
  left: 50%;
  transform: translateX(-50%);
  padding: 1.5rem 2rem;
  border-radius: 0.75rem;
  font-weight: 600;
  z-index: 1000;
  text-align: center;
  min-width: 300px;
  max-width: 90%;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  animation: slideIn 0.3s ease-out, timeout 6s linear forwards;
  font-size: 1.1rem;
}

.success {
  background-color: #10b981;
  color: #ffffff;
  border: 2px solid #059669;
}

.error {
  background-color: #ef4444;
  color: #ffffff;
  border: 2px solid #dc2626;
>>>>>>> Development
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
<<<<<<< HEAD
  background: currentColor;
  opacity: 0.3;
=======
  background: rgba(255, 255, 255, 0.5);
>>>>>>> Development
  animation: progress 5s linear forwards;
}

@keyframes slideIn {
  from {
    opacity: 0;
<<<<<<< HEAD
    transform: translateX(-50%) translateY(-20px);
=======
    transform: translateX(-50%) translateY(-30px);
>>>>>>> Development
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
<<<<<<< HEAD
=======

/* Mobile-specific adjustments */
@media (max-width: 640px) {
  .container {
    padding: 1rem;
  }

  .header-buttons {
    width: 100%;
    justify-content: center;
  }

  .section-actions {
    justify-content: center;
  }

  .btn-section,
  .btn-question {
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
  }

  .title-text {
    font-size: 1.25rem;
    text-align: center;
  }

  .question-text p {
    font-size: 1.1rem;
  }
}

/* Tablet adjustments */
@media (min-width: 641px) and (max-width: 1023px) {
  .container {
    padding: 1.5rem;
  }

  .side-bar {
    height: auto;
    position: relative;
  }

  .main-content {
    margin-left: 0;
  }

  .section-header {
    flex-wrap: wrap;
  }
}
>>>>>>> Development
</style>
