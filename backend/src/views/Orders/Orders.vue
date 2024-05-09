<template>
    <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Orders</h1>
  </div>
  <OrdersTable @clickView="viewOrder" />
  </template>
  
  <script setup>
  import OrdersTable from "./OrdersTable.vue";

  
  //const orders = computed(()=>store.state.orders);
  
  
  function viewOrder(){
    
  }

  
  </script>
  
  <style scoped>
  
  </style>
  