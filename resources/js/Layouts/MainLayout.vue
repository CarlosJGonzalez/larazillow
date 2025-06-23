<template>
    <Link href="/listing">Listings</Link>&nbsp;
    <Link href="/listing/create">Create</Link>
    <div v-if="flashSuccess" class="success">
        {{ flashSuccess }}
    </div>
    <slot></slot>
</template>

<script setup>
    import { computed } from 'vue'
    import { Link, usePage } from '@inertiajs/vue3'

    //page.props.flash.success
    const page = usePage()
    const flashSuccess = computed(
        () => page.props.flash.success
    )

</script>

<style scoped>
    .success{
        background-color: rgb(187, 240, 187);
    }
</style>