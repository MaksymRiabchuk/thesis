<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {PlusIcon, Edit3Icon} from 'lucide-vue-next';

defineOptions({
  layout: AdminLayout,
});
const mockOffers = [
  {id: 1, title: "Sony A7III Camera", owner: "John Doe", category: "Electronics", price: 45},
  {id: 2, title: "Mountain Bike (Trek)", owner: "Alice Smith", category: "Sports & Outdoors", price: 20},
  {id: 3, title: "DJI Mavic Pro", owner: "Robert Johnson", category: "Electronics", price: 35},
  {id: 4, title: "Camping Tent 4-person", owner: "Emily Davis", category: "Outdoors", price: 15},
  {id: 5, title: "Bosch Power Drill", owner: "Michael Brown", category: "Tools & Hardware", price: 10},
  {id: 6, title: "Portable Projector", owner: "Sarah Wilson", category: "Electronics", price: 25},
];

</script>

<template>
  <div class="mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">
          Current Offers
        </h1>
        <p class="text-gray-500 text-[15px] mt-1">
          Manage all available product listings in the system.
        </p>
      </div>

      <Link
          to="/dashboard/add-offer"
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
            <th class="py-4 px-6 text-[13px] font-medium text-gray-500 uppercase tracking-wider">
              Product Title
            </th>
            <th class="py-4 px-6 text-[13px] font-medium text-gray-500 uppercase tracking-wider">
              User Name
            </th>
            <th class="py-4 px-6 text-[13px] font-medium text-gray-500 uppercase tracking-wider">
              Category
            </th>
            <th class="py-4 px-6 text-[13px] font-medium text-gray-500 uppercase tracking-wider">
              Price per Day
            </th>
            <th class="py-4 px-6 text-right text-[13px] font-medium text-gray-500 uppercase tracking-wider">
              Actions
            </th>
          </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
          <tr key={offer.id} class="hover:bg-gray-50/50 transition-colors" v-for="(offer,) in mockOffers">
            <td class="py-4 px-6 text-[14px] font-medium text-gray-900">
              {{ offer.title }}
            </td>
            <td class="py-4 px-6 text-[14px] text-gray-600">
              {{ offer.owner }}
            </td>
            <td class="py-4 px-6">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[12px] font-medium bg-gray-100 text-gray-800">
                  {{ offer.category }}
                </span>
            </td>
            <td class="py-4 px-6 text-[14px] font-medium text-gray-900">
              ${{ offer.price }}
            </td>
            <td class="py-4 px-6 text-right">
              <Link
                  class="text-gray-800 hover:text-primary ease-in-out transition-colors p-1.5 rounded-md hover:bg-gray-100 cursor-pointer"
                  :href="route('admin.offers.edit')"
              >

                <Edit3Icon class="w-3 h-3"/>
              </Link>
            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30 flex items-center justify-between">
          <span class="text-[13px] text-gray-500">
            Showing 1 to {{ mockOffers.length }} of {{ mockOffers.length }} results
          </span>
        <div class="flex gap-2">
          <button
              class="px-3 py-1 text-[13px] font-medium text-gray-400 bg-white border border-gray-200 rounded-[6px] cursor-not-allowed">
            Previous
          </button>
          <button
              class="px-3 py-1 text-[13px] font-medium text-gray-600 bg-white border border-gray-200 rounded-[6px] hover:bg-gray-50">
            Next
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>