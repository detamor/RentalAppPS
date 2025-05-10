<template>
  <div class="bg-gray-900 min-h-screen">
    <div class="container mx-auto py-8">
      <!-- Render a section containing order details if there is an order object -->
      <div class="bg-gray-800 rounded-lg p-8 shadow-lg" v-if="order">
        <!-- Button to navigate back to previous page -->
        <button
          class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg mb-6 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-600"
          @click="goBack"
        >
          &larr; Back
        </button>
        <!-- Title displaying the user's name and the order details -->
        <h1 class="text-4xl font-bold text-white mb-6">
          {{ order.customer.name }}'s Order Details
        </h1>
        <!-- Render the product name for the order -->
        <div class="mb-6">
          <label class="block text-gray-400 font-bold mb-2">Game:</label>
          <p class="text-gray-200 font-semibold">{{ order.game.name_games }}</p>
        </div>
        <!-- Render the quantity for the order -->
        <div class="mb-6">
          <label class="block text-gray-400 font-bold mb-2">Duration:</label>
          <p class="text-gray-200 font-semibold">{{ order.quantity }} hours</p>
        </div>
        <!-- Render the total price for the order -->
        <div class="mb-6">
          <label class="block text-gray-400 font-bold mb-2">Total Price:</label>
          <p class="text-gray-200 font-semibold">
            Rp {{ toFixed(order.total_price) }}
          </p>
        </div>
        <div class="mb-6">
          <label class="block text-gray-400 font-bold mb-2">Rental Date:</label>
          <p class="text-gray-200 font-semibold">
            {{ formatDate(order.rental_date) }}
          </p>
        </div>
        <!-- Render the status of the order -->
        <div class="mb-6">
          <label class="block text-gray-400 font-bold mb-2">Status:</label>
          <p class="text-gray-200 font-semibold">{{ order.status }}</p>
        </div>
        <!-- Render edit and delete buttons for the order -->
        <div class="flex items-center justify-between">
          <router-link
            :to="{ name: 'orderedit', params: { id: order.id } }"
            class="bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-3 px-6 rounded-lg hover:from-purple-700 hover:to-pink-700 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-600"
            >Edit</router-link
          >
          <button
            type="button"
            @click="deleteOrder"
            class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-red-600"
          >
            Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, computed, onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useRouter, useRoute } from "vue-router";

// Initialize variables for authentication, routing and order data
const authStore = useAuthStore();
const router = useRouter();
const route = useRoute();
const order = ref(null);

// Fetch the order data when the component is mounted
onMounted(async () => {
  const response = await axios.get(
    `http://localhost:8000/api/orders/${route.params.id}`,
    {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    }
  );
  // Set the order data to the fetched data
  order.value = response.data.data;
});

// Define function to delete the current order
const deleteOrder = async () => {
  if (confirm("Are you sure you want to delete this order?")) {
    try {
      await axios.delete(`http://localhost:8000/api/orders/${route.params.id}`, {
        headers: {
          Authorization: `Bearer ${authStore.accessToken}`,
        },
      });
      // Redirect to the orders page after deleting the order
      router.push({ name: "orderlist" });
    } catch (error) {
      console.log(error);
    }
  }
};

const formatDate = (date) => {
  if (!date) return '';
  return new Date(date).toLocaleDateString();
};

// Define function to format the order total price to two decimal places
const toFixed = (value, precision = 2) => {
  if (isNaN(value)) {
    return "";
  }
  return parseFloat(value).toFixed(precision);
};

// Define function to navigate back to the previous page
const goBack = () => {
  router.go(-1);
};
</script>