<template>
  <div class="w-full bg-white">
    <label :for="props.name" :class="props.labelClass"
      >{{ props.label }}
      <span v-if="props.required" class="font-semibold text-red-500">(*)</span>
    </label>
    <QuillEditor
      :name="props.name"
      :id="props.name"
      v-model:content="value"
      theme="snow"
      contentType="html"
      toolbar="full"
    />
    <span v-if="errorMessage" class="mt-[6px] block text-[12px] text-red-500">{{
      errorMessage
    }}</span>
  </div>
</template>

<script setup>
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { useField } from 'vee-validate';
import { watch } from 'vue';

const props = defineProps({
  required: {
    type: [Boolean, String],
    default: false
  },
  label: {
    type: String,
    default: ''
  },
  labelClass: {
    type: String,
    default: 'mb-2 block text-sm font-medium text-gray-900'
  },
  name: {
    type: String,
    required: true
  },
  placeholder: {
    type: String,
    default: ''
  },
  oldValue: {
    type: [String, Boolean, Symbol],
    default: 'Nhập nội dung ở đây'
  }
});

// Tạo field với VeeValidate
const { value, errorMessage } = useField(props.name);

// Watch for changes in oldValue and set value accordingly
watch(
  () => props.oldValue,
  (newOldValue) => {
    if (newOldValue !== undefined && newOldValue !== value.value) {
      value.value = newOldValue;
    }
  },
  { immediate: true }
);
</script>
