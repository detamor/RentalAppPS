<template>
  <div class="bg-gray-900 min-h-screen">
    <div class="container mx-auto py-8">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-white">Edit Admin</h1>
        <button
          class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-lg transition duration-300 ease-in-out flex items-center shadow-lg"
          @click="goBack"
        >
          <i class="fas fa-arrow-left mr-2"></i> Back
        </button>
      </div>
      <div class="bg-gray-800 rounded-lg overflow-hidden flex flex-col shadow-lg p-6">
        <form v-if="user" @submit.prevent="updateUser" class="space-y-6">
          <div>
            <label class="text-lg font-semibold text-white" for="name">Name:</label>
            <input
              class="border rounded-md p-2 w-full mt-2"
              v-model="user.name"
              type="text"
              id="name"
              required
            />
          </div>
          <div>
            <label class="text-lg font-semibold text-white" for="email">Email:</label>
            <input
              class="border rounded-md p-2 w-full mt-2"
              v-model="user.email"
              type="email"
              id="email"
              required
            />
          </div>
          <div>
            <label class="text-lg font-semibold text-white" for="password">Password:</label>
            <input
              class="border rounded-md p-2 w-full mt-2"
              v-model="password"
              type="password"
              id="password"
            />
          </div>
          <button
            class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-lg transition duration-300 ease-in-out flex items-center shadow-lg"
            type="submit"
          >
            <i class="fas fa-save mr-2"></i> Save Changes
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();
const router = useRouter();
const route = useRoute();
const user = ref(null);
const password = ref("");

const goBack = () => {
  router.go(-1);
};

onMounted(async () => {
  try {
    const response = await axios.get(`http://localhost:8000/api/users/${route.params.id}`, {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    user.value = response.data.data;
  } catch (error) {
    console.error(error);
  }
});

const updateUser = async () => {
  try {
    const updatePayload = {
      name: user.value.name,
      email: user.value.email,
    };
    if (password.value) {
      updatePayload.password = password.value;
    }
    const response = await axios.put(`http://localhost:8000/api/users/${user.value.id}`, updatePayload, {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    router.push(`/users/${user.value.id}`);
  } catch (error) {
    console.error(error);
  }
};
</script>