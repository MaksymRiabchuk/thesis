<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { watch } from 'vue';
import InputErrorMessage from "@/components/Admin/InputErrorMessage.vue";
import {ForgotPasswordForm} from "@/types/auth/forgot-password";

defineOptions({
  layout: GuestLayout,
});

const form = useForm<ForgotPasswordForm>({
  email: '',
});

const onSubmit = async (): Promise<void> => {
  form.post(route('auth.forgot.send.password'));
};

watch(
    () => form.email,
    () => {
      form.clearErrors('email');
    }
);
</script>

<template>
  <div class="w-full max-w-md flex flex-col items-center rounded-lg border border-gray-200 bg-white p-6 shadow-lg">
    <h2 class="mb-6 text-2xl font-medium text-gray-800">Forgot Password</h2>

    <form class="w-full" @submit.prevent="onSubmit">
      <div class="mb-2">
        <Label for="email" class="text-sm font-medium" :is-error="!!form.errors.email">
          Email
        </Label>
        <Input
            required
            id="email"
            v-model="form.email"
            placeholder="example@gmail.com"
            name="email"
            type="email"
            :is-error="!!form.errors.email"
        />
        <InputErrorMessage :message="form.errors.email" />
      </div>

      <div class="mb-4 flex justify-between px-1 text-sm text-gray-500">
        <Link
            :href="route('auth.login')"
            class="hover:text-primary cursor-pointer"
        >
          Have an account?
        </Link>
        <Link :href="route('auth.register')" class="hover:text-primary cursor-pointer pr-1">
          Sign up
        </Link>
      </div>

      <div class="flex justify-center">
        <Button
            class="w-full cursor-pointer text-base"
            type="submit"
            :disabled="form.hasErrors"
            :loading="form.processing"
        >
          Send
        </Button>
      </div>
    </form>
  </div>
</template>