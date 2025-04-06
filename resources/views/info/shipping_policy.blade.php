<?php

/** @var \Illuminate\Database\Eloquent\Collection $products */
$categoryList = \App\Models\Category::getActiveAsTree();

?>

<x-app-layout>

<x-category-list :category-list="$categoryList" class="-ml-5 -mt-5 -mr-5 px-4" />
<br>

<div class="container mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8 py-10 bg-white shadow-lg rounded-lg">
    <h2 class="text-4xl font-bold text-gray-800 border-b pb-4 mb-8">Shipping Policy</h2>
    
    <p class="text-lg text-gray-700 mb-6">
        <strong>Postage:</strong> Products are dispatched from Mount Isa, Far North Queensland. We aim to pack and book your order for delivery within <span class="font-semibold">24 - 48 hours</span> after payment clearance.
    </p>

    <p class="text-lg text-gray-700 mb-6">
        We use <span class="font-semibold">Australia Post</span> as our courier service. 
        Our flat rate shipping fee is <span class="font-semibold">$10.90</span> for parcels up to 5kg.
        Any parcel over 5kg will be calculated based on weight.
    </p>

    <p class="text-lg text-gray-700 mb-6">
        All deliveries to post office boxes will be handled by <span class="font-semibold">Australia Post</span>. 
        Enjoy <span class="text-green-600 font-semibold">FREE shipping</span> on orders over <span class="font-semibold">$89</span>.
    </p>

    <p class="text-lg text-gray-700 mb-6">
        If a parcel needs re-delivery due to an incorrect address or non-collection, an additional fee will apply.
    </p>

    <p class="text-lg text-gray-700">
        If you purchase for someone else, we may inform them who sent the package if they inquire.
    </p>
</div>

</x-app-layout>
