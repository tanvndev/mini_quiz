<template>
  <!-- Loading status -->
  <LoadingIndicator v-if="isLoading" />
  <div class="flex h-screen">
    <!-- Sidebar -->
    <SidebarComponent />
    <div class="flex w-full flex-1 flex-col">
      <!-- Header -->
      <HeaderComponent />
      <!-- Main -->
      <main class="h-full overflow-y-auto bg-[#f5f6f7]">
        <slot name="template"></slot>
      </main>
    </div>
  </div>
</template>

<script setup>
import { SidebarComponent, HeaderComponent, LoadingIndicator } from '@/components/backend';
import { useStore } from 'vuex';
import { useAntToast } from '@/utils/antToast';
import { computed, onMounted, watchEffect } from 'vue';
import { AuthService } from '@/services';

const { showMessage } = useAntToast();
const store = useStore();
const isShowToast = computed(() => store.getters['antStore/getIsShow']);
const isLoading = computed(() => store.getters['loadingStore/getIsLoading']);
const token = computed(() => store.getters['authStore/getToken']);

const setUserCurrent = async () => {
  if (token.value) {
    const user = await AuthService.me();
    store.commit('authStore/setUser', user.data);
  }
};

watchEffect(() => {
  if (isShowToast.value) {
    const type = store.getters['antStore/getType'];
    const message = store.getters['antStore/getMessage'];
    showMessage(type, message);
    store.dispatch('antStore/removeMessage');
  }
});

onMounted(() => {
  setUserCurrent();
});
</script>

<style scoped>
/* Style the scrollbar */
::-webkit-scrollbar {
  width: 5px; /* Default width of the scrollbar */
}

/* Style the track (part of the scrollbar not covered by the thumb) */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Style the draggable part of the scrollbar (thumb) */
::-webkit-scrollbar-thumb {
  background: #acacac;
  border-radius: 10px;
}

/* Change the thumb color when hovering */
::-webkit-scrollbar-thumb:hover {
  background: #797979;
}

/* Optional: Style the scrollbar in different states */
::-webkit-scrollbar:vertical {
  width: 5px; /* Ensure scrollbar width is consistent */
}

::-webkit-scrollbar:horizontal {
  height: 5px; /* Set height for horizontal scrollbar */
}
</style>
