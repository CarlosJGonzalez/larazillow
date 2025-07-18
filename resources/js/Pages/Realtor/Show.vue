<template>
    <div class="mb-4">
        <Link
            :href="route('realtor.listing.index')">
                &lt;- Go back to Listings
        </Link>
    </div>
    
    <section class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
        <Box class="md:col-span-7 flex flex-col gap-4">
            <div v-if="!hasOffers" class="w-full text-center font-medium text-gray-500">
                No Offers
            </div>
            <div v-else class="md:col-span-7 flex flex-col gap-4">
                <Offer 
                    v-for="offer in listing.offers"
                    :offer="offer" 
                    :key="offer.id"
                    :listing-price="listing.price"
                    :is-sold="listing.sold_at != null"
                />
            </div>
        </Box>

        <div class="md:col-span-5">
            <Box class="md:col-span-5">
                <template #header>Basic Info</template>
                <Price :price="listing.price" class="text-2xl font-bold" />
                <ListingSpace :listing="listing" />
                <ListingAddress :listing="listing" />
            </Box>            
        </div>
    </section>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import Box from '@/Components/UI/Box.vue';
    import Price from '@/Components/UI/Price.vue';
    import ListingSpace from '@/Components/UI/ListingSpace.vue';
    import ListingAddress from '@/Components/ListingAddress.vue';
    import { computed } from 'vue';
    import Offer from './Show/Components/Offer.vue';

    const props = defineProps({
        'listing': Object,
    })
    const hasOffers = computed(
        () => props.listing.offers.length
    )
</script>