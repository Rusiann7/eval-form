<template>
  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <!-- Sidebar Toggle -->
  <input
    type="checkbox"
    id="principal-nav-toggle"
    class="menu-checkbox"
    aria-hidden="true"
  />
  <label for="principal-nav-toggle" class="menu-overlay" aria-hidden="true"></label>

  <!-- Modals -->
  <div class="main-modal" v-if="activeModal === 'showInfo'">
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
            <button class="action-button">Average Evaluation</button>
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

  <div class="main-modal" v-if="activeModal === 'showInfot'">
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
            <button class="action-button">Average Evaluation</button>
            <button
              class="action-button"
              @click.prevent="
                $router.push({
                  name: 'PerformanceGraph',
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
    
  <!-- Sidebar -->
  <div class="side-bar">
    <div class="sidebar-header">
      <h3 class="sidebar-title">Principal Portal</h3>
      <label for="principal-nav-toggle" class="sidebar-close" aria-label="Close menu">
        <span></span>
        <span></span>
      </label>
    </div>
    <div class="menu">
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu1 = !showMenu1">
          <span>Student</span>
          <svg class="chevron-icon" :class="{ 'rotated': showMenu1 }" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </a>
        <div class="sub-menu" v-if="showMenu1">
          <a href="#" class="sub-item" @click="click('student')">Student Evaluations</a>
          <a href="#" @click="click('showInfo')" class="sub-item">Individual Answers</a>
        </div>
      </div>
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu2 = !showMenu2">
          <span>Teacher</span>
          <svg class="chevron-icon" :class="{ 'rotated': showMenu2 }" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </a>
        <div class="sub-menu" v-if="showMenu2">
          <a href="#" @click="click('teacher')" class="sub-item">Teacher Evaluations</a>
          <a href="#" @click="click('evaluate')" class="sub-item">Evaluate Teachers</a>
        </div>
      </div>
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu3 = !showMenu3">
          <span>Account Management</span>
          <svg class="chevron-icon" :class="{ 'rotated': showMenu3 }" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </a>
        <div class="sub-menu" v-if="showMenu3">
          <a href="#" @click="click2('crtTeacher')" class="sub-item">Add Teachers</a>
          <a href="#" @click="click2('rmTeacher')" class="sub-item">Delete Users</a>
          <a href="#" @click="click2('editTeacher')" class="sub-item">Edit Users</a>
        </div>
      </div>
      <div class="item">
        <a href="#" @click.prevent="navigateAndClose('/scheduler')">Scheduler</a>
      </div>
      <div class="item">
        <a href="#" @click.prevent="navigateAndClose('/fileupload')">File Upload</a>
      </div>
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu4 = !showMenu4">
          <span>Question Change</span>
          <svg class="chevron-icon" :class="{ 'rotated': showMenu4 }" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </a>
        <div class="sub-menu" v-if="showMenu4">
          <a href="#" @click.prevent="$router.push('/changequestions-student')" class="sub-item">Student Questions</a>
          <a href="#" @click.prevent="$router.push('/changequestions-teacher')" class="sub-item">Teacher Questions</a>
        </div>
      </div>
    </div>
    <div class="sidebar-footer">
      <button class="logout-btn sidebar-logout" @click="logout()">
        <svg class="logout-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
          <polyline points="16 17 21 12 16 7"></polyline>
          <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
        Logout
      </button>
    </div>
  </div>

  <!-- Main content container -->
  <div class="main-content">
    <!-- Header -->
    <header class="topbar">
      <div class="header-left">
        <div class="title-row">
          <h1 class="logo">Teacher Evaluation System</h1>
          <div class="title-actions">
            <button class="portal-btn">Principal Portal</button>
            <label
              for="principal-nav-toggle"
              class="menu-toggle"
              aria-label="Toggle menu"
            >
              <span></span>
              <span></span>
              <span></span>
            </label>
          </div>
        </div>
      </div>
      <div class="user-section">
        <span class="user-greeting">Welcome, {{ fullname }} {{ lastname }}</span>
        <button class="logout-btn desktop-only" @click="logout()">
          <svg class="logout-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg>
          Logout
        </button>
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
        <div class="stat-icon">👥</div>
        <h3>{{ this.count }}</h3>
        <p>Teachers</p>
      </div>
      <div class="stat-card">
        <div class="stat-icon">🎓</div>
        <h3>{{ this.count2 }}</h3>
        <p>Students</p>
      </div>
    </div>

    <!-- Student Evaluations -->
    <div v-if="activeModal === 'student'">
      <div class="section-header">
        <h3>Student Evaluations</h3>
      </div>

      <!-- Search and Sort Controls -->
      <div class="search-sort-container">
        <div class="search-wrapper">
          <svg class="search-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.35-4.35"></path>
          </svg>
          <input
            type="text"
            v-model="studentSearchQuery"
            placeholder="Search by name, subject, quarter, or year..."
            class="search-input"
          />
        </div>
        <div class="sort-wrapper">
          <label for="student-sort" class="sort-label">Sort by:</label>
          <select
            id="student-sort"
            v-model="studentSortBy"
            class="sort-select"
          >
            <option value="name-asc">Name (A-Z)</option>
            <option value="name-desc">Name (Z-A)</option>
            <option value="subject-asc">Subject (A-Z)</option>
            <option value="subject-desc">Subject (Z-A)</option>
            <option value="quarter-asc">Quarter (1-4)</option>
            <option value="quarter-desc">Quarter (4-1)</option>
            <option value="year-desc">Year (Newest)</option>
            <option value="year-asc">Year (Oldest)</option>
          </select>
        </div>
      </div>

      <!-- Results Count -->
      <div class="results-count" v-if="filteredAndSortedStudents.length !== newStudents.length">
        <span>Showing {{ filteredAndSortedStudents.length }} of {{ newStudents.length }} evaluations</span>
      </div>

      <div class="teacher-container">
        <div
          class="card student-card"
          v-for="newStudent in filteredAndSortedStudents"
          :key="`student-${newStudent.id}-${newStudent.eval_id}`"
        >
          <h3>{{ newStudent.firstname }} {{ newStudent.lastname }}</h3>
          <p>{{ newStudent.subject }}</p>
          <span class="badge"
            >Q{{ newStudent.quarter }} {{ newStudent.year }}</span
          >
          <div class="card-button-wrapper">
            <button
              class="start"
              @click.prevent="
                $router.push({
                  name: 'printable-form',
                  params: {
                    id: newStudent.id,
                    tcrid: newStudent.teacher_id,
                    evtid: newStudent.eval_id,
                  },
                })
              "
            >
              View Evaluation
            </button>
          </div>
        </div>
        <div v-if="filteredAndSortedStudents.length === 0" class="no-results">
          <p>No evaluations found matching your search criteria.</p>
        </div>
      </div>
    </div>

    <!-- Evaluate Teachers -->
    <div v-if="activeModal === 'evaluate'">
      <div class="section-header">
        <h3>Evaluate Teachers</h3>
      </div>

      <!-- Search and Sort Controls -->
      <div class="search-sort-container">
        <div class="search-wrapper">
          <svg class="search-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.35-4.35"></path>
          </svg>
          <input
            type="text"
            v-model="evaluateSearchQuery"
            placeholder="Search by name, subject, quarter, or year..."
            class="search-input"
          />
        </div>
        <div class="sort-wrapper">
          <label for="evaluate-sort" class="sort-label">Sort by:</label>
          <select
            id="evaluate-sort"
            v-model="evaluateSortBy"
            class="sort-select"
          >
            <option value="name-asc">Name (A-Z)</option>
            <option value="name-desc">Name (Z-A)</option>
            <option value="subject-asc">Subject (A-Z)</option>
            <option value="subject-desc">Subject (Z-A)</option>
            <option value="quarter-asc">Quarter (1-4)</option>
            <option value="quarter-desc">Quarter (4-1)</option>
            <option value="year-desc">Year (Newest)</option>
            <option value="year-asc">Year (Oldest)</option>
          </select>
        </div>
      </div>

      <!-- Results Count -->
      <div class="results-count" v-if="filteredAndSortedEvaluateTeachers.length !== teachers.length">
        <span>Showing {{ filteredAndSortedEvaluateTeachers.length }} of {{ teachers.length }} teachers</span>
      </div>

      <!-- Teacher Cards -->
      <div class="teacher-container">
        <div
          class="card teacher-card-evaluate"
          v-for="teacher in filteredAndSortedEvaluateTeachers"
          :key="`evaluate-${teacher.id}`"
        >
          <h3>{{ teacher.firstname }} {{ teacher.lastname }}</h3>
          <p>{{ teacher.subject }}</p>
          <span class="badge">Q{{ teacher.quarter }} {{ teacher.year }}</span>
          <div class="card-button-wrapper">
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
        <div v-if="filteredAndSortedEvaluateTeachers.length === 0" class="no-results">
          <p>No teachers found matching your search criteria.</p>
        </div>
      </div>
    </div>

    <!-- Teacher Evaluations -->
    <div v-if="activeModal === 'teacher'">
      <div class="section-header">
        <h3>Teacher Evaluations</h3>
      </div>

      <!-- Search and Sort Controls -->
      <div class="search-sort-container">
        <div class="search-wrapper">
          <svg class="search-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.35-4.35"></path>
          </svg>
          <input
            type="text"
            v-model="teacherSearchQuery"
            placeholder="Search by name, subject, quarter, or year..."
            class="search-input"
          />
        </div>
        <div class="sort-wrapper">
          <label for="teacher-sort" class="sort-label">Sort by:</label>
          <select
            id="teacher-sort"
            v-model="teacherSortBy"
            class="sort-select"
          >
            <option value="name-asc">Name (A-Z)</option>
            <option value="name-desc">Name (Z-A)</option>
            <option value="subject-asc">Subject (A-Z)</option>
            <option value="subject-desc">Subject (Z-A)</option>
            <option value="quarter-asc">Quarter (1-4)</option>
            <option value="quarter-desc">Quarter (4-1)</option>
            <option value="year-desc">Year (Newest)</option>
            <option value="year-asc">Year (Oldest)</option>
          </select>
        </div>
      </div>

      <!-- Results Count -->
      <div class="results-count" v-if="filteredAndSortedTeachers.length !== newTeachers.length">
        <span>Showing {{ filteredAndSortedTeachers.length }} of {{ newTeachers.length }} evaluations</span>
      </div>

      <div class="teacher-container">
        <div
          class="card teacher-card"
          v-for="newteacher in filteredAndSortedTeachers"
          :key="`teacher-${newteacher.id}-${newteacher.eval_id}`"
        >
          <h3>{{ newteacher.firstname }} {{ newteacher.lastname }}</h3>
          <p>{{ newteacher.subject }}</p>
          <span class="badge"
            >Q{{ newteacher.quarter }} {{ newteacher.year }}</span
          >
          <div class="card-button-wrapper">
            <button
              class="start"
              @click.prevent="
                $router.push({
                  name: 'printable-form1',
                  params: {
                    id: newteacher.id,
                    tcrid: newteacher.teacher_id,
                    evtid: newteacher.eval_id,
                  },
                })
              "
            >
              View Evaluation
            </button>
          </div>
        </div>
        <div v-if="filteredAndSortedTeachers.length === 0" class="no-results">
          <p>No evaluations found matching your search criteria.</p>
        </div>
      </div>
    </div>

    <!-- Account Management -->
    <div v-if="activeModal === 'manage'">
      <div class="content">
        <!-- Create Teacher Form -->
        <div class="container" v-if="activeTab1 === 'crtTeacher'">
          <div class="form-header">
            <h3 class="form-title">Create New Teacher Account</h3>
            <p class="form-subtitle">Fill in the details below to create a new teacher user account</p>
          </div>

          <form method="post" @submit.prevent="createTeachers()" class="create-teacher-form">
            <div v-if="isWrong" class="wrong">
              <p>Wrong Credentials or Incomplete Information</p>
            </div>

            <div class="form-grid">
              <div class="form-group">
                <label for="firstName">First Name <span class="required">*</span></label>
                <input
                  id="firstName"
                  type="text"
                  v-model="teacherr.fn"
                  placeholder="Enter First Name"
                  required
                />
              </div>

              <div class="form-group">
                <label for="lastName">Last Name <span class="required">*</span></label>
                <input
                  id="lastName"
                  type="text"
                  v-model="teacherr.ln"
                  placeholder="Enter Last Name"
                  required
                />
              </div>

              <div class="form-group">
                <label for="email">Email Address <span class="required">*</span></label>
                <input
                  id="email"
                  type="email"
                  v-model="teacherr.email"
                  placeholder="Enter Email Address"
                  required
                />
              </div>

              <div class="form-group">
                <label for="teacherId">Teacher ID <span class="required">*</span></label>
                <input
                  id="teacherId"
                  type="number"
                  v-model="teacherr.id"
                  placeholder="Enter Teacher ID"
                  required
                />
              </div>

              <div class="form-group">
                <label for="subject">Subject <span class="required">*</span></label>
                <select id="subject" v-model="teacherr.sub" required>
                  <option value="">Select Subject</option>
                  <option value="Math">Math</option>
                  <option value="English">English</option>
                  <option value="Filipino">Filipino</option>
                  <option value="Science">Science</option>
                  <option value="Araling Panlipunan">Araling Panlipunan</option>
                  <option value="TLE">TLE</option>
                  <option value="MAPEH">MAPEH</option>
                  <option value="ESP">ESP</option>
                </select>
              </div>

              <div class="form-group">
                <label for="quarter">Quarter <span class="required">*</span></label>
                <select id="quarter" v-model="teacherr.qrt" required>
                  <option value="">Select Quarter</option>
                  <option value="1">Quarter 1</option>
                  <option value="2">Quarter 2</option>
                  <option value="3">Quarter 3</option>
                  <option value="4">Quarter 4</option>
                </select>
              </div>

              <div class="form-group">
                <label for="year">Year <span class="required">*</span></label>
                <input
                  id="year"
                  type="number"
                  v-model="teacherr.yr"
                  placeholder="Enter Year (e.g., 2024)"
                  required
                  min="2000"
                  max="2100"
                />
              </div>

              <div class="form-group">
                <label for="password">Password <span class="required">*</span></label>
                <input
                  id="password"
                  type="password"
                  v-model="teacherr.ps"
                  placeholder="Enter Password"
                  required
                  minlength="6"
                />
              </div>

              <div class="form-group">
                <label for="confirmPassword">Confirm Password <span class="required">*</span></label>
                <input
                  id="confirmPassword"
                  type="password"
                  v-model="teacherr.cpas"
                  placeholder="Confirm Password"
                  required
                  minlength="6"
                />
              </div>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn-primary">
                <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 5v14M5 12h14"></path>
                </svg>
                Create Teacher Account
              </button>
            </div>
          </form>
        </div>

        <!-- Delete Users Section -->
        <div v-if="activeTab1 === 'rmTeacher'">
          <div class="section-header">
            <h3>Delete Users</h3>
            <p class="section-description">Search and manage teacher accounts. Click remove to delete a teacher account.</p>
          </div>

          <!-- Search and Sort Controls -->
          <div class="search-sort-container">
            <div class="search-wrapper">
              <svg class="search-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
              </svg>
              <input
                type="text"
                v-model="deleteSearchQuery"
                placeholder="Search by name, subject, quarter, or year..."
                class="search-input"
              />
            </div>
            <div class="sort-wrapper">
              <label for="delete-sort" class="sort-label">Sort by:</label>
              <select
                id="delete-sort"
                v-model="deleteSortBy"
                class="sort-select"
              >
                <option value="name-asc">Name (A-Z)</option>
                <option value="name-desc">Name (Z-A)</option>
                <option value="subject-asc">Subject (A-Z)</option>
                <option value="subject-desc">Subject (Z-A)</option>
                <option value="quarter-asc">Quarter (1-4)</option>
                <option value="quarter-desc">Quarter (4-1)</option>
                <option value="year-desc">Year (Newest)</option>
                <option value="year-asc">Year (Oldest)</option>
              </select>
            </div>
          </div>

          <!-- Results Count -->
          <div class="results-count" v-if="filteredAndSortedDeleteTeachers.length !== teachers.length">
            <span>Showing {{ filteredAndSortedDeleteTeachers.length }} of {{ teachers.length }} teachers</span>
          </div>

          <div class="teacher-container">
            <div
              class="card delete-teacher-card"
              v-for="teacher in filteredAndSortedDeleteTeachers"
              :key="`delete-${teacher.id}`"
            >
              <h3>{{ teacher.firstname }} {{ teacher.lastname }}</h3>
              <p>{{ teacher.subject }}</p>
              <span class="badge">Q{{ teacher.quarter }} {{ teacher.year }}</span>
              <div class="card-button-wrapper">
                <button
                  class="btn-delete"
                  @click.prevent="rmTeachers(teacher.id)"
                >
                  <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="m19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                  </svg>
                  Remove Teacher
                </button>
              </div>
            </div>
            <div v-if="filteredAndSortedDeleteTeachers.length === 0" class="no-results">
              <p>No teachers found matching your search criteria.</p>
            </div>
          </div>
        </div>

        <!-- Edit Teacher Section -->
        <div v-if="activeTab1 === 'editTeacher'">
          <div class="section-header">
            <h3>Edit Teacher Accounts</h3>
            <p class="section-description">Search and edit teacher account details.</p>
          </div>

          <!-- Search and Sort Controls -->
          <div class="search-sort-container">
            <div class="search-wrapper">
              <svg class="search-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
              </svg>
              <input
                type="text"
                v-model="editSearchQuery"
                placeholder="Search by name, subject, quarter, or year..."
                class="search-input"
              />
            </div>
          </div>

          <!-- Results Count -->
          <div class="results-count" v-if="filteredEditTeachers.length !== teachers.length">
            <span>Showing {{ filteredEditTeachers.length }} of {{ teachers.length }} teachers</span>
          </div>

          <div class="teacher-container">
            <div
              class="card"
              v-for="teacher in filteredEditTeachers"
              :key="teacher.id"
              v-if="!isEditing"
            >
              <h3>{{ teacher.firstname }} {{ teacher.lastname }}</h3>
              <p>{{ teacher.subject }}</p>
              <span class="badge">Q{{ teacher.quarter }} {{ teacher.year }}</span>
              <div class="card-button-wrapper">
                <button class="update" @click.prevent="openTeacherModal(teacher.id)">
                  Edit Teacher
                </button>
              </div>
            </div>

            <div v-if="isEditing" class="edit-form-container">
              <div class="card">
                <div class="form-header">
                  <h3 class="form-title">Edit Teacher Account</h3>
                  <p class="form-subtitle">Update the details for {{ selectedTeachers.fn }} {{ selectedTeachers.ln }}</p>
                </div>
                <form method="post" @submit.prevent="editTeachers()">
                  <div v-if="isWrong" class="wrong">
                    <p class="wrong">Wrong Credentials or Incomplete Information</p>
                  </div>
                  <div class="form-grid">
                    <div class="form-group">
                      <label for="editFirstName">First Name <span class="required">*</span></label>
                      <input
                        id="editFirstName"
                        type="text"
                        v-model="selectedTeachers.fn"
                        placeholder="Enter First Name"
                        required
                      />
                    </div>

                    <div class="form-group">
                      <label for="editLastName">Last Name <span class="required">*</span></label>
                      <input
                        id="editLastName"
                        type="text"
                        v-model="selectedTeachers.ln"
                        placeholder="Enter Last Name"
                        required
                      />
                    </div>

                    <div class="form-group">
                      <label for="editEmail">Email Address <span class="required">*</span></label>
                      <input
                        id="editEmail"
                        type="email"
                        v-model="selectedTeachers.email"
                        placeholder="Enter Email"
                        required
                      />
                    </div>

                    <div class="form-group">
                      <label for="editTeacherId">Teacher ID <span class="required">*</span></label>
                      <input
                        id="editTeacherId"
                        type="number"
                        v-model="selectedTeachers.id"
                        placeholder="Enter ID"
                        required
                      />
                    </div>

                    <div class="form-group">
                      <label for="editSubject">Subject <span class="required">*</span></label>
                      <select id="editSubject" v-model="selectedTeachers.sub" required>
                        <option value="">Select Subject</option>
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
                      <label for="editQuarter">Quarter <span class="required">*</span></label>
                      <select id="editQuarter" v-model="selectedTeachers.qrt" required>
                        <option value="1">Quarter 1</option>
                        <option value="2">Quarter 2</option>
                        <option value="3">Quarter 3</option>
                        <option value="4">Quarter 4</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="editYear">Year <span class="required">*</span></label>
                      <input
                        id="editYear"
                        type="number"
                        v-model="selectedTeachers.yr"
                        placeholder="Enter Year"
                        required
                      />
                    </div>
                  </div>
                  <div class="form-actions">
                    <button type="submit" class="btn-primary">Save Changes</button>
                    <button type="button" class="btn-secondary" @click="isEditing = false">Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { removeToken, getToken } from "../../utils/auth";

const url1 = "https://rusiann7.helioho.st";
const url2 = "https://star-panda-literally.ngrok-free.app";

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
        "Principal",
      lastname:
        JSON.parse(localStorage.getItem("userData") || "{}").lastname ||
        "User",
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
      studentSearchQuery: "",
      studentSortBy: "name-asc",
      teacherSearchQuery: "",
      teacherSortBy: "name-asc",
      evaluateSearchQuery: "",
      evaluateSortBy: "name-asc",
      deleteSearchQuery: "",
      deleteSortBy: "name-asc",
      editSearchQuery: "",
      verify: "",
      verified: "0",
      active: "code",
      subjects: [],
    };
  },

  computed: {
    filteredAndSortedStudents() {
      let filtered = this.newStudents;

      // Apply search filter
      if (this.studentSearchQuery.trim()) {
        const query = this.studentSearchQuery.toLowerCase().trim();
        filtered = filtered.filter((student) => {
          const fullName = `${student.firstname} ${student.lastname}`.toLowerCase();
          const subject = (student.subject || "").toLowerCase();
          const quarter = String(student.quarter || "");
          const year = String(student.year || "");
          
          return (
            fullName.includes(query) ||
            subject.includes(query) ||
            quarter.includes(query) ||
            year.includes(query)
          );
        });
      }

      // Apply sorting
      const [sortField, sortOrder] = this.studentSortBy.split("-");
      filtered = [...filtered].sort((a, b) => {
        let aValue, bValue;

        switch (sortField) {
          case "name":
            aValue = `${a.firstname} ${a.lastname}`.toLowerCase();
            bValue = `${b.firstname} ${b.lastname}`.toLowerCase();
            break;
          case "subject":
            aValue = (a.subject || "").toLowerCase();
            bValue = (b.subject || "").toLowerCase();
            break;
          case "quarter":
            aValue = parseInt(a.quarter) || 0;
            bValue = parseInt(b.quarter) || 0;
            break;
          case "year":
            aValue = parseInt(a.year) || 0;
            bValue = parseInt(b.year) || 0;
            break;
          default:
            return 0;
        }

        if (typeof aValue === "string") {
          return sortOrder === "asc"
            ? aValue.localeCompare(bValue)
            : bValue.localeCompare(aValue);
        } else {
          return sortOrder === "asc" ? aValue - bValue : bValue - aValue;
        }
      });

      return filtered;
    },

    filteredAndSortedTeachers() {
      let filtered = this.newTeachers;

      // Apply search filter
      if (this.teacherSearchQuery.trim()) {
        const query = this.teacherSearchQuery.toLowerCase().trim();
        filtered = filtered.filter((teacher) => {
          const fullName = `${teacher.firstname} ${teacher.lastname}`.toLowerCase();
          const subject = (teacher.subject || "").toLowerCase();
          const quarter = String(teacher.quarter || "");
          const year = String(teacher.year || "");
          
          return (
            fullName.includes(query) ||
            subject.includes(query) ||
            quarter.includes(query) ||
            year.includes(query)
          );
        });
      }

      // Apply sorting
      const [sortField, sortOrder] = this.teacherSortBy.split("-");
      filtered = [...filtered].sort((a, b) => {
        let aValue, bValue;

        switch (sortField) {
          case "name":
            aValue = `${a.firstname} ${a.lastname}`.toLowerCase();
            bValue = `${b.firstname} ${b.lastname}`.toLowerCase();
            break;
          case "subject":
            aValue = (a.subject || "").toLowerCase();
            bValue = (b.subject || "").toLowerCase();
            break;
          case "quarter":
            aValue = parseInt(a.quarter) || 0;
            bValue = parseInt(b.quarter) || 0;
            break;
          case "year":
            aValue = parseInt(a.year) || 0;
            bValue = parseInt(b.year) || 0;
            break;
          default:
            return 0;
        }

        if (typeof aValue === "string") {
          return sortOrder === "asc"
            ? aValue.localeCompare(bValue)
            : bValue.localeCompare(aValue);
        } else {
          return sortOrder === "asc" ? aValue - bValue : bValue - aValue;
        }
      });

      return filtered;
    },

    filteredAndSortedEvaluateTeachers() {
      let filtered = this.teachers;

      // Apply search filter
      if (this.evaluateSearchQuery.trim()) {
        const query = this.evaluateSearchQuery.toLowerCase().trim();
        filtered = filtered.filter((teacher) => {
          const fullName = `${teacher.firstname} ${teacher.lastname}`.toLowerCase();
          const subject = (teacher.subject || "").toLowerCase();
          const quarter = String(teacher.quarter || "");
          const year = String(teacher.year || "");
          
          return (
            fullName.includes(query) ||
            subject.includes(query) ||
            quarter.includes(query) ||
            year.includes(query)
          );
        });
      }

      // Apply sorting
      const [sortField, sortOrder] = this.evaluateSortBy.split("-");
      filtered = [...filtered].sort((a, b) => {
        let aValue, bValue;

        switch (sortField) {
          case "name":
            aValue = `${a.firstname} ${a.lastname}`.toLowerCase();
            bValue = `${b.firstname} ${b.lastname}`.toLowerCase();
            break;
          case "subject":
            aValue = (a.subject || "").toLowerCase();
            bValue = (b.subject || "").toLowerCase();
            break;
          case "quarter":
            aValue = parseInt(a.quarter) || 0;
            bValue = parseInt(b.quarter) || 0;
            break;
          case "year":
            aValue = parseInt(a.year) || 0;
            bValue = parseInt(b.year) || 0;
            break;
          default:
            return 0;
        }

        if (typeof aValue === "string") {
          return sortOrder === "asc"
            ? aValue.localeCompare(bValue)
            : bValue.localeCompare(aValue);
        } else {
          return sortOrder === "asc" ? aValue - bValue : bValue - aValue;
        }
      });

      return filtered;
    },

    filteredAndSortedDeleteTeachers() {
      let filtered = this.teachers;

      // Apply search filter
      if (this.deleteSearchQuery.trim()) {
        const query = this.deleteSearchQuery.toLowerCase().trim();
        filtered = filtered.filter((teacher) => {
          const fullName = `${teacher.firstname} ${teacher.lastname}`.toLowerCase();
          const subject = (teacher.subject || "").toLowerCase();
          const quarter = String(teacher.quarter || "");
          const year = String(teacher.year || "");
          
          return (
            fullName.includes(query) ||
            subject.includes(query) ||
            quarter.includes(query) ||
            year.includes(query)
          );
        });
      }

      // Apply sorting
      const [sortField, sortOrder] = this.deleteSortBy.split("-");
      filtered = [...filtered].sort((a, b) => {
        let aValue, bValue;

        switch (sortField) {
          case "name":
            aValue = `${a.firstname} ${a.lastname}`.toLowerCase();
            bValue = `${b.firstname} ${b.lastname}`.toLowerCase();
            break;
          case "subject":
            aValue = (a.subject || "").toLowerCase();
            bValue = (b.subject || "").toLowerCase();
            break;
          case "quarter":
            aValue = parseInt(a.quarter) || 0;
            bValue = parseInt(b.quarter) || 0;
            break;
          case "year":
            aValue = parseInt(a.year) || 0;
            bValue = parseInt(b.year) || 0;
            break;
          default:
            return 0;
        }

        if (typeof aValue === "string") {
          return sortOrder === "asc"
            ? aValue.localeCompare(bValue)
            : bValue.localeCompare(aValue);
        } else {
          return sortOrder === "asc" ? aValue - bValue : bValue - aValue;
        }
      });

      return filtered;
    },

    filteredEditTeachers() {
      let filtered = this.teachers;

      // Apply search filter
      if (this.editSearchQuery.trim()) {
        const query = this.editSearchQuery.toLowerCase().trim();
        filtered = filtered.filter((teacher) => {
          const fullName = `${teacher.firstname} ${teacher.lastname}`.toLowerCase();
          const subject = (teacher.subject || "").toLowerCase();
          const quarter = String(teacher.quarter || "");
          const year = String(teacher.year || "");
          
          return (
            fullName.includes(query) ||
            subject.includes(query) ||
            quarter.includes(query) ||
            year.includes(query)
          );
        });
      }

      return filtered;
    },
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
        if (confirm("Are you sure you want to remove this teacher?")) {
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
            setTimeout(() => this.isSuccess = false, 3000);
          } else {
            this.isFailed = true;
            setTimeout(() => this.isFailed = false, 3000);
          }
          this.isLoading = false;
        }
      } catch (error) {
        console.error(error);
        this.isLoading = false;
      }
    },

    async createTeachers() {
      if (this.teacherr.ps !== this.teacherr.cpas) {
        this.isWrong = true;
        setTimeout(() => this.isWrong = false, 3000);
        return;
      }

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

        const result = await response.json();

        if (result.success) {
          this.getTeachers();
          this.isSuccess = true;
          setTimeout(() => this.isSuccess = false, 3000);
          this.teacherr = {
            fn: "",
            ln: "",
            email: "",
            id: "",
            yr: "",
            ps: "",
            cpas: "",
            sub: "",
            qrt: "",
          };
        } else {
          this.isFailed = true;
          setTimeout(() => this.isFailed = false, 3000);
        }
        this.isLoading = false;
      } catch (error) {
        console.error(error);
        this.isLoading = false;
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
        }
      } catch (error) {
        console.error("error");
      }
    },

    async editTeachers() {
      try {
        this.isLoading = true;

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
          this.getTeachers();
          this.isSuccess = true;
          setTimeout(() => this.isSuccess = false, 3000);
          this.isEditing = false;
        } else {
          this.isFailed = true;
          setTimeout(() => this.isFailed = false, 3000);
          this.isWrong = true;
          setTimeout(() => this.isWrong = false, 3000);
        }
        this.isLoading = false;
      } catch (error) {
        this.isLoading = false;
        console.log(error);
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
      const teacher = this.teachers.find((teacher) => teacher.id === teacherId);

      this.selectedTeachers = {
        fn: teacher.firstname,
        ln: teacher.lastname,
        email: teacher.email,
        id: teacher.id,
        sub: teacher.subject,
        qrt: teacher.quarter,
        yr: teacher.year,
      };

      this.isEditing = true;
    },

    click(tabName) {
      this.activeModal = tabName;
      if (window.innerWidth <= 768) {
        document.getElementById('principal-nav-toggle').checked = false;
      }
    },

    click2(tabName) {
      this.activeTab1 = tabName;
      this.activeModal = "manage";
      if (window.innerWidth <= 768) {
        document.getElementById('principal-nav-toggle').checked = false;
      }
    },

    navigateAndClose(route) {
      this.$router.push(route);
      if (window.innerWidth <= 768) {
        document.getElementById('principal-nav-toggle').checked = false;
      }
    },

    verifyCode() {
      this.active = 'input';
    },

    verifyInput() {
      this.verified = '1';
      this.active = 'code';
    }
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
      }
    },
  },

  mounted() {
    this.id = localStorage.getItem("userData") || "";
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
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
  background: #f9fafb;
  color: #1a1a1a;
  line-height: 1.6;
  display: flex;
  min-height: 100vh;
  overflow-x: hidden;
  font-size: 16px;
}

