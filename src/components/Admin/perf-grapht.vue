<template>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap"
    rel="stylesheet"
  />
  <link
    href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined"
    rel="stylesheet"
  />

  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <div class="container">
    <main class="main-grid">
      <section class="card">
        <h2 class="card-title">Graph of Performance</h2>

        <Bar :data="chartData" :options="chartOptions" />
      </section>
      <section class="card">
        <h2 class="card-title">A.I. Summarizer</h2>
        <div class="ai-response">
          <p class="response-text">{{ geminiOutput }}</p>
        </div>
      </section>
    </main>
  </div>
</template>

<script>
import { Bar } from "vue-chartjs";

import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from "chart.js";

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

const url1 = "https://rusiann7.helioho.st";
const url2 = "https://star-panda-literally.ngrok-free.app";

export default {
  name: "graphPerformance",
  components: { Bar },
  data() {
    return {
      aiphp: `${url2}/chartGettert.php`,
      chartphp: `${url2}/chartGettert.php`,
      urlappphp: `${url2}/questiontAll.php`,
      urlappphp3: `${url2}/mergeAntGetter.php`,
      gemini: null,
      geminiOutput: "",
      averages: [],
      isLoading: false,
      isSuccess: false,
      isFailed: false,
      chartData: {
        labels: [],
        datasets: [],
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        scales: {
          x: { display: false },
          y: { beginAtZero: true },
        },
      },
      airesponse: null,
      headers: [],
      answers: {},
      teacher: {},
      answer: {},
    };
  },

  methods: {
    async getChartData() {
      try {
        this.isLoading = true;

        const response = await fetch(this.chartphp, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "getChartDataT",
            tcr_id: this.$route.params.id,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.averages = result.average.map((average) => ({
            avg: average.average,
          }));

          console.log(this.averages);

          this.chartData = {
            labels: this.averages.map((_, i) => `Q${i + 1}`),
            datasets: [
              {
                label: "Average",
                data: this.averages.map((a) => a.avg),
                backgroundColor: "rgba(75, 192, 192, 0.5)",
              },
            ],
          };

          this.isLoading = false;
          this.isSuccess = true;
        } else {
          this.isLoading = false;
          this.isFailed = true;
        }
      } catch (error) {
        console.error(error);
      }
    },

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

    async getAnswers() {
      try {
        this.isLoading = true;

        const response = await fetch(this.urlappphp3, {
          method: "POST",
          headers: { "Content-type": "application/json" },
          body: JSON.stringify({
            action: "teacher",
            evt: this.$route.params.evtid,
            tcr: this.$route.params.id,
          }),
        });

        const result = await response.json();

        if (result.success) {
          const sessionData = Object.values(result.answer)[0];

          this.month = sessionData.time;
          this.answer = sessionData;
          this.isLoading = false;

          this.answers = {};
          for (const ans of result.answer) {
            this.answers[Number(ans.question_id)] = Number(
              ans.score.toFixed(1)
            );
          }
        }
      } catch (error) {
        console.log(error);
        this.isLoading = false;
      }
    },

    async runAI() {
      if (
        !this.headers.length &&
        !Object.keys(this.answers).length &&
        !this.averages.length
      ) {
        console.warn("AI skipped: missing data.");
        return;
      }

      const allQuestions = [];
      this.headers.forEach((header) => {
        if (header.questions && Array.isArray(header.questions)) {
          header.questions.forEach((question) => {
            allQuestions.push({
              question_id: question.question_id,
              question: question.question,
              header: header.header,
            });
          });
        }
      });

      const payload = {
        categories: this.headers.map((header) => ({
          category: header.header,
          question_count: header.questions ? header.questions.length : 0,
        })),
        questions: allQuestions,
        answers: this.answers,
        averages: this.averages.map((avg) => avg.avg),
      };

      const prompt = `Summarize teacher performance based strictly on the provided dataset.

      DATA:
      ${JSON.stringify(payload, null, 2)}

        REQUIREMENTS:
        - Identify strengths and weaknesses based only on the numbers.
        - Provide a short bullet summary that a school admin can instantly understand.
        - DO NOT invent data.
        - Base the entire evaluation only on the correlations between questions, answers, and averages.
        - Be concise but accurate.
        `;

      const { GoogleGenAI } = await import("@google/genai");
      this.gemini = new GoogleGenAI({
        apiKey: "AIzaSyDpAiyG5Cm_pNIzIOcH6pM_vOGCjfeOMw0",
      });
      const res = await this.gemini.models.generateContent({
        model: "gemini-2.5-flash",
        contents: prompt,
      });
      this.geminiOutput = res.text;
    },
  },

  mounted() {
    Promise.all([this.getChartData(), this.getQuestions(), this.getAnswers()])
      .then(() => {
        this.runAI();
      })
      .catch((error) => {
        console.error("Error loading data:", error);
      });
  },
};
</script>

