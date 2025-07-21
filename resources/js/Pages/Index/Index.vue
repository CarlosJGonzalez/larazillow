<template>
<div class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
    <div class="bg-gray-800 text-3xl  md:col-span-7 flex items-top rounded-lg shadow md:text-8xl">
        <div class="grid">
            <div>
                <Box href="/more" class="flex flex-col md:grid md:grid-flow-col gap-3 justify-items-center border m-2 border-gray-600">
                    <div class="col-span-6 m-2">
                        <img src="https://dev.myrecp.com/public/storage/images/home.png" />                        
                    </div>
                    <div class="col-span-6 m-2 flex items-center">
                        <div class="text-4xl text-white ext-left">This site is under development. It's a partial result of a course I'm currently developing: Creating Advanced SPAs with Laravel Version 11 + Inertia (VueJS) + TailwindCSS
                        <div class="mt-4 text-2xs">Carlos Gonzalez <div class="text-xs">carlositflow@gmail.com</div></div></div>

                    </div>
                </Box>
                <Box class="flex flex-col-reverse md:grid md:grid-flow-col gap-3 justify-items-center border border-gray-600 m-2">
                    <div class="col-span-6 m-2 flex items-center text-right">
                        <div class="bold text-4xl text-white">We will guide you and help to make your best investment.</div>
                    </div>
                    <div class="col-span-6 m-2">
                        <img src="https://dev.myrecp.com/public/storage/images/success.png" />
                    </div>
                </Box>                
            </div>
        </div>
    </div>
    <div class="md:col-span-5 p-2 flex flex-col gap-4 rounded-lg shadow">
        <video autoplay="true" playsinline loop class="mx-auto w-full max-w-2xl">
            <source :src="videoUrl" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</div>




</template>
<script setup>
const videoUrl = "https://dev.myrecp.com/public/storage/images/agent1.mp4"
</script>