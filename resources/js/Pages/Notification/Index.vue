<template>
    <h1 class="text-3xl mb-4">Your Notifications</h1>
    <section v-if="notifications.data.length" clas="text-gray-700 dark:text-gray-400">
            <div v-for="notification in notifications.data" :key="notification.id" class="border-b border-gray-200 dark:border-gray-800 py-4 flex justify-between items-center">
                <div>
                    <span v-if="notification.type === 'App\\Notifications\\OfferMade'">
                        Offer <Price :price="notification.data.amount" /> for 
                        <Link 
                            :href="route('realtor.listing.show', { listing: notification.data.listing_id})"
                            class="text-indigo-600 dark:text-indigo-400"
                        > listing</Link> was made
                    </span>
                </div>
                <div>
                    <Link 
                        v-if="!notification.read_at" 
                        class="btn-outline text-xs font-medium uppercase" 
                        :href="route('notification.update', { notification: notification.id })"
                        as="button"
                        method="patch"
                    >
                        mark as Read
                    </Link>
                </div>
            </div>
    </section>
    <EmptyState v-else>No notifications yet.</EmptyState>

    <section v-if="notifications.links" class="w-full flex justify-center mt-8 mb-8">
        <Pagination :links="notifications.links" />
    </section>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import Price from '@/Components/UI/Price.vue';
    import EmptyState from '../../Components/UI/EmptyState.vue';
    import Pagination from '@/Components/UI/Pagination.vue';
    defineProps({
        notifications: Object,
    })
</script>