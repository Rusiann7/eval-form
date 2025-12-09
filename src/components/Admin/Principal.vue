<template>
  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <div class="loading-screen" v-if="activeModal === 'showInfo'">
    <div class="modal-container">
      <div class="modal-content">
        <div class="left-column">
          <div class="profile-section">
            <div class="profile-image-container"></div>
            <div class="profile-details">
              <div class="detail-item">
                <label class="detail-label">Name</label>
                <p class="detail-value">
                  {{ selectedStudent.firstname }}
                  {{ selectedStudent.lastname }}
                </p>
              </div>
              <div class="detail-item">
                <label class="detail-label">Quarter</label>
                <p class="detail-value">Q{{ selectedStudent.quarter }}</p>
              </div>
              <div class="detail-item">
                <label class="detail-label">Year</label>
                <p class="detail-value">{{ selectedStudent.year }}</p>
              </div>
            </div>
          </div>
          <div class="info-section">
            <div class="info-item">
              <label class="info-label">Subject</label>
              <p class="info-value">{{ selectedStudent.subject }}</p>
            </div>
            <div class="info-item">
              <label class="info-label">Sentiment</label>
              <p class="info-value">{{ selectedStudent.sentiment }}</p>
            </div>
          </div>
          <div class="buttons-grid">
            <button
              class="action-button"
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
              class="action-button"
              @click.prevent="
                $router.push({
                  name: 'PerformanceGraph',
                  params: {
                    id: selectedStudent.teacher_id,
                  },
                })
              "
            >
              Show Performance Graph
            </button>
            <button
              class="action-button"
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
            <button class="action-button" @click="activeModal = 'student'">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--for teacher-->
  <div class="loading-screen" v-if="activeModal === 'showInfot'">
    <div class="modal-container">
      <div class="modal-content">
        <div class="left-column">
          <div class="profile-section">
            <div class="profile-details">
              <div class="detail-item">
                <label class="detail-label">Name</label>
                <p class="detail-value">
                  {{ newSelectedteachers.firstname }}
                  {{ newSelectedteachers.lastname }}
                </p>
              </div>
              <div class="detail-item">
                <label class="detail-label">Quarter</label>
                <p class="detail-value">Q{{ newSelectedteachers.quarter }}</p>
              </div>
              <div class="detail-item">
                <label class="detail-label">Year</label>
                <p class="detail-value">{{ newSelectedteachers.year }}</p>
              </div>
            </div>
          </div>
          <div class="info-section">
            <div class="info-item">
              <label class="info-label">Subject</label>
              <p class="info-value">{{ newSelectedteachers.subject }}</p>
            </div>
            <div class="info-item">
              <label class="info-label">Sentiment</label>
              <p class="info-value">{{ newSelectedteachers.sentiment }}</p>
            </div>
          </div>
          <div class="buttons-grid">
            <button
              class="action-button"
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
              class="action-button"
              @click.prevent="
                $router.push({
                  name: 'PerformanceGraphT',
                  params: {
                    id: newSelectedteachers.teacher_id,
                  },
                })
              "
            >
              Show Performance Graph
            </button>
            <button
              class="action-button"
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
            <button class="action-button" @click="activeModal = 'student'">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--sidebar (drawer)-->
  <div v-if="isNavOpen" class="nav-overlay" @click="closeNav"></div>
  <div class="side-bar" :class="{ open: isNavOpen }">
    <div class="nav-header">
      <div>
        <p class="nav-title">Principal Portal</p>
      </div>
      <button class="nav-close" @click="closeNav" aria-label="Close menu">
        <span class="material-icons">close</span>
      </button>
    </div>
    <div class="menu">
      <div class="item">
        <a
          href="#"
          class="sub-btn"
          @click.stop="
            $router.push('/principal');
            click('student');
            closeNav();
          "
          >Student</a
        >
      </div>
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu2 = !showMenu2">
          Teacher
          <span class="material-icons chevron">{{
            showMenu2 ? "expand_less" : "expand_more"
          }}</span>
        </a>
        <div class="sub-menu" v-if="showMenu2">
          <a href="#" @click="click('teacher'); closeNav()" class="sub-item"
            >Evaluation Answers</a
          >
          <a href="#" @click="click('evaluate'); closeNav()" class="sub-item"
            >Evaluate Teachers</a
          >
        </div>
      </div>
      <div class="item">
        <a href="#" @click.stop="showMenu3 = !showMenu3">
          Account Management
          <span class="material-icons chevron">{{
            showMenu3 ? "expand_less" : "expand_more"
          }}</span>
        </a>
        <div class="sub-menu" v-if="showMenu3">
          <a href="#" @click="click2('crtTeacher'); closeNav()" class="sub-item"
            >Add Teachers</a
          >
          <a href="#" @click="click2('rmTeacher'); closeNav()" class="sub-item"
            >Delete Users</a
          >
          <a href="#" @click="click2('editTeacher'); closeNav()" class="sub-item"
            >Edit Users</a
          >
        </div>
      </div>
      <div class="item">
        <a href="#" @click.prevent="$router.push('/scheduler'); closeNav()"
          >Scheduler</a
        >
      </div>
      <div class="item">
        <a href="#" @click.prevent="$router.push('/fileupload'); closeNav()"
          >File Upload</a
        >
      </div>

      <div class="item">
        <a href="#" @click.prevent="showMenu4 = !showMenu4">
          Question Change
          <span class="material-icons chevron">{{
            showMenu4 ? "expand_less" : "expand_more"
          }}</span>
        </a>

        <div class="sub-menu" v-if="showMenu4">
          <a
            href="#"
            @click.prevent="
              $router.push('/changequestions-student');
              closeNav();
            "
            class="sub-item"
            >Change Student Questions</a
          >
          <a
            href="#"
            @click.prevent="
              $router.push('/changequestions-teacher');
              closeNav();
            "
            class="sub-item"
            >Change Teacher Questions</a
          >
        </div>
      </div>
    </div>
    <div class="menu-footer">
      <button class="logout-btn menu-logout" @click="logout()">
        <span class="material-icons logout-icon">logout</span>
        Logout
      </button>
    </div>
  </div>
  <!--end of sidebar-->

  <!--main content container-->
  <div class="main-content">
    <!-- Header -->
    <header class="topbar">
      <div class="topbar-left">
        <button class="menu-trigger" @click="isNavOpen = true" aria-label="Open menu">
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

