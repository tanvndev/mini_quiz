<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="state.pageTitle" />
        <form @submit.prevent="onSubmit">
          <a-row :gutter="16">
            <a-col :span="18">
              <a-card class="mt-3" title="Thông tin chung">
                <AleartError :errors="state.error" />
                <a-row :gutter="[16, 16]">
                  <a-col :span="24">
                    <InputComponent
                      label="Tiêu đề bài kiểm tra"
                      placeholder="Tiêu đề bài kiểm tra"
                      :required="true"
                      name="title"
                    />
                  </a-col>
                  <a-col :span="24">
                    <SelectComponent
                      name="topic_id"
                      label="Chủ đề câu hỏi"
                      placeholder="Chọn chủ đề câu hỏi"
                      :required="true"
                      :options="state.topics"
                    />
                  </a-col>

                  <a-col :span="24">
                    <InputComponent
                      name="description"
                      label="Mô tả bài kiểm tra"
                      placeholder="Mô tả bài kiểm tra"
                      type-input="textarea"
                      :required="true"
                      :options="state.topics"
                    />
                  </a-col>
                </a-row>
              </a-card>

              <a-card class="mt-3" title="Các câu hỏi kiểm tra">
                <QuestionView @on-change-question="handleQuestions" />
              </a-card>
            </a-col>
            <a-col :span="6">
              <a-card class="mt-3" title="Hình ảnh bài kiểm tra">
                <InputFinderComponent name="image" />
              </a-card>
            </a-col>
          </a-row>

          <div class="fixed bottom-0 right-[19px] p-10">
            <a-button html-type="submit" :loading="loading" type="primary">
              <i class="far fa-save mr-2"></i>
              <span>Lưu thông tin</span>
            </a-button>
          </div>
        </form>
      </div>
    </template>
  </MasterLayout>
</template>

<script setup>
import {
  MasterLayout,
  BreadcrumbComponent,
  AleartError,
  InputComponent,
  SelectComponent,
  InputFinderComponent
} from '@/components/backend';
import QuestionView from './partials/QuestionView.vue';
import { computed, onMounted, reactive } from 'vue';
import { useForm } from 'vee-validate';
import { useStore } from 'vuex';
import { formatDataToSelect, formatMessages } from '@/utils/format';
import * as yup from 'yup';
import router from '@/router';
import { useCRUD } from '@/composables';

const store = useStore();
const { getOne, getAll, create, update, messages, data, loading } = useCRUD();

// STATE
const state = reactive({
  error: {},
  endpoint: 'quizzes',
  pageTitle: 'Thêm mới bài kiểm tra',
  topics: []
});

const id = computed(() => router.currentRoute.value.params.id || null);

const { handleSubmit, setValues, setFieldValue } = useForm({
  validationSchema: yup.object({
    name: yup.string().required('Chủ đề không được để trống.')
  })
});

const onSubmit = handleSubmit(async (values) => {
  const response =
    id.value && id.value > 0
      ? await update(state.endpoint, id.value, values)
      : await create(state.endpoint, values);
  if (!response) {
    return (state.error = formatMessages(messages.value));
  }
  store.dispatch('antStore/showMessage', { type: 'success', message: messages.value });
  state.error = {};
  router.push({ name: 'topic.index' });
});

const fetchOne = async () => {
  await getOne(state.endpoint, id.value);
  setValues({
    name: data.value?.name,
    description: data.value?.description,
    canonical: data.value?.canonical
  });
};

const getTopics = async () => {
  await getAll('topics');
  state.topics = formatDataToSelect(data.value);
};

const handleQuestions = (questionIds) => {
  setFieldValue('question_ids', questionIds);
};

onMounted(async () => {
  if (id.value) {
    fetchOne();
    state.pageTitle = 'Cập nhập bài kiểm tra.';
  }
  getTopics();
});
</script>
