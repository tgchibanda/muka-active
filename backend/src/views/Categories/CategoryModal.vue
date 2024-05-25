<template>
  <TransitionRoot appear :show="show" as="template">
    <Dialog as="div" @close="closeModal" class="relative z-10">
      <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
        leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-black/25"></div>
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
          <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95">
            <DialogPanel
              class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[700px] sm:w-full">

              <Spinner v-if="loading"
                class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center" />
              <header class="py-3 px-4 flex justify-between items-center">
                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                  {{ category.id ? `Update category: "${props.category.name}"` : 'Create new Category' }}
                </DialogTitle>
                <button @click="closeModal()"
                  class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </header>
              <form @submit.prevent="onSubmit">
                <div class="bg-white px-4 pt-5 pb-4">
                  <CustomInput type="text" class="mb-2" v-model="category.name" label="Category Name" />

                  <CustomInput type="select" :select-options="parentCategories" class="mb-2"
                    v-model="category.parent_id" label="parent" />


                  <CustomInput type="checkbox" class="mb-2" v-model="category.active" label="Active" />
                </div>
                <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                  <button type="submit"
                    class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-3">
                    Submit
                  </button>
                  <button type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    @click="closeModal" ref="cancelButtonRef">
                    Cancel
                  </button>
                </footer>
              </form>

            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { ref, computed, onUpdated } from 'vue'
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'
import store from '../../store/index.js'
import CustomInput from '../../components/core/CustomInput.vue'
import Spinner from "../../components/core/Spinner.vue";


const loading = ref(false);

const props = defineProps({
  modelValue: Boolean,
  category: {
    requred: true,
    type: Object,
  }
})

const category = ref({
  id: props.category.id,
  name: props.category.name,
  active: props.category.active,
  parent_id: props.category.parent_id,
})

const emit = defineEmits(['update:modelValue', 'close'])

const show = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
})

const parentCategories = computed(() => {
  return [
    { key: '', text: 'Select Parent Category' },
    ...store.state.categories.data
    .filter(c => {
      if (category.value.id) {
        return c.id !== category.value.id
      }
      return true;
    })
    .map(c => ({ key: c.id, text: c.name }))
  ]
})

onUpdated(() => {
  category.value = {
    id: props.category.id,
    name: props.category.name,
    active: props.category.active,
    parent_id: props.category.parent_id,
  }
})

function closeModal() {
  show.value = false
  emit('close')
}

function onSubmit() {
  loading.value = true
  category.value.active = !!category.value.active
  if (category.value.id) {
    store.dispatch('updateCategory', category.value)
      .then(response => {
        loading.value = false;
        if (response.status === 200) {
          store.commit('showToast', `Category Updated`)
          store.dispatch('getCategories')
          closeModal()
        }
      })
  } else {
    store.dispatch('createCategory', category.value)
      .then(response => {
        loading.value = false;
        if (response.status === 201) {
          store.commit('showToast', `Category Created`)
          store.dispatch('getCategories')
          closeModal()
        }
      })
      .catch(err => {
        loading.value = false;
        debugger;
      })
  }
}

</script>


<style scoped></style>
