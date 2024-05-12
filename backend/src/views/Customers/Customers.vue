<template>
  <div class="flex items-center justify-between mb-3">
  <h1 class="text-3xl font-semibold">Customers</h1>
</div>
<CustomerModal v-model="showModal" :customer="customerModel" @close="onModalClose" />
<CustomersTable @clickEdit="editCustomer" />
</template>

<script setup>
import CustomersTable from "./CustomersTable.vue";
import CustomerModal from "./CustomerModal.vue";
import store from "../../store/index.js";
import {ref} from "vue";

const DEFAULT_EMPTRY_OBJECT = {

}



const showModal = ref(false)
const customerModel = ref({...DEFAULT_EMPTRY_OBJECT})

function showCustomerModal(){
  showModal.value = true
}

function editCustomer(customer){
  store.dispatch('getCustomer', customer.user_id)
  .then(({data})=>{
    customerModel.value = data
    showCustomerModal()
  })
}

function onModalClose() {
  customerModel.value = {...DEFAULT_EMPTRY_OBJECT}
}

</script>

<style scoped>

</style>
