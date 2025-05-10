<template>
    <div class="bg-gray-900 min-h-screen">
      <div class="container mx-auto py-8">
        <button
          class="bg-gray-800 hover:bg-gray-700 text-white rounded-md py-2 px-4 mb-6 flex items-center"
          @click="goBack"
        >
          <i class="fas fa-arrow-left mr-2"></i> Back
        </button>
        <h1 class="text-4xl font-bold text-white mb-4">Admin Details</h1>
        <div class="bg-gray-800 rounded-lg p-6 shadow-lg" v-if="user">
          <h3 class="text-2xl font-semibold text-white mb-2">{{ user.name }}</h3>
          <p class="text-gray-400 text-sm mb-4">{{ user.email }}</p>
          <div class="flex justify-between items-center">
            <router-link
              :to="`/users/${user.id}/edit`"
              class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-md py-2 px-4 transition-colors flex items-center"
            >
              <i class="fas fa-edit mr-2"></i> Edit
            </router-link>
            <button
              @click="deleteUser"
              class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-md py-2 px-4 transition-colors flex items-center"
            >
              <i class="fas fa-trash-alt mr-2"></i> Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import axios from 'axios';
  import { ref, onMounted } from 'vue';
  import { useRouter, useRoute } from 'vue-router';
  import { useAuthStore } from '@/stores/auth';
  
  const authStore = useAuthStore();
  const router = useRouter();
  const route = useRoute();
  const user = ref(null);
  
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
  
  const deleteUser = async () => {
    if (confirm('Are you sure you want to delete this Admin?')) {
      try {
        await axios.delete(`http://localhost:8000/api/users/${user.value.id}`, {
          headers: {
            Authorization: `Bearer ${authStore.accessToken}`,
          },
        });
        router.push('/users');
      } catch (error) {
        console.error(error);
      }
    }
  };
  </script>
  
  <style>
  /* No additional styles needed */
  </style>