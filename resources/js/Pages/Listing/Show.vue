<template>
    <div class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">  
        <Box class="md:col-span-7 flex items-top" :class="{'items-center' : !listing.myimages.length}">
            <div v-if="listing.myimages.length" class="grid grid-cols-2 gap-1">
                <img v-for="image in listing.myimages" :src="image.src" :key="image.id" />
            </div>
            <div v-else class="w-full text-center font-medium text-gray-500">No images found</div>
        </Box>
        <div class="md:col-span-5 p-2 flex flex-col gap-4">
            <Box>
                <template #header>
                    Basic Info
                </template>
                <Price :price="listing.price" class="text-xl" />
                <ListingSpace :listing="listing" class="text-lg" />
                <ListingAddress :listing="listing" class="text-gray-500" />                   
            </Box>
            <Box>
                <template #header>
                    Monthly Payment
                </template>
                <div>
                    <label class="label">Interest rate({{ interestRate }}%)</label>
                    <input v-model.number="interestRate" type="range" min="0.1" max="30" step="0.1" 
                        class="w-full h-4 bg-gray-200 rounded-lg appeareance-none cursor-pointer dark:bg-gray-700" />
                    <label class="label">Duration ({{ duration }} years)</label>
                    <input v-model="duration" type="range" min="3" max="35" step="1" 
                        class="w-full h-4 bg-gray-200 rounded-lg appeareance-none cursor-pointer dark:bg-gray-700" />
        
                    <div class="text-gray-600 dark:text-gray-300 mt-2">
                        <div class="text-gray-400">
                            Your Monthly payment
                        </div>
                        <Price :price="monthlyPayment" class="text-3xl" />
                    </div>
                    <div class="mt-2 text-gray-500">
                        <div class="flex justify-between mt-2">
                            <div>Total Paid</div>
                            <div>
                                <Price :price="totalPaid" class="font-medium" />
                            </div>                            
                        </div>
                        <div class="flex justify-between mt-2">
                            <div>Principal Paid</div>
                            <div>
                                <Price :price="listing.price" class="font-medium" />
                            </div>                            
                        </div>
                        <div class="flex justify-between mt-2">
                            <div>Interest Paid</div>
                            <div>
                                <Price :price="totalInterest" class="font-medium" />
                            </div>                            
                        </div>                                                
                    </div>
                </div>
            </Box>
            <MakeOffer 
                @offer-updated = "offer=$event"
                v-if="user && !hasOffer"
                :price="listing.price" 
                :listing-id="listing.id" />

            <HasOffer v-if="user && hasOffer" :offer="hasOffer" />
        </div>
    </div>
</template>

<script setup>
    import ListingAddress from '@/Components/ListingAddress.vue';
    import Price from '@/Components/UI/Price.vue';
    import ListingSpace from '@/Components/UI/ListingSpace.vue';
    import Box from '@/Components/UI/Box.vue';
    import { ref, computed } from 'vue';
    import {useMonthlyPayment} from '@/Composables/useMonthlyPayment.js';
    import MakeOffer from './Show/Components/MakeOffer.vue';
    import { usePage } from '@inertiajs/vue3';
    import HasOffer from './Show/Components/HasOffer.vue';
    const interestRate = ref(3.65)
    const duration = ref(20)
    const props = defineProps({
        listing: Object,
        hasOffer: Object,
    })

    const offer = ref( props.listing.price );

    const {monthlyPayment, totalPaid, totalInterest} = useMonthlyPayment(offer, interestRate,duration);
    
    const page = usePage();
    const user = computed(
        () => page.props.user
    )
</script>