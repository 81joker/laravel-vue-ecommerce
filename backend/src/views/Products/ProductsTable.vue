<template>
  <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
    <div class="flex justify-between border-b-2 pb-3">
      <div class="flex items-center">
        <span class="whitespace-nowrap mr-3">Per Page</span>
        <select @change="getProducts(null)" v-model="perPage"
          class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
        <span class="ml-3">Found products</span>
      </div>
      <div>
        <input @change="getProducts(null)" v-model="search"
          class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
          placeholder="Type to Search products" />
      </div>
    </div>
    page:response.page,

    <Spinner v-if="products.loading" />
    <template v-else>
      <table class="table-auto w-full">
        <thead>
          <tr>
            <!-- <th class="border-b-2 p-2 text-left">ID</th>
                        <th class="border-b-2 p-2 text-left">Image</th>
                        <th class="border-b-2 p-2 text-left">Title</th>
                        <th class="border-b-2 p-2 text-left">Price</th>
                        <th class="border-b-2 p-2 text-left">Last Updated At</th> -->
            <TableHeaderCell field="id" :sort-field="sortField" :sort-direction="sortDirection"
              @click="sortProducts('id')">
              ID
            </TableHeaderCell>
            <TableHeaderCell field="image" :sort-field="sortField" :sort-direction="sortDirection">
              Image
            </TableHeaderCell>
            <TableHeaderCell field="title" :sort-field="sortField" :sort-direction="sortDirection"
              @click="sortProducts('title')">
              Title
            </TableHeaderCell>
            <TableHeaderCell field="price" :sort-field="sortField" :sort-direction="sortDirection"
              @click="sortProducts('price')">
              Price
            </TableHeaderCell>
            <TableHeaderCell field="updated_at" :sort-field="sortField" :sort-direction="sortDirection"
              @click="sortProducts('updated_at')">
              Last Updated At
            </TableHeaderCell>
            <TableHeaderCell field="actions"> Actions </TableHeaderCell>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(product , index) in products.data" :key="product.id" class="animate-fade-in-down" :style="{'animation-delay': `${index * 0.2}s`}">
            <td class="border-b p-2">{{ product.id }}</td>
            <td class="border-b p-2">
              <img :src="product.image" :alt="product.title" class="w-14 h-10 object-cover rounded-full" />
            </td>
            <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">
              {{ product.title }}
            </td>
            <td class="border-b p-2">{{ product.price }}</td>
            <td class="border-b p-2">{{ product.updated_at }}</td>
            <td class="border-b p-2">
              <Menu as="div" class="relative inline-block text-left">
                <div>
                  <MenuButton
                    class="inline-flex items-center justify-center w-full justify-center rounded-full w-10 h-10 bg-black bg-opacity-0 text-sm font-medium text-white hover:bg-opacity-5 focus:bg-opacity-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75">
                    <DotsVerticalIcon class="h-5 w-5 text-indigo-500" aria-hidden="true" />
                  </MenuButton>
                </div>

                <transition enter-active-class="transition duration-100 ease-out"
                  enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
                  leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100"
                  leave-to-class="transform scale-95 opacity-0">
                  <MenuItems
                    class="absolute z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <div class="px-1 py-1">
                      <MenuItem v-slot="{ active }">
                      <button :class="[
                        active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                        'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                      ]" @click="editProduct(product)">
                        <PencilIcon :active="active" class="mr-2 h-5 w-5 text-indigo-400" aria-hidden="true" />
                        Edit
                      </button>
                      </MenuItem>
                      <MenuItem v-slot="{ active }">
                      <button :class="[
                        active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                        'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                      ]" @click="deleteProduct(product)">
                        <TrashIcon :active="active" class="mr-2 h-5 w-5 text-indigo-400" aria-hidden="true" />
                        Delete
                      </button>
                      </MenuItem>
                    </div>
                  </MenuItems>
                </transition>
              </Menu>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="flex items-center justify-between mt-5 bg-red">
        <span>
          Showing from {{ products.from }} to {{ products.to }} products
        </span>
        <nav v-if="products.total > products.limit"
          class="relative z-0 inline-flex rounded-md justify-center shadow-sm -space-x-px" aria-label="Pagination">
          <a v-for="(link, i) of products.links" :key="i" :disabled="!link.url" href="#"
            @click="getForPage($event, link)" aria-current="page"
            class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap" :class="[
              link.active
                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
              i === 0 ? 'rounded-l-md' : '',
              i === products.links.length - 1 ? 'rounded-r-md' : '',
              !link.url ? ' bg-gray-100 text-gray-700' : '',
            ]" v-html="link.label">
          </a>
        </nav>
      </div>
    </template>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { DotsVerticalIcon, PencilIcon, TrashIcon } from '@heroicons/vue/outline'
import Spinner from "@/components/core/Spinner.vue";
import store from "../../store";
import { PRODUCTS_PER_PAGE } from "../../constants.js";
import TableHeaderCell from "@/components/core/Table/TableHeaderCell.vue";
const perPage = ref(PRODUCTS_PER_PAGE);
const search = ref("");
const products = computed(() => store.state.products);
const sortField = ref('updated_at');
const sortDirection = ref('desc')
onMounted(() => {
  getProducts(null);
});

function getProducts(url = null) {
  // store.dispatch("getProducts"  , {url});
  store.dispatch("getProducts", {
    url,
    perPage: perPage.value,
    search: search.value,
    // per_page: perPage.value,
    sort_field: sortField.value,
    sort_direction: sortDirection.value
  });
  // store.dispatch("getProducts", {perPage: perPage.value, page, search: search.value});
}

function getForPage(ev, link) {
  ev.preventDefault();
  if (!link.url || link.active) {
    return;
  }
  getProducts(link.url);
}

function sortProducts(field) {
  if (field === sortField.value) {
    if (sortDirection.value === 'desc') {
      sortDirection.value = 'asc'
    } else {
      sortDirection.value = 'desc'
    }
  } else {
    sortField.value = field;
    sortDirection.value = 'asc'
  }

  getProducts()
}



function deleteProduct(product) {
  if (!confirm(`Are you sure you want to delete the product?`)) {
    return
  }
  store.dispatch('deleteProduct', product.id)
    .then(res => {
      // TODO Show notification
      store.dispatch('getProducts')
    })
}

function editProduct(p) {
  emit('clickEdit', p)
}
</script>

<style scoped></style>
