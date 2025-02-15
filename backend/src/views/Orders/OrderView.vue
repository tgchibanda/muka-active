<template>
  <div v-if="order" class="p-6 bg-white shadow-lg rounded-lg">
    <!-- Order Details -->
    <div>
      <h2 class="flex justify-between items-center text-2xl font-semibold pb-3 border-b border-gray-300">
        Order Details
        <OrderStatus :order="order" />
      </h2>
      <table class="w-full mt-3 text-sm">
        <tbody>
          <tr v-for="(label, key) in orderInfo" :key="key">
            <td class="font-semibold py-2 px-3 text-gray-700">{{ label }}</td>
            <td class="py-2 px-3">
              <template v-if="key === 'status'">
                <select v-model="order.status" @change="onStatusChange" class="border rounded p-2 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                  <option v-for="status in orderStatuses" :value="status" :key="status">{{ status }}</option>
                </select>
              </template>
              <template v-else-if="['total_price', 'shipping_cost', 'grand_total'].includes(key)">
                ${{ order[key] }}
              </template>
              <template v-else>
                {{ order[key] }}
              </template>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <!-- Customer Details -->
    <div class="mt-6">
      <h2 class="text-2xl font-semibold pb-3 border-b border-gray-300">Customer Details</h2>
      <table class="w-full mt-3 text-sm">
        <tbody>
          <tr v-for="(label, key) in customerInfo" :key="key">
            <td class="font-semibold py-2 px-3 text-gray-700">{{ label }}</td>
            <td class="py-2 px-3">{{ order.customer[key] }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <!-- Addresses Details -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
      <div>
        <h2 class="text-xl font-semibold pb-2 border-b border-gray-300">Billing Address</h2>
        <p class="mt-2 text-gray-600 leading-relaxed">{{ formatAddress(order.customer.billingAddress) }}</p>
      </div>
      <div>
        <h2 class="text-xl font-semibold pb-2 border-b border-gray-300">Shipping Address</h2>
        <p class="mt-2 text-gray-600 leading-relaxed">{{ formatAddress(order.customer.shippingAddress) }}</p>
      </div>
    </div>
    
    <!-- Order Items -->
    <div class="mt-6">
      <h2 class="text-2xl font-semibold pb-3 border-b border-gray-300">Order Items</h2>
      <div v-for="item in order.items" :key="item.id" class="flex items-center gap-4 py-4 border-b">
        <img :src="item.product.image" class="w-24 h-24 object-cover rounded-lg" alt="" />
        <div class="flex-1">
          <h3 class="font-semibold text-lg">{{ item.product.title }}</h3>
          <div class="flex justify-between mt-2 text-gray-700">
            <span>Qty: {{ item.quantity }}</span>
            <span class="font-semibold text-lg">${{ item.unit_price }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import store from '../../store';
import axiosClient from '../../axios.js';
import OrderStatus from './OrderStatus.vue';

const route = useRoute();
const order = ref(null);
const orderStatuses = ref([]);

const orderInfo = {
  id: 'Order #',
  created_at: 'Order Date',
  status: 'Order Status',
  total_price: 'Products Price',
  shipping_cost: 'Shipping Cost',
  grand_total: 'SubTotal'
};

const customerInfo = {
  first_name: 'Full Name',
  email: 'Email',
  phone: 'Phone'
};

onMounted(() => {
  store.dispatch('getOrder', route.params.id).then(({ data }) => {
    order.value = data;
  });
  
  axiosClient.get('/orders/statuses').then(({ data }) => {
    orderStatuses.value = data;
  });
});

function onStatusChange() {
  axiosClient.post(`/orders/change-status/${order.value.id}/${order.value.status}`).then(({ data }) => {
    store.commit('showToast', `Order status was successfully changed to "${order.value.status}"`);
  });
}

function formatAddress(address) {
  return `${address.address1}, ${address.address2 ? address.address2 + ',' : ''} ${address.city}, ${address.zipcode}, ${address.state}, ${address.country}`;
}
</script>

<style scoped>
table td {
  border-bottom: 1px solid #e5e7eb;
}
</style>
