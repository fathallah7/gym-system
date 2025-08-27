<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';
import Spinner from '@/components/Spinner.vue';

const route = useRoute();
const memberId = route.params.id;

const selectedMember = ref(null);
const isLoading = ref(false);

const fetchMember = async () => {
    try {
        isLoading.value = true;
        const response = await axios.get(`/member/${memberId}`);
        selectedMember.value = response.data;
        console.log('Member fetched successfully:', selectedMember.value);
    } catch (error) {
        console.error('Error fetching member:', error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    fetchMember();
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
            Member Profile
        </h1>
    </header>

    <Spinner v-if="isLoading" />

    <!-- Member Details Page -->
    <div class="bg-gray-50 min-h-screen flex items-center justify-center py-8" v-if="!isLoading">
        <div class="bg-white rounded-xl p-8 w-full max-w-8xl shadow-2xl border border-gray-300">
            <div class="flex justify-between items-center mb-6">
                <button @click="$router.back()" class="text-gray-600 hover:text-gray-900">
                    <i class="fa-solid fa-arrow-left text-lg"></i>
                    <span class="ml-2 text-sm font-medium">Back</span>
                </button>
            </div>
            <hr class="mb-6 border-gray-400" />
            <div v-if="selectedMember" class="space-y-6">
                <div class="flex flex-col items-center mb-6">
                    <div class="relative">
                        <img :src="selectedMember.photo || 'https://i.pravatar.cc/200?img=2'" alt="Member Photo"
                            class="w-32 h-32 rounded-full object-cover border-4 border-blue-900 shadow-lg">
                        <div class="absolute inset-0 rounded-full border-3 border-yellow-500 opacity-80 shadow-inner">
                        </div>
                    </div>
                    <h2 class="mt-4 text-lg font-medium text-gray-900">{{ selectedMember.name }}</h2>
                    <p class="text-base text-gray-600">ID: {{ selectedMember.id }}</p>
                </div>

                <div class="bg-gray-100 rounded-lg p-4 border border-gray-200">
                    <h3 class="text-base font-semibold text-gray-800 mb-3">Personal Information</h3>
                    <div class="grid grid-cols-2 gap-4 text-base">
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-blue-800 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Email:</span> {{ selectedMember.email || 'N/A' }}
                            </p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-phone text-blue-800 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Phone:</span> {{ selectedMember.phone_number ||
                                'N/A' }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-map-marker-alt text-blue-800 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Address:</span> {{ selectedMember.address ||
                                'N/A' }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-birthday-cake text-blue-800 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Birth:</span> {{ selectedMember.date_of_birth ||
                                'N/A' }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-venus-mars text-blue-800 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Gender:</span> {{ selectedMember.gender || 'N/A'
                            }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-sticky-note text-blue-800 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Notes:</span> {{ selectedMember.notes || 'N/A' }}
                            </p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-check-circle text-blue-800 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Status: </span>
                                <span :class="selectedMember.status === 'allowed' ? 'text-green-700' : 'text-red-700'">
                                    {{ selectedMember.status || 'N/A' }}
                                </span>
                            </p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-calendar-alt text-blue-800 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Since:</span> {{ new
                                Date(selectedMember.created_at).toLocaleDateString() }}</p>
                        </div>
                    </div>
                </div>

                <hr class="mb-6 border-gray-400" />

                <div v-if="selectedMember.memberships && selectedMember.memberships.length"
                    class="bg-gray-100 rounded-lg p-4 border border-gray-200">
                    <h3 class="text-base font-semibold text-gray-800 mb-3">Membership Plans</h3>
                    <div v-for="membership in selectedMember.memberships" :key="membership.id"
                        class="grid grid-cols-2 gap-4 text-base mb-4 last:mb-0">
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3 col-span-2">
                            <i class="fa-solid fa-id-card text-blue-800 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Membership ID:</span> {{ membership.id }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-list text-blue-800 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Plan:</span> {{ membership.plan.name }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-check-circle text-blue-800 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Status: </span>
                                <span :class="membership.status === 'active' ? 'text-green-700' : 'text-red-700'">
                                    {{ membership.status }}
                                </span>
                            </p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-calendar-day text-blue-800 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Start:</span> {{ membership.start_date }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-calendar-times text-blue-800 text-lg"></i>
                            <p><span class="font-medium text-gray-800">End:</span> {{ membership.end_date }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-ticket-alt text-blue-800 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Sessions:</span> {{ membership.remaining_sessions
                                || 'open' }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-sticky-note text-blue-800 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Notes:</span> {{ membership.notes || 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <p v-else class="text-base text-gray-600 text-center">No membership plans available.</p>

            </div>
            <div class="mt-6 flex justify-center gap-4">
                <button @click="$router.back()"
                    class="px-5 py-1.5 bg-blue-800 text-white rounded-md hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all text-base">
                    Back
                </button>
            </div>
        </div>
    </div>
</template>