<template>
  <!-- Navigation bar -->
  <nav
    v-if="authStore.isLoggedIn"
    class="bg-gray-900 py-4 px-8 flex items-center justify-between"
  >
    <!-- Logo -->
    <div class="text-white font-bold text-xl">
      <RouterLink to="/game">
        <span class="text-amber-400">Game</span>App
      </RouterLink>
    </div>

    <!-- Navigation links -->
    <div class="flex items-center space-x-6">
      <RouterLink
        to="/customers"
        class="text-white hover:text-amber-400 transition-colors"
        >Customer</RouterLink
      >
      <RouterLink
        to="/orders"
        class="text-white hover:text-amber-400 transition-colors"
        >Orders</RouterLink
      >
      <RouterLink
        to="/payments"
        class="text-white hover:text-amber-400 transition-colors"
        >Payments</RouterLink
      >
      <RouterLink
        to="/users"
        class="text-white hover:text-amber-400 transition-colors"
        >Admin</RouterLink
      >
    </div>

    <!-- User profile and logout button -->
    <div class="relative">
      <div
        class="flex items-center space-x-4 cursor-pointer"
        @click="showDropdown = !showDropdown"
      >
        <div class="relative">
          <img
            src="https://via.placeholder.com/40"
            alt="User Avatar"
            class="w-10 h-10 rounded-full object-cover"
          />
          <span
            class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 bg-red-600 rounded-full text-xs text-white"
            >13</span
          >
        </div>
        <span class="text-white">{{ username.value }}</span>
      </div>
      <div
        v-show="showDropdown"
        class="absolute right-0 mt-2 w-56 rounded-lg shadow-lg bg-gray-800 ring-1 ring-gray-700 ring-opacity-5"
        @click.outside="showDropdown = false"
      >
        <div
          class="py-1"
          role="menu"
          aria-orientation="vertical"
          aria-labelledby="options-menu"
        >
          <button
            @click="logout"
            class="block w-full px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white"
            role="menuitem"
          >
            <span class="flex items-center justify-between">
              <span>Logout</span>
              <svg
                class="ml-2 h-5 w-5 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                />
              </svg>
            </span>
          </button>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main content area -->
  <div class="p-4">
    <!-- Render the current route -->
    <RouterView />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from "@/stores/auth";
import { useRouter, useRoute } from "vue-router";

// Initialize objects
const authStore = useAuthStore();
const router = useRouter();
const showDropdown = ref(false);
const username = ref('');

// Define logout method
const logout = () => {
  authStore.logout(); // Clear authentication state
  router.push({ name: "login" }); // Redirect to login route
  showDropdown.value = false; // Hide dropdown
};
</script>

<style></style>