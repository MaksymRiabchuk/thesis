<script setup lang="ts">
import { AlertCircle } from 'lucide-vue-next';
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';

const props = defineProps<{
  message?: string;
  class?: HTMLAttributes['class'];
}>();
</script>

<template>
  <p
      v-if="message"
      :class="cn('text-[0.8rem] font-medium text-destructive flex items-center gap-1.5 mt-1.5', props.class)"
  >
    <AlertCircle class="h-3.5 w-3.5 shrink-0" />
    <span>{{ message }}</span>
  </p>
</template>