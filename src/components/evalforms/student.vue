<template>

<div class="container">
        <header>
            <h1><i class="fas fa-user-graduate"></i> STUDENT EVALUATION TOOL</h1>
        </header>
        
        <div class="intro">
            <p><strong>This form is designed to provide constructive feedback to teachers based on classroom experience. Please rate each indicator honestly to help improve teaching quality.</strong></p>
        </div>
        
        <div class="info-fields">
            <div class="info-field">
                <label for="student">Pangalan ng Mag-aaral (Student Name):</label>
                <p name="student">temp-username</p>
            </div>
            
            <div class="info-field">
                <label for="grade">Subject:</label>
                <p name="grade">{{ teacher.sub }}</p>
            </div>
            
            <div class="info-field">
                <label for="teacher">Subject Teacher:</label>
                <p name="teacher">{{teacher.firstnm}} {{ teacher.lastnm }}</p>
            </div>
            
            <div class="info-field">
                <label for="date">Petsa (Date):</label>
                <p name="date">{{ month }}</p>
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
        
        <div class="evaluation-section" v-for="header in headers" :key="header.header_id"> <!--title card yung blue i v-for din ito-->
            <h2 class="section-header">{{ header.header }} <span class="tagalog">{{ header.header_p }}</span></h2>
            <table class="indicator-table"> 
                <tr>
                    <th>Indicator</th><!--ito yung sa taas-->
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
                <tr v-for="question in header.questions" :key="question.question_id"> <!--dito mo lagay yung v-for-->
                    <td>
                        <strong>temp-date-counter</strong> {{ question.question }}<br> <!--tanong tagalog-->
                        <span class="tagalog">temp-answer-eng</span><!--tanong english-->
                    </td>
                    <td class="rating-cell">
                        <div class="rating-options">
                            <label class="rating-option">
                                <input type="radio" 
                                    :name="'rating: ' + question.question_id"
                                    value="5" 
                                    v-model="answer[question.question_id]"
                                >
                                <span class="rating-value">5</span>
                            </label>
                            <label class="rating-option">
                                <input type="radio" 
                                    :name="'rating: ' + question.question_id"
                                    value="3" 
                                    v-model="answer[question.question_id]"
                                >
                                <span class="rating-value">3</span>
                            </label>
                            <label class="rating-option">
                                <input type="radio" 
                                    :name="'rating-' + question.question_id"
                                    value="1" 
                                    v-model="answer[question.question_id]"
                                >
                                <span class="rating-value">1</span>
                            </label>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!--Feedback here-->
        <div class="feedback-section">
            <h2>Karagdagang mensahe / suhestiyon ng mag-aaral sa kaniyang guro upang mapagbuti pang higit ang kaniyang pagtuturo.</h2>
            <h2>Additional message/suggestion from the student to the teacher to further improve teaching.</h2>
            <textarea placeholder="Please provide your feedback and suggestions here..." v-model="feedback"></textarea>
        </div>
        
        <div class="buttons">
            <button class="submit" type="submit" @click.prevent="submitEval"><i class="fas fa-paper-plane"></i> Submit Evaluation</button>
            <button class="reset" type="submit" @click.prevent="formClear"><i class="fas fa-redo"></i> Reset Form</button>
        </div>
        
        <footer>
            <p><strong>This evaluation is intended for educational improvement purposes. All responses will be kept confidential.</strong></p>
        </footer>
    </div>

</template>

<script>

export default {
    name: "student-eval",
    data(){
        return{
            urlappphp: "https://rusiann7.helioho.st/questions.php",
            urlappphp2: "https://rusiann7.helioho.st/idGetter.php",
            headers: [],
            teacher: {},
            date: new Date().getDate(),
            month: "",
            year: new Date().getFullYear(),
            feedback: "",
            answer:{}
        }
    },

    methods:{
        async getQuestions(){
            try {
                const response = await fetch(this.urlappphp, { 
                    method: 'POST',
                    headers:{
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ action: "getQuestions"})
                });

                const result = await response.json();

                if(result.success){
                    this.headers = result.headers;
                }else {
                    console.error("server error:", error);
                }
            }catch(error){
                console.error(error)
            }
        },

        async getTeacherbyid(){
            try{
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
                }else{
                    console.log("Server error:", result.message);
                }
            }catch(error){
                console.log(error);
            }
        },

        async submitEval() {
            try{
                console.log(this.answer, this.feedback);
            }catch(error){

            }
        },

        formClear(){
            this.feedback = "";
            this.answer = {};
        }
    },

    mounted(){
        this.getQuestions();
        this.getTeacherbyid();
        this.feedback = "";
    }
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
            font-size: 18px;
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
            font-size: 36px;
            font-weight: bold;
        }
        
        .intro {
            background-color: #e8f1ff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            font-size: 20px;
            font-weight: 500;
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
        
        .info-field input, .info-field select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 18px;
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
            font-size: 28px;
            font-weight: bold;
        }
        
        table.rating-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        table.rating-table th, table.rating-table td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: center;
            font-weight: bold;
        }
        
        table.rating-table th {
            background-color: #4a86e8;
            color: white;
            font-size: 20px;
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
            font-size: 24px;
            font-weight: bold;
        }
        
        .indicator-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        .indicator-table th, .indicator-table td {
            border: 1px solid #dee2e6;
            padding: 12px;
        }
        
        .indicator-table th {
            background-color: #e8f1ff;
            text-align: left;
            font-size: 20px;
            font-weight: bold;
        }
        
        .indicator-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .rating-cell {
            width: 200px;
        }
        
        .rating-options {
            display: flex;
            justify-content: space-between;
            width: 100%;
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
        
        .rating-value {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 5px;
        }
        
        .rating-label {
            font-size: 14px;
            color: #666;
        }
        
        .feedback-section {
            margin-top: 40px;
        }
        
        .feedback-section h2 {
            margin-bottom: 15px;
            color: #2c3e50;
            font-size: 28px;
            font-weight: bold;
        }
        
        textarea {
            width: 100%;
            height: 150px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 18px;
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
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: bold;
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
            font-size: 18px;
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            body {
                font-size: 16px;
            }
            
            .info-fields {
                grid-template-columns: 1fr;
            }
            
            .rating-options {
                flex-direction: column;
                gap: 10px;
            }
            
            .rating-option {
                flex-direction: row;
                justify-content: flex-start;
                gap: 10px;
            }
            
            .indicator-table th:nth-child(2),
            .indicator-table td:nth-child(2) {
                width: 40%;
            }
            
            h1 {
                font-size: 28px;
            }
            
            .intro {
                font-size: 18px;
            }
        }
        
        @media print {
            body {
                background-color: white;
                padding: 0;
                font-size: 16px;
            }
            
            .container {
                box-shadow: none;
                padding: 0;
            }
            
            button {
                display: none;
            }
            
            h1 {
                font-size: 24px;
            }
        }
        
        .tagalog {
            font-style: italic;
            color: #555;
        }
</style>