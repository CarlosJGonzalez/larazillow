<template>
    <div>
        <h1 class="text-xl font-bold mb-4">Verify Your Email</h1>
        <p class="mb-4">Since email delivery is not available in this development environment, you can manually verify your account by clicking this link in order to create listings:</p>
    </div>
    <Link 
        :href="url"
        method="get"
        as="button"
        class="text-indigo-600 dark:text-indigo-400 btn-outline"
    >
        Verify it
    </Link>
</template>
<script setup>
    import { Link } from '@inertiajs/vue3';
    defineProps({
        url: String,
    })
</script>