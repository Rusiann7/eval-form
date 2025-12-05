<template>
  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <div class="container">
    <header>
      <h1>
        <i class="fas fa-chalkboard-teacher"></i> PEER EVALUATION FOR TEACHERS
      </h1>
    </header>

    <div class="intro">
      <p>
        <strong
          >This form is designed to provide constructive feedback to colleagues
          based on observation and professional interaction. Please rate each
          indicator honestly and provide additional feedback where
          appropriate.</strong
        >
      </p>
    </div>

    <div class="info-fields">
      <div class="info-field">
        <label for="evaluator">Name of Evaluator:</label>
        <p class="info-value">{{ name }}</p>
      </div>

      <div class="info-field">
        <label for="teacher">Name of Teacher Subject for Evaluation:</label>
        <p class="info-value">{{ teacher.firstnm }} {{ teacher.lastnm }}</p>
      </div>

      <div class="info-field">
        <label for="date">Date of Evaluation:</label>
        <p class="info-value">{{ month }}</p>
      </div>

      <div class="info-field">
        <label for="subject">Subject/Observation Context:</label>
        <p class="info-value">{{ teacher.sub }}</p>
      </div>
    </div>

    <div class="rating-scale">
      <h2>Rating Scale</h2>
      <table class="rating-table">
        <thead>
          <tr>
            <th>Rating Scale</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>4.500-5.000</td>
            <td>Outstanding</td>
          </tr>
          <tr>
            <td>3.500-4.499</td>
            <td>Very Satisfactory</td>
          </tr>
          <tr>
            <td>2.500-3.499</td>
            <td>Satisfactory</td>
          </tr>
          <tr>
            <td>1.500-2.499</td>
            <td>Unsatisfactory</td>
          </tr>
          <tr>
            <td>1.000-1.499</td>
            <td>Poor</td>
          </tr>
        </tbody>
      </table>
      <p class="rating-note">
        <strong
          >Please rate the following aspects of your colleague's performance
          using the scale above:</strong
        >
      </p>
    </div>

    <div
      class="evaluation-section"
      v-for="header in headers"
      :key="header.header_id"
    >
      <h2 class="section-header">{{ header.header }}</h2>
      <table class="indicator-table">
        <thead>
          <tr>
            <th class="indicator-header">Indicator</th>
            <th class="rating-header">
              <div class="rating-options-header">
                <div class="rating-option-header">
                  <span class="rating-value-header">5</span>
                  <span class="rating-label-header">Outstanding</span>
                </div>
                <div class="rating-option-header">
                  <span class="rating-value-header">4</span>
                  <span class="rating-label-header">Very Satisfactory</span>
                </div>
                <div class="rating-option-header">
                  <span class="rating-value-header">3</span>
                  <span class="rating-label-header">Satisfactory</span>
                </div>
                <div class="rating-option-header">
                  <span class="rating-value-header">2</span>
                  <span class="rating-label-header">Unsatisfactory</span>
                </div>
                <div class="rating-option-header">
                  <span class="rating-value-header">1</span>
                  <span class="rating-label-header">Poor</span>
                </div>
              </div>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="question in header.questions" :key="question.question_id">
            <td class="question-cell">
              {{ question.question }}
            </td>
            <td class="rating-cell">
              <div class="rating-options">
                <label class="rating-option">
                  <input
                    type="radio"
                    :name="'rating:' + question.question_id"
                    value="5"
                    v-model="answer[question.question_id]"
                  />
                  <span class="radio-value">5</span>
                </label>
                <label class="rating-option">
                  <input
                    type="radio"
                    :name="'rating:' + question.question_id"
                    value="4"
                    v-model="answer[question.question_id]"
                  />
                  <span class="radio-value">4</span>
                </label>
                <label class="rating-option">
                  <input
                    type="radio"
                    :name="'rating:' + question.question_id"
                    value="3"
                    v-model="answer[question.question_id]"
                  />
                  <span class="radio-value">3</span>
                </label>
                <label class="rating-option">
                  <input
                    type="radio"
                    :name="'rating:' + question.question_id"
                    value="2"
                    v-model="answer[question.question_id]"
                  />
                  <span class="radio-value">2</span>
                </label>
                <label class="rating-option">
                  <input
                    type="radio"
                    :name="'rating:' + question.question_id"
                    value="1"
                    v-model="answer[question.question_id]"
                  />
                  <span class="radio-value">1</span>
                </label>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="feedback-section">
      <h2 class="feedback-title">PROFESSIONAL FEEDBACK FOR COLLEAGUE DEVELOPMENT</h2>
      <textarea
        placeholder="Please provide constructive feedback for your colleague's professional growth..."
        v-model="feedback"
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
          >This evaluation is intended for professional development purposes.
          All responses will be kept confidential.</strong
        >
      </p>
    </footer>
  </div>
