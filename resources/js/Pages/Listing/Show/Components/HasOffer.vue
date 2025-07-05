<template>
    <Box>
        <template #header>Current Offer</template>
        <Price class="text-2xl" :price="offer.amount" />
        <section class="mt-2 flex flex-col md:flex-row justify-between text-gray-500">
            <div>Made on</div>
            <div class="text-xl text-medium">{{ offerMadeOn }}</div>
        </section>
    </Box>
</template>

<script setup>
    import Box from '@/Components/UI/Box.vue';
    import Price from '@/Components/UI/Price.vue';
    import { computed } from 'vue';

    const props = defineProps({
        offer: Object,
    })

    const offerMadeOn = computed(
        () => new Date( props.offer.created_at ).toDateString(),
    );
</script>