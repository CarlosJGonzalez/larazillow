<template>
    <h1 class="text-3xl mb-4">Your Listings</h1>
    <section>
        <RealtorFilters :filters="filters" class="mb-4" />
    </section>
    <section v-if="listings.data.length" class="grid grid-cols-1 lg:grid-cols-2 gap-2">
        <Box v-for="listing in listings.data" :key="listing.id" :class="{'border-dashed': listing.deleted_at}">
            <div class="flex flex-col md:flex-row gap-2 md:items-center justify-between">
                <div :class="{'opacity-25': listing.deleted_at}">
                    <div v-if="listing.sold_at != null" 
                        class="text-xs uppercase border border-dashed inline-block p-1 rounded border-green-300 text-green-500 dark:border-green-600 dark:text-green-300 mb-2"
                    >
                        sold
                    </div>
                    <div class="xl:flex items-center gap-2">
                        <Price :price="listing.price" class="text-2xl font-medium" />
                        <ListingSpace :listing="listing" />
                    </div>                    
                    <ListingAddress :listing="listing" class="text-gray-500" />
                </div>
                <div>
                    <section>
                        <div class="flex items-center gap-1 text-gray-600 dark:text-gray-300">
                            <a 
                                class="btn-outline text-xs font-medium" 
                                :href="route('listing.show',{listing: listing.id})"
                                target="_blank"
                            >Preview</a>
                            <Link class="btn-outline text-xs font-medium" :href="route('realtor.listing.edit', {listing: listing.id})">Edit</Link>
                            <Link v-if="!listing.deleted_at" class="btn-outline text-xs font-medium" method="delete" :href="route('realtor.listing.destroy', {listing: listing.id})">Delete</Link>
                            <Link v-else="listing.deleted_at" class="btn-outline text-xs font-medium" :href="route('realtor.listing.restore', {listing: listing.id})" method="put">Restore</Link>
                        </div>
                        <div class="mt-2">
                            <Link 
                                :href="route('realtor.listing.image.create', { listing: listing.id })"
                                class="block w-full btn-outline text-xs font-medium text-center"
                            >
                                Images&nbsp;({{ listing.myimages_count }})
                            </Link>                            
                        </div>
                        <div class="mt-2">
                            <Link 
                                :href="route('realtor.listing.show', { listing: listing.id })"
                                class="block w-full btn-outline text-xs font-medium text-center"
                            >
                                Offers&nbsp;({{ listing.offers_count }})
                            </Link>                            
                        </div>                        
                    </section>                    
                </div>
            </div>
        </Box>
    </section>

    <EmptyState v-else>No listings yet</EmptyState>

    <section v-if="listings.data.length" class="w-full flex justify-center mt-4 mb-4">
        <Pagination :links="listings.links" />
    </section>
</template>

<script setup >
    import Box from '@/Components/UI/Box.vue';
    import Price from '@/Components/UI/Price.vue';
    import ListingSpace from '@/Components/UI/ListingSpace.vue';
    import ListingAddress from '@/Components/ListingAddress.vue';
    import {Link} from '@inertiajs/vue3';
    import RealtorFilters from './Index/Components/RealtorFilters.vue';
    import Pagination from '@/Components/UI/Pagination.vue';
import EmptyState from '../../Components/UI/EmptyState.vue';
    
    defineProps({
        listings: Object,
        filters: Object,
        offers: Object,
    });

</script>