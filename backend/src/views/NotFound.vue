<template>
    <div class="flex justify-center items-center min-h-full min-w-full w-full">
        <div class="flex">
            <div class="text-indigo-600 text-5xl px-8 font-bold border-r pb-8 leading-10">404</div>
        <div class="px-8">
            <h1 class="text-5xl font-bold mb-2">Page Not Found</h1>
            <p class="text-gray-400 mb-10">Please check the url in the address bar and try again!</p>
            <div>
                <router-link :to="{name: 'app.dashboard'}" 
                    class="rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Go Back Home</router-link>
            </div>
        </div>
        </div>
    </div>
  </template>
  

<script setup>

</script>

<style scoped>

</style>
