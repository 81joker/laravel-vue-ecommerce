<template>
  <div>
    <!-- <pre>{{ products.links }}</pre> -->
    <div class="flex items-center justify-between mb-3">
      <h1 class="text-3xl font-semibold">Products</h1>
      <button
        type="button"
        @click="showProductModal"
        class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Add new Product
      </button>
    </div>
  <ProductModal v-model="showModal"  :product="productModel" />
  <ProductsTable />
  </div>
</template>
<script setup>
import { ref } from "vue";
import ProductModal from "./ProductModal.vue";
import ProductsTable from "./ProductsTable.vue";

const productModel = ref({
  id: null,
  title: "",
  image: null,
  description: "",
  price: 0,
});
const showModal = ref(false)
  function showProductModal() {
    showModal.value = true
  }
// function sortProducts(field) {
//     debugger
// //   store.dispatch("getProducts", {
// //     sortField: field,
// //     sortDirection: products.sortDirection,
// //     perPage: perPage.value,
// //     search: search.value,
// //   });
// }
</script>
