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
                <tr class="border-b border-gray-100 hover:bg-gray-100 transition-colors" v-for="member in memberships"
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
    </div>

</template>