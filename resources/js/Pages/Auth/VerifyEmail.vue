<template>
    <div>
        You need be verified first to see this page.
        Please check out your email inbox and verify your email.
    </div>
    <Link 
        :href="route('verification.send')"
        method="post"
        as="button"
        class="text-indigo-600 dark:text-indigo-400"
    >
        Resend verification Emanil
    </Link>
</template>
<script setup>
    import { Link } from '@inertiajs/vue3';
</script>