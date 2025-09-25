<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';
import Spinner from '@/components/Spinner.vue';
import PageHeader from '@/components/PageHeader.vue';

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
    <PageHeader title="Member Profile" icon="fa-solid fa-user" />

    <Spinner v-if="isLoading" />

    <!-- Member Details Page -->
    <div class="min-h-screen py-6 sm:py-8 px-4 sm:px-6" v-if="!isLoading">
        <div class="bg-white rounded-lg p-6 sm:p-8 w-full max-w-8xl mx-auto shadow-md border border-gray-200">
            <div class="flex justify-between items-center mb-4 sm:mb-6">
                <button @click="$router.back()"
                    class="flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                    <i class="fa-solid fa-arrow-left text-base sm:text-lg"></i>
                    <span class="ml-2 text-sm sm:text-base font-medium">Back</span>
                </button>
            </div>
            <hr class="mb-4 sm:mb-6 border-gray-200" />
            <div v-if="selectedMember" class="space-y-6">
                <div class="flex flex-col items-center mb-4 sm:mb-6">
                    <h2 class="mt-3 text-lg sm:text-xl font-medium text-gray-900">{{ selectedMember.name }}</h2>
                    <p class="text-sm sm:text-base text-gray-600">ID: {{ selectedMember.id }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 sm:p-8 shadow-sm border border-gray-200 max-w-7xl mx-auto">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 sm:mb-8 text-center tracking-tight">
                        Member Profile
                    </h3>

                    <div class="grid grid-cols-1 gap-4 sm:gap-6">
                        <div class="relative group">
                            <div
                                class="bg-white p-4 sm:p-6 rounded-lg border border-gray-200 shadow-sm transition-all duration-300 group-hover:shadow-md group-hover:border-gray-300">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <i class="fa-solid fa-envelope text-gray-700 text-lg sm:text-xl"></i>
                                    <div class="flex-1">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Email</label>
                                        <input type="email" v-model="selectedMember.email"
                                            class="w-full p-2.5 sm:p-3 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-500 transition-all duration-300 text-sm sm:text-base"
                                            placeholder="Enter email" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative group">
                            <div
                                class="bg-white p-4 sm:p-6 rounded-lg border border-gray-200 shadow-sm transition-all duration-300 group-hover:shadow-md group-hover:border-gray-300">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <i class="fa-solid fa-phone text-gray-700 text-lg sm:text-xl"></i>
                                    <div class="flex-1">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Phone</label>
                                        <input type="tel" v-model="selectedMember.phone_number"
                                            class="w-full p-2.5 sm:p-3 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-500 transition-all duration-300 text-sm sm:text-base"
                                            placeholder="Enter phone number" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative group">
                            <div
                                class="bg-white p-4 sm:p-6 rounded-lg border border-gray-200 shadow-sm transition-all duration-300 group-hover:shadow-md group-hover:border-gray-300">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <i class="fa-solid fa-map-marker-alt text-gray-700 text-lg sm:text-xl"></i>
                                    <div class="flex-1">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Address</label>
                                        <input type="text" v-model="selectedMember.address"
                                            class="w-full p-2.5 sm:p-3 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-500 transition-all duration-300 text-sm sm:text-base"
                                            placeholder="Enter address" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative group">
                            <div
                                class="bg-white p-4 sm:p-6 rounded-lg border border-gray-200 shadow-sm transition-all duration-300 group-hover:shadow-md group-hover:border-gray-300">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <i class="fa-solid fa-birthday-cake text-gray-700 text-lg sm:text-xl"></i>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Date of
                                            Birth</label>
                                        <input type="date" v-model="selectedMember.date_of_birth"
                                            class="w-full p-2.5 sm:p-3 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 transition-all duration-300 text-sm sm:text-base" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative group">
                            <div
                                class="bg-white p-4 sm:p-6 rounded-lg border border-gray-200 shadow-sm transition-all duration-300 group-hover:shadow-md group-hover:border-gray-300">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <i class="fa-solid fa-venus-mars text-gray-700 text-lg sm:text-xl"></i>
                                    <div class="flex-1">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Gender</label>
                                        <select v-model="selectedMember.gender"
                                            class="w-full p-2.5 sm:p-3 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 transition-all duration-300 text-sm sm:text-base">
                                            <option value="" disabled class="text-gray-500">Select gender</option>
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
                                class="bg-white p-4 sm:p-6 rounded-lg border border-gray-200 shadow-sm transition-all duration-300 group-hover:shadow-md group-hover:border-gray-300">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <i class="fa-solid fa-sticky-note text-gray-700 text-lg sm:text-xl"></i>
                                    <div class="flex-1">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Notes</label>
                                        <textarea v-model="selectedMember.notes"
                                            class="w-full p-2.5 sm:p-3 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-500 transition-all duration-300 text-sm sm:text-base"
                                            placeholder="Enter notes" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative group">
                            <div
                                class="bg-white p-4 sm:p-6 rounded-lg border border-gray-200 shadow-sm transition-all duration-300 group-hover:shadow-md group-hover:border-gray-300">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <i class="fa-solid fa-check-circle text-gray-700 text-lg sm:text-xl"></i>
                                    <div class="flex-1">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Status</label>
                                        <select v-model="selectedMember.status"
                                            class="w-full p-2.5 sm:p-3 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 transition-all duration-300 text-sm sm:text-base">
                                            <option value="allowed" class="text-green-600">Active</option>
                                            <option value="banned" class="text-red-600">Suspended</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative group">
                            <div
                                class="bg-white p-4 sm:p-6 rounded-lg border border-gray-200 shadow-sm transition-all duration-300 group-hover:shadow-md group-hover:border-gray-300">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <i class="fa-solid fa-calendar-alt text-gray-700 text-lg sm:text-xl"></i>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Member
                                            Since</label>
                                        <input type="text"
                                            :value="new Date(selectedMember.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })"
                                            class="w-full p-2.5 sm:p-3 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed text-gray-900 text-sm sm:text-base"
                                            disabled />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
                        <button @click="updateMember"
                            class="bg-blue-600 text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-md font-medium shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 text-sm sm:text-base">
                            Save Changes
                        </button>
                        <button @click="deleteMember"
                            class="bg-red-600 text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-md font-medium shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-200 text-sm sm:text-base">
                            Remove Member
                        </button>
                    </div>
                </div>

                <div v-if="selectedMember.memberships && selectedMember.memberships.length"
                    class="bg-gray-50 rounded-lg p-6 shadow-sm border border-gray-200 mt-6">
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4 sm:mb-6 tracking-tight">
                        Membership Plans
                    </h3>
                    <div v-for="membership in selectedMember.memberships" :key="membership.id"
                        class="grid grid-cols-1 gap-4 text-sm sm:text-base mb-4 sm:mb-6 last:mb-0">
                        <div
                            class="bg-white p-4 rounded-md border border-gray-200 shadow-sm flex items-center gap-3 transition-all duration-300 hover:shadow-md hover:border-gray-300">
                            <i class="fa-solid fa-id-card text-gray-700 text-base sm:text-lg"></i>
                            <p><span class="font-medium text-gray-700">Membership ID:</span> {{ membership.id }}</p>
                        </div>
                        <div
                            class="bg-white p-4 rounded-md border border-gray-200 shadow-sm flex items-center gap-3 transition-all duration-300 hover:shadow-md hover:border-gray-300">
                            <i class="fa-solid fa-list text-gray-700 text-base sm:text-lg"></i>
                            <p><span class="font-medium text-gray-700">Plan:</span> {{ membership.plan.name }}</p>
                        </div>
                        <div
                            class="bg-white p-4 rounded-md border border-gray-200 shadow-sm flex items-center gap-3 transition-all duration-300 hover:shadow-md hover:border-gray-300">
                            <i class="fa-solid fa-check-circle text-gray-700 text-base sm:text-lg"></i>
                            <p><span class="font-medium text-gray-700">Status: </span>
                                <span
                                    :class="membership.status === 'active' ? 'font-bold text-green-600' : 'text-red-600'">
                                    {{ membership.status.charAt(0).toUpperCase() + membership.status.slice(1) }}
                                </span>
                            </p>
                        </div>
                        <div
                            class="bg-white p-4 rounded-md border border-gray-200 shadow-sm flex items-center gap-3 transition-all duration-300 hover:shadow-md hover:border-gray-300">
                            <i class="fa-solid fa-ticket-alt text-gray-700 text-base sm:text-lg"></i>
                            <p><span class="font-medium text-gray-700">Sessions: </span> {{
                                membership.remaining_sessions ?? 'Open' }}</p>
                        </div>
                        <div
                            class="bg-white p-4 rounded-md border border-gray-200 shadow-sm flex items-center gap-3 transition-all duration-300 hover:shadow-md hover:border-gray-300">
                            <i class="fa-solid fa-calendar-day text-gray-700 text-base sm:text-lg"></i>
                            <p><span class="font-medium text-gray-700">Start:</span>
                                {{ new Date(membership.start_date).toLocaleDateString('en-US', {
                                    year: 'numeric', month:
                                'short', day: 'numeric' }) }}
                            </p>
                        </div>
                        <div
                            class="bg-white p-4 rounded-md border border-gray-200 shadow-sm flex items-center gap-3 transition-all duration-300 hover:shadow-md hover:border-gray-300">
                            <i class="fa-solid fa-calendar-times text-gray-700 text-base sm:text-lg"></i>
                            <p><span class="font-medium text-gray-700">End:</span>
                                {{ membership.end_date ? new Date(membership.end_date).toLocaleDateString('en-US', {
                                    year: 'numeric', month: 'short', day: 'numeric' }) : 'N/A' }}
                            </p>
                        </div>
                        <div
                            class="bg-white p-4 rounded-md border border-gray-200 shadow-sm flex items-center gap-3 transition-all duration-300 hover:shadow-md hover:border-gray-300">
                            <i class="fa-solid fa-sticky-note text-gray-700 text-base sm:text-lg"></i>
                            <p><span class="font-medium text-gray-700">Notes:</span> {{ membership.notes || 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <p v-else class="text-sm sm:text-base text-gray-700 text-center py-4">
                    No membership plans available.
                </p>
            </div>
            <div class="mt-6 flex justify-center">
                <button @click="$router.back()"
                    class="px-5 py-2.5 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all text-sm sm:text-base">
                    Back
                </button>
            </div>
        </div>
    </div>
</template>
