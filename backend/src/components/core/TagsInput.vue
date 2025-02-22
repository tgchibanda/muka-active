<template>
  <div class="flex flex-wrap items-center border border-gray-300 rounded-md p-2">
    <!-- Display Existing Tags -->
    <span v-for="(tag, index) in modelValue" :key="index" class="bg-indigo-200 text-indigo-800 px-2 py-1 rounded-full flex items-center mr-2 mb-1">
      {{ tag }}
      <button type="button" class="ml-1 text-red-600 hover:text-red-800" @click="removeTag(index)">×</button>
    </span>

    <!-- Input for Adding New Tags -->
    <input
      type="text"
      v-model="newTag"
      @keydown.enter.prevent="addTag"
      @keydown.backspace="handleBackspace"
      class="border-none focus:ring-0 flex-1 outline-none px-2 py-1"
      placeholder="Add a product color and press enter if it exist!"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  modelValue: Array
});

const emit = defineEmits(['update:modelValue']);
const newTag = ref("");

function addTag() {
  if (newTag.value.trim() !== "") {
    const updatedTags = [...(props.modelValue || []), newTag.value.trim()];
    emit("update:modelValue", updatedTags);
    newTag.value = ""; // Clear input after adding
  }
}

function removeTag(index) {
  const updatedTags = [...props.modelValue];
  updatedTags.splice(index, 1);
  emit("update:modelValue", updatedTags);
}

// Handle Backspace to remove last tag if input is empty
function handleBackspace(event) {
  if (newTag.value === "" && props.modelValue.length > 0) {
    removeTag(props.modelValue.length - 1);
  }
}
</script>

<style scoped>
input {
  min-width: 100px;
}
</style>
