<template>
  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <div class="loading-screen" v-if="activeModal === 'showInfo'">
    <div class="modal-container">
      <div class="modal-content new-design">
        <button class="modal-close-icon" @click="activeModal = 'student'">
          &times;
        </button>
        <div class="modal-grid">
          <!-- Left Section: Profile and Actions -->
          <div class="left-section">
            <div class="profile-layout">
              <div class="profile-image-box">
                <span class="material-icons">image</span>
              </div>
              <div class="profile-info">
                <div class="info-group">
                  <label>Name</label>
                  <span class="value"
                    >{{ selectedStudent.firstname }}
                    {{ selectedStudent.lastname }}</span
                  >
                </div>
                <div class="info-group">
                  <label>Quarter</label>
                  <span class="value">Q{{ selectedStudent.quarter }}</span>
                </div>
                <div class="info-group">
                  <label>Year</label>
                  <span class="value">{{ selectedStudent.year }}</span>
                </div>
              </div>
            </div>

            <div class="info-group full-width">
              <label>Sentiment</label>
              <span
                :class="[
                  'value',
                  'sentiment-text',
                  sentimentClass(selectedStudent.sentiment),
                ]"
              >
                {{ selectedStudent.sentiment }}
              </span>
            </div>

            <div class="actions-grid-custom">
              <button class="action-btn-outline">Previous Evaluation</button>
              <button
                class="action-btn-outline"
                @click.prevent="
                  $router.push({
                    name: 'printable-form2',
                    params: {
                      tcrid: selectedStudent.teacher_id,
                      evtid: selectedStudent.eval_id,
                    },
                  })
                "
              >
                Average Evaluation
              </button>
              <button
                class="action-btn-outline"
                @click.prevent="
                  $router.push({
                    name: 'PerformanceGraph',
                    params: { id: selectedStudent.teacher_id },
                  })
                "
              >
                Show Performance Graph
              </button>
              <button
                class="action-btn-outline"
                @click.prevent="
                  $router.push({
                    name: 'printable-form',
                    params: {
                      id: selectedStudent.id,
                      tcrid: selectedStudent.teacher_id,
                      evtid: selectedStudent.eval_id,
                    },
                  })
                "
              >
                Individual Evaluation
              </button>
            </div>
          </div>

          <!-- Right Section: AI Summarizer -->
          <div class="right-section">
            <h3 class="ai-title">AI Summarizer</h3>
            <div class="ai-summary-content">
              <div v-if="isLoadingAi" class="ai-loading">
                <div class="pulse-bubble"></div>
                <p>Generating summary...</p>
              </div>
              <p v-else-if="airesponse">{{ airesponse }}</p>
              <p v-else class="placeholder-text">
                John has shown exceptional growth this quarter, particularly in
                his project management skills. He successfully led the "Phoenix"
                project, delivering it two weeks ahead of schedule. His
                communication with stakeholders has been consistently clear and
                effective. An area for improvement would be to delegate more
                tasks to junior team members to foster their growth.
              </p>
            </div>
            <div class="ai-chat-input">
              <input type="text" placeholder="Ask a follow-up..." />
              <button class="ai-send-btn">
                <span class="material-icons">send</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--for teacher-->
  <div class="loading-screen" v-if="activeModal === 'showInfot'">
    <div class="modal-container">
      <div class="modal-content new-design">
        <button class="modal-close-icon" @click="activeModal = 'student'">
          &times;
        </button>
        <div class="modal-grid">
          <!-- Left Section -->
          <div class="left-section">
            <div class="profile-layout">
              <div class="profile-image-box">
                <span class="material-icons">image</span>
              </div>
              <div class="profile-info">
                <div class="info-group">
                  <label>Name</label>
                  <span class="value"
                    >{{ newSelectedteachers.firstname }}
                    {{ newSelectedteachers.lastname }}</span
                  >
                </div>
                <div class="info-group">
                  <label>Quarter</label>
                  <span class="value">Q{{ newSelectedteachers.quarter }}</span>
                </div>
                <div class="info-group">
                  <label>Year</label>
                  <span class="value">{{ newSelectedteachers.year }}</span>
                </div>
              </div>
            </div>

            <div class="info-group full-width">
              <label>Sentiment</label>
              <span
                :class="[
                  'value',
                  'sentiment-text',
                  sentimentClass(newSelectedteachers.sentiment),
                ]"
              >
                {{ newSelectedteachers.sentiment }}
              </span>
            </div>

            <div class="actions-grid-custom">
              <button class="action-btn-outline">Previous Evaluation</button>
              <button
                class="action-btn-outline"
                @click.prevent="
                  $router.push({
                    name: 'printable-form3',
                    params: {
                      tcrid: newSelectedteachers.teacher_id,
                      evtid: newSelectedteachers.eval_id,
                    },
                  })
                "
              >
                Average Evaluation
              </button>
              <button
                class="action-btn-outline"
                @click.prevent="
                  $router.push({
                    name: 'PerformanceGraphT',
                    params: { id: newSelectedteachers.teacher_id },
                  })
                "
              >
                Show Performance Graph
              </button>
              <button
                class="action-btn-outline"
                @click.prevent="
                  $router.push({
                    name: 'printable-form1',
                    params: {
                      id: newSelectedteachers.id,
                      tcrid: newSelectedteachers.teacher_id,
                      evtid: newSelectedteachers.eval_id,
                    },
                  })
                "
              >
                Individual Evaluation
              </button>
            </div>
          </div>

          <!-- Right Section -->
          <div class="right-section">
            <h3 class="ai-title">AI Summarizer</h3>
            <div class="ai-summary-content">
              <div v-if="isLoadingAi" class="ai-loading">
                <div class="pulse-bubble"></div>
                <p>Analyzing evaluation data...</p>
              </div>
              <p v-else-if="airesponse">{{ airesponse }}</p>
              <p v-else class="placeholder-text">
                Summary data is being processed. This section will provide an
                automated analysis of the performance evaluation once complete.
              </p>
            </div>
            <div class="ai-chat-input">
              <input type="text" placeholder="Ask a follow-up..." />
              <button class="ai-send-btn">
                <span class="material-icons">send</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--sidebar (drawer)-->
  <Sidebar
    :isNavOpen="isNavOpen"
    @close="closeNav"
    @navigate="click"
    @navigate2="click2"
  />
  <!--end of sidebar-->

  <!--main content container-->
  <div class="main-content">
    <!-- Header -->
    <header class="topbar">
      <div class="topbar-left">
        <button
          class="menu-trigger"
          @click="isNavOpen = true"
          aria-label="Open menu"
        >
          <span class="material-icons">menu</span>
        </button>
        <div>
          <span class="logo">Teacher Evaluation System</span>
          <br />
          <span class="breadcrumb">Principal Portal</span>
        </div>
      </div>
      <div class="user-info">
        <span>Welcome, {{ fullname }} {{ lastname }}</span>
        <button class="logout-btn" @click="logout()">Logout</button>
      </div>

      <div class="error" v-if="isFailed">
        <span>Task failed to execute!</span>
      </div>

      <div class="success" v-if="isSuccess">
        <span>Task successfully executed!</span>
      </div>
    </header>

    <!-- Page Header -->
    <div class="page-header">
      <h2>Principal Dashboard</h2>
      <p>
        Manage teacher evaluations and view institutional performance metrics
      </p>
    </div>

    <!-- Stats -->
    <div class="stats-container">
      <div class="stat-card">
        👥
        <h3>{{ this.count }}</h3>
        <p>Teachers</p>
      </div>
      <div class="stat-card">
        🎓
        <h3>{{ this.count2 }}</h3>
        <p>Students</p>
      </div>
    </div>

    <div v-if="activeModal === 'student'">
      <div class="teacher-header">
        <h3>Student Evaluations</h3>
      </div>

      <div class="teacher-container">
        <div
          class="card"
          v-for="newStudent in newStudents"
          :key="newStudents.id"
        >
          <h3>{{ newStudent.firstname }} {{ newStudent.lastname }}</h3>
          <p>{{ newStudent.subject }}</p>
          <span class="badge"
            >Q{{ newStudent.quarter }} {{ newStudent.year }}</span
          >
          <br /><br />
          <button class="start" @click="openStudentModal(newStudent.id)">
            View Evaluation
          </button>
        </div>
      </div>
    </div>

    <div v-if="activeModal === 'evaluate'">
      <!-- Teacher Cards -->
      <div class="teacher-container">
        <div class="card" v-for="teacher in teachers" :key="teacher.id">
          <h3>{{ teacher.firstname }} {{ teacher.lastname }}</h3>
          <p>{{ teacher.subject }}</p>
          <span class="badge">Q{{ teacher.quarter }} {{ teacher.year }}</span>
          <br /><br />
          <button
            class="start"
            @click.prevent="
              $router.push({ name: 'teacher-eval', params: { id: teacher.id } })
            "
          >
            Start Evaluation
          </button>
        </div>
      </div>
    </div>

    <div v-if="activeModal === 'teacher'">
      <div class="teacher-header">
        <h3>Teacher Evaluations</h3>
      </div>

      <div class="teacher-container">
        <div
          class="card"
          v-for="newteacher in newTeachers"
          :key="newteacher.id"
        >
          <h3>{{ newteacher.firstname }} {{ newteacher.lastname }}</h3>
          <p>{{ newteacher.subject }}</p>
          <span class="badge"
            >Q{{ newteacher.quarter }} {{ newteacher.year }}</span
          >
          <br /><br />
          <button class="start" @click="openNewTeacherModal(newteacher.id)">
            View Evaluation
          </button>
        </div>
      </div>
    </div>

    <div v-if="activeModal === 'manage'">
      <div class="content">
        <div class="container" v-if="activeTab1 === 'crtTeacher'">
          <div class="header">
            <h3 class="headText">Create new teacher users</h3>
          </div>

          <form method="post" @submit.prevent="createTeachers()">
            <div v-if="isWrong" class="wrong">
              <p class="wrong">Wrong Credentials or Incomplete</p>
            </div>
            <div class="form-group">
              <label for="lsNm">Enter the First Name:</label>
              <input
                type="text"
                v-model="teacherr.fn"
                placeholder="Enter First Name"
                required
              />
            </div>

            <div class="form-group">
              <label for="lsNm">Enter the Last Name:</label>
              <input
                type="text"
                v-model="teacherr.ln"
                placeholder="Enter Last Name"
                required
              />
            </div>

            <div class="form-group">
              <label for="lsNm">Enter the Email:</label>
              <input
                type="email"
                v-model="teacherr.email"
                placeholder="Enter Email"
                required
              />
            </div>

            <div class="form-group">
              <label for="lsNm">Enter the ID:</label>
              <input
                type="number"
                v-model="teacherr.id"
                placeholder="Enter ID"
                required
              />
            </div>

            <div class="form-group">
              <label for="lsNm">Choose Subject:</label>

              <select v-model="teacherr.sub" class="" required>
                <option
                  v-for="subject in subjects"
                  :key="subject.id"
                  :value="subject.id"
                >
                  {{ subject.subjects }}
                </option>
              </select>
            </div>

            <div class="form-group">
              <label for="lsNm">Choose Quarter:</label>
              <select v-model="teacherr.qrt" class="" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </div>

            <div class="form-group">
              <label for="lsNm">Enter Year:</label>
              <input
                type="number"
                v-model="teacherr.yr"
                placeholder="Enter Year"
                required
              />
            </div>

            <div class="form-group">
              <label for="lsNm">Enter the Password:</label>
              <input
                type="password"
                v-model="teacherr.ps"
                placeholder="Enter Password"
                minlength="8"
                required
              />
            </div>

            <div class="form-group">
              <label for="lsNm">Enter the Confirm Password:</label>
              <input
                type="password"
                v-model="teacherr.cpas"
                placeholder="Confirm Password"
                required
              />
            </div>
            <div class="">
              <button type="submit" class="btn">Create Teacher</button>
            </div>
          </form>
        </div>

        <div class="teacher-container" v-if="activeTab1 === 'rmTeacher'">
          <div class="card" v-for="teacher in teachers" :key="teacher.id">
            <h3>{{ teacher.firstname }} {{ teacher.lastname }}</h3>
            <p>{{ teacher.subject }}</p>
            <span class="badge">Q{{ teacher.quarter }} {{ teacher.year }}</span>
            <br /><br />
            <button class="start" @click.prevent="rmTeachers(teacher.id)">
              Remove Teacher
            </button>
          </div>
        </div>

        <div class="teacher-container" v-if="activeTab1 === 'editTeacher'">
          <div
            class="card"
            v-for="teacher in teachers"
            :key="teacher.id"
            v-if="!isEditing"
          >
            <h3>{{ teacher.firstname }} {{ teacher.lastname }}</h3>
            <p>{{ teacher.subject }}</p>
            <span class="badge">Q{{ teacher.quarter }} {{ teacher.year }}</span>
            <br /><br />
            <button class="start" @click.prevent="openTeacherModal(teacher.id)">
              Edit Teacher
            </button>
          </div>

          <div class="loading-screen" v-if="isEditing">
            <div class="card">
              <form method="post" @submit.prevent="editTeachers()">
                <div v-if="isWrong" class="wrong">
                  <p class="wrong">Wrong Credentials or Incomplete</p>
                </div>
                <div class="form-group">
                  <label for="lsNm">Enter the First Name:</label>
                  <input
                    type="text"
                    v-model="selectedTeachers.fn"
                    placeholder="Enter First Name"
                    required
                  />
                </div>

                <div class="form-group">
                  <label for="lsNm">Enter the Last Name:</label>
                  <input
                    type="text"
                    v-model="selectedTeachers.ln"
                    placeholder="Enter Last Name"
                    required
                  />
                </div>

                <div class="form-group">
                  <label for="lsNm">Enter the Email:</label>
                  <input
                    type="email"
                    v-model="selectedTeachers.email"
                    placeholder="Enter Email"
                    required
                  />
                </div>

                <div class="form-group">
                  <label for="lsNm">Enter the ID:</label>
                  <input
                    type="number"
                    v-model="selectedTeachers.id"
                    placeholder="Enter ID"
                    required
                  />
                </div>

                <div class="form-group">
                  <label for="lsNm">Choose Subject:</label>

                  <select v-model="selectedTeachers.sub" class="" required>
                    <option
                      v-for="subject in subjects"
                      :key="subject.id"
                      :value="subject.id"
                    >
                      {{ subject.subjects }}
                    </option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="lsNm">Choose Quarter:</label>
                  <select v-model="selectedTeachers.qrt" class="" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="lsNm">Enter Year:</label>
                  <input
                    type="number"
                    v-model="selectedTeachers.yr"
                    placeholder="Enter Year"
                    required
                  />
                </div>
                <div class="">
                  <button type="submit" class="btn">Edit Teacher</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"
    />
  </div>
