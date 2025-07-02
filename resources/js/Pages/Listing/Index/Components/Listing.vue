<template>
    <Box>
        <Link :href="route('listing.show', listing.id)">
            <div class="flex items-center gap-1">
                <Price :price="listing.price" class="text-xl" />
                <div class="text-xs text-gray-500" >
                    <Price :price="monthlyPayment" /> pm
                </div>
            </div>
            <ListingSpace :listing="listing" class="text-lg" />
            <ListingAddress :listing="listing" class="text-gray-500" />
            <div v-if="user">
                <Link :href="route('listing.edit', listing.id)">
                    Edit
                </Link>
            </div>           
        </Link>
    </Box>
</template>

<script setup >
    import {Link, usePage} from '@inertiajs/vue3'
    import ListingAddress from '@/Components/ListingAddress.vue';
    import Box from '@/Components/UI/Box.vue';
    import ListingSpace from '@/Components/UI/ListingSpace.vue';
    import Price from '@/Components/UI/Price.vue';
    import {useMonthlyPayment} from '@/Composables/useMonthlyPayment.js';
    import {computed} from 'vue';
    const props = defineProps({
        listing: Object,
    })

    const {monthlyPayment} = useMonthlyPayment(props.listing.price, 4.5, 20);
    const page = usePage();
    const user = computed(
        () => page.props.user
    )
</script>