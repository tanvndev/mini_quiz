<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="state.pageTitle" />
        <form @submit.prevent="onSubmit">
          <a-row :gutter="16">
            <a-col :span="20" class="mx-auto">
              <a-card class="mt-3" title="Thông tin chung">
                <AleartError :errors="state.error" />
                <a-row :gutter="[16, 16]">
                  <a-col :span="12">
                    <InputComponent label="Tên chủ đề" :required="true" name="name" />
                  </a-col>

                  <a-col :span="12">
                    <InputComponent label="Đường dẫn" name="canonical" />
                  </a-col>

                  <a-col :span="24">
                    <InputComponent type-input="textarea" label="Mô tả chủ đề" name="description" />
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
  InputComponent
} from '@/components/backend';
import { computed, onMounted, reactive } from 'vue';
import { useForm } from 'vee-validate';
import { useStore } from 'vuex';
import { formatDataToSelect, formatMessages } from '@/utils/format';
import * as yup from 'yup';
import router from '@/router';
import { useCRUD } from '@/composables';

const store = useStore();
const { getOne, create, update, messages, data, loading } = useCRUD();

// STATE
const state = reactive({
  error: {},
  endpoint: 'topics',
  pageTitle: 'Thêm mới chủ đề'
});

const id = computed(() => router.currentRoute.value.params.id || null);

const { handleSubmit, setValues } = useForm({
  validationSchema: yup.object({
    name: yup.string().required('Tên chủ đề không được để trống.')
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

onMounted(async () => {
  if (id.value) {
    fetchOne();
    state.pageTitle = 'Cập nhập chủ đề.';
  }
});
</script>
