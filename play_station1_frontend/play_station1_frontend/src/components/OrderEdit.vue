<template>
  <div class="bg-gray-900 min-h-screen">
    <div class="container mx-auto py-8">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-white">Edit Order</h1>
        <button
          class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-lg transition duration-300 ease-in-out flex items-center shadow-lg"
          @click="goBack"
        >
          <i class="fas fa-arrow-left mr-2"></i> Back
        </button>
      </div>
      <form @submit.prevent="updateOrder" v-if="order" class="bg-gray-800 rounded-lg overflow-hidden flex flex-col shadow-lg">
        <div class="p-6 flex-grow">
          <div class="mb-4">
            <label class="block text-gray-400 font-bold mb-2" for="customer_id">Customer:</label>
            <div class="relative">
              <select
                v-model="form.customer_id"
                id="customer_id"
                class="block appearance-none w-full bg-gray-700 text-white border border-gray-600 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
              >
                <option value="" disabled>Select a customer</option>
                <option v-for="customer in customers" :key="customer.id" :value="customer.id">
                  {{ customer.name }}
                </option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M14.707 6.293a1 1 0 00-1.414 0L10 9.586 6.707 6.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 000-1.414z" />
                </svg>
              </div>
            </div>
            <p v-if="formErrors.customer_id" class="text-red-500 text-sm mt-1">{{ formErrors.customer_id[0] }}</p>
          </div>
          <div class="mb-4">
            <label class="block text-gray-400 font-bold mb-2" for="game_id">Game:</label>
            <div class="relative">
              <select
                v-model="form.game_id"
                @change="updateTotalPrice"
                id="game_id"
                class="block appearance-none w-full bg-gray-700 text-white border border-gray-600 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
              >
                <option value="" disabled>Select a game</option>
                <option v-for="game in games" :key="game.id" :value="game.id">
                  {{ game.name_games }} - ${{ game.price }}
                </option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M14.707 6.293a1 1 0 00-1.414 0L10 9.586 6.707 6.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 000-1.414z" />
                </svg>
              </div>
            </div>
            <p v-if="formErrors.game_id" class="text-red-500 text-sm mt-1">{{ formErrors.game_id[0] }}</p>
          </div>
          <div class="mb-4">
            <label class="block text-gray-400 font-bold mb-2" for="quantity">Duration:</label>
            <input
              v-model.number="form.quantity"
              type="number"
              id="quantity"
              name="quantity"
              class="block appearance-none w-full bg-gray-700 text-white border border-gray-600 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
            />
            <p v-if="formErrors.quantity" class="text-red-500 text-sm mt-1">{{ formErrors.quantity[0] }}</p>
          </div>
          <div class="mb-4">
            <label class="block text-gray-400 font-bold mb-2" for="total_price">Total Price:</label>
            <input
              v-model.number="form.total_price"
              type="number"
              id="total_price"
              name="total_price"
              step="0.01"
              class="block appearance-none w-full bg-gray-700 text-white border border-gray-600 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
            />
            <p v-if="formErrors.total_price" class="text-red-500 text-sm mt-1">{{ formErrors.total_price[0] }}</p>
          </div>
          <div class="mb-4">
            <label class="block text-gray-400 font-bold mb-2" for="rental_date">Rental Date:</label>
            <input
              v-model="form.rental_date"
              type="date"
              id="rental_date"
              name="rental_date"
              class="block appearance-none w-full bg-gray-700 text-white border border-gray-600 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
            />
            <p v-if="formErrors.rental_date" class="text-red-500 text-sm mt-1">{{ formErrors.rental_date[0] }}</p>
          </div>
          <div class="mb-4">
            <label class="block text-gray-400 font-bold mb-2" for="status">Status:</label>
            <div class="relative">
              <select
                v-model="form.status"
                id="status"
                class="block appearance-none w-full bg-gray-700 text-white border border-gray-600 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
              >
                <option value="" disabled>Select a status</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="canceled">Canceled</option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M14.707 6.293a1 10 00-1.414 0L10 9.586 6.707 6.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 000-1.414z" />
                </svg>
              </div>
            </div>
            <p v-if="formErrors.status" class="text-red-500 text-sm mt-1">{{ formErrors.status[0] }}</p>
          </div>
        </div>
        <div class="p-6 bg-gray-700 flex justify-between items-center">
          <button
            type="submit"
            class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-lg transition duration-300 ease-in-out flex items-center shadow-lg"
          >
            <i class="fas fa-save mr-2"></i> Save Changes
          </button>
          <router-link
            :to="{ name: 'orderdetail', params: { id: order.id } }"
            class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-6 py-3 rounded-lg transition duration-300 ease-in-out flex items-center shadow-lg"
          >
            <i class="fas fa-times mr-2"></i> Cancel
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
// Import required modules and functions
import axios from "axios";
import { ref, computed, onMounted, watch } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useRouter, useRoute } from "vue-router";

// Get the authentication store, router and current route
const authStore = useAuthStore();
const router = useRouter();
const route = useRoute();

// Define reactive variables and computed properties
const order = ref(null);
const form = ref({
  customer_id: "",
  game_id: "",
  quantity: 0,
  total_price: 0,
  status: "",
  rental_date: "",
});
const formErrors = ref({});

// Fetch the order data on component mount
onMounted(async () => {
  const orderId = route.params.id;
  try {
    const response = await axios.get(`http://localhost:8000/api/orders/${orderId}`, {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    order.value = response.data.data;
  } catch (error) {
    console.error(error);
  }
});

// Define a computed property to map the order data to the form object
const mappedForm = computed(() => {
  if (!order.value) {
    return form.value;
  }
  return {
    customer_id: order.value.customer.id,
    game_id: order.value.game.id,
    quantity: order.value.quantity,
    total_price: order.value.total_price,
    status: order.value.status,
    rental_date: order.value.rental_date,
  };
});

// Update the total price when the game selection changes
const updateTotalPrice = () => {
  const game = games.value.find((game) => game.id === Number(form.value.game_id));
  form.value.total_price = game.price * form.value.quantity;
};

// Update the form variable whenever the order variable changes
watch(
  () => order.value,
  () => {
    form.value = { ...mappedForm.value };
  },
  { immediate: true }
);

// Define methods for updating the order and handling form errors
async function updateOrder() {
  try {
    const response = await axios.put(`http://localhost:8000/api/orders/${order.value.id}`, form.value, {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    order.value = response.data.data;
    router.push({ name: "orderlist" });
  } catch (error) {
    if (error.response && error.response.status === 422) {
      formErrors.value = error.response.data.errors;
    } else {
      console.error(error);
    }
  }
}

// Fetch the list of customers and games to display in the select inputs
const customers = ref([]);
const games = ref([]);
onMounted(async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/customers", {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    customers.value = response.data.data;
  } catch (error) {
    console.error(error);
  }
  try {
    const response = await axios.get("http://localhost:8000/api/games", {
      headers: {
        Authorization: `Bearer ${authStore.accessToken}`,
      },
    });
    games.value = response.data.data;
  } catch (error) {
    console.error(error);
  }
});

// Define a method to navigate back to the previous page in the browser history
const goBack = () => {
  router.go(-1);
};
</script>