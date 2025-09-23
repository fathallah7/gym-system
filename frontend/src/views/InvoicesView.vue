<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
import { onMounted } from 'vue';
import { useToast } from 'vue-toastification';
import Spinner from '@/components/Spinner.vue';
import Pagination from '@/components/Pagination.vue';
import PageHeader from '@/components/PageHeader.vue';

const isLoading = ref(false);
const toast = useToast();
const showPartialModal = ref(false);

const selectedInvoiceData = ref(null);

const invoices = ref([]);
const meta = ref({})

const search = ref('');

const updateData = ref({
    amount: '',
    payment_method: '',
    status: '',
    errors: {}
});

const fetchInvoices = async (page, term = '') => {
    try {
        isLoading.value = true;
        const response = await axios.get('/invoices', {
            params: {
                page: page,
                search: term
            }
        });
        invoices.value = response.data.data;
        if (response.data.meta) {
            meta.value = response.data.meta;
        } else {
            meta.value = {
                current_page: response.data.current_page,
                last_page: response.data.last_page,
                total: response.data.total,
            };
        }
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
    updateData.value.errors = {};
    showPartialModal.value = false;
};

const update = async () => {
    try {
        updateData.value.errors = {};
        const response = await axios.put(`/invoices/${selectedInvoiceData.value.id}`, updateData.value);
        toast.success('Payment added successfully!');
        fetchInvoices();
        closeModal();
    } catch (error) {
        console.log(error);
        if (error.response && error.response.status === 422) {
            updateData.value.errors = error.response.data.errors;
        }
    } finally {
        isLoading.value = false;
    }
};

watch(search, (newVal) => {
    fetchInvoices(1, newVal)
})

onMounted(() => {
    fetchInvoices(1, '');
});

</script>


<template>

    <!-- Header -->
    <PageHeader title="Invoices" icon="fa-solid fa-credit-card" />


    <!-- Modal -->
    <div v-if="showPartialModal"
        class="fixed p-5 inset-0 bg-black/50 bg-opacity-60 flex items-center justify-center z-50 transition-opacity duration-300"
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
                <!-- Amount -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pay Amount</label>
                    <input type="number" v-model="updateData.amount"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                        :class="{ 'border-red-500': updateData.errors.amount }" placeholder="Enter The amount" />
                    <p v-if="updateData.errors.amount" class="text-red-500 text-sm mt-1">{{ updateData.errors.amount[0]
                    }}</p>
                </div>
                <!-- Payment Method -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Method</label>
                    <select name="type" id="type" v-model="updateData.payment_method"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                        :class="{ 'border-red-500': updateData.errors.payment_method }">
                        <option value="" disabled selected>Select Payment Method</option>
                        <option value="cash">Cash</option>
                        <option value="other">Other</option>
                    </select>
                    <p v-if="updateData.errors.payment_method" class="text-red-500 text-sm mt-1">{{
                        updateData.errors.payment_method[0] }}</p>
                </div>
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="type" id="type" v-model="updateData.status"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                        :class="{ 'border-red-500': updateData.errors.status }">
                        <option value="" disabled selected>Select Invoice Status</option>
                        <option value="paid">Paid</option>
                        <option value="partial">Partial</option>
                        <option value="canceled">Canceled</option>
                    </select>
                    <p v-if="updateData.errors.status" class="text-red-500 text-sm mt-1">{{ updateData.errors.status[0]
                    }}</p>
                </div>
            </div>
            <div class="mt-4 flex justify-end gap-4">
                <button @click="closeModal" :disabled="isLoading"
                    :class="{ 'opacity-50 cursor-not-allowed': isLoading }"
                    class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors">
                    Cancel
                </button>
                <button @click="update" :disabled="isLoading" :class="{ 'opacity-50 cursor-not-allowed': isLoading }"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                    Add
                </button>
            </div>
        </div>
    </div>


    <div class="p-6 overflow-x-auto mx-auto max-w-8xl">
        <!-- Search Bar -->
        <div class="mb-6 flex items-center justify-between gap-4">
            <input v-model="search" type="text" placeholder="Search projects..."
                class="w-full max-w-md rounded-lg border border-gray-400 px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black"
                aria-label="Search projects" />
        </div>

        <!-- Table -->
        <div class="overflow-hidden rounded-xl shadow-sm bg-white" v-if="!isLoading">
            <!-- Table for larger screens -->
            <table class="w-full table-auto text-left hidden sm:table">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-sm font-medium text-gray-700 text-center">Number</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Total</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden md:table-cell">Amount Paid</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden lg:table-cell">Payment Date</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden lg:table-cell">Status</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden xl:table-cell">Membership ID</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden xl:table-cell">Member Name</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <Spinner v-if="isLoading" class="flex justify-center items-center" />
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors" v-for="invoice in invoices"
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
                        <td class="p-4 hidden md:table-cell">
                            <p class="text-sm text-gray-900">
                                {{ invoice.payments_sum_amount ?? '0' }}
                            </p>
                        </td>
                        <td class="p-4 hidden lg:table-cell">
                            <p class="text-sm text-gray-900">
                                {{ invoice.payments && invoice.payments.length > 0 ? invoice.payments[0].payment_date :
                                    'N/A' }}
                            </p>
                        </td>
                        <td class="p-4 hidden lg:table-cell">
                            <span
                                class="inline-block rounded-md bg-green-100 text-green-700 px-2 py-1 text-xs font-semibold uppercase"
                                :class="{
                                    'bg-red-100 text-red-700': invoice.status === 'canceled' || invoice.status === 'unpaid',
                                    'bg-yellow-100 text-yellow-700': invoice.status === 'partial',
                                    'bg-green-100 text-green-700': invoice.status === 'paid'
                                }">
                                {{ invoice.status }}
                            </span>
                            <button v-if="invoice.status === 'partial' || invoice.status === 'unpaid'"
                                @click="openPartialModal(invoice)"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fa-solid fa-rotate"></i>
                            </button>
                        </td>
                        <td class="p-4 hidden xl:table-cell">
                            <p class="text-sm text-gray-900">{{ invoice.membership?.id ?? 'N/A' }}</p>
                        </td>
                        <td class="p-4 hidden xl:table-cell">
                            <p class="text-sm text-gray-900">{{ invoice.membership?.member?.name ?? 'N/A' }}</p>
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

            <!-- Card layout for mobile -->
            <div class="sm:hidden divide-y divide-gray-300">
                <div class="p-4 bg-gradient-to-b from-gray-50 to-white border border-gray-200 rounded-xl shadow-lg mb-4 hover:shadow-xl transition-shadow duration-300"
                    v-for="invoice in invoices" :key="invoice.id">
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex items-center gap-3">
                            <div>
                                <p class="text-base font-bold text-gray-800 tracking-tight">{{ invoice.number }}</p>
                                <p class="text-xs text-gray-500">Invoice ID: {{ invoice.id }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button v-if="invoice.status === 'partial' || invoice.status === 'unpaid'"
                                @click="openPartialModal(invoice)"
                                class="rounded-md px-3 py-1 bg-blue-900 text-white text-sm font-medium hover:bg-blue-950 focus:outline-none focus:ring-2 focus:ring-blue-700 transition-colors duration-200"
                                title="Update Payment">
                                <i class="fa-solid fa-rotate"></i>
                            </button>
                            <button
                                class="rounded-md px-3 py-1 bg-blue-900 text-white text-sm font-medium hover:bg-blue-950 focus:outline-none focus:ring-2 focus:ring-blue-700 transition-colors duration-200"
                                title="Print Invoice">
                                <i class="fa-solid fa-print"></i>
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-2">
                        <p class="text-sm font-medium text-gray-700">
                            Total: <span class="text-gray-900">{{ invoice.total_amount || 'N/A' }}</span>
                        </p>
                        <p class="text-sm font-medium text-gray-700">
                            Amount Paid: <span class="text-gray-900">{{ invoice.payments_sum_amount ?? '0' }}</span>
                        </p>
                        <p class="text-sm font-medium text-gray-700">
                            Payment Date: <span>{{ invoice.payments && invoice.payments.length > 0 ?
                                invoice.payments[0].payment_date : 'N/A' }}</span>
                        </p>
                        <p class="text-sm font-medium text-gray-700">
                            Status:
                            <span
                                class="inline-block rounded-md px-2 py-1 text-xs font-semibold uppercase bg-amber-100 text-amber-800"
                                :class="{
                                    'bg-red-100 text-red-800': invoice.status === 'canceled' || invoice.status === 'unpaid',
                                    'bg-amber-100 text-amber-800': invoice.status === 'partial',
                                    'bg-green-100 text-green-800': invoice.status === 'paid'
                                }">
                                {{ invoice.status }}
                            </span>
                        </p>
                        <p class="text-sm font-medium text-gray-700">
                            Membership ID: <span>{{ invoice.membership?.id ?? 'N/A' }}</span>
                        </p>
                        <p class="text-sm font-medium text-gray-700">
                            Member Name: <span>{{ invoice.membership?.member?.name ?? 'N/A' }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <Pagination v-if="meta && meta.last_page" :meta="meta" @page-changed="fetchInvoices" />

</template>


<style scoped></style>