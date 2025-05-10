<template>
  <div class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4 w-full max-w-md">
      <div class="mb-8">
        <router-link to="/" class="gradient-background hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center">
          <i class="fas fa-arrow-left mr-2"></i> Back
        </router-link>
      </div>
      <h1 class="text-3xl font-bold mb-6">Create Game</h1>
      <form @submit.prevent="createGame" class="space-y-6">
        <div>
          <label for="name" class="block font-medium text-gray-400 mb-2">Name:</label>
          <input id="name" v-model="name" type="text" class="bg-gray-700 text-white rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-600" />
        </div>
        <div>
          <label for="genre" class="block font-medium text-gray-400 mb-2">Genre:</label>
          <input id="genre" v-model="genre" type="text" class="bg-gray-700 text-white rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-600" />
        </div>
        <div>
          <label for="price" class="block font-medium text-gray-400 mb-2">Price:</label>
          <input id="price" v-model="price" type="number" step="0.01" class="bg-gray-700 text-white rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-600" />
        </div>
        <div>
          <label for="image" class="block font-medium text-gray-400 mb-2">Image URL:</label>
          <input id="image" v-model="image" type="text" class="bg-gray-700 text-white rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-600" />
        </div>
        <button type="submit" class="gradient-background hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-md transition-colors flex items-center justify-center">
          <i class="fas fa-plus mr-2"></i> Create
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from "@/stores/auth";

// Import useAuthStore
const authStore = useAuthStore();

// Initialize useAuthStore
const router = useRouter();
const name = ref('');
const genre = ref('');
const price = ref('');
const image = ref('');

const createGame = async () => {
  if (name.value && genre.value && price.value) {
    try {
      await axios.post('http://localhost:8000/api/games', {
        name_games: name.value,
        genre_games: genre.value,
        price: price.value,
        image: image.value,
      }, {
        headers: {
          Authorization: `Bearer ${authStore.accessToken}`, // Set Authorization header with access token
        },
      });
      router.push('/game');
    } catch (error) {
      console.error('Error creating game:', error); // Handle error creating game
    }
  } else {
    alert('Please fill in all required fields');
  }
};
</script>

<style>
.gradient-background {
  background: linear-gradient(135deg, #667eea, #764ba2);
}
</style>