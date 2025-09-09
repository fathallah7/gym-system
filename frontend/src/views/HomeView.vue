    <script setup>
    import { ref, onMounted } from 'vue';
    import axios from 'axios';
    import Spinner from '@/components/Spinner.vue';
    import Chart from 'chart.js/auto';

    const isLoading = ref(true);

    const data = ref(null);

    const cards = [
        {
            title: "Members",
            valueKey: "total_members",
            icon: "fa-users",
            color: "bg-blue-500 text-white",
        },
        {
            title: "Memberships",
            valueKey: "total_memberships",
            icon: "fa-id-card",
            color: "bg-green-500 text-white",
        },
        {
            title: "Active Memberships",
            valueKey: "total_active_memberships",
            icon: "fa-check-circle",
            color: "bg-green-700 text-white",
        },
        {
            title: "Expired Memberships",
            valueKey: "total_expired_memberships",
            icon: "fa-exclamation-circle",
            color: "bg-red-700 text-white",
        },
        {
            title: "Canceled Memberships",
            valueKey: "total_canceled_memberships",
            icon: "fa-times-circle",
            color: "bg-yellow-500 text-white",
        },
        {
            title: "Frozen Memberships",
            valueKey: "total_frozen_memberships",
            icon: "fa-stopwatch",
            color: "bg-blue-400 text-white",
        },
        {
            title: "Payments Amount",
            valueKey: "total_payments_amount",
            icon: "fa-dollar-sign",
            color: "bg-green-600 text-white",
        },
        {
            title: "Paid Invoices",
            valueKey: "total_paid_invoices",
            icon: "fa-file-invoice-dollar",
            color: "bg-gray-500 text-white",
        },
        {
            title: "Unpaid Invoices",
            valueKey: "total_unpaid_invoices",
            icon: "fa-file-invoice",
            color: "bg-red-500 text-white",
        },
        {
            title: "Partial Invoices",
            valueKey: "total_partial_invoices",
            icon: "fa-file-invoice",
            color: "bg-orange-500 text-white",
        },
        // {
        //     title: "Expiring Memberships",
        //     valueKey: "total_expiring_memberships",
        //     icon: "fa-clock",
        //     color: "bg-yellow-500 text-white",
        // },
    ]

    const fetchData = async () => {
        try {
            isLoading.value = true;
            const response = await axios.get('/dashboard');
            data.value = response.data;
            console.log('API Response:', data.value);
        } catch (error) {
            console.error('Fetch error:', error);
        }
        finally {
            isLoading.value = false;
        }
    };

    onMounted(() => {
        fetchData();
    });

</script>

    <template>

        <!-- Header -->
        <header class="bg-white shadow p-4 max-w-8xl items-center mx-auto">
            <h1 class="flex items-center text-xl font-semibold text-gray-800">
                <i class="fa-solid fa-layer-group w-6 mr-2 text-gray-600"></i>
                Dashboard Overview
            </h1>
        </header>

        <div v-if="isLoading" class="flex justify-center items-center h-64">
            <Spinner />
        </div>

        <div v-if="!isLoading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mt-5 sm:gap-6 mb-6 sm:mb-8">
            <!-- All Cards -->
            <div v-for="(card, index) in cards" :key="index"
                class="bg-white p-4 sm:p-6 rounded-3xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 backdrop-blur-sm bg-opacity-90">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="p-2 sm:p-3 rounded-full" :class="card.color">
                        <i :class="`fa-solid ${card.icon} ${card.color} text-lg sm:text-xl`"></i>
                    </div>
                    <div>
                        <h3 class="text-xs sm:text-sm font-semibold text-gray-600">{{ card?.title }}</h3>
                        <p class="text-lg sm:text-2xl font-bold text-blue-600">{{ data?.cards[card.valueKey] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="!isLoading" class="min-h-screen text-gray-900 font-sans">
            <div class="mx-auto p-4 max-w-8xl">
                <!-- Tables Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Recent Members Table -->
                    <div
                        class="bg-white p-4 sm:p-6 rounded-3xl shadow-lg border border-gray-100 backdrop-blur-sm bg-opacity-90 transition-all duration-300 hover:shadow-xl">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 tracking-tight">Recent Members</h3>
                        <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                            Email</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                            Phone</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" v-if="data && data.tables">
                                    <tr v-for="member in data.tables.recent_members" :key="member.id"
                                        class="hover:bg-gray-50 transition-colors duration-200">
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                            {{ member.id }}</td>
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                            {{ member.name }}</td>
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden sm:table-cell">
                                            {{ member.email || 'N/A' }}</td>
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden md:table-cell">
                                            {{ member.phone_number || 'N/A' }}</td>
                                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                :class="{
                                                    'bg-green-100 text-green-800': member.status === 'allowed',
                                                    'bg-red-100 text-red-800': member.status === 'banned'
                                                }">
                                                {{ member.status }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Memberships Table -->
                    <div
                        class="bg-white p-4 sm:p-6 rounded-3xl shadow-lg border border-gray-100 backdrop-blur-sm bg-opacity-90 transition-all duration-300 hover:shadow-xl">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 tracking-tight">Recent Memberships
                        </h3>
                        <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Member</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                            Plan</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                            Start Date</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" v-if="data && data.tables">
                                    <tr v-for="membership in data.tables.recent_memberships" :key="membership.id"
                                        class="hover:bg-gray-50 transition-colors duration-200">
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                            {{ membership.id }}</td>
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                            {{ membership.member.name }}</td>
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden sm:table-cell">
                                            {{ membership.plan.name }}</td>
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden md:table-cell">
                                            {{ membership.start_date }}</td>
                                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                :class="{
                                                    'bg-green-100 text-green-800': membership.status === 'active',
                                                    'bg-yellow-100 text-yellow-800': membership.status === 'frozen',
                                                    'bg-red-100 text-red-800': membership.status === 'expired'
                                                }">
                                                {{ membership.status }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Payments Table -->
                    <div
                        class="bg-white p-4 sm:p-6 rounded-3xl shadow-lg border border-gray-100 backdrop-blur-sm bg-opacity-90 transition-all duration-300 hover:shadow-xl">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 tracking-tight">Recent Payments</h3>
                        <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Amount</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                            Payment Date</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                            Method</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" v-if="data && data.tables">
                                    <tr v-for="payment in data.tables.recent_payments" :key="payment.id"
                                        class="hover:bg-gray-50 transition-colors duration-200">
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                            {{ payment.id }}</td>
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                            {{ payment.amount }}</td>
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden sm:table-cell">
                                            {{ payment.payment_date }}</td>
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden md:table-cell">
                                            {{ payment.method }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Invoices Table -->
                    <div
                        class="bg-white p-4 sm:p-6 rounded-3xl shadow-lg border border-gray-100 backdrop-blur-sm bg-opacity-90 transition-all duration-300 hover:shadow-xl">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 tracking-tight">Recent Invoices</h3>
                        <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Number</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                            Amount</th>
                                        <th
                                            class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" v-if="data && data.tables">
                                    <tr v-for="invoice in data.tables.recent_invoices" :key="invoice.id"
                                        class="hover:bg-gray-50 transition-colors duration-200">
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                            {{ invoice.id }}</td>
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                            {{ invoice.number }}</td>
                                        <td
                                            class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden sm:table-cell">
                                            {{ invoice.total_amount }}</td>
                                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                :class="{
                                                    'bg-green-100 text-green-800': invoice.status === 'paid',
                                                    'bg-red-100 text-red-800': invoice.status !== 'paid'
                                                }">
                                                {{ invoice.status }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </template>
