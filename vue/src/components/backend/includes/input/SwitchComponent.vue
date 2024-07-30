<template>
  <a-switch v-model:checked="value" :size="props.size" @change="handleChange">
    <template #checkedChildren>
      {{ props.checkText }}
    </template>
    <template #unCheckedChildren>
      {{ props.uncheckText }}
    </template>
  </a-switch>
  <span v-if="errorMessage" class="mt-[6px] block text-[12px] text-red-500">{{
    errorMessage
  }}</span>
</template>

<script setup>
import { useField } from 'vee-validate';
import { watch } from 'vue';

const emits = defineEmits(['onChange']);
const handleChange = (value) => {
  emits('onChange', value);
};

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  size: {
    type: String,
    default: 'default'
  },
  checkText: {
    type: String,
    default: ''
  },
  uncheckText: {
    type: String,
    default: ''
  },
  oldValue: {
    type: [String, Number, Array, Object],
    default: ''
  }
});

// Tạo field với VeeValidate
const { value, errorMessage } = useField(props.name);

watch(
  () => props.oldValue,
  (newOldValue) => {
    if (newOldValue !== undefined && newOldValue !== value.value) {
      value.value = newOldValue;
    }
  },
  { immediate: true }
); // `immediate` để chạy watcher ngay lập tức
</script>
