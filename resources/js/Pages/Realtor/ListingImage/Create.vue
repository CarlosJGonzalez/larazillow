<template>
  <Box>
    <template #header>Upload Images</template>

    <form @submit.prevent="upload">
      <div class="flex flex-col gap-4 my-4">
        <div>
          <label class="block mb-2 font-medium">Upload new images</label>
          <input
            type="file"
            multiple
            @change="addFiles"
            class="border rounded-md file:px-4 file:py-2 border-gray-200 dark:border-gray-700 file:text-gray-700 file:dark:text-gray-400 file:border-0 file:bg-gray-100 file:dark:bg-gray-800 file:font-medium file:hover:bg-gray-200 file:dark:hover:bg-gray-700 file:hover:cursor-pointer file:mr-4"
          />
        </div>

        <div class="flex gap-2">
          <button
            :disabled="!form.images.length"
            type="submit"
            class="btn-outline"
            :class="{ 'cursor-not-allowed': !form.images.length, disabled: !form.images.length }"
          >
            Upload
          </button>

          <button @click="reset" type="button" class="btn-outline">
            Reset
          </button>
        </div>
      </div>
    </form>
  </Box>

  <Box class="mt-4" v-if="currentImages.length">
    <template #header>Current Images</template>

    <section class="mt-4 grid grid-cols-3">
      <div
        v-for="image in currentImages"
        :key="image.id"
        class="m-2 shadow-lg flex flex-col justify-between gap-2"
      >
        <img :src="image.src" class="rounded-md mb-2" />

        <Link
          method="delete"
          :href="route('realtor.listing.image.destroy', { listing: props.listing.id, image: image.id })"
          as="button"
          class="mt-4 btn-outline text-xs"
        >
          Delete
        </Link>
      </div>
    </section>
  </Box>

  <Box class="mt-4">
    <template #header>Browse Server Images</template>

    <div class="mt-4">
      <div class="flex items-center justify-between mb-3">
        <div class="text-sm text-gray-500">
          Pick an image from the server and attach it to this listing.
        </div>
        <button type="button" class="btn-outline text-xs" @click="loadServerImages">
          Refresh
        </button>
      </div>

      <div v-if="serverImages.length" class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <label
          v-for="image in serverImages"
          :key="image.path"
          class="border rounded-md p-2 cursor-pointer transition"
          :class="selectedServerImage === image.path
            ? 'ring-2 ring-blue-500'
            : 'hover:bg-gray-50 dark:hover:bg-gray-800'"
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

          <div class="text-xs mt-2 truncate">
            {{ image.name }}
          </div>
        </label>
      </div>

      <div v-else class="text-sm text-gray-500">
        No images found in storage/app/public/images
      </div>

      <div class="mt-4 flex gap-2">
        <button
          type="button"
          class="btn-outline"
          :disabled="!selectedServerImage"
          :class="{ 'cursor-not-allowed': !selectedServerImage, disabled: !selectedServerImage }"
          @click="attachSelectedServerImage"
        >
          Attach Selected Image
        </button>

        <button
          type="button"
          class="btn-outline"
          @click="selectedServerImage = null"
        >
          Clear Selection
        </button>
      </div>
    </div>
  </Box>

  <div v-if="imageErrors.length" class="mt-4">
    <div v-for="(error, index) in imageErrors" :key="index">
      {{ error }}
    </div>
  </div>
</template>

<script setup>
import Box from '@/Components/UI/Box.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
  listing: {
    type: Object,
    default: () => ({ myimages: [] }),
  },
  errors: Object,
});

const form = useForm({
  images: [],
  existing_image_path: null,
});

const serverImages = ref([]);
const selectedServerImage = ref(null);

const currentImages = computed(() =>
  Array.isArray(props.listing?.myimages) ? props.listing.myimages : []
);

const imageErrors = computed(() => Object.values(form.errors));

const loadServerImages = async () => {
  const response = await axios.get(route('realtor.listing.image.library'));
  serverImages.value = response.data;
};

onMounted(loadServerImages);

const upload = () => {
  if (!form.images.length) {
    return;
  }

  form.post(route('realtor.listing.image.store', { listing: props.listing.id }), {
    onSuccess: () => form.reset('images'),
    onError: (errors) => {
      console.log(errors);
    },
  });
};

const attachSelectedServerImage = () => {
  if (!selectedServerImage.value) {
    return;
  }

  form.existing_image_path = selectedServerImage.value;

  form.post(route('realtor.listing.image.store', { listing: props.listing.id }), {
    onSuccess: () => {
      selectedServerImage.value = null;
      form.existing_image_path = null;
    },
    onError: (errors) => {
      console.log(errors);
    },
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