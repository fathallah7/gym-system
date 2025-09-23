<script setup>
const props = defineProps({
    memberships: {
        type: Array,
        required: true
    },
    isLoading: {
        type: Boolean,
        required: true
    },
    meta: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['edit-membership', 'delete-membership', 'attendance']);
</script>

<template>
    <div class="overflow-hidden rounded-xl shadow-sm bg-white" v-if="!isLoading">
        <!-- Table for larger screens -->
        <table class="w-full table-auto text-left hidden sm:table">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-sm font-medium text-gray-700 text-center">ID</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700">Member</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden md:table-cell">Plane</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden lg:table-cell">Remaining Sessions</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden xl:table-cell">End Date</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden lg:table-cell">Status</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors" v-for="member in memberships"
                    :key="member.id">
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
                    <td class="p-4 hidden md:table-cell">
                        <div class="flex items-center gap-3">
                            <div class="flex flex-col">
                                <p class="text-sm font-medium text-gray-900">{{ member.plan?.name }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 hidden lg:table-cell">
                        <div class="flex items-center gap-3">
                            <div class="flex flex-col">
                                <p class="text-sm font-medium text-gray-900"
                                    :class="{ 'text-red-600': member.remaining_sessions === 0 }">
                                    {{ member.remaining_sessions }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 hidden xl:table-cell">
                        <span class="inline-block rounded-md">
                            {{ member.end_date }}
                        </span>
                    </td>
                    <td class="p-4 hidden lg:table-cell">
                        <p class="text-gray-900 inline-block rounded-md px-2 py-1 text-xs font-semibold uppercase"
                            :class="{
                                'bg-red-100 text-red-700': member.status === 'expired',
                                'bg-green-100 text-green-700': member.status === 'active',
                                'bg-yellow-100 text-yellow-700': member.status === 'frozen'
                            }">
                            {{ member.status }}
                        </p>
                    </td>
                    <td class="p-4">
                        <button @click="$emit('attendance', member.id, member.member.name)"
                            class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <i class="fa-solid fa-square-check"></i>
                        </button>
                        <button @click="$emit('edit-membership', member)"
                            class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button @click="$emit('delete-membership', member.id)"
                            class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Card layout for mobile -->
        <div class="sm:hidden divide-y divide-gray-300">
            <div class="p-4 bg-gradient-to-b from-gray-50 to-white border border-gray-200 rounded-xl shadow-lg mb-4 hover:shadow-xl transition-shadow duration-300"
                v-for="member in memberships" :key="member.id">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center gap-3">
                        <div>
                            <p class="text-base font-bold text-gray-800 tracking-tight">{{ member.member.name }}</p>
                            <p class="text-xs text-gray-500">ID: {{ member.id }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button @click="$emit('attendance', member.id, member.member.name)"
                            class="rounded-md px-3 py-1 bg-blue-900 text-white text-sm font-medium hover:bg-blue-950 focus:outline-none focus:ring-2 focus:ring-blue-700 transition-colors duration-200"
                            title="Mark Attendance">
                            <i class="fa-solid fa-square-check"></i>
                        </button>
                        <button @click="$emit('edit-membership', member)"
                            class="rounded-md px-3 py-1 bg-blue-900 text-white text-sm font-medium hover:bg-blue-950 focus:outline-none focus:ring-2 focus:ring-blue-700 transition-colors duration-200"
                            title="Edit Membership">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button @click="$emit('delete-membership', member.id)"
                            class="rounded-md px-3 py-1 bg-red-800 text-white text-sm font-medium hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-700 transition-colors duration-200"
                            title="Delete Membership">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    <p class="text-sm font-medium text-gray-700">
                        Plan: <span class="text-gray-900">{{ member.plan?.name || 'No data' }}</span>
                    </p>
                    <p class="text-sm font-medium text-gray-700">
                        Remaining Sessions:
                        <span :class="{ 'text-red-600': member.remaining_sessions === 0 }">
                            {{ member.remaining_sessions }}
                        </span>
                    </p>
                    <p class="text-sm font-medium text-gray-700">
                        End Date: <span>{{ member.end_date || 'No data' }}</span>
                    </p>
                    <p class="text-sm font-medium text-gray-700">
                        Status:
                        <span
                            class="inline-block rounded-md px-2 py-1 text-xs font-semibold uppercase bg-amber-100 text-amber-800"
                            :class="{
                                'bg-red-100 text-red-800': member.status === 'expired',
                                'bg-green-100 text-green-800': member.status === 'active',
                                'bg-amber-100 text-amber-800': member.status === 'frozen'
                            }">
                            {{ member.status }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>