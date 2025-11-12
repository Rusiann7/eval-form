<template>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap"
    rel="stylesheet"
  />
  <link
    href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet"
  />

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
                >
                </textarea>
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
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

main-modal {
  background-color: #ffffff;
  color: #1f2937;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
}

@media (min-width: 640px) {
  main-modal {
    padding: 1.5rem;
  }
}

@media (min-width: 1024px) {
  main-modal {
    padding: 2rem;
  }
}

.modal-container {
  width: 100%;
  max-width: 80rem;
  height: 100%;
  max-height: 90vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-content {
  width: 100%;
  max-width: 72rem;
  border-radius: 0.5rem;
  background-color: #f8fafc;
  padding: 2rem;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.modal-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 3rem;
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
  gap: 2rem;
}

.profile-section {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
}

@media (min-width: 640px) {
  .profile-section {
    grid-template-columns: auto 1fr;
    gap: 1.5rem;
  }
}

.profile-image-container {
  display: flex;
  align-items: center;
  justify-content: center;
}

@media (min-width: 640px) {
  .profile-image-container {
    justify-content: flex-start;
  }
}

.profile-image {
  width: 10rem;
  height: 10rem;
  background-color: #e2e8f0;
  border-radius: 0.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.profile-icon {
  font-size: 3.75rem;
  color: #9ca3af;
}

.profile-details {
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 1rem;
}

.detail-item {
  margin-bottom: 0.5rem;
}

.detail-label {
  font-weight: 500;
  color: #6b7280;
  display: block;
}

.detail-value {
  margin-top: 0.25rem;
  font-weight: 600;
  font-size: 1rem;
  color: #111827;
}

.info-section {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.info-item {
  margin-bottom: 0.5rem;
}

.info-label {
  font-weight: 500;
  color: #6b7280;
  display: block;
}

.info-value {
  margin-top: 0.25rem;
  font-weight: 600;
  font-size: 1rem;
  color: #111827;
}

.buttons-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
  padding-top: 1rem;
}

.action-button {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  background-color: #ffffff;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  cursor: pointer;
  transition: all 0.2s ease-in-out;
}

.action-button:hover {
  background-color: #f3f4f6;
}

.action-button:focus {
  outline: none;
  box-shadow: 0 0 0 2px #0f172a, 0 0 0 4px rgba(15, 23, 42, 0.1);
}

.right-column {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.ai-title {
  font-size: 1.25rem;
  font-weight: 700;
  text-align: center;
  margin-bottom: 1rem;
  color: #111827;
}

.ai-container {
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  background-color: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  padding: 1rem;
  height: 100%;
}

.ai-response {
  flex-grow: 1;
  margin-bottom: 1rem;
}

.ai-textarea {
  width: 100%;
  height: 100%;
  resize: none;
  background-color: transparent;
  border: none;
  padding: 0;
  color: #4b5563;
  font-size: 0.875rem;
  line-height: 1.5;
  font-family: inherit; /* Add this */
}

.ai-textarea:focus {
  outline: none;
  box-shadow: none;
}

.ai-input-container {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.ai-input {
  flex-grow: 1;
  width: 100%;
  padding: 0.5rem 1rem;
  background-color: #f3f4f6;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  transition: all 0.2s ease-in-out;
}

.ai-input:focus {
  outline: none;
  box-shadow: 0 0 0 2px #0f172a;
  border-color: #0f172a;
}

.ai-input::placeholder {
  color: #6b7280;
}

.ai-send-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
  font-weight: 600;
  color: #ffffff;
  background-color: #0f172a;
  border: none;
  border-radius: 0.375rem;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  cursor: pointer;
  transition: all 0.2s ease-in-out;
}

.ai-send-button:hover {
  background-color: #1e293b;
}

.ai-send-button:focus {
  outline: none;
  box-shadow: 0 0 0 2px #0f172a, 0 0 0 4px rgba(15, 23, 42, 0.1);
}

.send-icon {
  font-size: 1.125rem;
}
</style>
