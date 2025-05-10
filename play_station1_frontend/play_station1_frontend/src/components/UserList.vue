<template>
  <div class="p-4">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-3xl font-bold flex-1">Admin List</h1>
      <router-link
        to="/users/create"
        class="bg-green-500 hover:bg-green-600 text-white rounded-md py-2 px-4 transition-colors"
        >Create a new admin</router-link
      >
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <div v-for="user in users" :key="user.id" class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4">
          <h3 class="text-xl font-bold mb-2">{{ user.name }}</h3>
          <p class="text-gray-700">{{ user.email }}</p>
          <router-link
            :to="'/users/' + user.id"
            class="block mt-4 bg-blue-500 hover:bg-blue-600 text-white rounded-md py-2 px-4 transition-colors"
            >Details</router-link
          >
        </div>
      </div>
    </div>

    <div class="mb-4">
      <label for="pageSelector" class="block text-lg font-semibold mb-2">Navigate to:</label>
      <div class="flex items-center">
        <select v-model="selectedPage" id="pageSelector" class="border rounded-md p-2 mr-2">
          <option value="" disabled selected>Select a page</option>
          <option value="/games">Games</option>
          <option value="/games/create">Create Game</option>
          <option value="/customers">Customer</option>
          <option value="/orders">Order</option>
          <option value="/payments">Payments</option>
        </select>
        <button
          @click="fetchData"
          class="bg-blue-500 text-white rounded-md py-2 px-4 hover:bg-blue-600 transition-colors"
        >
          Go
        </button>
      </div>
    </div>

    <GameCreate v-if="selectedPage === '/games/create'" />

    <div v-else-if="fetchedData.length > 0" class="mt-4">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">{{ selectedPageLabel }} List</h2>
        <button
          @click="goBack"
          class="bg-gray-300 hover:bg-gray-400 transition-colors rounded-md py-2 px-4"
        >
          &larr; Back
        </button>
        <router-link
          to="/create"
          class="bg-gradient-to-r from-purple-600 to-purple-800 hover:bg-purple-700 text-white px-4 py-2 md:px-6 md:py-3 rounded-md transition duration-300 ease-in-out flex items-center"
        >
          Create a new game
        </router-link>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <div
          v-for="item in fetchedData"
          :key="item.id"
          class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col"
        >
          <div class="relative flex-grow">
            <img :src="item.image" :alt="item.name_games" class="w-full h-48 md:h-64 object-cover" />
            <div class="absolute top-0 left-0 p-2 bg-green-500 text-white rounded-br-lg">
              <i class="fas fa-tag mr-1"></i> Rp {{ item.price }}/Jam
            </div>
          </div>
          <div class="p-4 md:p-8 flex-grow">
            <h2 class="text-xl md:text-2xl font-semibold mb-2">{{ item.name_games }}</h2>
            <p class="text-gray-500 mb-4">
              <i class="fas fa-tag mr-1"></i> Genre: {{ item.genre_games }}
            </p>
            <div class="flex justify-between items-center">
              <router-link
                :to="`/game/${item.id}/edit`"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 md:px-6 md:py-3 rounded-md transition duration-300 ease-in-out flex items-center mr-4"
              >
                <i class="fas fa-edit mr-2"></i> Edit
              </router-link>
              <button
                @click="deleteItem(item.id)"
                class="bg-red-500 text-white rounded-md py-2 px-4 hover:bg-red-600 transition-colors"
              >
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";
import GameCreate from "@/components/GameCreate.vue";

const authStore = useAuthStore();
const router = useRouter();
const users = ref([]);
const selectedPage = ref("");
const fetchedData = ref([]);
const selectedPageLabel = ref("");

const fetchData = async () => {
  try {
    let endpoint;
    let label;

    switch (selectedPage.value) {
      case "/games":
        endpoint = "http://localhost:8000/api/games";
        label = "Game";
        break;
      case "/customers":
        endpoint = "http://localhost:8000/api/customers";
        label = "Customer";
        break;
      case "/orders":
        endpoint = "http://localhost:8000/api/orders";
        label = "Order";
        break;
      case "/payments":
        endpoint = "http://localhost:8000/api/payments";
        label = "Payment";
        break;
      default:
        break;
    }

    if (endpoint) {
      const response = await axios.get(endpoint, {
        headers: {
          Authorization: `Bearer ${authStore.accessToken}`,
        },
      });
      fetchedData.value = response.data.data;
      selectedPageLabel.value = label;
    }
  } catch (error) {
    console.error(error);
  }
};

const deleteItem = async (itemId) => {
  try {
    const confirmDelete = confirm("Are you sure you want to delete this item?");
    if (confirmDelete) {
      let endpoint;
      switch (selectedPage.value) {
        case "/games":
          endpoint = `http://localhost:8000/api/games/${itemId}`;
          break;
        case "/customers":
          endpoint = `http://localhost:8000/api/customers/${itemId}`;
          break;
        case "/orders":
          endpoint = `http://localhost:8000/api/orders/${itemId}`;
          break;
        case "/payments":
          endpoint = `http://localhost:8000/api/payments/${itemId}`;
          break;
        default:
          break;
      }

      if (endpoint) {
        await axios.delete(endpoint, {
          headers: {
            Authorization: `Bearer ${authStore.accessToken}`,
          },
        });
        fetchData();
      }
    }
  } catch (error) {
    console.error(error);
  }
};

const goBack = () => {
  fetchedData.value = [];
};

const getUsers = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/users", {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    users.value = response.data.data;
  } catch (error) {
    console.error(error);
  }};
onMounted(getUsers);
</script>