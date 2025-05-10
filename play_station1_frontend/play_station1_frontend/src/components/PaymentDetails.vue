<template>
  <div class="bg-gray-900 min-h-screen">
    <div class="container mx-auto py-8">
      <div class="flex justify-between items-center mb-8">
        <button
          class="bg-gray-700 text-white rounded-lg py-2 px-4 hover:bg-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-600"
          @click="goBack"
        >
          &larr; Back
        </button>
      </div>
      <div v-if="payment" class="bg-gray-800 rounded-lg p-8 shadow-lg">
        <h1 class="text-4xl font-bold text-white mb-6">Payment Details</h1>
        <div class="mb-6">
          <label class="block text-gray-400 font-bold mb-2">Order:</label>
          <p class="text-white font-semibold">Order #{{ payment.order.id }}</p>
        </div>
        <div class="mb-6">
          <label class="block text-gray-400 font-bold mb-2">Customer:</label>
          <p class="text-white font-semibold">{{ payment.order.customer ? payment.order.customer.name : 'N/A' }}</p>
        </div>
        <div class="mb-6">
          <label class="block text-gray-400 font-bold mb-2">Total Price:</label>
          <p class="text-white font-semibold">{{ payment.order.total_price }}</p>
        </div>
        <div class="mb-6">
          <label class="block text-gray-400 font-bold mb-2">Payment Method:</label>
          <p class="text-white font-semibold">{{ payment.method }}</p>
        </div>
        <div class="mb-6">
          <label class="block text-gray-400 font-bold mb-2">Payment Date:</label>
          <p class="text-white font-semibold">{{ formatDate(payment.date) }}</p>
        </div>
        <div class="flex items-center justify-between">
          <router-link
            :to="`/payments/${payment.id}/edit`"
            class="bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-3 px-6 rounded-lg hover:from-purple-700 hover:to-pink-700 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-600"
            >Edit</router-link
          >
          <button
            type="button"
            @click="deletePayment"
            class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline"
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
import { ref, onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useRouter, useRoute } from "vue-router";

const authStore = useAuthStore();
const router = useRouter();
const route = useRoute();
const payment = ref(null);

onMounted(async () => {
  const response = await axios.get(`http://localhost:8000/api/payments/${route.params.id}`, {
    headers: {
      Authorization: `Bearer ${authStore.accessToken}`,
    },
  });
  payment.value = response.data.data;
});

const formatDate = (date) => {
  if (!date) return "";
  return new Date(date).toLocaleDateString();
};

const deletePayment = async () => {
  if (confirm("Are you sure you want to delete this payment?")) {
    try {
      await axios.delete(`http://localhost:8000/api/payments/${route.params.id}`, {
        headers: {
          Authorization: `Bearer ${authStore.accessToken}`,
        },
      });
      router.push({ name: "paymentlist" });
    } catch (error) {
      console.log(error);
    }
  }
};

const goBack = () => {
  router.go(-1);
};
</script>