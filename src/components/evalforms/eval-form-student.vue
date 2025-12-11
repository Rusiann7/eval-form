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
      <p><strong>Comments/Suggestions:</strong></p>

      <p class="rating-cell">
        {{ answer.feedback || "N/A" }}
      </p>
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
//const url2 = "http://localhost:8000";

export default {
  name: "printEval",
  data() {
    return {
      urlappphp: `${url2}/questionsAll.php`,
      urlappphp2: `${url2}/idGetter.php`,
      urlappphp3: `${url2}/ansGetter.php`,
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
            action: "ansGetter",
            id: this.$route.params.id,
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
          for (const ans of sessionData.answer) {
            this.answers[Number(ans.question_id)] = ans.score;
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
  margin: 15mm 10mm; /* Adjusted margins for better print layout */
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  margin: 0;
  padding: 1rem;
  font-family: "Arial", sans-serif;
  background-color: #f0f0f0;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  font-size: 16px;
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
  padding: 0.75rem 1rem; /* Increased padding */
  border-bottom: 2px solid #0044cc;
  background-color: #f8f9fa;
  position: relative;
  flex-wrap: wrap;
  gap: 0.75rem; /* Increased gap */
}

.logo-left,
.logo-right {
  width: 4.5rem; /* Increased size */
  height: 4.5rem; /* Increased size */
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 0.5rem;
  flex-shrink: 0;
  background-color: #ffffff; /* Changed from #e6e6e6 to white */
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 0.25rem;
}

.logo-left img,
.logo-right img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.header-content {
  flex: 1;
  min-width: 220px; /* Slightly increased */
}

.header h1 {
  font-size: 1.35rem; /* Increased */
  margin: 0.2rem 0;
  font-weight: bold;
  color: #003366;
  line-height: 1.3;
}

.header h2 {
  font-size: 1.2rem; /* Increased */
  margin: 0.15rem 0;
  font-weight: 600;
  color: #0044aa;
  line-height: 1.3;
}

.header h3 {
  font-size: 1.05rem; /* Increased */
  margin: 0.15rem 0;
  font-weight: 600;
  color: #005588;
  line-height: 1.3;
}

.content {
  padding: 1.5rem 1.75rem; /* Increased padding */
}

/* Info fields section */
.info-fields {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1.25rem; /* Increased gap */
  margin-bottom: 2rem; /* Increased margin */
  margin-top: 1rem;
  padding: 1rem;
  background-color: #f8f9fa;
  border-radius: 0.5rem;
  border: 1px solid #e0e0e0;
}

.info-field {
  margin-bottom: 0.5rem;
}

.info-field label {
  display: block;
  font-weight: bold;
  margin-bottom: 0.4rem;
  color: #2c3e50;
  font-size: 1.15rem; /* Increased */
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.info-field p {
  font-size: 1.2rem; /* Increased */
  padding: 0.5rem 0;
  color: #333;
  font-weight: 500;
  min-height: 1.8rem;
  border-bottom: 1px dashed #ccc;
}

/* Rating scale section */
.rating-scale {
  background-color: #f0f7ff;
  padding: 1.25rem; /* Increased padding */
  border-radius: 0.5rem;
  margin-bottom: 2rem;
  border: 1px solid #cce0ff;
  box-shadow: 0 2px 4px rgba(0, 68, 204, 0.1);
}

.rating-scale h2 {
  color: #003366;
  margin-bottom: 1rem;
  text-align: center;
  font-size: 1.4rem; /* Increased */
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.rating-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 1rem;
  font-size: 1.1rem; /* Increased */
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.rating-table th,
.rating-table td {
  border: 2px solid #0044cc;
  padding: 0.85rem 0.5rem; /* Increased padding */
  text-align: center;
  font-weight: bold;
}

.rating-table th {
  background-color: #0044cc;
  color: white;
  font-size: 1.15rem; /* Increased */
  font-weight: 600;
  text-transform: uppercase;
}

.rating-table tr:nth-child(even) {
  background-color: #f0f7ff;
}

.rating-table tr:nth-child(odd) {
  background-color: #ffffff;
}

.rating-scale p strong {
  font-size: 1.15rem;
  color: #003366;
  display: block;
  text-align: center;
  margin-top: 1rem;
  padding-top: 1rem;
  border-top: 1px solid #ccc;
}

/* Evaluation sections */
.evaluation-section {
  margin: 2rem 0; /* Increased margin */
  page-break-inside: avoid;
  break-inside: avoid;
}

.section-header {
  background: linear-gradient(135deg, #4a86e8, #2c5aa0);
  color: white;
  padding: 1rem 1.25rem; /* Increased padding */
  border-radius: 0.5rem 0.5rem 0 0;
  margin-bottom: 0;
  font-size: 1.4rem; /* Increased */
  font-weight: bold;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
  display: flex;
  flex-direction: column;
  gap: 0.3rem;
}

.tagalog {
  font-size: 1.15rem; /* Increased */
  font-weight: normal;
  font-style: italic;
  opacity: 0.9;
}

/* Indicator table */
.indicator-table {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
  font-size: 1.05rem; /* Increased */
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.indicator-table thead {
  background-color: #e6f0ff;
}

.indicator-table th,
.indicator-table td {
  padding: 0.85rem 0.75rem; /* Increased padding */
  text-align: left;
  vertical-align: top;
  border: 1px solid #d0d0d0;
}

.indicator-table th {
  font-weight: 600;
  color: #003366;
  font-size: 1.1rem;
  text-align: center;
  background-color: #e6f0ff;
}

.indicator-table td:first-child {
  width: 70%;
  word-wrap: break-word;
  font-size: 1.05rem; /* Increased */
  line-height: 1.5;
  color: #333;
}

.indicator-table td:last-child {
  width: 30%;
  text-align: center;
  font-weight: bold;
  font-size: 1.25rem; /* Increased */
  color: #0044cc;
  background-color: #f8f9fa;
}

.indicator-table tr {
  page-break-inside: avoid;
  break-inside: avoid;
}

.indicator-table tr:nth-child(even) {
  background-color: #f8f9fa;
}

.indicator-table tr:nth-child(odd) {
  background-color: #ffffff;
}

.indicator-table tbody tr:hover {
  background-color: #e9ecef;
}

/* Comments/Suggestions section */
.content > p:first-of-type {
  font-size: 1.2rem;
  font-weight: bold;
  color: #003366;
  margin: 2rem 0 0.5rem 0;
  padding-top: 1rem;
  border-top: 2px solid #0044cc;
  text-transform: uppercase;
}

.content > p.rating-cell {
  font-size: 1.1rem;
  line-height: 1.6;
  padding: 1rem;
  margin: 0.5rem 0 2rem 0;
  background-color: #f8f9fa;
  border: 1px solid #ddd;
  border-radius: 0.5rem;
  min-height: 100px;
  white-space: pre-wrap;
  word-wrap: break-word;
}

/* Footer styles */
.footer {
  padding: 1rem 1.5rem; /* Increased padding */
  border-top: 2px solid #0044cc;
  background-color: #f8f9fa;
  font-size: 0.95rem; /* Increased from 0.5rem */
  margin-top: 2rem;
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 1.25rem; /* Increased gap */
}

.footer-logo {
  width: 4rem; /* Increased from 2.5rem */
  height: 4rem; /* Increased from 2.5rem */
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #ccc;
  flex-shrink: 0;
  background-color: white;
  border-radius: 4px;
  padding: 0.25rem;
}

.footer-logo img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.footer-content {
  flex: 1;
  min-width: 220px;
}

.footer-line {
  margin: 0.35rem 0; /* Increased margin */
  line-height: 1.5;
  color: #333;
}

.footer-line strong {
  font-size: 1rem;
  color: #003366;
  min-width: 100px;
  display: inline-block;
}

/* Loading screen */
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
  z-index: 9999;
  color: white;
}

.loading-spinner {
  border: 5px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top: 5px solid #ffffff;
  width: 4rem;
  height: 4rem;
  animation: spin 1s linear infinite;
  margin-bottom: 1.5rem;
}

.loading-screen p {
  font-size: 1.5rem;
  font-weight: bold;
  letter-spacing: 1px;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

/* Responsive Design */
@media screen and (max-width: 1200px) {
  body {
    padding: 0.75rem;
    font-size: 15px;
  }

  .content {
    padding: 1.25rem 1.5rem;
  }
}

@media screen and (max-width: 992px) {
  .a4-page {
    width: 100%;
    min-height: auto;
  }

  .header {
    padding: 0.75rem;
  }

  .logo-left,
  .logo-right {
    width: 4rem;
    height: 4rem;
  }

  .header h1 {
    font-size: 1.25rem;
  }

  .header h2 {
    font-size: 1.1rem;
  }

  .header h3 {
    font-size: 1rem;
  }
}

@media screen and (max-width: 768px) {
  body {
    padding: 0.5rem;
    font-size: 14px;
    align-items: flex-start;
  }

  .a4-page {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .header {
    flex-direction: column;
    text-align: center;
    padding: 1rem;
    gap: 1rem;
  }

  .logo-left,
  .logo-right {
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
    padding: 0.75rem;
  }

  .section-header {
    font-size: 1.25rem;
    padding: 0.85rem;
    flex-direction: column;
  }

  .indicator-table {
    display: block;
    overflow-x: auto;
    font-size: 1rem;
  }

  .indicator-table td:first-child,
  .indicator-table td:last-child {
    width: auto;
    min-width: 60%;
  }

  .indicator-table td:last-child {
    min-width: 40%;
  }

  .footer {
    flex-direction: column;
    text-align: center;
    padding: 1rem;
    gap: 1rem;
  }

  .footer-logo {
    width: 3.5rem;
    height: 3.5rem;
  }

  .footer-line strong {
    display: block;
    text-align: left;
    margin-bottom: 0.25rem;
  }
}

@media screen and (max-width: 576px) {
  body {
    padding: 0.25rem;
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
    padding: 0.75rem;
  }

  .tagalog {
    font-size: 1rem;
  }

  .info-field label {
    font-size: 1.05rem;
  }

  .info-field p {
    font-size: 1.1rem;
  }

  .rating-scale h2 {
    font-size: 1.2rem;
  }

  .rating-table {
    font-size: 1rem;
  }

  .rating-table th,
  .rating-table td {
    padding: 0.6rem 0.4rem;
  }

  .indicator-table th,
  .indicator-table td {
    padding: 0.7rem 0.5rem;
  }

  .indicator-table td:first-child {
    font-size: 1rem;
  }

  .indicator-table td:last-child {
    font-size: 1.15rem;
  }

  .content > p:first-of-type {
    font-size: 1.1rem;
  }

  .content > p.rating-cell {
    font-size: 1rem;
    padding: 0.75rem;
  }
}

/* Print styles - optimized for A4 printing */
@media print {
  /* Force browsers to print backgrounds and colors */
  * {
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
    color-adjust: exact !important;
  }

  body {
    background: none;
    margin: 0;
    padding: 0;
    font-size: 11pt;
    line-height: 1.4;
    width: 210mm;
    height: 297mm;
  }

  .a4-page {
    box-shadow: none;
    margin: 0;
    width: 210mm;
    min-height: 297mm;
    page-break-after: always;
    position: relative;
  }

  /* Hide loading screen when printing */
  .loading-screen {
    display: none !important;
  }

  /* Ensure proper page breaks and avoid splitting sections */
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

  /* Adjust spacing for print */
  .header {
    padding: 0.4rem 0.75rem;
    border-bottom-width: 1px;
  }

  .content {
    padding: 1rem 1.25rem;
  }

  .info-fields {
    margin-bottom: 1.5rem;
    padding: 0.75rem;
    gap: 1rem;
  }

  .rating-scale {
    margin-bottom: 1.5rem;
    padding: 1rem;
  }

  .footer {
    padding: 0.75rem 1rem;
    margin-top: 1.5rem;
    font-size: 9pt;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
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

  /* Force black text for better print contrast */
  * {
    color: black !important;
    print-color-adjust: exact;
    -webkit-print-color-adjust: exact;
  }

  /* Ensure background colors print */
  .section-header,
  .rating-table th,
  .indicator-table thead {
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }

  /* Ensure all borders print */
  .info-field,
  .evaluation-section,
  .rating-scale {
    border: none;
  }

  /* Force visibility of all elements */
  .header-content,
  .footer-content,
  .content > * {
    visibility: visible !important;
    display: block !important;
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

/* Add print button styling for screen only */
@media screen {
  .print-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 12px 24px;
    background-color: #0044cc;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    z-index: 1000;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
  }

  .print-button:hover {
    background-color: #0033aa;
  }
}
</style>
