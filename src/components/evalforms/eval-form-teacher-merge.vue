<template>
  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <div class="a4-page">
    <!--  <div class="watermark">JAMES L. GORDON INTEGRATED SCHOOL</div> -->

    <div class="header">
      <div class="logo-left">
        <img src="/src/assets/depedlogo.png" alt="Left Logo DepEd logo" />
      </div>
      <div class="header-content">
        <h1>Republic of The Philippines</h1>
        <h2>Department of Education</h2>
        <h3>SCHOOLS DIVISION OF OLONGAPO CITY</h3>
        <!-- <h4>JAMES L. GORDON INTEGRATED SCHOOL</h4> -->
      </div>
      <div class="logo-right">
        <img
          src="/src/assets/bagongpinas.png"
          alt="Right Logo Bagong Pinas logo"
        />
      </div>
    </div>

    <div class="content">
      <div class="info-fields">
        <div class="info-field">
          <label for="student">Pangalan:</label>
          <p>{{ name.firstname }} {{ name.lastname }} ({{ name.stid }})</p>
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
            >Please rate the following aspects of your teacher's performance
            using the scale above:</strong
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
          {{ header.header }}
          <span class="tagalog">{{ header.header_p }}</span>
        </h2>
        <table class="indicator-table">
          <thead>
            <tr>
              <th>Questions</th>
              <!--ito yung sa taas-->
              <th class="rating-cell">
                <div class="rating-options">
                  <div class="rating-option">
                    <span class="rating-label">Ratings</span>
                  </div>
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="question in header.questions"
              :key="question.question_id"
            >
              <!--dito mo lagay yung v-for-->
              <td>
                {{ question.question }}<br />
                <!--tanong tagalog-->
              </td>
              <td class="rating-cell">
                {{ answers[Number(question.question_id)] || "N/A" }}
              </td>
            </tr>
            <tr></tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="footer">
      <div class="footer-logo">
        <img src="/src/assets/JLGISlogo.png" alt="Footer Logo JLGIS logo" />
      </div>
      <div class="footer-content">
        <div class="footer-line">
          <strong>Address:</strong> Foster St. Brgy. Kababae, Olongapo City 2200
        </div>
        <div class="footer-line"><strong>Tel. no.:</strong> (047) 222-4769</div>
        <div class="footer-line">
          <strong>Email:</strong> 500027@deped.gov.ph / 500027@r3-2.deped.gov.ph
        </div>
        <div class="footer-line">
          <strong>Facebook Page:</strong>
          depedtayojameslgordonintegratedschool
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const url1 = "https://rusiann7.helioho.st";
const url2 = "https://star-panda-literally.ngrok-free.app";

