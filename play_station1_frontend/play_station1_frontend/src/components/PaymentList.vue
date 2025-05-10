<template>
  <div class="bg-gray-900 min-h-screen">
    <div class="container mx-auto py-8">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-white">Payment List</h1>
        <router-link
          to="/payments/create"
          class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-lg transition duration-300 ease-in-out flex items-center shadow-lg"
        >
          <i class="fas fa-plus mr-2"></i> Create a new payment
        </router-link>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <div
          v-for="payment in payments"
          :key="payment.id"
          class="bg-gray-800 rounded-lg overflow-hidden flex flex-col shadow-lg"
        >
          <div class="relative flex-grow">
            <div class="absolute top-0 left-0 p-2 bg-purple-600 text-white rounded-br-lg">
              <i class="fas fa-money-bill-wave mr-1"></i> Payment
            </div>
          </div>
          <div class="p-6 flex-grow">
            <h2 class="text-2xl font-semibold mt-4 mb-2 text-white">Order #{{ payment.order.id }}</h2>
            <p class="text-gray-400 mb-4">
              <i class="fas fa-calendar-alt mr-2 text-purple-400"></i> {{ formatDate(payment.created_at) }}
            </p>
            <p class="text-gray-400 mb-4" v-if="payment.order.customer">
              <i class="fas fa-user mr-2 text-purple-400"></i> {{ payment.order.customer.name }}
            </p>
            <p class="text-gray-400 mb-6" v-if="payment.order.game">
              <i class="fas fa-gamepad mr-2 text-purple-400"></i> {{ payment.order.game.name_games }}
            </p>
            <p class="text-gray-400 mb-6 font-semibold">
              Total price: {{ payment.order.total_price }}
            </p>
            <div class="flex justify-between items-center">
              <router-link
                :to="`/payments/${payment.id}`"
                class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-lg transition duration-300 ease-in-out flex items-center shadow-lg"
              >
                <i class="fas fa-eye mr-2"></i> View Details
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();
const payments = ref([]);

onMounted(async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/payments?with=order.customer,order.game", {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    payments.value = response.data.data;
  } catch (error) {
    console.error(error);
    alert("Terjadi kesalahan saat mengambil data pembayaran.");
  }
});

const formatDate = (date) => {
  if (!date) return "";
  return new Date(date).toLocaleDateString();
};
</script>