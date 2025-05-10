<template>
  <div class="bg-gray-900 min-h-screen py-10">
    <div class="container mx-auto">
      <div class="mb-8">
        <button
          @click="goBack"
          class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-medium py-2 px-4 rounded-md transition-colors shadow-lg"
        >
          &larr; Back
        </button>
      </div>
      <div v-if="game" class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="relative">
          <img
            :src="game.image"
            :alt="game.name_games"
            class="w-full h-80 md:h-96 object-cover"
          />
          <div class="absolute top-0 left-0 p-2 bg-green-600 text-white rounded-br-lg">
            <i class="fas fa-tag mr-1"></i> Rp {{ game.price }}/Jam
          </div>
        </div>
        <div class="p-8">
          <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ game.name_games }}</h2>
          <p class="text-gray-400 mb-4">
            <i class="fas fa-tag mr-2 text-purple-400"></i> Genre: {{ game.genre_games }}
          </p>
          <div class="flex justify-between items-center">
            <router-link
              :to="`/game/${game.id}/edit`"
              class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-4 py-2 md:px-6 md:py-3 rounded-md transition duration-300 ease-in-out flex items-center mr-4 shadow-lg"
            >
              <i class="fas fa-edit mr-2"></i> Edit
            </router-link>
            <button
              @click="deleteGame"
              class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 md:px-6 md:py-3 rounded-md transition duration-300 ease-in-out flex items-center shadow-lg"
            >
              <i class="fas fa-trash mr-2"></i> Delete
            </button>
          </div>
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

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();
const game = ref(null);

onMounted(async () => {
  try {
    const response = await axios.get(`http://localhost:8000/api/games/${route.params.id}`, {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    game.value = response.data.data;
  } catch (error) {
    console.error('Error fetching game details:', error);
    // Handle error fetching game details
  }
});

const goBack = () => {
  router.go(-1);
};

const deleteGame = async () => {
  if (confirm('Are you sure you want to delete this game?')) {
    try {
      await axios.delete(`http://localhost:8000/api/games/${game.value.id}`, {
        headers: {
          Authorization: `Bearer ${authStore.accessToken}`,
        },
      });
      router.push('/game');
    } catch (error) {
      console.error('Error deleting game:', error);
      // Handle error deleting game
    }
  }
};
</script>

<style>
/* No changes to the style */
</style>