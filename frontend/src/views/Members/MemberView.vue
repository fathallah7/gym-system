<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute , useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';
import Spinner from '@/components/Spinner.vue';

const route = useRoute();
const $router = useRouter();
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
        await axios.put(`/member/${memberId}`, selectedMember.value);
        console.log('Member updated successfully:', selectedMember.value);
        toast.success('Member updated successfully!');
    } catch (error) {
        console.error('Error updating member:', error);
        toast.error('Failed to update member.');
    }
};

const deleteMember = async () => {
    if (confirm('Are you sure you want to delete this member?')) {
        try {
            await axios.delete(`/member/${memberId}`);
            $router.back();
            toast.success('Member deleted successfully!');
        } catch (error) {
            toast.error('Failed to delete member.');
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

                <div
                    class="bg-cream-50 rounded-xl p-8 shadow-lg border border-black max-w-8xl mx-auto relative overflow-hidden">
                    <!-- Subtle background texture -->
                    <div
                        class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/linen.png')] opacity-10">
                    </div>

                    <h3
                        class="text-3xl font-bold text-black mb-8 text-center tracking-tight bg-clip-text bg-gradient-to-r from-black to-bronze-600">
                        Member Profile
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                        <div class="relative group">
                            <div
                                class="bg-white p-6 rounded-lg border border-black shadow-sm transition-all duration-400 group-hover:shadow-md group-hover:border-bronze-300">
                                <div class="flex items-center gap-4">
                                    <i class="fa-solid fa-envelope text-black text-2xl"></i>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-black mb-2">Email</label>
                                        <input type="email" v-model="selectedMember.email"
                                            class="w-full p-3 bg-cream-50 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-bronze-500 focus:border-bronze-500 text-black placeholder-black transition-all duration-300 font-sans text-sm"
                                            placeholder="Enter email" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative group">
                            <div
                                class="bg-white p-6 rounded-lg border border-black shadow-sm transition-all duration-400 group-hover:shadow-md group-hover:border-bronze-300">
                                <div class="flex items-center gap-4">
                                    <i class="fa-solid fa-phone text-black text-2xl"></i>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-black mb-2">Phone</label>
                                        <input type="tel" v-model="selectedMember.phone_number"
                                            class="w-full p-3 bg-cream-50 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-bronze-500 focus:border-bronze-500 text-black placeholder-black transition-all duration-300 font-sans text-sm"
                                            placeholder="Enter phone number" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative group">
                            <div
                                class="bg-white p-6 rounded-lg border border-black shadow-sm transition-all duration-400 group-hover:shadow-md group-hover:border-bronze-300">
                                <div class="flex items-center gap-4">
                                    <i class="fa-solid fa-map-marker-alt text-black text-2xl"></i>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-black mb-2">Address</label>
                                        <input type="text" v-model="selectedMember.address"
                                            class="w-full p-3 bg-cream-50 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-bronze-500 focus:border-bronze-500 text-black placeholder-black transition-all duration-300 font-sans text-sm"
                                            placeholder="Enter address" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative group">
                            <div
                                class="bg-white p-6 rounded-lg border border-black shadow-sm transition-all duration-400 group-hover:shadow-md group-hover:border-bronze-300">
                                <div class="flex items-center gap-4">
                                    <i class="fa-solid fa-birthday-cake text-black text-2xl"></i>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-black mb-2">Date
                                            of Birth</label>
                                        <input type="date" v-model="selectedMember.date_of_birth"
                                            class="w-full p-3 bg-cream-50 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-bronze-500 focus:border-bronze-500 text-black transition-all duration-300 font-sans text-sm" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative group">
                            <div
                                class="bg-white p-6 rounded-lg border border-black shadow-sm transition-all duration-400 group-hover:shadow-md group-hover:border-bronze-300">
                                <div class="flex items-center gap-4">
                                    <i class="fa-solid fa-venus-mars text-black text-2xl"></i>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-black mb-2">Gender</label>
                                        <select v-model="selectedMember.gender"
                                            class="w-full p-3 bg-cream-50 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-bronze-500 focus:border-bronze-500 text-black transition-all duration-300 font-sans text-sm">
                                            <option value="" disabled class="text-black">Select gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative group">
                            <div
                                class="bg-white p-6 rounded-lg border border-black shadow-sm transition-all duration-400 group-hover:shadow-md group-hover:border-bronze-300">
                                <div class="flex items-center gap-4">
                                    <i class="fa-solid fa-sticky-note text-black text-2xl"></i>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-black mb-2">Notes</label>
                                        <textarea v-model="selectedMember.notes"
                                            class="w-full p-3 bg-cream-50 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-bronze-500 focus:border-bronze-500 text-black placeholder-black transition-all duration-300 font-sans text-sm"
                                            placeholder="Enter notes" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative group">
                            <div
                                class="bg-white p-6 rounded-lg border border-black shadow-sm transition-all duration-400 group-hover:shadow-md group-hover:border-bronze-300">
                                <div class="flex items-center gap-4">
                                    <i class="fa-solid fa-check-circle text-black text-2xl"></i>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-black mb-2">Status</label>
                                        <select v-model="selectedMember.status"
                                            class="w-full p-3 bg-cream-50 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-bronze-500 focus:border-bronze-500 text-black transition-all duration-300 font-sans text-sm">
                                            <option value="allowed" class="text-green-700">Active</option>
                                            <option value="banned" class="text-red-700">Suspended</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative group">
                            <div
                                class="bg-white p-6 rounded-lg border border-black shadow-sm transition-all duration-400 group-hover:shadow-md group-hover:border-bronze-300">
                                <div class="flex items-center gap-4">
                                    <i class="fa-solid fa-calendar-alt text-black text-2xl"></i>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-black mb-2">Member
                                            Since</label>
                                        <input type="text"
                                            :value="new Date(selectedMember.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })"
                                            class="w-full p-3 bg-cream-100 border border-black rounded-md cursor-not-allowed text-black font-sans text-sm"
                                            disabled />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-center gap-6 relative z-10">
                        <button @click="updateMember"
                            class="relative bg-gray-800 text-white px-8 py-3 rounded-md font-medium shadow-md hover:shadow-lg hover:bg-black focus:outline-none focus:ring-2 focus:ring-bronze-400 transition-all duration-200 hover:bg-gradient-to-r cursor-pointer">
                            Save Changes
                        </button>
                        <button @click="deleteMember"
                            class="relative bg-red-700 text-white px-8 py-3 rounded-md font-medium shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-400 transition-all duration-200 hover:bg-gradient-to-r hover:bg-red-800  cursor-pointer">
                            Remove Member
                        </button>
                    </div>
                </div>

                <div v-if="selectedMember.memberships && selectedMember.memberships.length"
                    class="bg-cream-50 rounded-lg p-6 border border-black shadow-sm relative z-10">
                    <h3
                        class="text-lg font-semibold text-black mb-6 tracking-tight bg-clip-text bg-gradient-to-r from-black to-bronze-600">
                        Membership Plans
                    </h3>
                    <div v-for="membership in selectedMember.memberships" :key="membership.id"
                        class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-6 last:mb-0">
                        <div
                            class="bg-white p-4 rounded-md border border-black shadow-sm flex items-center gap-3 transition-all duration-300 hover:shadow-md hover:border-bronze-300">
                            <i class="fa-solid fa-id-card text-black text-lg"></i>
                            <p><span class="font-medium text-black">Membership ID:</span> {{
                                membership.id }}</p>
                        </div>
                        <div
                            class="bg-white p-4 rounded-md border border-black shadow-sm flex items-center gap-3 transition-all duration-300 hover:shadow-md hover:border-bronze-300">
                            <i class="fa-solid fa-list text-black text-lg"></i>
                            <p><span class="font-medium text-black">Plan:</span> {{
                                membership.plan.name }}</p>
                        </div>
                        <div
                            class="bg-white p-4 rounded-md border border-black shadow-sm flex items-center gap-3 transition-all duration-300 hover:shadow-md hover:border-bronze-300">
                            <i class="fa-solid fa-check-circle text-black text-lg"></i>
                            <p><span class="font-medium font text-black">Status: </span>
                                <span
                                    :class="membership.status === 'active' ? 'font-bold text-green-700' : 'text-red-700'">
                                    {{ membership.status.charAt(0).toUpperCase() + membership.status.slice(1) }}
                                </span>
                            </p>
                        </div>
                        <div
                            class="bg-white p-4 rounded-md border border-black shadow-sm flex items-center gap-3 transition-all duration-300 hover:shadow-md hover:border-bronze-300">
                            <i class="fa-solid fa-ticket-alt text-black text-lg"></i>
                            <p><span class="font-medium text-black">Sessions: </span> {{
                                membership.remaining_sessions ?? 'Open' }}</p>
                        </div>
                        <div
                            class="bg-white p-4 rounded-md border border-black shadow-sm flex items-center gap-3 transition-all duration-300 hover:shadow-md hover:border-bronze-300">
                            <i class="fa-solid fa-calendar-day text-black text-lg"></i>
                            <p><span class="font-medium text-black">Start:</span>
                                {{ new Date(membership.start_date).toLocaleDateString('en-US', {
                                    year: 'numeric', month:
                                        'short', day: 'numeric'
                                }) }}
                            </p>
                        </div>
                        <div
                            class="bg-white p-4 rounded-md border border-black shadow-sm flex items-center gap-3 transition-all duration-300 hover:shadow-md hover:border-bronze-300">
                            <i class="fa-solid fa-calendar-times text-black text-lg"></i>
                            <p><span class="font-medium text-black">End:</span>
                                {{ membership.end_date ? new Date(membership.end_date).toLocaleDateString('en-US', {
                                    year: 'numeric', month: 'short', day: 'numeric'
                                }) : 'N/A' }}
                            </p>
                        </div>
                        <div
                            class="bg-white p-4 rounded-md border border-black shadow-sm flex items-center gap-3 transition-all duration-300 hover:shadow-md hover:border-bronze-300">
                            <i class="fa-solid fa-sticky-note text-black text-lg"></i>
                            <p><span class="font-medium text-black">Notes:</span> {{ membership.notes
                                || 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <p v-else class="text-sm text-black text-center font-sans py-4">
                    No membership plans available.
                </p>
            </div>
            <div class="mt-6 flex justify-center gap-4">
                <button @click="$router.back()"
                    class="px-5 py-1.5 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all text-base">Back</button>
            </div>
        </div>
    </div>
</template>
