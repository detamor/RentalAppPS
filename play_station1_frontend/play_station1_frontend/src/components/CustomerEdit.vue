<template>
  <div class="bg-gray-800 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-xl rounded-lg w-full max-w-4xl px-8 pt-6 pb-8 mb-4">
      <div class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">Edit Customer</h1>
        <div class="flex items-center">
          <button
            @click="cancelEdit"
            class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center"
          >
            <i class="fas fa-times mr-2"></i> Cancel
          </button>
        </div>
      </div>

      <form @submit.prevent="updateCustomer">
        <div class="mb-4">
          <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
          <input
            id="name"
            v-model="customer.name"
            type="text"
            class="border rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            required
          />
        </div>

        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
          <input
            id="email"
            v-model="customer.email"
            type="email"
            class="border rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            required
          />
        </div>

        <div class="mb-4">
          <label for="phone_number" class="block text-gray-700 font-medium mb-2">Phone Number</label>
          <input
            id="phone_number"
            v-model="customer.phone_number"
            type="text"
            class="border rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            required
          />
        </div>

        <div class="flex justify-end">
          <button
            type="submit"
            class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center mr-2"
          >
            <i class="fas fa-save mr-2"></i> Save
          </button>
        </div>
      </form>
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

const updateCustomer = async () => {
  try {
    await axios.put(`http://localhost:8000/api/customers/${route.params.id}`, customer.value, {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    router.push('/customers');
  } catch (error) {
    console.error(error);
  }
};

const cancelEdit = () => {
  router.go(-1);
};

onMounted(getCustomer);
</script>