/* ===== IMPROVED TYPOGRAPHY - LARGER TEXT ===== */
h1 { font-size: 1.875rem; }
h2 { font-size: 1.625rem; }
h3 { font-size: 1.375rem; }
p, span, label, button, input, select { 
  font-size: 1.0625rem; 
}

@media (min-width: 768px) {
  h1 { font-size: 2.25rem; }
  h2 { font-size: 2rem; }
  h3 { font-size: 1.75rem; }
  p, span, label, button, input, select { 
    font-size: 1.125rem; 
  }
}

@media (min-width: 1024px) {
  h1 { font-size: 2.5rem; }
  h2 { font-size: 2.25rem; }
  h3 { font-size: 2rem; }
  p, span, label, button, input, select { 
    font-size: 1.25rem; 
  }
}

/* ===== TOPBAR STYLES ===== */
.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.25rem 1.5rem;
  border-bottom: 1px solid #e5e7eb;
  flex-wrap: wrap;
  gap: 1rem;
  position: sticky;
  top: 0;
  background: white;
  z-index: 30;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.header-left {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  flex-wrap: wrap;
}

.title-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  gap: 1rem;
}

.logo {
  font-weight: bold;
  margin: 0;
  color: #111827;
  font-size: 1.25rem;
}

.title-actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.portal-btn {
  background: #f3f4f6;
  padding: 0.75rem 1.25rem;
  border-radius: 12px;
  cursor: pointer;
  border: none;
  transition: background 0.2s;
  white-space: nowrap;
  font-weight: 500;
}

