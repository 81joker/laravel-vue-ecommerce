@props(['categoryList', 'isChild' => false, 'level' => 0])

<div class="relative">
    <!-- Mobile toggle button - only for root level -->
    @if($level === 0)
    <button onclick="toggleMainMenu()" class="md:hidden bg-slate-800 text-white p-3 w-full text-left flex justify-between items-center">
        Categories
        <span id="mainMenuIcon">▼</span>
    </button>
    @endif

    <!-- Category list container -->
    <div id="{{ $isChild ? 'childMenu-'.$level : 'mainMenu' }}" 
         class="{{ $isChild ? 'child-menu' : 'main-menu' }} 
                {{ !$isChild && $level === 0 ? 'hidden md:flex' : '' }} 
                {{ $isChild ? 'hidden md:group-hover:flex' : '' }}
                bg-slate-700 text-white">
        @if (!empty($categoryList))
            <div class="{{ $isChild ? 'pl-4' : '' }} {{ $level === 0 ? 'flex flex-col md:flex-row' : '' }}">
                @foreach ($categoryList as $category)
                    <div class="category-item relative group" 
                         onmouseenter="handleHover(this, {{ !empty($category->children) ? 'true' : 'false' }})"
                         onmouseleave="handleLeave(this, {{ !empty($category->children) ? 'true' : 'false' }})">
                        <a href="{{ route('byCategory', $category->id) }}" 
                           class="block cursor-pointer py-3 px-6 hover:bg-black/10 transition flex justify-between items-center"
                           onclick="handleClick(event, {{ !empty($category->children) ? 'true' : 'false' }})">
                            {{ $category->name }}
                            @if(!empty($category->children))
                                <span class="arrow-icon transform transition-transform duration-200">›</span>
                            @endif
                        </a>
                        @if(!empty($category->children))
                            <x-category-list 
                                :categoryList="$category->children" 
                                :isChild="true"
                                :level="$level + 1"
                                class="absolute md:top-full left-0 z-50 bg-slate-700 w-full md:w-48 shadow-md" 
                            />
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-gray-400 py-4 px-6">
                No categories available
            </div>
        @endif
    </div>
</div>

{{-- <script>
  // Toggle main menu on mobile
function toggleMainMenu() {
    const menu = document.getElementById('mainMenu');
    const icon = document.getElementById('mainMenuIcon');
    menu.classList.toggle('active');
    icon.textContent = menu.classList.contains('active') ? '▲' : '▼';
}

// Unified hover handler for both mobile and desktop
function handleHover(element, hasChildren) {
    if (hasChildren) {
        const childMenu = element.querySelector('.child-menu');
        if (childMenu) {
            if (window.innerWidth < 768) {
                // On mobile, show immediately on hover
                childMenu.style.display = 'flex';
            } else {
                // On desktop, use the hover behavior
                element.classList.add('hover-active');
                childMenu.style.display = 'flex';
            }
        }
    }
}

function handleLeave(element, hasChildren) {
    if (hasChildren) {
        const childMenu = element.querySelector('.child-menu');
        if (childMenu) {
            if (window.innerWidth < 768) {
                // On mobile, don't hide on leave - let click handle it
                return;
            } else {
                // On desktop, hide after delay
                element.classList.remove('hover-active');
                setTimeout(() => {
                    if (!element.classList.contains('hover-active')) {
                        childMenu.style.display = 'none';
                    }
                }, 200);
            }
        }
    }
}

// Click handler for mobile
function handleClick(event, hasChildren) {
    if (window.innerWidth < 768 && hasChildren) {
        event.preventDefault();
        const item = event.currentTarget.closest('.category-item');
        item.classList.toggle('active');
        
        // Toggle child menu display
        const childMenu = item.querySelector('.child-menu');
        if (childMenu) {
            childMenu.style.display = item.classList.contains('active') ? 'flex' : 'none';
        }
        
        // Close siblings
        const siblings = Array.from(item.parentNode.children).filter(child => child !== item);
        siblings.forEach(sibling => {
            sibling.classList.remove('active');
            const siblingChildMenu = sibling.querySelector('.child-menu');
            if (siblingChildMenu) {
                siblingChildMenu.style.display = 'none';
            }
        });
    }
}

// Close menus when clicking outside (mobile)
document.addEventListener('click', function(event) {
    if (window.innerWidth >= 768) return;
    
    if (!event.target.closest('.category-item')) {
        document.querySelectorAll('.category-item').forEach(item => {
            item.classList.remove('active');
            const childMenu = item.querySelector('.child-menu');
            if (childMenu) {
                childMenu.style.display = 'none';
            }
        });
    }
});
</script>
 --}}
