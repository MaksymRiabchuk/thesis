<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/components/Admin/Pagination.vue";
import SortableTh from "@/components/Admin/SortableTh.vue";
import {PlusIcon, ArrowLeftIcon, Edit3Icon} from 'lucide-vue-next';

defineOptions({
  layout: AdminLayout,
});

interface OfferRow {
  id: number;
  title: string;
  price_per_day: string;
  is_active: boolean;
  is_published: boolean;
  user: { id: number; name: string } | null;
  category: { id: number; name: string } | null;
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
  offers: Paginated<OfferRow>;
  sort?: string | null;
  direction?: 'asc' | 'desc' | null;
  personalOnly?: boolean;
}>();

function statusLabel(offer: OfferRow) {
  if (!offer.is_active) return {text: 'Inactive', class: 'bg-red-100 text-red-700'};
  if (!offer.is_published) return {text: 'Draft', class: 'bg-gray-100 text-gray-700'};
  return {text: 'Published', class: 'bg-[#edf7f0] text-[#369c4e]'};
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
          {{ props.personalOnly ? 'My Offers' : 'Current Offers' }}
        </h1>
        <p class="text-gray-500 text-[15px] mt-1">
          {{
            props.personalOnly
                ? 'Manage the product listings you have created.'
                : 'Manage all available product listings in the system.'
          }}
        </p>
      </div>

      <Link
          :href="route('admin.offers.create')"
          class="inline-flex items-center px-4 py-2.5 bg-[#369c4e] hover:bg-[#308b45] text-white w-36 lg:w-auto font-medium text-[15px] rounded-xl transition-colors shadow-sm"
      >
        <PlusIcon class="w-5 h-5 mr-1.5"/>
        Add Offer
      </Link>
    </div>

    <div class="bg-white rounded-[12px] shadow-sm border border-gray-100 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
          <tr class="border-b border-gray-100 bg-gray-50/50">
            <SortableTh column="title" label="Product Title" :sort="props.sort" :direction="props.direction"/>
            <SortableTh v-if="!props.personalOnly" column="user" label="User Name" :sort="props.sort" :direction="props.direction"/>
            <SortableTh column="category" label="Category" :sort="props.sort" :direction="props.direction"/>
            <SortableTh column="price_per_day" label="Price per Day" :sort="props.sort" :direction="props.direction"/>
            <th class="py-4 px-6 text-[13px] font-medium text-gray-500 uppercase tracking-wider">
              Status
            </th>
            <th class="py-4 px-6 text-right text-[13px] font-medium text-gray-500 uppercase tracking-wider">
              Actions
            </th>
          </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
          <tr :key="offer.id" class="hover:bg-gray-50/50 transition-colors" v-for="offer in props.offers.data">
            <td class="py-4 px-6 text-[14px] font-medium text-gray-900">
              {{ offer.title }}
            </td>
            <td v-if="!props.personalOnly" class="py-4 px-6 text-[14px] text-gray-600">
              {{ offer.user?.name ?? '—' }}
            </td>
            <td class="py-4 px-6">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[12px] font-medium bg-gray-100 text-gray-800">
                  {{ offer.category?.name ?? '—' }}
                </span>
            </td>
            <td class="py-4 px-6 text-[14px] font-medium text-gray-900">
              ${{ offer.price_per_day }}
            </td>
            <td class="py-4 px-6">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[12px] font-medium"
                    :class="statusLabel(offer).class"
                >
                  {{ statusLabel(offer).text }}
                </span>
            </td>
            <td class="py-4 px-6 text-right">
              <div class="flex justify-end items-center gap-1">
                <Link
                    class="text-gray-800 hover:text-primary ease-in-out transition-colors p-1.5 rounded-md hover:bg-gray-100 cursor-pointer"
                    :href="route('admin.offers.edit', offer.id)"
                >
                  <Edit3Icon class="w-3 h-3"/>
                </Link>
              </div>
            </td>
          </tr>
          <tr v-if="props.offers.data.length === 0">
            <td :colspan="props.personalOnly ? 5 : 6" class="py-8 px-6 text-center text-[14px] text-gray-500">
              No offers yet.
            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <Pagination :meta="props.offers"/>
    </div>
  </div>
</template>

<style scoped>

</style>