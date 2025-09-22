<template>

    <div v-if="isLoading" class="loading-screen">
        <div class="loading-spinner"></div>
        <p>Loading...</p>
    </div>

    <div class="container">
        <header>
            <h1><i class="fas fa-chalkboard-teacher"></i> PEER EVALUATION FOR TEACHERS</h1>
        </header>
        
        <div class="intro">
            <p><strong>This form is designed to provide constructive feedback to colleagues based on observation and professional interaction. Please rate each indicator honestly and provide additional feedback where appropriate.</strong></p>
        </div>
        
        <div class="info-fields">
            <div class="info-field">
                <label for="evaluator">Name of Evaluator:</label>
                <p>{{ name }}</p> <!--name of eval-->
            </div>
            
            <div class="info-field">
                <label for="teacher">Name of Teacher Subject for Evaluation:</label>
                <p>{{ teacher.firstnm }} {{ teacher.lastnm }}</p> <!--name of teacher for eval-->
            </div>
            
            <div class="info-field">
                <label for="date">Date of Evaluation:</label>
                <p>{{ month }}</p><!--just put the current date-->
            </div>
            
            <div class="info-field">
                <label for="subject">Subject/Observation Context:</label>
                <p>{{ teacher.sub }}</p> <!--subject-->
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
            <p><strong>Please rate the following aspects of your colleague's performance using the scale above:</strong></p>
        </div> 
        
        <div class="evaluation-section" v-for="header in headers" :key="header.header_id">
            <h2 class="section-header">{{ header.header }}</h2>
            <table class="indicator-table">
                <thead>
                    <tr>
                        <th>Indicator</th>
                        <th class="rating-cell">
                            <div class="rating-options">
                                <div class="rating-option">
                                    <span class="rating-value">5</span>
                                </div>
                                <div class="rating-option">
                                    <span class="rating-value">4</span>
                                </div>
                                <div class="rating-option">
                                    <span class="rating-value">3</span>
                                </div>
                                <div class="rating-option">
                                    <span class="rating-value">2</span>
                                </div>
                                <div class="rating-option">
                                    <span class="rating-value">1</span>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="question in header.questions" :key="question.question_id">
                        <td><strong> {{ question.question }}</strong> – {{ question.question_eng }}</td>
                        <td class="rating-cell">
                            <div class="rating-options">
                                <label>
                                    <input type="radio" 
                                        :name="'rating: ' + question.question_id" 
                                        value="5"
                                        v-model="answer[question.question_id]"
                                    >
                                    <span class="rating-value">5</span>
                                </label>
                                <label>
                                    <input type="radio" 
                                        :name="'rating: ' + question.question_id" 
                                        value="4"
                                        v-model="answer[question.question_id]"
                                    > 
                                    <span class="rating-value">4</span>
                                </label>
                                <label>
                                    <input type="radio" 
                                        :name="'rating: ' + question.question_id" 
                                        value="3"
                                        v-model="answer[question.question_id]"
                                    > 
                                    <span class="rating-value">3</span>
                                </label>
                                <label>
                                    <input type="radio" 
                                        :name="'rating: ' + question.question_id" 
                                        value="2"
                                        v-model="answer[question.question_id]"
                                    >
                                    <span class="rating-value">2</span>
                                </label>
                                <label>
                                    <input type="radio" 
                                        :name="'rating: ' + question.question_id" 
                                        value="1"
                                        v-model="answer[question.question_id]"
                                    >
                                    <span class="rating-value">1</span>
                                </label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="feedback-section">
            <h2>PROFESSIONAL FEEDBACK FOR COLLEAGUE DEVELOPMENT</h2>
            <textarea placeholder="Please provide constructive feedback for your colleague's professional growth..." v-model="feedback"></textarea>
        </div>
        
        <div class="buttons">
            <button class="submit" type="submit" @click.prevent="submitEval"><i class="fas fa-paper-plane"></i> Submit Evaluation</button>
            <button class="reset" type="submit" @click.prevent="formClear"><i class="fas fa-redo"></i> Reset Form</button>
        </div>
        
        <footer>
            <p><strong>This evaluation is intended for professional development purposes. All responses will be kept confidential.</strong></p>
        </footer>
    </div>
</template>

<script>
export default {
    name: 'tcEval',
    data(){
        return{
            urlappphp: "https://rusiann7.helioho.st/questiont.php",
            urlappphp2: "https://rusiann7.helioho.st/idGetter.php",
            urlappphp3: "https://rusiann7.helioho.st/submitt.php",
            headers: [],
            teacher: {},
            date: new Date().getDate(),
            month: "",
            year: new Date().getFullYear(),
            feedback: "",
            answer: [],
            isLoading: false,
            name: JSON.parse(localStorage.getItem("userData") || "{}").fullname || "Student Name",
            id: JSON.parse(localStorage.getItem("userData") || "{}").id || null,
        }
    },

    methods: {

        async getQuesions(){
            try {
                this.isLoading = true;

                const response = await fetch(this.urlappphp, {
                    method:'POST',
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({action: "getTeacherQuestions"})
                });

                const result = await response.json();

                if(result.success){
                    this.isLoading = false;
                    this.headers = result.headers;
                }else{
                    console.error("Error fetching questions:", result.message);
                }

            }catch(error){
                console.error(error);
                this.isLoading = false;
            }
        },

        async getTeacherbyid(){
            try{
                this.isLoading = true;

                const response = await fetch(this.urlappphp2, {
                    method: 'POST',
                    headers: {
                        "Content-type":"application/json"
                    },
                    body: JSON.stringify({action: "getteacherbyid", id: this.$route.params.id})
                });

                const result = await response.json();

                if(result.success){
                    this.teacher = result.teacher;
                    this.month = result.month + " " + this.date + ", " + this.year;
                    this.isLoading = false;
                }else{
                    console.log("Server error:", result.message);
                }
            }catch(error){
                console.log(error);
                this.isLoading = false;
            }
        },

        async submitEval() {
            try{
                this.isLoading = true;

                console.log(this.answer, this.feedback, this.$route.params.id, this.id);

                const response = await fetch(this.urlappphp3, {
                    method: 'POST',
                    headers: {
                        "Content-type":"application/json"
                    },
                    body: JSON.stringify({action: "submits", 
                        id: this.$route.params.id, feedback: this.feedback, answers: this.answer, stid: this.id })
                })

                const result = await response.json();

                if(result.success){
                    this.isLoading = false;
                    alert("Evaluation submitted successfully. Thank you!");
                    this.$router.replace("/teacher");
                }else{
                    console.log("Server error:", result.message);
                }
            }catch(error){
                console.log(error);
            }
        },

        formClear(){
            this.feedback = "";
            this.answer = {};
        },

        skipLogin(){
            const token = getToken();

            if (!token) {
                console.error("No token found, redirecting to login.");
                this.$router.replace("/new-Dashboard");
                return;
            }
        },
    },

    mounted() {
        this.getQuesions();
        this.getTeacherbyid();
        this.formClear();
        this.skipLogin();
    },
}

