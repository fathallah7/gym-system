<script setup>
import { onMounted } from 'vue';
import { RouterLink } from 'vue-router';




const logout = () => {
    localStorage.removeItem('token');
};

onMounted(() => {
    // Dropdown toggle
    document.querySelectorAll('.flex.items-center.p-2').forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const dropdown = item.nextElementSibling;
            if (dropdown && dropdown.hasAttribute('data-dropdown')) {
                dropdown.classList.toggle('hidden');
            }
        });
    });
});
</script>



<template>

    <nav class="flex-1 p-4 overflow-y-auto">
        
        <!-- Menu Group -->
        <div>
            <h3 class="mb-4 text-xs font-semibold uppercase text-gray-400">Main Menu</h3>
            <ul class="space-y-2">
                <!-- Menu Item Dashboard -->
                <li>
                    <RouterLink to="home" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg"
                        :class="{ 'bg-gray-100 rounded-lg': $route.path === '/home' }">
                        <i class="fa-solid fa-chart-line w-6 mr-2 text-gray-600"></i>
                        Dashboard
                    </RouterLink>
                </li>

                <!-- Menu  Memberships -->
                <li>
                    <RouterLink to="memberships"
                        class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg"
                        :class="{ 'bg-gray-100 rounded-lg': $route.path === '/memberships' }">
                        <i class="fa-solid fa-id-card w-6 mr-2"></i>
                        Memberships
                    </RouterLink>
                </li>

                <!-- Menu  Members -->
                <li>
                    <RouterLink to="members" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg"
                        :class="{ 'bg-gray-100 rounded-lg': $route.path === '/members' }">
                        <i class="fa-solid fa-users w-6 mr-2 text-gray-600"></i>
                        Members
                    </RouterLink>
                </li>
            </ul>
        </div>

        <!-- Others Group -->
        <div class="mt-5">
            <h3 class="mb-4 text-xs font-semibold uppercase text-gray-400">Memberships</h3>
            <ul class="space-y-2">
                <!-- New Member -->
                <li>
                    <RouterLink to="new-member" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg"
                        :class="{ 'bg-gray-100 rounded-lg': $route.path === '/new-member' }">
                        <i class="fa-solid fa-user-plus w-6 mr-2 text-gray-600"></i>
                        New Member
                    </RouterLink>
                </li>

                <!-- New Membership -->
                <li>
                    <RouterLink to="new-membership"
                        class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg"
                        :class="{ 'bg-gray-100 rounded-lg': $route.path === '/new-membership' }">
                        <i class="fa-solid fa-file-circle-plus w-6 mr-2"></i>
                        New Membership
                    </RouterLink>
                </li>
            </ul>
        </div>

        <!-- Others Group -->
        <div class="mt-5">
            <h3 class="mb-4 text-xs font-semibold uppercase text-gray-400">System</h3>
            <ul class="space-y-2">
                <!-- Item Plans -->
                <li>
                    <RouterLink to="plans" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg"
                        :class="{ 'bg-gray-100 rounded-lg': $route.path === '/plans' }">
                        <i class="fa-solid fa-layer-group w-6 mr-2 text-gray-600"></i>
                        Plans
                    </RouterLink>
                </li>

                <!-- Item Invoices -->
                <li>
                    <RouterLink to="invoices" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg"
                        :class="{ 'bg-gray-100 rounded-lg': $route.path === '/invoices' }">
                        <i class="fa-solid fa-credit-card w-6 mr-2 text-gray-600"></i>
                        Payments & Invoices
                    </RouterLink>
                </li>

                <!-- Item Authentication -->
                <!-- <li>
                    <a href="#" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z">
                            </path>
                        </svg>
                        Authentication
                        <svg class="ml-auto w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4.792 7.396l5.208 5.208 5.208-5.208"></path>
                        </svg>
                    </a>
                    <ul class="pl-8 space-y-1 hidden" data-dropdown="authentication">
                        <li><a href="#" class="block p-2 text-gray-600 hover:bg-gray-100 rounded-lg">Sign
                                In</a></li>
                        <li><a href="#" class="block p-2 text-gray-600 hover:bg-gray-100 rounded-lg">Sign
                                Up</a></li>
                    </ul>
                </li> -->
            </ul>
        </div>

        <div class="mt-5 border-t border-gray-300 pt-4">
            <ul>
                <li>
                    <RouterLink to="/login" @click.prevent="logout"
                        class="flex items-center p-2 text-red-700 hover:bg-red-100 rounded-lg">
                        <i class="fa-solid fa-right-from-bracket w-6 mr-2 text-red-700"></i>
                        Logout
                    </RouterLink>
                </li>
            </ul>
        </div>


    </nav>


</template>