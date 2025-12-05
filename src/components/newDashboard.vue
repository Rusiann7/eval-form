<template>
  <div v-if="isLoading" class="loading-screen">
    <div class="loading-spinner"></div>
    <p>Loading...</p>
  </div>

  <div class="container">
    <div class="logo">
      <!-- Perfect Circle Logo -->
      <div class="logo-image">
        <img src="../assets/logo2.png" alt="Project EVAL Logo" />
      </div>
      <h1>EduRate</h1>
      <p class="tagline">"Reflect, Improve, Inspire!"</p>
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
        <div class="icon">
          <i class="fas fa-chalkboard-teacher"></i>
        </div>
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
        <div class="icon">
          <i class="fas fa-user-shield"></i>
        </div>
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
      <div class="modal-header">
        <div class="modal-icon">
          <i class="fas fa-user-graduate"></i>
        </div>
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
          <div class="captcha-container">
            <div
              ref="turnstileWidgetStudent"
              class="cf-turnstile"
            ></div>
          </div>
          <button type="submit" class="modal-btn" :disabled="isLoading">
            {{ isLoading ? 'Logging in...' : 'Login' }}
          </button>
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
          <button type="submit" class="modal-btn" :disabled="isLoading">
            {{ isLoading ? 'Creating Account...' : 'Create Account' }}
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Teacher Modal -->
  <div class="modal teacher-modal" v-if="activeModal === 'teacher'">
    <div class="modal-content">
      <span class="close-modal" @click="closeModal()">&times;</span>
      <div class="modal-header">
        <div class="modal-icon">
          <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <h2>Teacher Portal</h2>
        <p>Login to your account</p>
        <p class="modal-note">
          <i>If you do not have an account yet visit the admin office.</i>
        </p>
      </div>

      <div class="tab-content">
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
          <div class="captcha-container">
            <div
              class="cf-turnstile"
              ref="turnstileWidgetTeacher"
            ></div>
          </div>

          <button type="submit" class="modal-btn" :disabled="isLoading">
            {{ isLoading ? 'Logging in...' : 'Login to Teacher Portal' }}
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
        <div class="modal-icon">
          <i class="fas fa-user-shield"></i>
        </div>
        <h2>Administrator Portal</h2>
        <p>Login to your account</p>
      </div>

      <div class="tab-content">
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
          <div class="captcha-container">
            <div
              ref="turnstileWidgetAdmin"
              class="cf-turnstile"
            ></div>
          </div>

          <button type="submit" class="modal-btn" :disabled="isLoading">
            {{ isLoading ? 'Logging in...' : 'Login to Admin Portal' }}
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Forgot Password Modal -->
  <div class="modal forgot-modal" v-if="activeModal === 'fgps'">
    <div class="modal-content">
      <span class="close-modal" @click="closeModal()">&times;</span>
      <div class="modal-header">
        <div class="modal-icon">
          <i class="fas fa-key"></i>
        </div>
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
        <button type="submit" class="modal-btn" :disabled="isLoading">
          {{ isLoading ? 'Sending...' : 'Send Reset Code' }}
        </button>
      </form>
    </div>
  </div>

  <div class="modal code-modal" v-if="activeModal === 'code'">
    <div class="modal-content">
      <span class="close-modal" @click="closeModal()">&times;</span>
      <div class="modal-header">
        <div class="modal-icon">
          <i class="fas fa-envelope"></i>
        </div>
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
        <button type="submit" class="modal-btn" :disabled="isLoading">
          {{ isLoading ? 'Verifying...' : 'Enter Reset Code' }}
        </button>
      </form>
    </div>
  </div>

  <div class="modal password-modal" v-if="activeModal === 'password'">
    <div class="modal-content">
      <span class="close-modal" @click="closeModal()">&times;</span>
      <div class="modal-header">
        <div class="modal-icon">
          <i class="fas fa-lock"></i>
        </div>
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
          />
        </div>
        <div class="form-group">
          <label for="confirmpass">Confirm Password</label>
          <input
            type="password"
            v-model="newPassword.confirmPassword"
            placeholder="Confirm your new password"
            required
          />
        </div>
        <button type="submit" class="modal-btn" :disabled="isLoading">
          {{ isLoading ? 'Updating...' : 'Reset Password' }}
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import { setToken, getToken } from "../utils/auth";

