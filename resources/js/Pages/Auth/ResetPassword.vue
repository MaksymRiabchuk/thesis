<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import InputErrorMessage from "@/components/Admin/InputErrorMessage.vue";

const props = defineProps<{
  email: string;
  token: string;
}>();

defineOptions({
  layout: GuestLayout,
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
});

const onSubmit = () => {
  form.post(route('password.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <div class="w-full max-w-md flex flex-col items-center rounded-lg border border-gray-200 bg-white p-6 shadow-lg">
    <h2 class="mb-6 text-2xl font-medium text-gray-800">Reset Password</h2>

    <form class="w-full" @submit.prevent="onSubmit">
      <input type="hidden" v-model="form.email">
      <input type="hidden" v-model="form.token">

      <div class="mb-4">
        <Label for="password" class="text-sm font-medium" :is-error="!!form.errors.password">
          New Password
        </Label>
        <Input
            id="password"
            v-model="form.password"
            placeholder="*********"
            type="password"
            autocomplete="new-password"
            :is-error="!!form.errors.password"
        />
        <InputErrorMessage :message="form.errors.password" />
      </div>

      <div class="mb-6">
        <Label for="password_confirmation" class="text-sm font-medium">
          Confirm Password
        </Label>
        <Input
            id="password_confirmation"
            v-model="form.password_confirmation"
            placeholder="*********"
            type="password"
            autocomplete="new-password"
        />
        <InputErrorMessage :message="form.errors.password_confirmation" />
      </div>

      <div class="flex justify-center">
        <Button
            class="w-full text-base"
            type="submit"
            :loading="form.processing"
        >
          Reset Password
        </Button>
      </div>
    </form>
  </div>
</template>