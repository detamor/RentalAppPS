<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 to-black">
    <div class="max-w-md w-full p-8 bg-white rounded-xl shadow-2xl">
      <div class="flex items-center justify-center mb-8">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="currentColor"
          class="w-12 h-12 text-gold"
        >
          <path
            fill-rule="evenodd"
            d="M9.493 2.853a.75.75 0 00-.785-.175L4.257 4.236l-.464-.884a.75.75 0 00-1.285.276L2.74 8.49 1.108 9.237a.75.75 0 00-.467 1.024l.403.703-1.175 2.546A1 1 0 001 14.601v.257c0 .411.27.768.658.904a48.138 48.138 0 014.83 2.128c.376.15.81.15 1.186 0a48.138 48.138 0 014.83-2.128c.388-.136.658-.493.658-.904v-.257a1 1 0 00-1.03-1.09l-1.175-2.546.403-.703a.75.75 0 00-.467-1.024l-1.632-.747 1.15-5.155a.75.75 0 00-.785-.775zM9 9.953L6.94 13.5l1.44 3.122A47.955 47.955 0 0111.88 15.5l-2.88-5.547zm5.594 2.268a48.138 48.138 0 00-4.83-2.128.75.75 0 00-.224-.03V14h4.793l-.739-2.779zm-.88-2.268L11.62 15.5l3.498 1.122A47.953 47.953 0 0118 16.673v-4.147a2.25 2.25 0 00-.144-.672l-4.142-1.903z"
            clip-rule="evenodd"
          />
        </svg>
        <h2 class="text-3xl font-bold text-gold ml-4">PlayStation Rent</h2>
      </div>
      <div v-if="errorMessage" class="mb-6">
        <p class="bg-red-100 text-red-700 rounded-lg p-4">{{ errorMessage }}</p>
      </div>
      <form class="space-y-6" @submit.prevent="onSubmit">
        <div>
          <label for="email-address" class="block text-sm font-medium text-gray-700">Email address</label>
          <div class="mt-1">
            <input
              id="email-address"
              name="email"
              type="email"
              v-model="email"
              required
              class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-gold focus:border-gold sm:text-sm"
              placeholder="Email"
            />
          </div>
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <div class="mt-1">
            <input
              id="password"
              name="password"
              type="password"
              v-model="password"
              required
              class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-gold focus:border-gold sm:text-sm"
              placeholder="Password"
            />
          </div>
        </div>
        <div>
          <button
            type="submit"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gold hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold"
          >
            Login
          </button>
        </div>
        <div class="flex justify-center text-gray-700">
          Belum memiliki akun? <a href="/register" class="text-indigo-600 hover:text-indigo-800 ml-1">Silahkan daftar disini!</a>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();
const email = ref("");
const password = ref("");
const errorMessage = ref(null);

async function onSubmit() {
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    const response = await axios.post("http://localhost:8000/api/login", {
      email: email.value,
      password: password.value,
    });
    authStore.setAccessToken(response.data.access_token);
    console.log("Login successful");
    router.push({ name: "home" });
  } catch (error) {
    if (
      error.response &&
      error.response.status === 422 &&
      error.response.data.errors &&
      error.response.data.errors.email
    ) {
      errorMessage.value = error.response.data.errors.email[0];
    } else {
      errorMessage.value = "An error occurred: " + error.message;
    }
    console.error(errorMessage.value);
  }
}
</script>

<style>
.text-gold {
  color: #ffd700;
}

.bg-gold {
  background-color: #ffd700;
}

.focus\:ring-gold:focus {
  --tw-ring-color: #ffd700;
}

.focus\:border-gold:focus {
  --tw-border-color: #ffd700;
}

.hover\:bg-yellow-600:hover {
  --tw-bg-opacity: 1;
  background-color: rgb(202 138 4 / var(--tw-bg-opacity));
}

.hover\:text-indigo-800:hover {
  --tw-text-opacity: 1;
  color: rgb(55 48 163 / var(--tw-text-opacity));
}
</style>