<template>
    <div>
        <span class="font-bold">{{listing.beds}}</span>Bd | 
        <span class="font-bold"> {{listing.baths}}</span> Ba | 
        <span class="font-bold">{{listing.area}}</span> m2
    </div>
</template>

<script setup>
    defineProps({
        listing: Object,
    })
</script>