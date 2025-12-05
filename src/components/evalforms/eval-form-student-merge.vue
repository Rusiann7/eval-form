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
      urlappphp: `${url2}/questionsAll.php`,
      urlappphp2: `${url2}/idGetter.php`,
      urlappphp3: `${url2}/mergeAnsGetter.php`,
      urlappphp4: `${url2}/evtGetter.php`,
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
            action: "student",
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
  margin: 20mm 10mm; /* Add margins for print safety */
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  margin: 0;
  padding: 1rem;
  font-family: 'Arial', sans-serif;
  background-color: #f0f0f0;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  font-size: 16px; /* Base font size */
  line-height: 1.5;
}

.a4-page {
  width: 210mm;
  min-height: 297mm;
  background: white;
  position: relative;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  max-width: 100%;
  margin: 0 auto;
}

/* Header styles */
.header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  text-align: center;
  padding: 0.5rem 1rem;
  border-bottom: 2px solid #0044cc;
  background-color: #f8f9fa;
  position: relative;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.logo-left,
.logo-right {
  width: 4rem;
  height: 4rem;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 0.3rem;
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
  min-width: 200px;
}

.header h1 {
  font-size: 1.25rem; /* Increased from 0.875rem */
  margin: 0.2rem 0;
  font-weight: bold;
  color: #003366;
  line-height: 1.2;
}

.header h2 {
  font-size: 1.125rem; /* Increased from 0.75rem */
  margin: 0.1rem 0;
  font-weight: 600;
  color: #0044aa;
  line-height: 1.2;
}

.header h3 {
  font-size: 1rem; /* Increased from 0.7rem */
  margin: 0.1rem 0;
  font-weight: 600;
  color: #005588;
  line-height: 1.2;
}

.content {
  padding: 1rem 1.5rem; /* Increased padding */
}

.info-fields {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1rem; /* Increased gap */
  margin-bottom: 1.5rem; /* Increased margin */
  margin-top: 1rem; /* Increased margin */
}

.info-field {
  margin-bottom: 0.5rem;
}

.info-field label {
  display: block;
  font-weight: bold;
  margin-bottom: 0.3rem;
  color: #2c3e50;
  font-size: 1.1rem; /* Increased from 1rem */
}

.info-field p {
  font-size: 1.1rem; /* Added font size for p tags */
  padding: 0.4rem 0;
  color: #333;
}

.evaluation-section {
  margin: 1.5rem 0; /* Increased margin */
  page-break-inside: avoid;
}

.section-header {
  background-color: #4a86e8;
  color: white;
  padding: 0.75rem 1rem; /* Increased padding */
  border-radius: 0.3rem 0.3rem 0 0;
  margin-bottom: 0;
  font-size: 1.35rem; /* Increased from 1.25rem */
  font-weight: bold;
}

.tagalog {
  display: block;
  font-size: 1.1rem; /* Added size for tagalog */
  font-weight: normal;
  margin-top: 0.2rem;
}

.indicator-table {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
  font-size: 1rem; /* Increased from 0.9rem */
}

.indicator-table thead {
  background-color: #f0f7ff;
}

.indicator-table th,
.indicator-table td {
  padding: 0.75rem 0.5rem; /* Increased padding */
  text-align: left;
  vertical-align: top;
  border: 1px solid #dee2e6;
}

.indicator-table td:first-child {
  width: 70%;
  word-wrap: break-word;
  font-size: 1rem; /* Increased from 0.875rem */
  line-height: 1.4;
}

.indicator-table td:last-child {
  width: 30%;
  text-align: center;
  font-weight: bold;
  font-size: 1.1rem;
}

.indicator-table tr {
  page-break-inside: avoid;
  break-inside: avoid;
}

.indicator-table tr:nth-child(even) {
  background-color: #f8f9fa;
}

.indicator-table tbody tr:hover {
  background-color: #e9ecef;
}

.rating-scale {
  background-color: #f8f9fa;
  padding: 1rem; /* Increased padding */
  border-radius: 0.5rem;
  margin-bottom: 1.5rem;
  border: 1px solid #dee2e6;
}

.rating-scale h2 {
  color: #2c3e50;
  margin-bottom: 0.75rem;
  text-align: center;
  font-size: 1.35rem; /* Increased from 1.25rem */
  font-weight: bold;
}

.rating-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 0.75rem;
  font-size: 1rem; /* Increased from 0.875rem */
}

.rating-table th,
.rating-table td {
  border: 1px solid #dee2e6;
  padding: 0.75rem 0.5rem; /* Increased padding */
  text-align: center;
}

.rating-table th {
  background-color: #4a86e8;
  color: white;
  font-size: 1.1rem; /* Increased from 1rem */
  font-weight: 600;
}

.rating-table tr:nth-child(even) {
  background-color: #f2f2f2;
}

