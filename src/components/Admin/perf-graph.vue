<template>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap"
    rel="stylesheet"
  />
  <link
    href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined"
    rel="stylesheet"
  />

  <div class="container">
    <main class="main-grid">
      <section class="card">
        <h2 class="card-title">Graph of Performance</h2>
        <div class="graph-placeholder">
          <div class="placeholder-content">
            <svg
              class="placeholder-icon"
              fill="none"
              stroke="currentColor"
              viewBox="0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1.586-1.586a2 2 0 00-2.828 0L6 18M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
              ></path>
            </svg>
            <p class="placeholder-text-lg">Template</p>
            <p class="placeholder-text-sm">Placeholder for graph data</p>
          </div>
        </div>
      </section>
      <section class="card">
        <h2 class="card-title">A.I. Summarizer</h2>
        <div class="ai-response">
          <p class="response-text">A.I. Response Here</p>
        </div>
        <div class="input-container">
          <div class="input-wrapper">
            <input class="text-input" placeholder="Text here" type="text" />
            <button class="send-button" type="button">
              <span class="material-icons-outlined send-icon">send</span>
            </button>
          </div>
        </div>
      </section>
    </main>
  </div>
</template>

<style scoped>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  background-color: #ffffff;
  color: #000000;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.container {
  display: flex;
  flex-direction: column;
  height: 100vh;
  padding: 1rem;
}

@media (min-width: 640px) {
  .container {
    padding: 1.5rem;
  }
}

@media (min-width: 1024px) {
  .container {
    padding: 2rem;
  }
}

.main-grid {
  flex: 1;
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
}

@media (min-width: 1024px) {
  .main-grid {
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
  }
}

.card {
  background-color: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
    0 2px 4px -1px rgba(0, 0, 0, 0.06);
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
}

.card-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #000000;
  margin-bottom: 1.5rem;
}

.graph-placeholder {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: #f8fafc;
  border-radius: 0.5rem;
}

.placeholder-content {
  text-align: center;
  color: #64748b;
}

.placeholder-icon {
  width: 4rem;
  height: 4rem;
  margin: 0 auto 1rem auto;
  color: #94a3b8;
}

.placeholder-text-lg {
  font-size: 1.125rem;
  font-weight: 500;
  margin-bottom: 0.25rem;
}

.placeholder-text-sm {
  font-size: 0.875rem;
}

.ai-response {
  flex: 1;
  background-color: #f8fafc;
  border-radius: 0.5rem;
  padding: 1rem;
}

.response-text {
  color: #64748b;
}

.input-container {
  margin-top: 1.5rem;
  display: flex;
  align-items: center;
  gap: 1rem;
}

.input-wrapper {
  position: relative;
  flex: 1;
}

.text-input {
  width: 100%;
  padding-left: 1rem;
  padding-right: 3rem;
  padding-top: 0.625rem;
  padding-bottom: 0.625rem;
  border-radius: 0.5rem;
  border: 1px solid #cbd5e0;
  background-color: #f7fafc;
  color: #000000;
  transition: all 0.15s ease-in-out;
}

.text-input::placeholder {
  color: #94a3b8;
}

.text-input:focus {
  outline: none;
  ring: 2px solid #000000;
  border-color: #000000;
}

.send-button {
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 1rem;
  color: #64748b;
  background: none;
  border: none;
  cursor: pointer;
  transition: color 0.15s ease-in-out;
}

.send-button:hover {
  color: #000000;
}

.send-icon {
  font-size: 1.25rem;
}
</style>
