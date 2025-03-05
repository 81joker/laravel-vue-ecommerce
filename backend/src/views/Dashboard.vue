<template>
    <h1 class="text-4xl mb-2">Dashbboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <!-- ACtivae Customers -->
        <div class="bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center">
            <label >Active Customers</label>
           <template v-if="!loading.cousomersCount">
            <span class="text-3xl font-semibold">{{ cousomersCount }}</span>
           </template>
            <Spinner v-else  text="" class=""/>
        </div>
        <!-- ACtivae Customers -->
        <!-- ACtivae Products -->
        <div class="bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center">
            <label >Active Products</label>
            <template v-if="!loading.productsCount">
            <span class="text-3xl font-semibold">{{ productsCount }}</span>
           </template>
            <Spinner v-else  text="" class=""/>
        </div>
        <!-- ACtivae Products -->
        <!--Paid Order -->
        <div class="bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center">
            <label >Total Paid Order</label>
            <template v-if="!loading.paidOrdersCount">
            <span class="text-3xl font-semibold">{{ productsCount }}</span>
           </template>
            <Spinner v-else  text="" class=""/>        </div>
        <!--Paid Order -->
        <!-- Total Income -->
        <div class="bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center">
            <label >Total Income</label>
            <template v-if="!loading.totalIncome">
            <span class="text-3xl font-semibold">{{ totalIncome }}</span>
           </template>
            <Spinner v-else  text="" class=""/>
        </div>
        <!-- Total Income -->

    </div>
    <div class="grid grid-rows-2  grid-flow-col grid-cols-1 md:grid-cols-3 mt-2 gap-3">
    <!-- <div class="grid grid-cols-1 md:grid-cols-3 mt-2 gap-3"> -->
        <div class="col-span-2 row-span-2 bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center">
            Products
        </div>
        <div class="bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center">
        <DoughnutChart   />
        </div>
        <div class="bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center">
            Customers
        </div>
    </div>
</template>
<script setup>
import axiosClient from '@/axios';
import DoughnutChart from '@/components/Charts/DoughnutChart.vue';
import Spinner from '@/components/core/Spinner.vue';
import { ref } from 'vue';


const loading = ref({
    cousomersCount: true,
    productsCount: true,
    paidOrdersCount: true,
    totalIncome: true
});

const cousomersCount = ref();
const productsCount = ref();
const paidOrdersCount = ref();
const totalIncome = ref();

axiosClient.get('/dashboard/customers-count').
then(({data}) => {
    cousomersCount.value = data;
    loading.value.cousomersCount = false;
});

axiosClient.get('/dashboard/products-count').
then(({data}) => {productsCount.value = data; loading.value.productsCount = false;});

axiosClient.get('/dashboard/orders-count').
then(({data}) =>{ paidOrdersCount.value = data; loading.value.paidOrdersCount = false;});

axiosClient.get('/dashboard/income-count').
then(({data}) => {totalIncome.value = new Intl.NumberFormat("de-DE", { style: "currency", currency: "EUR" })
.format(Math.random(data)),
loading.value.totalIncome = false;});
</script>
