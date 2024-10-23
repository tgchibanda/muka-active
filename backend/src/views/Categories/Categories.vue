<template>
    <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Categories</h1>
    <button type="submit"
            @click="showCategoryModal"
            class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
      Add new Category
    </button>
  </div>
  <CategoryModal v-model="showModal" :category="categoryModel" @close="onModalClose" />
  <CategoriesTable @clickEdit="editCategory" />
  </template>
  
  <script setup>
  import CategoriesTable from "./CategoriesTable.vue";
  import CategoryModal from "./CategoryModal.vue";
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
  const categoryModel = ref({...DEFAULT_EMPTRY_OBJECT})
  
  function showCategoryModal(){
    showModal.value = true
  }
  
  function editCategory(category){
      categoryModel.value = category
      showCategoryModal();
  }
  
  function onModalClose() {
    categoryModel.value = {...DEFAULT_EMPTRY_OBJECT}
  }
  
  </script>
  
  <style scoped>
  
  </style>
  