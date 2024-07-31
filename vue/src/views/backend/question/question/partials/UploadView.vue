<template>
  <a-button type="dashed" class="h-[36px]" @click="state.open = true">
    <i class="fas fa-file-import mr-2"></i>
    Nhap cau hoi
  </a-button>

  <a-modal v-model:open="state.open" @ok="handleOk">
    <template #title>
      <div class="flex items-center">
        <h3 class="mb-0 mr-2 text-lg font-bold">Nhap cau hoi vao danh sach</h3>
        <small class="text-red-500">(Vui long chon file exel)</small>
      </div>
    </template>
    <InputFileComponent name="file" />
  </a-modal>
</template>

<script setup>
import { onMounted, reactive } from 'vue';
import { InputFileComponent } from '@/components/backend';
import { useForm } from 'vee-validate';
import * as yup from 'yup';

// STATE
const state = reactive({
  open: false
});

const { handleSubmit } = useForm({
  validationSchema: yup.object({
    file: yup
      .mixed()
      .test('fileRequired', 'Hay chon file.', (value) => value)
      .test('fileType', 'Vui long cho file excel.', (value) => {
        if (!value) return true; // allow empty value
        return (
          value &&
          [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel'
          ].includes(value.type)
        );
      })
  })
});

const handleOk = handleSubmit(async (values) => {
  console.log(values);
});
</script>
