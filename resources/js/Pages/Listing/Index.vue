<template>
    <div v-for="listing in listings" :key="listing.id">
        <Link :href="route('listing.show', listing.id)">
            <ListingAddress :listing="listing" />
            <Link :href="route('listing.edit', listing.id)">
                Edit
            </Link>
            <Link :href="route('listing.destroy', listing.id)" method="delete">
                Delete
            </Link>            
        </Link>
    </div>
</template>

<script setup>
    import {Link} from '@inertiajs/vue3'
    import ListingAddress from '@/Components/ListingAddress.vue';
    defineProps({
        listings: Array,
    })
</script>