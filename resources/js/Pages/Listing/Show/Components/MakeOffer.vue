<template>
    <Box >
        <template #header>Make an Offer</template>
        <div>
            <form @submit.prevent="bid">
                <input v-model="form.amount" type="text" class="input" />
                <input type="range" :min="min" :max="max" step="1000" 
                    v-model="form.amount"
                    class="mt-2 w-full h-4 bg-gray-200 rounded-lg appeareance-none cursor-pointer dark:bg-gray-700" />
                <button class="btn-outline w-full mt-2 text-sm" type="submit">Make an Offer</button>
            </form>
        </div>
        <div class="flex justify-between text-gray-500 mt-2">
            <div>Difference</div>
            <div>
                <Price :price="difference" />
            </div>
        </div>
    </Box>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import Box from '@/Components/UI/Box.vue';
    import Price from '@/Components/UI/Price.vue';
    import { computed, watch } from 'vue';
    import { debounce } from 'lodash';
    const props = defineProps({
        listingId: Number,
        price: Number
    })

    const form = useForm({
        amount: props.price,
    })

    const difference = computed( () => form.amount - props.price );
    const min = computed( () => Math.round(props.price / 2) );
    const max = computed( () => Math.round(props.price * 2 ));

    const bid = () => {
        form.post(
            route('listing.offer.store',{ listing: props.listingId })
        )
    }

    const emit = defineEmits(['offerUpdated']);

    watch(() => form.amount, 
        debounce( (value) =>emit( 'offerUpdated', value),200)
    );

</script>