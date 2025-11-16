<template>
  <button @click="toggle = !toggle">Toggle Sidebar</button>

  <div class="side-bar" v-if="toggle">
    <div class="menu">
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu1 = !showMenu1"
          >Student</a
        >
        <div class="sub-menu" v-if="showMenu1">
          <a href="#" class="sub-item">Merged Answers</a>
          <a href="#" class="sub-item">Individual Answers</a>
        </div>
      </div>
      <div class="item">
        <a href="#" class="sub-btn" @click.stop="showMenu2 = !showMenu2"
          >Teacher</a
        >
        <div class="sub-menu" v-if="showMenu2">
          <a href="#" class="sub-item">Merged Answers</a>
          <a href="#" class="sub-item">Individual Answers</a>
        </div>
      </div>
      <div class="item"><a href="#">Scheduler</a></div>
      <div class="item"><a href="#">File Upload</a></div>
      <div class="item">
        <a href="#" @click.stop="showMenu3 = !showMenu3">Accounts</a>
        <div class="sub-menu" v-if="showMenu3">
          <a href="#" class="sub-item">Add Teachers</a>
          <a href="#" class="sub-item">Delete Users</a>
        </div>
      </div>
      <div class="item"><a href="#">Question Change</a></div>
    </div>
  </div>

  <div class="content">
    <div class="main">
      <div class="info-area">
        <h1>Hello</h1>
        <p>Hello</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "test",
  data() {
    return {
      showMenu1: false,
      showMenu2: false,
      showMenu3: false,
      toggle: false,
    };
  },
};
</script>

<style scoped>
.info-area {
  background-color: aquamarine;
}
/*Styles for the sidebar*/
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
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
  background: rgba(40, 185, 40, 0.898);
  transition: 0.3s ease;
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
  background: rgba(40, 185, 40, 0.898);
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
</style>
