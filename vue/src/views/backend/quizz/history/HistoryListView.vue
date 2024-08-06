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
            :pagination="pagination"
            :loading="loading"
            @change="handleTableChange"
          >
            <template #bodyCell="{ column, record }">
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
import { BreadcrumbComponent, MasterLayout } from '@/components/backend';
import { useCRUD, usePagination } from '@/composables';

// STATE
const state = reactive({
  pageTitle: 'Lịch sử làm bài của bạn',
  modelName: 'Quizz',
  routeCreate: 'quizz.store',
  routeUpdate: 'quizz.update',
  endpoint: 'quizzes/history/user',
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

const { getAll, loading } = useCRUD();

// Pagination
const { pagination, handleTableChange, onChangePagination, selectedRowKeys, selectedRows } =
  usePagination();

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

// Lifecycle hook
onMounted(fetchData);
</script>
