<template>
  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <div class="container">
    <div class="logo">
      <!-- LOGO CHANGE - Lines below -->
      <div class="logo-image">
        <img src="../assets/logo2.png" alt="Project EVAL Logo" />
      </div>
      <h1>EduRate</h1>
      <p class="tagline">“Reflect, Improve, Inspire!”</p>
      <p class="instruction">
        Select your role to access the evaluation platform
      </p>
    </div>

    <div class="cards-container">
      <div class="card student">
        <div class="icon">
          <i class="fas fa-user-graduate"></i>
        </div>
        <h2>Student</h2>
        <p>
          Evaluate your teachers and provide feedback on their teaching methods
          and course content.
        </p>
        <button class="btn student-btn" @click="toggleModal('student')">
          Access Student Portal
        </button>
      </div>

      <div class="card teacher">
        <div class="icon"></div>
        <h2>Teacher</h2>
        <p>
          Evaluate your colleagues and peers to foster professional growth and
          collaboration.
        </p>
        <button class="btn teacher-btn" @click="toggleModal('teacher')">
          Access Teacher Portal
        </button>
      </div>

      <div class="card admin">
        <div class="icon"></div>
        <h2>Admin</h2>
        <p>
          Evaluate teachers, manage assessments, and oversee the evaluation
          process.
        </p>
        <button class="btn admin-btn" @click="toggleModal('admin')">
          Access Admin Portal
        </button>
      </div>
    </div>
  </div>

  <!-- Student Modal -->
  <div class="modal student-modal" v-if="activeModal === 'student'">
    <div class="modal-content">
      <span class="close-modal" @click="closeModal()">&times;</span>
      <!--ito yung button sa close palitan ng method-->
      <div class="modal-header">
        <div class="modal-icon"></div>
        <h2>Student Portal</h2>
        <p>Login or create a new account</p>
      </div>

      <div class="tabs">
        <button
          class="tab-btn"
          :class="{ active: activeTab === 'login' }"
          @click="activeTab = 'login'"
        >
          Login
        </button>
        <button
          class="tab-btn"
          :class="{ active: activeTab === 'register' }"
          @click="activeTab = 'register'"
        >
          Register
        </button>
      </div>

      <div class="tab-content" v-if="activeTab === 'login'">
        <!--login-->
        <form method="post" @submit.prevent="login">
          <div class="form-group">
            <div v-if="isWrong" class="wrong">
              <p class="wrong">Wrong Credentials or Incomplete</p>
            </div>
            <label for="studentId">Student ID:</label>
            <input
              type="text"
              v-model="studentl.id"
              placeholder="Enter your student ID"
              required
            />
          </div>
          <div class="form-group">
            <label for="studentPassword">Password:</label>
            <input
              type="password"
              v-model="studentl.ps"
              placeholder="Enter your password"
              required
            />
          </div>
          <div class="remember-forgot">
            <div class="forgot-password">
              <a @click="toggleModal('fgps')" style="cursor: pointer"
                >Forgot Password?</a
              >
            </div>
          </div>
          <div
            style="
              display: flex;
              justify-content: center;
              align-items: center;
              width: 100%;
              padding: 10px 0;
            "
          >
            <div
              ref="turnstileWidgetStudent"
              class="cf-turnstile"
              style="
                width: 100% !important;
                max-width: 100% !important;
                display: flex;
                justify-content: center;
              "
            ></div>
          </div>
          <button type="submit" class="modal-btn">Login</button>
        </form>
      </div>

      <div class="tab-content" v-if="activeTab === 'register'">
        <!--register-->
        <form method="post" @submit.prevent="signup()">
          <div v-if="isWrong" class="wrong">
            <p class="wrong">Wrong Credentials or Incomplete</p>
          </div>
          <div class="form-group">
            <label for="studentName">First Name:</label>
            <input
              type="text"
              v-model="studentr.fn"
              placeholder="Enter your first name"
              required
            />
          </div>
          <div class="form-group">
            <label for="studentName">Last Name:</label>
            <input
              type="text"
              v-model="studentr.ln"
              placeholder="Enter your last name"
              required
            />
          </div>
          <div class="form-group">
            <label for="studentEmail">Email Address:</label>
            <input
              type="email"
              v-model="studentr.em"
              placeholder="Enter your email"
              required
            />
          </div>
          <div class="form-group">
            <label for="studentIdRegister">Student ID:</label>
            <input
              type="text"
              v-model="studentr.id"
              placeholder="Enter your student ID"
              required
            />
          </div>
          <div class="form-group">
            <label for="studentPasswordRegister">Password:</label>
            <input
              type="password"
              v-model="studentr.pass"
              minlength="8"
              placeholder="Create a password"
              required
            />
          </div>
          <div class="form-group">
            <label for="studentConfirmPassword">Confirm Password:</label>
            <input
              type="password"
              v-model="studentr.conpass"
              placeholder="Confirm your password"
              required
            />
          </div>
          <button type="submit" class="modal-btn">Create Account</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Teacher Modal -->
  <div class="modal teacher-modal" v-if="activeModal === 'teacher'">
    <div class="modal-content">
      <span class="close-modal" @click="closeModal()">&times;</span>
      <div class="modal-header">
        <div class="modal-icon"></div>
        <h2>Teacher Portal</h2>
        <p>Login to your account</p>
        <br />
        <p>
          <i>If you do not have an account yet visit the admin office.</i>
        </p>
        <br />
      </div>

      <div class="tab-content" v-if="activeTab === 'login'">
        <form method="post" @submit.prevent="login">
          <div v-if="isWrong" class="wrong">
            <p class="wrong">Wrong Credentials or Incomplete</p>
          </div>
          <div class="form-group">
            <label for="teacherId">Email: </label>
            <input
              type="text"
              v-model="teacherl.id"
              placeholder="Enter your teacher Email"
              required
            />
          </div>
          <div class="form-group">
            <label for="teacherPassword">Password:</label>
            <input
              type="password"
              v-model="teacherl.ps"
              placeholder="Enter your password"
              required
            />
          </div>
          <div class="remember-forgot">
            <div class="forgot-password">
              <a @click="toggleModal('fgps')" style="cursor: pointer"
                >Forgot Password?</a
              >
            </div>
          </div>
          <div
            style="
              display: flex;
              justify-content: center;
              align-items: center;
              width: 100%;
              padding: 10px 0;
            "
          >
            <div
              class="cf-turnstile"
              ref="turnstileWidgetTeacher"
              style="
                width: 100% !important;
                max-width: 100% !important;
                display: flex;
                justify-content: center;
              "
            ></div>
          </div>

          <button type="submit" class="modal-btn">
            Login to Teacher Portal
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Admin Modal -->
  <div class="modal admin-modal" v-if="activeModal === 'admin'">
    <div class="modal-content">
      <span class="close-modal" @click="closeModal()">&times;</span>
      <div class="modal-header">
        <div class="modal-icon"></div>
        <h2>Administrator Portal</h2>
        <p>Login to your account</p>
      </div>

      <div class="tab-content active">
        <form method="post" @submit.prevent="login">
          <div v-if="isWrong" class="wrong">
            <p class="wrong">Wrong Credentials or Incomplete</p>
          </div>
          <div class="form-group">
            <label for="adminId">Admin ID</label>
            <input
              type="text"
              v-model="admin.id"
              placeholder="Enter your admin ID"
              required
            />
          </div>
          <div class="form-group">
            <label for="adminPassword">Password</label>
            <input
              type="password"
              v-model="admin.ps"
              placeholder="Enter your password"
              required
            />
          </div>
          <div class="remember-forgot">
            <div class="forgot-password">
              <a @click="toggleModal('fgps')" style="cursor: pointer"
                >Forgot Password?</a
              >
            </div>
          </div>
          <div
            style="
              display: flex;
              justify-content: center;
              align-items: center;
              width: 100%;
              padding: 10px 0;
            "
          >
            <div
              ref="turnstileWidgetAdmin"
              class="cf-turnstile"
              style="
                width: 100% !important;
                max-width: 100% !important;
                display: flex;
                justify-content: center;
              "
            ></div>
          </div>

          <button type="submit" class="modal-btn">Login to Admin Portal</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Forgot Password Modal -->
  <div class="modal" v-if="activeModal === 'fgps'">
    <div class="modal-content">
      <span class="close-modal" @click="closeModal()">&times;</span>
      <div class="modal-header">
        <div class="modal-icon"></div>
        <h2>Reset Password</h2>
        <p>Enter your email to receive a password reset code</p>
      </div>
      <form id="forgotPasswordForm" method="post" @submit.prevent="fgps()">
        <div class="form-group">
          <label for="resetEmail">Email Address</label>
          <input
            type="email"
            v-model="newPassword.email"
            placeholder="Enter your email"
            required
          />
        </div>
        <button type="submit" class="modal-btn">Send Reset Code</button>
      </form>
    </div>
  </div>

  <div class="modal" v-if="activeModal === 'code'">
    <div class="modal-content">
      <span class="close-modal" @click="closeModal()">&times;</span>
      <div class="modal-header">
        <div class="modal-icon"></div>
        <h2>Reset Password</h2>
        <p>We have sent an E-Mail to your inbox containing the code</p>
      </div>
      <form id="forgotPasswordForm" method="post" @submit.prevent="codes()">
        <div class="form-group">
          <label for="resetEmail">Code</label>
          <input
            type="text"
            v-model="newPassword.code"
            placeholder="Enter the code"
            required
          />
        </div>
        <button type="submit" class="modal-btn">Enter Reset Code</button>
      </form>
    </div>
  </div>

  <div class="modal" v-if="activeModal === 'password'">
    <div class="modal-content">
      <span class="close-modal" @click="closeModal()">&times;</span>
      <div class="modal-header">
        <div class="modal-icon"></div>
        <h2>Reset Password</h2>
        <p>Enter your new password</p>
      </div>
      <form id="forgotPasswordForm" method="post" @submit.prevent="passwords()">
        <div class="form-group">
          <label for="resetEmail">New Password</label>
          <input
            type="password"
            v-model="newPassword.newPasswords"
            placeholder="Enter your new password"
            required
          /><!--vmodel dito-->
          <br />
          <br />

          <label for="condirmpass">Confirm Password</label>
          <input
            type="password"
            v-model="newPassword.confirmPassword"
            placeholder="Confirm your new password"
            required
          /><!--vmodel dito-->
        </div>
        <button type="submit" class="modal-btn">Reset Password</button>
      </form>
    </div>
  </div>
