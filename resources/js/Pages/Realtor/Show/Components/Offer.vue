<template>
    <Box >
        <template #header>Offer #{{ offer.id }} 
            <span v-if="offer.accepted_at" 
                class="dark:bg-green-900 dark:text-green-200 uppercase bg-green-200 text-green-900 ml-2">
                accepted
            </span>
        </template>
        <section class="flex items-center justify-between">
            <div>
                <Price :price="offer.amount" class="text-xl" />
                <div>
                    Difference: <Price :price="difference" />
                </div>
                <div>
                    Made By {{ offer.bidder.name }}
                </div>
                <div>
                    Made on {{ madeOn }}
                </div>
            </div>
            <div >
                <Link v-if="!isSold"
                    method="put" :href="route('realtor.offer.accept', {offer: offer.id })" as="button" class="btn-outline text-xs font-medium">
                    Accept
                </Link>
            </div>
        </section>
    </Box>
</template>

<script setup>
    import Box from '@/Components/UI/Box.vue';
    import { Link } from '@inertiajs/vue3';
    import Price from '@/Components/UI/Price.vue';
    import { computed } from 'vue';

    const props = defineProps({
        'offer': Object,
        'listingPrice': Number,
        'isSold' : Boolean,
    });

    const difference = computed(
        () => props.offer.amount - props.listingPrice
    )

    const madeOn = computed(
        () => new Date( props.offer.created_at ).toDateString()
    )

</script>