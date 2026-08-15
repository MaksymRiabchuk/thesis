<script setup lang="ts">
import {Link, useForm} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {CloudUploadIcon, ArrowLeftIcon, XIcon} from 'lucide-vue-next';
import {computed, ref} from "vue";
import {Toggle} from "@/components/ui/toggle";

defineOptions({
  layout: AdminLayout,
});

interface Category {
  id: number;
  name: string;
}

interface OfferImage {
  id: number;
  path: string;
}

interface OfferData {
  id: number;
  title: string;
  description: string | null;
  price_per_day: string;
  quantity: number;
  category_id: number;
  is_active: boolean;
  is_published: boolean;
  images: OfferImage[];
}

const props = defineProps<{
  categories: Category[];
  offer: OfferData | null;
}>();

const isEditing = computed(() => props.offer !== null);

const existingImages = ref<OfferImage[]>(props.offer?.images ? [...props.offer.images] : []);
const fileInput = ref<HTMLInputElement | null>(null);

const form = useForm({
  title: props.offer?.title ?? '',
  category_id: props.offer?.category_id ?? ('' as number | ''),
  description: props.offer?.description ?? '',
  price_per_day: props.offer?.price_per_day ?? '',
  quantity: props.offer?.quantity ?? 1,
  is_active: props.offer?.is_active ?? true,
  is_published: props.offer?.is_published ?? false,
  images: [] as File[],
  removed_image_ids: [] as number[],
});

const newImagePreviews = computed(() =>
    form.images.map((file) => ({file, url: URL.createObjectURL(file)}))
);

function openFilePicker() {
  fileInput.value?.click();
}

function onFilesSelected(event: Event) {
  const files = (event.target as HTMLInputElement).files;
  if (!files) return;

  form.images = [...form.images, ...Array.from(files)];
  (event.target as HTMLInputElement).value = '';
}

function removeNewImage(index: number) {
  form.images = form.images.filter((_, i) => i !== index);
}

function removeExistingImage(image: OfferImage) {
  form.removed_image_ids = [...form.removed_image_ids, image.id];
  existingImages.value = existingImages.value.filter((img) => img.id !== image.id);
}

function submit() {
  if (isEditing.value && props.offer) {
    form.put(route('admin.offers.update', props.offer.id), {forceFormData: true});
  } else {
    form.post(route('admin.offers.store'), {forceFormData: true});
  }
}
</script>

