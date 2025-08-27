<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';
import { useToast } from 'vue-toastification';
import Spinner from '@/components/Spinner.vue';

const route = useRoute();
const memberId = route.params.id;

const selectedMember = ref(null);
const isLoading = ref(false);

const toast = useToast();

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

const updateMember = async () => {
    try {
        isLoading.value = true;
        await axios.put(`/member/${memberId}`, selectedMember.value);
        console.log('Member updated successfully:', selectedMember.value);
        toast.success('Member updated successfully!');
    } catch (error) {
        console.error('Error updating member:', error);
        toast.error('Failed to update member.');
    } finally {
        isLoading.value = false;
    }
};

const deleteMember = async () => {
    if (confirm('Are you sure you want to delete this member?')) {
        try {
            isLoading.value = true;
            await axios.delete(`/member/${memberId}`);
            console.log('Member deleted successfully');
            alert('Member deleted successfully!');
            $router.push('/members');
        } catch (error) {
            console.error('Error deleting member:', error);
            alert('Failed to delete member.');
        } finally {
            isLoading.value = false;
        }
    }
};

onMounted(() => {
    fetchMember();
});
</script>

<template>
    <!-- Header -->
    <header class="bg-white shadow p-4 max-w-8xl mx-auto">
        <h1 class="flex text-xl font-semibold text-gray-800">
            <svg class="w-6 h-6 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
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
    <div class=" min-h-screen flex items-center justify-center py-8" v-if="!isLoading">
        <div class="bg-white rounded-lg p-8 w-full max-w-8xl shadow-md border border-gray-300">
            <div class="flex justify-between items-center mb-6">
                <button @click="$router.back()" class="text-gray-600 hover:text-gray-900">
                    <i class="fa-solid fa-arrow-left text-lg"></i>
                    <span class="ml-2 text-base font-medium">Back</span>
                </button>
            </div>
            <hr class="mb-6 border-gray-300" />
            <div v-if="selectedMember" class="space-y-6">
                <div class="flex flex-col items-center mb-6">
                    <div class="relative">
                        <img :src="selectedMember.photo || 'https://i.pravatar.cc/200?img=2'" alt="Member Photo"
                            class="w-32 h-32 rounded-full object-cover border-4 border-gray-600 shadow-sm">
                    </div>
                    <h2 class="mt-4 text-lg font-medium text-gray-900">{{ selectedMember.name }}</h2>
                    <p class="text-base text-gray-600">ID: {{ selectedMember.id }}</p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-md border border-gray-100">
                    <h3
                        class="text-2xl font-bold text-gray-900 mb-8 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-teal-500">
                        Member Profile</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="relative group">
                            <div
                                class="bg-gray-50 p-5 rounded-lg border border-gray-200 flex items-center gap-4 transition-all duration-300 group-hover:shadow-md group-hover:border-blue-300">
                                <i class="fa-solid fa-envelope text-blue-600 text-xl"></i>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" v-model="selectedMember.email"
                                        class="w-full p-3 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-400 transition-all duration-200"
                                        placeholder="Enter email" />
                                </div>
                            </div>
                        </div>
                        <div class="relative group">
                            <div
                                class="bg-gray-50 p-5 rounded-lg border border-gray-200 flex items-center gap-4 transition-all duration-300 group-hover:shadow-md group-hover:border-blue-300">
                                <i class="fa-solid fa-phone text-blue-600 text-xl"></i>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                    <input type="tel" v-model="selectedMember.phone_number"
                                        class="w-full p-3 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-400 transition-all duration-200"
                                        placeholder="Enter phone number" />
                                </div>
                            </div>
                        </div>
                        <div class="relative group">
                            <div
                                class="bg-gray-50 p-5 rounded-lg border border-gray-200 flex items-center gap-4 transition-all duration-300 group-hover:shadow-md group-hover:border-blue-300">
                                <i class="fa-solid fa-map-marker-alt text-blue-600 text-xl"></i>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                    <input type="text" v-model="selectedMember.address"
                                        class="w-full p-3 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-400 transition-all duration-200"
                                        placeholder="Enter address" />
                                </div>
                            </div>
                        </div>
                        <div class="relative group">
                            <div
                                class="bg-gray-50 p-5 rounded-lg border border-gray-200 flex items-center gap-4 transition-all duration-300 group-hover:shadow-md group-hover:border-blue-300">
                                <i class="fa-solid fa-birthday-cake text-blue-600 text-xl"></i>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                    <input type="date" v-model="selectedMember.date_of_birth"
                                        class="w-full p-3 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 transition-all duration-200" />
                                </div>
                            </div>
                        </div>
                        <div class="relative group">
                            <div
                                class="bg-gray-50 p-5 rounded-lg border border-gray-200 flex items-center gap-4 transition-all duration-300 group-hover:shadow-md group-hover:border-blue-300">
                                <i class="fa-solid fa-venus-mars text-blue-600 text-xl"></i>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                    <select v-model="selectedMember.gender"
                                        class="w-full p-3 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 transition-all duration-200">
                                        <option value="" class="text-gray-400">Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="relative group">
                            <div
                                class="bg-gray-50 p-5 rounded-lg border border-gray-200 flex items-center gap-4 transition-all duration-300 group-hover:shadow-md group-hover:border-blue-300">
                                <i class="fa-solid fa-sticky-note text-blue-600 text-xl"></i>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                                    <textarea v-model="selectedMember.notes"
                                        class="w-full p-3 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-400 transition-all duration-200"
                                        placeholder="Enter notes" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="relative group">
                            <div
                                class="bg-gray-50 p-5 rounded-lg border border-gray-200 flex items-center gap-4 transition-all duration-300 group-hover:shadow-md group-hover:border-blue-300">
                                <i class="fa-solid fa-check-circle text-blue-600 text-xl"></i>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select v-model="selectedMember.status"
                                        class="w-full p-3 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 transition-all duration-200">
                                        <option value="allowed" class="text-green-600">Allowed</option>
                                        <option value="banned" class="text-red-600">Banned</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="relative group">
                            <div
                                class="bg-gray-50 p-5 rounded-lg border border-gray-200 flex items-center gap-4 transition-all duration-300 group-hover:shadow-md group-hover:border-blue-300">
                                <i class="fa-solid fa-calendar-alt text-blue-600 text-xl"></i>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Since</label>
                                    <input type="text" :value="new Date(selectedMember.created_at).toLocaleDateString()"
                                        class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed text-gray-700 text-base"
                                        disabled />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end gap-4">
                        <button @click="updateMember"
                            class="relative bg-blue-600 text-white px-8 py-3 rounded-lg font-medium shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-300">
                            Update
                        </button>
                        <button @click="deleteMember"
                            class="relative bg-gradient-to-r from-red-500 to-red-700 text-white px-8 py-3 rounded-lg font-medium shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-400 transition-all duration-300">
                            Delete Member
                        </button>
                    </div>
                </div>

                <hr class="mb-6 border-gray-300" />

                <div v-if="selectedMember.memberships && selectedMember.memberships.length"
                    class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">Membership Plans</h3>
                    <div v-for="membership in selectedMember.memberships" :key="membership.id"
                        class="grid grid-cols-2 gap-4 text-base mb-4 last:mb-0">
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3 col-span-2">
                            <i class="fa-solid fa-id-card text-gray-600 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Membership ID:</span> {{ membership.id
                                }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-list text-gray-600 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Plan:</span> {{ membership.plan.name
                                }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-check-circle text-gray-600 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Status: </span>
                                <span :class="membership.status === 'active' ? 'text-green-600' : 'text-red-600'">
                                    {{ membership.status }}
                                </span>
                            </p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-calendar-day text-gray-600 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Start:</span> {{ membership.start_date
                                }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-calendar-times text-gray-600 text-lg"></i>
                            <p><span class="font-medium text-gray-800">End:</span> {{ membership.end_date }}
                            </p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-ticket-alt text-gray-600 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Sessions:</span> {{
                                membership.remaining_sessions || 'open' }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm flex items-center gap-3">
                            <i class="fa-solid fa-sticky-note text-gray-600 text-lg"></i>
                            <p><span class="font-medium text-gray-800">Notes:</span> {{ membership.notes ||
                                'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <p v-else class="text-base text-gray-600 text-center">No membership plans available.</p>
            </div>
            <div class="mt-6 flex justify-center gap-4">
                <button @click="$router.back()"
                    class="px-5 py-1.5 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all text-base">Back</button>
            </div>
        </div>
    </div>
</template>
