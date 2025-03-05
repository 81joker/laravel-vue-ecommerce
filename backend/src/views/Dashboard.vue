<template>
    <h1 class="text-4xl mb-2">Dashbboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <!-- ACtivae Customers -->
        <div class="bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center">
            <label class="font-semibold">Total Users</label>
            <span class="text-3xl font-bold">0</span>
        </div>
        <!-- ACtivae Customers -->
        <!-- ACtivae Products -->
        <div class="bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center">
            <label class="font-semibold">Total Users</label>
            <span class="text-3xl font-bold">1212</span>
        </div>
        <!-- ACtivae Products -->
        <!--Paid Order -->
        <div class="bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center">
            <label class="font-semibold">Total Users</label>
            <span class="text-3xl font-bold">0</span>
        </div>
        <!--Paid Order -->
        <!-- Total Income -->
        <div class="bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center">
            <label class="font-semibold">Total Users</label>
            <span class="text-3xl font-bold">1212.3232</span>
        </div>
        <!-- Total Income -->

        <div>
            <!-- Order Country -->
            <Doughnut  />
          <!-- Order Country -->
        </div>
    </div>
</template>
<script setup>
import Doughnut from '@/components/Charts/Doughnut.vue';




</script>
