<template>
  <div class="main-modal">
    <div class="modal-container">
      <div class="modal-content">
        <div class="modal-grid">
          <div class="left-column">
            <div class="profile-section">
              <div class="profile-image-container">
                <div class="profile-image">
                  <span class="material-icons profile-icon">image</span>
                </div>
              </div>
              <div class="profile-details">
                <div class="detail-item">
                  <label class="detail-label">Name</label>
                  <p class="detail-value">John Doe</p>
                </div>
                <div class="detail-item">
                  <label class="detail-label">Quarter</label>
                  <p class="detail-value">Q3</p>
                </div>
                <div class="detail-item">
                  <label class="detail-label">Year</label>
                  <p class="detail-value">2023</p>
                </div>
              </div>
            </div>
            <div class="info-section">
              <div class="info-item">
                <label class="info-label">Subject</label>
                <p class="info-value">Quarterly Performance Review</p>
              </div>
              <div class="info-item">
                <label class="info-label">Sentiment</label>
                <p class="info-value">Positive</p>
              </div>
            </div>
            <div class="buttons-grid">
              <button class="action-button">Previous Evaluation</button>
              <button class="action-button">Average Evaluation</button>
              <button class="action-button">Show Performance Graph</button>
              <button class="action-button">Individual Evaluation</button>
            </div>
          </div>
          <div class="right-column">
            <h2 class="ai-title">AI Summarizer</h2>
            <div class="ai-container">
              <div class="ai-response">
                <textarea
                  class="ai-textarea"
                  placeholder="AI Response Here..."
                  readonly
                ></textarea>
              </div>
              <div class="ai-input-container">
                <input
                  class="ai-input"
                  placeholder="Ask a follow-up..."
                  type="text"
                />
                <button class="ai-send-button">
                  <span class="material-icons send-icon">send</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

:root {
  font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.main-modal {
  background-color: #ffffff;
  color: #1f2937;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
}

@media (min-width: 640px) {
  .main-modal {
    padding: 1.5rem;
  }
}

@media (min-width: 1024px) {
  .main-modal {
    padding: 2rem;
  }
}

.modal-container {
  width: 100%;
  max-width: 90rem;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-content {
  width: 100%;
  max-width: 85rem;
  border-radius: 1rem;
  background-color: #f8fafc;
  padding: 2rem;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

@media (max-width: 768px) {
  .modal-content {
    padding: 1.5rem;
  }
}

.modal-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2.5rem;
}

@media (min-width: 1024px) {
  .modal-grid {
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
  }
}

.left-column {
  display: flex;
  flex-direction: column;
  gap: 2.5rem;
}

.profile-section {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

@media (min-width: 640px) {
  .profile-section {
    flex-direction: row;
    align-items: center;
    gap: 2rem;
  }
}

.profile-image-container {
  display: flex;
  justify-content: center;
}

@media (min-width: 640px) {
  .profile-image-container {
    justify-content: flex-start;
  }
}

.profile-image {
  width: 12rem;
  height: 12rem;
  background-color: #e2e8f0;
  border-radius: 0.75rem;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

@media (max-width: 639px) {
  .profile-image {
    width: 10rem;
    height: 10rem;
    margin: 0 auto;
  }
}

.profile-icon {
  font-size: 4.5rem;
  color: #9ca3af;
}

.profile-details {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
  flex-grow: 1;
}

.detail-item {
  margin-bottom: 0.25rem;
}

.detail-label {
  font-weight: 500;
  color: #6b7280;
  display: block;
  font-size: 1rem;
  margin-bottom: 0.25rem;
}

@media (min-width: 768px) {
  .detail-label {
    font-size: 1.125rem;
  }
}

.detail-value {
  font-weight: 600;
  font-size: 1.25rem;
  color: #111827;
}

@media (min-width: 768px) {
  .detail-value {
    font-size: 1.5rem;
  }
}

.info-section {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.info-item {
  margin-bottom: 0.25rem;
}

.info-label {
  font-weight: 500;
  color: #6b7280;
  display: block;
  font-size: 1rem;
  margin-bottom: 0.25rem;
}

@media (min-width: 768px) {
  .info-label {
    font-size: 1.125rem;
  }
}

.info-value {
  font-weight: 600;
  font-size: 1.25rem;
  color: #111827;
}

@media (min-width: 768px) {
  .info-value {
    font-size: 1.5rem;
  }
}

.buttons-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
  padding-top: 1rem;
}

@media (min-width: 640px) {
  .buttons-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .buttons-grid {
    gap: 1.25rem;
  }
}

.action-button {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding: 1rem 1.25rem;
  font-size: 1rem;
  font-weight: 500;
  color: #374151;
  background-color: #ffffff;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
  cursor: pointer;
  transition: all 0.2s ease-in-out;
  text-align: center;
  line-height: 1.4;
  min-height: 3.5rem;
}

@media (min-width: 768px) {
  .action-button {
    font-size: 1.125rem;
    padding: 1.125rem 1.5rem;
  }
}

.action-button:hover {
  background-color: #f3f4f6;
  transform: translateY(-2px);
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.action-button:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1), 0 0 0 2px #0f172a;
}

.right-column {
  display: flex;
  flex-direction: column;
  height: 100%;
  min-height: 30rem;
}

.ai-title {
  font-size: 1.75rem;
  font-weight: 700;
  text-align: center;
  margin-bottom: 1.5rem;
  color: #111827;
}

@media (min-width: 768px) {
  .ai-title {
    font-size: 2rem;
    margin-bottom: 2rem;
  }
}

.ai-container {
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  background-color: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 0.75rem;
  padding: 1.5rem;
  height: 100%;
  min-height: 25rem;
}

@media (min-width: 768px) {
  .ai-container {
    padding: 2rem;
  }
}

.ai-response {
  flex-grow: 1;
  margin-bottom: 1.5rem;
}

.ai-textarea {
  width: 100%;
  height: 100%;
  min-height: 15rem;
  resize: none;
  background-color: transparent;
  border: none;
  padding: 0;
  color: #4b5563;
  font-size: 1.125rem;
  line-height: 1.6;
  font-family: inherit;
}

@media (min-width: 768px) {
  .ai-textarea {
    font-size: 1.25rem;
    line-height: 1.7;
  }
}

.ai-textarea:focus {
  outline: none;
  box-shadow: none;
}

.ai-input-container {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.ai-input {
  flex-grow: 1;
  width: 100%;
  padding: 1rem 1.25rem;
  background-color: #f3f4f6;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  font-size: 1.125rem;
  transition: all 0.2s ease-in-out;
}

@media (min-width: 768px) {
  .ai-input {
    font-size: 1.25rem;
    padding: 1.125rem 1.5rem;
  }
}

.ai-input:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
  border-color: #0f172a;
  background-color: #ffffff;
}

.ai-input::placeholder {
  color: #6b7280;
}

.ai-send-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 1rem 1.5rem;
  font-size: 1rem;
  font-weight: 600;
  color: #ffffff;
  background-color: #0f172a;
  border: none;
  border-radius: 0.5rem;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
  cursor: pointer;
  transition: all 0.2s ease-in-out;
  flex-shrink: 0;
  min-width: 4rem;
}

@media (min-width: 768px) {
  .ai-send-button {
    padding: 1.125rem 1.75rem;
    font-size: 1.125rem;
  }
}

.ai-send-button:hover {
  background-color: #1e293b;
  transform: translateY(-2px);
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.ai-send-button:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.3);
}

.send-icon {
  font-size: 1.5rem;
}

@media (min-width: 768px) {
  .send-icon {
    font-size: 1.75rem;
  }
}
</style> 