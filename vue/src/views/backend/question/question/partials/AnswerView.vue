<template>
  <a-card class="mt-3">
    <template #title>
      <span>Đáp án <small class="text-red-500">(Tối thiểu 2 đáp án)</small></span>
    </template>

    <a-row :gutter="16">
      <!-- Render answers if available -->
      <a-col :span="24" v-for="(answer, index) in answers" :key="index" class="mb-4">
        <a-row :gutter="[16, 16]" class="items-center">
          <a-col :span="1">
            <span class="font-bold">#{{ index + 1 }}</span>
          </a-col>
          <a-col :span="19">
            <EditorComponent :name="`answers[${index}].content`" :old-value="answer.content" />
          </a-col>
          <a-col :span="2" class="text-right">
            <SwitchComponent
              check-text="Đúng"
              uncheck-text="Sai"
              :name="`answers[${index}].is_correct`"
              :old-value="answer.is_correct && answer.is_correct != 0"
            />
          </a-col>
          <a-col :span="2" class="text-center">
            <a-button type="primary" danger @click="removeAnswer(index)">
              <i class="far fa-trash-alt"></i>
            </a-button>
          </a-col>
        </a-row>
      </a-col>

      <!-- Button to add a new answer -->
      <a-col :span="24" class="mt-3">
        <a-button class="float-right" @click="addAnswer">
          <i class="fas fa-plus mr-2"></i>
          Tạo thêm đáp án
        </a-button>
      </a-col>
    </a-row>
  </a-card>
</template>

<script setup>
import { ref, watch } from 'vue';
import { EditorComponent, SwitchComponent } from '@/components/backend';

// Define props
const props = defineProps({
  answers: {
    type: [Array, Object],
    default: () => []
  }
});

// Define a local state to manage answers
const answers = ref([...props.answers]);

// Watch for changes in props and update local state
watch(
  () => props.answers,
  (newAnswers) => {
    answers.value = [...newAnswers];
  },
  { deep: true }
);

if (answers.value == 0) {
  answers.value = Array(2).fill({ content: '', is_correct: false });
}

const addAnswer = () => {
  answers.value.push({ content: '', is_correct: false });
};

const removeAnswer = (index) => {
  if (answers.value.length > 2) {
    answers.value.splice(index, 1);
  }
};
</script>

<style scoped>
/* Add any specific styles you want here */
</style>
