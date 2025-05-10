<template>
  <div class="bg-gray-900 min-h-screen">
    <div class="container mx-auto py-8">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-white">Customer List</h1>
        <router-link
          to="/customers/create"
          class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-lg transition duration-300 ease-in-out flex items-center shadow-lg"
        >
          <i class="fas fa-user-plus mr-2"></i> Create Customer
        </router-link>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <div
          v-for="customer in customers"
          :key="customer.id"
          class="bg-gray-800 rounded-lg overflow-hidden flex flex-col shadow-lg"
        >
          <div class="relative flex-grow">
            <div class="absolute top-0 left-0 p-2 bg-purple-600 text-white rounded-br-lg">
              <i class="fas fa-user mr-1"></i> Customer
            </div>
          </div>
          <div class="p-6 flex-grow">
            <h2 class="text-2xl font-semibold mt-4 mb-2 text-white">{{ customer.name }}</h2>
            <p class="text-gray-400 mb-4">
              <i class="fas fa-envelope mr-2 text-purple-400"></i> {{ customer.email }}
            </p>
            <p class="text-gray-400 mb-6">
              <i class="fas fa-phone mr-2 text-purple-400"></i> {{ customer.phone_number }}
            </p>
            <div class="flex justify-between items-center">
              <router-link
                :to="'/customers/' + customer.id"
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
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const customers = ref([]);
const router = useRouter();
const authStore = useAuthStore();

const getCustomers = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/customers', {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    customers.value = response.data.data;
  } catch (error) {
    console.error(error);
  }
};

onMounted(getCustomers);
</script>

<style>
/* Tidak ada perubahan pada bagian style */
</style>