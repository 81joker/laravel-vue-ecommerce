<template>
    <div v-if="customer">
  
  <pre>{{ customer }}</pre>
  
    </div>
  </template>
  
  <script setup>
  import {computed, onMounted, ref} from "vue";
  import store from "../../store";
  import {useRoute} from "vue-router";
  import axiosClient from "../../axios.js";
  
  const route = useRoute()
  
  const customer = ref(null);
  
  onMounted(() => {
    store.dispatch('getCustomer', route.params.id)
      .then(({data}) => {
        customer.value = data
      })
  
  })
  
  
  </script>
  
  <style scoped>
  
  </style>