<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Spinner from '@/components/Spinner.vue';
import Chart from 'chart.js/auto';

const isLoading = ref(true);
const data = ref(null);

const membershipCards = [
    { title: "Members", valueKey: "total_members", icon: "fa-users", color: "bg-indigo-600" },
    { title: "Memberships", valueKey: "total_memberships", icon: "fa-id-card", color: "bg-teal-500" },
    { title: "Active Memberships", valueKey: "total_active_memberships", icon: "fa-check-circle", color: "bg-emerald-500" },
    { title: "Expired Memberships", valueKey: "total_expired_memberships", icon: "fa-exclamation-circle", color: "bg-rose-500" },
    { title: "Canceled Memberships", valueKey: "total_canceled_memberships", icon: "fa-times-circle", color: "bg-amber-500" },
    { title: "Frozen Memberships", valueKey: "total_frozen_memberships", icon: "fa-stopwatch", color: "bg-cyan-500" },
];

const paymentCards = [
    { title: "Payments Amount", valueKey: "total_payments_amount", icon: "fa-dollar-sign", color: "bg-emerald-600" },
];

const invoiceCards = [
    { title: "Paid Invoices", valueKey: "total_paid_invoices", icon: "fa-file-invoice-dollar", color: "bg-gray-600" },
    { title: "Unpaid Invoices", valueKey: "total_unpaid_invoices", icon: "fa-file-invoice", color: "bg-red-600" },
    { title: "Partial Invoices", valueKey: "total_partial_invoices", icon: "fa-file-invoice", color: "bg-orange-600" },
];

const revenueChartRef = ref(null);
const membershipsChartRef = ref(null);
const plansChartRef = ref(null);
const statusChartRef = ref(null);

const renderCharts = () => {
    if (!data.value || !data.value.charts) return;

    // 1️⃣ Monthly Revenue
    new Chart(revenueChartRef.value, {
        type: 'bar',
        data: {
            labels: data.value.charts.monthly_revenue.map(item => item.month),
            datasets: [{
                label: 'Monthly Revenue',
                data: data.value.charts.monthly_revenue.map(item => item.total),
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                fill: true
            }]
        }
    });

    // 2️⃣ New Memberships Per Month
    new Chart(membershipsChartRef.value, {
        type: 'line',
        data: {
            labels: data.value.charts.new_memberships_per_month.map(item => item.month),
            datasets: [{
                label: 'New Memberships',
                data: data.value.charts.new_memberships_per_month.map(item => item.count),
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: true,
            }]
        }
    });

    // 3️⃣ Subscriptions by Plan
    new Chart(plansChartRef.value, {
        type: 'doughnut',
        data: {
            labels: data.value.charts.subscriptions_by_plan.map(item => item.plan?.name),
            datasets: [{
                label: 'Subscriptions by Plan',
                data: data.value.charts.subscriptions_by_plan.map(item => item.count),
                backgroundColor: ['#4CAF50', '#FF9800', '#2196F3', '#9C27B0', '#FFC107']
            }]
        }
    });

    // 4️⃣ Subscriptions Status
    new Chart(statusChartRef.value, {
        type: 'pie',
        data: {
            labels: data.value.charts.subscriptions_status.map(item => item.status),
            datasets: [{
                label: 'Subscriptions Status',
                data: data.value.charts.subscriptions_status.map(item => item.count),
                backgroundColor: ['#4CAF50', '#F44336', '#FFC107']
            }]
        }
    });
};

