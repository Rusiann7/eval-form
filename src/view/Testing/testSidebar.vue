<template>
  <div class="container">
    <header class="header">
      <div class="search-container">
        <span class="material-icons search-icon">search</span>
        <input
          aria-label="Search"
          class="search-input"
          placeholder="Search questions..."
          type="text"
        />
      </div>

      <div class="header-buttons">
        <button class="btn-secondary">
          <span class="material-icons">refresh</span>
          Refresh
        </button>
        <button class="btn-primary">
          <span class="material-icons">add</span>
          Add New
        </button>
      </div>
    </header>

    <main class="main">
      <!-- Draggable Headers -->
      <draggable
        v-model="headers"
        group="headers"
        @start="drag = true"
        @end="drag = false"
        item-key="header_id"
        class="draggable-container"
        handle=".drag-handle"
      >
        <template #item="{ element: header, index }">
          <div class="section">
            <div class="section-header">
              <div class="section-title">
                <span class="material-icons drag-handle">drag_indicator</span>
                <p class="title-text">{{ header.header || `Header ${index + 1}` }}</p>
              </div>
              <div class="section-actions">
                <button class="btn-section">
                  <span class="material-icons">edit</span>
                  Edit
                </button>
                <button class="btn-section" @click="removeHeader(header.header_id)">
                  <span class="material-icons">delete</span>
                  Remove
                </button>
                <button class="btn-section">
                  <span class="material-icons">add</span>
                  Add Question
                </button>
              </div>
            </div>

            <!-- Draggable Questions within Header -->
            <draggable
              v-model="header.questions"
              group="questions"
              @start="drag = true"
              @end="drag = false"
              item-key="question_id"
              class="questions-container"
              handle=".question-drag-handle"
            >
              <template #item="{ element: question }">
                <div class="question-card">
                  <div class="question-content">
                    <div class="question-text">
                      <span class="material-icons question-drag-handle">drag_handle</span>
                      <p>{{ question.question_text || question || 'Question text here...' }}</p>
                    </div>
                    <div class="question-actions">
                      <button class="btn-question">
                        <span class="material-icons">edit</span>
                        Edit
                      </button>
                      <button class="btn-question" @click="removeQuestion(header.header_id, question.question_id)">
                        <span class="material-icons">delete</span>
                        Remove
                      </button>
                    </div>
                  </div>
                </div>
              </template>
              
              <!-- Empty state for questions -->
              <template #footer v-if="!header.questions || header.questions.length === 0">
                <div class="empty-questions">
                  <span class="material-icons">question_mark</span>
                  <p>No questions yet. Add your first question.</p>
                </div>
              </template>
            </draggable>
          </div>
        </template>
        
        <!-- Add Header Button -->
        <template #footer>
          <div class="add-header-section">
            <button class="add-header-btn" @click="addNewHeader">
              <span class="material-icons">add_circle</span>
              Add New Header
            </button>
          </div>
        </template>
      </draggable>
    </main>
  </div>
</template>

<script>
import draggable from "vuedraggable";

export default {
  components: {
    draggable,
  },
  data() {
    return {
      drag: false,
      headers: [
        {
          header_id: 1,
          header: "Technical Skills Assessment",
          questions: [
            {
              question_id: 1,
              question_text: "How would you rate your proficiency in JavaScript?"
            },
            {
              question_id: 2,
              question_text: "Describe your experience with Vue.js framework"
            },
            {
              question_id: 3,
              question_text: "What testing frameworks have you worked with?"
            }
          ]
        },
        {
          header_id: 2,
          header: "Soft Skills Evaluation",
          questions: [
            {
              question_id: 4,
              question_text: "How do you handle conflict in a team setting?"
            },
            {
              question_id: 5,
              question_text: "Describe your approach to time management"
            }
          ]
        }
      ],
    };
  },
  mounted() {
    // Fetch initial data if needed
    this.getQuestions();
  },
  methods: {
    async getQuestions() {
      try {
        // Your existing fetch logic here
        console.log("Fetching questions...");
      } catch (error) {
        console.error("Error fetching questions:", error);
      }
    },
    addNewHeader() {
      const newId = this.headers.length + 1;
      this.headers.push({
        header_id: newId,
        header: `New Header ${newId}`,
        questions: []
      });
    },
    removeHeader(headerId) {
      const index = this.headers.findIndex(h => h.header_id === headerId);
      if (index > -1) {
        this.headers.splice(index, 1);
      }
    },
    removeQuestion(headerId, questionId) {
      const header = this.headers.find(h => h.header_id === headerId);
      if (header) {
        const index = header.questions.findIndex(q => q.question_id === questionId);
        if (index > -1) {
          header.questions.splice(index, 1);
        }
      }
    }
  },
};
</script>

