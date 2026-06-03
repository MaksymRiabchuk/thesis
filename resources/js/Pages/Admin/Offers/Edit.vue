<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {CloudUploadIcon} from 'lucide-vue-next';

defineOptions({
  layout: AdminLayout,
});
</script>

<template>
  <div class="mx-auto space-y-8">
    <div>
      <h1 class="text-2xl font-semibold text-gray-900 tracking-tight mb-2">
        Create New Offer
      </h1>
      <p class="text-gray-500 text-[15px]">
        List a new product for other users to rent. Fill out the details below.
      </p>
    </div>

    <div class="bg-white rounded-[12px] shadow-sm border border-gray-100 p-8">
      <form class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-1.5">
            <label class="block text-[14px] font-medium text-[#111827]">
              Product Title
            </label>
            <input
                type="text"
                placeholder="e.g. Sony A7III Camera"
                class="w-full px-4 py-2.5 text-[15px] border border-[#e5e7eb] rounded-xl focus:outline-none focus:ring-1 focus:ring-[#3c9f52] focus:border-[#3c9f52] placeholder:text-[#9ca3af] text-[#111827]"
            />
          </div>

          <div class="space-y-1.5">
            <label class="block text-[14px] font-medium text-[#111827]">
              Category
            </label>
            <select
                class="w-full px-4 py-2.5 text-[15px] border border-[#e5e7eb] rounded-xl focus:outline-none focus:ring-1 focus:ring-[#3c9f52] focus:border-[#3c9f52] bg-white text-[#111827]">
              <option value="">Select a category</option>
              <option value="electronics">Electronics</option>
              <option value="tools">Tools & Hardware</option>
              <option value="sports">Sports & Outdoors</option>
              <option value="vehicles">Vehicles</option>
            </select>
          </div>
        </div>

        <div class="space-y-1.5">
          <label class="block text-[14px] font-medium text-[#111827]">
            Description
          </label>
          <textarea
              rows={4}
              placeholder="Describe your product in detail..."
              class="w-full px-4 py-2.5 text-[15px] border border-[#e5e7eb] rounded-xl focus:outline-none focus:ring-1 focus:ring-[#3c9f52] focus:border-[#3c9f52] placeholder:text-[#9ca3af] text-[#111827] resize-none"
          />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-1.5">
            <label class="block text-[14px] font-medium text-[#111827]">
              Price per Day ($)
            </label>
            <input
                type="number"
                placeholder="0.00"
                min="0"
                @keydown="(e) => ['-', 'e', 'E', '+'].includes(e.key) && e.preventDefault()"
                class="w-full px-4 py-2.5 text-[15px] border border-[#e5e7eb] rounded-xl focus:outline-none focus:ring-1 focus:ring-[#3c9f52] focus:border-[#3c9f52] placeholder:text-[#9ca3af] text-[#111827]"
            />
          </div>

          <div class="space-y-1.5">
            <label class="block text-[14px] font-medium text-[#111827]">
              Available Units
            </label>
            <input
                type="number"
                placeholder="1"
                min="0"
                @keydown="(e) => ['-', 'e', 'E', '+'].includes(e.key) && e.preventDefault()"
                class="w-full px-4 py-2.5 text-[15px] border border-[#e5e7eb] rounded-xl focus:outline-none focus:ring-1 focus:ring-[#3c9f52] focus:border-[#3c9f52] placeholder:text-[#9ca3af] text-[#111827]"
            />
          </div>
        </div>

        <div class="space-y-1.5">
          <label class="block text-[14px] font-medium text-[#111827]">
            Product Images
          </label>
          <div
              class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-[10px] hover:border-[#369c4e] transition-colors cursor-pointer bg-gray-50">
            <div class="space-y-2 text-center">
              <CloudUploadIcon class="mx-auto h-10 w-10 text-gray-400"/>
              <div class="flex text-[14px] text-gray-600 justify-center">
                  <span
                      class="relative rounded-md font-medium text-[#369c4e] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#369c4e]">
                    Upload a file
                  </span>
                <p class="pl-1">or drag and drop</p>
              </div>
              <p class="text-[12px] text-gray-500">
                PNG, JPG, GIF up to 10MB
              </p>
            </div>
          </div>
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
          <button
              type="button"
              class="px-6 py-2.5 text-[15px] font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#369c4e]"
          >
            Cancel
          </button>
          <button
              type="submit"
              class="px-6 py-2.5 text-[15px] font-medium text-white bg-[#369c4e] rounded-xl hover:bg-[#308b45] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#369c4e] shadow-sm"
          >
            Publish Offer
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>

</style>