.portal-btn:hover {
  background: #e5e7eb;
}

.user-section {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  flex-wrap: wrap;
}

.user-greeting {
  color: #374151;
  white-space: nowrap;
  font-weight: 500;
}

.desktop-only {
  display: inline-flex;
}

.menu-toggle {
  display: none;
  width: 44px;
  height: 44px;
  border-radius: 10px;
  border: 1px solid #d1d5db;
  background: rgba(255, 255, 255, 0.95);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  cursor: pointer;
  transition: all 0.2s ease;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 5px;
  position: relative;
  z-index: 45;
  flex-shrink: 0;
}

.menu-toggle span {
  width: 20px;
  height: 2.5px;
  background: #111827;
  border-radius: 999px;
  transition: transform 0.25s ease, opacity 0.25s ease;
}

.menu-toggle:focus-visible {
  outline: 2px solid #111827;
  outline-offset: 3px;
}

.menu-checkbox:checked ~ .side-bar {
  transform: translateX(0);
}

.logout-btn {
  background: #f3f4f6;
  border: 1px solid #e5e7eb;
  padding: 0.75rem 1.25rem;
  border-radius: 12px;
  cursor: pointer;
  text-decoration: none;
  color: #374151;
  transition: all 0.2s ease;
  white-space: nowrap;
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  font-weight: 500;
}

