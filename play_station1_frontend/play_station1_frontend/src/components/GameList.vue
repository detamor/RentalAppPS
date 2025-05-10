<template>
  <div class="bg-gray-900 min-h-screen">
    <div class="container mx-auto py-8">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-white">Games List</h1>
        <router-link
          to="/create"
          class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-lg transition duration-300 ease-in-out flex items-center shadow-lg"
        >
          <i class="fas fa-plus mr-2"></i> Create a new game
        </router-link>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <div
          v-for="game in games"
          :key="game.id"
          class="bg-gray-800 rounded-lg overflow-hidden flex flex-col shadow-lg"
        >
          <div class="relative flex-grow">
            <img
              :src="game.image"
              :alt="game.name_games"
              class="w-full h-64 object-cover"
            />
            <div class="absolute top-0 left-0 p-2 bg-green-600 text-white rounded-br-lg">
              <i class="fas fa-tag mr-1"></i> Rp {{ game.price }}/Jam
            </div>
          </div>
          <div class="p-6 flex-grow">
            <h2 class="text-2xl font-semibold mt-4 mb-2 text-white">
              {{ game.name_games }}
            </h2>
            <p class="text-gray-400 mb-4">
              <i class="fas fa-tag mr-2 text-purple-400"></i> Genre:
              {{ game.genre_games }}
            </p>
            <div class="flex justify-between items-center">
              <router-link
                :to="`/game/${game.id}`"
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
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
const games = ref([]);

onMounted(async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/games', {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    games.value = response.data.data;
  } catch (error) {
    console.error('Error fetching games:', error);
  }
});
</script>

<style>
/* Tidak ada perubahan pada bagian style */
</style>