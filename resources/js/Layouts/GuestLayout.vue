<script setup lang="ts">
import {useFlashMessages} from "@/composables/useFlashMessages";
import 'vue-toast-notification/dist/theme-sugar.css';
useFlashMessages();
</script>

<template>
  <div class="flex min-h-screen flex-col bg-slate-50">
    <slot/>
  </div>
</template>

<style scoped></style>
