<script setup>
import { reactive, ref } from 'vue';
import axios from 'axios';
import { onMounted } from 'vue';
import { useToast } from 'vue-toastification';
import Spinner from '@/components/Spinner.vue';
import Pagination from '@/components/Pagination.vue';

const isLoading = ref(false);
const toast = useToast();
const showModal = ref(false);

const memberships = ref();
const membershipStatusData = ref();
const memberID = ref();
const meta = ref({});

const fetchMemberships = async (page) => {
    try {
        isLoading.value = true;
        const response = await axios.get('/memberships',
            {
                params: {
                    page: page
                }
            }
        );
        console.log(response.data);
        memberships.value = response.data.data;

        if (response.data.meta) {
            meta.value = response.data.meta;
        } else {
            meta.value = {
                current_page: response.data.current_page,
                last_page: response.data.last_page,
                total: response.data.total,
            };
        }
    } catch (error) {
        console.log(error);
        toast.error('Failed to fetch memberships.');
    } finally {
        isLoading.value = false;
    }
};

const memberUpdateStatus = async () => {
    try {
        await axios.put(`/memberships/${memberID.value}`, {
            status: membershipStatusData.value,
        });
        toast.success('Membership status updated successfully.');
        fetchMemberships();
        isLoading.value = false;
        closeModal();
    } catch (error) {
        console.log(error);
        toast.error('Failed to update membership status.');
    }
};

const deleteMembership = async (id) => {
    if (confirm('Are You Sure For Delete This Membership')) {
        try {
            await axios.delete(`/memberships/${id}`);
            toast.success('Membership deleted successfully.');
            fetchMemberships();
            isLoading.value = false;
        } catch (error) {
            console.log(error);
            toast.error('Failed to delete membership.');
        }
    }
}

const attendance = async (id, name) => {
    try {
        await axios.put(`/memberships/${id}/attendance`);
        toast.success(`Attendance recorded successfully for ${name}.`);
        fetchMemberships();
        isLoading.value = false;
    } catch (error) {
        console.log(error);
        toast.error(`Failed to record attendance for ${name}.`);
    }
};

const openEditModal = (member) => {
    showModal.value = true;
    membershipStatusData.value = member.status;
    memberID.value = member.id;
};

const closeModal = () => {
    showModal.value = false;
};

onMounted(() => {
    fetchMemberships(1);
});
</script>

<template>
    <!-- Header -->
    <header class="bg-white shadow p-4 max-w-8xl items-center mx-auto">
        <h1 class="flex items-center text-xl font-semibold text-gray-800">
            <i class="fa-solid fa-id-card w-6 mr-2 text-gray-600"></i>
            Memberships
        </h1>
    </header>

    <div class="p-6 overflow-x-auto mx-auto max-w-8xl">

        <!-- Search Bar -->
        <div class="mb-3 flex items-center justify-between gap-4">
            <input type="text" placeholder="Search projects..."
                class="w-full max-w-md rounded-lg border border-gray-400 px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black"
                aria-label="Search projects" />

            <RouterLink to="/new-membership"
                class="relative bg-gray-800 text-white px-6 py-2 rounded-md font-medium shadow-md hover:shadow-lg hover:bg-black focus:outline-none focus:ring-2 focus:ring-bronze-400 transition-all duration-200 hover:bg-gradient-to-r cursor-pointer">
                Make Membership
            </RouterLink>
        </div>

        <!-- Modal -->
        <div v-if="showModal"
            class="fixed inset-0 bg-black/50 bg-opacity-60 flex items-center justify-center z-50 transition-opacity duration-300"
            :class="{ 'opacity-100': showModal, 'opacity-0': !showModal }">
            <div
                class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Edit Status
                    </h2>
                    <button @click="closeModal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i class="fa-solid fa-times text-xl"></i>
                    </button>
                </div>
                <div class="space-y-5">
                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="type" id="type"
                            class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                            v-model="membershipStatusData">
                            <option value="" disabled>Select plan type</option>
                            <option value="active">Active</option>
                            <option value="expired">Expired</option>
                            <option value="canceled">Canceled</option>
                            <option value="frozen">Frozen</option>
                        </select>
                        <!-- <div v-if="planData.errors.type" class="text-red-600 text-sm mt-1">
                            {{ planData.errors.type[0] }}
                        </div> -->
                    </div>
                </div>
                <div class="mt-8 flex justify-end gap-4">
                    <button @click="closeModal" :disabled="isLoading"
                        :class="{ 'opacity-50 cursor-not-allowed': isLoading }"
                        class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors">
                        Cancel
                    </button>
                    <button @click="memberUpdateStatus" :disabled="isLoading"
                        :class="{ 'opacity-50 cursor-not-allowed': isLoading }"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                        {{ isEditMode ? 'Update' : 'Create' }}
                    </button>
                </div>
            </div>
        </div>

        <Spinner v-if="isLoading" class="flex justify-center items-center" />
        <!-- Table -->
        <div class="overflow-hidden rounded-xl shadow-sm bg-white" v-if="!isLoading">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-sm font-medium text-gray-700 text-center">ID</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Member</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Plane</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Remaining Sessions</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">End Date</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100 hover:bg-gray-100 transition-colors"
                        v-for="member in memberships" :key="member.id">
                        <td class="p-2 text-center bg-gray-100">
                            <p class="text-sm text-gray-900">{{ member.id }}</p>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">{{ member.member.name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">{{ member.plan?.name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900"
                                        :class="{ 'text-red-600': member.remaining_sessions === 0 }">
                                        {{ member.remaining_sessions }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="inline-block rounded-md ">
                                {{ member.end_date }}
                            </span>
                        </td>
                        <td class="p-4">
                            <p class="text-gray-900 inline-block rounded-md px-2 py-1 text-xs font-semibold uppercase"
                                :class="{ 'bg-red-100 text-red-700': member.status === 'expired', 'bg-green-100 text-green-700 ': member.status === 'active', 'bg-yellow-100 text-yellow-700': member.status === 'frozen' }">
                                {{ member.status }}</p>
                        </td>
                        <td class="p-4">
                            <button @click="attendance(member.id, member.member.name)"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fa-solid fa-square-check"></i>
                            </button>
                            <button @click="openEditModal(member)"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button @click="deleteMembership(member.id)"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <Pagination v-if="meta && meta.last_page" :meta="meta" @page-changed="fetchMemberships" />

</template>

<style scoped>
/* Smooth modal transitions */
.scale-100 {
    transform: scale(1);
}

.scale-0 {
    transform: scale(0.95);
}
</style>