</template>

<script>
import { removeToken, getToken } from "../../utils/auth";

const url1 = "https://rusiann7.helioho.st";
const url2 = "https://star-panda-literally.ngrok-free.app";
//const url2 = "http://localhost:8000";

export default {
  name: "tcEval",
  data() {
    return {
      urlappphp: `${url2}/questiont.php`,
      urlappphp2: `${url2}/idGetter.php`,
      urlappphp3: `${url2}/submitt.php`,
      headers: [],
      teacher: {},
      date: new Date().getDate(),
      month: "",
      year: new Date().getFullYear(),
      feedback: "",
      answer: {},
      isLoading: false,
      name:
        JSON.parse(localStorage.getItem("userData") || "{}").fullname ||
        "Evaluator Name",
      id: JSON.parse(localStorage.getItem("userData") || "{}").id || null,
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
          this.isLoading = false;
          this.headers = result.headers;
        } else {
          console.error("Error fetching questions:", result.message);
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
        // Check if all questions are answered
        const unanswered = Object.keys(this.answer).filter(
          (key) => !this.answer[key]
        );
        
        if (unanswered.length) {
          alert("Please answer all questions before submitting.");
          return;
        }

        this.isLoading = true;

        console.log(this.answer, this.feedback, this.$route.params.id, this.id);

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
          this.$router.replace("/teacher");
        } else {
          console.log("Server error:", result.message);
          alert("Error submitting evaluation. Please try again.");
          this.isLoading = false;
        }
      } catch (error) {
        console.log(error);
        this.isLoading = false;
        alert("Network error. Please check your connection and try again.");
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
  font-size: 16px; /* Base font size */
}

.container {
  max-width: 75rem;
  margin: 0 auto;
  background: white;
  padding: 2rem;
  border-radius: 0.75rem;
  box-shadow: 0 0 1.5rem rgba(0, 0, 0, 0.1);
}

/* Header Styles */
header {
  text-align: center;
  margin-bottom: 2rem;
  padding-bottom: 1.5rem;
  border-bottom: 3px solid #4a86e8;
}

h1 {
  color: #2c3e50;
  margin-bottom: 0.75rem;
  font-size: 2.5rem; /* Increased from 2rem */
  font-weight: 700;
}

h1 i {
  margin-right: 0.75rem;
  color: #4a86e8;
}

/* Intro Section */
.intro {
  background-color: #e8f1ff;
  padding: 1.5rem;
  border-radius: 0.75rem;
  margin-bottom: 2rem;
  font-size: 1.25rem; /* Increased from 1.125rem */
  font-weight: 500;
  line-height: 1.7;
}

/* Info Fields */
.info-fields {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.info-field {
  background: #f8fafc;
  padding: 1.25rem;
  border-radius: 0.5rem;
  border-left: 4px solid #4a86e8;
}

.info-field label {
  display: block;
  font-weight: 600;
  margin-bottom: 0.5rem;
  color: #2c3e50;
  font-size: 1.125rem; /* Increased from 1rem */
}

.info-value {
  font-size: 1.125rem; /* Increased from 1rem */
  color: #1a202c;
  font-weight: 500;
}

/* Rating Scale */
.rating-scale {
  background-color: #f8f9fa;
  padding: 1.75rem;
  border-radius: 0.75rem;
  margin-bottom: 2.5rem;
  border: 1px solid #dee2e6;
}

.rating-scale h2 {
  color: #2c3e50;
  margin-bottom: 1.25rem;
  text-align: center;
  font-size: 1.75rem; /* Increased from 1.5rem */
  font-weight: 600;
}

table.rating-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 1.5rem;
  font-size: 1.125rem; /* Increased from 1rem */
}

table.rating-table th,
table.rating-table td {
  border: 2px solid #dee2e6;
  padding: 1rem;
  text-align: center;
  font-weight: 600;
}

table.rating-table th {
  background-color: #4a86e8;
  color: white;
  font-size: 1.25rem; /* Increased from 1.125rem */
  padding: 1.25rem;
}

table.rating-table tr:nth-child(even) {
  background-color: #f2f2f2;
}

.rating-note {
  text-align: center;
  font-size: 1.125rem; /* Increased from 1rem */
  color: #2c3e50;
  padding-top: 0.5rem;
}

/* Evaluation Sections */
.evaluation-section {
  margin-bottom: 3rem;
  page-break-inside: avoid;
}

.section-header {
  background-color: #4a86e8;
  color: white;
  padding: 1.25rem;
  border-radius: 0.75rem 0.75rem 0 0;
  margin-bottom: 0;
  font-size: 1.5rem; /* Increased from 1.25rem */
  font-weight: 600;
  text-align: center;
}

.indicator-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 1.5rem;
  font-size: 1.125rem; /* Increased from 1rem */
}

