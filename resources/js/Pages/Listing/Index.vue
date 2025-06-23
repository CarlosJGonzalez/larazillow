<template>
    <div v-for="listing in listings" :key="listing.id">
        <Link :href="`/listing/${listing.id}`">
            <ListingAddress :listing="listing" />
            <Link :href="`/listing/${listing.id}/edit`">
                Edit
            </Link>
            <Link :href="`/listing/${listing.id}`" method="delete">
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