const url1 = "https://rusiann7.helioho.st";
const url2 = "https://rusiann7.helioho.st";

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
        alert("Please complete the captcha verification");
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
            setToken(result.token);
          } else {
            console.error("No token received from server.");
            this.isLoading = false;
            return;
          }

          localStorage.setItem("userData", JSON.stringify(result.userData));
          this[type] = { id: "", ps: "" };

          this.isLoading = false;
          this.$router.replace(site);
        } else {
          this.isWrong = true;
          this.isLoading = false;
          alert(result.error || "Login failed. Please try again.");
        }
      } catch (error) {
        console.error("Login error:", error);
        this.isLoading = false;
        alert("An error occurred. Please try again.");
      }
    },

    async signup() {
      if (this.studentr.pass !== this.studentr.conpass) {
        this.isWrong = true;
        alert("Passwords do not match!");
        return;
      }

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
          alert("Account created successfully! Please login.");
          this.activeTab = "login";
          this.studentr = {
            fn: "",
            ln: "",
            em: "",
            id: "",
            pass: "",
            conpass: "",
          };
        } else {
          alert(result.error || "Registration failed. Please try again.");
        }
        this.isLoading = false;
      } catch (error) {
        this.isLoading = false;
        console.error("Signup error:", error);
        alert("An error occurred. Please try again.");
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
          alert("Reset code sent to your email!");
        } else {
          this.isLoading = false;
          alert(result.error || "Failed to send reset code.");
        }
      } catch (error) {
        this.isLoading = false;
        console.error("Forgot password error:", error);
        alert("An error occurred. Please try again.");
      }
    },

    async passwords() {
      if (this.newPassword.newPasswords !== this.newPassword.confirmPassword) {
        alert("Passwords do not match!");
        return;
      }

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
          alert("Password reset successful! Please login.");
        } else {
          this.isLoading = false;
          alert(result.error || "Password reset failed.");
        }
      } catch (error) {
        this.isLoading = false;
        console.error("Password reset error:", error);
        alert("An error occurred. Please try again.");
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
        } else {
          this.isLoading = false;
          alert(result.error || "Invalid code. Please try again.");
        }
      } catch (error) {
        this.isLoading = false;
        console.error("Code verification error:", error);
        alert("An error occurred. Please try again.");
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
      this.activeTab = "login";
      this.isWrong = false;
      this.isLoading = false;
      
      // Reset form data
      this.studentl = { id: "", ps: "" };
      this.teacherl = { id: "", ps: "" };
      this.admin = { id: "", ps: "" };
      this.newPassword = {
        newPasswords: "",
        confirmPassword: "",
        email: "",
        code: "",
      };
    },

    closeModal() {
      this.activeModal = "";
      this.activeTab = "login";
      this.isWrong = false;
      this.isLoading = false;
    },

    notify() {
      if ("Notification" in window) {
        if (Notification.permission === "granted") {
          console.log("Notification permission granted");
        } else if (Notification.permission !== "denied") {
          Notification.requestPermission().then((permission) => {
            if (permission === "granted") {
              console.log("Notification permission granted");
            }
          });
        }
      }
    },
  },

  mounted() {
    // Load Font Awesome if not already loaded
    if (!document.querySelector('link[href*="font-awesome"]')) {
      const link = document.createElement("link");
      link.rel = "stylesheet";
      link.href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css";
      document.head.appendChild(link);
    }

    // Load Cloudflare Turnstile if not already loaded
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
            callback: () => {
              document.cookie = "cf_verified=1; path=/; max-age=10800";
              this.captcha = true;
            },
            theme: "light",
          });
        }, 300);
      });
    },
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
  font-size: 16px;
  line-height: 1.6;
}

/* ===== IMPROVED TYPOGRAPHY - LARGER TEXT ===== */
h1 { font-size: 2.5rem; }
h2 { font-size: 2rem; }
h3 { font-size: 1.75rem; }
p, span, label, button, input, select, a { 
  font-size: 1.125rem; 
}

@media (min-width: 768px) {
  h1 { font-size: 3rem; }
  h2 { font-size: 2.5rem; }
  h3 { font-size: 2rem; }
  p, span, label, button, input, select, a { 
    font-size: 1.25rem; 
  }
}

