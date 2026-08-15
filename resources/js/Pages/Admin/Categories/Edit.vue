<script setup lang="ts">
import {Link, useForm} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {ArrowLeftIcon} from 'lucide-vue-next';
import {computed} from "vue";

defineOptions({
  layout: AdminLayout,
});

interface CategoryData {
  id: number;
  name: string;
}

const props = defineProps<{
  category: CategoryData | null;
}>();

const isEditing = computed(() => props.category !== null);

const form = useForm({
  name: props.category?.name ?? '',
});

function submit() {
  if (isEditing.value && props.category) {
    form.put(route('admin.categories.update', props.category.id));
  } else {
    form.post(route('admin.categories.store'));
  }
}
</script>

<template>
  <div class="mx-auto space-y-8">
    <Link
        :href="route('admin.categories')"
        class="inline-flex items-center gap-1.5 text-[14px] font-medium text-gray-500 hover:text-gray-900 transition-colors"
    >
      <ArrowLeftIcon class="w-4 h-4"/>
      Back
    </Link>

    <div>
      <h1 class="text-2xl font-semibold text-gray-900 tracking-tight mb-2">
        {{ isEditing ? 'Edit Category' : 'Create New Category' }}
      </h1>
      <p class="text-gray-500 text-[15px]">
        {{
          isEditing
              ? 'Update the name of this category.'
              : 'Add a new category offers can be listed under.'
        }}
      </p>
    </div>

    <div class="bg-white rounded-[12px] shadow-sm border border-gray-100 p-8">
      <form class="space-y-6" @submit.prevent="submit">
        <div class="space-y-1.5">
          <label class="block text-[14px] font-medium text-[#111827]">
            Category Name
          </label>
          <input
              v-model="form.name"
              type="text"
              placeholder="e.g. Cameras"
              class="w-full px-4 py-2.5 text-[15px] border border-[#e5e7eb] rounded-xl focus:outline-none focus:ring-1 focus:ring-[#3c9f52] focus:border-[#3c9f52] placeholder:text-[#9ca3af] text-[#111827]"
          />
          <p v-if="form.errors.name" class="text-[13px] text-red-500">{{ form.errors.name }}</p>
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
          <Link
              :href="route('admin.categories')"
              class="px-6 py-2.5 text-[15px] font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#369c4e]"
          >
            Cancel
          </Link>
          <button
              type="submit"
              :disabled="form.processing"
              class="px-6 py-2.5 text-[15px] font-medium text-white bg-[#369c4e] rounded-xl hover:bg-[#308b45] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#369c4e] shadow-sm disabled:opacity-60 disabled:cursor-not-allowed"
          >
            {{ form.processing ? 'Saving...' : (isEditing ? 'Save Changes' : 'Create Category') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>

</style>
