<template>
  <Box>
    <template #header>Upload Images</template>

    <form @submit.prevent="upload">
      <div class="flex flex-col gap-4 my-4">
        <div>
          <label class="block mb-2 font-medium">Upload a new image</label>
          <input
            type="file"
            multiple
            @change="addFiles"
            class="border rounded-md file:px-4 file:py-2 border-gray-200 dark:border-gray-700 file:text-gray-700 file:dark:text-gray-400 file:border-0 file:bg-gray-100 file:dark:bg-gray-800 file:font-medium file:hover:bg-gray-200 file:dark:hover:bg-gray-700 file:hover:cursor-pointer file:mr-4"
          />
        </div>

        <div>
          <div class="flex items-center justify-between mb-2">
            <label class="font-medium">Browse server images</label>
            <button type="button" class="text-sm underline" @click="loadLibrary">
              Refresh
            </button>
          </div>

          <div v-if="serverImages.length" class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <label
              v-for="image in serverImages"
              :key="image.path"
              class="border rounded-md p-2 cursor-pointer transition"
              :class="selectedServerImage === image.path ? 'ring-2 ring-blue-500' : 'hover:bg-gray-50 dark:hover:bg-gray-800'"
            >
              <input
                type="radio"
                class="sr-only"
                :value="image.path"
                v-model="selectedServerImage"
              />
              <img
                :src="image.src"
                :alt="image.name"
                class="w-full h-28 object-cover rounded"
              />
              <div class="text-xs mt-2 truncate">{{ image.name }}</div>
            </label>
          </div>

          <div v-else class="text-sm text-gray-500">
            No images found in storage/images.
          </div>
        </div>

        <div class="flex gap-2">
          <button
            :disabled="!canSubmit"
            type="submit"
            class="btn-outline"
            :class="{ 'cursor-not-allowed': !canSubmit, disabled: !canSubmit }"
          >
            Upload / Use Selected
          </button>

          <button @click="reset" type="button" class="btn-outline">
            Reset
          </button>
        </div>
      </div>
    </form>
  </Box>
</template>

<script setup>
import Box from '@/Components/UI/Box.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
  listing: Object,
  errors: Object,
});

const form = useForm({
  images: [],
  existing_image_path: null,
});

const serverImages = ref([]);
const selectedServerImage = ref(null);

const imageErrors = computed(() => Object.values(form.errors));
const canSubmit = computed(() => form.images.length > 0 || !!selectedServerImage.value);

const loadLibrary = async () => {
  const response = await axios.get(route('realtor.listing.image.library'));
  serverImages.value = response.data;
};

onMounted(loadLibrary);

const upload = () => {
  if (!canSubmit.value) return;

  form.existing_image_path = selectedServerImage.value;

  form.post(route('realtor.listing.image.store', { listing: props.listing.id }), {
    onSuccess: () => reset(),
  });
};

const addFiles = (event) => {
  form.images = [...event.target.files];
};

const reset = () => {
  form.reset();
  selectedServerImage.value = null;
};
</script>