<style scoped>
/* Base Styles - Consistent with other components */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: "Inter", "Roboto", "Segoe UI", Tahoma, Geneva, Verdana,
    sans-serif;
  background-color: #ffffff;
  color: #000000;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
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
  line-height: 1.6;
}

/* Container */
.container {
  display: flex;
  flex-direction: column;
  height: 100vh;
  padding: 1.5rem;
  width: 100%;
}

@media (min-width: 768px) {
  .container {
    padding: 2rem;
  }
}

@media (min-width: 1024px) {
  .container {
    padding: 2.5rem;
    max-width: 1600px;
    margin: 0 auto;
  }
}

/* Main Grid */
.main-grid {
  flex: 1;
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
  width: 100%;
}

@media (min-width: 1024px) {
  .main-grid {
    grid-template-columns: 1fr 1fr;
    gap: 2.5rem;
  }
}

@media (min-width: 1400px) {
  .main-grid {
    gap: 3rem;
  }
}

/* Cards */
.card {
  background-color: #ffffff;
  border: 2px solid #e2e8f0;
  border-radius: 1rem;
  box-shadow: 0 8px 16px -1px rgba(0, 0, 0, 0.1),
    0 4px 8px -1px rgba(0, 0, 0, 0.06);
  padding: 2rem;
  display: flex;
  flex-direction: column;
  min-height: 400px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 16px 32px -2px rgba(0, 0, 0, 0.15),
    0 8px 16px -2px rgba(0, 0, 0, 0.1);
}

@media (min-width: 768px) {
  .card {
    padding: 2.5rem;
    min-height: 450px;
  }
}

@media (min-width: 1400px) {
  .card {
    min-height: 500px;
  }
}

/* Card Title */
.card-title {
  font-size: 1.75rem;
  font-weight: 700;
  color: #000000;
  margin-bottom: 2rem;
  padding-bottom: 1rem;
  border-bottom: 2px solid #f0f0f0;
  text-align: center;
}

@media (min-width: 768px) {
  .card-title {
    font-size: 2rem;
  }
}

@media (min-width: 1024px) {
  .card-title {
    font-size: 2.25rem;
    text-align: left;
  }
}

/* Chart Container */
.chart-container {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: #f8fafc;
  border-radius: 0.75rem;
  padding: 1.5rem;
  min-height: 300px;
}

@media (min-width: 768px) {
  .chart-container {
    padding: 2rem;
  }
}

/* AI Response Section */
.ai-response {
  flex: 1;
  background-color: #f8fafc;
  border-radius: 0.75rem;
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  min-height: 300px;
}

@media (min-width: 768px) {
  .ai-response {
    padding: 2rem;
  }
}

.response-text {
  color: #374151;
  font-size: 1.25rem;
  line-height: 1.7;
  text-align: center;
  margin: 0;
}

@media (min-width: 768px) {
  .response-text {
    font-size: 1.5rem;
    line-height: 1.8;
  }
}

