<template>

<div class="w-[200px] bg-indigo-700 rounded-l-xl py-4 px-2">
      
  <router-link :to="{name: 'app.dashboard'}" class="flex items-center hover:bg-black/30 p-2 rounded transition-colors">
        <span class="mr-2 text-gray-300"><HomeIcon class="w-5"/></span>
        <span class="text-xs text-gray-300">
          Dashboard
        </span>
      </router-link>

  <router-link :to="{name: 'app.dashboard'}" class="flex items-center hover:bg-black/30 p-2 rounded transition-colors">
        <span class="mr-2 text-gray-300"><ViewListIcon class="w-5"/></span>
        <span class="text-xs text-gray-300">
          Products
        </span>
      </router-link>

  <router-link :to="{name: 'app.dashboard'}" class="flex items-center hover:bg-black/30 p-2 rounded transition-colors">
        <span class="mr-2 text-gray-300"><UsersIcon class="w-5"/></span>
        <span class="text-xs text-gray-300">
          Users
        </span>
      </router-link>

  <router-link :to="{name: 'app.dashboard'}" class="flex items-center hover:bg-black/30 p-2 rounded transition-colors">
        <span class="mr-2 text-gray-300"><ChartBarIcon class="w-5"/></span>
        <span class="text-xs text-gray-300">
          Reports
        </span>
      </router-link>
  
</div>


</template>


<script setup>
import {HomeIcon, UsersIcon, ViewListIcon, ChartBarIcon} from '@heroicons/vue/outline'
</script>