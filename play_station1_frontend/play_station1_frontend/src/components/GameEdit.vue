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
      <div class="bg-gray-800 rounded-lg shadow-lg p-8">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Edit Game</h2>
        <form @submit.prevent="updateGame">
          <div class="mb-6">
            <label class="block text-gray-400 font-bold mb-2" for="name_games">
              Name
            </label>
            <input
              v-model="form.name_games"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline-purple focus:border-purple-500"
              id="name_games"
              type="text"
              placeholder="Enter game name"
            />
          </div>
          <div class="mb-6">
            <label class="block text-gray-400 font-bold mb-2" for="genre_games">
              Genre
            </label>
            <input
              v-model="form.genre_games"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline-purple focus:border-purple-500"
              id="genre_games"
              type="text"
              placeholder="Enter game genre"
            />
          </div>
          <div class="mb-6">
            <label class="block text-gray-400 font-bold mb-2" for="price">
              Price
            </label>
            <input
              v-model="form.price"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline-purple focus:border-purple-500"
              id="price"
              type="number"
              placeholder="Enter game price"
            />
          </div>
          <div class="mb-6">
            <label class="block text-gray-400 font-bold mb-2" for="image">
              Image
            </label>
            <input
              v-model="form.image"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline-purple focus:border-purple-500"
              id="image"
              type="text"
              placeholder="Enter game image URL"
            />
          </div>
          <div class="flex items-center justify-between">
            <button
              type="button"
              @click="cancelEdit"
              class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 md:px-6 md:py-3 rounded-md transition duration-300 ease-in-out flex items-center mr-4 shadow-lg"
            >
              <i class="fas fa-times mr-2"></i> Cancel
            </button>
            <button
              type="submit"
              class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-4 py-2 md:px-6 md:py-3 rounded-md transition duration-300 ease-in-out flex items-center shadow-lg"
            >
              <i class="fas fa-save mr-2"></i> Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from 'axios';
import { reactive, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const router = useRouter();
const route = useRoute();
const authStore = useAuthStore();

const form = reactive({
  name_games: '',
  genre_games: '',
  price: '',
  image: '',
});

onMounted(async () => {
  try {
    const response = await axios.get(`http://localhost:8000/api/games/${route.params.id}`, {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    const game = response.data.data;
    form.name_games = game.name_games;
    form.genre_games = game.genre_games;
    form.price = game.price;
    form.image = game.image;
  } catch (error) {
    console.error('Error fetching game details:', error);
    // Handle error fetching game details
  }
});

const goBack = () => {
  router.go(-1);
};

const cancelEdit = () => {
  router.go(-1);
};

const updateGame = async () => {
  try {
    await axios.put(`http://localhost:8000/api/games/${route.params.id}`, form, {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    router.push('/game');
  } catch (error) {
    console.error('Error updating game:', error);
    // Handle error updating game
  }
};
</script>

<style>
.focus\:shadow-outline-purple {
  box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.5);
}

.focus\:border-purple-500 {
  border-color: #9061f9;
}
</style>