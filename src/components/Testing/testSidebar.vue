<template>

<nav>
    <ul class="sidebar" ref="sidebar">
      <li @click="hideSidebar">
        <a href="#">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            height="26"
            viewBox="0 -960 960 960"
            width="26"
            fill="#e3e3e3"
          >
          <path
            d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"
          />
          </svg>
        </a>

      </li>
      <li><a href="#" @click.prevent="$router.push('/adminHome')">Home</a></li> <!--chart-->
      <li><a href="#" @click.prevent="$router.push('/adminPrice')">Student Evaluation</a></li>
      <li>
        <select name="Teachers" id="">Teachers
            <option value="Individual Evaluation">Individual Evaluation(Teachers)</option>
            <option value="Averaged Evaluation">Averaged Evaluation (Students)</option>
            <option value="Averaged Evaluation">Averaged Evaluation (Teachers)</option>
        </select>
      </li>
      <li><a href="#" @click.prevent="$router.push('/adminControl')"></a></li>
      <li><a href="#" @click.prevent="$router.push('/adminControl')">Sentiment Analysis</a></li>
      <li><a href="#" @click.prevent="$router.push('/adminControl')">Bulk Upload</a></li>
      <li>
            <select name="" id=""> Evaluation Period
                <option value="">Overview</option>
                <option value="">Evaluation Period for Teachers</option>
                <option value="">Evaluation Period for Students</option>
            </select>
      </li>
      <li><a href="#" @click.prevent="logout">Log Out</a></li>
    </ul>
</nav>

  <draggable v-model="questions" @end="updateOrder" item-key="id">
    <template #item="{ element, index }">
      <div class="p-2 border mb-2 rounded">
        {{ index + 1 }}. {{ element.text }}
      </div>
    </template>
  </draggable>

<div class="sidebar">
      <div class="menu-item">
      Main Item 2
    </div>

    <!-- Your menu trigger -->
    <button @click="showSubMenu = !showSubMenu">
      Student
    </button>
    
    <!-- Transition wrapper around your v-if div -->
    <transition name="slide-fade" :duration="{ enter: 100, leave: 150 }">
      <div v-if="showSubMenu" class="submenu">
        <a href="#">merged</a>
        <br><br>  
        <a href="#">indi</a>  
      </div>
    </transition>
    
    <div class="menu-item">
      Main Item 3
    </div>
  </div>
</template>

<script>
import draggable from 'vuedraggable'

export default {
  components: { draggable },
  data() {
    return {
      questions: [
        { question_id: 1, question: 'What is your name?' },
        { question_id: 2, question: 'What subject do you teach?' },
        { question_id: 3, question: 'How do you rate the facilities?' }
      ],
      showSubMenu: false
    }
  },
  methods: {
  updateOrder(evt) {
    console.log('New order:', this.questions.map(q => q.question))
  }
}

}
</script>


<style>
.card {
  padding: 10px;
  margin: 5px;
  background: #2f2f2f;
  color: white;
  border-radius: 6px;
  cursor: grab;
}

.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateY(-10px);
  opacity: 0;
}

.submenu {
  background: #f5f5f5;
  padding: 10px;
}
</style>
