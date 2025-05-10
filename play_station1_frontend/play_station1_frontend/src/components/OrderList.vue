<template>
  <div class="bg-gray-900 p-4">
    <header class="flex items-center justify-between mb-6">
      <h1 class="text-3xl font-bold text-white">Order List</h1>
      <router-link
        to="/orders/create"
        class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-md py-2 px-4 inline-block transition-colors focus:outline-none focus:ring-2 focus:ring-purple-300 focus:ring-opacity-50"
      >
        Create a new order
      </router-link>
    </header>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <div
        v-for="order in orders"
        :key="order.id"
        class="bg-white rounded-lg p-4 shadow-md"
      >
        <h3 class="text-xl font-bold mb-2 text-gray-800">{{ order.game.name_games }}</h3>
        <div class="text-sm mb-2">
          <p class="text-gray-500 mb-1 flex items-center">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-6 h-6 mr-1.5 text-purple-400"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
            Duration: {{ order.quantity }} hours
          </p>
          <p class="text-gray-500 mb-1 flex items-center">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-6 h-6 mr-1.5 text-purple-400"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12"
              />
            </svg>
            Status: {{ order.status }}
          </p>
          <p class="text-gray-500 flex items-center">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-6 h-6 mr-1.5 text-purple-400"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
            Ordered by: {{ order.customer.name }}
          </p>
          <p class="text-gray-500 mb-1 flex items-center">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-6 h-6 mr-1.5 text-purple-400"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6.75 3v2.25M6.75 19.25v-2.25M3.75 6.75h15M3.75 17.25h15M12 12.75a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
            Rental Date: {{ formatDate(order.rental_date) }}
          </p>
        </div>
        <p class="text-gray-800 font-semibold text-lg">
          Total price: {{ order.total_price }}
        </p>
        <router-link
          :to="`/orders/${order.id}`"
          class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-md py-2 px-4 mt-4 inline-block transition-colors focus:outline-none focus:ring-2 focus:ring-purple-300 focus:ring-opacity-50"
        >
          View Details
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref } from "vue";
import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();
const orders = ref([]);

// Fungsi untuk mendapatkan daftar pesanan
const fetchOrders = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/orders", {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    orders.value = response.data.data;
  } catch (error) {
    console.error(error);
  }
};

// Panggil fungsi fetchOrders saat komponen dimuat
fetchOrders();

// Fungsi untuk memformat tanggal
const formatDate = (date) => {
  if (!date) return '';
  return new Date(date).toLocaleDateString();
};
</script>