</script>
<style scoped>

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
        
body {
    background-color: #f0f7ff;
    color: #333;
    line-height: 1.6;
    padding: 20px;
    font-size: 18px; /* Increased base font size */
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #4a86e8;
}
        
h1 {
    color: #2c3e50;
    margin-bottom: 10px;
    font-size: 36px; /* Increased */
    font-weight: bold; /* Added bold */
}

.intro {
    background-color: #e8f1ff;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
    font-size: 20px; /* Increased */
    font-weight: 500; /* Slightly bolder */
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
    font-weight: bold; /* Already bold */
    margin-bottom: 5px;
    color: #2c3e50;
    font-size: 20px; /* Increased */
}

.info-field input {
    width: 100%;
    padding: 12px; /* Increased padding */
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 18px; /* Increased */
}

.rating-scale {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
    border: 1px solid #dee2e6;
}

.rating-scale h2 {
    color: #2c3e50;
    margin-bottom: 15px;
    text-align: center;
    font-size: 28px; /* Increased */
    font-weight: bold; /* Added bold */
}
        
table.rating-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    font-size: 18px; /* Increased */
}

table.rating-table th, table.rating-table td {
    border: 1px solid #dee2e6;
    padding: 12px;
    text-align: center;
    font-weight: bold; /* Added bold */
}

table.rating-table th {
    background-color: #4a86e8;
    color: white;
    font-size: 20px; /* Increased */
}

table.rating-table tr:nth-child(even) {
    background-color: #f2f2f2;
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
    font-size: 24px; /* Increased */
    font-weight: bold; /* Added bold */
}

.indicator-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    font-size: 18px; /* Increased */
}
        
.indicator-table th, .indicator-table td {
    border: 1px solid #dee2e6;
    padding: 12px;
}

.indicator-table th {
    background-color: #e8f1ff;
    text-align: left;
    font-size: 20px; /* Increased */
    font-weight: bold; /* Added bold */
}

.indicator-table tr:nth-child(even) {
    background-color: #f8f9fa;
}

.rating-options {
    display: flex;
    justify-content: space-between;
    width: 100%;
}

.rating-options label {
    display: inline-block;
    width: 18%;
    text-align: center;
    padding: 5px;
    cursor: pointer;
    font-weight: bold; /* Added bold */
    font-size: 18px; /* Increased */
}

.rating-options input {
    margin-right: 5px;
    transform: scale(1.3); /* Make radio buttons larger */
}

.rating-value {
    font-weight: bold;
    font-size: 20px;
    margin-bottom: 5px;
}
        
.feedback-section {
    margin-top: 40px;
}

.feedback-section h2 {
    margin-bottom: 15px;
    color: #2c3e50;
    font-size: 28px; /* Increased */
    font-weight: bold; /* Added bold */
}

textarea {
    width: 100%;
    height: 150px;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 18px; /* Increased */
    resize: vertical;
}

.buttons {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 30px;
}
        
button {
    padding: 12px 25px;
    border: none;
    border-radius: 5px;
    font-size: 18px; /* Increased */
    cursor: pointer;
    transition: background-color 0.3s;
    font-weight: bold; /* Added bold */
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
}
        
footer {
    text-align: center;
    margin-top: 40px;
    color: #666;
    font-size: 18px; /* Increased */
    font-weight: 500; /* Slightly bolder */
}

@media (max-width: 768px) {
    body {
        font-size: 16px; /* Adjusted for mobile */
    }
    
    .info-fields {
        grid-template-columns: 1fr;
    }
    
    .rating-options {
        flex-direction: column;
    }
    
    .rating-options label {
        width: 100%;
        text-align: left;
        margin-bottom: 5px;
    }
    
    .indicator-table th:nth-child(2),
    .indicator-table td:nth-child(2) {
        width: 40%;
    }
    
    h1 {
        font-size: 28px; /* Adjusted for mobile */
    }
    
    .intro {
        font-size: 18px; /* Adjusted for mobile */
    }
}
        
@media print {
    body {
        background-color: white;
        padding: 0;
        font-size: 16px; /* Adjusted for print */
    }
    
    .container {
        box-shadow: none;
        padding: 0;
    }
    
    button {
        display: none;
    }
    
    h1 {
        font-size: 24px; /* Adjusted for print */
    }
}
</style>