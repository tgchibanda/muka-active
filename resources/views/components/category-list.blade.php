@props(['categoryList'])

<div {{ $attributes->merge(['class' => 'category-list flex text-white bg-yellow-700']) }}>
    @if (!empty($categoryList))
    <div class="category-item relative">
            <a href="{{ route('about_us') }}" class="cursor-pointer block py-3 px-6 hover:bg-black/10" >About Us</a>
        </div>
    <div class="category-item relative">
        <a href="{{ route('home') }}" class="cursor-pointer block py-3 px-6 hover:bg-black/10" >All</a>
    </div>
        @foreach($categoryList as $category)
            <div class="category-item relative">
                <a href="{{ route('byCategory', $category) }}" class="cursor-pointer block py-3 px-6 hover:bg-black/10">
                    {{$category->name}}
                </a>
                <x-category-list class="absolute left-0 top-[100%] z-50 hidden flex-col" :category-list="$category->children"/>
            </div>
        @endforeach

        <div class="category-item relative">
            <a href="{{ route('shipping_policy') }}" class="cursor-pointer block py-3 px-6 hover:bg-black/10" >Shipping Policy</a>
        </div>
        <div class="category-item relative">
            <a href="{{ route('contact_us') }}" class="cursor-pointer block py-3 px-6 hover:bg-black/10" >Contact Us</a>
        </div>
    @endif
</div>