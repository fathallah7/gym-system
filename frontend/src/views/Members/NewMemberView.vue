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

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Default Inputs -->
                    <div class="rounded-2xl border border-gray-200 bg-white">
                        <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6">
                            <!-- Name Input -->
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" placeholder="Enter Member Name"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none" />
                            </div>
                            <!-- Gender Select Input -->
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700">Gender</label>
                                <div class="relative">
                                    <select
                                        class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none">
                                        <option value="">Select Option</option>
                                        <option value="Marketing">Male</option>
                                        <option value="Template">Femail</option>
                                    </select>
                                    <span
                                        class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2 text-gray-500">
                                        <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <!-- Date Picker -->
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700">Date Picker Input</label>
                                <div class="relative">
                                    <input type="date" placeholder="Select date"
                                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none" />
                                    <span
                                        class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-gray-500">
                                        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <!-- Input with Placeholder -->
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" placeholder="Enter Member Address"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none" />
                            </div>
                            <!-- Notes  -->
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700">Notes</label>
                                <textarea placeholder="Enter any notes..." rows="5"
                                    class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none"></textarea>
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
                                <input type="text" placeholder="Enter Member Email"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none" />
                            </div>
                            <!-- Phone Number Input -->
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="text" placeholder="Enter Member Name"
                                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-3 focus:ring-blue-500/10 focus:outline-none" />
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
                                    <span class="mx-auto mb-5 block w-full max-w-[290px] text-sm text-gray-700">Drag and
                                        drop your PNG, JPG, WebP, SVG images here or browse</span>
                                    <span class="text-sm text-blue-500 font-medium underline">Browse File</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>




</template>