<template>
  <div class="mx-auto space-y-8">
    <Link
        :href="route('admin.offers')"
        class="inline-flex items-center gap-1.5 text-[14px] font-medium text-gray-500 hover:text-gray-900 transition-colors"
    >
      <ArrowLeftIcon class="w-4 h-4"/>
      Back
    </Link>

    <div>
      <h1 class="text-2xl font-semibold text-gray-900 tracking-tight mb-2">
        {{ isEditing ? 'Edit Offer' : 'Create New Offer' }}
      </h1>
      <p class="text-gray-500 text-[15px]">
        {{
          isEditing
              ? 'Update the details of this listing.'
              : 'List a new product for other users to rent. Fill out the details below.'
        }}
      </p>
    </div>

    <div class="bg-white rounded-[12px] shadow-sm border border-gray-100 p-8">
      <form class="space-y-6" @submit.prevent="submit">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-1.5">
            <label class="block text-[14px] font-medium text-[#111827]">
              Product Title
            </label>
            <input
                v-model="form.title"
                type="text"
                placeholder="e.g. Sony A7III Camera"
                class="w-full px-4 py-2.5 text-[15px] border border-[#e5e7eb] rounded-xl focus:outline-none focus:ring-1 focus:ring-[#3c9f52] focus:border-[#3c9f52] placeholder:text-[#9ca3af] text-[#111827]"
            />
            <p v-if="form.errors.title" class="text-[13px] text-red-500">{{ form.errors.title }}</p>
          </div>

          <div class="space-y-1.5">
            <label class="block text-[14px] font-medium text-[#111827]">
              Category
            </label>
            <select
                v-model="form.category_id"
                class="w-full px-4 py-2.5 text-[15px] border border-[#e5e7eb] rounded-xl focus:outline-none focus:ring-1 focus:ring-[#3c9f52] focus:border-[#3c9f52] bg-white text-[#111827]">
              <option value="">Select a category</option>
              <option v-for="category in props.categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
            <p v-if="form.errors.category_id" class="text-[13px] text-red-500">{{ form.errors.category_id }}</p>
          </div>
        </div>

        <div class="space-y-1.5">
          <label class="block text-[14px] font-medium text-[#111827]">
            Description
          </label>
          <textarea
              v-model="form.description"
              :rows="4"
              placeholder="Describe your product in detail..."
              class="w-full px-4 py-2.5 text-[15px] border border-[#e5e7eb] rounded-xl focus:outline-none focus:ring-1 focus:ring-[#3c9f52] focus:border-[#3c9f52] placeholder:text-[#9ca3af] text-[#111827] resize-none"
          />
          <p v-if="form.errors.description" class="text-[13px] text-red-500">{{ form.errors.description }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-1.5">
            <label class="block text-[14px] font-medium text-[#111827]">
              Price per Day ($)
            </label>
            <input
                v-model="form.price_per_day"
                type="number"
                placeholder="0.00"
                min="0"
                @keydown="(e) => ['-', 'e', 'E', '+'].includes(e.key) && e.preventDefault()"
                class="w-full px-4 py-2.5 text-[15px] border border-[#e5e7eb] rounded-xl focus:outline-none focus:ring-1 focus:ring-[#3c9f52] focus:border-[#3c9f52] placeholder:text-[#9ca3af] text-[#111827]"
            />
            <p v-if="form.errors.price_per_day" class="text-[13px] text-red-500">{{ form.errors.price_per_day }}</p>
          </div>

          <div class="space-y-1.5">
            <label class="block text-[14px] font-medium text-[#111827]">
              Available Units
            </label>
            <input
                v-model="form.quantity"
                type="number"
                placeholder="1"
                min="0"
                @keydown="(e) => ['-', 'e', 'E', '+'].includes(e.key) && e.preventDefault()"
                class="w-full px-4 py-2.5 text-[15px] border border-[#e5e7eb] rounded-xl focus:outline-none focus:ring-1 focus:ring-[#3c9f52] focus:border-[#3c9f52] placeholder:text-[#9ca3af] text-[#111827]"
            />
            <p v-if="form.errors.quantity" class="text-[13px] text-red-500">{{ form.errors.quantity }}</p>
          </div>
        </div>

        <div class="flex gap-8">
          <label class="inline-flex items-center gap-2.5 text-[14px] font-medium text-[#111827] cursor-pointer">
            <Toggle v-model="form.is_active"/>
            Active
          </label>
          <label class="inline-flex items-center gap-2.5 text-[14px] font-medium text-[#111827] cursor-pointer">
            <Toggle v-model="form.is_published"/>
            Published
          </label>
        </div>

        <div class="space-y-1.5">
          <label class="block text-[14px] font-medium text-[#111827]">
            Product Images
          </label>

          <div v-if="existingImages.length || newImagePreviews.length" class="flex flex-wrap gap-3 mb-3">
            <div v-for="image in existingImages" :key="`existing-${image.id}`" class="relative">
              <img :src="image.path" class="w-20 h-20 object-cover rounded-lg border border-gray-200" alt="Offer image"/>
              <button
                  type="button"
                  @click="removeExistingImage(image)"
                  class="absolute -top-2 -right-2 bg-white border border-gray-200 rounded-full p-1 text-gray-500 hover:text-red-600 shadow-sm"
              >
                <XIcon class="w-3 h-3"/>
              </button>
            </div>
            <div v-for="(preview, index) in newImagePreviews" :key="`new-${index}`" class="relative">
              <img :src="preview.url" class="w-20 h-20 object-cover rounded-lg border border-gray-200" alt="New image"/>
              <button
                  type="button"
                  @click="removeNewImage(index)"
                  class="absolute -top-2 -right-2 bg-white border border-gray-200 rounded-full p-1 text-gray-500 hover:text-red-600 shadow-sm"
              >
                <XIcon class="w-3 h-3"/>
              </button>
            </div>
          </div>

          <input ref="fileInput" type="file" accept="image/*" multiple class="hidden" @change="onFilesSelected"/>
          <div
              @click="openFilePicker"
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
          <p v-if="form.errors.images" class="text-[13px] text-red-500">{{ form.errors.images }}</p>
        </div>

        <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
          <Link
              :href="route('admin.offers')"
              class="px-6 py-2.5 text-[15px] font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#369c4e]"
          >
            Cancel
          </Link>
          <button
              type="submit"
              :disabled="form.processing"
              class="px-6 py-2.5 text-[15px] font-medium text-white bg-[#369c4e] rounded-xl hover:bg-[#308b45] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#369c4e] shadow-sm disabled:opacity-60 disabled:cursor-not-allowed"
          >
            {{ form.processing ? 'Saving...' : (isEditing ? 'Save Changes' : 'Publish Offer') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>

</style>