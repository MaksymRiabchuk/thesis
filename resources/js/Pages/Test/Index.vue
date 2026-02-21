<script setup lang="ts">
import {usePage} from '@inertiajs/vue3';
import {PageProps} from '@/types';
import GuestLayout from "@/Layouts/GuestLayout.vue";

defineOptions({
    layout: GuestLayout,
});
const page = usePage<PageProps>();
// const user = page.props.auth.user;
// defineProps<{
//     articles: Array<{ id: number; title: string }>;
// }>();

</script>

<template>
    <div>
        efe
    </div>
</template>