const fetchData = async () => {
    try {
        isLoading.value = true;
        const response = await axios.get('/dashboard');
        data.value = response.data;
        renderCharts();
        console.log('API Response:', data.value);
    } catch (error) {
        console.error('Fetch error:', error);
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
        <h1 class="flex text-xl font-semibold text-gray-800 items-center">
            <i class="fa-solid fa-layer-group w-8 mr-3 text-"></i>
            Dashboard
        </h1>
    </header>


    <!-- Loading Spinner -->
    <Spinner v-if="isLoading" class="flex justify-center items-center" />

    <div class="mx-4 sm:mx-8 mt-8 mb-12">

        <!-- Membership Metrics Section - Enhanced styling -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 border-b-2 border-blue-100 pb-2 flex items-center">
                    <i class="fa-solid fa-users mr-3 text-blue-600"></i>
                    Membership Metrics
                </h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="(card, index) in membershipCards" :key="index"
                    class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-200 group relative overflow-hidden">
                    <!-- Subtle gradient overlay -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-white to-gray-50 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="flex items-center space-x-4 relative z-10">
                        <div class="p-4 rounded-xl shadow-sm transition-transform duration-200 group-hover:scale-105"
                            :class="card.color">
                            <i :class="`fa-solid ${card.icon} text-white text-2xl`"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">{{ card.title
                                }}</h3>
                            <p class="text-3xl font-bold text-gray-900">{{ data?.cards[card.valueKey] || 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Payment Metrics Section - Enhanced styling -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 border-b-2 border-green-100 pb-2 flex items-center">
                    <i class="fa-solid fa-dollar-sign mr-3 text-green-600"></i>
                    Payment Metrics
                </h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="(card, index) in paymentCards" :key="index"
                    class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-200 group relative overflow-hidden col-span-full">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-white to-gray-50 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="flex items-center space-x-4 relative z-10">
                        <div class="p-4 rounded-xl shadow-sm transition-transform duration-200 group-hover:scale-105"
                            :class="card.color">
                            <i :class="`fa-solid ${card.icon} text-white text-2xl`"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">{{ card.title
                                }}</h3>
                            <p class="text-3xl font-bold text-gray-900">${{ data?.cards[card.valueKey] || 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Invoice Metrics Section - Enhanced styling -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 border-b-2 border-purple-100 pb-2 flex items-center">
                    <i class="fa-solid fa-file-invoice mr-3 text-purple-600"></i>
                    Invoice Metrics
                </h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="(card, index) in invoiceCards" :key="index"
                    class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-200 group relative overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-white to-gray-50 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="flex items-center space-x-4 relative z-10">
                        <div class="p-4 rounded-xl shadow-sm transition-transform duration-200 group-hover:scale-105"
                            :class="card.color">
                            <i :class="`fa-solid ${card.icon} text-white text-2xl`"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">{{ card.title
                                }}</h3>
                            <p class="text-3xl font-bold text-gray-900">{{ data?.cards[card.valueKey] || 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12 ">
            <!-- Monthly Revenue -->
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 backdrop-blur-sm bg-opacity-95">
                <h3 class="text-xl font-bold text- mb-5 tracking-tight">Monthly Revenue</h3>
                <canvas ref="revenueChartRef"></canvas>
            </div>

            <!-- New Memberships -->
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 backdrop-blur-sm bg-opacity-95">
                <h3 class="text-xl font-bold text- mb-5 tracking-tight">New Memberships Per Month</h3>
                <canvas ref="membershipsChartRef"></canvas>
            </div>

            <!-- Subscriptions by Plan -->
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 backdrop-blur-sm bg-opacity-95">
                <h3 class="text-xl font-bold text- mb-5 tracking-tight">Subscriptions by Plan</h3>
                <canvas ref="plansChartRef"></canvas>
            </div>

            <!-- Subscriptions Status -->
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 backdrop-blur-sm bg-opacity-95">
                <h3 class="text-xl font-bold text- mb-5 tracking-tight">Subscriptions Status</h3>
                <canvas ref="statusChartRef"></canvas>
            </div>
        </div>

        <!-- Tables Section - Enhanced styling -->
        <section>
            <h2 class="text-2xl font-bold text-gray-900 mb-8 border-b-2 border-gray-200 pb-2 flex items-center">
                <i class="fa-solid fa-table mr-3 text-teal-600"></i>
                Recent Activity
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Members Table - Enhanced -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                            <i class="fa-solid fa-users mr-2 text-blue-600"></i>
                            Recent Members
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Phone</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" v-if="data && data.tables">
                                <tr v-for="member in data.tables.recent_members" :key="member.id"
                                    class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-mono text-gray-600">#{{ member.id }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                                <i class="fa-solid fa-user text-gray-600 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">{{ member.name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden sm:table-cell">
                                        {{ member.email || 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden md:table-cell">
                                        {{ member.phone_number || 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" :class="{
                                            'bg-green-100 text-green-800': member.status === 'allowed',
                                            'bg-red-100 text-red-800': member.status === 'banned'
                                        }">
                                            <i class="fa-solid mr-1 text-xs" :class="{
                                                'fa-check text-green-600': member.status === 'allowed',
                                                'fa-ban text-red-600': member.status === 'banned'
                                            }"></i>
                                            {{ member.status }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Memberships Table - Enhanced -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                            <i class="fa-solid fa-id-card mr-2 text-purple-600"></i>
                            Recent Memberships
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Member</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Plan</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Start Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" v-if="data && data.tables">
                                <tr v-for="membership in data.tables.recent_memberships" :key="membership.id"
                                    class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-mono text-gray-600">#{{ membership.id }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ membership.member.name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden sm:table-cell">
                                        {{ membership.plan.name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden md:table-cell">
                                        {{ membership.start_date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" :class="{
                                            'bg-green-100 text-green-800': membership.status === 'active',
                                            'bg-yellow-100 text-yellow-800': membership.status === 'frozen',
                                            'bg-red-100 text-red-800': membership.status === 'expired'
                                        }">
                                            <i class="fa-solid mr-1 text-xs" :class="{
                                                'fa-play text-green-600': membership.status === 'active',
                                                'fa-pause text-yellow-600': membership.status === 'frozen',
                                                'fa-clock text-red-600': membership.status === 'expired'
                                            }"></i>
                                            {{ membership.status }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Payments Table - Enhanced -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                            <i class="fa-solid fa-credit-card mr-2 text-green-600"></i>
                            Recent Payments
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Payment Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Method</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" v-if="data && data.tables">
                                <tr v-for="payment in data.tables.recent_payments" :key="payment.id"
                                    class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-mono text-gray-600">#{{ payment.id }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-semibold text-gray-900">${{ payment.amount }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden sm:table-cell">
                                        {{ payment.payment_date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden md:table-cell">
                                        {{ payment.method }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Invoices Table - Enhanced -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                            <i class="fa-solid fa-file-invoice-dollar mr-2 text-purple-600"></i>
                            Recent Invoices
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" v-if="data && data.tables">
                                <tr v-for="invoice in data.tables.recent_invoices" :key="invoice.id"
                                    class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-mono text-gray-600">#{{ invoice.id }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900">{{ invoice.number }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden sm:table-cell">
                                        ${{ invoice.total_amount }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" :class="{
                                            'bg-green-100 text-green-800': invoice.status === 'paid',
                                            'bg-red-100 text-red-800': invoice.status !== 'paid'
                                        }">
                                            <i class="fa-solid mr-1 text-xs" :class="{
                                                'fa-check text-green-600': invoice.status === 'paid',
                                                'fa-times text-red-600': invoice.status !== 'paid'
                                            }"></i>
                                            {{ invoice.status }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

    </div>
</template>
