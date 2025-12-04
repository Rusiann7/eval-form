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
              close
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
            <div class="profile-image-container">
              <div class="profile-image">
                <span class="material-icons profile-icon">image</span>
              </div>
            </div>
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
              close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--sidebar-->
  <div class="side-bar">
    <div class="menu">
      <div class="item">
        <a
          href="#"
          class="sub-btn"
          @click.stop="
            $router.push('/principal');
            click('student');
          "
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
        <a href="#" @click.stop="showMenu3 = !showMenu3">Account Management</a>
        <div class="sub-menu" v-if="showMenu3">
          <a href="#" @click="click2('crtTeacher')" class="sub-item"
            >Add Teachers</a
          >
          <a href="#" @click="click2('rmTeacher')" class="sub-item"
            >Delete Users</a
          >
          <a href="#" @click="click2('editTeacher')" class="sub-item"
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

  <!--main content container-->
  <div class="main-content">
    <!-- Header -->
    <header class="topbar">
      <div>
        <span class="logo">Teacher Evaluation System</span>
        <br />
        <span class="breadcrumb">Principal Portal</span>
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
/* ===== CSS RESET & BASE STYLES ===== */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

body {
  background: #fff;
  color: #1a1a1a;
  line-height: 1.6;
  display: flex;
  min-height: 100vh;
}

/* ===== HEADER & TYPOGRAPHY ===== */
header {
  text-align: center;
  margin: 40px 0 20px;
}

header h1 {
  font-size: 24px;
  font-weight: bold;
}

header p {
  font-size: 16px;
  color: #555;
}

/* ===== TOPBAR STYLES ===== */
.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 40px;
  border-bottom: 1px solid #eee;
  flex-wrap: wrap;
  gap: 15px;
  position: sticky;
  top: 0;
  background: white;
  z-index: 99;
}

.logo {
  font-weight: bold;
  font-size: 18px;
}

.breadcrumb {
  background: #f1f3f5;
  padding: 5px 12px;
  border-radius: 8px;
  font-size: 14px;
  margin-left: 10px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 200px;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 15px;
  font-size: 14px;
  flex-wrap: wrap;
}

.logout-btn {
  background: #fff;
  border: 1px solid #ccc;
  padding: 6px 12px;
  border-radius: 6px;
  cursor: pointer;
  text-decoration: none;
  color: #000;
  transition: all 0.2s ease;
  white-space: nowrap;
}

.logout-btn:hover {
  background: #f8f9fa;
  border-color: #999;
}

/* ===== ROLE CARDS ===== */
.role-container {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin: 40px auto;
  flex-wrap: wrap;
  max-width: 1000px;
}

.role-card {
  background: #fff;
  border: 1px solid #eee;
  border-radius: 12px;
  padding: 30px 20px;
  width: 280px;
  text-align: center;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.role-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.icon {
  font-size: 40px;
  margin-bottom: 15px;
  border-radius: 50%;
  padding: 15px;
  display: inline-block;
}

.student {
  background: #eaf1ff;
  color: #0066ff;
}
.teacher {
  background: #e9f9ee;
  color: #2ecc71;
}
.admin {
  background: #f6eaff;
  color: #9b59b6;
}

.role-card h3 {
  margin: 10px 0 5px;
  font-size: 18px;
  font-weight: 600;
}

.role-card p {
  color: #555;
  font-size: 14px;
  margin-bottom: 20px;
  line-height: 1.5;
}

/* ===== BUTTON STYLES ===== */
.btn {
  display: inline-block;
  padding: 12px 20px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  text-decoration: none;
  cursor: pointer;
  border: none;
  transition: all 0.3s ease;
}

.btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn:active {
  transform: translateY(0);
}

.btn-student {
  background: #000;
  color: #fff;
}

.btn-teacher {
  background: #f1f3f5;
  color: #000;
}

.btn-admin {
  background: #fff;
  border: 1px solid #ccc;
  color: #000;
}

/* ===== PAGE COMPONENTS ===== */
.page-header {
  padding: 30px 40px 10px;
}

.page-header h2 {
  margin: 0;
  font-size: 20px;
  font-weight: 600;
}

.page-header p {
  color: #555;
  font-size: 14px;
  margin-top: 5px;
}

/* ===== STATS CARDS ===== */
.stats-container {
  display: flex;
  gap: 20px;
  padding: 20px 40px;
  flex-wrap: wrap;
}

.stat-card {
  flex: 1;
  min-width: 150px;
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  text-align: center;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  transition: transform 0.2s ease;
}

.stat-card:hover {
  transform: translateY(-2px);
}

.stat-card h3 {
  margin: 10px 0 0;
  font-size: 18px;
  font-weight: 600;
}

.stat-card p {
  color: #555;
  font-size: 14px;
  margin-top: 5px;
}

/* ===== TABS ===== */
.tabs {
  display: flex;
  gap: 8px;
  padding: 0 20px;
  margin: 20px 0;
  flex-wrap: wrap;
  justify-content: center;
}

.tab {
  background: #f1f3f5;
  padding: 8px 16px;
  border-radius: 20px;
  font-size: 14px;
  cursor: pointer;
  text-align: center;
  flex: 1 0 auto;
  min-width: fit-content;
  transition: all 0.3s ease;
  border: none;
  font-weight: 500;
}

.tab:hover {
  background: #e9ecef;
}

.tab.active {
  background: #000;
  color: #fff;
}

/* ===== TEACHER COMPONENTS ===== */
.teacher-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 40px;
  margin-bottom: 20px;
  flex-wrap: wrap;
  gap: 15px;
}