<style scoped>
/* Base Styles */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

:root {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 1rem;
  min-height: 100vh;
  background-color: #f8fafc;
}

@media (min-width: 768px) {
  .container {
    padding: 2rem;
  }
}

/* Header Styles */
.header {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  margin-bottom: 2.5rem;
  padding: 1.5rem;
  background: white;
  border-radius: 1rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

@media (min-width: 768px) {
  .header {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
  }
}

/* Search Container */
.search-container {
  position: relative;
  flex: 1;
  max-width: 600px;
}

.search-icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #64748b;
  font-size: 1.5rem;
}

.search-input {
  width: 100%;
  padding: 1rem 1rem 1rem 3.5rem;
  font-size: 1.125rem;
  border: 2px solid #e2e8f0;
  border-radius: 0.75rem;
  background: #f8fafc;
  transition: all 0.3s ease;
  color: #0f172a;
}

.search-input:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  background: white;
}

.search-input::placeholder {
  color: #94a3b8;
  font-size: 1.125rem;
}

/* Header Buttons */
.header-buttons {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.btn-primary,
.btn-secondary {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.875rem 1.75rem;
  font-size: 1.125rem;
  font-weight: 600;
  border-radius: 0.75rem;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
  min-height: 3.5rem;
}

.btn-primary {
  background: #0f172a;
  color: white;
}

.btn-primary:hover {
  background: #1e293b;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
}

.btn-secondary {
  background: white;
  color: #0f172a;
  border: 2px solid #e2e8f0;
}

.btn-secondary:hover {
  background: #f1f5f9;
  border-color: #cbd5e1;
  transform: translateY(-2px);
}

.btn-primary .material-icons,
.btn-secondary .material-icons {
  font-size: 1.25rem;
}

/* Main Content */
.main {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.draggable-container {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

/* Sections */
.section {
  background: white;
  border-radius: 1rem;
  padding: 1.5rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  border: 2px solid transparent;
  transition: all 0.3s ease;
}

.section:hover {
  border-color: #e2e8f0;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}

.section-header {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  margin-bottom: 1.5rem;
  padding-bottom: 1.5rem;
  border-bottom: 2px solid #f1f5f9;
}

@media (min-width: 768px) {
  .section-header {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
  }
}

.section-title {
  display: flex;
  align-items: center;
  gap: 1rem;
  flex: 1;
}

.drag-handle {
  color: #94a3b8;
  font-size: 1.5rem;
  cursor: move;
}

.title-text {
  font-size: 1.5rem;
  font-weight: 700;
  color: #0f172a;
  line-height: 1.4;
}

@media (min-width: 768px) {
  .title-text {
    font-size: 1.75rem;
  }
}

.section-actions {
  display: flex;
  gap: 0.75rem;
  flex-wrap: wrap;
}

.btn-section {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.25rem;
  font-size: 1rem;
  font-weight: 600;
  border-radius: 0.5rem;
  border: 2px solid #e2e8f0;
  background: white;
  color: #475569;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-section:hover {
  background: #f8fafc;
  border-color: #cbd5e1;
  color: #0f172a;
  transform: translateY(-2px);
}

.btn-section .material-icons {
  font-size: 1.125rem;
}

/* Questions Container */
.questions-container {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  min-height: 100px;
}

.question-card {
  background: #f8fafc;
  border-radius: 0.75rem;
  border: 2px solid #e2e8f0;
  padding: 1.25rem;
  transition: all 0.3s ease;
}

.question-card:hover {
  border-color: #cbd5e1;
  background: #f1f5f9;
  transform: translateX(4px);
}

.question-content {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

@media (min-width: 768px) {
  .question-content {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
  }
}

.question-text {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  flex: 1;
}

.question-drag-handle {
  color: #94a3b8;
  font-size: 1.25rem;
  cursor: move;
  flex-shrink: 0;
  margin-top: 0.125rem;
}

.question-text p {
  font-size: 1.125rem;
  color: #334155;
  line-height: 1.6;
  font-weight: 500;
}

@media (min-width: 768px) {
  .question-text p {
    font-size: 1.25rem;
  }
}

.question-actions {
  display: flex;
  gap: 0.75rem;
  flex-shrink: 0;
}

.btn-question {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.625rem 1rem;
  font-size: 0.875rem;
  font-weight: 600;
  border-radius: 0.5rem;
  border: 2px solid #e2e8f0;
  background: white;
  color: #475569;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-question:hover {
  background: #f1f5f9;
  border-color: #cbd5e1;
  color: #0f172a;
}

.btn-question .material-icons {
  font-size: 1.125rem;
}

/* Empty State */
.empty-questions {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 3rem 1rem;
  background: #f8fafc;
  border-radius: 0.75rem;
  border: 2px dashed #cbd5e1;
  text-align: center;
  color: #64748b;
}

.empty-questions .material-icons {
  font-size: 3rem;
  color: #94a3b8;
  margin-bottom: 1rem;
}

.empty-questions p {
  font-size: 1.125rem;
  font-weight: 500;
}

/* Add Header Section */
.add-header-section {
  display: flex;
  justify-content: center;
  padding: 1.5rem;
}

.add-header-btn {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 1rem 2rem;
  font-size: 1.125rem;
  font-weight: 600;
  color: #3b82f6;
  background: white;
  border: 2px dashed #3b82f6;
  border-radius: 0.75rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

.add-header-btn:hover {
  background: #eff6ff;
  border-style: solid;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
}

.add-header-btn .material-icons {
  font-size: 1.5rem;
}

/* Draggable States */
.sortable-chosen {
  background: #f8fafc;
  border-color: #cbd5e1;
}

.sortable-ghost {
  opacity: 0.5;
  background: #f1f5f9;
}

/* Responsive Design */
@media (max-width: 767px) {
  .container {
    padding: 1rem;
  }
  
  .header {
    padding: 1rem;
  }
  
  .search-input {
    font-size: 1rem;
    padding: 0.875rem 0.875rem 0.875rem 3rem;
  }
  
  .btn-primary,
  .btn-secondary {
    padding: 0.75rem 1.25rem;
    font-size: 1rem;
    min-height: 3rem;
  }
  
  .section {
    padding: 1.25rem;
  }
  
  .title-text {
    font-size: 1.25rem;
  }
  
  .section-actions {
    justify-content: center;
  }
  
  .question-text p {
    font-size: 1rem;
  }
  
  .btn-question {
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
  }
}

@media (max-width: 480px) {
  .header-buttons {
    width: 100%;
    justify-content: center;
  }
  
  .btn-primary,
  .btn-secondary {
    flex: 1;
    justify-content: center;
  }
  
  .section-actions {
    width: 100%;
  }
  
  .btn-section {
    flex: 1;
    justify-content: center;
  }
  
  .question-actions {
    width: 100%;
    justify-content: center;
  }
  
  .btn-question {
    flex: 1;
    justify-content: center;
  }
}

/* Focus States for Accessibility */
button:focus,
input:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
}
</style> 