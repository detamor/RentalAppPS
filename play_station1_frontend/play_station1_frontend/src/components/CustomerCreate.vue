<template>
  <div class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-xl rounded-lg w-full max-w-md px-8 pt-6 pb-8 mb-4">
      <div class="mb-8">
        <router-link
          to="/customers"
          class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-medium py-2 px-4 rounded-md transition-colors"
        >
          &larr; Back
        </router-link>
      </div>
      <h1 class="text-3xl font-bold mb-4 text-gray-800">Create Customer</h1>
      <form @submit.prevent="createCustomer" class="space-y-4">
        <div>
          <label for="name" class="block font-medium text-gray-700 mb-2">Name:</label>
          <input
            id="name"
            v-model="name"
            type="text"
            class="border rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
            required
          />
        </div>
        <div>
          <label for="email" class="block font-medium text-gray-700 mb-2">Email:</label>
          <input
            id="email"
            v-model="email"
            type="email"
            class="border rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
            required
          />
        </div>
        <div>
          <label for="phone" class="block font-medium text-gray-700 mb-2">Phone Number:</label>
          <input
            id="phone"
            v-model="phoneNumber"
            type="text"
            class="border rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
            required
          />
        </div>
        <button
          type="submit"
          class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-2 px-4 rounded transition-colors"
        >
          Create
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const name = ref('');
const email = ref('');
const phoneNumber = ref('');

const createCustomer = async () => {
  try {
    const response = await axios.post(
      'http://localhost:8000/api/customers',
      {
        name: name.value,
        email: email.value,
        phone_number: phoneNumber.value,
      },
      {
        headers: {
          Authorization: `Bearer ${authStore.accessToken}`,
        },
      }
    );
    console.log(response.data);
    // Reset form
    name.value = '';
    email.value = '';
    phoneNumber.value = '';
    // Navigate to customer list
    router.push('/customers');
  } catch (error) {
    console.error(error);
    // Handle error
    if (error.response && error.response.status === 422) {
      // Validation error
      const errors = error.response.data.errors;
      let errorMessage = error.response.data.message + '\n';
      for (const field in errors) {
        errorMessage += `${field}: ${errors[field].join(', ')}\n`;
      }
      alert(errorMessage);
    } else {
      alert('Error creating customer. Please try again.');
    }
  }
};
</script>