const url1 = "https://rusiann7.helioho.st";
const url2 = "https://star-panda-literally.ngrok-free.app";
//const url2 = "http://localhost:8000";
//const url2 = "https://rusiann7.helioho.st";

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
      teachers: [],
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
      count: 0,
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
      showMenu2: false,
      showMenu3: false,
      showMenu4: false,
      subjects: { id: "", subject: "" },
      airesponse: null,
      isNavOpen: false,
    };
  },

  methods: {
    async getTeachers() {
      try {
        this.isLoading = true;

        const response = await fetch(this.urlappphp, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ action: "getTeachers", id: this.usrid }),
        });

        const result = await response.json();

        if (result.success) {
          this.teachers = result.teachers.map((teacher) => ({
            id: teacher.id,
            firstname: teacher.firstname,
            lastname: teacher.lastname,
            subject: teacher.subject,
            quarter: teacher.quarter,
            year: teacher.year,
            sentiment: teacher.sentiment,
            email: teacher.email,
          }));

          this.count = result.total;
          this.isLoading = false;
        } else {
          console.error("Error fetching teachers:", result.message);
          this.isLoading = false;
        }
      } catch (error) {
        console.error("Error fetching teachers:", error);
      }
    },

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

    async airesponse(id) {
      try {
        this.isLoading = true;

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
          this.isLoading = false;
          this.isSuccess = true;
        } else {
          this.isLoading = false;
          this.isFailed = true;
        }
      } catch (error) {
        this.isLoading = false;
        console.error(error);
      }
    },

    logout() {
      try {
        removeToken();
        this.localUserData = {};
        this.$router.replace("/");
      } catch (error) {
        console.error("Logout error:", error);
      }
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
        (student) => student.id === studentId
      );
      this.activeModal = "showInfo";
    },

    openNewTeacherModal(newTeacherId) {
      this.newSelectedteachers = this.newTeachers.find(
        (teacher) => teacher.id === newTeacherId
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

    openTeacherInfo(teacher_id) {},

    toggleModal(modal) {
      this.activeModal = modal;
    },

    click(tabName) {
      this.activeTab = tabName;
      this.toggleModal(tabName);
    },

    click2(tabName) {
      this.activeTab1 = tabName;
      this.activeModal = "manage";
    },

    closeNav() {
      this.isNavOpen = false;
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
      }
    },
  },

  mounted() {
    this.id = localStorage.getItem("userData") || "";
    this.skipLogin();
    this.getSteval();
    this.getTeachers();
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
  display: flex;
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
  transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
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
  min-width: 200px;
  background: #ffffff;
  border-radius: 1rem;
  padding: 2rem;
  text-align: center;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
    0 2px 4px -1px rgba(0, 0, 0, 0.06);
  border: 2px solid #f3f4f6;
  transition: all 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.stat-card h3 {
  margin: 1rem 0 0;
  font-size: 2.5rem;
  font-weight: 700;
  color: #000000;
}

.stat-card p {
  color: #6b7280;
  font-size: 1.1rem;
  margin-top: 0.25rem;
  font-weight: 500;
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
.nav-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.55);
  backdrop-filter: blur(2px);
  z-index: 180;
}

.side-bar {
  background: #ffffff;
  width: 320px;
  max-width: 90vw;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  border-right: 1px solid #e5e7eb;
  z-index: 200;
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
  transform: translateX(-100%);
  transition: transform 0.25s ease;
  display: flex;
  flex-direction: column;
}

