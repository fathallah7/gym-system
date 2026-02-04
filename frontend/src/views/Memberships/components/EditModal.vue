<script setup>

const props = defineProps({
    showModal: {
        type: Boolean,
        required: true
    },
    membershipStatusData: {
        type: String,
        required: true
    },
    isLoading: {
        type: Boolean,
        required: true
    }
});

const emit = defineEmits(['close-modal', 'member-update-status' , 'update:membershipStatusData']);

</script>

<template>


    <div v-if="showModal"
        class="fixed p-5 inset-0 bg-black/50 bg-opacity-60 flex items-center justify-center z-50 transition-opacity duration-300"
        :class="{ 'opacity-100': showModal, 'opacity-0': !showModal }">
        <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-100">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Edit Status
                </h2>
                <button @click="$emit('close-modal')" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            <div class="space-y-5">
                <!-- Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="type" id="type"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                        :value="membershipStatusData"
                        @input="$emit('update:membershipStatusData', $event.target.value)">
                        <option value="" disabled>Select plan type</option>
                        <option value="active">Active</option>
                        <option value="expired">Expired</option>
                        <option value="canceled">Canceled</option>
                        <option value="frozen">Frozen</option>
                    </select>
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-4">
                <button @click="$emit('close-modal')" :disabled="isLoading"
                    :class="{ 'opacity-50 cursor-not-allowed': isLoading }"
                    class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors">
                    Cancel
                </button>
                <button @click="$emit('member-update-status')" :disabled="isLoading"
                    :class="{ 'opacity-50 cursor-not-allowed': isLoading }"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                    Update
                </button>
            </div>
        </div>
    </div>


</template>