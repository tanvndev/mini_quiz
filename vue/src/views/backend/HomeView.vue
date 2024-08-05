<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto mt-5 h-screen">
        <a-row :gutter="[16, 16]">
          <a-col span="4" v-for="quizz in state.quizzes" :key="quizz.id">
            <a-card hoverable>
              <template #cover>
                <img :alt="quizz.title" :src="quizz.image" />
              </template>
              <a-card-meta>
                <template #title>
                  <RouterLink :to="{ name: 'quizz.do', params: { canonical: quizz.canonical } }">
                    {{ quizz.title }}
                  </RouterLink>
                </template>
              </a-card-meta>
            </a-card>
          </a-col>
        </a-row>
      </div>
    </template>
  </MasterLayout>
</template>

<script setup>
import { MasterLayout } from '@/components/backend';
import { useCRUD } from '@/composables';
import { onMounted, reactive } from 'vue';
import { RouterLink } from 'vue-router';
const { getAll, data } = useCRUD();

const state = reactive({
  quizzes: []
});

const getQuizzs = async () => {
  await getAll('quizzes');
  state.quizzes = data.value;
};

onMounted(() => {
  getQuizzs();
});
</script>