.logout-btn:hover {
  background: #e5e7eb;
  border-color: #d1d5db;
}

.logout-icon {
  flex-shrink: 0;
  color: #dc2626;
  stroke: #dc2626;
}

/* ===== SIDEBAR STYLES ===== */
.menu-checkbox {
  display: none;
}

.menu-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(17, 24, 39, 0.55);
  backdrop-filter: blur(1px);
  z-index: 35;
  cursor: pointer;
  pointer-events: auto;
}

.menu-checkbox:checked ~ .menu-overlay {
  display: block;
}

@media (min-width: 769px) {
  .menu-overlay {
    display: none !important;
  }
}

.side-bar {
  background: #ffffff;
  width: 320px;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  overflow-y: auto;
  z-index: 40;
  border-right: 1px solid #e5e7eb;
  box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
  display: flex;
  flex-direction: column;
  transition: transform 0.3s ease;
  pointer-events: auto;
}

.sidebar-header {
  padding: 1.75rem 1.5rem;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #f9fafb;
  position: relative;
}

.sidebar-title {
  font-size: 1.375rem;
  font-weight: 700;
  color: #111827;
  margin: 0;
}

.sidebar-close {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  border: 1px solid #e5e7eb;
  background: #ffffff;
  display: none;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background 0.2s ease, border-color 0.2s ease;
  position: relative;
}

