<script setup lang="ts">
import {router} from "@inertiajs/vue3";
import {ArrowUpIcon, ArrowDownIcon, ChevronsUpDownIcon} from 'lucide-vue-next';
import {computed} from "vue";

const props = defineProps<{
  column: string;
  label: string;
  sort?: string | null;
  direction?: 'asc' | 'desc' | null;
  align?: 'left' | 'right';
}>();

const isActive = computed(() => props.sort === props.column);

function toggleSort() {
  const params = new URLSearchParams(window.location.search);

  let nextDirection: 'asc' | 'desc' | null;
  if (!isActive.value) {
    nextDirection = 'asc';
  } else if (props.direction === 'asc') {
    nextDirection = 'desc';
  } else {
    nextDirection = null;
  }

  if (nextDirection) {
    params.set('sort', props.column);
    params.set('direction', nextDirection);
  } else {
    params.delete('sort');
    params.delete('direction');
  }
  params.delete('page');

  const query = params.toString();
  router.get(`${window.location.pathname}${query ? `?${query}` : ''}`, {}, {preserveState: true, preserveScroll: true});
}
</script>

<template>
  <th
      class="py-4 px-6 text-[13px] font-medium text-gray-500 uppercase tracking-wider cursor-pointer select-none hover:text-gray-700 transition-colors"
      :class="align === 'right' ? 'text-right' : 'text-left'"
      @click="toggleSort"
  >
    <span class="inline-flex items-center gap-1" :class="align === 'right' ? 'justify-end' : ''">
      {{ label }}
      <ArrowUpIcon v-if="isActive && direction === 'asc'" class="w-3 h-3"/>
      <ArrowDownIcon v-else-if="isActive && direction === 'desc'" class="w-3 h-3"/>
      <ChevronsUpDownIcon v-else class="w-3 h-3 text-gray-300"/>
    </span>
  </th>
</template>

<style scoped>
</style>
