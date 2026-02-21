<script setup lang="ts">
import {LoginForm} from "@/types/auth/login";
import {useForm} from "@inertiajs/vue3";
import {route} from "ziggy-js";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {Input} from "@/components/ui/input";

defineOptions({
    layout: GuestLayout,
});
const form = useForm<LoginForm>('post', route('auth.login'), {
    email: '',
    password: '',
});
const onSubmit = async (): Promise<void> => {
    console.log('Submit')
}
</script>

<template>
    <div class="max-w-md mx-auto flex justify-center items-center flex-col">
        <h2 class="text-2xl text-body font-medium">Login</h2>
        <form @submit.prevent="onSubmit">
            <div>
                <Input v-model="form.email" placeholder="Email" name="email" type="email" />
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
