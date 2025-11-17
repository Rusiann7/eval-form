<template>
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap"
    rel="stylesheet"
  />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined"
    rel="stylesheet"
  />

  <!--sidebar-->
  <div class="side-bar">
    <div class="menu">
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="$router.push('/principal')"
          >Student</a
        >
      </div>
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu2 = !showMenu2"
          >Teacher</a
        >
        <div class="sub-menu" v-if="showMenu2">
          <a href="#" @click="click('teacher')" class="sub-item"
            >Evaluation Answers</a
          >
          <a href="#" @click="click('evaluate')" class="sub-item"
            >Evaluate Teachers</a
          >
        </div>
      </div>
      <div class="item">
        <a href="#" @click.stop="$router.push('/principal')"
          >Account Management</a
        >
        <div class="sub-menu" v-if="showMenu3">
          <a href="#" @click="click2('crtTeacher')" class="sub-item"
            >Add Teachers</a
          >
          <a href="#" @click="click2('rmTeacher')" class="sub-item"
            >Delete Users</a
          >
          <a href="#" @click="click2('rmTeacher')" class="sub-item"
            >Edit Users</a
          >
        </div>
      </div>
      <div class="item">
        <a href="#" @click.prevent="$router.push('/scheduler')">Scheduler</a>
      </div>
      <div class="item">
        <a href="#" @click.prevent="$router.push('/fileupload')">File Upload</a>
      </div>

      <div class="item">
        <a href="#" @click.prevent="showMenu4 = !showMenu4">Question Change</a>

        <div class="sub-menu" v-if="showMenu4">
          <a
            href="#"
            @click.prevent="$router.push('/changequestions-student')"
            class="sub-item"
            >Chnage Student Questions</a
          >
          <a
            href="#"
            @click.prevent="$router.push('/changequestions-teacher')"
            class="sub-item"
            >Change Teacher Questions</a
          >
        </div>
      </div>
    </div>
  </div>

  <!--end of sidebar-->

  <div class="content">
    <div class="container">
      <main class="main-content">
        <div class="card" style="margin-bottom: 40px">
          <div class="titles">
            <h1>Current Times</h1>
            <br />
            <h3>Time Start: {{ startendtime.time_start }}</h3>
            <h3>Date Start: {{ startendtime.date_start }}</h3>
            <h3>Time End: {{ startendtime.time_end }}</h3>
            <h3>Date End: {{ startendtime.date_end }}</h3>
          </div>
        </div>
        <div class="card">
          <header class="header">
            <h1 class="title">Set Due Date</h1>
            <p class="subtitle">
              Define the submission deadline for this assignment.
            </p>
          </header>
          <form @submit.prevent="this.setTime()" class="form" method="POST">
            <div class="form-grid">
              <div class="form-group">
                <label class="label" for="due-date">Due date</label>
                <div class="input-container">
                  <span class="material-icons-outlined input-icon">
                    calendar_today
                  </span>
                  <input
                    class="input-field"
                    name="due-date"
                    type="date"
                    v-model="times.dateset"
                    required
                  />
                </div>
              </div>
              <div class="form-group">
                <label class="label" for="due-time">Time</label>
                <div class="input-container">
                  <span class="material-icons-outlined input-icon">
                    schedule
                  </span>
                  <input
                    class="input-field"
                    name="due-time"
                    type="time"
                    v-model="times.timeset"
                    required
                  />
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="label">End</label>
              <p class="description">
                Set a final cutoff date and time after which submissions are no
                longer accepted.
              </p>
              <div class="form-grid">
                <div>
                  <div class="input-container">
                    <span class="material-icons-outlined input-icon">
                      event_busy
                    </span>
                    <input
                      class="input-field"
                      name="end-date"
                      type="date"
                      v-model="times.dateend"
                      required
                    />
                  </div>
                </div>
                <div>
                  <div class="input-container">
                    <span class="material-icons-outlined input-icon">
                      access_time
                    </span>
                    <input
                      class="input-field"
                      name="end-time"
                      type="time"
                      v-model="times.timeend"
                      required
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="button-container">
              <button class="button" type="submit">
                <span class="material-icons-outlined">save</span>
                Save Settings
              </button>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
const url1 = "https://rusiann7.helioho.st";
const url2 = "https://star-panda-literally.ngrok-free.app";

