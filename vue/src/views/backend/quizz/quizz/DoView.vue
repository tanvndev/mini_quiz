<template>
  <div class="container mx-auto mt-5 rounded shadow-md">
    <a-card>
      <h1 class="mb-5 text-center text-3xl">{{ state.quizz.title }}</h1>
      <RouterLink :to="{ name: 'home' }" class="float-right">
        <i class="fas fa-home-lg-alt text-xl"></i>
      </RouterLink>
      <p class="mb-10 mt-5">Thí sinh đọc kỹ đề trước khi làm bài.</p>
      <span class="mb-5 block text-right text-2xl font-bold text-primary-500">
        <i class="fas fa-clock"></i>
        {{ timeRemaining }}
      </span>
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
        <a-popconfirm
          title="Bạn có chắc chắn muốn nộp bài?"
          ok-text="Nộp bài"
          cancel-text="Hủy"
          @confirm="submitAnswers"
        >
          <a-button>Nộp bài</a-button>
        </a-popconfirm>
      </div>
    </a-card>
  </div>
</template>

<script setup>
import { computed, onMounted, reactive } from 'vue';
import { useCRUD } from '@/composables';
import router from '@/router';
import { message } from 'ant-design-vue';
import { formatMessages } from '@/utils/format';
import store from '@/store';

const state = reactive({
  quizz: {},
  selectedAnswers: {},
  timeRemaining: 0
});

const { getOne, create, data, messages } = useCRUD();
const canonical = computed(() => router.currentRoute.value.params.canonical);

const fetchOne = async () => {
  await getOne('quizzes/do', canonical.value);
  state.quizz = data.value;
};

const hasError = (questionId) => {
  return !state.selectedAnswers[questionId];
};

const startTimer = () => {
  state.timeRemaining = 0;
  setInterval(() => {
    state.timeRemaining += 1000;
  }, 1000);
};

const submitAnswers = async () => {
  const unansweredQuestions = state.quizz.questions
    .filter((question) => !state.selectedAnswers[question.id])
    .map((question) => `Câu ${state.quizz.questions.indexOf(question) + 1}`);

  if (unansweredQuestions.length > 0) {
    const messageText = `Bạn chưa trả lời các câu hỏi sau: ${unansweredQuestions.join(', ')}`;
    message.warning(messageText);
    return false;
  }

  const formData = new FormData();
  formData.append('duration', state.timeRemaining);
  formData.append('quizz_id', state.quizz.id);
  formData.append('answers', JSON.stringify(state.selectedAnswers));

  const response = await create('quizzes/mark', formData);

  if (!response) {
    return (state.error = formatMessages(messages.value));
  }
  store.dispatch('antStore/showMessage', { type: 'success', message: messages.value });
  state.error = {};
  router.push({ name: 'quizz.history', params: { id: data.value.id } });
};

const formatTime = (milliseconds) => {
  const minutes = Math.floor(milliseconds / 60000);
  const seconds = Math.floor((milliseconds % 60000) / 1000);
  return `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
};

const timeRemaining = computed(() => formatTime(state.timeRemaining));

onMounted(() => {
  if (canonical.value) {
    fetchOne();
    startTimer();
  }
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
