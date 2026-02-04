<script setup>
import { reactive, ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';

const router = useRouter();
const toast = useToast();
const isLoading = ref(false);

const form = reactive({
    name: '',
    gender: '',
    date_of_birth: '',
    address: '',
    notes: '',
    email: '',
    phone_number: '',
    errors: {}
});

const submitForm = async () => {
    try {
        isLoading.value = true;
        form.errors = {};

        const response = await axios.post('/members', form);
        Object.keys(form).forEach(key => { form[key] = ''; });
        toast.success(response.data.message);
    } catch (error) {
        if (error.response?.status === 422) {
            form.errors = error.response.data.errors;
        } else {
            toast.error(error.response?.data?.message || 'Failed to add member.');
        }
    } finally {
        isLoading.value = false;
    }
};

</script>

<template>

    <!-- Header -->
    <header class="bg-white shadow p-4 max-w-8xl items-center mx-auto ">
        <h1 class="flex text-xl font-semibold text-gray-800">
            <svg class="w-6 h-6 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z">
                </path>
            </svg>
            New Member
        </h1>
    </header>

    <!-- Main Content -->
    <main>
        <div class="mx-auto max-w-8xl p-4 md:p-6">

            <form @submit.prevent="submitForm">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div class="rounded-2xl border border-gray-200 bg-white">
                            <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6">

                                <!-- Name Input -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Name</label>
                                    <input v-model="form.name" type="text" placeholder="Enter Member Name"
                                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none"
                                        :class="{ 'border-red-500': form.errors.name }" />
                                    <div v-if="form.errors.name" class="error">
                                        <p class="text-sm text-red-700">{{ form.errors.name[0] }}</p>
                                    </div>
                                </div>

                                <!-- Gender Select Input -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Gender</label>
                                    <div class="relative">
                                        <select v-model="form.gender"
                                            class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none"
                                            :class="{ 'border-red-700': form.errors.gender }">
                                            <option value="selected" selected disabled>Select Option</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                        <span
                                            class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2 text-gray-500">
                                            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div v-if="form.errors.gender" class="error">
                                        <p class="text-sm text-red-700">{{ form.errors.gender[0] }}</p>
                                    </div>
                                </div>

                                <!-- Date Picker -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Date of Birth</label>
                                    <div class="relative">
                                        <input v-model="form.date_of_birth" type="date" placeholder="Select date"
                                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none"
                                            :class="{ 'border-red-700': form.errors.date_of_birth }" />
                                        <div v-if="form.errors.date_of_birth" class="error">
                                            <p class="text-sm text-red-700">{{ form.errors.date_of_birth[0] }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Input with Placeholder -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Address</label>
                                    <input v-model="form.address" type="text" placeholder="Enter Member Address"
                                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none"
                                        :class="{ 'border-red-700': form.errors.address }" />
                                    <div v-if="form.errors.address" class="error">
                                        <p class="text-sm text-red-700">{{ form.errors.address[0] }}</p>
                                    </div>
                                </div>

                                <!-- Notes  -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Notes</label>
                                    <textarea v-model="form.notes" placeholder="Enter any notes..." rows="5"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none"
                                        :class="{ 'border-red-700': form.errors.notes }">
                                    </textarea>
                                    <div v-if="form.errors.notes" class="error">
                                        <p class="text-sm text-red-700">{{ form.errors.notes[0] }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Select Inputs -->
                        <div class="rounded-2xl border border-gray-200 bg-white">
                            <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6">

                                <!-- Email Input -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Email</label>
                                    <input v-model="form.email" type="text" placeholder="Enter Member Email"
                                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none"
                                        :class="{ 'border-red-700': form.errors.email }" />
                                    <div v-if="form.errors.email" class="error">
                                        <p class="text-sm text-red-700">{{ form.errors.email[0] }}</p>
                                    </div>
                                </div>

                                <!-- Phone Number Input -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input v-model="form.phone_number" type="text"
                                        placeholder="Enter Member Phone Number"
                                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none"
                                        :class="{ 'border-red-700': form.errors.phone_number }" />
                                    <div v-if="form.errors.phone_number" class="error">
                                        <p class="text-sm text-red-700">{{ form.errors.phone_number[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- submit button center pro style -->
                <div class="mt-6 flex justify-center">
                    <button type="submit" :disabled="isLoading" :class="{ 'opacity-50 cursor-not-allowed': isLoading }"
                        class="inline-flex w-full max-w-sm cursor-pointer items-center justify-center rounded-lg border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                        Add Member
                    </button>
                </div>

            </form>

        </div>
    </main>


</template>
