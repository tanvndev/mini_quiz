<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="state.pageTitle" />
        <form @submit.prevent="onSubmit">
          <a-row :gutter="16">
            <a-col :span="18" class="mx-auto">
              <!-- Question -->
              <a-card class="mt-3" title="Thông tin chung câu hỏi">
                <AleartError :errors="state.error" />
                <a-row :gutter="[16, 16]">
                  <a-col :span="24">
                    <EditorComponent
                      :required="true"
                      type-input="textarea"
                      label="Nội dung câu hỏi"
                      name="content"
                    />
                  </a-col>
                </a-row>
              </a-card>
              <!-- Answer -->
              <AnswerView />
            </a-col>
            <!-- Sidebar -->
            <a-col :span="6" class="mx-auto">
              <a-card class="mt-3" title="Thông tin bổ sung">
                <AleartError :errors="state.error" />
                <a-row :gutter="[16, 16]">
                  <a-col :span="24">
                    <SelectComponent
                      label="Chủ đề cảu hỏi"
                      :required="true"
                      name="topic_id"
                      :options="state.topics"
                      placeholder="Chọn chủ đề câu hỏi"
                    />
                  </a-col>

                  <a-col :span="24">
                    <SelectComponent
                      label="Loại câu hỏi"
                      name="type"
                      :required="true"
                      :options="QUESTION_TYPE"
                      placeholder="Chọn loại câu hỏi"
                    />
                  </a-col>
                </a-row>
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
  EditorComponent,
  SelectComponent
} from '@/components/backend';
import { computed, onMounted, reactive } from 'vue';
import { useForm } from 'vee-validate';
import { useStore } from 'vuex';
import { formatDataToSelect, formatMessages } from '@/utils/format';
import * as yup from 'yup';
import router from '@/router';
import { useCRUD } from '@/composables';
import { QUESTION_TYPE } from '@/static/constants';
import AnswerView from './partials/AnswerView.vue';

const store = useStore();
const { getOne, create, getAll, update, messages, data, loading } = useCRUD();

// STATE
const state = reactive({
  endpoint: 'questions',
  pageTitle: 'Thêm mới câu hỏi',
  topics: [],
  error: {}
});

const id = computed(() => router.currentRoute.value.params.id || null);

const { handleSubmit, setValues } = useForm({
  validationSchema: yup.object({
    content: yup.string().required('Tên câu hỏi không được để trống.'),
    topic_id: yup.number().required('Vui lòng chọn chủ đề câu hỏi.'),
    type: yup.number().required('Vui lòng chọn loại câu hỏi.')
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

onMounted(async () => {
  if (id.value) {
    fetchOne();
    state.pageTitle = 'Cập nhập câu hỏi.';
  }
  getTopics();
});
</script>
