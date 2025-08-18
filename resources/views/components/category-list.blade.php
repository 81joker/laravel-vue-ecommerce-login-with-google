@props(['categoryList'])
<div {{ $attributes->merge(['class' => 'category-list flex text-white bg-slate-700']) }}>
    @if (!empty($categoryList))
            @foreach ($categoryList as $category)
              <div class="category-item relative">
                <a href="{{ route('byCategory', $category->id) }}" class="block cursor-pointer py-3 px-6  shadow hover:bg-black/10 transition">
                 {{ $category->name }}
                </a>
              @if(!is_null($category->children))
                  <x-category-list :categoryList="$category->children" class="absolute  top-[100%] z-50 flex-col hidden" />
                @endif
              </div>
            @endforeach
    @else
        <div class="text-center text-gray-600 py-16 text-xl">
            No categories available
        </div>
    @endif

</div>
