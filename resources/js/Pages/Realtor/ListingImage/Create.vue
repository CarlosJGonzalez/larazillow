<template>
    <Box >
        <template #header>Upload Images</template>
        <form @submit.prevent="upload">
            <div class="flex flex-wrap items-center gap-2 my-4">  
                <div class="grid grid-row">
                    <input type="file" multiple @input="addFiles"
                        class="border rounded-md file:px-4 file:py-2 border-gray-200 dark:border-gray-700 file:text-gray-700 file:dark:text-gray-400 file:border-0 file:bg-gray-100 file:dark:bg-gray-800 file:font-medium file:hover:bg-gray-200 file:dark:hover:bg-gray-700 file:hover:cursor-pointer file:mr-4"
                    >
                    <!-- <span v-if="!form.images.length" class="text-sm">No image selected</span> -->
                </div>         
                <div>
                    <button
                        :disabled="!form.images.length"
                        type="submit" 
                        class="btn-outline"
                        :class="{ 'cursor-not-allowed': !form.images.length,  'disabled': !form.images.length}">Upload</button>
                    <button @click="reset" type="reset" class="btn-outline">Reset</button>
                </div>
            </div>
        </form>
    </Box>
    <Box class="mt-4" v-if="listing.myimages.length">
        <template #header>Current Images</template>
        <section class="mt-4 grid grid-cols-3">
            <div v-for="image in listing.myimages" :key="image.id" class="m-2 shadow-lg flex flex-col justify-between gap-2">
                <img :src="image.src" class="rounded-md mb-2" />
                <Link 
                    method="delete" 
                    :href="route('realtor.listing.image.destroy', {listing: props.listing.id, image: image.id})" 
                    as="button"
                    class="mt-4 btn-outline text-xs"
                >Delete</Link>
            </div>                
        </section>
    </Box>
    <div v-if="imageErrors.length">
        <div v-for="(error,index) in imageErrors" :key="index">
            {{ error }}
        </div>
    </div>
</template>

<script setup>
    import Box from '@/Components/UI/Box.vue';
    import { useForm, Link } from '@inertiajs/vue3';
    import { computed } from 'vue';
    const props = defineProps({ 
        listing: Object,
        errors: Object,
    });
    const form = useForm({
        images: [],
    });

    //converting Object to Array
    const imageErrors = computed(() => Object.values( form.errors));

    const upload = () =>{
        if( !form.images.length ){
            return;
        }
        form.post( 
            route('realtor.listing.image.store', { listing: props.listing.id }),{
                onSuccess: () => form.reset('images'),
                onError: ( errors )=> {
                    console.log( errors )
                }
            }
        )
    };

    const addFiles = (event) => {
        for( const image of event.target.files ){
            form.images.push( image );
        }
    }

    const reset = () => {
        form.reset('images');
    }
</script>