</template>

<script>
import { setToken, getToken } from "../utils/auth";

const url1 = "https://rusiann7.helioho.st";
const url2 = "https://star-panda-literally.ngrok-free.app";
//const url2 = "http://localhost:8000";
export default {
  name: "newDashboard",
  data() {
    return {
      activeModal: "",
      activeTab: "login",
      loginphp: `${url2}/login.php`,
      signupphp: `${url2}/register.php`,
      loginteacherphp: `${url2}/login-t.php`,
      loginadminphp: `${url2}/login-a.php`,
      forgetpassword: `${url2}/reset.php`,
      password: `${url2}/password.php`,
      code: `${url2}/code.php`,
      studentl: { id: "", ps: "" },
      studentr: { fn: "", ln: "", em: "", id: "", pass: "", conpass: "" },
      teacherl: { id: "", ps: "" },
      admin: { id: "", ps: "" },
      newPassword: {
        newPasswords: "",
        confirmPassword: "",
        email: "",
        code: "",
      },
      isLoading: false,
      isWrong: false,
      captcha: false,
    };
  },

  methods: {
    async login() {
      if (!this.captcha) {
        return;
      }

      this.isLoading = true;

      try {
        let type = null;
        let site = null;
        let url = null;

        switch (this.activeModal) {
          case "student":
            type = "studentl";
            site = "/student";
            url = this.loginphp;
            break;

          case "admin":
            type = "admin";
            site = "/principal";
            url = this.loginadminphp;
            break;

          default:
            type = "teacherl";
            site = "/teacher";
            url = this.loginteacherphp;
            break;
        }

        const response = await fetch(url, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            email: this[type].id,
            password: this[type].ps,
            action: "login",
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.isWrong = false;
          if (result.token) {
            setToken(result.token); //verify the token
          } else {
            console.error("No token received from server.");
            this.isLoading = false;
            return;
          }

          localStorage.setItem("userData", JSON.stringify(result.userData));
          this[type] = { id: "", ps: "" };

          this.isLoading = false;
          this.$router.replace(site); //router routes the user to the page
        } else {
          this.responseMessage = result.error;
          this.isWrong = true;
          this.isLoading = false;
        }
      } catch (error) {
        console.error("Login error:", error);
        this.isLoading = false;
      }
    },

    async signup() {
      if (this.studentr.pass === this.studentr.conpass) {
        try {
          this.isLoading = true;

          const response = await fetch(this.signupphp, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              ...this.studentr,
              action: "signup",
            }),
          });

          const result = await response.json();
          if (result.success) {
            this.responseMessage = result.message;
            this.activeTab = "login";
            this.isLoading = false;
            this.studentr = {
              fn: "",
              ln: "",
              em: "",
              id: "",
              pass: "",
              conpass: "",
            };
          } else {
            this.isLoading = false;
            console.error("server error: ", error);
          }
        } catch (error) {
          this.isLoading = false;
          console.error("Signup error:", error);
        }
      } else {
        this.isWrong = true;
      }
    },

    async fgps() {
      try {
        this.isLoading = true;

        const response = await fetch(this.forgetpassword, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            action: "reset",
            email: this.newPassword.email,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.isLoading = false;
          this.activeModal = "code";
        }
      } catch (error) {
        console.error("Signup error:", error);
      }
    },

    async passwords() {
      if (this.newPassword.newPasswords === this.newPassword.confirmPassword) {
        try {
          this.isLoading = true;

          const response = await fetch(this.password, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              action: "password",
              passwordss: this.newPassword.newPasswords,
              conpassword: this.newPassword.confirmPassword,
              email: this.newPassword.email,
            }),
          });
          const result = await response.json();

          if (result.success) {
            this.isLoading = false;
            this.activeModal = "student";
            this.activeTab = "login";
          }
        } catch (error) {
          console.error("Signup error:", error);
        }
      } else {
        this.newPassword = { newPasswords: "", confirmPassword: "" };
        alert("Password missmatch");
        return;
      }
    },

    async codes() {
      try {
        this.isLoading = true;

        const response = await fetch(this.code, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            action: "code",
            code: this.newPassword.code,
            email: this.newPassword.email,
          }),
        });

        const result = await response.json();

        if (result.success) {
          this.isLoading = false;
          this.activeModal = "password";
        }
      } catch (error) {}
    },

    async captchaVerify() {
      try {
        if (document.cookie.includes("cf_verified=1")) {
          this.captcha = true;
        }
      } catch (error) {
        console.error("Error verifying captcha:", error);
      }
    },

    skipLogin() {
      const token = getToken();

      if (!token) {
        console.error("No token found, redirecting to login.");
        this.$router.replace("/new-Dashboard");
        return;
      } else {
        this.login();
      }
    },

    toggleModal(modal) {
      this.activeModal = modal;
      this.isWrong = false;
    },

    closeModal() {
      this.activeModal = null;
      this.activeTab = "login";
    },

    notify() {
      if (Notification.permission === "granted") {
        console.log("Notification: ", Notification.permission);
      } else {
        Notification.requestPermission().then((permission) => {
          if (permission === "granted") {
            console.log("Notification: ", Notification.permission);
          }
        });
      }
    },
  },

  mounted() {
    if (!document.querySelector('script[src*="cloudflare.com/turnstile"]')) {
      const script = document.createElement("script");
      script.src = "https://challenges.cloudflare.com/turnstile/v0/api.js";
      script.async = true;
      script.defer = true;
      document.head.appendChild(script);
    }

    window.onTurnstileSuccess = (token) => {
      document.cookie = "cf_verified=1; path=/; max-age=10800";
      this.captcha = true;
    };

    this.notify();
  },

  watch: {
    activeModal(newVal) {
      this.$nextTick(() => {
        setTimeout(() => {
          const ref =
            this.$refs[
              newVal === "student"
                ? "turnstileWidgetStudent"
                : newVal === "teacher"
                ? "turnstileWidgetTeacher"
                : newVal === "admin"
                ? "turnstileWidgetAdmin"
                : null
            ];

          if (!ref || !window.turnstile) {
            console.warn("Turnstile ref or global turnstile not available");
            return;
          }

          ref.innerHTML = "";

          window.turnstile.render(ref, {
            sitekey: "0x4AAAAAAB75cNLp9r6mKKXd",
            callback: () => (
              (document.cookie = "cf_verified=1; path=/; max-age=10800"),
              (this.captcha = true)
            ),
            theme: "light",
          });
        }, 300);
      });
    },
  },
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

