<template>
   <guest-layout title = "Request new password">
    
      <form class="space-y-6" action="#" method="POST">
        
        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
          </div>
          <div class="mt-2">
            <input id="password" name="password" type="password" autocomplete="current-password" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>
        </div>

        <div class="text-sm">
              <router-link :to="{name: 'login'}" class="font-semibold text-indigo-600 hover:text-indigo-500">Remember password?</router-link>
        </div>

        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
        </div>
      </form>
   </guest-layout>
</template>





<script setup>
  import {LockClosedIcon} from '@heroicons/vue/solid'
  import GuestLayout from '../components/GuestLayout.vue'
</script>

<style scoped>

</style>