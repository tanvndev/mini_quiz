<template>
  <a-card class="mt-3">
    <template #title>
      <span>Đáp án <small class="text-red-500">(Tối thiểu 2 đáp án)</small></span>
    </template>
    <a-row :gutter="16">
      <a-col :span="24" v-for="(count, index) in state.countAnswer" :key="count" class="mb-4">
        <a-row :gutter="[16, 16]" class="items-center">
          <a-col :span="1">
            <span class="font-bold">#{{ index + 1 }}</span>
          </a-col>
          <a-col :span="19">
            <EditorComponent :name="`answers[${index}]content`" />
          </a-col>

          <a-col :span="2" class="text-right">
            <SwitchComponent
              check-text="Đúng"
              uncheck-text="Sai"
              :name="`answers[${index}]is_correct`"
            />
          </a-col>

          <a-col :span="2" class="text-center">
            <a-button type="primary" danger @click="deleteAnswer">
              <i class="far fa-trash-alt"></i>
            </a-button>
          </a-col>
        </a-row>
      </a-col>
      <a-col :span="24" class="mt-3">
        <a-button class="float-right" @click="createAnswer">
          <i class="fas fa-plus mr-2"></i>
          Tạo thêm đáp án
        </a-button>
      </a-col>
    </a-row>
  </a-card>
</template>
<script setup>
import { reactive } from 'vue';
import { EditorComponent, SwitchComponent } from '@/components/backend';

// STATE
const state = reactive({
  countAnswer: 2
});

const createAnswer = () => {
  state.countAnswer++;
};

const deleteAnswer = () => {
  state.countAnswer--;
  if (state.countAnswer < 2) {
    state.countAnswer = 2;
  }
};
</script>
