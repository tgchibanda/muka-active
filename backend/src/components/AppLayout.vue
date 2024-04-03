<template>

  <div class="flex min-h-full bg-gray-200">

    <!-- Side Bar -->
      <Sidebar />
    <!-- End Side Bar -->

    <div class="flex-1">

      <TopHeader></TopHeader>

      <!-- Content -->
      <main class="p-6">
          <router-view></router-view>
      </main>
      <!-- End Content -->

    </div>


  </div>


</template>


<script setup>
import Sidebar from "./SideBar.vue";
import TopHeader from "./TopHeader.vue";
const {title} =  defineProps({
    title: String
})

</script>

<style scoped>
  
</style>