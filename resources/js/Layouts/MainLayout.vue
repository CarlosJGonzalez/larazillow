<template>
    <header class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 w-full">
        <div class="container mx-auto">
            <nav class="p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="mr-4">
                        <Link href="/" class="text-lg font-medium underline">Home</Link>
                    </div> 
                    <div>
                        <Link :href="route('listing.index')" class="text-lg font-medium underline">Listings</Link>
                    </div>
                </div>
                <div v-if="user" class="flex items-center gap-1">
                    <Link class="text-gray-500 relative pr-2 py-2 text-lg"
                        :href="route('notification.index')">
                        🔔
                        <div v-if="notificationCount" class="absolute right-0 top-0 w-5 h-5 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center">
                            {{ notificationCount }}
                        </div>
                    </Link>
                    <Link class="text-sm text-gray-500" :href="route('realtor.listing.index')">
                        {{user.name}}
                    </Link>
                    <Link :href="route('realtor.listing.create')" class="btn-primary">+ New Listing</Link>
                    <Link :href="route('logout')" method="delete" as="button"> LogOut</Link>                    
                </div>
                <div v-else class="flex items-center gap-2">
                    <Link :href="route('user-account.create')">Register</Link>
                    <Link :href="route('login')" class="btn-primary">Sign-In</Link>
                </div>
            </nav>
        </div>
    </header>
    <main class="container mx-auto p-4 w-full">
        <div v-if="flashSuccess" class="mb-4 border rounded-md shadow-sm border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-700 p-2">
            {{ flashSuccess }}
        </div>
        <div v-if="flashError" class="mb-4 rounded-md border shadow-sm border-red-700 dark:border-red-300 bg-red-50 dark:bg-red-700 p-2">
            {{ flashError }}
        </div>
        <slot></slot>
    </main>


</template>

<script setup>
    import { computed } from 'vue'
    import { Link, usePage } from '@inertiajs/vue3'

    const page = usePage()
    const flashSuccess = computed(
        () => page.props.flash.success
    );

    const flashError = computed(
        () => page.props.flash.error
    )

    const user = computed(
        () => page.props.user
    );

    const notificationCount = computed(
        () => Math.min(page.props.user.notificationCount, 9),
    );
</script>