.dropdown {
  padding: 8px 12px;
  border: 1.5px solid #e1e5e9;
  border-radius: 6px;
  font-size: 14px;
  background: #fff;
  transition: border-color 0.3s ease;
}

.dropdown:focus {
  border-color: #4a6da7;
  outline: none;
}

.teacher-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 20px;
  padding: 0 40px 40px;
}

.teacher-card {
  border: 1px solid #eee;
  border-radius: 12px;
  padding: 20px;
  background: #fff;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.teacher-card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}

.teacher-card h3 {
  margin: 0;
  font-size: 16px;
  font-weight: 600;
}

.teacher-card p {
  color: #555;
  margin: 5px 0 10px;
  font-size: 14px;
}

/* ===== CARD COMPONENTS ===== */
.card {
  border: 1px solid #e1e5e9;
  border-radius: 12px;
  padding: 20px;
  background: #fff;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.card h3 {
  font-size: 16px;
  margin-bottom: 5px;
  font-weight: 600;
}

.card p {
  font-size: 14px;
  color: #666;
  margin-bottom: 10px;
  line-height: 1.5;
}

/* ===== BADGES ===== */
.badge {
  display: inline-block;
  background: #f1f3f5;
  padding: 4px 10px;
  font-size: 12px;
  border-radius: 20px;
  margin: 0 5px 10px 0;
  font-weight: 500;
}

.badge.rating {
  background: #ffe6e6;
  color: #c0392b;
  font-weight: bold;
}

.badge.evaluated {
  background: #e5e7eb;
  color: #333;
}

.checkmark {
  color: #27ae60;
  font-weight: bold;
  margin-left: 6px;
}

/* ===== BUTTON VARIANTS ===== */
.btn-dark {
  background: #000;
  color: #fff;
  border: none;
}

.btn-light {
  background: #f1f3f5;
  color: #000;
  border: none;
}

.card button {
  width: 100%;
  padding: 12px;
  border: 1.5px solid #e1e5e9;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  font-size: 14px;
  transition: all 0.3s ease;
  margin-top: 10px;
}

.card button:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card .start {
  background: #000;
  color: #fff;
  border-color: #000;
}

.card .update {
  background: #fff;
  color: #333;
  border-color: #e1e5e9;
}

/* ===== FORM STYLES ===== */
.wrong {
  color: #d32f2f;
  background: #ffebee;
  padding: 12px 16px;
  border-radius: 8px;
  margin-bottom: 20px;
  font-weight: 600;
  text-align: center;
  border: 1px solid #ffcdd2;
}

.form-group {
  margin-bottom: 20px;
  align-items: center;
  justify-content: center;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  color: #444;
  font-weight: 500;
  font-size: 14px;
}

.form-group input,
.form-group select {
  width: 70%;
  padding: 12px 15px;
  border: 1.5px solid #e1e5e9;
  border-radius: 8px;
  font-size: 1rem;
  background: #fff;
  transition: all 0.3s ease;
}

.form-group input:focus,
.form-group select:focus {
  border-color: #4a6da7;
  outline: none;
  box-shadow: 0 0 0 3px rgba(74, 109, 167, 0.1);
}

.form-group input:hover,
.form-group select:hover {
  border-color: #c1c9d2;
}

/* ===== LOADING & FEEDBACK STATES ===== */
.loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  z-index: 3000;
  color: white;
}

.loading-spinner {
  border: 4px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top: 4px solid #ffffff;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
  margin-bottom: 10px;
  z-index: 3000;
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
  top: 20px;
  left: 50%;
  transform: translateX(-50%);
  padding: 20px 30px;
  border-radius: 8px;
  font-weight: 500;
  z-index: 1000;
  text-align: center;
  min-width: 300px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  animation: slideIn 0.3s ease-out, timeout 6s linear forwards;
}

