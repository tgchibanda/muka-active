<template>
  <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
    <div class="flex justify-between border-b-2 pb-3">
      <div class="flex items-center">
        <span class="whitespace-nowrap mr-3">Per Page</span>
        <select @change="getCustomers(null)" v-model="perPage"
                class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
      </div>
      <div>
        <input v-model="search" @change="getCustomers(null)"
               class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
               placeholder="Type to Search customers">
      </div>
    </div>
      {{ customers.meta }}
      <table class="table-auto w-full">
      <thead>
      <tr>
        <TableHeaderCell @click="sortCustomer" class="border-b-2 p-2 text-left" field="id">
          ID
        </TableHeaderCell>
        <TableHeaderCell class="border-b-2 p-2 text-left" field="name" :sort-field="sortField">
          Name
        </TableHeaderCell>
        <TableHeaderCell @click="sortCustomer" class="border-b-2 p-2 text-left" field="email">
          Email
        </TableHeaderCell>
        <TableHeaderCell @click="sortCustomer" class="border-b-2 p-2 text-left" field="phone">
          Phone
        </TableHeaderCell>
        <TableHeaderCell @click="sortCustomer" class="border-b-2 p-2 text-left" field="updated_at">
          Registered On
        </TableHeaderCell>
        <TableHeaderCell field="actions">
          Actions
        </TableHeaderCell>
      </tr>
      </thead>
      <tbody v-if="customers.loading">
        <tr>
          <td colspan="5"><Spinner class="my-4" v-if="customers.loading"/></td>
        </tr>
      </tbody>
      <tbody v-else>
      <tr v-for="(customer, index) of customers.data" class="animate-fade-in" :style="{'animation-delay': `${index*0.05}s`}">
        <td class="border-b p-2 ">{{ customer.user_id }}</td>
        <td class="border-b p-2 ">
          {{ customer.first_name }} {{ customer.last_name }}
        </td>
        <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">
          {{ customer.email }}
        </td>
        <td class="border-b p-2">
          {{ customer.phone }}
        </td>
        <td class="border-b p-2">
          {{ customer.created_at }}
        </td>
  
        <td class="border-b p-2">
  
          <Menu as ="div" class="relative inline-block text-left">
            <div>
          <MenuButton
            class="inline-flex items-center justify-center w-full rounded-full h-10 bg-black bg-opacity-0"
          >
            <DotsVerticalIcon
              class="h-5 w-5 text-indigo-500"
              aria-hidden="true"
            />
          </MenuButton>
        </div>
  
        <transition
          enter-active-class="transition duration-100 ease-out"
          enter-from-class="transform scale-95 opacity-0"
          enter-to-class="transform scale-100 opacity-100"
          leave-active-class="transition duration-75 ease-in"
          leave-from-class="transform scale-100 opacity-100"
          leave-to-class="transform scale-95 opacity-0"
        >
        <MenuItems
            class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
          >
          <div class="px-1 py-1">
  
            <MenuItem v-slot="{ active }">
  
              <button
                :class="[
                  active ? 'bg-indigo-600' : 'text-gray-900',
                  'group flex w-full items-center rounded-md px-2 py-2 text-sm']"
                  @click="editCustomer(customer)">
                  <PencilIcon
                    :active="active"
                    class="mr-2 h-5 w-5 text-indigo-400"
                    aria-hidden="true"
                    />
                    Edit
              </button>
  
            </MenuItem>
  
            <MenuItem v-slot="{ active }">
  
              <button
                :class="[
                  active ? 'bg-indigo-600' : 'text-gray-900',
                  'group flex w-full items-center rounded-md px-2 py-2 text-sm']"
                  @click="deleteCustomer(customer)">
                  <TrashIcon
                    :active="active"
                    class="mr-2 h-5 w-5 text-indigo-400"
                    aria-hidden="true"
                    />
                    Delete
              </button>
  
            </MenuItem>
          </div>
        </MenuItems>
      
      </transition>
          </Menu>
        </td>
      </tr>
      </tbody>
    </table>
    <div v-if="!customers.loading" class="flex justify-between items-center mt-5">
      <span>
        Showing from {{ customers.from }} to {{ customers.to }}
      </span>
      <nav
          v-if="customers.total > customers.limit"
          class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
          aria-label="Pagination">
          <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
        <a
          v-for="(link, i) of customers.links"
          :key="i"
          :disabled="!link.url"
          href="#"
          @click.prevent="getForPage($event, link)"
          aria-current="page"
          class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
          :class="[
              link.active
                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
              i === 0 ? 'rounded-l-md' : '',
              i === customers.links.length - 1 ? 'rounded-r-md' : '',
              !link.url ? ' bg-gray-100 text-gray-700': ''
            ]"
          v-html="link.label"
        >
        </a>
      </nav>
    </div>
  </div>
  </template>
  
  <script setup>
  import {computed, onMounted, ref} from 'vue';
  import store from "../../store/index.js";
  import Spinner from "../../components/core/Spinner.vue";
  import TableHeaderCell from "../../components/core/Table/TableHeaderCell.vue";
  import {PRODUCTS_PER_PAGE} from "../../constants.js";
  import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue';
  import {DotsVerticalIcon, PencilIcon, TrashIcon} from '@heroicons/vue/outline';
  
  const emit = defineEmits(['clickEdit']);
  const perPage = ref(PRODUCTS_PER_PAGE)
  const search = ref ('')
  const customers = computed(() => store.state.customers)
  const sortField = ref('updated_at')
  const sortDirection = ref('desc')
  
  onMounted(() => {
  getCustomers();
  })
  
  function getCustomers(url = null) {
  store.dispatch('getCustomers', {
          url,
          sort_field: sortField.value,
          sort_direction: sortDirection.value,
          search: search.value,
        perPage: perPage.value})
  }
  
  function getForPage(ev, link){
    if(!link.url || link.active) {
      return
    }
    getCustomers(link.url);
  }
  
  function sortCustomer(field){
    if (field === sortField.value) {
      if (sortDirection.value === 'desc') {
        sortDirection.value = 'asc'
      } else {
        sortDirection.value = 'desc'
      }
    } else {
      sortField.value = field;
      sortDirection.value = 'asc'
    }
  
    getCustomers();
  }
  
  function editCustomer(customer){
    emit('clickEdit', customer);
  }
  
  function deleteCustomer(customer) {
    if(!confirm('Are you sure you want to delete the customer?')){
      return
    }
    store.dispatch('deleteCustomer', customer.id)
    .then(res => {
      // TODO Show notification
      store.dispatch('getCustomers')
    })
  }
  </script>
  
  <style scoped>
  
  </style>
  