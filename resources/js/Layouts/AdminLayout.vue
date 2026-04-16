<script setup lang="ts">
import AdminFooter from '@/components/Admin/AdminFooter.vue';
import AdminHeader from '@/components/Admin/AdminNavbar.vue';
import {useFlashMessages} from "@/composables/useFlashMessages";

useFlashMessages();
</script>

<template>
  <AdminHeader/>
  <div>
    <slot/>
  </div>
  <AdminFooter/>
</template>

<style scoped></style>
