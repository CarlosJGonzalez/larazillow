<template>
    <div class="flex gap-1">
        <Link v-for="(link, index) in links" 
            :key="index" class="py-2 px-4 rounded-md " 
            :href="link.url ?? 'null'" 
            :class="{'bg-indigo-500 dark:bg-indigo-800': link.active, 'hidden':link.url==null}"
            v-html="link.label"
        />        
    </div>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';
defineProps({links: Array})
</script>