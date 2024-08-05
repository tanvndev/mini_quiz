<template>
  <div class="container mx-auto mt-5 rounded shadow-md">
    <a-card>
      <h1 class="mb-5 text-center text-3xl">{{ state.quizz.title }}</h1>
      <RouterLink :to="{ name: 'home' }" class="float-right">
        <i class="fas fa-home-lg-alt text-xl"></i>
      </RouterLink>
      <p class="mb-10 mt-5">Thí sinh đọc kỹ đề trước khi làm bài.</p>

      <a-row :gutter="[16, 16]">
        <a-col
          :span="24"
          v-for="(quiz, index) in state.quizz.questions"
          :key="quiz.id"
          class="mb-3"
        >
          <span class="font-bold">Câu {{ index + 1 }}:</span>
          <div v-html="quiz.content" class="question mt-3"></div>

          <ul class="answers ml-4 mt-4">
            <li class="mb-3 flex" v-for="answer in quiz.answers" :key="answer.id">
              <input type="radio" class="mr-2" />
              <div v-html="answer.content"></div>
            </li>
          </ul>
        </a-col>
      </a-row>
    </a-card>
  </div>
</template>
<script setup>
import router from '@/router';
import { computed, onMounted, reactive } from 'vue';
import { useCRUD } from '@/composables';

const state = reactive({
  quizz: {}
});

const { getOne, data } = useCRUD();
const canonical = computed(() => router.currentRoute.value.params.canonical);

const fetchOne = async () => {
  await getOne('quizzes/do', canonical.value);
  state.quizz = data.value;
};

onMounted(() => {
  fetchOne();
});
</script>
<style>
.question {
  font-weight: bold;
}

.question p {
  font-weight: bold;
}

.answers {
  cursor: pointer;
}
.answers p {
  margin-bottom: 0;
}
</style>
