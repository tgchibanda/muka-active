<template>

  <div class="flex min-h-full">

    <!-- Side Bar -->
      <Sidebar :class="{'-ml-[267px]' : !sidebarOpened}" />
    <!-- End Side Bar -->

    <div class="flex-1">

      <TopHeader @toggle-sidebar="toggleSidebar"></TopHeader>

      <!-- Content -->
      <main class="h-screen p-6 bg-gray-200">
          <router-view></router-view>
      </main>
      <!-- End Content -->

    </div>


  </div>


</template>


<script setup>
import {ref} from "vue"
import Sidebar from "./SideBar.vue";
import TopHeader from "./TopHeader.vue";
const {title} =  defineProps({
    title: String
})

const sidebarOpened = ref(true)
function toggleSidebar() {
  sidebarOpened.value = !sidebarOpened.value
}
</script>

<style scoped>
  
</style>