.indicator-table th,
.indicator-table td {
  border: 1px solid #dee2e6;
  padding: 1.25rem;
  vertical-align: top;
}

.indicator-header {
  background-color: #e8f1ff;
  text-align: left;
  font-size: 1.25rem; /* Increased from 1.125rem */
  font-weight: 600;
  width: 70%;
}

.rating-header {
  background-color: #e8f1ff;
  text-align: center;
  font-weight: 600;
  width: 30%;
}

.rating-options-header {
  display: flex;
  justify-content: space-around;
  width: 100%;
  gap: 0.5rem;
}

.rating-option-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  flex: 1;
  min-width: 0;
}

.rating-value-header {
  font-weight: 700;
  font-size: 1.25rem; /* Increased from 1.125rem */
  margin-bottom: 0.25rem;
}

.rating-label-header {
  font-size: 0.75rem; /* Smaller for 5 options */
  color: #2c3e50;
  line-height: 1.2;
  font-weight: 500;
}

.indicator-table tr:nth-child(even) {
  background-color: #f8f9fa;
}

/* Question Cell */
.question-cell {
  padding: 1.25rem;
  font-size: 1.125rem; /* Increased from 1rem */
  line-height: 1.6;
  color: #1a202c;
}

/* Rating Cell */
.rating-cell {
  min-width: 320px;
  width: 30%;
  padding: 1rem;
}

.rating-options {
  display: flex;
  justify-content: space-around;
  width: 100%;
  gap: 0.25rem;
}

.rating-option {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  flex: 1;
  cursor: pointer;
  padding: 0.75rem 0.5rem;
  border-radius: 0.5rem;
  transition: background-color 0.2s;
  min-width: 0;
}

.rating-option:hover {
  background-color: #f0f7ff;
}

.rating-option input {
  margin: 0.5rem 0;
  transform: scale(1.3);
  cursor: pointer;
}

.radio-value {
  font-weight: 700;
  font-size: 1.25rem; /* Increased from 1.125rem */
  color: #2c3e50;
}

/* Feedback Section */
.feedback-section {
  margin-top: 3rem;
  background: #f8fafc;
  padding: 2rem;
  border-radius: 0.75rem;
}

.feedback-title {
  margin-bottom: 1.5rem;
  color: #2c3e50;
  font-size: 1.5rem; /* Increased from 1.5rem */
  font-weight: 600;
  line-height: 1.5;
  text-align: center;
}

textarea {
  width: 100%;
  height: 10rem;
  padding: 1.25rem;
  border: 2px solid #cbd5e0;
  border-radius: 0.75rem;
  font-size: 1.125rem; /* Increased from 1rem */
  resize: vertical;
  transition: border-color 0.2s;
  font-family: inherit;
}

textarea:focus {
  outline: none;
  border-color: #4a86e8;
  box-shadow: 0 0 0 3px rgba(74, 134, 232, 0.2);
}

/* Buttons */
.buttons {
  display: flex;
  justify-content: center;
  gap: 1.5rem;
  margin-top: 2.5rem;
  flex-wrap: wrap;
}

button {
  padding: 1rem 2rem;
  border: none;
  border-radius: 0.5rem;
  font-size: 1.125rem; /* Increased from 1rem */
  cursor: pointer;
  transition: all 0.3s;
  font-weight: 600;
  min-width: 180px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
}

button i {
  font-size: 1.125rem;
}

button.submit {
  background-color: #2e7d32;
  color: white;
}

