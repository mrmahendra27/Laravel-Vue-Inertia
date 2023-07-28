<template>
  <Head title="Login" />

  <main class="grid items-center min-h-screen">
    <section class="bg-white p-8 rounded max-w-md mx-auto border border-blue-800">
      <h1 class="text-3xl">Login</h1>

      <form class="max-w-md mx-auto mt-8" @submit.prevent="submit">
        <div class="flex flex-wrap -mx-3 mb-2">
          <div class="w-full px-3">
            <label
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
              for="grid-email"
            >
              Email
            </label>
            <input
              class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              id="grid-email"
              type="email"
              placeholder="Enter Email"
              v-model="form.email"
              required
            />
            <p
              v-if="form.errors.email"
              v-text="form.errors.email"
              class="text-red-600 text-xs italic"
            ></p>
          </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
          <div class="w-full px-3">
            <label
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
              for="grid-password"
            >
              Password
            </label>
            <input
              class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              id="grid-password"
              type="password"
              placeholder="Enter Password"
              v-model="form.password"
              required
            />
            <p
              v-if="form.errors.password"
              v-text="form.errors.password"
              class="text-red-600 text-xs italic"
            ></p>
          </div>
        </div>
        <div class="md:flex md:items-center">
          <button
            class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
            type="submit"
            :disabled="form.processing"
          >
            Login
          </button>
        </div>
      </form>
    </section>
  </main>
</template>
<script>
export default {
  layout: null,
};
</script>
<script setup>
import { useForm } from "@inertiajs/vue3";
const form = useForm({
  email: null,
  password: null,
});

function submit() {
  form.post("/login", form);
}
</script>