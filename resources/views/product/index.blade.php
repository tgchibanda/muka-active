<?php

/** @var \Illuminate\Database\Eloquent\Collection $products */
$categoryList = \App\Models\Category::getActiveAsTree();

?>

<x-app-layout>

    <x-category-list :category-list="$categoryList" class="-ml-5 -mt-5 -mr-5 px-4" />

    <div class="flex gap-2 items-center p-3 pb-0 " 
            x-data="{
                selectedSort:'{{ request()->get('sort', '-updated_at') }}',
                searchKeyword: '{{ request()->get('search') }}',
                updateUrl() {
                    const params = new URLSearchParams(window.location.search)
                    params.set('sort', this.selectedSort)
                    if(this.searchKeyword){
                        params.set('sort', this.searchKeyword)
                    } else {
                        params.delete('sort', this.searchKeyword)
                    }
                    
                    window.location.href = window.location.origin + window.location.pathname + '?' + params.toString();
                    }
            }">

        <form action="" class="flex-1" method="get" @submit.prevent="updateUrl">
            <x-input id="loginEmail" type="text" x-model="searchKeyword" :errors="$errors" name="search" placeholder="Search for products name or short description"/>
        </form>

        <x-input 
            x-model="selectedSort" 
            @change="updateUrl()"
            type="select" name="sort" class="w-full focus:border-yellow-600 focus:ring-yellow-600 border-gray-300 rounded">
            <option value="price">Price (ASC)</option>
            <option value="-price">Price (DESC)</option>
            <option value="title">Title (ASC)</option>
            <option value="-title">Title (DESC)</option>
            <option value="-updated_at">Last modified at the top</option>
            <option value="updated_at">Last modified at the bottom</option>
        </x-input>

    </div>

    <?php if ($products->count() === 0) : ?>
        <div class="text-center text-gray-600 py-16 text-xl">
            There are no products published
        </div>
    <?php else : ?>
        <div class="grid gap-4 grig-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 p-3">
            @foreach($products as $product)
            <!-- Product Item -->
            <div x-data="productItem({{ json_encode([
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'image' => $product->image,
                        'title' => $product->title,
                        'price' => $product->price,
                        'addToCartUrl' => route('cart.add', $product)
                    ]) }})" class="border border-1 border-gray-200 rounded-md hover:border-yellow-600 transition-colors bg-white">
                <a href="{{ route('product.view', $product->slug) }}" class="aspect-w-3 aspect-h-2 block overflow-hidden">
                    <img src="{{ $product->image }}" alt="" class="object-cover rounded-lg hover:scale-105 hover:rotate-1 transition-transform" />
                </a>
                <div class="p-4">
                    <h3 class="text-lg">
                        <a href="{{ route('product.view', $product->slug) }}">
                            {{$product->title}}
                        </a>
                    </h3>
                    <h5 class="font-bold">${{$product->price}}</h5>
                </div>
                <div class="flex justify-between py-3 px-4">
                    <button class="btn-primary" @click="addToCart()">
                        Add to Cart
                    </button>
                </div>
            </div>
            <!--/ Product Item -->
            @endforeach
        </div>
        {{$products->appends(['sort'=> request('sort'), 'search' => request('search')])->links()}}
    <?php endif; ?>
</x-app-layout>