button.submit:hover {
  background-color: #1b5e20;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
}

button.reset {
  background-color: #d32f2f;
  color: white;
}

button.reset:hover {
  background-color: #b71c1c;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(211, 47, 47, 0.3);
}

/* Footer */
footer {
  text-align: center;
  margin-top: 3rem;
  padding-top: 1.5rem;
  border-top: 2px solid #e2e8f0;
  color: #4a5568;
  font-size: 1.125rem; /* Increased from 1rem */
  font-weight: 500;
}

/* Loading Screen */
.loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  z-index: 3000;
  color: white;
}

.loading-spinner {
  border: 6px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top: 6px solid #ffffff;
  width: 4rem;
  height: 4rem;
  animation: spin 1s linear infinite;
  margin-bottom: 1.5rem;
}

.loading-screen p {
  font-size: 1.5rem;
  font-weight: 500;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 1024px) {
  .container {
    padding: 1.5rem;
    max-width: 95%;
  }
  
  h1 {
    font-size: 2rem;
  }
  
  .intro {
    font-size: 1.125rem;
  }
  
  .section-header {
    font-size: 1.375rem;
  }
  
  .rating-options-header {
    gap: 0.25rem;
  }
  
  .rating-label-header {
    font-size: 0.6875rem;
  }
}

@media (max-width: 768px) {
  body {
    padding: 1rem;
    font-size: 15px;
  }

  .container {
    padding: 1.25rem;
    border-radius: 0.5rem;
  }

  .info-fields {
    grid-template-columns: 1fr;
    gap: 1rem;
  }

  .rating-table {
    display: block;
    overflow-x: auto;
  }

  .rating-options-header {
    flex-direction: column;
    gap: 0.5rem;
  }

  .rating-option-header {
    flex-direction: row;
    justify-content: flex-start;
    gap: 0.5rem;
    text-align: left;
  }

  .rating-label-header {
    font-size: 0.75rem;
  }

  .indicator-table {
    display: block;
    overflow-x: auto;
  }

  .rating-cell {
    min-width: 250px;
  }

  h1 {
    font-size: 1.75rem;
  }

  .intro {
    font-size: 1rem;
    padding: 1.25rem;
  }

  .buttons {
    flex-direction: column;
    align-items: center;
  }

  button {
    width: 100%;
    max-width: 300px;
    padding: 0.875rem 1.5rem;
  }

  .section-header {
    font-size: 1.25rem;
    padding: 1rem;
  }

  .feedback-title {
    font-size: 1.25rem;
  }
  
  .rating-options {
    flex-wrap: wrap;
    justify-content: center;
  }
  
  .rating-option {
    min-width: 50px;
    flex: none;
  }
}

@media (max-width: 480px) {
  body {
    padding: 0.75rem;
    font-size: 14px;
  }

  .container {
    padding: 1rem;
    border-radius: 0.5rem;
  }

  header {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
  }

  h1 {
    font-size: 1.5rem;
  }

  .rating-scale h2,
  .feedback-section h2 {
    font-size: 1.25rem;
  }

  table.rating-table th,
  table.rating-table td {
    padding: 0.75rem;
    font-size: 0.9375rem;
  }

  .indicator-table th,
  .indicator-table td {
    padding: 0.75rem;
    font-size: 0.9375rem;
  }

  .rating-cell {
    padding: 0.75rem;
    min-width: 200px;
  }

  .rating-options {
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.5rem;
  }

  .rating-option {
    flex-direction: row;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.5rem;
    min-width: 40px;
  }

  .radio-value {
    font-size: 1.125rem;
  }

  textarea {
    height: 8rem;
    padding: 1rem;
    font-size: 1rem;
  }

  button {
    padding: 0.875rem 1.25rem;
    font-size: 1rem;
  }
  
  .question-cell {
    font-size: 1rem;
    line-height: 1.5;
  }
  
  .rating-options-header {
    display: none; /* Hide header rating labels on very small screens */
  }
}

@media (max-width: 360px) {
  .rating-options {
    flex-direction: column;
    align-items: stretch;
  }
  
  .rating-option {
    flex-direction: row;
    justify-content: space-between;
    padding: 0.75rem;
  }
}

/* Print Styles */
@media print {
  body {
    background-color: white;
    padding: 0;
    font-size: 14px;
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
    font-size: 1.5rem;
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
  
  .rating-options-header {
    display: flex !important;
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