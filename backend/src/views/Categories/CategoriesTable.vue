<template>
<div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
  <div class="flex justify-between border-b-2 pb-3">
    <div class="flex items-center">
      <span class="whitespace-nowrap mr-3">Per Page</span>
      <select @change="getCategories(null)" v-model="perPage"
              class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="50">50</option>
        <option value="100">100</option>
      </select>
    </div>
    <div>
      <input v-model="search" @change="getCategories(null)"
             class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
             placeholder="Type to Search categories">
    </div>
  </div>
    {{ categories.meta }}
    <table class="table-auto w-full">
    <thead>
    <tr>
      <TableHeaderCell @click="sortCategory" class="border-b-2 p-2 text-left" field="id" :sort-field="sortField" :sort-direction="sortDirection">
        ID
      </TableHeaderCell>
      <TableHeaderCell @click="sortCategory" class="border-b-2 p-2 text-left" field="name" :sort-field="sortField" :sort-direction="sortDirection">
        Name
      </TableHeaderCell>
      <TableHeaderCell @click="sortCategory" class="border-b-2 p-2 text-left" field="slug" :sort-field="sortField" :sort-direction="sortDirection">
        Slug
      </TableHeaderCell>
      <TableHeaderCell @click="sortCategory" class="border-b-2 p-2 text-left" field="active" :sort-field="sortField" :sort-direction="sortDirection">
        Active
      </TableHeaderCell>
      <TableHeaderCell @click="sortCategory" class="border-b-2 p-2 text-left" field="parent_id" :sort-field="sortField" :sort-direction="sortDirection">
        Parent
      </TableHeaderCell>
      <TableHeaderCell @click="sortCategory" class="border-b-2 p-2 text-left" field="created_at" :sort-field="sortField" :sort-direction="sortDirection">
        Created At
      </TableHeaderCell>
      <TableHeaderCell field="actions">
        Actions
      </TableHeaderCell>
    </tr>
    </thead>
    <tbody v-if="categories.loading">
      <tr>
        <td colspan="7"><Spinner class="my-4" v-if="categories.loading"/></td>
      </tr>
    </tbody>
    <tbody v-else>
    <tr v-for="(category, index) of categories.data" class="animate-fade-in" :style="{'animation-delay': `${index*0.05}s`}">
      <td class="border-b p-2 ">{{ category.id }}</td>
      <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">
        {{ category.name }}
      </td>
      <td class="border-b p-2">
        {{ category.slug }}
      </td>
      <td class="border-b p-2">
        {{ category.active ? 'Yes' : 'No' }}
      </td>
      
      <td class="border-b p-2">
        {{ category.parent?.name }}
      </td>
      
      <td class="border-b p-2">
        {{ category.created_at }}
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
                @click="editCategory(category)">
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
                @click="deleteCategory(category)">
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
  <div v-if="!categories.loading" class="flex justify-between items-center mt-5">
    <span>
      Showing from {{ categories.from }} to {{ categories.to }}
    </span>
    <nav
        v-if="categories.total > categories.limit"
        class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
        aria-label="Pagination">
        <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
      <a
        v-for="(link, i) of categories.links"
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
            i === categories.links.length - 1 ? 'rounded-r-md' : '',
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
import {CATEGORIES_PER_PAGE} from "../../constants.js";
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue';
import {DotsVerticalIcon, PencilIcon, TrashIcon} from '@heroicons/vue/outline';

const emit = defineEmits(['clickEdit']);
const perPage = ref(CATEGORIES_PER_PAGE)
const search = ref ('')
const categories = computed(() => store.state.categories)
const sortField = ref('name')
const sortDirection = ref('asc')

onMounted(() => {
      try {
        getCategories();
        //console.log('OK');
      } catch (error) {
        console.error('Error in onMounted:', error);
      }
    });

function getCategories(url = null) {
store.dispatch('getCategories', {
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
  getCategories(link.url);
}

function sortCategory(field){
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

  getCategories();
}

function editCategory(category){
  emit('clickEdit', category);
}

function deleteCategory(category) {
  if(!confirm('Are you sure you want to delete the category?')){
    return
  }
  store.dispatch('deleteCategory', category.id)
  .then(res => {
    store.commit('showToast', `Category Deleted`)
    store.dispatch('getCategories')
  })
}
</script>

<style scoped>

</style>
