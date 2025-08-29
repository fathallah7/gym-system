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

        const response = await axios.post('/member', form);
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
                        <!-- Photo -->
                        <div class="rounded-2xl border border-gray-200 bg-white">
                            <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6">
                                <form
                                    class="dropzone rounded-xl border border-dashed border-gray-300 bg-gray-50 p-7 lg:p-10 hover:border-blue-500">
                                    <div class="m-0">
                                        <div class="mb-5 flex justify-center">
                                            <div
                                                class="flex h-[68px] w-[68px] items-center justify-center rounded-full bg-gray-200 text-gray-700">
                                                <svg class="fill-current" width="29" height="28" viewBox="0 0 29 28"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M14.5019 3.91699C14.2852 3.91699 14.0899 4.00891 13.953 4.15589L8.57363 9.53186C8.28065 9.82466 8.2805 10.2995 8.5733 10.5925C8.8661 10.8855 9.34097 10.8857 9.63396 10.5929L13.7519 6.47752V18.667C13.7519 19.0812 14.0877 19.417 14.5019 19.417C14.9161 19.417 15.2519 19.0812 15.2519 18.667V6.48234L19.3653 10.5929C19.6583 10.8857 20.1332 10.8855 20.426 10.5925C20.7188 10.2995 20.7186 9.82463 20.4256 9.53184L15.0838 4.19378C14.9463 4.02488 14.7367 3.91699 14.5019 3.91699ZM5.91626 18.667C5.91626 18.2528 5.58047 17.917 5.16626 17.917C4.75205 17.917 4.41626 18.2528 4.41626 18.667V21.8337C4.41626 23.0763 5.42362 24.0837 6.66626 24.0837H22.3339C23.5766 24.0837 24.5839 23.0763 24.5839 21.8337V18.667C24.5839 18.2528 24.2482 17.917 23.8339 17.917C23.4197 17.917 23.0839 18.2528 23.0839 18.667V21.8337C23.0839 22.2479 22.7482 22.5837 22.3339 22.5837H6.66626C6.25205 22.5837 5.91626 22.2479 5.91626 21.8337V18.667Z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <h4 class="text-xl mb-3 font-semibold text-gray-800">Drop File Here</h4>
                                        <span class="mx-auto mb-5 block w-full max-w-[290px] text-sm text-gray-700">Drag
                                            and
                                            drop your PNG, JPG, WebP, SVG images here or browse</span>
                                        <span class="text-sm text-blue-500 font-medium underline">Browse File</span>
                                    </div>
                                </form>
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