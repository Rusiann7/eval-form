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
            <p><strong>Please rate the following aspects of your teacher's performance using the scale above:</strong></p>
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
                                        <span class="rating-label"
                                            >Ratings</span
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
  margin: 0mm; /* Remove margins to maximize space */
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
    min-height: 297mm;
    background: white;
    position: relative;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Header styles - will be repeated on each page */
.header {
    display: flex;
    align-items: center;
    text-align: center;
    padding: 3mm 5mm; /* Reduced padding */
    border-bottom: 2px solid #0044cc;
    background-color: #f8f9fa;
    position: relative;
}

.logo-left,
.logo-right {
    width: 60px; /* Smaller logos */
    height: 60px;
    background-color: #e6e6e6;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ccc;
    margin: 0 5px; /* Reduced margin */
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
    font-size: 14pt; /* Smaller font sizes */
    margin: 3px 0;
    font-weight: bold;
    color: #003366;
}

.header h2 {
    font-size: 12pt;
    margin: 2px 0;
    font-weight: normal;
    color: #0044aa;
}

.header h3 {
    font-size: 11pt;
    margin: 2px 0;
    font-weight: normal;
    color: #005588;
}

.header h4 {
    font-size: 14pt;
    margin: 5px 0 2px 0;
    font-weight: bold;
    color: #cc0000;
    text-transform: uppercase;
}

.content {
    padding: 2mm 10mm; /* Reduced padding */
}

.info-fields {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px; /* Reduced gap */
    margin-bottom: 3px;
    margin-top: 10px;
}

.info-field {
    margin-bottom: 3px;
}

.info-field label {
    display: block;
    font-weight: bold;
    margin-bottom: 3px;
    color: #2c3e50;
    font-size: 16px; /* Smaller font */
}

.evaluation-section {
    margin: 20px 0; /* Reduced spacing */
    page-break-inside: avoid;
}

.section-header {
    background-color: #4a86e8;
    color: white;
    padding: 10px; /* Reduced padding */
    border-radius: 5px 5px 0 0;
    margin-bottom: 0;
    font-size: 20px; /* Smaller font */
    font-weight: bold;
}

.indicator-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

.indicator-table td:first-child {
    width: 70%;
    word-wrap: break-word;
    padding: 8px 6px; /* Reduced padding */
    font-size: 14px; /* Smaller font */
}

.indicator-table td:last-child {
    width: 30%;
    vertical-align: top;
    padding: 8px 6px; /* Reduced padding */
}

.indicator-table tr {
    page-break-inside: avoid;
    break-inside: avoid;
}

.indicator-table tr:nth-child(even) {
    background-color: #f8f9fa;
}

.rating-cell {
    width: 30%;
    vertical-align: top;
}

.rating-options {
    display: flex;
    justify-content: space-around;
}

.rating-option {
    text-align: center;
}

/* Smaller footer */
.footer {
    padding: 3mm 10mm; /* Reduced padding */
    border-top: 1px solid #0044cc; /* Thinner border */
    background-color: #f8f9fa;
    font-size: 8pt; /* Smaller font */
    margin-top: 10mm; /* Reduced margin */
}

.footer-logo {
    width: 40px; /* Smaller logo */
    height: 40px;
    background-color: #e6e6e6;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ccc;
    margin-right: 10px;
}

.footer-logo img {
    max-width: 100%;
    max-height: 100%;
}

.footer-content {
    flex: 1;
}

.footer-line {
    margin: 1px 0; /* Reduced margin */
}

.watermark {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-45deg);
    font-size: 30pt; /* Smaller watermark */
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

.rating-scale {
    background-color: #f8f9fa;
    padding: 12px; /* Reduced padding */
    border-radius: 5px;
    margin-bottom: 8px;
    border: 1px solid #dee2e6;
}

.rating-scale h2 {
    color: #2c3e50;
    margin-bottom: 10px; /* Reduced margin */
    text-align: center;
    font-size: 20px; /* Smaller font */
    font-weight: bold;
}

table.rating-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 8px;
    font-size: 14px; /* Smaller font */
}

table.rating-table th, table.rating-table td {
    border: 1px solid #dee2e6;
    padding: 8px; /* Reduced padding */
    text-align: center;
    font-weight: bold;
}

table.rating-table th {
    background-color: #4a86e8;
    color: white;
    font-size: 16px; /* Smaller font */
}

table.rating-table tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Print styles - HEADER AND FOOTER ON EVERY PAGE */
/* Print styles - ULTRA SIMPLE FIX */
/* Print styles - FIXED HEADER/FOOTER THAT WORKS */
@media print {
    body {
        background: none;
        margin: 0;
        padding: 0;
    }
    
    .a4-page {
        box-shadow: none;
        margin: 0;
        width: 100%;
        height: 100%;
        page-break-after: always;
    }
    
    /* Header on every page - FIXED */
    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        padding: 2mm 5mm;
        background: white;
        z-index: 1000;
        height: 20mm; /* Fixed height */
    }
    
    /* Footer on every page - FIXED */
    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 2mm 10mm;
        background: white;
        z-index: 1000;
        height: 12mm; /* Fixed height */
    }
    
    /* CRITICAL: Add margins to content to avoid cutting */
    .content {
        padding: 30mm 10mm 20mm 10mm; /* 30mm top clears 20mm header safely */
        margin: 0;
    }

    
    /* Prevent content from being cut off */
    .evaluation-section {
        page-break-inside: avoid;
        break-inside: avoid;
        margin: 15px 0;
    }
    
    .indicator-table tr {
        page-break-inside: avoid;
        break-inside: avoid;
    }
    
    /* Ensure tables don't break across pages awkwardly */
    .indicator-table {
        page-break-inside: auto;
    }
    
    /* Add extra space before sections that might break */
    .evaluation-section:first-child {
        margin-top: 0;
    }
}
</style>