.success {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.error {
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

.success span,
.error span {
  display: block;
}

/* Progress bar for timeout */
.success::after,
.error::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  height: 4px;
  background: currentColor;
  opacity: 0.3;
  animation: progress 5s linear forwards;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateX(-50%) translateY(-20px);
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

/* ===== RESPONSIVE DESIGN ===== */

/* Tablet */
@media (max-width: 768px) {
  .topbar {
    padding: 12px 20px;
    gap: 12px;
  }

  .logo {
    font-size: 16px;
  }

  .breadcrumb {
    font-size: 13px;
    padding: 4px 10px;
    margin-left: 8px;
    max-width: 150px;
  }

  .user-info {
    gap: 12px;
    font-size: 13px;
  }

  .logout-btn {
    padding: 5px 10px;
    font-size: 13px;
  }

  .tabs {
    padding: 0 16px;
    gap: 6px;
  }

  .tab {
    padding: 6px 12px;
    font-size: 13px;
    flex: 1 0 calc(50% - 6px);
    max-width: calc(50% - 6px);
  }

  .page-header,
  .teacher-header,
  .stats-container,
  .teacher-container {
    padding-left: 20px;
    padding-right: 20px;
  }

  .side-bar {
    width: 200px;
  }

  .main-content {
    margin-left: 200px;
  }
}

/* Mobile */
@media (max-width: 480px) {
  .topbar {
    padding: 10px 16px;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }

  .logo-breadcrumb-container {
    display: flex;
    align-items: center;
    width: 100%;
    justify-content: space-between;
  }

  .logo {
    font-size: 16px;
  }

  .breadcrumb {
    font-size: 12px;
    padding: 4px 8px;
    margin-left: 0;
    max-width: 120px;
  }

  .user-info {
    width: 100%;
    justify-content: space-between;
    gap: 8px;
    font-size: 12px;
  }

  .logout-btn {
    padding: 4px 8px;
    font-size: 12px;
  }

  .tabs {
    padding: 0 12px;
    gap: 4px;
    margin: 16px 0;
  }

  .tab {
    padding: 6px 10px;
    font-size: 12px;
    flex: 1 0 100%;
    max-width: 100%;
    border-radius: 12px;
  }

  .teacher-header {
    flex-direction: column;
    align-items: stretch;
  }

  .role-card,
  .stat-card {
    width: 100%;
    min-width: auto;
  }

  .side-bar {
    width: 100%;
    height: auto;
    position: relative;
  }

  .main-content {
    margin-left: 0;
  }

  body {
    flex-direction: column;
  }
}

/* Small mobile */
@media (max-width: 360px) {
  .topbar {
    padding: 8px 12px;
  }

  .user-info {
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
  }

  .logout-btn {
    align-self: stretch;
    text-align: center;
  }

  .success,
  .error {
    min-width: 280px;
    padding: 15px 20px;
    left: 10px;
    right: 10px;
    transform: translateX(0);
    margin: 0 auto;
  }
}

/* Large screens */
@media (min-width: 1200px) {
  .topbar {
    padding: 20px 60px;
  }

  .logo {
    font-size: 20px;
  }

  .breadcrumb {
    font-size: 15px;
    max-width: 300px;
  }

  .tabs {
    padding: 0 60px;
    gap: 12px;
  }

  .tab {
    padding: 10px 20px;
    font-size: 15px;
  }
}

/* ===== ACCESSIBILITY ENHANCEMENTS ===== */
@media (prefers-reduced-motion: reduce) {
  * {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}

/* High contrast support */
@media (prefers-contrast: high) {
  .form-group input,
  .form-group select,
  .dropdown {
    border-width: 2px;
  }

  .wrong {
    border: 2px solid #d32f2f;
  }

  .badge {
    border: 1px solid currentColor;
  }
}

/* Focus visibility for accessibility */
button:focus-visible,
input:focus-visible,
select:focus-visible,
.tab:focus-visible {
  outline: 2px solid #4a6da7;
  outline-offset: 2px;
}

/* Loading states */
.card button:disabled,
.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none !important;
}

.card button:disabled:hover,
.btn:disabled:hover {
  transform: none !important;
  box-shadow: none !important;
}

/* Overlay for background */
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  z-index: 998;
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
  padding: 20px;
  min-height: 100vh;
}

button {
  position: relative;
  z-index: 1000;
  padding: 10px 20px;
  margin: 10px;
  cursor: pointer;
}

.main-content {
  margin-left: 250px;
  flex: 1;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.page-header,
.teacher-header,
.stats-container,
.teacher-container,
.role-container {
  position: relative;
  z-index: 1;
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
