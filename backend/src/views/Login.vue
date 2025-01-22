<template>
  <guest-layout title="Sign in to your account">
    <form action=""  @submit.prevent="login">
    <div v-if="errorMsg" class="bg-red-400">
        {{errorMsg}}
    </div>
    <div>
      <label for="email" class="block text-sm/6 font-medium text-gray-900"
        >Email address</label
      >
      <div class="mt-2">
        <input
          type="email"
          name="email"
          v-model="user.email"
          id="email"
          autocomplete="email"
          required=""
          class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
        />
      </div>
    </div>

    <div>
      <div class="flex items-center justify-between">
        <label for="password" class="block text-sm/6 font-medium text-gray-900"
          >Password</label
        >
        <div class="text-sm">
          <a
            href="#"
            class="font-semibold text-indigo-600 hover:text-indigo-500"
            >Forgot password?</a
          >
        </div>
      </div>
      <div class="mt-2">
        <input
          type="password"
          name="password"
          v-model="user.password"
          id="password"
          autocomplete="current-password"
          required=""
          class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
        />
      </div>
    </div>
    <!-- Remmber me -->
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <input
          id="remember-me"
          name="remember-me"
          type="checkbox"
          v-model="user.remember"
          class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
        />
        <label for="remember-me" class="ml-2 block text-sm text-gray-900">
          Remember me
        </label>
      </div>

      <!-- <div class="text-sm">
        <router-link
          :to="{ name: 'requestPassword' }"
          class="font-medium text-indigo-600 hover:text-indigo-500"
        >
          Forgot your password?
        </router-link>
      </div> -->
    </div>
    <!--/ Remmber me -->
    <div>
        <!-- <p class="mt-10 text-center text-sm/6 text-gray-500">
          Not a member?
          <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Start a 14 day free trial</a>
        </p> -->
      <button
        type="submit"
        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
      >
        Sign in
      </button>
    </div>
</form>
  </guest-layout>
</template>
  <script setup>
import { ref } from "vue";
import GuestLayout from "../components/GuestLayout.vue";
// import { useRoute } from "vue-router";
import store from '@/store'
import router from "../router";

// const router = useRoute()
const loading = ref(false);
const errorMsg = ref("");
const user = {
    email: "",
  password: "",
  remember: false,
};

function login() {
    // debugger;
    loading.value = true;
    store.dispatch("login", user)
        .then(() => {
            loading.value = false;
            router.push({ name: "app.dashboard" });
        })
        .catch(({ response }) => {
            loading.value = false;
            errorMsg.value = response.data.message;
        });
}
</script>
