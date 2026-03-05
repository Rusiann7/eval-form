<template>
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
          <a
            href="#"
            @click="
              click('teacher');
              closeNav();
            "
            class="sub-item"
            >Evaluation Answers</a
          >
          <a
            href="#"
            @click="
              click('evaluate');
              closeNav();
            "
            class="sub-item"
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
          <a
            href="#"
            @click="
              click2('crtTeacher');
              closeNav();
            "
            class="sub-item"
            >Add Teachers</a
          >
          <a
            href="#"
            @click="
              click2('rmTeacher');
              closeNav();
            "
            class="sub-item"
            >Delete Users</a
          >
          <a
            href="#"
            @click="
              click2('editTeacher');
              closeNav();
            "
            class="sub-item"
            >Edit Users</a
          >
        </div>
      </div>
      <div class="item">
        <a
          href="#"
          @click.prevent="
            $router.push('/scheduler');
            closeNav();
          "
          >Scheduler</a
        >
      </div>
      <div class="item">
        <a
          href="#"
          @click.prevent="
            $router.push('/fileupload');
            closeNav();
          "
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
</template>

<script>
import { removeToken } from "../utils/auth";
export default {
  name: "sideBar",
  props: {
    isNavOpen: {
      type: Boolean,
      required: true,
    },
  },

  data() {
    return {
      showMenu2: false,
      showMenu3: false,
      showMenu4: false,
    };
  },
  emits: ["close", "navigate"],

  methods: {
    closeNav() {
      this.$emit("close");
    },

    logout() {
      removeToken();
      this.$router.replace("/");
    },

    click(tabName) {
      this.$emit("navigate", tabName);
      this.closeNav();
    },

    click2(tabName) {
      this.$emit("navigate2", tabName);
      this.closeNav();
    },
  },
};
</script>

<style scoped>
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

</style>
