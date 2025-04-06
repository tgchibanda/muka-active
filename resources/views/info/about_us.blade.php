<?php

/** @var \Illuminate\Database\Eloquent\Collection $products */
$categoryList = \App\Models\Category::getActiveAsTree();

?>

<x-app-layout>

<x-category-list :category-list="$categoryList" class="-ml-5 -mt-5 -mr-5 px-4" />
<br>

<div class="container mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8 py-10 bg-white shadow-lg rounded-lg">
    <h2 class="text-4xl font-bold text-gray-800 border-b pb-4 mb-8">About Us</h2>

    {{-- Hero Section: Image + Text Side by Side --}}
    <div class="flex flex-col md:flex-row items-center md:items-start gap-8 mb-12">
        <img src="{{ asset('store/images/9.jpeg') }}" alt="Cody and Robin with Honeycombs"
             class="w-full md:w-1/2 rounded-lg shadow-md object-cover max-h-[400px]">

        <div class="text-lg text-gray-700 md:w-1/2">
            <p class="mb-4">
                <strong>Mt Isa Beehive Products</strong> is a family-owned natural honey and beekeeping business based in Mount Isa, Queensland.
                Founded by <strong>Cody and his mum Robin</strong>, we manage over <strong>80 hives</strong> producing premium homemade bee-based products.
            </p>
            <p class="mb-4">
                We proudly offer <strong>raw honey, healing balms, beeswax furniture polish, leather wax</strong> and more — all handmade with care using natural ingredients.
            </p>
            <p class="mb-4">
                As licensed beekeepers (<strong>Licence: H1457</strong>), we also provide:
                <ul class="list-disc ml-6 mt-2">
                    <li>Beehive Removal Services</li>
                    <li>Pollination Services for local farms and gardens</li>
                </ul>
            </p>
            <p>
                <strong>ABN:</strong> 26780144519<br>
                <strong>Phone (Cody):</strong> 0408 251 669
            </p>
        </div>
    </div>

    <div class="text-center my-10">
        <a href="/" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg shadow">
            🐝 Shop Now
        </a>
    </div>

    <hr class="my-10">

    <h3 class="text-3xl font-semibold text-gray-800 mb-6">Meet the Beekeepers</h3>

    <div class="flex flex-col md:flex-row items-center gap-8 mb-12">
        <img src="{{ asset('store/images/15.jpeg') }}" alt="Cody with honeycomb"
             class="w-full md:w-1/2 rounded shadow-md object-cover max-h-[400px]">
        <div class="text-lg text-gray-700 md:w-1/2">
            <p class="mb-3"><strong>Cody</strong> is our lead beekeeper — maintaining hives, harvesting honey, and ensuring ethical, sustainable beekeeping.</p>
            <p><strong>Robin</strong> crafts our salves and waxes, drawing from her deep knowledge of natural remedies and homemaking tradition.</p>
        </div>
    </div>

    
</div>


</x-app-layout>