export default {
  name: "schedule",
  data() {
    return {
      timegetterphp: `${url2}/timeGetter.php`,
      timesettierphp: `${url2}/startEvalSMTP.php`,
      times: {
        timeset: "",
        dateset: "",
        timeend: "",
        dateend: "",
      },
      startendtime: {},
      isLoading: false,
      showMenu1: false,
      showMenu2: false,
      showMenu3: false,
      showMenu4: false,
    };
  },

  methods: {
    async setTime() {
      try {
        this.isLoading = true;

        const response = await fetch(this.timesettierphp, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "setTime",
            time_start: this.times.timeset,
            date_start: this.times.dateset,
            time_end: this.times.timeend,
            date_end: this.times.dateend,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.isLoading = false;
          this.getTime();
        } else {
          this.isLoading = false;
        }
      } catch (error) {
        this.isLoading = false;
        console.error(error);
      }
    },

    async getTime() {
      try {
        this.isLoading = true;

        const response = await fetch(this.timegetterphp, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "getTime",
          }),
        });

        const result = await response.json();

        if (result.success) {
          const t = result.times || {};
          this.startendtime = {
            time_start: t.time_start,
            date_start: t.date_start,
            time_end: t.time_end,
            date_end: t.date_end,
          };
          this.isLoading = false;
        } else {
          this.isLoading = false;
        }
      } catch (error) {
        this.isLoading = false;
        console.error(error);
      }
    },
  },

  mounted() {
    this.getTime();
  },
};
</script>

<style scoped>
.material-icons-outlined {
  font-size: 20px;
}

input[type="date"]::-webkit-calendar-picker-indicator {
  cursor: pointer;
  filter: invert(0.5);
}

input[type="time"]::-webkit-calendar-picker-indicator {
  cursor: pointer;
  filter: invert(0.5);
}

* {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

.content {
  background-color: #f9fafb;
  color: #1f2937;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  margin: 0;
  padding: 0;
}

.container {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 1rem;
}

.main-content {
  width: 100%;
  max-width: 32rem;
}

.card {
  background-color: #ffffff;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
    0 2px 4px -1px rgba(0, 0, 0, 0.06);
  padding: 1.5rem;
}

.header {
  margin-bottom: 2rem;
  text-align: center;
}

.title {
  font-size: 1.875rem;
  font-weight: 700;
  color: #111827;
  margin: 0;
}

.subtitle {
  color: #6b7280;
  margin-top: 0.5rem;
  margin-bottom: 0;
}

.form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
}

.label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.5rem;
}

.description {
  font-size: 0.75rem;
  color: #6b7280;
  margin-bottom: 0.5rem;
}

.input-container {
  position: relative;
}

.input-icon {
  position: absolute;
  left: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
  pointer-events: none;
}

.input-field {
  padding-left: 2.5rem;
  width: 85%;
  border-radius: 0.5rem;
  border: 1px solid #d1d5db;
  background-color: #f9fafb;
  color: #111827;
  height: 2.5rem;
  font-size: 0.875rem;
}

.input-field:focus {
  outline: none;
  ring: 2px solid #111827;
  border-color: #111827;
}

.button-container {
  padding-top: 1rem;
}

.button {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1rem;
  border: 1px solid transparent;
  border-radius: 0.5rem;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  font-size: 0.875rem;
  font-weight: 500;
  color: #ffffff;
  background-color: #111827;
  transition: opacity 0.2s;
}

.button:hover {
  opacity: 0.9;
}

.button:focus {
  outline: none;
  ring: 2px solid #111827;
  ring-offset: 2px;
}

@media (min-width: 640px) {
  .card {
    padding: 2rem;
  }

  .title {
    font-size: 1.875rem;
  }

  .form-grid {
    grid-template-columns: 1fr 1fr;
  }
}

.side-bar {
  background: #f8f9fa;
  width: 250px;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  overflow-y: auto;
  z-index: 999;
  border-right: 1px solid #ddd;
  flex-shrink: 0;
}

.side-bar .menu {
  width: 100%;
  margin-top: 80px;
}

.side-bar .menu .item {
  cursor: pointer;
  position: relative;
}

.side-bar .menu .item a {
  color: rgb(0, 0, 0);
  text-decoration: none;
  display: block;
  padding: 5px 30px;
  line-height: 60px;
  font-size: 16px;
  border-bottom: 1px solid #eee;
}

.side-bar .menu .item a:hover {
  background: rgba(0, 0, 0, 0.898);
  transition: 0.3s ease;
  color: white;
}

.side-bar .menu .item i {
  margin-right: 15px;
}

.side-bar .menu .item .sub-menu {
  background: #e9ecef;
  position: relative;
  z-index: 1000;
}

.side-bar .menu .item .sub-menu a {
  padding-left: 60px;
  border-bottom: 1px solid #ddd;
}

.side-bar .menu .item .sub-menu a:hover {
  background: rgba(0, 0, 0, 0.898);
  color: white;
}

.content {
  margin-left: 250px;
  flex: 1;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
</style>
