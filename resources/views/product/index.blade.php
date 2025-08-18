<?php
/** @var \Illuminate\Database\Eloquent\Collection $products */
$categoryList = \App\Models\Category::getActiveAsTree();
?>
<x-app-layout>
  <x-category-list  :category-list="$categoryList" class="-mt-5 -mr-5 -ml-5 px-4"/>
    <?php if ($products->count() === 0): ?>
        <div class="text-center text-gray-600 py-16 text-xl">
            There are no products published
        </div>
    <?php else: ?>
    <div class="grid gap-8 grig-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 p-5 gap-4">
        @foreach ($products as $product)
            <!-- Product Item -->
            <div 
            x-data="productItem({{ json_encode([
                'id' => $product->id,
                'title' => $product->title,
                'image' => $product->image,
                'description' => $product->description,
                'price' => $product->price,
                'addToCartUrl' => route('cart.add', $product),
            ]) }})"
            class="relative flex flex-col my-6 bg-white shadow-sm border border-slate-200 rounded-lg w-96 hover:border-purple-600 transition-colors">
    
                <a  href="{{ route('product.view', $product->slug) }}" class="relative p-2.5 h-96 overflow-hidden rounded-xl bg-clip-border">
                  <img                   
                  src="{{ $product->image ?: '/images/no-image.png' }}"
                   alt="{{ Str::limit($product->title, 10) }}"
                   class="h-full w-full object-cover rounded-md hover:rotate-1 transition-transform"
                 />
                </a>
                <div class="p-4">
                  <div class="mb-2 flex items-center justify-between">
                    <p class="text-slate-800 text-xl font-semibold">
                      {{ Str::limit($product->title, 25) }}
                    </p>
                    <p class="text-purple-600 text-xl font-semibold">
                      ${{ $product->price }}
                    </p>
                  </div>
                  <p class="text-slate-600 leading-normal font-light">
                    {{ Str::limit($product->description, 80) }} 
                  </p>
                  <button class="btn-primary w-full mt-6 py-2 px-4 border border-transparent 
                  text-sm transition-all shadow-md hover:shadow-lg focus:bg-purple-700
                  focus:shadow-none active:bg-purple-700 hover:bg-purple-700 
                  active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" @click="addToCart()">
                    Add to Cart
                  </button>
                </div>
              </div>
            <!--/ Product Item -->
        @endforeach
    </div>
    <div class="p-5 text-start">
        {{$products->links()}}
    </div>
    <?php endif; ?>

</x-app-layout>
