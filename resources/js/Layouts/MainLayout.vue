<template>
    <Link href="/">Home</Link>&nbsp;
    <Link href="/hello">Show Hello Page</Link>
    <div>
        The timer running {{ timer }}
    </div>
    <slot></slot>
</template>

<script setup>
    import {Link} from '@inertiajs/vue3'
    import {ref} from 'vue'

    const timer = ref( 0 )
    setInterval( () => timer.value++, 1000 )
        
</script>