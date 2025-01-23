<template>
  <div class="min-h-full bg-gray-200  flex">
    <!-- Sidebar-->
    <Sidebar :class="{ '-ml-[200px]': !sidebarOpened }" />
    <!--/ Sidebar-->

    <div class="flex-1">
      <Navbar @toggle-sidebar="toggleSidebar" />
      <!-- Content -->
      <main class="p-6">
        <div class="bg-white p-4 rounded">
          <router-view></router-view>
        </div>
      </main>
      <!--/ Content -->
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted} from 'vue'
import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";
import store from '../store'

const { title } = defineProps({
  title: String
})
const sidebarOpened = ref(true)

function toggleSidebar() {
  sidebarOpened.value = !sidebarOpened.value
}

onMounted(() => {
  // store.dispatch('getUser')
  window.addEventListener('resize', handleSidebarOpen)
})
function handleSidebarOpen(){

  sidebarOpened.value = window.outerWidth > 768;
}


</script>

