<script setup lang="ts">
import {Link, router} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/components/Admin/Pagination.vue";
import SortableTh from "@/components/Admin/SortableTh.vue";
import {PlusIcon, Edit3Icon, ArrowLeftIcon, Trash2Icon} from 'lucide-vue-next';

defineOptions({
  layout: AdminLayout,
});

interface CategoryRow {
  id: number;
  name: string;
  slug: string;
  offers_count: number;
}

interface Paginated<T> {
  data: T[];
  current_page: number;
  last_page: number;
  from: number | null;
  to: number | null;
  total: number;
  prev_page_url: string | null;
  next_page_url: string | null;
}

const props = defineProps<{
  categories: Paginated<CategoryRow>;
  sort?: string | null;
  direction?: 'asc' | 'desc' | null;
}>();

function destroyCategory(category: CategoryRow) {
  if (!confirm(`Delete category "${category.name}"?`)) return;
  router.delete(route('admin.categories.destroy', category.id));
}
</script>

<template>
  <div class="mx-auto space-y-6">
    <Link
        :href="route('admin.dashboard')"
        class="inline-flex items-center gap-1.5 text-[14px] font-medium text-gray-500 hover:text-gray-900 transition-colors"
    >
      <ArrowLeftIcon class="w-4 h-4"/>
      Back
    </Link>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">
          Categories
        </h1>
        <p class="text-gray-500 text-[15px] mt-1">
          Manage the categories offers can be listed under.
        </p>
      </div>

      <Link
          :href="route('admin.categories.create')"
          class="inline-flex items-center px-4 py-2.5 bg-[#369c4e] hover:bg-[#308b45] text-white w-36 lg:w-auto font-medium text-[15px] rounded-xl transition-colors shadow-sm"
      >
        <PlusIcon class="w-5 h-5 mr-1.5"/>
        Add Category
      </Link>
    </div>

    <div class="bg-white rounded-[12px] shadow-sm border border-gray-100 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
          <tr class="border-b border-gray-100 bg-gray-50/50">
            <SortableTh column="name" label="Name" :sort="props.sort" :direction="props.direction"/>
            <SortableTh column="slug" label="Slug" :sort="props.sort" :direction="props.direction"/>
            <SortableTh column="offers_count" label="Offers" :sort="props.sort" :direction="props.direction"/>
            <th class="py-4 px-6 text-right text-[13px] font-medium text-gray-500 uppercase tracking-wider">
              Actions
            </th>
          </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
          <tr :key="category.id" class="hover:bg-gray-50/50 transition-colors" v-for="category in props.categories.data">
            <td class="py-4 px-6 text-[14px] font-medium text-gray-900">
              {{ category.name }}
            </td>
            <td class="py-4 px-6 text-[14px] text-gray-600">
              {{ category.slug }}
            </td>
            <td class="py-4 px-6 text-[14px] text-gray-600">
              {{ category.offers_count }}
            </td>
            <td class="py-4 px-6 text-right">
              <div class="flex justify-end items-center gap-1">
                <Link
                    class="text-gray-800 hover:text-primary ease-in-out transition-colors p-1.5 rounded-md hover:bg-gray-100 cursor-pointer"
                    :href="route('admin.categories.edit', category.id)"
                >
                  <Edit3Icon class="w-3 h-3"/>
                </Link>
                <button
                    type="button"
                    @click="destroyCategory(category)"
                    class="text-gray-800 hover:text-red-600 ease-in-out transition-colors p-1.5 rounded-md hover:bg-gray-100 cursor-pointer"
                >
                  <Trash2Icon class="w-3 h-3"/>
                </button>
              </div>
            </td>
          </tr>
          <tr v-if="props.categories.data.length === 0">
            <td colspan="4" class="py-8 px-6 text-center text-[14px] text-gray-500">
              No categories yet.
            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <Pagination :meta="props.categories"/>
    </div>
  </div>
</template>

<style scoped>

</style>
