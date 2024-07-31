<template>
  <div class="upload-files-container">
    <a-upload
      v-model:file-list="state.fileList"
      name="file"
      list-type="picture"
      :before-upload="() => false"
      :headers="state.headers"
      :multiple="props.multipleFile"
      @change="handleSelectFile"
    >
      <a-button v-if="handleUploadMutipleFile()">
        <i class="far fa-upload mr-2"></i>
        Chọn tệp của bạn
      </a-button>
    </a-upload>

    <span v-if="errorMessage" class="mt-[6px] block text-[12px] text-red-500">{{
      errorMessage
    }}</span>
  </div>
</template>
<script setup>
import { reactive } from 'vue';
import { useField } from 'vee-validate';

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  multipleFile: {
    type: [Boolean, String],
    default: false
  }
});

// STATE
const state = reactive({
  fileList: [],
  headers: {
    authorization: 'authorization-text'
  }
});

const handleUploadMutipleFile = () => {
  if (props.multipleFile) {
    return true;
  }
  if (state.fileList.length > 0 && state.fileList.length < 2) {
    return false;
  }
  return true;
};

const { value, errorMessage } = useField(props.name);

const handleSelectFile = (valueInput) => {
  if (props.multipleFile) {
    return (value.value = valueInput.fileList);
  }
  return (value.value = valueInput.file);
};
</script>
