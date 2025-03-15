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
        <div class="col-span-2 row-span-2 bg-white py-6 px-5 text-center shadow">
            <label class="text-lg font-semibold block mb-2">Latest Orders</label>
            <template v-if="!loading.latestOrders">
                <router-link :to="{name: 'app.orders.view', params: {id: o.id}}" v-for="o of latestOrders" :key="o.id"
                             class="mb-3 flex">
                    <h1>
                    Order #{{ o.id }} - {{ o.items }} items - {{ o.created_at }}
                    </h1>
                </router-link>
            </template>
        </div>
        <div class="bg-white py-6 px-5 text-center shadow rounded-lg flex flex-col items-center justify-center">
        <DoughnutChart :width="140" :height="200" :data="orderByCountry" v-if="orderByCountry.datasets && orderByCountry.datasets[0].data.length > 0"/>
    </div>
    <div class="bg-white py-6 px-5 rounded-lg shadow">
        <label class="text-lg font-semibold block mb-2">Latest Customers</label>
          <template v-if="!loading.latestCustomers">
       <router-link :to="{name: 'app.customers.view', params: {id: c.id}}" v-for="c of latestCustomers" :key="c.id"
                     class="mb-3 flex">
          <div class="w-12 h-12 bg-gray-200 flex items-center justify-center rounded-full mr-2">
            <UserIcon class="w-5"/>
          </div>
          <div>
            <h3>{{ c.first_name }} {{ c.last_name }}</h3>
            <p>{{ c.email }}</p>
          </div>
        </router-link>
      </template>
      <Spinner v-else text="" class=""/>
        </div>
    </div>
</template>
<script setup>
import axiosClient from '@/axios';
import DoughnutChart from '@/components/Charts/DoughnutChart.vue';
// import Doughnut from '@/components/Charts/Bar.vue';

import Spinner from '@/components/core/Spinner.vue';
import { data } from 'autoprefixer';
import { ref } from 'vue';


const loading = ref({
    cousomersCount: true,
    productsCount: true,
    paidOrdersCount: true,
    totalIncome: true,
    latestCustomers: true,
    latestOrders: true,

});

const cousomersCount = ref();
const productsCount = ref();
const paidOrdersCount = ref();
const totalIncome = ref();
const latestCustomers = ref([]);
const latestOrders = ref([]);
const orderByCountry = ref({
    labels : [],
     datasets : [{
        //  backgroundColor: [],
         backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16', '#FFC312'],
        data: [],
    }]
});

// function getRandomColor() {
//     const letters = '0123456789ABCDEF';
//     let color = '#';
//     for (let i = 0; i < 6; i++) {
//         color += letters[Math.floor(Math.random() * 16)];
//     }
//     return color;
// }

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

axiosClient.get('/dashboard/orders-by-country').
then(({data: countries}) => {
    if (countries && countries.length > 0) {
    countries.forEach(c => {
        orderByCountry.value.labels.push(c.name),
        orderByCountry.value.datasets[0].data.push( c.count)
        // orderByCountry.value.datasets[0].backgroundColor.push(getRandomColor())
    });
    // orderByCountry.value = orderByCountry
}
     loading.value.orderByCountry = false;
});


axiosClient.get('/dashboard/latest-customers')
.then(({data}) => {
    latestCustomers.value = data;
    loading.value.latestCustomers = false;
});
axiosClient.get('/dashboard/latest-orders')
.then(({data}) => {
    latestOrders.value = data;
    loading.value.latestOrders = false;
});


</script>
