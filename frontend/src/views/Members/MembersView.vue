<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { onMounted } from 'vue';

onMounted(
    async () => {
        try {
            const response = await axios.get('/member');
            console.log('done', response)
        } catch (error) {
            console.log(error)
        }
    });

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
            Members
        </h1>
    </header>


    <div class="p-6 overflow-x-auto mx-auto max-w-7xl">
        <!-- Search Bar -->
        <div class="mb-6 flex items-center gap-4">
            <input type="text" placeholder="Search projects..."
                class="w-full max-w-md rounded-lg border border-gray-400 px-4 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black"
                aria-label="Search projects" />
        </div>
        <!-- Table -->
        <div class="overflow-hidden rounded-xl shadow-sm bg-white">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Project</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Teamlead</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Function</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Deadline</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">React Project</p>
                                    <p class="text-xs text-gray-500">Start date: 10 Dec 2023</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-3.jpg"
                                    alt="John Michael" class="h-9 w-9 rounded-full object-cover" loading="lazy" />
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">John Michael</p>
                                    <p class="text-xs text-gray-500">john@creative-tim.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex flex-col">
                                <p class="text-sm font-medium text-gray-900">Manager</p>
                                <p class="text-xs text-gray-500">Organization</p>
                            </div>
                        </td>
                        <td class="p-4">
                            <span
                                class="inline-block rounded-md bg-green-100 text-green-700 px-2 py-1 text-xs font-semibold uppercase">
                                Completed
                            </span>
                        </td>
                        <td class="p-4">
                            <p class="text-sm text-gray-900">23/04/18</p>
                        </td>
                        <td class="p-4">
                            <button
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"
                                aria-label="Edit React Project">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="h-4 w-4">
                                    <path
                                        d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">Angular Project</p>
                                    <p class="text-xs text-gray-500">Start date: 10 Dec 2023</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-2.jpg"
                                    alt="Alexa Liras" class="h-9 w-9 rounded-full object-cover" loading="lazy" />
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">Alexa Liras</p>
                                    <p class="text-xs text-gray-500">alexa@creative-tim.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex flex-col">
                                <p class="text-sm font-medium text-gray-900">Programator</p>
                                <p class="text-xs text-gray-500">Developer</p>
                            </div>
                        </td>
                        <td class="p-4">
                            <span
                                class="inline-block rounded-md bg-purple-100 text-purple-700 px-2 py-1 text-xs font-semibold uppercase">
                                Active
                            </span>
                        </td>
                        <td class="p-4">
                            <p class="text-sm text-gray-900">23/04/18</p>
                        </td>
                        <td class="p-4">
                            <button
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"
                                aria-label="Edit Angular Project">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="h-4 w-4">
                                    <path
                                        d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">Tailwind Project</p>
                                    <p class="text-xs text-gray-500">Start date: 10 Dec 2023</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-1.jpg"
                                    alt="Laurent Perrier" class="h-9 w-9 rounded-full object-cover" loading="lazy" />
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">Laurent Perrier</p>
                                    <p class="text-xs text-gray-500">laurent@creative-tim.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex flex-col">
                                <p class="text-sm font-medium text-gray-900">Executive</p>
                                <p class="text-xs text-gray-500">Projects</p>
                            </div>
                        </td>
                        <td class="p-4">
                            <span
                                class="inline-block rounded-md bg-yellow-100 text-yellow-700 px-2 py-1 text-xs font-semibold uppercase">
                                Scheduled
                            </span>
                        </td>
                        <td class="p-4">
                            <p class="text-sm text-gray-900">19/09/17</p>
                        </td>
                        <td class="p-4">
                            <button
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"
                                aria-label="Edit Tailwind Project">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="h-4 w-4">
                                    <path
                                        d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">Laravel Project</p>
                                    <p class="text-xs text-gray-500">Start date: 10 Dec 2023</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-4.jpg"
                                    alt="Michael Levi" class="h-9 w-9 rounded-full object-cover" loading="lazy" />
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">Michael Levi</p>
                                    <p class="text-xs text-gray-500">michael@creative-tim.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex flex-col">
                                <p class="text-sm font-medium text-gray-900">Programator</p>
                                <p class="text-xs text-gray-500">Developer</p>
                            </div>
                        </td>
                        <td class="p-4">
                            <span
                                class="inline-block rounded-md bg-green-100 text-green-700 px-2 py-1 text-xs font-semibold uppercase">
                                Completed
                            </span>
                        </td>
                        <td class="p-4">
                            <p class="text-sm text-gray-900">24/12/08</p>
                        </td>
                        <td class="p-4">
                            <button
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"
                                aria-label="Edit Laravel Project">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="h-4 w-4">
                                    <path
                                        d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">Astro Project</p>
                                    <p class="text-xs text-gray-500">Start date: 10 Dec 2023</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-5.jpg"
                                    alt="Richard Gran" class="h-9 w-9 rounded-full object-cover" loading="lazy" />
                                <div class="flex flex-col">
                                    <p class="text-sm font-medium text-gray-900">Richard Gran</p>
                                    <p class="text-xs text-gray-500">richard@creative-tim.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex flex-col">
                                <p class="text-sm font-medium text-gray-900">Manager</p>
                                <p class="text-xs text-gray-500">Executive</p>
                            </div>
                        </td>
                        <td class="p-4">
                            <span
                                class="inline-block rounded-md bg-red-100 text-red-700 px-2 py-1 text-xs font-semibold uppercase">
                                Pending
                            </span>
                        </td>
                        <td class="p-4">
                            <p class="text-sm text-gray-900">04/10/21</p>
                        </td>
                        <td class="p-4">
                            <button
                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"
                                aria-label="Edit Astro Project">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="h-4 w-4">
                                    <path
                                        d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Mobile View -->
        <div class="md:hidden space-y-4 mt-4">
            <div class="rounded-lg border border-gray-100 p-4 bg-white shadow-sm">
                <div class="flex justify-between items-center">
                    <p class="text-sm font-medium text-gray-900">React Project</p>
                    <button
                        class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        aria-label="Edit React Project">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                            <path
                                d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-500">Start date: 10 Dec 2023</p>
                <div class="mt-2 flex items-center gap-3">
                    <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-3.jpg"
                        alt="John Michael" class="h-8 w-8 rounded-full object-cover" loading="lazy" />
                    <div>
                        <p class="text-sm font-medium text-gray-900">John Michael</p>
                        <p class="text-xs text-gray-500">john@creative-tim.com</p>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-sm text-gray-900">Manager</p>
                    <p class="text-xs text-gray-500">Organization</p>
                </div>
                <div class="mt-2">
                    <span
                        class="inline-block rounded-md bg-green-100 text-green-700 px-2 py-1 text-xs font-semibold uppercase">
                        Completed
                    </span>
                </div>
                <p class="mt-2 text-sm text-gray-900">Deadline: 23/04/18</p>
            </div>
            <div class="rounded-lg border border-gray-100 p-4 bg-white shadow-sm">
                <div class="flex justify-between items-center">
                    <p class="text-sm font-medium text-gray-900">Angular Project</p>
                    <button
                        class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        aria-label="Edit Angular Project">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                            <path
                                d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-500">Start date: 10 Dec 2023</p>
                <div class="mt-2 flex items-center gap-3">
                    <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-2.jpg"
                        alt="Alexa Liras" class="h-8 w-8 rounded-full object-cover" loading="lazy" />
                    <div>
                        <p class="text-sm font-medium text-gray-900">Alexa Liras</p>
                        <p class="text-xs text-gray-500">alexa@creative-tim.com</p>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-sm text-gray-900">Programator</p>
                    <p class="text-xs text-gray-500">Developer</p>
                </div>
                <div class="mt-2">
                    <span
                        class="inline-block rounded-md bg-purple-100 text-purple-700 px-2 py-1 text-xs font-semibold uppercase">
                        Active
                    </span>
                </div>
                <p class="mt-2 text-sm text-gray-900">Deadline: 23/04/18</p>
            </div>
            <div class="rounded-lg border border-gray-100 p-4 bg-white shadow-sm">
                <div class="flex justify-between items-center">
                    <p class="text-sm font-medium text-gray-900">Tailwind Project</p>
                    <button
                        class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        aria-label="Edit Tailwind Project">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                            <path
                                d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-500">Start date: 10 Dec 2023</p>
                <div class="mt-2 flex items-center gap-3">
                    <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-1.jpg"
                        alt="Laurent Perrier" class="h-8 w-8 rounded-full object-cover" loading="lazy" />
                    <div>
                        <p class="text-sm font-medium text-gray-900">Laurent Perrier</p>
                        <p class="text-xs text-gray-500">laurent@creative-tim.com</p>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-sm text-gray-900">Executive</p>
                    <p class="text-xs text-gray-500">Projects</p>
                </div>
                <div class="mt-2">
                    <span
                        class="inline-block rounded-md bg-yellow-100 text-yellow-700 px-2 py-1 text-xs font-semibold uppercase">
                        Scheduled
                    </span>
                </div>
                <p class="mt-2 text-sm text-gray-900">Deadline: 19/09/17</p>
            </div>
            <div class="rounded-lg border border-gray-100 p-4 bg-white shadow-sm">
                <div class="flex justify-between items-center">
                    <p class="text-sm font-medium text-gray-900">Laravel Project</p>
                    <button
                        class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        aria-label="Edit Laravel Project">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                            <path
                                d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-500">Start date: 10 Dec 2023</p>
                <div class="mt-2 flex items-center gap-3">
                    <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-4.jpg"
                        alt="Michael Levi" class="h-8 w-8 rounded-full object-cover" loading="lazy" />
                    <div>
                        <p class="text-sm font-medium text-gray-900">Michael Levi</p>
                        <p class="text-xs text-gray-500">michael@creative-tim.com</p>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-sm text-gray-900">Programator</p>
                    <p class="text-xs text-gray-500">Developer</p>
                </div>
                <div class="mt-2">
                    <span
                        class="inline-block rounded-md bg-green-100 text-green-700 px-2 py-1 text-xs font-semibold uppercase">
                        Completed
                    </span>
                </div>
                <p class="mt-2 text-sm text-gray-900">Deadline: 24/12/08</p>
            </div>
            <div class="rounded-lg border border-gray-100 p-4 bg-white shadow-sm">
                <div class="flex justify-between items-center">
                    <p class="text-sm font-medium text-gray-900">Astro Project</p>
                    <button
                        class="rounded-lg p-2 text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        aria-label="Edit Astro Project">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                            <path
                                d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-500">Start date: 10 Dec 2023</p>
                <div class="mt-2 flex items-center gap-3">
                    <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-5.jpg"
                        alt="Richard Gran" class="h-8 w-8 rounded-full object-cover" loading="lazy" />
                    <div>
                        <p class="text-sm font-medium text-gray-900">Richard Gran</p>
                        <p class="text-xs text-gray-500">richard@creative-tim.com</p>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-sm text-gray-900">Manager</p>
                    <p class="text-xs text-gray-500">Executive</p>
                </div>
                <div class="mt-2">
                    <span
                        class="inline-block rounded-md bg-red-100 text-red-700 px-2 py-1 text-xs font-semibold uppercase">
                        Pending
                    </span>
                </div>
                <p class="mt-2 text-sm text-gray-900">Deadline: 04/10/21</p>
            </div>
        </div>
    </div>



</template>