.side-bar.open {
  transform: translateX(0);
}

.nav-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 1.25rem;
  border-bottom: 1px solid #e5e7eb;
}

.nav-title {
  margin: 0;
  font-weight: 700;
  font-size: 1.25rem;
  color: #111827;
}

.nav-close {
  border: 1px solid #e5e7eb;
  background: #f9fafb;
  border-radius: 10px;
  width: 36px;
  height: 36px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.side-bar .menu {
  width: 100%;
  margin-top: 0;
  padding: 0.5rem 0 0;
  flex: 1;
  overflow-y: auto;
}

.side-bar .menu .item {
  cursor: pointer;
  position: relative;
}

.side-bar .menu .item a {
  color: rgb(0, 0, 0);
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 1.5rem;
  line-height: 1.4;
  font-size: 1rem;
  font-weight: 600;
  border-bottom: 1px solid #eee;
  transition: all 0.2s ease;
}

.side-bar .menu .item a:hover {
  background: #f3f4f6;
  color: #000;
  padding-left: 1.75rem;
}

.side-bar .menu .item .sub-menu {
  background: #f9fafb;
  position: relative;
  z-index: 1000;
}

.side-bar .menu .item .sub-menu a {
  padding-left: 2.75rem;
  font-size: 0.95rem;
  border-bottom: 1px solid #eee;
  font-weight: 500;
}

.side-bar .menu .item .sub-menu a:hover {
  background: #eef2ff;
  color: #000;
}

.chevron {
  font-size: 1.1rem;
  color: #6b7280;
}

.menu-footer {
  padding: 1rem 1.25rem 1.5rem;
  border-top: 1px solid #e5e7eb;
}

.menu-logout {
  width: 100%;
  justify-content: center;
}

/* Hide mobile drawer on desktop */
@media (min-width: 1024px) {
  .menu-trigger {
    display: none;
  }

  .nav-overlay {
    display: none !important;
  }

  .side-bar {
    transform: translateX(0);
    box-shadow: none;
    position: fixed;
    width: 280px;
  }

  .nav-close {
    display: none;
  }

  .topbar .logout-btn {
    display: none;
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
}

@media (min-width: 1024px) {
  .main-content {
    margin-left: 280px;
  }
}

/* ===== MODAL STYLES ===== */
.modal-container {
  width: 100%;
  max-width: 1200px;
  height: 100%;
  max-height: 90vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
}

.modal-content {
  width: 100%;
  max-width: 800px;
  border-radius: 1rem;
  background-color: #ffffff;
  padding: 2.5rem;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
  border: 2px solid #e5e7eb;
}

.left-column {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.profile-section {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
}

@media (min-width: 768px) {
  .profile-section {
    grid-template-columns: auto 1fr;
    gap: 2rem;
  }
}

.profile-image-container {
  display: flex;
  align-items: center;
  justify-content: center;
}

.profile-image {
  width: 12rem;
  height: 12rem;
  background-color: #f3f4f6;
  border-radius: 0.75rem;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px solid #e5e7eb;
}

.profile-icon {
  font-size: 4rem;
  color: #9ca3af;
}

.profile-details {
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 1.5rem;
}

.detail-item {
  margin-bottom: 0.5rem;
}

.detail-label {
  font-weight: 600;
  color: #6b7280;
  display: block;
  font-size: 1rem;
}

.detail-value {
  margin-top: 0.25rem;
  font-weight: 700;
  font-size: 1.25rem;
  color: #000000;
}

.info-section {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.5rem;
}

@media (max-width: 640px) {
  .info-section {
    grid-template-columns: 1fr;
  }
}

.info-item {
  margin-bottom: 0.5rem;
}

.info-label {
  font-weight: 600;
  color: #6b7280;
  display: block;
  font-size: 1rem;
}

.info-value {
  margin-top: 0.25rem;
  font-weight: 700;
  font-size: 1.25rem;
  color: #000000;
}

.buttons-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
  padding-top: 1.5rem;
}

@media (max-width: 768px) {
  .buttons-grid {
    grid-template-columns: 1fr;
  }
}

.action-button {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding: 1rem 1.5rem;
  font-size: 1rem;
  font-weight: 600;
  color: #ffffff;
  background-color: #000000;
  border: 2px solid #000000;
  border-radius: 0.5rem;
  cursor: pointer;
  transition: all 0.2s ease;
  text-decoration: none;
  font-family: inherit;
}

.action-button:hover {
  background-color: #333333;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.action-button:last-child {
  background-color: #ffffff;
  color: #000000;
}

.action-button:last-child:hover {
  background-color: #f3f4f6;
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
  animation: slideIn 0.3s ease-out, timeout 6s linear forwards;
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

  .side-bar {
    height: auto;
    position: relative;
  }

  .main-content {
    margin-left: 0;
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
