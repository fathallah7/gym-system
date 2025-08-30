<script setup>
import { reactive, ref } from 'vue';
import axios from 'axios';
import { onMounted } from 'vue';
import { useToast } from 'vue-toastification';
import Spinner from '@/components/Spinner.vue';

const isLoading = ref(false);
const toast = useToast();
const showModal = ref(false);
const isEditMode = ref(false);

const planData = reactive({
    name: '',
    type: '',
    sessions: null,
    duration: '',
    price: null,
    errors: {}
});
const plans = ref([]);
const selectedPlanId = ref(null);

const fetchPlans = async () => {
    try {
        isLoading.value = true;
        const response = await axios.get('/plans');
        plans.value = response.data.data;
    } catch (error) {
        console.log(error);
        toast.error('Failed to fetch plans.');
    } finally {
        isLoading.value = false;
    }
};

const openAddModal = () => {
    isEditMode.value = false;
    Object.assign(planData, { name: '', type: '', sessions: null, duration: '', price: null });
    showModal.value = true;
};

const openEditModal = (plan) => {
    isEditMode.value = true;
    selectedPlanId.value = plan.id;
    Object.assign(planData, {
        name: plan.name,
        type: plan.type,
        sessions: plan.sessions,
        duration: plan.duration,
        price: plan.price
    });
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    planData.errors = {};
};

const createOrUpdatePlan = async () => {
    try {
        planData.errors = {};
        if (isEditMode.value) {
            const response = await axios.put(`/plans/${selectedPlanId.value}`, planData);
            toast.success('Plan updated successfully!');
        } else {
            const response = await axios.post('/plans', planData);
            toast.success(response.data.message);
        }
        fetchPlans();
        closeModal();
    } catch (error) {
        if (error.response && error.response.status === 422) {
            planData.errors = error.response.data.errors;
        } else {
            toast.error(isEditMode.value ? 'Failed to update plan.' : 'Failed to create plan.');
        }
    } finally {
        isLoading.value = false;
    }
};

const deletePlan = async (id) => {
    if (confirm('Are you sure you want to delete this plan?')) {
        try {
            await axios.delete(`/plans/${id}`);
            toast.success('Plan deleted successfully!');
            fetchPlans();
        } catch (error) {
            toast.error('Failed to delete plan.');
        }
        finally {
            isLoading.value = false;
        }
    }
};

onMounted(() => {
    fetchPlans();
});
</script>

<template>
    <!-- Header -->
    <header class="bg-white shadow p-4 max-w-8xl items-center mx-auto">
        <h1 class="flex items-center text-xl font-semibold text-gray-800">
            <i class="fa-solid fa-layer-group w-6 mr-2 text-gray-600"></i>
            Plans
        </h1>
    </header>

    <div class="p-6 overflow-x-auto mx-auto max-w-8xl">
        <Spinner v-if="isLoading" class="flex justify-center items-center" />

        <!-- Search Bar -->
        <div class="mb-3 flex items-center justify-end gap-4" v-if="!isLoading">
            <button @click="openAddModal"
                class="relative bg-gray-800 text-white px-6 py-2 rounded-md font-medium shadow-md hover:shadow-lg hover:bg-black focus:outline-none focus:ring-2 focus:ring-bronze-400 transition-all duration-200 hover:bg-gradient-to-r cursor-pointer">
                Add New Plan
            </button>
        </div>

        <!-- Modal -->
        <div v-if="showModal"
            class="fixed inset-0 bg-black/50 bg-opacity-60 flex items-center justify-center z-50 transition-opacity duration-300"
            :class="{ 'opacity-100': showModal, 'opacity-0': !showModal }">
            <div
                class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ isEditMode ? 'Edit Plan' : 'Add New Plan' }}
                    </h2>
                    <button @click="closeModal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i class="fa-solid fa-times text-xl"></i>
                    </button>
                </div>
                <div class="space-y-5">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Plan Name</label>
                        <input v-model="planData.name" type="text"
                            class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                            :class="{ 'border-red-500': planData.errors.name }" placeholder="Enter plan name" />
                        <div v-if="planData.errors.name" class="text-red-600 text-sm mt-1">
                            {{ planData.errors.name[0] }}
                        </div>
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="type" id="type"
                            class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                            v-model="planData.type">
                            <option value="" disabled>Select plan type</option>
                            <option value="open">Open</option>
                            <option value="sessions">Sessions</option>
                        </select>
                        <div v-if="planData.errors.type" class="text-red-600 text-sm mt-1">
                            {{ planData.errors.type[0] }}
                        </div>
                    </div>

                    <!-- Sessions -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sessions</label>
                        <input v-model.number="planData.sessions" type="number"
                            class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                            :class="{ 'border-red-500': planData.errors.sessions }"
                            placeholder="Enter number of sessions" />
                        <div v-if="planData.errors.sessions" class="text-red-600 text-sm mt-1">
                            {{ planData.errors.sessions[0] }}
                        </div>
                    </div>

                    <!-- Duration -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Duration (days)</label>
                        <input v-model="planData.duration" type="number"
                            class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                            :class="{ 'border-red-500': planData.errors.duration }" placeholder="Enter duration" />
                        <div v-if="planData.errors.duration" class="text-red-600 text-sm mt-1">
                            {{ planData.errors.duration[0] }}
                        </div>
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                        <input v-model.number="planData.price" type="number"
                            class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                            :class="{ 'border-red-500': planData.errors.price }" placeholder="Enter price" />
                        <div v-if="planData.errors.price" class="text-red-600 text-sm mt-1">
                            {{ planData.errors.price[0] }}
                        </div>
                    </div>
                </div>
                <div class="mt-8 flex justify-end gap-4">
                    <button @click="closeModal" :disabled="isLoading"
                        :class="{ 'opacity-50 cursor-not-allowed': isLoading }"
                        class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors">
                        Cancel
                    </button>
                    <button @click="createOrUpdatePlan" :disabled="isLoading"
                        :class="{ 'opacity-50 cursor-not-allowed': isLoading }"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                        {{ isEditMode ? 'Update' : 'Create' }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-hidden rounded-xl shadow-sm bg-white" v-if="!isLoading">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-sm font-medium text-gray-700 text-center">ID</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Plan</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Type</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Sessions</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Duration</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Price</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100 hover:bg-gray-100 transition-colors" v-for="plan in plans"
                        :key="plan.id">
                        <td class="p-2 text-center bg-gray-100">
                            <p class="text-sm text-gray-900">{{ plan.id }}</p>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">{{ plan.name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">{{ plan.type }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span
                                class="inline-block rounded-md bg-green-100 text-green-700 px-2 py-1 text-xs font-semibold uppercase">
                                {{ plan.sessions }}
                            </span>
                        </td>
                        <td class="p-4">
                            <p class="text-sm text-gray-900">{{ plan.duration }} days</p>
                        </td>
                        <td class="p-4">
                            <p class="text-sm text-gray-900">{{ plan.price }}</p>
                        </td>
                        <td class="p-4">
                            <button @click="openEditModal(plan)"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button @click="deletePlan(plan.id)"
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

<style scoped>
/* Smooth modal transitions */
.scale-100 {
    transform: scale(1);
}

.scale-0 {
    transform: scale(0.95);
}
</style>