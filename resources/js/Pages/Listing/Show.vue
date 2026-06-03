<script setup>
import ListingAddress from '@/Components/ListingAddress.vue';
import Price from '@/Components/UI/Price.vue';
import ListingSpace from '@/Components/UI/ListingSpace.vue';
import Box from '@/Components/UI/Box.vue';
import { ref, computed } from 'vue';
import { useMonthlyPayment } from '@/Composables/useMonthlyPayment.js';
import MakeOffer from './Show/Components/MakeOffer.vue';
import { usePage } from '@inertiajs/vue3';
import HasOffer from '@/Pages/Listing/Show/Components/HasOffer.vue';

const props = defineProps({
  listing: {
    type: Object,
    default: () => ({
      price: 0,
      myimages: [],
    }),
  },
  hasOffer: Object,
});

const images = computed(() => Array.isArray(props.listing?.myimages) ? props.listing.myimages : []);

const interestRate = ref(3.65);
const duration = ref(20);
const offer = ref(props.listing.price ?? 0);

const { monthlyPayment, totalPaid, totalInterest } = useMonthlyPayment(offer, interestRate, duration);

const page = usePage();
const user = computed(() => page.props.user);
</script>

<template>
  <div class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
    <Box v-if="images.length" class="md:col-span-7 flex items-top">
      <div class="grid grid-cols-2 gap-1 w-full">
        <template v-for="image in images" :key="image.id">
          <img
            v-if="image?.src"
            :src="image.src"
            :alt="image.alt || 'Listing image'"
            class="w-full h-48 object-cover rounded"
            @error="$event.target.style.display = 'none'"
          />
          <div
            v-else
            class="w-full h-48 flex items-center justify-center bg-gray-100 dark:bg-gray-800 rounded"
          >
            <svg viewBox="0 0 24 24" class="w-16 h-16 text-gray-400" fill="none" aria-hidden="true">
              <path d="M4 4h16v16H4V4Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
              <path d="M7 15l3-3 2 2 3-3 2 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M9 10.5h.01" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
            </svg>
          </div>
        </template>
      </div>
    </Box>

    <Box v-else class="md:col-span-7 flex items-center justify-center min-h-64">
      <svg viewBox="0 0 24 24" class="w-24 h-24 text-gray-400" fill="none" aria-hidden="true">
        <path d="M4 4h16v16H4V4Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
        <path d="M7 15l3-3 2 2 3-3 2 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M9 10.5h.01" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
      </svg>
    </Box>

    <div class="md:col-span-5 p-2 flex flex-col gap-4">
      <!-- unchanged right column -->
    </div>
  </div>
</template>