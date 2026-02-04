<script setup>
import { reactive, ref } from 'vue';
import axios from 'axios';
import { onMounted } from 'vue';
import { useToast } from 'vue-toastification';
import Spinner from '@/components/Spinner.vue';
import PageHeader from '@/components/PageHeader.vue';
import PlansTable from './components/PlansTable.vue';
import Modal from './components/Modal.vue';

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
    <PageHeader title="Plans" icon="fa-solid fa-layer-group" />

    <div class="p-6 overflow-x-auto mx-auto max-w-8xl">

        <!-- Loading Spinner -->
        <Spinner v-if="isLoading" class="flex justify-center items-center" />

        <!-- Search Bar -->
        <div class="mb-3 flex items-center justify-end gap-4" v-if="!isLoading">
            <button @click="openAddModal"
                class="relative bg-gray-800 text-white px-6 py-2 rounded-md font-medium shadow-md hover:shadow-lg hover:bg-black focus:outline-none focus:ring-2 focus:ring-bronze-400 transition-all duration-200 hover:bg-gradient-to-r cursor-pointer">
                Add New Plan
            </button>
        </div>

        <!-- Modal -->
        <Modal v-if="showModal" :showModal="showModal" :isEditMode="isEditMode" v-model:planData="planData"
            @close-modal="closeModal" @save-plan="createOrUpdatePlan" />

        <!-- Table -->
        <PlansTable :plans="plans" :isLoading="isLoading" @edit-plan="openEditModal" @delete-plan="deletePlan" />

    </div>
</template>