@media (min-width: 1024px) {
  h1 { font-size: 3.5rem; }
  h2 { font-size: 2.75rem; }
  h3 { font-size: 2.25rem; }
  p, span, label, button, input, select, a { 
    font-size: 1.375rem; 
  }
}

/* ===== MAIN CONTAINER ===== */
.container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 2rem 1rem;
  color: #fff;
  width: 100%;
  min-height: 100vh;
  background: linear-gradient(135deg, #0c5904 0%, #03424e 100%);
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}

/* ===== UPDATED LOGO SECTION WITH PERFECT CIRCLE ===== */
.logo {
  margin-bottom: 3rem;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  max-width: 1200px;
}

/* Perfect circle logo container */
.logo-image {
  width: 180px;
  height: 180px;
  border-radius: 50%;
  border: 6px solid #fff;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
  margin-bottom: 1.5rem;
  background-color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  /* Ensure perfect circle on all devices */
  aspect-ratio: 1 / 1;
  position: relative;
}

/* Logo image that fits perfectly in the circle */
.logo-image img {
  /* Make image fill the circle */
  width: 85%;
  height: 85%;
  /* Maintain aspect ratio and fit inside */
  object-fit: contain;
  /* Remove any default margins/padding */
  margin: 0;
  padding: 0;
  /* Center the image perfectly */
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.logo h1 {
  font-size: 3.5rem;
  font-weight: 800;
  margin-bottom: 0.5rem;
  color: #fff;
  text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
  word-wrap: break-word;
  overflow-wrap: break-word;
}

.tagline {
  font-size: 1.75rem;
  margin-bottom: 0.5rem;
  text-align: center;
  max-width: 800px;
  line-height: 1.4;
  color: #e0f7fa;
  font-weight: 600;
  word-wrap: break-word;
  padding: 0 0.5rem;
}

.instruction {
  color: #e0e0e0;
  margin-top: 1.5rem;
  font-size: 1.375rem;
  text-align: center;
  font-weight: 500;
  word-wrap: break-word;
  padding: 0 0.5rem;
}

/* ===== CARDS CONTAINER ===== */
.cards-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 2rem;
  width: 100%;
  max-width: 1200px;
  margin-top: 1rem;
}

