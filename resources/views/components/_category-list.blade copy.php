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

{{-- @props(['categoryList'])

<div {{ $attributes->merge(['class' => 'category-list bg-slate-700 text-white']) }}>
    {{-- زر فتح القائمة في الموبايل --}}
    <div class="md:hidden p-4 flex justify-between items-center">
        <h2 class="text-lg font-bold">Categories</h2>
        <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="p-2 bg-slate-800 rounded">
            ☰
        </button>
    </div>

    {{-- قائمة التصنيفات --}}
    <div id="mobile-menu" class="md:flex flex-wrap hidden md:!flex">
        @if (!empty($categoryList))
            @foreach ($categoryList as $category)
                <div class="category-item relative group">
                    <a href="{{ route('byCategory', $category->id) }}" class="block cursor-pointer py-3 px-6 shadow hover:bg-black/10 transition">
                        {{ $category->name }}
                    </a>

                    {{-- العناصر الفرعية --}}
                    @if(!is_null($category->children))
                        <div class="absolute left-0 top-full z-50 hidden group-hover:flex flex-col bg-slate-700 w-48">
                            <x-category-list :categoryList="$category->children" />
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="text-center text-gray-300 py-16 text-xl">
                No categories available
            </div>
        @endif
    </div>
</div> --}}
