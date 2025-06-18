<template>
    <div>Index</div>
    <Link href="/hello">Show Hello Page</Link>
    <div>{{ message }}</div>    
</template>

<script setup>
    import {Link} from '@inertiajs/vue3'
    defineProps({
        message: String
    })
</script>
