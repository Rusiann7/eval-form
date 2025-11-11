<template>
  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <div class="container">
    <header>
      <h1><i class="fas fa-user-graduate"></i> STUDENT EVALUATION TOOL</h1>
    </header>

    <div class="intro">
      <p>
        <strong
          >This form is designed to provide constructive feedback to teachers
          based on classroom experience. Please rate each indicator honestly to
          help improve teaching quality.</strong
        >
      </p>
    </div>

    <div class="info-fields">
      <div class="info-field">
        <label for="student">Pangalan ng Mag-aaral (Student Name):</label>
        <p>{{ name }}</p>
      </div>

      <div class="info-field">
        <label for="grade">Subject:</label>
        <p>{{ teacher.sub }}</p>
      </div>

      <div class="info-field">
        <label for="teacher">Subject Teacher:</label>
        <p>{{ teacher.firstnm }} {{ teacher.lastnm }}</p>
      </div>

      <div class="info-field">
        <label for="date">Petsa (Date):</label>
        <p>{{ month }}</p>
      </div>
    </div>

    <div class="rating-scale">
      <h2>Rating Scale</h2>
      <table class="rating-table">
        <thead>
          <tr>
            <th>Rating</th>
            <th>Description (English)</th>
            <th>Paglalarawan (Filipino)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>5</td>
            <td>Very Evident</td>
            <td>Palagiang Nakikita</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Sometimes Evident</td>
            <td>Paminsan-minsang Nakikita</td>
          </tr>
          <tr>
            <td>1</td>
            <td>Not Evident</td>
            <td>Hindi Nakikita</td>
          </tr>
        </tbody>
      </table>
      <p>
        <strong
          >Please rate the following aspects of your teacher's performance using
          the scale above:</strong
        >
      </p>
    </div>

    <div
      class="evaluation-section"
      v-for="header in headers"
      :key="header.header_id"
    >
      <!--title card yung blue i v-for din ito-->
      <h2 class="section-header">
        {{ header.header }} <span class="tagalog">{{ header.header_p }}</span>
      </h2>
      <table class="indicator-table">
        <thead>
          <tr>
            <th>Indicator</th>
            <!--ito yung sa taas-->
            <th class="rating-cell">
              <div class="rating-options">
                <div class="rating-option">
                  <span class="rating-value">5</span>
                  <span class="rating-label">Very Evident</span>
                </div>
                <div class="rating-option">
                  <span class="rating-value">3</span>
                  <span class="rating-label">Sometimes</span>
                </div>
                <div class="rating-option">
                  <span class="rating-value">1</span>
                  <span class="rating-label">Not Evident</span>
                </div>
              </div>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="question in header.questions" :key="question.question_id">
            <!--dito mo lagay yung v-for-->
            <td>
              <p>{{ question.question }}</p>
              <br />
              <!--tanong tagalog-->
            </td>
            <td class="rating-cell">
              <div class="rating-options">
                <label class="rating-option">
                  <input
                    type="radio"
                    :name="'rating: ' + question.question_id"
                    value="5"
                    v-model="answer[question.question_id]"
                    required
                  />
                  <span class="rating-value">5</span>
                </label>
                <label class="rating-option">
                  <input
                    type="radio"
                    :name="'rating: ' + question.question_id"
                    value="3"
                    v-model="answer[question.question_id]"
                    required
                  />
                  <span class="rating-value">3</span>
                </label>
                <label class="rating-option">
                  <input
                    type="radio"
                    :name="'rating:' + question.question_id"
                    value="1"
                    v-model="answer[question.question_id]"
                    required
                  />
                  <span class="rating-value">1</span>
                </label>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!--Feedback here-->
    <div class="feedback-section">
      <h2>
        Karagdagang mensahe / suhestiyon ng mag-aaral sa kaniyang guro upang
        mapagbuti pang higit ang kaniyang pagtuturo.
      </h2>
      <h2>
        Additional message/suggestion from the student to the teacher to further
        improve teaching.
      </h2>
      <textarea
        placeholder="Please provide your feedback and suggestions here..."
        v-model="feedback"
        required
      ></textarea>
    </div>

    <div class="buttons">
      <button class="submit" type="submit" @click.prevent="submitEval">
        <i class="fas fa-paper-plane"></i> Submit Evaluation
      </button>
      <button class="reset" type="submit" @click.prevent="formClear">
        <i class="fas fa-redo"></i> Reset Form
      </button>
    </div>

    <footer>
      <p>
        <strong
          >This evaluation is intended for educational improvement purposes. All
          responses will be kept confidential.</strong
        >
      </p>
    </footer>
  </div>
