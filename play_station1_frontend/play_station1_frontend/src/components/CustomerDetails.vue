<template>
  <div class="bg-gray-800 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-xl rounded-lg w-full max-w-4xl px-8 pt-6 pb-8 mb-4">
      <div class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">Customer Details</h1>
      </div>

      <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="relative flex-grow">
          <div
            class="absolute top-0 left-0 p-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-br-lg"
          >
            <i class="fas fa-user mr-1"></i> Customer
          </div>
        </div>
        <div class="p-4 md:p-8 flex-grow relative">
          <h2 class="text-xl md:text-2xl font-semibold mt-3 mb-2 text-gray-800">{{ customer.name }}</h2>
          <p class="text-gray-500 mb-4">
            <i class="fas fa-envelope mr-1 text-purple-400"></i> {{ customer.email }}
          </p>
          <p class="text-gray-500 mb-4">
            <i class="fas fa-phone mr-1 text-purple-400"></i> {{ customer.phone_number }}
          </p>
          <div class="absolute bottom-4 right-4 flex space-x-2">
            <router-link
              :to="`/customers/${customer.id}/edit`"
              class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center"
            >
              <i class="fas fa-edit mr-2"></i> Edit Customer
            </router-link>
          </div>
        </div>
      </div>

      <div class="mt-8 flex justify-between">
        <router-link
          to="/customers"
          class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center"
        >
          <i class="fas fa-arrow-left mr-2"></i> Back
        </router-link>
        <button
          @click="deleteCustomer"
          class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center"
        >
          <i class="fas fa-trash mr-2"></i> Delete
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const customer = ref({});
const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();

const getCustomer = async () => {
  try {
    const response = await axios.get(`http://localhost:8000/api/customers/${route.params.id}`, {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    customer.value = response.data.data;
  } catch (error) {
    console.error(error);
  }
};

const deleteCustomer = async () => {
  try {
    await axios.delete(`http://localhost:8000/api/customers/${route.params.id}`, {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    router.push('/customers');
  } catch (error) {
    console.error(error);
  }
};

onMounted(getCustomer);
</script>