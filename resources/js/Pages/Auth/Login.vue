<script setup lang="ts">
import {LoginForm} from '@/types/auth/login';
import {Link, useForm} from '@inertiajs/vue3';
import {route} from 'ziggy-js';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {Input} from '@/components/ui/input';
import {Label} from '@/components/ui/label';
import {Button} from '@/components/ui/button';
import {watch} from 'vue';

defineOptions({
    layout: GuestLayout,
});
const form = useForm<LoginForm>('post', route('auth.login'), {
    email: '',
    password: '',
});
const onSubmit = async (): Promise<void> => {
    form.post(route('auth.sign.in'), {
        onFinish: () => {
            console.log(form);
        },
    });
};

watch(
    () => form.email,
    () => {
        form.clearErrors('email');
    }
);
watch(
    () => form.password,
    () => {
        form.clearErrors('password');
    }
);
</script>

<template>
    <div
        class="mx-auto mt-100 flex w-full max-w-md flex-col items-center justify-center rounded-lg border border-gray-200 p-4 shadow-lg"
    >
        <h2 class="text-body mb-4 text-2xl font-medium">Login</h2>
        <form class="w-full" @submit.prevent="onSubmit">
            <div class="mb-4">
                <Label for="#email" class="text-sm font-medium" :is-error="!!form.errors.email"> Email </Label>
                <Input
                    required
                    id="#email"
                    v-model="form.email"
                    placeholder="example@gmail.com"
                    name="email"
                    type="email"
                    :is-error="!!form.errors.email"
                />
            </div>
            <div class="mb-1">
                <Label for="#password" class="text-sm font-medium" :is-error="!!form.errors.password">
                    Password </Label>
                <Input
                    required
                    id="#password"
                    v-model="form.password"
                    placeholder="*********"
                    name="password"
                    type="password"
                    :is-error="!!form.errors.password"
                />
            </div>
            <div class="mb-4 flex justify-between pl-1 text-xs text-gray-500">
                <Link
                    :href="route('auth.forgot.password')"
                    class="hover:text-primary cursor-pointer"
                >
                    Forgot password?
                </Link>
                <Link :href="route('auth.register')" class="hover:text-primary cursor-pointer pr-1">
                    Sign up
                </Link>
            </div>
            <div class="flex justify-center">
                <Button class="w-full cursor-pointer text-lg" type="submit" :disabled="form.hasErrors" :loading="form.processing"> Login</Button>
            </div>
        </form>
    </div>
</template>

<style scoped></style>
