<template>
  <div class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
    <Box
      v-if="hasImages"
      class="md:col-span-7 flex items-top"
      :class="{ 'items-center': !hasImages }"
    >
      <div class="grid grid-cols-2 gap-1 w-full">
        <template v-for="image in validImages" :key="image.id">
          <img
            v-if="image.src"
            :src="image.src"
            :alt="image.alt || 'Listing image'"
            class="w-full h-48 object-cover rounded"
          />
          <div
            v-else
            class="w-full h-48 flex items-center justify-center bg-gray-100 dark:bg-gray-800 rounded"
          >
            <NotFoundSvg class="w-16 h-16 text-gray-400" />
          </div>
        </template>
      </div>
    </Box>

    <Box
      v-else
      class="md:col-span-7 flex items-top"
      :class="{ 'items-center': !hasImages }"
    >
      <div class="w-full h-64 flex items-center justify-center">
        <NotFoundSvg class="w-24 h-24 text-gray-400" />
      </div>
    </Box>

    <div class="md:col-span-5 p-2 flex flex-col gap-4">
      <Box>
        <template #header>
          Basic Info
        </template>
        <Price :price="listing.price" class="text-xl" />
        <ListingSpace :listing="listing" class="text-lg" />
        <ListingAddress :listing="listing" class="text-gray-500" />
      </Box>

      <Box>
        <template #header>
          Monthly Payment
        </template>
        <div>
          <label class="label">Interest rate({{ interestRate }}%)</label>
          <input v-model.number="interestRate" type="range" min="0.1" max="30" step="0.1"
            class="w-full h-4 bg-gray-200 rounded-lg appeareance-none cursor-pointer dark:bg-gray-700" />
          <label class="label">Duration ({{ duration }} years)</label>
          <input v-model="duration" type="range" min="3" max="35" step="1"
            class="w-full h-4 bg-gray-200 rounded-lg appeareance-none cursor-pointer dark:bg-gray-700" />

          <div class="text-gray-600 dark:text-gray-300 mt-2">
            <div class="text-gray-400">
              Your Monthly payment
            </div>
            <Price :price="monthlyPayment" class="text-3xl" />
          </div>
          <div class="mt-2 text-gray-500">
            <div class="flex justify-between mt-2">
              <div>Total Paid</div>
              <div>
                <Price :price="totalPaid" class="font-medium" />
              </div>
            </div>
            <div class="flex justify-between mt-2">
              <div>Principal Paid</div>
              <div>
                <Price :price="listing.price" class="font-medium" />
              </div>
            </div>
            <div class="flex justify-between mt-2">
              <div>Interest Paid</div>
              <div>
                <Price :price="totalInterest" class="font-medium" />
              </div>
            </div>
          </div>
        </div>
      </Box>

      <MakeOffer
        @offer-updated="offer = $event"
        v-if="user && !hasOffer"
        :price="listing.price"
        :listing-id="listing.id"
      />

      <HasOffer v-if="user && hasOffer" :offer="hasOffer" />
    </div>
  </div>
</template>

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
  listing: Object,
  hasOffer: Object,
});

const interestRate = ref(3.65);
const duration = ref(20);
const offer = ref(props.listing.price);

const { monthlyPayment, totalPaid, totalInterest } = useMonthlyPayment(
  offer,
  interestRate,
  duration
);

const page = usePage();
const user = computed(() => page.props.user);

const validImages = computed(() =>
  (props.listing?.myimages ?? []).filter((image) => image?.src)
);

const hasImages = computed(() => validImages.value.length > 0);
</script>

<script>
export default {
  components: {
    NotFoundSvg: {
      template: `
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
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
      `,
    },
  },
};
</script>