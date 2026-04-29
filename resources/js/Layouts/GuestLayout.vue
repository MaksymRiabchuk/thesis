<script setup lang="ts">
import {useFlashMessages} from "@/composables/useFlashMessages";
import 'vue-toast-notification/dist/theme-sugar.css';
useFlashMessages();
</script>

<template>
  <div class="flex min-h-screen flex-col items-center justify-center bg-slate-50 p-4">
    <slot />
  </div>
</template>

<style scoped></style>
