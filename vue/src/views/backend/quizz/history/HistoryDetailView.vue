<template>
  <div class="container mx-auto mt-5 rounded shadow-md">
    <a-card>
      <h1 class="mb-5 text-center text-3xl">{{ state.quizz.quizz_name }}</h1>
      <RouterLink :to="{ name: 'home' }" class="float-right">
        <i class="fas fa-home-lg-alt text-xl"></i>
      </RouterLink>
      <a-row :gutter="[16, 16]">
        <a-col
          :span="24"
          v-for="(result, index) in state.resultAnswers"
          :key="result.id"
          class="mb-3"
        >
          <span :class="{ 'font-bold': true }"> Câu {{ index + 1 }}: </span>
          <div v-html="result.question.content" class="question mt-3"></div>

          <ul class="answers ml-4 mt-4">
            <li
              class="mb-3 flex items-center"
              v-for="answer in result.question.answers"
              :key="answer.id"
            >
              <input type="radio" :disabled="true" class="mr-2 cursor-not-allowed" />
              <div class="cursor-not-allowed" v-html="answer.content"></div>
              <i v-if="answer.is_correct" class="fal fa-check-circle ml-2 text-green-500"></i>
              <i v-else class="fal fa-times-circle ml-2 text-red-500"></i>
              <span
                v-if="result.answer_id === answer.id"
                class="ml-3 font-bold"
                :class="{
                  'text-green-500': result.is_correct === 1,
                  'text-red-500': result.is_correct !== 1
                }"
              >
                <i class="fas fa-hand-point-left"></i>
                Bạn chọn
              </span>
            </li>
          </ul>
        </a-col>
      </a-row>
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
  resultAnswers: []
});

const { getOne, data, messages } = useCRUD();
const id = computed(() => router.currentRoute.value.params.id);

const fetchOne = async () => {
  await getOne('quizzes/history/detail', id.value);
  state.quizz = data.value;
  state.resultAnswers = state.quizz.result_answers;
  console.log(state.resultAnswers);
};

onMounted(() => {
  if (id.value) {
    fetchOne();
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