.container {
  /* Responsive base font-size for readability across devices */
  font-size: clamp(16px, 1.6vw, 20px);
  line-height: 1.45;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 1rem 0.75rem;
  color: #fff;
  width: 100%;
  min-height: 100vh;
  background-image: linear-gradient(rgba(12, 89, 4, 0.8), rgba(3, 66, 78, 0.9));
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}

.logo {
  margin-bottom: 40px;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
}

.logo-image {
  width: 8rem; /* ~128px */
  height: 8rem;
  border-radius: 50%;
  object-fit: cover;
  border: 0.3rem solid #fff;
  box-shadow: 0 8px 18px rgba(0, 0, 0, 0.32);
  margin-bottom: 1.25rem;
  background-color: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
}

/* Added for logo image styling */
.logo-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.logo h1 {
  font-size: clamp(1.8rem, 4vw, 3.4rem);
  font-weight: 700;
  margin-bottom: 0.6rem;
  color: #fff;
  text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.5);
}

.tagline {
  font-size: clamp(1rem, 2vw, 1.4rem);
  margin-bottom: 0.6rem;
  text-align: center;
  max-width: 900px;
  line-height: 1.6;
  color: #e0f7fa;
  font-weight: 500;
}

.instruction {
  color: #e0e0e0;
  margin-top: 0.8rem;
  font-size: clamp(0.98rem, 1.4vw, 1.15rem);
  text-align: center;
}

