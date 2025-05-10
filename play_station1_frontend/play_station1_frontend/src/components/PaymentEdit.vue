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
      <div class="bg-gray-800 rounded-lg p-8 shadow-lg">
        <h1 class="text-4xl font-bold text-white mb-6">Edit Payment</h1>
        <form @submit.prevent="updatePayment" v-if="payment">
          <div class="mb-6">
            <label class="block text-gray-400 font-bold mb-2" for="date">Date:</label>
            <input
              v-model="form.date"
              type="date"
              id="date"
              name="date"
              class="block appearance-none w-full bg-gray-700 border border-gray-600 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline text-white"
            />
            <p v-if="formErrors.date" class="text-red-500 text-sm mt-1">
              {{ formErrors.date[0] }}
            </p>
          </div>
          <div class="mb-6">
            <label class="block text-gray-400 font-bold mb-2" for="method">Payment Method:</label>
            <input
              v-model="form.method"
              type="text"
              id="method"
              name="method"
              class="block appearance-none w-full bg-gray-700 border border-gray-600 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline text-white"
            />
            <p v-if="formErrors.method" class="text-red-500 text-sm mt-1">
              {{ formErrors.method[0] }}
            </p>
          </div>
          <div class="flex items-center justify-between">
            <button
              type="submit"
              class="bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-3 px-6 rounded-lg hover:from-purple-700 hover:to-pink-700 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-600"
            >
              Save Changes
            </button>
            <router-link
              :to="{ name: 'paymentdetail', params: { id: payment.id } }"
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
import { ref, onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useRouter, useRoute } from "vue-router";

const authStore = useAuthStore();
const router = useRouter();
const route = useRoute();
const payment = ref(null);
const form = ref({
  date: null,
  method: null,
});
const formErrors = ref({});

onMounted(async () => {
  const response = await axios.get(`http://localhost:8000/api/payments/${route.params.id}`, {
    headers: {
      Authorization: `Bearer ${authStore.accessToken}`,
    },
  });
  payment.value = response.data.data;
  form.value.date = response.data.data.date;
  form.value.method = response.data.data.method;
});

const updatePayment = async () => {
  try {
    const response = await axios.put(
      `http://localhost:8000/api/payments/${payment.value.id}`,
      form.value,
      {
        headers: {
          Authorization: `Bearer ${authStore.accessToken}`,
        },
      }
    );
    router.push({ name: "paymentlist", params: { id: response.data.data.id } });
  } catch (error) {
    if (error.response && error.response.status === 422) {
      formErrors.value = error.response.data.errors;
    } else {
      console.log(error);
    }
  }
};

const goBack = () => {
  router.go(-1);
};
</script>