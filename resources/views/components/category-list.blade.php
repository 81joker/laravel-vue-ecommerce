<nav class="bg-slate-700 border-gray-200 py-2.5 dark:bg-gray-900 category-list text-white -mt-5 -mr-5 -ml-5 px-4
">
    <div class="flex flex-wrap items-center justify-end md:justify-between  px-4 mx-auto">
        <div class="flex items-center justify-end w-full lg:w-auto lg:order-2">
            <button data-collapse-toggle="mobile-menu-2" type="button"
                class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="mobile-menu-2" aria-expanded="true">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="items-center justify-between w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
            <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                @props(['categoryList'])
                @if (!empty($categoryList))
                    @foreach ($categoryList as $category)
                        <li class="category-item group relative">
                            @if(!is_null($category->children))
                                <button id="dropdownHoverButton-{{ $category->id }}" data-dropdown-toggle="dropdownHover-{{ $category->id }}" 
                                    data-dropdown-trigger="hover"
                                    class="flex items-center justify-between w-full py-2 pl-3 pr-4 text-white hover:bg-black/10 transition">
                                    {{ $category->name }}
                                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="dropdownHover-{{ $category->id }}" 
                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 absolute left-0">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton-{{ $category->id }}">
                                        @foreach($category->children as $child)
                                            <li>
                                                <a href="{{ route('byCategory', $child->id) }}" 
                                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                    {{ $child->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route('byCategory', $category->id) }}"
                                    class="block py-2 pl-3 pr-4 text-white cursor-pointer shadow hover:bg-black/10 transition"
                                    aria-current="page">{{ $category->name }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</nav>
<script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>