.cards-container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 2rem;
  width: 100%;
  margin-top: 1.25rem;
}

.card {
  background: rgba(255, 255, 255, 0.98);
  border-radius: 0.9rem;
  padding: 1.6rem;
  flex: 0 1 20rem; /* flexible base width */
  max-width: calc(100% - 2rem);
  text-align: center;
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18);
  transition: transform 0.28s ease, box-shadow 0.28s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
}

.icon {
  font-size: 3.2rem;
  margin-bottom: 1.1rem;
  height: 5.2rem;
  width: 5.2rem;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.student .icon {
  background-color: rgba(74, 109, 167, 0.2);
  color: #4a6da7;
}

.teacher .icon {
  background-color: rgba(71, 167, 106, 0.2);
  color: #47a76a;
}

.admin .icon {
  background-color: rgba(199, 80, 80, 0.2);
  color: #c75050;
}

h2 {
  color: #2c3e50;
  margin-bottom: 0.9rem;
  font-size: clamp(1.4rem, 2.2vw, 2.2rem);
}

.card p {
  color: #555;
  margin-bottom: 1.25rem;
  line-height: 1.7;
  flex-grow: 1;
  font-size: clamp(1rem, 1.4vw, 1.12rem);
}

.btn {
  display: inline-block;
  background: #2c3e50;
  color: white;
  padding: 1rem 1.8rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 700;
  transition: all 0.25s ease;
  border: none;
  cursor: pointer;
  width: 85%;
  font-size: clamp(1rem, 1.5vw, 1.2rem);
}

.btn:hover {
  transform: scale(1.05);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.student .btn {
  background: #4a6da7;
}

.student .btn:hover {
  background: #3a5a8f;
}

.teacher .btn {
  background: #47a76a;
}

.teacher .btn:hover {
  background: #3a8f58;
}

.admin .btn {
  background: #c75050;
}

.admin .btn:hover {
  background: #a83c3c;
}

/* Modal Styles */
.modal {
  display: flex;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  justify-content: center;
  align-items: center;
  z-index: 2000;
}

.modal-content {
  background: white;
  border-radius: 1rem;
  width: 94%;
  max-width: 720px;
  padding: 1.4rem;
  box-shadow: 0 18px 48px rgba(0, 0, 0, 0.28);
  transform: translateY(-30px);
  transition: transform 0.35s ease;
  position: relative;
  max-height: 92vh;
  overflow-y: auto;
}

.close-modal {
  position: absolute;
  top: 0.8rem;
  right: 0.8rem;
  font-size: 1.5rem;
  color: #888;
  cursor: pointer;
  transition: color 0.25s ease;
}

.close-modal:hover {
  color: #333;
}

.modal-header {
  text-align: center;
  margin-bottom: 20px;
  padding: 0 10px;
}

.modal-icon {
  font-size: clamp(1.6rem, 2.6vw, 2.5rem);
  margin-bottom: 15px;
}

.student-modal .modal-icon {
  color: #4a6da7;
}

.teacher-modal .modal-icon {
  color: #47a76a;
}

.admin-modal .modal-icon {
  color: #c75050;
}

.modal-header h2 {
  color: #2c3e50;
  margin-bottom: 10px;
  font-size: clamp(1.1rem, 2vw, 1.8rem);
}

.modal-header p {
  color: #666;
  font-size: clamp(0.98rem, 1.2vw, 1.12rem);
}

/* Tab Styles */
.tabs {
  display: flex;
  margin-bottom: 1rem;
  border-bottom: 1px solid #e6e6e6;
}

.tab-btn {
  flex: 1;
  padding: 0.7rem 0.6rem;
  background: none;
  border: none;
  cursor: pointer;
  font-size: clamp(1rem, 1.4vw, 1.05rem);
  font-weight: 600;
  color: #888;
  transition: all 0.22s ease;
  border-bottom: 3px solid transparent;
}

.tab-btn.active {
  color: #2c3e50;
  border-bottom: 3px solid;
}

.student-modal .tab-btn.active {
  color: #4a6da7;
  border-bottom-color: #4a6da7;
}

.teacher-modal .tab-btn.active {
  color: #47a76a;
  border-bottom-color: #47a76a;
}

.admin-modal .tab-btn.active {
  color: #c75050;
  border-bottom-color: #c75050;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  color: #444;
  font-weight: 600;
  text-align: left;
  font-size: clamp(0.98rem, 1.2vw, 1.05rem);
}

.form-group input {
  width: 100%;
  padding: 0.95rem 1rem;
  border: 1px solid #e3e3e3;
  border-radius: 0.6rem;
  font-size: clamp(1rem, 1.2vw, 1.05rem);
  transition: border-color 0.2s ease;
}

.form-group input:focus {
  border-color: #4a6da7;
  outline: none;
}

.remember-forgot {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.forgot-password a {
  color: #4a6da7;
  text-decoration: none;
  font-size: clamp(0.95rem, 1.2vw, 1rem);
}

.forgot-password a:hover {
  text-decoration: underline;
}

.modal-btn {
  width: 100%;
  padding: 1rem;
  border: none;
  border-radius: 0.7rem;
  color: white;
  font-size: clamp(1rem, 1.6vw, 1.15rem);
  font-weight: 700;
  cursor: pointer;
  transition: background 0.22s ease, transform 0.15s ease;
}

.modal-btn:hover {
  transform: translateY(-2px);
}

.student-modal .modal-btn {
  background: #4a6da7;
}

.student-modal .modal-btn:hover {
  background: #3a5a8f;
}

.teacher-modal .modal-btn {
  background: #47a76a;
}

.teacher-modal .modal-btn:hover {
  background: #3a8f58;
}

.admin-modal .modal-btn {
  background: #c75050;
}

.admin-modal .modal-btn:hover {
  background: #a83c3c;
}

.switch-form a:hover {
  text-decoration: underline;
}

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
  width: 3.2rem;
  height: 3.2rem;
  animation: spin 1s linear infinite;
  margin-bottom: 0.6rem;
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

.wrong {
  color: red;
  margin-bottom: 10px;
  font-weight: bold;
  text-align: center;
}

@media (max-width: 900px) {
  .cards-container {
    flex-direction: column;
    align-items: center;
  }

  .card {
    width: 100%;
    max-width: 520px;
    margin-bottom: 1rem;
    padding: 1.25rem;
  }

  .logo h1 {
    font-size: 2.2rem;
  }

  .tagline {
    font-size: 1.05rem;
  }

  .modal-content {
    width: calc(100% - 2rem);
    max-width: 520px;
  }
}

@media (max-width: 600px) {
  .container { font-size: 15.5px; }

  .logo h1 {
    font-size: clamp(1.6rem, 6vw, 2.2rem);
  }

  .tagline {
    font-size: clamp(0.95rem, 2.8vw, 1.05rem);
  }

  .instruction {
    font-size: 0.98rem;
  }

  .card {
    padding: 0.9rem;
  }

  .logo-image {
    width: 6.25rem;
    height: 6.25rem;
  }
}

@media (min-width: 1100px) {
  .cards-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    align-items: start;
    max-width: 1200px;
    margin: 0 auto;
  }

  .card { flex: 0 1 22.5rem; }
  .modal-content { max-width: 820px; }
}

@media (min-width: 1600px) {
  .container { font-size: 21px; }
}
</style>
