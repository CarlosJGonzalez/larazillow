<template>
  <div class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
    <Box
      v-if="listing.myimages?.length"
      class="md:col-span-7 flex items-top"
    >
      <div class="grid grid-cols-2 gap-1 w-full">
        <template v-for="image in listing.myimages" :key="image.id">
          <img
            v-if="image.src && !failedImages[image.id]"
            :src="image.src"
            :alt="image.alt || 'Listing image'"
            class="w-full h-48 object-cover rounded"
            @error="failedImages[image.id] = true"
          />
          <div
            v-else
            class="w-full h-48 flex items-center justify-center bg-gray-100 dark:bg-gray-800 rounded"
          >
            <svg
              viewBox="0 0 24 24"
              class="w-16 h-16 text-gray-400"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
              <path
                d="M4 4h16v16H4V4Z"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linejoin="round"
              />
              <path
                d="M7 15l3-3 2 2 3-3 2 2"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M9 10.5h.01"
                stroke="currentColor"
                stroke-width="2.5"
                stroke-linecap="round"
              />
            </svg>
          </div>
        </template>
      </div>
    </Box>

    <Box v-else class="md:col-span-7 flex items-center justify-center min-h-64">
      <svg
        viewBox="0 0 24 24"
        class="w-24 h-24 text-gray-400"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
      >
        <path
          d="M4 4h16v16H4V4Z"
          stroke="currentColor"
          stroke-width="1.5"
          stroke-linejoin="round"
        />
        <path
          d="M7 15l3-3 2 2 3-3 2 2"
          stroke="currentColor"
          stroke-width="1.5"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
        <path
          d="M9 10.5h.01"
          stroke="currentColor"
          stroke-width="2.5"
          stroke-linecap="round"
        />
      </svg>
    </Box>

    <div class="md:col-span-5 p-2 flex flex-col gap-4">
      <!-- rest of your component -->
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue';

const failedImages = reactive({});
</script>