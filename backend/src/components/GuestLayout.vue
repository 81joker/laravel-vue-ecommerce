<template>
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
            {{ title }}
        </h2>
      </div>

      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

        <!-- <form class="space-y-6" action="#" method="POST"  @submit.prevent="emit('submit')"> -->
        <slot></slot>
        <!-- </form> -->

        <p class="mt-10 text-center text-sm/6 text-gray-500">
          Not a member?
          {{ ' ' }}
          <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Start a 14 day free trial</a>
        </p>
      </div>
    </div>
  </template>
  <script setup>
const {title} = defineProps({
    title: String
});

// const emit = defineEmits(['submit'])

  </script>
