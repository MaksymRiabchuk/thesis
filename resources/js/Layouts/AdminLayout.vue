<script setup lang="ts">
import {Link, useForm, usePage} from '@inertiajs/vue3';
import {route} from 'ziggy-js';
import {computed, ref, watch} from "vue";
import {PageProps} from "@/types";
import { LucideSquareArrowRightExit, LucideSearchX, LucideMenu, LucideX } from 'lucide-vue-next';
import {useFlashMessages} from "@/composables/useFlashMessages";

useFlashMessages();
const form = useForm('post', route('auth.login'),{});
const page = usePage<PageProps>();
const user = page.props.auth.user;
const isSidebarOpen = ref(false);
// const isAdmin = computed(() => user?.roles.includes('admin'));
// const canManageUsers = computed(() => user?.permissions.includes('manage users'));

const navItems = computed(() => {
  const _url = page.url;
  return [
    {
      name: "Dashboard",
      href: route('admin.dashboard'),
      isActive: route().current('admin.dashboard'),
      isVisible: true
    },
    {
      name: "Offers",
      href: route('admin.offers'),
      isActive: route().current('admin.offers'),
      isVisible: true
    },
    {
      name: "Categories",
      href: route('admin.categories'),
      isActive: route().current('admin.categories') || route().current('admin.categories.*'),
      isVisible: user?.role === 'admin'
    },
    {
      name: "FAQ",
      href: route('admin.faqs'),
      isActive: route().current('admin.faqs') || route().current('admin.faqs.*'),
      isVisible: user?.role === 'admin'
    },
  ];
});

</script>

<template>
  <div class="min-h-screen bg-[#f3f4f6] flex font-sans">
    <div
        v-if="isSidebarOpen"
        @click="isSidebarOpen = false"
        class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm md:hidden transition-opacity"
    ></div>
    <aside :class="[
            'fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 flex flex-col transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0',
            isSidebarOpen ? 'translate-x-0' : '-translate-x-full'
        ]">
      <div class="h-16 flex items-center justify-between px-6 border-b border-gray-200 shrink-0">
          <span class="text-[20px] font-semibold text-[#111827]">
            RentApp Admin
          </span>
        <button @click="isSidebarOpen = false" class="md:hidden text-gray-500 hover:text-gray-900 focus:outline-none">
          <LucideX class="w-6 h-6" />
        </button>
      </div>

      <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto">
        <Link
            v-for="(navItem, index) in navItems"
            :key="`'nav-item-link'-${index}`"
            :href="navItem.href"
            v-show="navItem.isVisible"
            @click="isSidebarOpen = false"
            class="flex items-center px-3 py-2.5 rounded-xl text-[15px] font-medium transition-colors"
            :class="navItem.isActive?'bg-[#edf7f0] text-[#369c4e]':'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
        >
          {{navItem.name}}
        </Link>
      </nav>

      <div class="p-4 border-t border-gray-200">
        <div
            @click="()=>{
              form.post(route('auth.logout'));
            }"
            class="flex items-center cursor-pointer px-3 py-2.5 rounded-xl text-[15px] font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors"
        >
          <LucideSquareArrowRightExit class="w-5 h-5 mr-2 text-gray-400" />
          Logout
        </div>
      </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0 overflow-hidden relative z-0">
      <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 shrink-0 gap-4">
        <button
            @click="isSidebarOpen = true"
            class="md:hidden p-2 -ml-2 text-gray-600 hover:text-gray-900 focus:outline-none rounded-lg hover:bg-gray-100"
        >
          <LucideMenu class="w-6 h-6" />
        </button>
        <div class="flex-1 flex items-center">
          <div class="max-w-md w-full relative">
            <LucideSearchX class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
            <input
                type="text"
                placeholder="Search offers, users..."
                class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-[14px] focus:outline-none focus:ring-1 focus:ring-[#3c9f52] focus:border-[#3c9f52]"
            />
          </div>
        </div>

        <div class="flex items-center space-x-4">
          <div class="w-8 h-8 rounded-full bg-[#369c4e] flex items-center justify-center text-white font-medium text-[14px]">
            A
          </div>
        </div>
      </header>

      <div class="flex-1 overflow-auto p-4 sm:p-6 lg:p-8">
        <slot/>
      </div>
    </main>
  </div>
</template>

<style scoped></style>
