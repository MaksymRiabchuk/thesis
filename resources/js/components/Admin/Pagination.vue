<script setup lang="ts">
import {router} from "@inertiajs/vue3";
import {ChevronLeftIcon, ChevronRightIcon} from 'lucide-vue-next';
import {computed} from "vue";

interface PaginationLink {
  url: string | null;
  label: string;
  active: boolean;
}

interface PaginationMeta {
  path: string;
  current_page: number;
  last_page: number;
  per_page: number;
  from: number | null;
  to: number | null;
  total: number;
  prev_page_url: string | null;
  next_page_url: string | null;
  links: PaginationLink[];
}

const props = defineProps<{
  meta: PaginationMeta;
  perPageOptions?: number[];
}>();

const perPageOptions = computed(() => props.perPageOptions ?? [10, 25, 50, 100]);

const pageLinks = computed(() => props.meta.links.slice(1, -1));

function goToPage(url: string | null) {
  if (!url) return;
  router.get(url, {}, {preserveState: true, preserveScroll: true});
}

function onPerPageChange(event: Event) {
  const perPage = (event.target as HTMLSelectElement).value;
  const params = new URLSearchParams(window.location.search);
  params.set('per_page', perPage);
  params.delete('page');

  router.get(`${props.meta.path}?${params.toString()}`, {}, {preserveState: true, preserveScroll: true});
}
</script>

<template>
  <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30 flex flex-col sm:flex-row items-center justify-between gap-3">
    <div class="flex items-center gap-4">
      <span class="text-[13px] text-gray-500">
        Showing {{ props.meta.from ?? 0 }} to {{ props.meta.to ?? 0 }} of {{ props.meta.total }} results
      </span>

      <label class="flex items-center gap-2 text-[13px] text-gray-500">
        Rows per page
        <select
            :value="props.meta.per_page"
            @change="onPerPageChange"
            class="px-2 py-1 text-[13px] border border-gray-200 rounded-[6px] bg-white text-gray-700 focus:outline-none focus:ring-1 focus:ring-[#3c9f52] focus:border-[#3c9f52]"
        >
          <option v-for="option in perPageOptions" :key="option" :value="option">{{ option }}</option>
        </select>
      </label>
    </div>

    <div class="flex items-center gap-1">
      <button
          type="button"
          :disabled="!props.meta.prev_page_url"
          @click="goToPage(props.meta.prev_page_url)"
          class="inline-flex items-center justify-center w-8 h-8 text-gray-600 bg-white border border-gray-200 rounded-[6px] hover:bg-gray-50 disabled:text-gray-300 disabled:cursor-not-allowed disabled:hover:bg-white"
      >
        <ChevronLeftIcon class="w-4 h-4"/>
      </button>

      <template v-for="(link, index) in pageLinks" :key="index">
        <span
            v-if="link.label === '...'"
            class="w-8 h-8 inline-flex items-center justify-center text-[13px] text-gray-400"
        >
          …
        </span>
        <button
            v-else
            type="button"
            @click="goToPage(link.url)"
            :disabled="link.active"
            class="w-8 h-8 inline-flex items-center justify-center text-[13px] font-medium rounded-[6px] border transition-colors"
            :class="link.active
              ? 'bg-[#369c4e] border-[#369c4e] text-white cursor-default'
              : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50 cursor-pointer'"
        >
          {{ link.label }}
        </button>
      </template>

      <button
          type="button"
          :disabled="!props.meta.next_page_url"
          @click="goToPage(props.meta.next_page_url)"
          class="inline-flex items-center justify-center w-8 h-8 text-gray-600 bg-white border border-gray-200 rounded-[6px] hover:bg-gray-50 disabled:text-gray-300 disabled:cursor-not-allowed disabled:hover:bg-white"
      >
        <ChevronRightIcon class="w-4 h-4"/>
      </button>
    </div>
  </div>
</template>

<style scoped>

</style>