export default {
  name: "printEval",
  data() {
    return {
      urlappphp: `${url2}/questiontAll.php`,
      urlappphp2: `${url2}/idGetter.php`,
      urlappphp3: `${url2}/mergeAntGetter.php`,
      urlappphp4: `${url2}/evttGetter.php`,
      name: {},
      month: "",
      headers: [],
      answers: {},
      teacher: {},
      answer: {},
      date: new Date().getDate(),
      year: new Date().getFullYear(),
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
            id: this.$route.params.tcrid,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.teacher = result.teacher;
          this.isLoading = false;
        } else {
          console.log("Server error:", result.message);
        }
      } catch (error) {
        console.log(error);
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
            tcr: this.$route.params.tcrid,
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

    async getStudentbyid() {
      try {
        this.isLoading = true;

        const response = await fetch(this.urlappphp4, {
          method: "POST",
          headers: {
            "Content-type": "application/json",
          },
          body: JSON.stringify({
            action: "getstudentbyid",
            evt: this.$route.params.evtid,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.name = result.student;
          this.isLoading = false;
        } else {
          console.log("Server error:", result.message);
        }
      } catch (error) {
        console.log(error);
        this.isLoading = false;
      }
    },
  },

  mounted() {
    this.getTeacherbyid();
    this.getQuestions();
    this.getAnswers();
    this.getStudentbyid();
  },
};
</script>

<style scoped>
/* Set page size to A4 */
@page {
  size: A4;
  margin: 0mm;
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

/* Base font size increased */
:root {
  --base-font-size: 16px;
  --scale-factor: 1.1;
}

body {
  margin: 0;
  padding: 0;
  font-family: "Arial", sans-serif;
  background-color: #f0f0f0;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  font-size: var(--base-font-size);
  line-height: 1.5;
}

.a4-page {
  width: 210mm;
  min-height: 297mm;
  background: white;
  position: relative;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  max-width: 100%;
}

/* Header styles */
.header {
  display: flex;
  align-items: center;
  text-align: center;
  padding: 1rem 0.5rem;
  border-bottom: 2px solid #0044cc;
  background-color: #f8f9fa;
  position: relative;
  flex-wrap: wrap;
  gap: 0.75rem;
}

.logo-left,
.logo-right {
  width: 4.5rem;
  height: 4.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 0.5rem;
  flex-shrink: 0;
}

.logo-left img,
.logo-right img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.header-content {
  flex: 1;
  min-width: 250px;
}

.header h1 {
  font-size: 1.125rem;
  margin: 0.25rem 0;
  font-weight: bold;
  color: #003366;
  line-height: 1.3;
}

.header h2 {
  font-size: 1rem;
  margin: 0.15rem 0;
  font-weight: 600;
  color: #0044aa;
  line-height: 1.3;
}

.header h3 {
  font-size: 0.9375rem;
  margin: 0.15rem 0;
  font-weight: 600;
  color: #005588;
  line-height: 1.3;
}

.content {
  padding: 1rem 1.25rem;
}

.info-fields {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1rem;
  margin: 1.5rem 0;
  padding: 0.75rem;
  background-color: #f8f9fa;
  border-radius: 0.5rem;
  border: 1px solid #dee2e6;
}

.info-field {
  margin-bottom: 0.5rem;
}

.info-field label {
  display: block;
  font-weight: bold;
  margin-bottom: 0.25rem;
  color: #2c3e50;
  font-size: 1rem;
}

.info-field p {
  font-size: 1.0625rem;
  color: #333;
  padding: 0.375rem 0;
  min-height: 1.5rem;
}

.evaluation-section {
  margin: 2rem 0;
  page-break-inside: avoid;
}

.section-header {
  background-color: #4a86e8;
  color: white;
  padding: 0.875rem;
  border-radius: 0.4rem 0.4rem 0 0;
  margin-bottom: 0;
  font-size: 1.375rem;
  font-weight: bold;
}

.tagalog {
  display: block;
  font-size: 1rem;
  font-weight: normal;
  opacity: 0.9;
  margin-top: 0.25rem;
}

.indicator-table {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
  font-size: 1rem;
  border: 1px solid #dee2e6;
}

.indicator-table thead {
  background-color: #e9ecef;
}

.indicator-table th {
  padding: 0.875rem 0.75rem;
  text-align: left;
  font-weight: bold;
  color: #495057;
  border-bottom: 2px solid #dee2e6;
  font-size: 1.0625rem;
}

.indicator-table td {
  padding: 0.875rem 0.75rem;
  border-bottom: 1px solid #dee2e6;
  vertical-align: top;
}

.indicator-table tbody tr:nth-child(even) {
  background-color: #f8f9fa;
}

.indicator-table tbody tr:hover {
  background-color: #e9ecef;
}

.indicator-table td:first-child {
  width: 70%;
  word-wrap: break-word;
  line-height: 1.6;
}

.indicator-table td:last-child {
  width: 30%;
  text-align: center;
  font-weight: bold;
  font-size: 1.125rem;
}

.rating-cell {
  text-align: center;
}

.rating-scale {
  background-color: #f8f9fa;
  padding: 1rem;
  border-radius: 0.5rem;
  margin: 1.5rem 0;
  border: 1px solid #dee2e6;
}

.rating-scale h2 {
  color: #2c3e50;
  margin-bottom: 1rem;
  text-align: center;
  font-size: 1.5rem;
  font-weight: bold;
}

.rating-scale p {
  font-size: 1.0625rem;
  line-height: 1.6;
  margin-top: 1rem;
}

.rating-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 1rem;
  font-size: 1rem;
}

.rating-table th,
.rating-table td {
  border: 1px solid #dee2e6;
  padding: 0.875rem;
  text-align: center;
}

.rating-table th {
  background-color: #4a86e8;
  color: white;
  font-size: 1.0625rem;
  font-weight: bold;
}

.rating-table tr:nth-child(even) {
  background-color: #f2f2f2;
}

.rating-table td {
  font-weight: 600;
}

/* Footer styles */
.footer {
  padding: 1rem 1.25rem;
  border-top: 2px solid #0044cc;
  background-color: #f8f9fa;
  margin-top: 2rem;
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
}

.footer-logo {
  width: 3.5rem;
  height: 3.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.footer-logo img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.footer-content {
  flex: 1;
  min-width: 300px;
}

.footer-line {
  margin: 0.25rem 0;
  line-height: 1.4;
  font-size: 0.9375rem;
}

.footer-line strong {
  color: #003366;
}

.watermark {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) rotate(-45deg);
  font-size: 3rem;
  color: rgba(0, 0, 0, 0.05);
  pointer-events: none;
  z-index: -1;
  text-align: center;
  white-space: nowrap;
  font-weight: bold;
}

.loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.85);
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
  width: 4rem;
  height: 4rem;
  animation: spin 1s linear infinite;
  margin-bottom: 1rem;
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

.loading-screen p {
  font-size: 1.25rem;
  font-weight: 500;
}

/* Responsive Design */
@media screen and (max-width: 1024px) {
  :root {
    --base-font-size: 15px;
  }

  .a4-page {
    width: 100%;
    margin: 0.5rem;
  }

  .header {
    padding: 0.875rem 0.75rem;
  }
}

@media screen and (max-width: 768px) {
  :root {
    --base-font-size: 14px;
  }

  body {
    padding: 0.5rem;
    align-items: flex-start;
  }

  .header {
    flex-direction: column;
    text-align: center;
    padding: 1rem;
    gap: 0.5rem;
  }

  .logo-left,
  .logo-right {
    width: 3.5rem;
    height: 3.5rem;
    margin: 0.25rem 0;
  }

  .header-content {
    width: 100%;
  }

  .content {
    padding: 0.75rem;
  }

  .info-fields {
    grid-template-columns: 1fr;
    gap: 0.75rem;
    padding: 0.75rem;
  }

  .section-header {
    font-size: 1.25rem;
    padding: 0.75rem;
  }

  .indicator-table {
    display: block;
    overflow-x: auto;
    table-layout: auto;
  }

  .indicator-table th,
  .indicator-table td {
    padding: 0.75rem 0.5rem;
    min-width: 120px;
  }

  .indicator-table td:first-child {
    min-width: 200px;
  }

  .rating-scale {
    padding: 0.875rem;
  }

  .rating-scale h2 {
    font-size: 1.25rem;
  }

  .rating-table th,
  .rating-table td {
    padding: 0.5rem;
  }

  .footer {
    flex-direction: column;
    text-align: center;
    padding: 1rem;
  }

  .footer-content {
    width: 100%;
  }

  .watermark {
    font-size: 2rem;
  }
}

@media screen and (max-width: 480px) {
  :root {
    --base-font-size: 13px;
  }

  body {
    padding: 0.25rem;
  }

  .content {
    padding: 0.5rem;
  }

  .header h1 {
    font-size: 1rem;
  }

  .header h2 {
    font-size: 0.9375rem;
  }

  .header h3 {
    font-size: 0.875rem;
  }

  .section-header {
    font-size: 1.125rem;
    padding: 0.625rem;
  }

  .tagalog {
    font-size: 0.875rem;
  }

  .indicator-table {
    font-size: 0.9375rem;
  }

  .rating-scale h2 {
    font-size: 1.125rem;
  }

  .rating-table {
    font-size: 0.9375rem;
  }

  .info-field label,
  .info-field p {
    font-size: 0.9375rem;
  }
}

/* Print styles - Improved for better printing */
@media print {
  :root {
    --base-font-size: 13pt;
  }

  body {
    background: none;
    margin: 0;
    padding: 0;
    font-size: var(--base-font-size);
    line-height: 1.4;
  }

  .a4-page {
    box-shadow: none;
    margin: 0;
    width: 210mm;
    height: auto;
    min-height: 297mm;
    page-break-after: always;
  }

  /* Header for every printed page */
  .header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    padding: 0.25rem 0.5rem;
    background: white;
    z-index: 1000;
    height: auto;
    border-bottom: 2px solid #0044cc;
  }

  /* Footer for every printed page */
  .footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 0.25rem 1rem;
    background: white;
    z-index: 1000;
    height: auto;
    border-top: 2px solid #0044cc;
  }

  /* Content area with margins to avoid header/footer overlap */
  .content {
    padding: 20mm 10mm 20mm 10mm;
    margin: 15mm 0 15mm 0;
  }

  /* Ensure proper page breaks */
  .evaluation-section {
    page-break-inside: avoid;
    break-inside: avoid;
    margin: 1.5rem 0;
  }

  .indicator-table {
    page-break-inside: auto;
  }

  .indicator-table tr {
    page-break-inside: avoid;
    break-inside: avoid;
  }

  /* Hide loading screen when printing */
  .loading-screen {
    display: none !important;
  }

  /* Adjust print margins for content */
  .info-fields {
    margin-top: 0.5rem;
    margin-bottom: 1rem;
  }

  /* Ensure background colors print */
  * {
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
    color-adjust: exact !important;
  }
}

/* Utility classes */
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

/* Smooth transitions for responsive changes */
.a4-page,
.header,
.content,
.footer {
  transition: all 0.3s ease;
}
</style>
