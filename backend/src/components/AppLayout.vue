<template>

  <div class="flex min-h-full">

    <!-- Side Bar -->
      <Sidebar />
    <!-- End Side Bar -->

    <div class="flex-1">
      <header class="h-8 shadow bg-white">
        Header
      </header>

      <!-- Content -->
      <main>
        <router-view></router-view>
      </main>
      <!-- End Content -->

    </div>


  </div>


</template>


<script setup>
import Sidebar from "./SideBar.vue";
const {title} =  defineProps({
    title: String
})

</script>

<style scoped>
  
</style>