</template>

<script>
import { setToken, getToken } from "../../utils/auth";

const url1 = "https://rusiann7.helioho.st";
const url2 = "https://star-panda-literally.ngrok-free.app";

export default {
  name: "student-eval",
  data() {
    return {
      urlappphp: `${url2}/questions.php`,
      urlappphp2: `${url2}/idGetter.php`,
      urlappphp3: `${url2}/submits.php`,
      headers: [],
      teacher: {},
      date: new Date().getDate(),
      month: "",
      year: new Date().getFullYear(),
      feedback: "",
      answer: {},
      name:
        JSON.parse(localStorage.getItem("userData") || "{}").fullname ||
        "Student Name",
      id: JSON.parse(localStorage.getItem("userData") || "{}").id || null,
      isLoading: false,
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

    async getTeacherbyid() {
      try {
        this.isLoading = true;

        const response = await fetch(this.urlappphp2, {
          method: "POST",
          headers: {
            "Content-type": "application/json",
          },
          body: JSON.stringify({
            action: "getteacherbyid",
            id: this.$route.params.id,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.teacher = result.teacher;
          this.month = result.month + " " + this.date + ", " + this.year;
          this.isLoading = false;
          console.log(this.teacher);
        } else {
          console.log("Server error:", result.message);
        }
      } catch (error) {
        console.log(error);
        this.isLoading = false;
      }
    },

    async submitEval() {
      try {
        const unanswered = Object.keys(this.answer).filter(
          (key) => !this.answer[key]
        );

        if (unanswered.length) {
          alert("Answer all questions before submitting.");
          return; // stop right here
        }

        this.isLoading = true;

        const response = await fetch(this.urlappphp3, {
          method: "POST",
          headers: {
            "Content-type": "application/json",
          },
          body: JSON.stringify({
            action: "submits",
            id: this.$route.params.id,
            feedback: this.feedback,
            answers: this.answer,
            stid: this.id,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.isLoading = false;
          alert("Evaluation submitted successfully. Thank you!");
          this.$router.replace("/student");
        } else {
          console.log("Server error:", result.message);
        }
      } catch (error) {
        console.log(error);
      }
    },

    formClear() {
      this.feedback = "";
      this.answer = {};
    },

    skipLogin() {
      const token = getToken();

      if (!token) {
        console.error("No token found, redirecting to login.");
        this.$router.replace("/new-Dashboard");
        return;
      }
    },
  },

  mounted() {
    this.getQuestions();
    this.getTeacherbyid();
    this.formClear();
    this.skipLogin();
  },
};
</script>
<style scoped>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

body {
  background-color: #f0f7ff;
  color: #333;
  line-height: 1.6;
  padding: 1.25rem;
  font-size: 1rem;
}

.container {
  max-width: 75rem;
  margin: 0 auto;
  background: white;
  padding: 1.875rem;
  border-radius: 0.625rem;
  box-shadow: 0 0 1.25rem rgba(0, 0, 0, 0.1);
}

header {
  text-align: center;
  margin-bottom: 1.875rem;
  padding-bottom: 1.25rem;
  border-bottom: 2px solid #4a86e8;
}

h1 {
  color: #2c3e50;
  margin-bottom: 0.625rem;
  font-size: 2rem;
  font-weight: bold;
}

.intro {
  background-color: #e8f1ff;
  padding: 1.25rem;
  border-radius: 0.5rem;
  margin-bottom: 1.875rem;
  font-size: 1.125rem;
  font-weight: 500;
}

.info-fields {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 1.25rem;
  margin-bottom: 1.25rem;
}

.info-field {
  margin-bottom: 1rem;
}

.info-field label {
  display: block;
  font-weight: bold;
  margin-bottom: 0.5rem;
  color: #2c3e50;
  font-size: 1.125rem;
}

.info-field input,
.info-field select {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ccc;
  border-radius: 0.25rem;
  font-size: 1rem;
  transition: border-color 0.2s;
}

.info-field input:focus,
.info-field select:focus {
  outline: none;
  border-color: #4a86e8;
  box-shadow: 0 0 0 2px rgba(74, 134, 232, 0.2);
}

.rating-scale {
  background-color: #f8f9fa;
  padding: 1.25rem;
  border-radius: 0.5rem;
  margin-bottom: 1.875rem;
  border: 1px solid #dee2e6;
}

.rating-scale h2 {
  color: #2c3e50;
  margin-bottom: 1rem;
  text-align: center;
  font-size: 1.5rem;
  font-weight: bold;
}

table.rating-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 1.25rem;
  font-size: 1rem;
}

table.rating-table th,
table.rating-table td {
  border: 1px solid #dee2e6;
  padding: 0.75rem;
  text-align: center;
  font-weight: bold;
}

table.rating-table th {
  background-color: #4a86e8;
  color: white;
  font-size: 1.125rem;
}

table.rating-table tr:nth-child(even) {
  background-color: #f2f2f2;
}

.evaluation-section {
  margin-bottom: 2.5rem;
  page-break-inside: avoid;
}

.section-header {
  background-color: #4a86e8;
  color: white;
  padding: 1rem;
  border-radius: 0.5rem 0.5rem 0 0;
  margin-bottom: 0;
  font-size: 1.25rem;
  font-weight: bold;
}

.indicator-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 1.25rem;
  font-size: 1rem;
}

.indicator-table th,
.indicator-table td {
  border: 1px solid #dee2e6;
  padding: 0.75rem;
  vertical-align: top;
}

.indicator-table th {
  background-color: #e8f1ff;
  text-align: left;
  font-size: 1.125rem;
  font-weight: bold;
}

.indicator-table tr:nth-child(even) {
  background-color: #f8f9fa;
}

/* Make TD content behave like paragraphs */
.indicator-content {
  margin: 0;
  padding: 0;
}

.indicator-content p {
  margin-bottom: 0.75rem;
  line-height: 1.5;
}

.indicator-content p:last-child {
  margin-bottom: 0;
}

.rating-cell {
  min-width: 250px;
  width: 30%;
}

.rating-options {
  display: flex;
  justify-content: space-between;
  width: 100%;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.rating-option {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  flex: 1;
  min-width: 80px;
}

.rating-option input {
  margin: 0.25rem 0;
  transform: scale(1.2);
  cursor: pointer;
}

.rating-value {
  font-weight: bold;
  font-size: 1.125rem;
  margin-bottom: 0.25rem;
}

.rating-label {
  font-size: 0.75rem;
  color: #666;
  line-height: 1.2;
}

.feedback-section {
  margin-top: 2.5rem;
}

.feedback-section h2 {
  margin-bottom: 1rem;
  color: #2c3e50;
  font-size: 1.5rem;
  font-weight: bold;
}

textarea {
  width: 100%;
  height: 9.375rem;
  padding: 1rem;
  border: 1px solid #ccc;
  border-radius: 0.5rem;
  font-size: 1rem;
  resize: vertical;
  transition: border-color 0.2s;
}

textarea:focus {
  outline: none;
  border-color: #4a86e8;
  box-shadow: 0 0 0 2px rgba(74, 134, 232, 0.2);
}

.buttons {
  display: flex;
  justify-content: center;
  gap: 1.25rem;
  margin-top: 1.875rem;
  flex-wrap: wrap;
}

button {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 0.3125rem;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s;
  font-weight: bold;
  min-width: 120px;
}

button.print {
  background-color: #4a86e8;
  color: white;
}

button.submit {
  background-color: #2e7d32;
  color: white;
}

button.reset {
  background-color: #f44336;
  color: white;
}

button:hover {
  opacity: 0.9;
  transform: translateY(-2px);
}

footer {
  text-align: center;
  margin-top: 2.5rem;
  color: #666;
  font-size: 1rem;
  font-weight: 500;
}

/* Loading Screen */
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
  width: 2.5rem;
  height: 2.5rem;
  animation: spin 1s linear infinite;
  margin-bottom: 0.75rem;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.tagalog {
  font-style: italic;
  color: #555;
  display: block;
  margin-top: 0.25rem;
  font-size: 0.9rem;
}

/* Responsive Design */
@media (max-width: 768px) {
  body {
    padding: 1rem;
    font-size: 0.9rem;
  }

  .container {
    padding: 1.25rem;
  }

  .info-fields {
    grid-template-columns: 1fr;
    gap: 1rem;
  }

  .rating-options {
    flex-direction: column;
    gap: 0.75rem;
  }

  .rating-option {
    flex-direction: row;
    justify-content: flex-start;
    gap: 0.75rem;
    text-align: left;
    min-width: auto;
  }

  .indicator-table {
    display: block;
    overflow-x: auto;
  }

  .indicator-table th,
  .indicator-table td {
    min-width: 200px;
  }

  .rating-cell {
    width: 40%;
    min-width: 200px;
  }

  h1 {
    font-size: 1.5rem;
  }

  .intro {
    font-size: 1rem;
    padding: 1rem;
  }

  .buttons {
    flex-direction: column;
    align-items: center;
  }

  button {
    width: 100%;
    max-width: 250px;
  }

  .section-header {
    font-size: 1.125rem;
    padding: 0.75rem;
  }

  .indicator-content p {
    margin-bottom: 0.5rem;
    line-height: 1.4;
  }
}

@media (max-width: 480px) {
  body {
    padding: 0.75rem;
  }

  .container {
    padding: 1rem;
    border-radius: 0.5rem;
  }

  header {
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
  }

  h1 {
    font-size: 1.25rem;
  }

  .rating-scale h2,
  .feedback-section h2 {
    font-size: 1.25rem;
  }

  table.rating-table th,
  table.rating-table td {
    padding: 0.5rem;
    font-size: 0.875rem;
  }

  .indicator-table th,
  .indicator-table td {
    padding: 0.5rem;
    font-size: 0.875rem;
  }

  .rating-value {
    font-size: 1rem;
  }

  textarea {
    height: 7rem;
    padding: 0.75rem;
  }

  .indicator-content p {
    font-size: 0.875rem;
    line-height: 1.4;
  }

  .tagalog {
    font-size: 0.8rem;
  }
}

@media print {
  body {
    background-color: white;
    padding: 0;
    font-size: 0.875rem;
  }

  .container {
    box-shadow: none;
    padding: 0;
    max-width: none;
  }

  button {
    display: none;
  }

  h1 {
    font-size: 1.25rem;
  }

  .intro {
    background-color: transparent;
    border: 1px solid #ccc;
  }

  .rating-scale {
    border: 1px solid #ccc;
    background-color: transparent;
  }

  .section-header {
    background-color: #e8f1ff;
    color: #2c3e50;
    border: 1px solid #ccc;
  }

  .indicator-content p {
    margin-bottom: 0.5rem;
    line-height: 1.4;
  }
}

/* Utility Classes */
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}
</style>
