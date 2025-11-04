<template>
<div id="app">
        <div class="container">
            <div class="header">
                <h1>Teacher Evaluation System</h1>
                <p>Schedule and manage peer evaluation sessions</p>
            </div>
            
            <div class="scheduler">
                <div class="calendar-section">
                    <div class="section-title">
                        <i class="fas fa-calendar-alt"></i>
                        <h2>Evaluation Schedule</h2>
                    </div>
                    
                    <div class="calendar-header">
                        <button>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h2>{{  }}</h2>
                        <button >
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    
                    <div class="calendar-grid">
                        <div>
                            <p>calendar header</p>
                        </div>
                        <div>
                            <p>calendar area</p>
                        </div>
                    </div>
                    
                    <div class="selected-date">
                        <div class="selected-date-label">Evaluation Date</div>
                        <div class="selected-date-value">{{  }}</div>
                    </div>
                    
                    <div class="time-section">
                        <div class="time-inputs">
                            <div class="time-input">
                                <label for="start-time">
                                    <i class="fas fa-clock"></i> Evaluation Start
                                </label>
                                <div class="time-input-group">
                                    <input type="time" id="start-time" v-model="startTime">
                                    <select class="ampm-select" v-model="startPeriod">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="time-input">
                                <label for="end-time">
                                    <i class="fas fa-clock"></i> Evaluation End
                                </label>
                                <div class="time-input-group">
                                    <input type="time" id="end-time" v-model="endTime">
                                    <select class="ampm-select" v-model="endPeriod">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="selected-time">
                            <div class="selected-time-value">
                                {{ }} - {{ }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="timer-section">
                    <div class="section-title">
                        <i class="fas fa-stopwatch"></i>
                        <h2>Evaluation Timer</h2>
                    </div>
                    
                    <div class="timer-label">Evaluation Time Remaining</div>
                    <div class="timer-display">{{ formattedTime }}</div>
                    
                    <div class="timer-controls">
                        <button class="timer-btn start" @click="startTimer" :disabled="timerRunning">
                            <i class="fas fa-play"></i> Start
                        </button>
                        <button class="timer-btn pause" @click="pauseTimer" :disabled="!timerRunning">
                            <i class="fas fa-pause"></i> Pause
                        </button>
                        <button class="timer-btn reset" @click="resetTimer">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                    </div>
                    
                    <div class="timer-inputs">
                        <div class="timer-input">
                            <label for="hours">
                                <i class="fas fa-clock"></i> Hours
                            </label>
                            <input type="number" id="hours" v-model="hours" min="0" max="23">
                        </div>
                        <div class="timer-input">
                            <label for="minutes">
                                <i class="fas fa-clock"></i> Minutes
                            </label>
                            <input type="number" id="minutes" v-model="minutes" min="0" max="59">
                        </div>
                        <div class="timer-input">
                            <label for="seconds">
                                <i class="fas fa-clock"></i> Seconds
                            </label>
                            <input type="number" id="seconds" v-model="seconds" min="0" max="59">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</template>

<script>

</script>

<style scoped>
* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0a2f0a 0%, #1a5a1a 50%, #2a7a2a 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 700;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            line-height: 1.2;
        }

        .header p {
            font-size: clamp(1rem, 2.5vw, 1.2rem);
            opacity: 0.9;
            margin-top: 10px;
        }

        .scheduler {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .calendar-section, .timer-section {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: clamp(15px, 3vw, 25px);
            flex: 1;
            min-width: min(100%, 350px);
            max-width: 600px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            color: #333;
            font-size: clamp(1.2rem, 3vw, 1.4rem);
        }

        .section-title i {
            color: #2a7a2a;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .calendar-header button {
            background: #f0f0f0;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .calendar-header button:hover {
            background: #e0e0e0;
        }

        .calendar-header h2 {
            font-size: clamp(1.1rem, 2.5vw, 1.3rem);
            color: #333;
            text-align: center;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-bottom: 20px;
        }

        .calendar-day-header {
            text-align: center;
            font-weight: 600;
            color: #666;
            padding: 8px 0;
            font-size: clamp(0.8rem, 2vw, 1rem);
        }

        .calendar-day {
            height: clamp(30px, 8vw, 40px);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: clamp(0.8rem, 2vw, 1rem);
        }

        .calendar-day:hover {
            background: #f0f0f0;
        }

        .calendar-day.selected {
            background: #2a7a2a;
            color: white;
        }

        .calendar-day.other-month {
            color: #ccc;
        }

        .calendar-day.today {
            background: #e1f5e1;
            font-weight: 600;
        }

        .time-section {
            margin-top: 25px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 15px;
        }

        .time-inputs {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .time-input {
            flex: 1;
            min-width: 150px;
        }

        .time-input label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: clamp(0.9rem, 2vw, 1rem);
        }

        .time-input-group {
            display: flex;
            gap: 8px;
        }

        .time-input-group input {
            flex: 1;
            padding: 10px 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: clamp(0.9rem, 2vw, 1rem);
            transition: all 0.3s ease;
            min-width: 0;
        }

        .time-input-group input:focus {
            border-color: #2a7a2a;
            outline: none;
        }

        .ampm-select {
            flex: 0.7;
            padding: 10px 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: clamp(0.9rem, 2vw, 1rem);
            background: white;
            transition: all 0.3s ease;
            min-width: 0;
        }

        .ampm-select:focus {
            border-color: #2a7a2a;
            outline: none;
        }

        .timer-display {
            font-size: clamp(2rem, 8vw, 3rem);
            font-weight: 700;
            color: #2a7a2a;
            text-align: center;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
            background: #f0fff0;
            padding: 15px;
            border-radius: 15px;
            border: 2px solid #e1f5e1;
            word-break: break-word;
        }

        .timer-label {
            font-size: clamp(1rem, 2.5vw, 1.2rem);
            font-weight: 600;
            color: #2a7a2a;
            text-align: center;
            margin-bottom: 10px;
        }

        .timer-controls {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .timer-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            font-size: clamp(0.9rem, 2vw, 1rem);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            min-width: 100px;
            justify-content: center;
        }

        .timer-btn.start {
            background: #2a7a2a;
            color: white;
        }

        .timer-btn.start:hover {
            background: #1a5a1a;
            transform: translateY(-2px);
        }

        .timer-btn.pause {
            background: #ff9800;
            color: white;
        }

        .timer-btn.pause:hover {
            background: #e68900;
            transform: translateY(-2px);
        }

        .timer-btn.reset {
            background: #f0f0f0;
            color: #333;
        }

        .timer-btn.reset:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }

        .selected-date {
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            background: #f0fff0;
            border-radius: 15px;
            border: 2px solid #e1f5e1;
        }

        .selected-date-label {
            font-size: clamp(0.9rem, 2vw, 1rem);
            color: #666;
            margin-bottom: 5px;
        }

        .selected-date-value {
            font-size: clamp(1.1rem, 2.5vw, 1.3rem);
            font-weight: 700;
            color: #2a7a2a;
        }

        .selected-time {
            text-align: center;
            margin-top: 10px;
            padding: 10px;
            background: #f0fff0;
            border-radius: 10px;
        }

        .selected-time-value {
            font-size: clamp(1rem, 2vw, 1.1rem);
            font-weight: 600;
            color: #2a7a2a;
        }

        .timer-inputs {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .timer-input {
            flex: 1;
            min-width: 80px;
        }

        .timer-input label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: clamp(0.9rem, 2vw, 1rem);
        }

        .timer-input input {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: clamp(0.9rem, 2vw, 1rem);
            transition: all 0.3s ease;
        }

        .timer-input input:focus {
            border-color: #2a7a2a;
            outline: none;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .scheduler {
                flex-direction: column;
                align-items: center;
            }
            
            .calendar-section, .timer-section {
                width: 100%;
                max-width: 500px;
            }
            
            .time-inputs {
                flex-direction: column;
            }
            
            .time-input {
                min-width: 100%;
            }
            
            .timer-controls {
                flex-direction: column;
            }
            
            .timer-btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            
            .container {
                gap: 20px;
            }
            
            .calendar-section, .timer-section {
                padding: 15px;
                border-radius: 15px;
            }
            
            .calendar-grid {
                gap: 3px;
            }
            
            .calendar-day {
                height: 35px;
                border-radius: 5px;
            }
            
            .time-section {
                padding: 15px;
            }
            
            .timer-inputs {
                gap: 10px;
            }
            
            .timer-input {
                min-width: calc(33.33% - 10px);
            }
        }

        @media (max-width: 360px) {
            .calendar-day-header {
                font-size: 0.7rem;
            }
            
            .calendar-day {
                font-size: 0.8rem;
                height: 30px;
            }
            
            .timer-input {
                min-width: calc(50% - 10px);
            }
            
            .timer-input:last-child {
                min-width: 100%;
            }
        }
</style>