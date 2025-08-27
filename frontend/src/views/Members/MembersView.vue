<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { onMounted } from 'vue';
import Spinner from '@/components/Spinner.vue';

const isLoading = ref(false);

const members = ref([]);

const fetchMembers = async () => {
    try {
        isLoading.value = true;
        const response = await axios.get('/member');
        members.value = response.data;
        console.log('Members fetched successfully:', members.value);
    } catch (error) {
        console.log(error);
    } finally {
        isLoading.value = false;
    }
};


onMounted(() => {
    fetchMembers();
});

</script>


<template>

    <!-- Header -->
    <header class="bg-white shadow p-4 max-w-8xl items-center mx-auto ">
        <h1 class="flex text-xl font-semibold text-gray-800">
            <svg class="w-6 h-6 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z">
                </path>
            </svg>
            Members
        </h1>
    </header>


    <div class="p-6 overflow-x-auto mx-auto max-w-8xl">
        <!-- Search Bar -->
        <div class="mb-6 flex items-center gap-4">
            <input type="text" placeholder="Search projects..."
                class="w-full max-w-md rounded-lg border border-gray-400 px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black"
                aria-label="Search projects" />
        </div>
        <!-- Table -->
        <div class="overflow-hidden rounded-xl shadow-sm bg-white">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-100" v-if="!isLoading">
                    <tr>
                        <th class="px-4 py-2 text-sm font-medium text-gray-700 text-center">ID</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Member</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Function</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Member Since</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <Spinner v-if="isLoading" class="flex justify-center items-center" />

                    <tr class="border-b border-gray-100 hover:bg-gray-100 transition-colors" v-for="member in members"
                        :key="member.id">

                        <td class="p-2 text-center bg-gray-100">
                            <p class="text-sm text-gray-900">{{ member.id }}</p>
                        </td>

                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <!-- <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-3.jpg"
                                    alt="John Michael" class="h-9 w-9 rounded-full object-cover" loading="lazy" /> -->
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">{{ member.name }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="p-4">
                            <div class="flex flex-col">
                                <p class="text-sm font-medium text-gray-600" v-if="member.phone_number"><i
                                        class="fa-solid fa-phone"></i> {{ member.phone_number }}</p>
                                <p class="text-sm font-medium text-gray-600" v-if="member.email"><i
                                        class="fa-solid fa-envelope"></i> {{ member.email }}</p>
                                <p class="text-sm font-medium text-gray-600" v-if="!member.phone_number"><i
                                        class="fa-solid fa-phone"></i> No data</p>
                                <p class="text-sm font-medium text-gray-600" v-if="!member.email"><i
                                        class="fa-solid fa-envelope"></i> No data</p>
                            </div>
                        </td>

                        <td class="p-4">
                            <span
                                class="inline-block rounded-md bg-green-100 text-green-700 px-2 py-1 text-xs font-semibold uppercase"
                                :class="{ 'bg-red-100 text-red-700': member.status === 'banned' }">
                                {{ member.status }}
                            </span>
                        </td>

                        <td class="p-4">
                            <p class="text-sm text-gray-900"> {{ new Date(member.created_at).toLocaleString() }} </p>
                        </td>

                        <td class="p-4">
                            <button @click="$router.push(`/members/${member.id}`)"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fa-solid fa-address-card"></i>
                            </button>
                            <button
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>



</template>


<style scoped></style>