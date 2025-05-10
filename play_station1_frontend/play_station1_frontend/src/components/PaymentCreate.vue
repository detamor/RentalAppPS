<template>
  <div class="bg-gray-900 min-h-screen">
    <div class="container mx-auto py-8">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-white">Create Payment</h1>
      </div>
      <form @submit.prevent="createPayment" class="bg-gray-800 rounded-lg p-8 shadow-lg">
        <div class="mb-6">
          <label for="order" class="block mb-2 font-semibold text-white">Order</label>
          <select
            v-model="form.order_id"
            id="order"
            class="w-full bg-gray-700 text-white rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-purple-600"
            @change="selectOrder"
          >
            <option value="">Select an order</option>
            <option v-for="order in orders" :key="order.id" :value="order.id">
              {{ order.game.name_games }} ({{ formatDate(order.rental_date) }})
            </option>
          </select>
        </div>
        <div class="mb-6" v-if="selectedOrder">
          <label class="block mb-2 font-semibold text-white">Total Price</label>
          <p class="text-2xl font-semibold text-purple-400">{{ selectedOrder.total_price }}</p>
        </div>
        <div class="mb-6" v-if="selectedOrder">
          <label class="block mb-2 font-semibold text-white">Customer</label>
          <p class="text-gray-400">{{ selectedOrder.customer.name }}</p>
        </div>
        <div class="mb-6">
          <label for="payment_method" class="block mb-2 font-semibold text-white"
            >Payment Method</label
          >
          <select
            v-model="form.payment_method"
            id="payment_method"
            class="w-full bg-gray-700 text-white rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-purple-600"
            required
          >
            <option value="">Select a payment method</option>
            <option value="cash">Cash</option>
            <option value="credit_card">Credit Card</option>
            <option value="bank_transfer">Bank Transfer</option>
            <option value="e_wallet">E-Wallet</option>
          </select>
        </div>
        <div class="flex justify-end">
          <button
            type="button"
            class="bg-gray-700 text-white rounded-lg py-3 px-6 mr-4 hover:bg-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-600"
            @click="cancel"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg py-3 px-6 hover:from-purple-700 hover:to-pink-700 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-600"
          >
            Create Payment
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";

const authStore = useAuthStore();
const router = useRouter();
const orders = ref([]);
const selectedOrder = ref(null);
const form = ref({
  order_id: "",
  payment_method: "",
});

onMounted(async () => {
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
});

const selectOrder = () => {
  const order = orders.value.find((order) => order.id === form.value.order_id);
  selectedOrder.value = order;
};

const createPayment = async () => {
  try {
    const currentDate = new Date().toISOString().slice(0, 10); // Format: 'yyyy-mm-dd'
    const formData = {
      order_id: form.value.order_id,
      date: currentDate,
      method: form.value.payment_method,
    };

    const response = await axios.post(
      "http://localhost:8000/api/payments",
      formData,
      {
        headers: {
          Authorization: `Bearer ${authStore.accessToken}`,
        },
      }
    );
    console.log(response.data);
    router.push("/payments");
  } catch (error) {
    console.error(error);
  }
};

const cancel = () => {
  router.push("/payments");
};

const formatDate = (date) => {
  if (!date) return "";
  return new Date(date).toLocaleDateString();
};
</script>