<template>
  <!-- Filter -->
  <FilterComponent @onFilter="onFilterOptions" />
  <!-- End filter -->
  <a-table
    bordered
    :columns="columns"
    :data-source="state.dataSource"
    :row-selection="rowSelection"
    :pagination="pagination"
    :loading="loading"
    @change="handleTableChange"
  >
    <template #bodyCell="{ column, record }">
      <template v-if="column.dataIndex === 'content'">
        <div class="content-html" v-html="record.content"></div>
      </template>
      <template v-if="column.dataIndex === 'type'">
        {{ typeText(record.type) }}
      </template>
    </template>

    <template #expandedRowRender="{ record }">
      <h2>Đáp án</h2>
      <ul class="list-answers mb-0 ml-10 list-disc" v-if="record.answers.length">
        <li v-for="answer in record.answers" :key="answer.id">
          <div class="answer-item" v-html="answer.content"></div>
          <i v-if="answer.is_correct" class="fal fa-check-circle ml-2 text-green-500"></i>
          <i v-else class="fal fa-times-circle ml-2 text-red-500"></i>
        </li>
      </ul>
    </template>
  </a-table>
</template>

<script setup>
import { computed, onMounted, reactive, watch } from 'vue';
import { FilterComponent } from '@/components/backend';
import { useCRUD, usePagination } from '@/composables';
import { QUESTION_TYPE } from '@/static/constants';

// STATE
const state = reactive({
  pageTitle: 'Danh sách câu hỏi',
  modelName: 'Question',
  routeCreate: 'question.store',
  routeUpdate: 'question.update',
  endpoint: 'questions',
  modelIds: [],
  filterOptions: {},
  dataSource: []
});

const columns = [
  {
    title: 'Tiêu đề câu hỏi',
    dataIndex: 'content',
    key: 'content',
    sorter: (a, b) => a.content.localeCompare(b.content)
  },
  {
    title: 'Kiểu câu hỏi',
    dataIndex: 'type',
    key: 'type',
    sorter: (a, b) => a.type.localeCompare(b.type),
    width: '15%'
  },
  {
    title: 'Chủ đề',
    dataIndex: 'topic_name',
    key: 'topic_name',
    sorter: (a, b) => a.topic_name.localeCompare(b.topic_name)
  }
];

const { getAll, loading } = useCRUD();

const emits = defineEmits(['onChangeQuestion']);

const typeText = computed(() => {
  return (type) => {
    return QUESTION_TYPE.find((item) => item.value === type).label;
  };
});

// Pagination
const {
  pagination,
  rowSelection,
  onChangePagination,
  selectedRowKeys,
  handleTableChange,
  selectedRows
} = usePagination();

// Fetchdata
const fetchData = async () => {
  const payload = {
    page: pagination.current,
    pageSize: pagination.pageSize,
    ...state.filterOptions
  };
  const response = await getAll(state.endpoint, payload);
  state.dataSource = response.data;
  pagination.current = response.current_page;
  pagination.total = response.total;
  pagination.pageSize = response.per_page;
};

// Watchers
watch(onChangePagination, () => fetchData());
watch(selectedRows, () => {
  state.isShowToolbox = selectedRows.value.length > 0;
  state.modelIds = selectedRowKeys.value;

  emits('onChangeQuestion', selectedRowKeys.value);
});

const onFilterOptions = (filterValue) => {
  state.filterOptions = filterValue;
  fetchData();
};

// Lifecycle hook
onMounted(fetchData);
</script>
