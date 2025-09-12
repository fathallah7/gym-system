<script setup>

const props = defineProps({
    members: {
        type: Array,
        required: true
    },
    isLoading: {
        type: Boolean,
        required: true
    }
});
const emit = defineEmits(['delete-member']);
</script>


<template>

        <div class="overflow-hidden rounded-xl shadow-sm bg-white" v-if="!isLoading">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-sm font-medium text-gray-700 text-center">ID</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Member</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Function</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Member Since</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <tr class="border-b border-gray-200 hover:bg-gray-100 transition-colors" v-for="member in members"
                        :key="member.id">

                        <td class="p-2 text-center bg-gray-100">
                            <p class="text-sm text-gray-900">{{ member.id }}</p>
                        </td>

                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <!-- <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-3.jpg"
                                    alt="John Michael" class="h-9 w-9 rounded-full object-cover" loading="lazy" /> -->
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">{{ member.name }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="p-4">
                            <div class="flex flex-col">
                                <p class="text-sm font-medium text-gray-600" v-if="member.phone_number"><i
                                        class="fa-solid fa-phone"></i> {{ member.phone_number }}</p>
                                <p class="text-sm font-medium text-gray-600" v-if="member.email"><i
                                        class="fa-solid fa-envelope"></i> {{ member.email }}</p>
                                <p class="text-sm font-medium text-gray-600" v-if="!member.phone_number"><i
                                        class="fa-solid fa-phone"></i> No data</p>
                                <p class="text-sm font-medium text-gray-600" v-if="!member.email"><i
                                        class="fa-solid fa-envelope"></i> No data</p>
                            </div>
                        </td>

                        <td class="p-4">
                            <span
                                class="inline-block rounded-md bg-green-100 text-green-700 px-2 py-1 text-xs font-semibold uppercase"
                                :class="{ 'bg-red-100 text-red-700': member.status === 'banned' }">
                                {{ member.status }}
                            </span>
                        </td>

                        <td class="p-4">
                            <p class="text-sm text-gray-900"> {{ new Date(member.created_at).toLocaleString() }} </p>
                        </td>

                        <td class="p-4">
                            <button @click="$router.push(`/members/${member.id}`)"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fa-solid fa-address-card"></i>
                            </button>
                            <button @click="emit('delete-member', member.id)"
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

</template>


