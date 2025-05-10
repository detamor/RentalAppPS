<template>
  <div class="bg-gray-900 min-h-screen">
    <div class="container mx-auto py-8">
      <div class="bg-gray-800 rounded-lg p-8 shadow-lg">
        <h1 class="text-4xl font-bold text-white mb-6">Create Order</h1>
        <form @submit.prevent="createOrder">
          <div class="mb-6">
            <label for="customer_id" class="block text-gray-400 font-bold mb-2">Customer:</label>
            <select
              id="customer_id"
              v-model="form.customer_id"
              class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-600"
              required
            >
              <option
                v-for="customer in customers"
                :key="customer.id"
                :value="customer.id"
              >
                {{ customer.name }}
              </option>
            </select>
          </div>
          <div class="mb-6">
            <label for="rental_date" class="block text-gray-400 font-bold mb-2">Rental Date:</label>
            <input
              type="date"
              id="rental_date"
              v-model="form.rental_date"
              class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-600"
              required
            />
          </div>
          <div class="mb-6">
            <label for="game_id" class="block text-gray-400 font-bold mb-2">Game:</label>
            <select
              id="game_id"
              v-model="form.game_id"
              class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-600"
              required
              @change="updateTotalPrice"
            >
              <option value="" disabled selected>Select a game</option>
              <option v-for="game in games" :key="game.id" :value="game.id">
                {{ game.name_games }} - Rp {{ game.price }}
              </option>
            </select>
          </div>
          <div class="mb-6">
            <label for="quantity" class="block text-gray-400 font-bold mb-2">Duration/1Jam:</label>
            <input
              type="number"
              id="quantity"
              v-model="form.quantity"
              class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-600"
              required
              @change="updateTotalPrice"
            />
          </div>
          <div class="mb-6">
            <label for="total_price" class="block text-gray-400 font-bold mb-2">Total Price:</label>
            <input
              type="number"
              id="total_price"
              v-model="form.total_price"
              class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-600"
              required
              disabled
            />
          </div>
          <div class="mb-6">
            <label for="status" class="block text-gray-400 font-bold mb-2">Status:</label>
            <select
              id="status"
              v-model="form.status"
              class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-600"
              required
            >
              <option value="pending">Pending</option>
              <option value="processing">Processing</option>
              <option value="completed">Completed</option>
              <option value="canceled">Canceled</option>
            </select>
          </div>
          <div class="flex items-center justify-between">
            <button
              type="submit"
              class="bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-3 px-6 rounded-lg hover:from-purple-700 hover:to-pink-700 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-600"
            >
              Create
            </button>
            <router-link
              to="/orders"
              class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-purple-600"
              >Cancel</router-link
            >
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const router = useRouter();
const authStore = useAuthStore();
const form = ref({
  customer_id: null,
  game_id: null,
  quantity: null,
  total_price: null,
  status: 'pending',
  rental_date: null,
});
const customers = ref([]);
const games = ref([]);

// Fungsi untuk mendapatkan data pelanggan dan permainan
const fetchData = async () => {
  try {
    const [customersResponse, gamesResponse] = await Promise.all([
      axios.get("http://localhost:8000/api/customers", {
        headers: {
          Authorization: `Bearer ${authStore.accessToken}`,
        },
      }),
      axios.get("http://localhost:8000/api/games", {
        headers: {
          Authorization: `Bearer ${authStore.accessToken}`,
        },
      }),
    ]);
    customers.value = customersResponse.data.data;
    games.value = gamesResponse.data.data;
  } catch (error) {
    console.log(error);
  }
};

// Panggil fungsi fetchData saat komponen dimuat
fetchData();

const updateTotalPrice = () => {
  const game = games.value.find(
    (game) => game.id === Number(form.value.game_id)
  );
  form.value.total_price = game.price * form.value.quantity;
};

const createOrder = async () => {
  try {
    const response = await axios.post(
      "http://localhost:8000/api/orders",
      form.value,
      {
        headers: {
          Authorization: `Bearer ${authStore.accessToken}`,
        },
      }
    );
    router.push({ name: "orderlist", params: { id: response.data.data.id } });
  } catch (error) {
    console.log(error);
  }
};
</script>