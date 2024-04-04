<template>

  <div class="flex min-h-full">

    <!-- Side Bar -->
      <Sidebar :class="{'-ml-[267px]' : !sidebarOpened}" />
    <!-- End Side Bar -->

    <div class="flex-1">

      <Navbar @toggle-sidebar="toggleSidebar"></Navbar>

      <!-- Content -->
      <main class="h-screen p-6 bg-gray-200">
          <router-view></router-view>
      </main>
      <!-- End Content -->

    </div>


  </div>


</template>


<script setup>
import {ref, onMounted, onUnmounted} from "vue"
import Sidebar from "./SideBar.vue";
import Navbar from "./Navbar.vue"
const {title} =  defineProps({
    title: String
})

const sidebarOpened = ref(true)
function toggleSidebar() {
  sidebarOpened.value = !sidebarOpened.value
}

onMounted (() => {
  handleSidebarOpened();
  window.addEventListener('resize', handleSidebarOpened)
})

onUnmounted (() => {
  window.removeEventListener('resize', handleSidebarOpened)
})

function handleSidebarOpened(){
  if(window.outerWidth <= 768 ){
    sidebarOpened.value = false
  }
  else {
    sidebarOpened.value = true
  }
}
</script>

<style scoped>
  
</style>