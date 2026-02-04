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
        <!-- Table for larger screens -->
        <table class="w-full table-auto text-left hidden sm:table">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-sm font-medium text-gray-700 text-center">ID</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700">Member</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden md:table-cell">Function</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden lg:table-cell">Status</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700 hidden xl:table-cell">Member Since</th>
                    <th class="px-6 py-4 text-sm font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors" v-for="member in members"
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
                    <td class="p-4 hidden md:table-cell">
                        <div class="flex flex-col">
                            <p class="text-sm font-medium text-gray-600" v-if="member.phone_number">
                                <i class="fa-solid fa-phone"></i> {{ member.phone_number }}
                            </p>
                            <p class="text-sm font-medium text-gray-600" v-if="member.email">
                                <i class="fa-solid fa-envelope"></i> {{ member.email }}
                            </p>
                            <p class="text-sm font-medium text-gray-600" v-if="!member.phone_number">
                                <i class="fa-solid fa-phone"></i> No data
                            </p>
                            <p class="text-sm font-medium text-gray-600" v-if="!member.email">
                                <i class="fa-solid fa-envelope"></i> No data
                            </p>
                        </div>
                    </td>
                    <td class="p-4 hidden lg:table-cell">
                        <span
                            class="inline-block rounded-md bg-green-100 text-green-700 px-2 py-1 text-xs font-semibold uppercase"
                            :class="{ 'bg-red-100 text-red-700': member.status === 'banned' }">
                            {{ member.status }}
                        </span>
                    </td>
                    <td class="p-4 hidden xl:table-cell">
                        <p class="text-sm text-gray-900">{{ new Date(member.created_at).toLocaleString() }}</p>
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

        <!-- Card layout for mobile -->
        <div class="sm:hidden divide-y divide-gray-300">
            <div class="p-4 bg-gradient-to-b from-gray-50 to-white border border-gray-200 rounded-xl shadow-lg mb-4 hover:shadow-xl transition-shadow duration-300"
                v-for="member in members" :key="member.id">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center gap-3">
                        <!-- <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-3.jpg"
              alt="John Michael" class="h-10 w-10 rounded-full object-cover border-2 border-gray-300" loading="lazy" /> -->
                        <div>
                            <p class="text-base font-bold text-gray-800 tracking-tight">{{ member.name }}</p>
                            <p class="text-xs text-gray-500">ID: {{ member.id }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button @click="$router.push(`/members/${member.id}`)"
                            class="rounded-md px-3 py-1 bg-blue-900 text-white text-sm font-medium hover:bg-blue-950 focus:outline-none focus:ring-2 focus:ring-blue-700 transition-colors duration-200"
                            title="View Member">
                            <i class="fa-solid fa-address-card"></i>
                        </button>
                        <button @click="emit('delete-member', member.id)"
                            class="rounded-md px-3 py-1 bg-red-800 text-white text-sm font-medium hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-700 transition-colors duration-200"
                            title="Delete Member">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    <p class="text-sm font-medium text-gray-700" v-if="member.phone_number">
                        <i class="fa-solid fa-phone mr-1 text-gray-500"></i> {{ member.phone_number }}
                    </p>
                    <p class="text-sm font-medium text-gray-700" v-if="!member.phone_number">
                        <i class="fa-solid fa-phone mr-1 text-gray-500"></i> No data
                    </p>
                    <p class="text-sm font-medium text-gray-700" v-if="member.email">
                        <i class="fa-solid fa-envelope mr-1 text-gray-500"></i> {{ member.email }}
                    </p>
                    <p class="text-sm font-medium text-gray-700" v-if="!member.email">
                        <i class="fa-solid fa-envelope mr-1 text-gray-500"></i> No data
                    </p>
                    <p class="text-sm font-medium text-gray-700">
                        Status:
                        <span
                            class="inline-block rounded-md px-2 py-1 text-xs font-semibold uppercase bg-amber-100 text-amber-800"
                            :class="{ 'bg-red-100 text-red-800': member.status === 'banned' }">
                            {{ member.status }}
                        </span>
                    </p>
                    <p class="text-sm font-medium text-gray-700">
                        Member Since: {{ new Date(member.created_at).toLocaleString() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