@media (min-width: 1024px) {
  .response-text {
    text-align: left;
    font-size: 1.375rem;
  }
}

/* Graph Placeholder */
.graph-placeholder {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: #f8fafc;
  border-radius: 0.75rem;
  padding: 2rem;
}

.placeholder-content {
  text-align: center;
  color: #64748b;
}

.placeholder-icon {
  width: 5rem;
  height: 5rem;
  margin: 0 auto 1.5rem auto;
  color: #94a3b8;
}

.placeholder-text-lg {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
  color: #374151;
}

.placeholder-text-sm {
  font-size: 1.1rem;
  color: #6b7280;
}

/* Chart.js Customization */
:deep(canvas) {
  width: 100% !important;
  height: auto !important;
  max-height: 350px;
}

@media (min-width: 768px) {
  :deep(canvas) {
    max-height: 400px;
  }
}

@media (min-width: 1400px) {
  :deep(canvas) {
    max-height: 450px;
  }
}

/* Input Container */
.input-container {
  margin-top: 2rem;
  display: flex;
  align-items: center;
  gap: 1rem;
  width: 100%;
}

.input-wrapper {
  position: relative;
  flex: 1;
}

.text-input {
  width: 100%;
  padding: 1rem 1rem 1rem 1.5rem;
  font-size: 1.1rem;
  border-radius: 0.75rem;
  border: 2px solid #cbd5e0;
  background-color: #ffffff;
  color: #000000;
  transition: all 0.2s ease-in-out;
  min-height: 3.5rem;
}

.text-input::placeholder {
  color: #94a3b8;
  font-size: 1rem;
}

.text-input:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
  border-color: #000000;
}

.send-button {
  position: absolute;
  top: 50%;
  right: 0.75rem;
  transform: translateY(-50%);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0.5rem;
  color: #64748b;
  background: none;
  border: none;
  cursor: pointer;
  transition: color 0.2s ease-in-out;
  border-radius: 50%;
}

.send-button:hover {
  color: #000000;
  background-color: #f3f4f6;
}

.send-icon {
  font-size: 1.5rem;
}

/* Loading States */
.loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.9);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  z-index: 3000;
  color: white;
}

.loading-spinner {
  border: 5px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top: 5px solid #ffffff;
  width: 60px;
  height: 60px;
  animation: spin 1s linear infinite;
  margin-bottom: 1.5rem;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

/* Mobile-specific adjustments */
@media (max-width: 640px) {
  .container {
    padding: 1rem;
    height: auto;
    min-height: 100vh;
  }

  .main-grid {
    gap: 1.5rem;
  }

  .card {
    padding: 1.5rem;
    min-height: 350px;
  }

  .card-title {
    font-size: 1.5rem;
    text-align: center;
  }

  .response-text {
    font-size: 1.1rem;
    text-align: center;
  }

  .placeholder-text-lg {
    font-size: 1.25rem;
  }

  .placeholder-text-sm {
    font-size: 1rem;
  }
}

/* Tablet adjustments */
@media (min-width: 641px) and (max-width: 1023px) {
  .container {
    padding: 1.5rem;
  }

  .main-grid {
    gap: 2rem;
  }

  .card {
    min-height: 400px;
  }
}

/* Focus states for accessibility */
button:focus,
input:focus {
  outline: 3px solid #000000;
  outline-offset: 2px;
}

/* Success/Error Messages */
.success-message,
.error-message {
  position: fixed;
  top: 1.5rem;
  left: 50%;
  transform: translateX(-50%);
  padding: 1rem 2rem;
  border-radius: 0.5rem;
  font-weight: 600;
  z-index: 1000;
  text-align: center;
  min-width: 300px;
  max-width: 90%;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  font-size: 1.1rem;
}

.success-message {
  background-color: #10b981;
  color: #ffffff;
  border: 2px solid #059669;
}

.error-message {
  background-color: #ef4444;
  color: #ffffff;
  border: 2px solid #dc2626;
}
</style>