</template>

<script>
import { removeToken, getToken } from "../../utils/auth";
import { useTeachers } from "../../composable/getTeacher";
import Sidebar from "../../component/sidebar.vue";

const url1 = "https://rusiann7.helioho.st";
//const url2 = "https://star-panda-literally.ngrok-free.app";
const url2 = "http://localhost:8000";

export default {
  name: "Principal",
  data() {
    return {
      urlappphp: `${url2}/Getter.php`,
      urlappphp2: `${url2}/viewEvaluations.php`,
      urlappphp3: `${url2}/viewEvaluationt.php`,
      urlappphp4: `${url2}/rmTeacher.php`,
      urlappphp5: `${url2}/createTeacher.php`,
      subjecturl: `${url2}/subjectGetter.php`,
      editteacherphp: `${url2}/editTeacher.php`,
      airesponsephp: `${url2}/ai.php`,
      teacherr: {
        fn: "",
        ln: "",
        email: "",
        ps: "",
        cpas: "",
        sub: "",
        qrt: "",
        yr: "",
        id: "",
      },
      newTeachers: [],
      newStudents: [],
      count2: 0,
      isLoading: false,
      isWrong: false,
      isSuccess: false,
      isFailed: false,
      isEditing: false,
      fullname:
        JSON.parse(localStorage.getItem("userData") || "{}").fullname ||
        "Student Name",
      lastname:
        JSON.parse(localStorage.getItem("userData") || "{}").lastname ||
        "Student Name",
      usrid: JSON.parse(localStorage.getItem("userData") || "{}").id || null,
      activeModal: "student",
      activeTab: "student",
      activeTab1: "crtTeacher",
      selectedSubject: null,
      selectedQuarter: null,
      selectedStudent: null,
      selectedTeachers: null,
      newSelectedteachers: null,
      showMenu1: false,
      subjects: { id: "", subject: "" },
      airesponse: null,
      isLoadingAi: false,
      isNavOpen: false,
    };
  },

  setup() {
    const { teachers, count, isLoading, error, getTeachers } = useTeachers();
    return { teachers, count, isLoading, error, getTeachers };
  },

  components: { Sidebar },

  methods: {
    async getStudentbyid() {
      try {
        this.isLoading = true;

        const response = await fetch(this.urlappphp4, {
          method: "POST",
          headers: {
            "Content-type": "application/json",
          },
          body: JSON.stringify({
            action: "getstudentbyid",
            evt: this.$route.params.evtid,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.name = result.student;
          this.isLoading = false;
        } else {
          console.log("Server error:", result.message);
        }
      } catch (error) {
        console.log(error);
        this.isLoading = false;
      }
    },

    async getSteval() {
      try {
        this.isLoading = true;

        const response = await fetch(this.urlappphp2, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "getEvaluations",
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.newStudents = result.evaluations.map((evaluation) => ({
            id: evaluation.id,
            teacher_id: evaluation.teacher_id,
            eval_id: evaluation.eval_id,
            firstname: evaluation.teacher.firstname,
            lastname: evaluation.teacher.lastname,
            subject: evaluation.teacher.subject,
            quarter: evaluation.teacher.quarter,
            year: evaluation.teacher.year,
            sentiment: evaluation.teacher.sentiment,
          }));

          this.count2 = result.total;
          this.isLoading = false;
        }
      } catch (error) {
        console.log(error);
        this.isLoading = false;
      }
    },

    async getTceval() {
      try {
        this.isLoading = true;

        const response = await fetch(this.urlappphp3, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "getEvaluationt",
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.newTeachers = result.evaluations.map((evaluation) => ({
            id: evaluation.id,
            teacher_id: evaluation.teacher_id,
            eval_id: evaluation.eval_id,
            firstname: evaluation.teacher.firstname,
            lastname: evaluation.teacher.lastname,
            subject: evaluation.teacher.subject,
            quarter: evaluation.teacher.quarter,
            year: evaluation.teacher.year,
            sentiment: evaluation.teacher.sentiment,
          }));

          this.count2 = result.total;
          this.isLoading = false;
        }
      } catch (error) {
        console.log(error);
        this.isLoading = false;
      }
    },

    async rmTeachers(id) {
      try {
        alert("Are you sure you want to remove this teacher?");
        this.isLoading = true;

        const response = await fetch(this.urlappphp4, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ action: "rmTeachers", id: id }),
        });

        const result = await response.json();

        if (result.success) {
          this.getTeachers();
          this.isSuccess = true;
          this.isLoading = false;
        } else {
          this.isLoading = false;
          console.error(result.message);
        }
      } catch (error) {
        console.error(error);
      }
    },

    async createTeachers() {
      if (this.teacherr.ps === this.teacherr.cpas) {
        try {
          this.isLoading = true;

          const response = await fetch(this.urlappphp5, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              ...this.teacherr,
              action: "createTeachers",
            }),
          });

          console.log(this.teacherr);

          const result = await response.json();

          if (result.success) {
            this.getTeachers();
            this.isLoading = false;
            this.isSuccess = true;
            this.teacherr = {
              fn: "",
              ln: "",
              email: "",
              id: "",
              yr: "",
              ps: "",
              cpas: "",
            };
          } else {
            this.isLoading = false;
            this.isFailed = true;
            console.error(error);
          }
        } catch (error) {
          console.error(error);
        }
      } else {
        this.isWrong = true;
      }
    },

    async getSubjects() {
      try {
        const response = await fetch(this.subjecturl, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "getSubjects",
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.subjects = result.subjects;
        } else {
        }
      } catch (error) {
        console.error("error");
      }
    },

    async editTeachers() {
      console.log(this.selectedTeachers);
      try {
        this.isLoading = true;
        this.isEditing = true;

        const response = await fetch(this.editteacherphp, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "editTeacher",
            user: this.selectedTeachers,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.isLoading = false;
          this.isSuccess = true;
        } else {
          this.isLoading = false;
          this.isFailed = true;
          this.isWrong = true;
        }
      } catch (error) {
        this.isLoading = false;
        console.log(error);
      }
    },

    async fetchAiResponse(id) {
      try {
        this.airesponse = null; // Reset previous response
        this.isLoadingAi = true;

        const response = await fetch(this.airesponsephp, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: "ai",
            id: id,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.airesponse = result.response;
          this.isLoadingAi = false;
        } else {
          this.isLoadingAi = false;
        }
      } catch (error) {
        this.isLoadingAi = false;
        console.error(error);
      }
    },

    sentimentClass(sentiment) {
      if (!sentiment) return "sentiment-neutral";
      const s = sentiment.toString().toLowerCase();
      if (s.includes("pos")) return "sentiment-positive";
      if (s.includes("neg")) return "sentiment-negative";
      return "sentiment-neutral";
    },

    skipLogin() {
      const token = getToken();

      if (!token) {
        console.error("No token found, redirecting to login.");
        this.$router.replace("/");
        return;
      }
    },

    openStudentModal(studentId) {
      this.selectedStudent = this.newStudents.find(
        (student) => student.id === studentId,
      );
      this.activeModal = "showInfo";
    },

    openNewTeacherModal(newTeacherId) {
      this.newSelectedteachers = this.newTeachers.find(
        (teacher) => teacher.id === newTeacherId,
      );
      this.activeModal = "showInfot";
    },

    openTeacherModal(teacherId) {
      const t = this.teachers.find((teacher) => teacher.id === teacherId);

      this.selectedTeachers = {
        fn: t.firstname,
        ln: t.lastname,
        email: t.email,
        id: t.id,
        sub: t.subject,
        qrt: t.quarter,
        yr: t.year,
      };

      this.isEditing = true;
    },

    closeNav() {
      this.isNavOpen = false;
    },
    click(tabName) {
      this.activeTab = tabName;
      this.activeModal = tabName;
    },
    click2(tabName) {
      this.activeTab1 = tabName;
      this.activeModal = "manage";
    },
  },

  watch: {
    activeModal(newVal) {
      switch (newVal) {
        case "student":
          this.getSteval();
          break;
        case "teacher":
          this.getTceval();
          break;
        case "evaluate":
          this.getTeachers();
          break;
        case "manage":
          this.getSubjects();
          break;
        case "showInfo":
          if (this.selectedStudent)
            this.fetchAiResponse(this.selectedStudent.id);
          break;
        case "showInfot":
          if (this.newSelectedteachers)
            this.fetchAiResponse(this.newSelectedteachers.id);
          break;
      }
    },
  },

  async mounted() {
    this.id = localStorage.getItem("userData") || "";
    this.skipLogin();
    this.getSteval();
    console.log("usrid is:", this.usrid);
    await this.getTeachers(this.usrid);
  },
};
</script>

