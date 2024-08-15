<template>
    <a-button type="dashed" class="h-[36px]" @click="state.open = true">
        <i class="fas fa-file-import mr-2"></i>
        Nhập câu hỏi
    </a-button>

    <a-modal v-model:open="state.open" @ok="handleOk">
        <template #title>
            <div class="flex items-center">
                <h3 class="mb-0 mr-2 text-lg font-bold">Nhập hàng loạt câu hỏi</h3>
                <small class="text-red-500">(Vui lòng chọn file excel)</small>

            </div>
        </template>
        <div class="mb-4">
            <a target="_blank" rel="noopener noreferrer" class="text-blue-500"
                href="/src/assets/files/question-example.xlsx">
                <i class="far fa-file-excel mr-1"></i>
                File câu hỏi mẫu
            </a>
        </div>
        <InputFileComponent name="file" />
    </a-modal>
</template>

<script setup>
import { reactive } from 'vue';
import { InputFileComponent } from '@/components/backend';
import { useForm } from 'vee-validate';
import * as yup from 'yup';
import { useCRUD } from '@/composables';
import { formatMessages } from '@/utils/format';
import store from '@/store';

const { create, messages } = useCRUD();

const emits = defineEmits(['onUpload']);

// STATE
const state = reactive({
    open: false,
    error: {},
    endpoint: 'questions/importQuestion',
});

const { handleSubmit, setValues } = useForm({
    validationSchema: yup.object({
        file: yup
            .mixed()
            .test('fileRequired', 'Vui lòng chọn tệp tin.', (value) => value)
            .test('fileType', 'Vui lòng chọn đúng định dạng tệp tin là excel.', (value) => {
                if (!value) return true; // allow empty value
                return (
                    value &&
                    [
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.ms-excel',
                        'application/wps-office.xlsx'
                    ].includes(value.type)
                );
            })
    })
});

const handleOk = handleSubmit(async (values) => {
    const response = await create(state.endpoint, values);
    if (!response) {
        store.dispatch('antStore/showMessage', { type: 'error', message: messages.value });
        return;
    }

    state.open = false;
    store.dispatch('antStore/showMessage', { type: 'success', message: messages.value });
    state.error = {};
    emits('onUpload');
});
</script>
