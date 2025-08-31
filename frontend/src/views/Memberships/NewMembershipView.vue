<script setup>

import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import Spinner from '@/components/Spinner.vue';

const toast = useToast();
const isLoading = ref(false);

const members = ref([]);
const plans = ref([]);

const form = ref({
    member_id: '',
    plan_id: '',
    duration: 30,
    amount: 0,
    payment_method: 'cash',
    note: '',
    total_amount: 0,
    status: 'paid',
    errors: {}
});

// fetch data
const fetchData = async () => {
    try {
        const membersResponse = await axios.get('/member');
        const plansResponse = await axios.get('/plans');
        members.value = membersResponse.data;
        plans.value = plansResponse.data.data;
        console.log(members.value);
        console.log(plans.value);
    } catch (error) {
        console.log(error);
        toast.error('Failed to fetch data.');
    }
};

// submit form
const createMembership = async () => {
    try {
        isLoading.value = true;
        form.value.errors = {};
        await axios.post('/memberships', form.value);
        toast.success('Membership created successfully!');
    } catch (error) {
        console.log(error);
        if (error.response?.status === 422) {
            form.value.errors = error.response.data.errors;
        } else {
            toast.error('Failed to create membership.');
        }
    } finally {
        isLoading.value = false;
    }
};


onMounted(() => {
    fetchData();
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
            New Membership
        </h1>
    </header>

    <!-- Main Content -->
    <main>
        <div class="mx-auto max-w-8xl p-4 md:p-6">

            <form @submit.prevent="createMembership">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div class="rounded-2xl border border-gray-200 bg-white">
                            <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6">

                                <!-- Name Input -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Member</label>
                                    <select v-model="form.member_id" id="member_id"
                                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none"
                                        :class="{ 'border-red-700': form.errors.member_id }">
                                        <option value="selected" selected disabled>Select Option</option>
                                        <option v-for="member in members" :value="member.id">{{ member.name }}</option>
                                    </select>
                                    <div v-if="form.errors.member_id" class="error">
                                        <p class="text-sm text-red-700">{{ form.errors.member_id[0] }}</p>
                                    </div>
                                </div>

                                <!-- Plan Select Input -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Plan</label>
                                    <div class="relative">
                                        <select v-model="form.plan_id"
                                            class="h-11 w-full  rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none"
                                            :class="{ 'border-red-700': form.errors.plan_id }">
                                            <option value="selected" selected disabled>Select Option</option>
                                            <option v-for="plan in plans" :value="plan.id">{{ plan.name }}</option>
                                        </select>
                                    </div>
                                    <div v-if="form.errors.plan_id" class="error">
                                        <p class="text-sm text-red-700">{{ form.errors.plan_id[0] }}</p>
                                    </div>
                                </div>

                                <!-- Duration Input -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Duration</label>
                                    <div class="relative">
                                        <input v-model="form.duration" type="number" placeholder="Enter duration"
                                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none"
                                            :class="{ 'border-red-700': form.errors.duration }" />
                                        <div v-if="form.errors.duration" class="error">
                                            <p class="text-sm text-red-700">{{ form.errors.duration[0] }}</p>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Select Inputs -->
                        <div class="rounded-2xl border border-gray-200 bg-white">
                            <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6">

                                <!-- Payment Method Select Input -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Payment Method</label>
                                    <select v-model="form.payment_method" placeholder="Enter Payment Method"
                                        id="payment_method"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none"
                                        :class="{ 'border-red-700': form.errors.payment_method }">
                                        <option value="cash" selected>Cash</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <div v-if="form.errors.payment_method" class="error">
                                        <p class="text-sm text-red-700">{{ form.errors.payment_method[0] }}</p>
                                    </div>
                                </div>

                                <!-- Amount Input -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Amount</label>
                                    <input v-model="form.amount" type="text" placeholder="Enter Amount"
                                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none"
                                        :class="{ 'border-red-700': form.errors.amount }" />
                                    <div v-if="form.errors.amount" class="error">
                                        <p class="text-sm text-red-700">{{ form.errors.amount[0] }}</p>
                                    </div>
                                </div>

                                <!-- Status Select Input -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Status</label>
                                    <select v-model="form.status" id="status"
                                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none"
                                        :class="{ 'border-red-700': form.errors.status }">
                                        <option value="selected" selected disabled>Select Option</option>
                                        <option value="paid">Paid</option>
                                        <option value="unpaid">Unpaid</option>
                                        <option value="partial">Partial</option>
                                        <option value="canceled">Canceled</option>
                                    </select>
                                    <div v-if="form.errors.status" class="error">
                                        <p class="text-sm text-red-700">{{ form.errors.status[0] }}</p>
                                    </div>
                                </div>

                                <!-- Total Amount Input -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Total Amount</label>
                                    <input v-model="form.total_amount" type="text" placeholder="Enter Total Amount"
                                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none"
                                        :class="{ 'border-red-700': form.errors.total_amount }" />
                                    <div v-if="form.errors.total_amount" class="error">
                                        <p class="text-sm text-red-700">{{ form.errors.total_amount[0] }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <!-- submit button center pro style -->
                <div class="mt-6 flex justify-center">
                    <button type="submit" :disabled="isLoading" :class="{ 'opacity-50 cursor-not-allowed': isLoading }"
                        class="inline-flex w-full max-w-sm cursor-pointer items-center justify-center rounded-lg border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                        Add Member
                    </button>
                </div>

            </form>

        </div>
    </main>

</template>