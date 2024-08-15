<template>
    <MasterLayout>
        <template #template>
            <div class="container mx-auto h-screen">
                <BreadcrumbComponent :titlePage="state.pageTitle" />

                <!-- Toolbox -->
                <ToolboxComponent :routeCreate="state.routeCreate" :modelName="state.modelName"
                    :isShowToolbox="state.isShowToolbox" :modelIds="state.modelIds" @onChangeToolbox="onChangeToolbox">
                    <template #extend>
                        <!-- Upload file excel -->
                        <UploadView @on-upload="handleOnUpload" />
                    </template>
                </ToolboxComponent>
                <!-- End toolbox -->

                <!-- Filter -->
                <FilterComponent @onFilter="onFilterOptions" />
                <!-- End filter -->

                <!-- Table -->
                <a-card class="mt-3">
                    <a-table bordered :columns="columns" :data-source="state.dataSource" :row-selection="rowSelection"
                        :pagination="pagination" :loading="loading" @change="handleTableChange">
                        <template #bodyCell="{ column, record }">
                            <template v-if="column.dataIndex === 'content'">
                                <div class="content-html" v-html="record.content"></div>
                            </template>
                            <template v-if="column.dataIndex === 'type'">
                                {{ typeText(record.type) }}
                            </template>

                            <template v-if="column.dataIndex === 'action'">
                                <ActionComponent @onDelete="onDelete" :id="record.id" :routeUpdate="state.routeUpdate"
                                    :endpoint="state.endpoint" />
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
                </a-card>
                <!-- End table -->
            </div>
        </template>
    </MasterLayout>
</template>

<script setup>
import { computed, onMounted, reactive, watch } from 'vue';
import {
    BreadcrumbComponent,
    MasterLayout,
    FilterComponent,
    ToolboxComponent,
    ActionComponent
} from '@/components/backend';
import { useCRUD, usePagination } from '@/composables';
import { QUESTION_TYPE } from '@/static/constants';
import UploadView from './partials/UploadView.vue';

// STATE
const state = reactive({
    pageTitle: 'Danh sách câu hỏi',
    modelName: 'Question',
    routeCreate: 'question.store',
    routeUpdate: 'question.update',
    endpoint: 'questions',
    isShowToolbox: false,
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
        width: '12%'
    },
    {
        title: 'Chủ đề',
        dataIndex: 'topic_name',
        key: 'topic_name',
        sorter: (a, b) => a.topic_name.localeCompare(b.topic_name)
    },
    {
        title: 'Thực thi',
        dataIndex: 'action',
        key: 'action',
        width: '6%'
    }
];

const { getAll, loading } = useCRUD();

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
});

const onFilterOptions = (filterValue) => {
    state.filterOptions = filterValue;
    fetchData();
};

const onChangeToolbox = () => {
    fetchData();
};

const handleOnUpload = () => {
    fetchData();
};

const onDelete = (key) => {
    state.dataSource = state.dataSource.filter((item) => item.key !== key);
};

// Lifecycle hook
onMounted(fetchData);
</script>
<style scoped>
.content-html {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}
</style>
