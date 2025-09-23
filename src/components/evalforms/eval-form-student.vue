<template>
    <div v-if="isLoading" class="loading-screen">
        <div class="loading-spinner"></div>
        <p>Loading...</p>
    </div>

    <div class="a4-page">
        <div class="watermark">JAMES L. GORDON INTEGRATED SCHOOL</div>

        <div class="header">
            <div class="logo-left">
                <img
                    src="/src/assets/depedlogo.png"
                    alt="Left Logo DepEd logo"
                />
            </div>
            <div class="header-content">
                <h1>Republic of The Philippines</h1>
                <h2>Department of Education</h2>
                <h3>SCHOOLS DIVISION OF OLONGAPO CITY</h3>
                <h4>JAMES L. GORDON INTEGRATED SCHOOL</h4>
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
                    <label for="student"
                        >Pangalan:</label
                    >
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
                            <th>Indicator</th>
                            <!--ito yung sa taas-->
                            <th class="rating-cell">
                                <div class="rating-options">
                                    <div class="rating-option">
                                        <span class="rating-value">5</span>
                                        <span class="rating-label"
                                            >Very Evident</span
                                        >
                                    </div>
                                    <div class="rating-option">
                                        <span class="rating-value">3</span>
                                        <span class="rating-label"
                                            >Sometimes</span
                                        >
                                    </div>
                                    <div class="rating-option">
                                        <span class="rating-value">1</span>
                                        <span class="rating-label"
                                            >Not Evident</span
                                        >
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
                                {{}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="footer">
            <div class="footer-logo">
                <img
                    src="/src/assets/JLGISlogo.png"
                    alt="Footer Logo JLGIS logo"
                />
            </div>
            <div class="footer-content">
                <div class="footer-line">
                    <strong>Address:</strong> Foster St. Brgy. Kababae, Olongapo
                    City 2200
                </div>
                <div class="footer-line">
                    <strong>Tel. no.:</strong> (047) 222-4769
                </div>
                <div class="footer-line">
                    <strong>Email:</strong> 500027@deped.gov.ph /
                    500027@r3-2.deped.gov.ph
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
export default {
    name: "printEval",
    data() {
        return {
            urlappphp: "https://rusiann7.helioho.st/questions.php",
            urlappphp2: "https://rusiann7.helioho.st/idGetter.php",
            name: "",
            month: "",
            headers: [],
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
                        id: this.$route.params.id,
                    }),
                });

                const result = await response.json();

                if (result.success) {
                    this.teacher = result.teacher;
                    this.month =
                        result.month + " " + this.date + ", " + this.year;
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
        (this.getTeacherbyid(), this.getQuestions());
    },
};
</script>

<style scoped>
/* Set page size to A4 */
@page {
  size: A4;
  margin: 20mm;
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
}

.a4-page {
    width: 210mm;
    background: white;
    position: relative;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    page-break-after: always;
}

.header {
    display: flex;
    align-items: center;
    text-align: center;
    padding: 5mm;
    border-bottom: 2px solid #0044cc;
    background-color: #f8f9fa;
    position: relative;
}

.logo-left,
.logo-right {
    width: 80px;
    height: 80px;
    background-color: #e6e6e6;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ccc;
    margin: 0 10px;
}

.logo-left img,
.logo-right img {
    max-width: 100%;
    max-height: 100%;
}

.header-content {
    flex: 1;
}

.header h1 {
    font-size: 16pt;
    margin: 5px 0;
    font-weight: bold;
    color: #003366;
}

.header h2 {
    font-size: 14pt;
    margin: 4px 0;
    font-weight: normal;
    color: #0044aa;
}

.header h3 {
    font-size: 13pt;
    margin: 4px 0;
    font-weight: normal;
    color: #005588;
}

.header h4 {
    font-size: 16pt;
    margin: 8px 0 4px 0;
    font-weight: bold;
    color: #cc0000;
    text-transform: uppercase;
}

.page-number {
    font-size: 10pt;
    margin-top: 5px;
    color: #666;
}

.content {
    flex: 1;
    padding: 15mm;
}

.content-placeholder {
    text-align: center;
    color: #888;
    font-style: italic;
    margin-top: 40%;
}

.footer {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 8mm 15mm;
    border-top: 2px solid #0044cc;
    background-color: #f8f9fa;
    font-size: 10pt;
}

.footer-logo {
    width: 60px;
    height: 60px;
    background-color: #e6e6e6;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ccc;
    margin-right: 15px;
}

.footer-logo img {
    max-width: 100%;
    max-height: 100%;
}

.footer-content {
    flex: 1;
}

.footer-line {
    margin: 3px 0;
}

.rating-cell {
    width: 200px;
}

.watermark {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-45deg);
    font-size: 40pt;
    color: rgba(0, 0, 0, 0.05);
    pointer-events: none;
    z-index: -1;
    text-align: center;
    white-space: nowrap;
    font-weight: bold;
}

@media print {
    body {
        background: none;
    }

    .a4-page {
        box-shadow: none;
        margin: 0;
        padding: 0;
        page-break-after: always;
    }

    .a4-page:last-of-type {
        page-break-after: avoid;
    }

      .footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
  }
}

.info-fields {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.info-field {
    margin-bottom: 15px;
}

.info-field label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #2c3e50;
    font-size: 20px;
}

.evaluation-section {
    margin-bottom: 40px;
    page-break-inside: avoid;
}

.section-header {
    background-color: #4a86e8;
    color: white;
    padding: 15px;
    border-radius: 8px 8px 0 0;
    margin-bottom: 0;
    font-size: 24px;
    font-weight: bold;
}

.indicator-table, 
.indicator-table tr, 
.indicator-table td, 
.indicator-table th {
    page-break-inside: avoid;
    break-inside: avoid;
}

.indicator-table tr:nth-child(even) {
    background-color: #f8f9fa;
}

.evaluation-section {
  page-break-after: auto;
  break-inside: avoid;
}

.rating-option {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.rating-option input {
    margin: 5px 0;
    transform: scale(1.5);
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
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
  margin-bottom: 10px;
  z-index: 3000;
}
</style>
