<template>
  <div class="page">
    <div class="card">
      <h1>Create Student Account</h1>
      <p class="subtitle">
        Fill in your details to create your EduRate student account.
      </p>

      <form @submit.prevent="signup">
        <div v-if="error" class="alert">{{ error }}</div>
        <div v-if="success" class="alert success">{{ success }}</div>

        <div class="grid">
          <label class="field">
            <span>First Name</span>
            <input v-model="form.fn" type="text" required />
          </label>
          <label class="field">
            <span>Last Name</span>
            <input v-model="form.ln" type="text" required />
          </label>
        </div>

        <label class="field">
          <span>Email</span>
          <input v-model="form.em" type="email" required />
        </label>

        <label class="field">
          <span>Student ID</span>
          <input v-model="form.id" type="text" required />
        </label>

        <div class="grid">
          <label class="field">
            <span>Password</span>
            <input v-model="form.pass" type="password" minlength="8" required />
          </label>
          <label class="field">
            <span>Confirm Password</span>
            <input
              v-model="form.conpass"
              type="password"
              minlength="8"
              required
            />
          </label>
        </div>

        <button class="primary" type="submit" :disabled="isLoading">
          {{ isLoading ? "Creating Account..." : "Create Account" }}
        </button>

        <button class="link" type="button" @click="$router.push('/')">
          Back to Dashboard
        </button>
      </form>
    </div>
  </div>
</template>

<script>
const url2 = "https://star-panda-literally.ngrok-free.app";

export default {
  name: "RegisterStudent",
  data() {
    return {
      form: { fn: "", ln: "", em: "", id: "", pass: "", conpass: "" },
      isLoading: false,
      error: "",
      success: "",
    };
  },
  methods: {
    async signup() {
      this.error = "";
      this.success = "";

      if (this.form.pass !== this.form.conpass) {
        this.error = "Passwords do not match.";
        return;
      }

      try {
        this.isLoading = true;
        const response = await fetch(`${url2}/register.php`, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            ...this.form,
            action: "signup",
          }),
        });

        const result = await response.json();
        if (result.success) {
          this.success = "Account created! You can now log in.";
          this.form = { fn: "", ln: "", em: "", id: "", pass: "", conpass: "" };
        } else {
          this.error = result.error || "Registration failed. Please try again.";
        }
      } catch (err) {
        console.error("Signup error:", err);
        this.error = "An error occurred. Please try again.";
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script>

<style scoped>
.page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #0c5904 0%, #03424e 100%);
  padding: 2rem 1rem;
}

.card {
  width: 100%;
  max-width: 640px;
  background: #fff;
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

h1 {
  margin: 0 0 0.25rem 0;
  color: #2c3e50;
}

.subtitle {
  margin: 0 0 1.5rem 0;
  color: #556;
}

form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.grid {
  display: grid;
  gap: 1rem;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
}

.field {
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
  color: #2c3e50;
  font-weight: 600;
}

.field input {
  padding: 0.9rem 1rem;
  border-radius: 10px;
  border: 1.5px solid #dcdfe6;
  font-size: 1rem;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.field input:focus {
  border-color: #4a6da7;
  outline: none;
  box-shadow: 0 0 0 3px rgba(74, 109, 167, 0.15);
}

.primary {
  border: none;
  background: linear-gradient(135deg, #4a6da7 0%, #3a5a8f 100%);
  color: #fff;
  padding: 1rem;
  border-radius: 10px;
  font-size: 1.05rem;
  font-weight: 700;
  cursor: pointer;
  transition: transform 0.1s, box-shadow 0.2s;
}

.primary:disabled {
  opacity: 0.65;
  cursor: not-allowed;
}

.primary:not(:disabled):hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 24px rgba(58, 90, 143, 0.35);
}

.link {
  border: none;
  background: none;
  color: #4a6da7;
  font-weight: 700;
  cursor: pointer;
  padding: 0.5rem 0;
}

.alert {
  padding: 0.85rem 1rem;
  border-radius: 10px;
  background: #ffebee;
  color: #b71c1c;
  border: 1px solid #ffcdd2;
  font-weight: 600;
}

.alert.success {
  background: #e8f5e9;
  color: #1b5e20;
  border: 1px solid #c8e6c9;
}
</style>