<style scoped>
/* ===== BASE STYLES ===== */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Inter", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

html {
  font-size: 16px;
}

@media (min-width: 768px) {
  html {
    font-size: 18px;
  }
}

@media (min-width: 1200px) {
  html {
    font-size: 20px;
  }
}

body {
  background: #ffffff;
  color: #1a1a1a;
  line-height: 1.6;
  min-height: 100vh;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.material-icons {
  font-size: 1.5rem;
  vertical-align: middle;
}

/* ===== TOPBAR STYLES ===== */
.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.5rem 2.5rem;
  border-bottom: 2px solid #e5e7eb;
  flex-wrap: wrap;
  gap: 1.5rem;
  position: sticky;
  top: 0;
  background: white;
  z-index: 99;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.topbar-left {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.menu-trigger {
  border: 1px solid #e5e7eb;
  background: #fff;
  width: 42px;
  height: 42px;
  border-radius: 10px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition:
    background 0.2s,
    box-shadow 0.2s,
    transform 0.1s;
}

.menu-trigger:hover {
  background: #f3f4f6;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
}

.menu-trigger:active {
  transform: translateY(1px);
}

.logo {
  font-weight: 700;
  font-size: 1.5rem;
  color: #000000;
}

.breadcrumb {
  background: #f3f4f6;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  font-size: 1rem;
  font-weight: 500;
  color: #374151;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  font-size: 1.1rem;
  flex-wrap: wrap;
}

.user-info span {
  font-weight: 500;
}

.logout-btn {
  background: #000000;
  border: 2px solid #000000;
  padding: 0.75rem 1.5rem;
  border-radius: 0.5rem;
  cursor: pointer;
  text-decoration: none;
  color: #ffffff;
  font-weight: 600;
  font-size: 1rem;
  transition: all 0.2s ease;
  white-space: nowrap;
}

.topbar .logout-btn {
  display: none;
}

.logout-btn:hover {
  background: #333333;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* ===== PAGE HEADER ===== */
.page-header {
  padding: 2.5rem 2.5rem 1rem;
}

.page-header h2 {
  margin: 0;
  font-size: 2rem;
  font-weight: 700;
  color: #000000;
}

@media (min-width: 768px) {
  .page-header h2 {
    font-size: 2.5rem;
  }
}

.page-header p {
  color: #6b7280;
  font-size: 1.1rem;
  margin-top: 0.5rem;
}

/* ===== STATS CARDS ===== */
.stats-container {
  display: flex;
  gap: 2rem;
  padding: 1.5rem 2.5rem;
  flex-wrap: wrap;
}

.stat-card {
  flex: 1;
  min-width: 250px;
  background: #ffffff;
  border-radius: 1.25rem;
  padding: 2.5rem;
  text-align: left;
  box-shadow:
    0 10px 15px -3px rgba(0, 0, 0, 0.05),
    0 4px 6px -2px rgba(0, 0, 0, 0.05);
  border: 1px solid #f3f4f6;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
}

.stat-card::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: linear-gradient(90deg, #000 0%, #333 100%);
  opacity: 0;
  transition: opacity 0.3s;
}

.stat-card:hover {
  transform: translateY(-8px);
  box-shadow:
    0 20px 25px -5px rgba(0, 0, 0, 0.1),
    0 10px 10px -5px rgba(0, 0, 0, 0.04);
  border-color: #e5e7eb;
}

.stat-card:hover::before {
  opacity: 1;
}

.stat-card h3 {
  margin: 0.5rem 0 0;
  font-size: 3rem;
  font-weight: 800;
  color: #111827;
  letter-spacing: -0.025em;
}

.stat-card p {
  color: #6b7280;
  font-size: 1rem;
  margin-top: 0.25rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

/* ===== TEACHER HEADER ===== */
.teacher-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2.5rem;
  margin-bottom: 1.5rem;
  flex-wrap: wrap;
  gap: 1.5rem;
}

.teacher-header h3 {
  font-size: 1.75rem;
  font-weight: 700;
  color: #000000;
  margin: 0;
}

@media (min-width: 768px) {
  .teacher-header h3 {
    font-size: 2rem;
  }
}

/* ===== MAIN CONTENT ===== */
.main-content {
  margin-left: 0;
  flex: 1;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  max-width: 100%;
  overflow-x: hidden;
  transition: margin-left 0.3s ease;
}

@media (min-width: 1024px) {
  .main-content {
    margin-left: 280px;
  }
}

/* ===== TEACHER CONTAINER ===== */
.teacher-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
  padding: 0 2.5rem 3rem;
}

@media (min-width: 1400px) {
  .teacher-container {
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  }
}

/* ===== CARD STYLES ===== */
.card {
  border: 2px solid #e5e7eb;
  border-radius: 1rem;
  padding: 2rem;
  background: #ffffff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
}

.card:hover {
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  border-color: #000000;
  transform: translateY(-4px);
}

.card h3 {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
  font-weight: 600;
  color: #000000;
}

.card p {
  font-size: 1.1rem;
  color: #6b7280;
  margin-bottom: 1rem;
  line-height: 1.5;
}

/* ===== BADGES ===== */
.badge {
  display: inline-block;
  background: #f3f4f6;
  padding: 0.5rem 1rem;
  font-size: 0.9rem;
  font-weight: 600;
  border-radius: 2rem;
  color: #374151;
  border: 1px solid #d1d5db;
}

/* ===== BUTTONS IN CARDS ===== */
.card button {
  width: 100%;
  padding: 1rem;
  border: 2px solid;
  border-radius: 0.75rem;
  cursor: pointer;
  font-weight: 600;
  font-size: 1.1rem;
  transition: all 0.2s ease;
  margin-top: 1rem;
  font-family: inherit;
}

.card .start {
  background: #000000;
  color: #ffffff;
  border-color: #000000;
}

.card .start:hover {
  background: #333333;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* ===== FORM STYLES ===== */
.content {
  padding: 2rem 2.5rem;
  min-height: 100vh;
}

.container {
  max-width: 800px;
  margin: 0 auto;
}

.header {
  margin-bottom: 2.5rem;
}

.headText {
  font-size: 1.75rem;
  font-weight: 700;
  color: #000000;
  margin-bottom: 0.5rem;
}

.wrong {
  color: #dc2626;
  background: #fee2e2;
  padding: 1rem 1.5rem;
  border-radius: 0.5rem;
  margin-bottom: 2rem;
  font-weight: 600;
  text-align: center;
  border: 2px solid #fca5a5;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  color: #374151;
  font-weight: 600;
  font-size: 1rem;
}

.form-group input,
.form-group select {
  width: 100%;
  padding: 1rem 1.25rem;
  border: 2px solid #d1d5db;
  border-radius: 0.5rem;
  font-size: 1.1rem;
  background: #ffffff;
  transition: all 0.2s ease;
  font-family: inherit;
}

.form-group input:focus,
.form-group select:focus {
  outline: none;
  border-color: #000000;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

.btn {
  display: inline-block;
  padding: 1rem 2rem;
  border-radius: 0.5rem;
  font-size: 1.1rem;
  font-weight: 600;
  text-decoration: none;
  cursor: pointer;
  border: 2px solid #000000;
  background: #000000;
  color: #ffffff;
  transition: all 0.2s ease;
  margin-top: 1rem;
  font-family: inherit;
}

.btn:hover {
  background: #333333;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* ===== SIDEBAR (DRAWER) ===== */

/* ===== MODAL STYLES ===== */
.modal-container {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1.5rem;
  overflow-y: auto;
}

/* ===== NEW MODAL DESIGN ===== */
.modal-content.new-design {
  max-width: 1100px;
  width: 95%;
  padding: 3rem;
  position: relative;
  background: #ffffff;
}

.modal-close-icon {
  position: absolute;
  top: 1.5rem;
  right: 1.5rem;
  background: none;
  border: none;
  font-size: 2rem;
  color: #9ca3af;
  cursor: pointer;
  transition: color 0.2s;
}

.modal-close-icon:hover {
  color: #374151;
}

.modal-grid {
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: 3rem;
}

@media (max-width: 992px) {
  .modal-grid {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
}

/* Left Section */
.left-section {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.profile-layout {
  display: flex;
  gap: 2rem;
  align-items: flex-start;
}

.profile-image-box {
  width: 140px;
  height: 140px;
  background: #e5e7eb;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.profile-image-box .material-icons {
  font-size: 3rem;
  color: #9ca3af;
}

.profile-info {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.info-group {
  display: flex;
  flex-direction: column;
}

.info-group label {
  font-size: 0.875rem;
  color: #6b7280;
  font-weight: 500;
  margin-bottom: 0.25rem;
}

.info-group .value {
  font-size: 1.25rem;
  font-weight: 700;
  color: #1f2937;
}

.metadata-section {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.sentiment-text {
  font-weight: 700;
  text-transform: capitalize;
}

.sentiment-positive {
  color: #059669 !important;
}

.sentiment-negative {
  color: #dc2626 !important;
}

.sentiment-neutral {
  color: #6b7280 !important;
}

/* AI Loading Animation */
.ai-loading {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;
  gap: 1rem;
  color: #6b7280;
}

.pulse-bubble {
  width: 12px;
  height: 12px;
  background-color: #0f172a;
  border-radius: 50%;
  animation: pulse 1.5s infinite ease-in-out;
}

@keyframes pulse {
  0% {
    transform: scale(0.8);
    opacity: 0.5;
  }
  50% {
    transform: scale(1.2);
    opacity: 1;
  }
  100% {
    transform: scale(0.8);
    opacity: 0.5;
  }
}

.actions-grid-custom {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
  margin-top: 1rem;
}

.action-btn-outline {
  background: #ffffff;
  border: 1px solid #e5e7eb;
  padding: 0.75rem 1rem;
  border-radius: 8px;
  font-weight: 600;
  color: #374151;
  cursor: pointer;
  transition: all 0.2s;
  font-size: 0.95rem;
  text-align: center;
}

.action-btn-outline:hover {
  background: #f9fafb;
  border-color: #d1d5db;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

/* Right Section - AI Summarizer */
.right-section {
  display: flex;
  flex-direction: column;
  border: 1px solid #f3f4f6;
  border-radius: 12px;
  padding: 1.5rem;
  background: #fcfcfc;
}

.ai-title {
  text-align: center;
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  color: #111827;
}

.ai-summary-content {
  flex: 1;
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  padding: 1.5rem;
  min-height: 250px;
  max-height: 400px;
  overflow-y: auto;
  font-size: 1rem;
  line-height: 1.6;
  color: #4b5563;
}

.placeholder-text {
  color: #9ca3af;
  font-style: italic;
}

.ai-chat-input {
  display: flex;
  align-items: center;
  margin-top: 1.5rem;
  background: #f3f4f6;
  border-radius: 12px;
  padding: 0.5rem 0.75rem;
}

.ai-chat-input input {
  flex: 1;
  background: none;
  border: none;
  padding: 0.75rem;
  font-size: 1rem;
  outline: none !important;
  color: #1f2937;
}

.ai-send-btn {
  background: #0f172a;
  color: white;
  border: none;
  width: 44px;
  height: 44px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background 0.2s;
}

.ai-send-btn:hover {
  background: #1e293b;
}

@media (max-width: 640px) {
  .modal-content.new-design {
    padding: 1.5rem;
    width: 98%;
  }

  .profile-layout {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .actions-grid-custom {
    grid-template-columns: 1fr;
  }
}

/* ===== LOADING & FEEDBACK STATES ===== */
.loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.85);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  z-index: 3000;
  color: white;
}

.loading-spinner {
  border: 6px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top: 6px solid #ffffff;
  width: 60px;
  height: 60px;
  animation: spin 1s linear infinite;
  margin-bottom: 1.5rem;
  z-index: 3000;
}

.loading-screen p {
  font-size: 1.5rem;
  font-weight: 500;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.success,
.error {
  position: fixed;
  top: 1.5rem;
  left: 50%;
  transform: translateX(-50%);
  padding: 1.5rem 2rem;
  border-radius: 0.75rem;
  font-weight: 600;
  z-index: 1000;
  text-align: center;
  min-width: 300px;
  max-width: 90%;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  animation:
    slideIn 0.3s ease-out,
    timeout 6s linear forwards;
  font-size: 1.1rem;
}

.success {
  background-color: #10b981;
  color: #ffffff;
  border: 2px solid #059669;
}

.error {
  background-color: #ef4444;
  color: #ffffff;
  border: 2px solid #dc2626;
}

.success span,
.error span {
  display: block;
}

.success::after,
.error::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  height: 4px;
  background: rgba(255, 255, 255, 0.5);
  animation: progress 5s linear forwards;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateX(-50%) translateY(-30px);
  }
  to {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
  }
}

@keyframes timeout {
  0% {
    opacity: 1;
    visibility: visible;
  }
  70% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    visibility: hidden;
  }
}

@keyframes progress {
  0% {
    width: 100%;
  }
  100% {
    width: 0%;
  }
}

/* ===== MOBILE RESPONSIVE ===== */
@media (max-width: 640px) {
  .topbar {
    padding: 1rem;
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }

  .logo {
    font-size: 1.25rem;
  }

  .breadcrumb {
    font-size: 0.9rem;
    padding: 0.375rem 0.75rem;
  }

  .user-info {
    width: 100%;
    justify-content: space-between;
    font-size: 1rem;
  }

  .topbar .logout-btn {
    display: none;
  }

  .page-header,
  .teacher-header,
  .stats-container,
  .teacher-container,
  .content {
    padding-left: 1rem;
    padding-right: 1rem;
  }

  .page-header h2 {
    font-size: 1.75rem;
  }

  .teacher-header h3 {
    font-size: 1.5rem;
  }

  .card h3 {
    font-size: 1.25rem;
  }

  .card p {
    font-size: 1rem;
  }

  .teacher-container {
    grid-template-columns: 1fr;
  }

  .modal-content {
    padding: 1.5rem;
    margin: 0.5rem;
  }

  .profile-image {
    width: 10rem;
    height: 10rem;
  }

  .detail-value,
  .info-value {
    font-size: 1.1rem;
  }
}

/* ===== TABLET RESPONSIVE ===== */
@media (min-width: 641px) and (max-width: 1023px) {
  .topbar {
    padding: 1.25rem 1.5rem;
  }

  .topbar .logout-btn {
    display: none;
  }

  .teacher-container {
    grid-template-columns: repeat(2, 1fr);
  }
}

/* ===== FOCUS STATES FOR ACCESSIBILITY ===== */
button:focus,
input:focus,
select:focus {
  outline: 3px solid #000000;
  outline-offset: 2px;
}

/* ===== SCROLLBAR STYLING ===== */
::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>
