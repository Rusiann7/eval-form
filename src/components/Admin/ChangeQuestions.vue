<template>
    <div id="app">
        <div class="container">
            <div class="header">
                <h1>Student Questions</h1>
            </div>

            <div class="search-section">
                <div class="search-bar">
                    <input 
                        type="text" 
                        class="search-input" 
                        placeholder="Search questions..." 
                        v-model="searchQuery"
                    >
                    <button class="search-btn">Search</button>
                </div> 
            </div>

            <div class="questions-container">
                <div class="questions-header">
                    <h2>Questions</h2>
                    <div class="questions-count">{{ filteredQuestions.length }} questions</div>
                </div>

                <div class="questions-list">
                    <div 
                        class="question-item" 
                        v-for="(question, index) in filteredQuestions" 
                        :key="question.id"
                        :draggable="true"
                        @dragstart="dragStart(index)"
                        @dragover.prevent
                        @dragenter="dragEnter(index)"
                        @dragleave="dragLeave(index)"
                        @drop="drop(index)"
                        :class="{ 'dragging': draggedIndex === index }"
                    >
                        <div class="drag-indicator">
                            <i class="fas fa-grip-lines"></i>
                        </div>
                        <div class="question-content-wrapper">
                            <div class="question-header">
                                <div class="question-title">{{ question.title }}</div>
                                <div class="question-date">{{ formatDate(question.date) }}</div>
                            </div>
                            <div class="question-content">{{ question.content }}</div>
                            <div class="question-actions">
                                <button class="btn btn-edit" @click="editQuestion(question)">Edit</button>
                                <button class="btn btn-remove" @click="removeQuestion(question.id)">Remove</button>
                            </div>
                        </div>
                    </div>

                    <div class="empty-state" v-if="filteredQuestions.length === 0">
                        <p>No questions found. Try a different search term.</p>
                        <button class="add-question-btn" @click="addNewQuestion">Add New Question</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit/Add Question Modal -->
        <div class="edit-modal" v-if="showModal">
            <div class="edit-modal-content">
                <div class="edit-modal-header">
                    <h3>{{ editingQuestion ? 'Edit Question' : 'Add New Question' }}</h3>
                    <button class="close-btn" @click="closeModal">&times;</button>
                </div>
                
                <div class="form-group">
                    <label for="question-title">Question Title</label>
                    <input 
                        type="text" 
                        id="question-title" 
                        class="form-control" 
                        v-model="currentQuestion.title"
                        placeholder="Enter question title"
                    >
                </div>
                
                <div class="form-group">
                    <label for="question-content">Question Content</label>
                    <textarea 
                        id="question-content" 
                        class="form-control" 
                        v-model="currentQuestion.content"
                        placeholder="Enter question content"
                    ></textarea>
                </div>
                
                <div class="modal-actions">
                    <button class="btn btn-cancel" @click="closeModal">Cancel</button>
                    <button class="btn btn-save" @click="saveQuestion">
                        {{ editingQuestion ? 'Update' : 'Add' }} Question
                    </button>
                </div>
            </div>
        </div>
    </div> 
</template>

<style scoped>
* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%);
            color: #f5f5f5;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 2.5rem;
            background: linear-gradient(135deg, #ff8c00 0%, #ffa500 50%, #ffd700 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .header p {
            color: #aaa;
            font-size: 1.1rem;
        }

        .search-section {
            margin-bottom: 30px;
        }

        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .search-input {
            flex: 1;
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 2px rgba(255, 165, 0, 0.5);
        }

        .search-btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #ff8c00 0%, #ffa500 100%);
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background: linear-gradient(135deg, #ffa500 0%, #ff8c00 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 165, 0, 0.3);
        }

        .questions-container {
            background: rgba(40, 40, 40, 0.8);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .questions-header {
            padding: 15px 20px;
            background: linear-gradient(135deg, #ff8c00 0%, #ffa500 100%);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .questions-header h2 {
            font-size: 1.5rem;
            color: white;
        }

        .questions-count {
            background: rgba(0, 0, 0, 0.2);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .questions-list {
            max-height: 500px;
            overflow-y: auto;
        }

        .question-item {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            cursor: move;
        }

        .question-item:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .question-item:last-child {
            border-bottom: none;
        }

        .question-item.dragging {
            opacity: 0.5;
            background: rgba(255, 165, 0, 0.1);
        }

        .drag-indicator {
            color: #ffa500;
            font-size: 1.2rem;
            padding: 5px;
            cursor: grab;
            display: flex;
            align-items: center;
            height: 100%;
            transition: all 0.3s ease;
        }

        .drag-indicator:active {
            cursor: grabbing;
        }

        .question-content-wrapper {
            flex: 1;
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .question-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #ffa500;
        }

        .question-date {
            font-size: 0.85rem;
            color: #aaa;
        }

        .question-content {
            margin-bottom: 15px;
            line-height: 1.5;
            color: #ddd;
        }

        .question-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: linear-gradient(135deg, #2196F3 0%, #0b7dda 100%);
            color: white;
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #0b7dda 0%, #2196F3 100%);
            transform: translateY(-2px);
        }

        .btn-remove {
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
            color: white;
        }

        .btn-remove:hover {
            background: linear-gradient(135deg, #d32f2f 0%, #f44336 100%);
            transform: translateY(-2px);
        }

        .btn-save {
            background: linear-gradient(135deg, #ff8c00 0%, #ffa500 100%);
            color: white;
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #ffa500 0%, #ff8c00 100%);
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            color: white;
        }

        .btn-cancel:hover {
            background: linear-gradient(135deg, #5a6268 0%, #6c757d 100%);
            transform: translateY(-2px);
        }

        .empty-state {
            padding: 40px 20px;
            text-align: center;
            color: #aaa;
        }

        .empty-state p {
            margin-bottom: 20px;
        }

        .add-question-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #ff8c00 0%, #ffa500 100%);
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-question-btn:hover {
            background: linear-gradient(135deg, #ffa500 0%, #ff8c00 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 165, 0, 0.3);
        }

        .edit-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .edit-modal-content {
            background: #2c2c2c;
            width: 90%;
            max-width: 600px;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .edit-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .edit-modal-header h3 {
            color: #ffa500;
            font-size: 1.5rem;
        }

        .close-btn {
            background: none;
            border: none;
            color: #aaa;
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-btn:hover {
            color: #ffa500;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #ddd;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 2px rgba(255, 165, 0, 0.5);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .drag-hint {
            text-align: center;
            color: #ffa500;
            font-size: 0.9rem;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        @media (max-width: 768px) {
            .question-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .question-date {
                margin-top: 5px;
            }
            
            .question-actions {
                flex-wrap: wrap;
            }
        } 
</style>