.sidebar-close span {
  position: absolute;
  width: 18px;
  height: 2px;
  background: #111827;
  border-radius: 999px;
}

.sidebar-close span:first-child {
  transform: rotate(45deg);
}

.sidebar-close span:last-child {
  transform: rotate(-45deg);
}

.sidebar-close:hover {
  background: #f3f4f6;
  border-color: #d1d5db;
}

.side-bar .menu {
  width: 100%;
  padding: 1rem 0;
  flex: 1;
}

.side-bar .menu .item {
  cursor: pointer;
  position: relative;
  pointer-events: auto;
}

.side-bar .menu .item a {
  color: #374151;
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 1.5rem;
  font-size: 1.0625rem;
  font-weight: 500;
  border-bottom: 1px solid #f3f4f6;
  transition: all 0.2s ease;
  pointer-events: auto;
  position: relative;
  z-index: 1;
}

.side-bar .menu .item a:hover {
  background: #f9fafb;
  color: #111827;
}

.side-bar .menu .item .sub-btn {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
}

.chevron-icon {
  transition: transform 0.2s ease;
  color: #6b7280;
  flex-shrink: 0;
}

.chevron-icon.rotated {
  transform: rotate(180deg);
}

.side-bar .menu .item .sub-menu {
  background: #f9fafb;
  position: relative;
  border-left: 3px solid #e5e7eb;
  margin-left: 1.5rem;
}