.card {
  background: rgba(255, 255, 255, 0.98);
  border-radius: 20px;
  padding: 2.5rem;
  text-align: center;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.card:hover {
  transform: translateY(-15px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.icon {
  font-size: 4rem;
  margin-bottom: 1.5rem;
  height: 100px;
  width: 100px;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.student .icon {
  background-color: rgba(74, 109, 167, 0.15);
  color: #4a6da7;
}

.teacher .icon {
  background-color: rgba(71, 167, 106, 0.15);
  color: #47a76a;
}

.admin .icon {
  background-color: rgba(199, 80, 80, 0.15);
  color: #c75050;
}

.card h2 {
  color: #2c3e50;
  margin-bottom: 1rem;
  font-size: 2rem;
  font-weight: 700;
}

.card p {
  color: #555;
  margin-bottom: 2rem;
  line-height: 1.6;
  flex-grow: 1;
  font-size: 1.125rem;
}

.btn {
  display: inline-block;
  color: white;
  padding: 1rem 2rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
  border: none;
  cursor: pointer;
  width: 100%;
  font-size: 1.125rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.btn:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.student .btn {
  background: linear-gradient(135deg, #4a6da7 0%, #3a5a8f 100%);
}

.student .btn:hover {
  background: linear-gradient(135deg, #3a5a8f 0%, #2a4a7f 100%);
}

.teacher .btn {
  background: linear-gradient(135deg, #47a76a 0%, #3a8f58 100%);
}

.teacher .btn:hover {
  background: linear-gradient(135deg, #3a8f58 0%, #2a7f48 100%);
}

.admin .btn {
  background: linear-gradient(135deg, #c75050 0%, #a83c3c 100%);
}

.admin .btn:hover {
  background: linear-gradient(135deg, #a83c3c 0%, #982c2c 100%);
}

/* ===== MODAL STYLES ===== */
.modal {
  display: flex;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.85);
  justify-content: center;
  align-items: center;
  z-index: 2000;
  padding: 1rem;
}

.modal-content {
  background: white;
  border-radius: 20px;
  width: 90%;
  max-width: 550px;
  padding: 2.5rem;
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
  position: relative;
  max-height: 90vh;
  overflow-y: auto;
  animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
  from {
    opacity: 0;
    transform: translateY(-30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.close-modal {
  position: absolute;
  top: 1.25rem;
  right: 1.5rem;
  font-size: 2rem;
  color: #888;
  cursor: pointer;
  transition: color 0.3s ease;
  line-height: 1;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
}

.close-modal:hover {
  color: #333;
  background: #f5f5f5;
}

.modal-header {
  text-align: center;
  margin-bottom: 2rem;
  padding: 0 0.5rem;
}

.modal-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
  color: inherit;
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

.forgot-modal .modal-icon,
.code-modal .modal-icon,
.password-modal .modal-icon {
  color: #666;
}

.modal-header h2 {
  color: #2c3e50;
  margin-bottom: 0.5rem;
  font-size: 2rem;
}

.modal-header p {
  color: #666;
  font-size: 1.125rem;
}

.modal-note {
  font-size: 1rem !important;
  color: #888 !important;
  margin-top: 0.5rem;
}

/* ===== TAB STYLES ===== */
.tabs {
  display: flex;
  margin-bottom: 2rem;
  border-bottom: 2px solid #eee;
}

.tab-btn {
  flex: 1;
  padding: 1rem;
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1.125rem;
  font-weight: 600;
  color: #888;
  transition: all 0.3s ease;
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

/* ===== FORM STYLES ===== */
.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  color: #444;
  font-weight: 600;
  text-align: left;
  font-size: 1.125rem;
}

.form-group input {
  width: 100%;
  padding: 1rem 1.25rem;
  border: 2px solid #ddd;
  border-radius: 12px;
  font-size: 1.125rem;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-group input:focus {
  border-color: #4a6da7;
  outline: none;
  box-shadow: 0 0 0 3px rgba(74, 109, 167, 0.1);
}

.remember-forgot {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-bottom: 1.5rem;
}

.forgot-password a {
  color: #4a6da7;
  text-decoration: none;
  font-size: 1rem;
  font-weight: 500;
}

.forgot-password a:hover {
  text-decoration: underline;
}

.captcha-container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  padding: 1rem 0;
  margin-bottom: 1.5rem;
}

.cf-turnstile {
  width: 100% !important;
  max-width: 100% !important;
  display: flex;
  justify-content: center;
}

.modal-btn {
  width: 100%;
  padding: 1.25rem;
  border: none;
  border-radius: 12px;
  color: white;
  font-size: 1.25rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.3s ease, transform 0.2s ease;
}

.modal-btn:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.modal-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.student-modal .modal-btn {
  background: linear-gradient(135deg, #4a6da7 0%, #3a5a8f 100%);
}

.student-modal .modal-btn:hover:not(:disabled) {
  background: linear-gradient(135deg, #3a5a8f 0%, #2a4a7f 100%);
}

.teacher-modal .modal-btn {
  background: linear-gradient(135deg, #47a76a 0%, #3a8f58 100%);
}

.teacher-modal .modal-btn:hover:not(:disabled) {
  background: linear-gradient(135deg, #3a8f58 0%, #2a7f48 100%);
}

.admin-modal .modal-btn {
  background: linear-gradient(135deg, #c75050 0%, #a83c3c 100%);
}

.admin-modal .modal-btn:hover:not(:disabled) {
  background: linear-gradient(135deg, #a83c3c 0%, #982c2c 100%);
}

.forgot-modal .modal-btn,
.code-modal .modal-btn,
.password-modal .modal-btn {
  background: linear-gradient(135deg, #666 0%, #555 100%);
}

.forgot-modal .modal-btn:hover:not(:disabled),
.code-modal .modal-btn:hover:not(:disabled),
.password-modal .modal-btn:hover:not(:disabled) {
  background: linear-gradient(135deg, #555 0%, #444 100%);
}

/* ===== LOADING SCREEN ===== */
.loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.9);
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

/* ===== ERROR MESSAGE ===== */
.wrong {
  color: #d32f2f;
  background: #ffebee;
  padding: 1rem;
  border-radius: 8px;
  margin-bottom: 1.5rem;
  font-weight: 600;
  text-align: center;
  border: 1px solid #ffcdd2;
  font-size: 1.125rem;
}

/* ===== RESPONSIVE DESIGN ===== */

/* Large Desktop */
@media (min-width: 1400px) {
  .logo-image {
    width: 200px;
    height: 200px;
  }
}

/* Laptop/Desktop */
@media (max-width: 1024px) {
  .cards-container {
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
  }
  
  .logo h1 {
    font-size: 3rem;
  }
  
  .tagline {
    font-size: 1.5rem;
  }
  
  .instruction {
    font-size: 1.25rem;
  }
}

/* Tablet */
@media (max-width: 768px) {
  .container {
    padding: 1.5rem 1rem;
    min-height: calc(100vh - 2rem);
  }
  
  .logo-image {
    width: 150px;
    height: 150px;
    border-width: 5px;
  }
  
  .logo-image img {
    width: 82%;
    height: 82%;
  }
  
  .logo h1 {
    font-size: 2.5rem;
  }
  
  .tagline {
    font-size: 1.25rem;
  }
  
  .instruction {
    font-size: 1.125rem;
  }
  
  .cards-container {
    grid-template-columns: 1fr;
    max-width: 500px;
    gap: 1.5rem;
  }
  
  .card {
    padding: 2rem;
  }
  
  .icon {
    width: 80px;
    height: 80px;
    font-size: 3rem;
  }
  
  .modal-content {
    padding: 2rem;
    width: 95%;
  }
}

/* Mobile */
@media (max-width: 480px) {
  .container {
    padding: 1rem 0.75rem;
    min-height: calc(100vh - 1rem);
  }
  
  .logo-image {
    width: 120px;
    height: 120px;
    border-width: 4px;
    margin-bottom: 1rem;
  }
  
  .logo-image img {
    width: 80%;
    height: 80%;
  }
  
  .logo h1 {
    font-size: 2.2rem;
  }
  
  .tagline {
    font-size: 1.1rem;
  }
  
  .instruction {
    font-size: 1rem;
  }
  
  .cards-container {
    grid-template-columns: 1fr;
    max-width: 350px;
    margin: 0 auto;
    gap: 1rem;
  }
  
  .card {
    padding: 1.75rem;
  }
  
  .card h2 {
    font-size: 1.75rem;
  }
  
  .card p {
    font-size: 1rem;
  }
  
  .btn {
    padding: 0.875rem 1.5rem;
    font-size: 1rem;
  }
  
  .modal-content {
    padding: 1.5rem;
  }
  
  .modal-header h2 {
    font-size: 1.75rem;
  }
  
  .modal-header p {
    font-size: 1rem;
  }
  
  .tab-btn {
    padding: 0.875rem;
    font-size: 1rem;
  }
  
  .form-group input {
    padding: 0.875rem 1rem;
    font-size: 1rem;
  }
  
  .modal-btn {
    padding: 1rem;
    font-size: 1.125rem;
  }
  
  .close-modal {
    top: 1rem;
    right: 1rem;
    font-size: 1.75rem;
  }
}

/* Very small screens */
@media (max-width: 360px) {
  .logo-image {
    width: 100px;
    height: 100px;
  }
  
  .logo-image img {
    width: 78%;
    height: 78%;
  }
  
  .logo h1 {
    font-size: 1.8rem;
  }
  
  .tagline {
    font-size: 1rem;
  }
  
  .instruction {
    font-size: 0.9rem;
  }
  
  .cards-container {
    max-width: 320px;
  }
  
  .card {
    padding: 1.5rem;
  }
}

/* For landscape orientation on mobile */
@media (max-height: 600px) and (orientation: landscape) {
  .logo-image {
    width: 100px;
    height: 100px;
    margin-bottom: 0.5rem;
  }
  
  .logo h1 {
    font-size: 2rem;
  }
  
  .container {
    padding: 1rem;
  }
}

/* High contrast support */
@media (prefers-contrast: high) {
  .logo-image {
    border: 3px solid #000;
    background-color: #fff;
  }
  
  .card {
    border: 2px solid #e5e7eb;
  }
  
  .form-group input {
    border-width: 2px;
  }
}

/* Focus visibility for accessibility */
button:focus-visible,
input:focus-visible,
.tab-btn:focus-visible,
.close-modal:focus-visible {
  outline: 2px solid #4a6da7;
  outline-offset: 2px;
}
</style> 