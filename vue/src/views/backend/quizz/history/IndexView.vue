<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="state.pageTitle" />

        <!-- Table -->
        <a-card class="mt-3">
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
              <template v-if="column.dataIndex === 'user_catalogue'">
                <a-tag color="blue">{{ record.user_catalogue.name }}</a-tag>
              </template>

              <template v-if="column.dataIndex === 'publish'">
                <PublishSwitchComponent
                  :record="record"
                  :modelName="state.modelName"
                  :field="column.dataIndex"
                />
              </template>

              <template v-if="column.dataIndex === 'action'">
                <RouterLink
                  class="rounded-[6px] border border-primary-500 px-[14px] py-[7px] text-primary-500 hover:bg-primary-500 hover:text-white"
                  :to="{ name: 'quizz.history', params: { id: record.id } }"
                >
                  <i class="fas fa-eye"></i
                ></RouterLink>
              </template>
            </template>
          </a-table>
        </a-card>
        <!-- End table -->
      </div>
    </template>
  </MasterLayout>
</template>

<script setup>
import { onMounted, reactive, watch } from 'vue';
import {
  BreadcrumbComponent,
  MasterLayout,
  FilterComponent,
  PublishSwitchComponent,
  ToolboxComponent,
  ActionComponent
} from '@/components/backend';
import { useCRUD, usePagination } from '@/composables';

// STATE
const state = reactive({
  pageTitle: 'Lịch sử làm bài',
  modelName: 'Quizz',
  endpoint: 'quizzes/history/index',
  isShowToolbox: false,
  modelIds: [],
  filterOptions: {},
  dataSource: []
});

const columns = [
  {
    title: 'Tên bài kiểm tra',
    dataIndex: 'quizz_name',
    key: 'quizz_name',
    sorter: (a, b) => a.quizz_name.localeCompare(b.quizz_name)
  },
  {
    title: 'Người làm',
    dataIndex: 'user_name',
    key: 'user_name',
    sorter: (a, b) => a.user_name.localeCompare(b.user_name)
  },
  {
    title: 'Điểm',
    dataIndex: 'score',
    key: 'score',
    sorter: (a, b) => a.score.localeCompare(b.score)
  },
  {
    title: 'Số câu đúng',
    dataIndex: 'correct',
    key: 'correct',
    sorter: (a, b) => a.correct.localeCompare(b.correct)
  },
  {
    title: 'Thời gian làm bài',
    dataIndex: 'duration',
    key: 'duration',
    sorter: (a, b) => a.duration.localeCompare(b.duration)
  },
  {
    title: 'Thực thi',
    dataIndex: 'action',
    key: 'action',
    width: '6%'
  }
];

// Composable
const { getAll, loading } = useCRUD();

// Pagination
const {
  pagination,
  rowSelection,
  handleTableChange,
  onChangePagination,
  selectedRowKeys,
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
});

const onFilterOptions = (filterValue) => {
  state.filterOptions = filterValue;
  fetchData();
};

const onChangeToolbox = () => {
  fetchData();
};

const onDelete = (key) => {
  state.dataSource = state.dataSource.filter((item) => item.key !== key);
};

// Lifecycle hook
onMounted(fetchData);
</script>