.side-bar .menu .item .sub-menu a {
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  font-size: 1rem;
  color: #6b7280;
  border-bottom: 1px solid #f3f4f6;
  pointer-events: auto;
  position: relative;
  z-index: 1;
}

.side-bar .menu .item .sub-menu a:hover {
  background: #f3f4f6;
  color: #111827;
  border-left-color: #000;
}

.sidebar-footer {
  padding: 1.25rem 1.5rem;
  border-top: 1px solid #e5e7eb;
  background: #f9fafb;
}

.sidebar-logout {
  width: 100%;
  padding: 1rem;
  border-radius: 10px;
  font-size: 1.0625rem;
  justify-content: flex-start;
  background: #ffffff;
  border: 1px solid #e5e7eb;
  color: #374151;
}

.sidebar-logout:hover {
  background: #f3f4f6;
  border-color: #d1d5db;
}

/* ===== MAIN CONTENT ===== */
.main-content {
  flex: 1;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  overflow-x: hidden;
  margin-left: 320px;
  width: calc(100% - 320px);
  transition: margin-left 0.3s ease, width 0.3s ease;
}

/* ===== PAGE HEADER ===== */
.page-header { 
  padding: 2rem 1.75rem 1.25rem; 
}

.page-header h2 { 
  margin: 0 0 0.75rem; 
  color: #111827;
  font-weight: 700;
}

.page-header p { 
  color: #6b7280; 
  line-height: 1.6;
  max-width: 800px;
}

/* ===== STATS CONTAINER ===== */
.stats-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.5rem;
  padding: 1.5rem 1.75rem;
  flex-wrap: wrap;
}

