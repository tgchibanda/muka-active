<?php

/** @var \Illuminate\Database\Eloquent\Collection $products */
$categoryList = \App\Models\Category::getActiveAsTree();

?>

<x-app-layout>

<x-category-list :category-list="$categoryList" class="-ml-5 -mt-5 -mr-5 px-4" />
<br>

<div class="container mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8 py-10 bg-white shadow-lg rounded-lg">
    <h2 class="text-4xl font-bold text-gray-800 border-b pb-4 mb-8">Contact Us</h2>

    <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="name" class="block font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" class="w-full border-gray-300 rounded p-3 shadow-sm" required>
        </div>

        <div>
            <label for="email" class="block font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full border-gray-300 rounded p-3 shadow-sm" required>
        </div>

        <div>
            <label for="message" class="block font-medium text-gray-700">Message</label>
            <textarea name="message" id="message" rows="4" class="w-full border-gray-300 rounded p-3 shadow-sm" required></textarea>
        </div>

        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded shadow">
            Send Message
        </button>
    </form>
</div>

<div class="text-center my-10">
        <a href="/shop" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg shadow">
            🐝 Shop Now
        </a>
    </div>

</x-app-layout>
