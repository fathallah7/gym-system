<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { onMounted } from 'vue';
import { useToast } from 'vue-toastification';
import Spinner from '@/components/Spinner.vue';

const isLoading = ref(false);
const toast = useToast();
const showPartialModal = ref(false);

const selectedInvoiceData = ref(null);

const invoices = ref([]);




const fetchInvoices = async () => {
    try {
        isLoading.value = true;
        const response = await axios.get('/invoices');
        invoices.value = response.data;
        console.log('invoices fetched successfully:', invoices.value);
    } catch (error) {
        console.log(error);
    } finally {
        isLoading.value = false;
    }
};

const openPartialModal = (data) => {
    selectedInvoiceData.value = data;
    showPartialModal.value = true;
};

const closeModal = () => {
    showPartialModal.value = false;
};

onMounted(() => {
    fetchInvoices();
});

</script>


<template>

    <!-- Header -->
    <header class="bg-white shadow p-4 max-w-8xl items-center mx-auto ">
        <h1 class="flex text-xl font-semibold text-gray-800 items-center">
            <i class="fa-solid fa-credit-card w-6 mr-2 text-gray-600"></i>
            Invoices
        </h1>
    </header>


    <!-- Modal -->
    <div v-if="showPartialModal"
        class="fixed inset-0 bg-black/50 bg-opacity-60 flex items-center justify-center z-50 transition-opacity duration-300"
        :class="{ 'opacity-100': showPartialModal, 'opacity-0': !showPartialModal }">
        <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-100">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">{{ selectedInvoiceData.number }}
                </h2>
                <button @click="closeModal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            <div class="space-y-2">
                <!-- Table -->
                <div class="overflow-hidden rounded-xl shadow-sm bg-white">
                    <table class="w-full table-auto text-left">
                        <thead class="bg-gray-100" v-if="!isLoading">
                            <tr>
                                <th class="px-6 py-4 text-sm font-medium text-gray-700">Amount</th>
                                <th class="px-6 py-4 text-sm font-medium text-gray-700">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <Spinner v-if="isLoading" class="flex justify-center items-center" />
                            <tr class="border-b border-gray-200 hover:bg-gray-100 transition-colors"
                                v-for="payment in selectedInvoiceData.payments" :key="payment.id">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <p class="text-sm font-bold">{{ payment.amount }}</p>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <p class="text-sm text-gray-900">{{ payment.payment_date }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="font-bold text-red-900">Total Needed : {{ selectedInvoiceData.total_amount }}</p>
                <!-- Sessions -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pay Amount</label>
                    <input type="number"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                        placeholder="Enter The amount" />
                </div>
                <!-- Payment Method -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Method</label>
                    <select name="type" id="type"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors">
                        <option value="" disabled selected>Select Invoice Status</option>
                        <option value="cash">Cash</option>
                        <option value="other">Partial</option>
                    </select>
                </div>
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="type" id="type"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors">
                        <option value="" disabled selected>Select Invoice Status</option>
                        <option value="paid">Paid</option>
                        <option value="partial">Partial</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 flex justify-end gap-4">
                <button @click="closeModal" :disabled="isLoading"
                    :class="{ 'opacity-50 cursor-not-allowed': isLoading }"
                    class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors">
                    Cancel
                </button>
                <button @click="createOrUpdatePlan" :disabled="isLoading"
                    :class="{ 'opacity-50 cursor-not-allowed': isLoading }"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                    Add
                </button>
            </div>
        </div>
    </div>


    <div class="p-6 overflow-x-auto mx-auto max-w-8xl">
        <!-- Search Bar -->
        <div class="mb-6 flex items-center justify-between gap-4">
            <input type="text" placeholder="Search projects..."
                class="w-full max-w-md rounded-lg border border-gray-400 px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black"
                aria-label="Search projects" />
        </div>
        <!-- Table -->
        <div class="overflow-hidden rounded-xl shadow-sm bg-white">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-100" v-if="!isLoading">
                    <tr>
                        <th class="px-4 py-2 text-sm font-medium text-gray-700 text-center">Number</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Total</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Amount Paid</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Payment Date</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Membership ID </th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Member Name</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <Spinner v-if="isLoading" class="flex justify-center items-center" />

                    <tr class="border-b border-gray-200 hover:bg-gray-100 transition-colors" v-for="invoice in invoices"
                        :key="invoice.id">

                        <td class="p-2 text-center bg-gray-100">
                            <p class="text-sm text-gray-900">{{ invoice.number }}</p>
                        </td>

                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">{{ invoice.total_amount }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="p-4">
                            <p class="text-sm text-gray-900">
                                {{ invoice.payments_sum_amount ?? '0'
                                }}
                            </p>
                        </td>

                        <td class="p-4">
                            <p class="text-sm text-gray-900">
                                {{ invoice.payments && invoice.payments.length > 0 ? invoice.payments[0].payment_date :
                                    'N/A' }}
                            </p>
                        </td>

                        <td class="p-4">
                            <span
                                class="inline-block rounded-md bg-green-100 text-green-700 px-2 py-1 text-xs font-semibold uppercase"
                                :class="{
                                    'bg-red-100 text-red-700': invoice.status === 'canceled',
                                    'bg-yellow-100 text-yellow-700': invoice.status === 'partial',
                                    'bg-red-100 text-red-700': invoice.status === 'unpaid',
                                    'bg-green-100 text-green-700': invoice.status === 'paid',
                                }">
                                {{ invoice.status }}
                            </span>
                            <button v-if="invoice.status === 'partial' || invoice.status === 'unpaid'"
                                @click="openPartialModal(invoice)"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fa-solid fa-rotate"></i>
                            </button>
                        </td>

                        <td class="p-4">
                            <p class="text-sm text-gray-900"> {{ invoice.membership?.id ?? 'N/A' }} </p>
                        </td>

                        <td class="p-4">
                            <p class="text-sm text-gray-900"> {{ invoice.membership?.member?.name ?? "N/A" }} </p>
                        </td>

                        <td class="p-4">
                            <button
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fa-solid fa-print"></i>
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>


</template>


<style scoped></style>