.rating-scale p strong {
  font-size: 1.1rem;
  color: #2c3e50;
}

/* Footer styles */
.footer {
  padding: 0.75rem 1.5rem; /* Increased padding */
  border-top: 1px solid #0044cc;
  background-color: #f8f9fa;
  font-size: 0.9rem; /* Increased from 0.5rem */
  margin-top: 2rem;
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem; /* Increased gap */
}

.footer-logo {
  width: 3.5rem; /* Increased from 2.5rem */
  height: 3.5rem; /* Increased from 2.5rem */
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #ccc;
  flex-shrink: 0;
}

.footer-logo img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.footer-content {
  flex: 1;
  min-width: 200px;
}

.footer-line {
  margin: 0.3rem 0; /* Increased margin */
  line-height: 1.4;
}

.footer-line strong {
  font-size: 0.95rem;
}

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
  width: 3rem;
  height: 3rem;
  animation: spin 1s linear infinite;
  margin-bottom: 1rem;
}

.loading-screen p {
  font-size: 1.2rem;
  font-weight: bold;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Responsive Design for Tablets and Mobile */
@media screen and (max-width: 1024px) {
  body {
    padding: 0.5rem;
    font-size: 15px;
  }
  
  .a4-page {
    width: 100%;
    min-height: auto;
  }
}

@media screen and (max-width: 768px) {
  body {
    padding: 0;
    font-size: 14px;
  }
  
  .a4-page {
    box-shadow: none;
    width: 100%;
  }
  
  .header {
    flex-direction: column;
    text-align: center;
    padding: 0.75rem;
    gap: 0.75rem;
  }
  
  .logo-left, .logo-right {
    width: 3.5rem;
    height: 3.5rem;
    margin: 0;
  }
  
  .header-content {
    width: 100%;
    order: 2;
  }
  
  .logo-left {
    order: 1;
  }
  
  .logo-right {
    order: 3;
  }
  
  .content {
    padding: 1rem;
  }
  
  .info-fields {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
  
  .section-header {
    font-size: 1.25rem;
    padding: 0.75rem;
  }
  
  .indicator-table {
    display: block;
    overflow-x: auto;
    font-size: 0.95rem;
  }
  
  .indicator-table td:first-child,
  .indicator-table td:last-child {
    width: auto;
    min-width: 50%;
  }
  
  .footer {
    flex-direction: column;
    text-align: center;
    padding: 1rem;
    gap: 0.75rem;
  }
  
  .footer-logo {
    width: 3rem;
    height: 3rem;
  }
}

@media screen and (max-width: 480px) {
  body {
    font-size: 13px;
  }
  
  .header h1 {
    font-size: 1.1rem;
  }
  
  .header h2 {
    font-size: 1rem;
  }
  
  .header h3 {
    font-size: 0.9rem;
  }
  
  .section-header {
    font-size: 1.15rem;
    padding: 0.6rem;
  }
  
  .info-field label,
  .info-field p {
    font-size: 1rem;
  }
  
  .rating-scale h2 {
    font-size: 1.15rem;
  }
  
  .rating-table {
    font-size: 0.9rem;
  }
  
  .rating-table th,
  .rating-table td {
    padding: 0.5rem;
  }
  
  .indicator-table th,
  .indicator-table td {
    padding: 0.6rem 0.4rem;
  }
}

/* Print styles - optimized for A4 */
@media print {
  body {
    background: none;
    margin: 0;
    padding: 0;
    font-size: 12pt; /* Use points for print */
    line-height: 1.3;
  }
  
  .a4-page {
    box-shadow: none;
    margin: 0;
    width: 210mm;
    height: auto;
    page-break-after: always;
  }
  
  /* Hide loading screen when printing */
  .loading-screen {
    display: none !important;
  }
  
  /* Ensure proper page breaks */
  .evaluation-section {
    page-break-inside: avoid;
    margin: 1rem 0;
  }
  
  .indicator-table {
    page-break-inside: auto;
  }
  
  .indicator-table tr {
    page-break-inside: avoid;
  }
  
  /* Adjust spacing for print */
  .header {
    padding: 0.3rem 0.5rem;
    border-bottom-width: 1px;
  }
  
  .content {
    padding: 0.5rem 1rem;
  }
  
  .footer {
    padding: 0.4rem 1rem;
    margin-top: 1rem;
    font-size: 9pt;
  }
  
  /* Ensure logos print properly */
  .logo-left img,
  .logo-right img,
  .footer-logo img {
    filter: none !important;
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
  }
  
  /* Remove hover effects for print */
  .indicator-table tbody tr:hover {
    background-color: inherit;
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

/* Improve table readability on all devices */
th {
  font-weight: 600;
}

/* Ensure images don't overflow */
img {
  max-width: 100%;
  height: auto;
}
</style> 