.stat-card {
  background: #fff;
  border-radius: 16px;
  padding: 2rem 1.5rem;
  text-align: center;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border: 1px solid #f3f4f6;
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.stat-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.stat-card h3 {
  margin: 0.75rem 0 0;
  font-size: 2.25rem;
  font-weight: 700;
  color: #111827;
}

.stat-card p {
  color: #6b7280;
  font-size: 1.125rem;
  margin-top: 0.5rem;
  font-weight: 500;
}

/* ===== SECTION HEADER ===== */
.section-header {
  padding: 0 1.75rem 1.25rem;
  margin-bottom: 0.5rem;
  flex-wrap: wrap;
  gap: 1rem;
}

.section-header h3 {
  font-size: 1.375rem;
  font-weight: 600;
  color: #111827;
  margin: 0 0 0.5rem 0;
}

.section-description {
  font-size: 1rem;
  color: #6b7280;
  margin: 0;
  line-height: 1.5;
}

/* ===== SEARCH AND SORT ===== */
.search-sort-container {
  display: flex;
  gap: 1.25rem;
  padding: 0 1.75rem 1.5rem;
  margin-bottom: 0.5rem;
  flex-wrap: wrap;
  align-items: center;
}

.search-wrapper {
  position: relative;
  flex: 1;
  min-width: 280px;
  display: flex;
  align-items: center;
}

.search-icon {
  position: absolute;
  left: 1.125rem;
  color: #6b7280;
  pointer-events: none;
  z-index: 1;
}

.search-input {
  width: 100%;
  padding: 1rem 1.125rem 1rem 3.25rem;
  border: 1.5px solid #e1e5e9;
  border-radius: 12px;
  font-size: 1.0625rem;
  background: #fff;
  transition: all 0.3s ease;
}

.search-input:focus {
  border-color: #000;
  outline: none;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

.search-input::placeholder {
  color: #9ca3af;
}

.sort-wrapper {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.sort-label {
  font-size: 1.0625rem;
  font-weight: 500;
  color: #374151;
  white-space: nowrap;
}

.sort-select {
  padding: 1rem 1.125rem;
  border: 1.5px solid #e1e5e9;
  border-radius: 12px;
  font-size: 1.0625rem;
  background: #fff;
  cursor: pointer;
  transition: all 0.3s ease;
  min-width: 200px;
}

.sort-select:focus {
  border-color: #000;
  outline: none;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

.results-count {
  padding: 0.75rem 1.75rem;
  font-size: 1rem;
  color: #6b7280;
  margin-bottom: 0.5rem;
}

/* ===== TEACHER CONTAINER ===== */
.teacher-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 1.75rem;
  padding: 0 1.75rem 3rem;
}

.card {
  border: 1px solid #e1e5e9;
  border-radius: 16px;
  padding: 1.75rem;
  background: #fff;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
}

.card:hover {
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  transform: translateY(-5px);
}

.card h3 {
  font-size: 1.25rem;
  margin-bottom: 0.5rem;
  font-weight: 600;
  color: #111827;
}

.card p {
  font-size: 1.0625rem;
  color: #6b7280;
  margin-bottom: 0.75rem;
  line-height: 1.5;
  flex: 1;
}

/* ===== BADGES ===== */
.badge {
  display: inline-block;
  background: #f1f3f5;
  padding: 0.5rem 1.125rem;
  font-size: 0.9375rem;
  border-radius: 20px;
  margin: 0 5px 10px 0;
  font-weight: 600;
  color: #374151;
}

/* ===== CARD BUTTONS ===== */
.card-button-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: auto;
  padding-top: 1.25rem;
}

.card .start,
.card .update,
.btn-delete {
  width: 100%;
  padding: 1rem 1.25rem;
  border: 1.5px solid #e1e5e9;
  border-radius: 12px;
  cursor: pointer;
  font-weight: 600;
  font-size: 1.0625rem;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
}

.card .start {
  background: #000;
  color: #fff;
  border-color: #000;
}

.card .start:hover {
  background: #1a1a1a;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.card .update {
  background: #fff;
  color: #333;
  border-color: #e1e5e9;
}

.card .update:hover {
  background: #f9fafb;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-delete {
  background: #fff;
  color: #dc2626;
  border-color: #dc2626;
}

.btn-delete:hover {
  background: #dc2626;
  color: #fff;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
}

.btn-icon {
  flex-shrink: 0;
}

/* ===== NO RESULTS ===== */
.no-results {
  grid-column: 1 / -1;
  text-align: center;
  padding: 4rem 1.75rem;
  color: #6b7280;
  background: #f9fafb;
  border-radius: 16px;
  border: 1px dashed #e5e7eb;
}

.no-results p {
  font-size: 1.25rem;
  margin: 0;
  font-weight: 500;
}

/* ===== FORM STYLES ===== */
.content {
  padding: 1.5rem 1.75rem;
  min-height: 100vh;
}

.container {
  max-width: 1000px;
  margin: 0 auto;
}

.form-header {
  margin-bottom: 2.5rem;
  padding-bottom: 1.75rem;
  border-bottom: 1px solid #e5e7eb;
}

.form-title {
  font-size: 1.75rem;
  font-weight: 700;
  color: #111827;
  margin: 0 0 0.75rem 0;
}

.form-subtitle {
  font-size: 1.125rem;
  color: #6b7280;
  margin: 0;
  line-height: 1.5;
}

.create-teacher-form {
  max-width: 1000px;
}

.wrong {
  color: #d32f2f;
  background: #ffebee;
  padding: 1rem 1.25rem;
  border-radius: 12px;
  margin-bottom: 2rem;
  font-weight: 600;
  text-align: center;
  border: 1px solid #ffcdd2;
  font-size: 1.0625rem;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.75rem;
  margin-bottom: 2.5rem;
}

.form-group {
  margin-bottom: 0;
}

.form-group label {
  display: block;
  margin-bottom: 0.75rem;
  color: #374151;
  font-weight: 600;
  font-size: 1.0625rem;
}

.required {
  color: #dc2626;
  margin-left: 2px;
}

.form-group input,
.form-group select {
  width: 100%;
  max-width: 100%;
  padding: 1rem 1.125rem;
  border: 1.5px solid #e1e5e9;
  border-radius: 12px;
  font-size: 1.0625rem;
  background: #fff;
  transition: all 0.3s ease;
}

.form-group input:focus,
.form-group select:focus {
  border-color: #000;
  outline: none;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

.form-actions {
  display: flex;
  justify-content: flex-start;
  padding-top: 2rem;
  border-top: 1px solid #e5e7eb;
  margin-top: 1rem;
  gap: 1rem;
}

.btn-primary {
  background: #000;
  color: #fff;
  border: none;
  padding: 1rem 2rem;
  border-radius: 12px;
  font-weight: 600;
  font-size: 1.125rem;
  cursor: pointer;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
}

.btn-primary:hover {
  background: #1a1a1a;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-secondary {
  background: #f3f4f6;
  color: #374151;
  border: 1px solid #e5e7eb;
  padding: 1rem 2rem;
  border-radius: 12px;
  font-weight: 600;
  font-size: 1.125rem;
  cursor: pointer;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
}

.btn-secondary:hover {
  background: #e5e7eb;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.edit-form-container {
  grid-column: 1 / -1;
}

/* ===== FEEDBACK MESSAGES ===== */
.success,
.error {
  position: fixed;
  top: 20px;
  left: 50%;
  transform: translateX(-50%);
  padding: 1.25rem 2rem;
  border-radius: 12px;
  font-weight: 600;
  z-index: 1000;
  text-align: center;
  min-width: 350px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  animation: slideIn 0.3s ease-out;
  font-size: 1.0625rem;
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

/* ===== LOADING SCREEN ===== */
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
  border: 5px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top: 5px solid #ffffff;
  width: 60px;
  height: 60px;
  animation: spin 1s linear infinite;
  margin-bottom: 1.5rem;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
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

/* ===== MODAL STYLES ===== */
.main-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
  z-index: 2000;
  overflow-y: auto;
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
  max-width: 80rem;
  max-height: 90vh;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: auto;
}

.modal-content {
  width: 100%;
  max-width: 72rem;
  border-radius: 16px;
  background-color: #f8fafc;
  padding: 2rem;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
  overflow-y: auto;
  max-height: 90vh;
}

.left-column {
  display: flex;
  flex-direction: column;
  gap: 2.5rem;
}

.profile-section {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
}

@media (min-width: 640px) {
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

@media (min-width: 640px) {
  .profile-image-container {
    justify-content: flex-start;
  }
}

.profile-image {
  width: 12rem;
  height: 12rem;
  background-color: #e2e8f0;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.profile-icon {
  font-size: 4.5rem;
  color: #9ca3af;
}

.profile-details {
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 1.25rem;
}

.detail-item {
  margin-bottom: 0.75rem;
}

.detail-label {
  font-weight: 600;
  color: #6b7280;
  display: block;
  font-size: 1.0625rem;
}

.detail-value {
  margin-top: 0.5rem;
  font-weight: 700;
  font-size: 1.25rem;
  color: #111827;
}

.info-section {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.info-item {
  margin-bottom: 0.75rem;
}

.info-label {
  font-weight: 600;
  color: #6b7280;
  display: block;
  font-size: 1.0625rem;
}

.info-value {
  margin-top: 0.5rem;
  font-weight: 700;
  font-size: 1.25rem;
  color: #111827;
}

.buttons-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1.25rem;
  padding-top: 1.5rem;
}

.action-button {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding: 1rem 1.25rem;
  font-size: 1.0625rem;
  font-weight: 600;
  color: #374151;
  background-color: #ffffff;
  border: 1.5px solid #d1d5db;
  border-radius: 12px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  cursor: pointer;
  transition: all 0.3s ease-in-out;
}

.action-button:hover {
  background-color: #f3f4f6;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.action-button:focus {
  outline: none;
  box-shadow: 0 0 0 3px #0f172a, 0 0 0 5px rgba(15, 23, 42, 0.1);
}

/* ===== RESPONSIVE DESIGN ===== */

/* Tablet */
@media (max-width: 1024px) {
  .main-content {
    margin-left: 0;
    width: 100%;
  }
  
  .side-bar {
    transform: translateX(-100%);
    box-shadow: 2px 0 24px rgba(15, 23, 42, 0.15);
  }
  
  .menu-toggle {
    display: flex;
  }
  
  .sidebar-close {
    display: flex;
  }
  
  .form-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
  
  .teacher-container {
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  }
}

@media (max-width: 768px) {
  .topbar {
    padding: 1rem;
    flex-direction: column;
    align-items: stretch;
    gap: 1rem;
  }
  
  .title-row {
    flex-wrap: wrap;
  }
  
  .title-actions .portal-btn {
    display: none;
  }
  
  .user-section {
    width: 100%;
    justify-content: space-between;
    gap: 1rem;
  }
  
  .desktop-only {
    display: none;
  }
  
  .user-greeting {
    display: none;
  }
  
  .page-header {
    padding: 1.5rem 1rem 1rem;
  }
  
  .stats-container {
    grid-template-columns: 1fr;
    gap: 1rem;
    padding: 1rem;
  }
  
  .stat-card {
    padding: 1.5rem 1rem;
  }
  
  .section-header,
  .search-sort-container {
    padding: 0 1rem 1rem;
  }
  
  .search-sort-container {
    flex-direction: column;
    gap: 1rem;
  }
  
  .search-wrapper {
    width: 100%;
    min-width: unset;
  }
  
  .sort-wrapper {
    width: 100%;
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
  }
  
  .sort-select {
    width: 100%;
    min-width: unset;
  }
  
  .results-count {
    padding: 0.5rem 1rem;
  }
  
  .teacher-container {
    grid-template-columns: 1fr;
    gap: 1rem;
    padding: 0 1rem 2rem;
  }
  
  .card {
    padding: 1.25rem;
  }
  
  .content {
    padding: 1rem;
  }
  
  .form-header {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
  }
  
  .form-title {
    font-size: 1.5rem;
  }
  
  .form-actions {
    flex-direction: column;
    gap: 0.75rem;
  }
  
  .btn-primary,
  .btn-secondary {
    width: 100%;
    justify-content: center;
  }
  
  .modal-container {
    padding: 1rem;
  }
  
  .modal-content {
    padding: 1.5rem;
  }
  
  .profile-section {
    grid-template-columns: 1fr;
    text-align: center;
  }
  
  .profile-details {
    text-align: center;
  }
  
  .buttons-grid {
    grid-template-columns: 1fr;
  }
  
  .side-bar {
    width: min(300px, 85%);
  }
}

/* Mobile */
@media (max-width: 480px) {
  .logo {
    font-size: 1.125rem;
  }
  
  h1 { font-size: 1.625rem; }
  h2 { font-size: 1.375rem; }
  h3 { font-size: 1.25rem; }
  
  .stat-card h3 {
    font-size: 1.75rem;
  }
  
  .stat-icon {
    font-size: 2.5rem;
  }
  
  .card h3 {
    font-size: 1.125rem;
  }
  
  .card p {
    font-size: 1rem;
  }
  
  .success,
  .error {
    min-width: 280px;
    padding: 1rem 1.25rem;
    left: 0.625rem;
    right: 0.625rem;
    transform: translateX(0);
    margin: 0 auto;
  }
  
  .side-bar {
    width: 100%;
  }
  
  .profile-image {
    width: 10rem;
    height: 10rem;
    margin: 0 auto;
  }
  
  .profile-icon {
    font-size: 4rem;
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
.action-button:focus-visible {
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
</style> 