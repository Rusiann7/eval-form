<template>

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
                <p>{{ }}</p> <!--name of eval-->
            </div>
            
            <div class="info-field">
                <label for="teacher">Name of Teacher Subject for Evaluation:</label>
                <p>{{  }}</p> <!--name of teacher for eval-->
            </div>
            
            <div class="info-field">
                <label for="date">Date of Evaluation:</label>
                <p>{{  }}</p><!--just put the current date-->
            </div>
            
            <div class="info-field">
                <label for="subject">Subject/Observation Context:</label>
                <p>{{  }}</p> <!--subject-->
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
                <tr>
                    <th>Indicator</th>
                    <th>Rating</th>
                </tr>
                <tr>
                    <td><strong>{{ }}counter {{  }} question start</strong> – {{  }} question paragraph</td>
                    <td>
                        <div class="rating-options">
                            <label><input type="radio" name="punctuality1" value="5"> 5</label>
                            <label><input type="radio" name="punctuality1" value="4"> 4</label>
                            <label><input type="radio" name="punctuality1" value="3"> 3</label>
                            <label><input type="radio" name="punctuality1" value="2"> 2</label>
                            <label><input type="radio" name="punctuality1" value="1"> 1</label>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="feedback-section">
            <h2>PROFESSIONAL FEEDBACK FOR COLLEAGUE DEVELOPMENT</h2>
            <textarea placeholder="Please provide constructive feedback for your colleague's professional growth..."></textarea>
        </div>
        
        <div class="buttons">
            <button class="submit"><i class="fas fa-paper-plane"></i> Submit Evaluation</button>
            <button class="reset"><i class="fas fa-redo"></i> Reset Form</button>
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
            urlappphp: "",
            headers: [],
            date: new Date().getDate(),
            month: new Date().getMonth(),
            year: new Date().getFullYear()
        }
    },

    methods: {

        async getQuesions(){
            try {

                const response = await fetch(this.urlappphp, {
                    method:'POST',
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({action: "getTeacherQuestions", id: this.$router.params.id})
                });

                const result = await response.json();

                if(result.success){
                    this.headers = result.headers;
                }else{
                    console.error("Error fetching questions:", result.message);
                }

            }catch(error){
                console.error(error);
            }
        }
    },

    mounted() {

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