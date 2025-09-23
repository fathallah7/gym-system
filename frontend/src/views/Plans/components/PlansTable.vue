<script setup>

const props = defineProps({
    plans: {
        type: Array,
        required: true
    },
    isLoading: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['edit-plan', 'delete-plan']);
</script>

<template>
    <div class="overflow-hidden rounded-xl shadow-sm bg-white" v-if="!isLoading">
        <!-- Table for larger screens -->
        <table class="w-full table-auto text-left hidden sm:table">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-sm font-medium text-gray-700 text-center">ID</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700">Plan</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden md:table-cell">Type</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden lg:table-cell">Sessions</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden xl:table-cell">Duration</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden lg:table-cell">Price</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors" v-for="plan in plans"
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
                    <td class="p-4 hidden md:table-cell">
                        <div class="flex items-center gap-3">
                            <div class="flex flex-col">
                                <p class="text-sm font-medium text-gray-900">{{ plan.type }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 hidden lg:table-cell">
                        <span
                            class="inline-block rounded-md bg-green-100 text-green-700 px-2 py-1 text-xs font-semibold uppercase">
                            {{ plan.sessions }}
                        </span>
                    </td>
                    <td class="p-4 hidden xl:table-cell">
                        <p class="text-sm text-gray-900">{{ plan.duration }} days</p>
                    </td>
                    <td class="p-4 hidden lg:table-cell">
                        <p class="text-sm text-gray-900">{{ plan.price }}</p>
                    </td>
                    <td class="p-4">
                        <button @click="emit('edit-plan', plan)"
                            class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button @click="emit('delete-plan', plan.id)"
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
                v-for="plan in plans" :key="plan.id">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center gap-3">
                        <div>
                            <p class="text-base font-bold text-gray-800 tracking-tight">{{ plan.name }}</p>
                            <p class="text-xs text-gray-500">ID: {{ plan.id }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button @click="emit('edit-plan', plan)"
                            class="rounded-md px-3 py-1 bg-blue-900 text-white text-sm font-medium hover:bg-blue-950 focus:outline-none focus:ring-2 focus:ring-blue-700 transition-colors duration-200"
                            title="Edit Plan">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button @click="emit('delete-plan', plan.id)"
                            class="rounded-md px-3 py-1 bg-red-800 text-white text-sm font-medium hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-700 transition-colors duration-200"
                            title="Delete Plan">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    <p class="text-sm font-medium text-gray-700">
                        Type: <span class="text-gray-900">{{ plan.type || 'No data' }}</span>
                    </p>
                    <p class="text-sm font-medium text-gray-700">
                        Sessions:
                        <span
                            class="inline-block rounded-md px-2 py-1 text-xs font-semibold uppercase bg-amber-100 text-amber-800">
                            {{ plan.sessions }}
                        </span>
                    </p>
                    <p class="text-sm font-medium text-gray-700">
                        Duration: <span>{{ plan.duration ? `${plan.duration} days` : 'No data' }}</span>
                    </p>
                    <p class="text-sm font-medium text-gray-700">
                        Price: <span>{{ plan.price || 'No data' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>