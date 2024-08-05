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
          v-for="(question, index) in state.quizz.questions"
          :key="question.id"
          class="mb-3"
        >
          <span
            :id="'question-' + question.id"
            :class="{ 'font-bold': true, error: hasError(question.id) }"
          >
            Câu {{ index + 1 }}:
          </span>
          <div v-html="question.content" class="question mt-3"></div>

          <ul class="answers ml-4 mt-4">
            <li class="mb-3 flex items-center" v-for="answer in question.answers" :key="answer.id">
              <input
                :id="'answer-' + question.id + '-' + answer.id"
                type="radio"
                :name="'question-' + question.id"
                :value="answer.id"
                v-model="state.selectedAnswers[question.id]"
                class="mr-2"
              />
              <label class="cursor-pointer" :for="'answer-' + question.id + '-' + answer.id">
                <div v-html="answer.content"></div>
              </label>
            </li>
          </ul>
        </a-col>
      </a-row>

      <div class="mt-5 text-center">
        <button @click="submitAnswers" class="btn btn-primary">Nộp bài</button>
      </div>
    </a-card>
  </div>
</template>

<script setup>
import { computed, onMounted, reactive } from 'vue';
import { useCRUD } from '@/composables';
import router from '@/router';
import { message } from 'ant-design-vue';

const state = reactive({
  quizz: {},
  selectedAnswers: {}
});

const { getOne, data } = useCRUD();
const canonical = computed(() => router.currentRoute.value.params.canonical);

const fetchOne = async () => {
  await getOne('quizzes/do', canonical.value);
  state.quizz = data.value;
};

const hasError = (questionId) => {
  return !state.selectedAnswers[questionId];
};

const submitAnswers = () => {
  const unansweredQuestions = state.quizz.questions
    .filter((question) => !state.selectedAnswers[question.id])
    .map((question) => `Câu ${state.quizz.questions.indexOf(question) + 1}`);

  if (unansweredQuestions.length > 0) {
    const messageText = `Bạn chưa trả lời các câu hỏi sau: ${unansweredQuestions.join(', ')}`;
    message.warning(messageText);
    return false;
  }

  console.log('Selected Answers:', state.selectedAnswers);
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
.question-text.error {
  color: red;
}

.error {
  color: red;
}
</style>
