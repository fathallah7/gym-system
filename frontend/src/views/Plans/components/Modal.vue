<script setup>

const props = defineProps({
    showModal: {
        type: Boolean,
        required: true
    },
    isEditMode: {
        type: Boolean,
        required: true
    },
    planData: {
        type: Object,
        required: true
    },
    isLoading: {
        type: Boolean,
        default: false
    }
});
const emit = defineEmits(['close-modal', 'save-plan']);

</script>


<template>

    <div v-if="showModal"
        class="fixed inset-0 bg-black/50 bg-opacity-60 flex items-center justify-center z-50 transition-opacity duration-300"
        :class="{ 'opacity-100': showModal, 'opacity-0': !showModal }">
        <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-100">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">{{ isEditMode ? 'Edit Plan' : 'Add New Plan' }}
                </h2>
                <button @click="closeModal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            <div class="space-y-5">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Plan Name</label>
                    <input v-model="planData.name" type="text"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                        :class="{ 'border-red-500': planData.errors.name }" placeholder="Enter plan name" />
                    <div v-if="planData.errors.name" class="text-red-600 text-sm mt-1">
                        {{ planData.errors.name[0] }}
                    </div>
                </div>

                <!-- Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" id="type"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                        v-model="planData.type">
                        <option value="" disabled>Select plan type</option>
                        <option value="open">Open</option>
                        <option value="sessions">Sessions</option>
                    </select>
                    <div v-if="planData.errors.type" class="text-red-600 text-sm mt-1">
                        {{ planData.errors.type[0] }}
                    </div>
                </div>

                <!-- Sessions -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sessions</label>
                    <input v-model.number="planData.sessions" type="number"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                        :class="{ 'border-red-500': planData.errors.sessions }"
                        placeholder="Enter number of sessions" />
                    <div v-if="planData.errors.sessions" class="text-red-600 text-sm mt-1">
                        {{ planData.errors.sessions[0] }}
                    </div>
                </div>

                <!-- Duration -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Duration (days)</label>
                    <input v-model="planData.duration" type="number"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                        :class="{ 'border-red-500': planData.errors.duration }" placeholder="Enter duration" />
                    <div v-if="planData.errors.duration" class="text-red-600 text-sm mt-1">
                        {{ planData.errors.duration[0] }}
                    </div>
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                    <input v-model.number="planData.price" type="number"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
                        :class="{ 'border-red-500': planData.errors.price }" placeholder="Enter price" />
                    <div v-if="planData.errors.price" class="text-red-600 text-sm mt-1">
                        {{ planData.errors.price[0] }}
                    </div>
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-4">
                <button @click="emit('close-modal')" :disabled="isLoading"
                    :class="{ 'opacity-50 cursor-not-allowed': isLoading }"
                    class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors">
                    Cancel
                </button>
                <button @click="emit('save-plan')" :disabled="isLoading"
                    :class="{ 'opacity-50 cursor-not-allowed': isLoading }"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                    {{ isEditMode ? 'Update' : 'Create' }}
                </button>
            </div>
        </div>
    </div>

</template>