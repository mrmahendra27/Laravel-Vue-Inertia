<template>
  <Head title="Users" />
  <div class="flex justify-between mb-6">
    <div class="flex items-center">
      <h1 class="text-3xl">Users</h1>
      <Link v-if="can.canCreateUser" href="/users/create" class="text-blue-500 text-sm ml-3"
        >New User</Link
      >
    </div>
    <input
      v-model="search"
      type="text"
      placeholder="Search.."
      class="border px-2 rounded-lg"
    />
  </div>

  <div class="py-8">
    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
      <div class="inline-block min-w-full shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
          <thead>
            <tr>
              <th
                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
              >
                Name
              </th>
              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users.data" :key="user.id">
              <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                <p class="text-gray-900 whitespace-no-wrap">{{ user.name }}</p>
              </td>

              <td
                class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right"
              >
                <Link
                  :href="`/users/${user.id}/edit`"
                  class="inline-block text-gray-500 hover:text-gray-700"
                  v-if="user.editable"
                >
                  Edit
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <Pagination :links="users.links" />
</template>
<script setup>
import Pagination from "../../Components/Pagination.vue";
import { reactive, ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import throttle from 'lodash/throttle'

let props = defineProps({ users: Object, filters: Object, can: Object });

let search = ref(props.filters.search);

let options = reactive({
  search: search,
});

watch(search, throttle(function(value) {
  console.log("triggered " + value)
  router.get("/users", options, {
    preserveState: true,
    replace: true,
  });
}, 1000));
</script>