<template>
    <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Users</h1>
    <button type="submit"
            @click="showUserModal"
            class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
      Add new User
    </button>
  </div>
  <UserModal v-model="showModal" :user="userModel" @close="onModalClose" />
  <UsersTable @clickEdit="editUser" />
  </template>
  
  <script setup>
  import UsersTable from "./UsersTable.vue";
  import UserModal from "./UserModal.vue";
  import store from "../../store/index.js";
  import {ref} from "vue";
  
  const DEFAULT_EMPTRY_OBJECT = {
    id: '',
    name: '',
    email: '',
    created_at: '',
    updated_at: '',
  }
  
  const showModal = ref(false)
  const userModel = ref({...DEFAULT_EMPTRY_OBJECT})
  
  function showUserModal(){
    showModal.value = true
  }
  
  function editUser(user){
      userModel.value = user
      showUserModal();
  }
  
  function onModalClose() {
    userModel.value = {...DEFAULT_EMPTRY_OBJECT}
  }
  
  </script>
  
  <style scoped>
  
  </style>
  