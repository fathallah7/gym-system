<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { onMounted } from 'vue';
import { useToast } from 'vue-toastification';
import Spinner from '@/components/Spinner.vue';
import Pagination from '@/components/Pagination.vue';
import MembersTable from './components/MembersTable.vue';
import PageHeader from '@/components/PageHeader.vue';
import ActionBar from '@/components/ActionBar.vue';

const isLoading = ref(false);

const toast = useToast();

const members = ref();
const meta = ref({});

const fetchMembers = async (page) => {
    try {
        isLoading.value = true;
        const response = await axios.get('/member', {
            params: {
                page: page
            }
        });
        members.value = response.data.data;
        if (response.data.meta) {
            meta.value = response.data.meta;
        } else {
            meta.value = {
                current_page: response.data.current_page,
                last_page: response.data.last_page,
                total: response.data.total,
            };
        }
        console.log('Members fetched successfully:', members.value);
    } catch (error) {
        console.log(error);
    } finally {
        isLoading.value = false;
    }
};

const deleteMember = async ($id) => {
    if (confirm('Are you sure you want to delete this member?')) {
        try {
            await axios.delete(`/member/${$id}`);
            toast.success('Member deleted successfully!');
            fetchMembers();
        } catch (error) {
            toast.error('Failed to delete member.');
        }
    }
};

onMounted(() => {
    fetchMembers(1);
});

</script>


<template>

    <!-- Header -->
    <PageHeader title="Members" icon="fa-solid fa-users " />

    <div class="p-6 overflow-x-auto mx-auto max-w-8xl">
        <!-- Bar -->
        <ActionBar toRoute="/new-member" buttonText="New Member" placeholder="Search members.." />

        <!-- Loading Spinner -->
        <Spinner v-if="isLoading" class="flex justify-center items-center" />

        <!-- Table -->
        <MembersTable v-else :members="members" :isLoading="isLoading" @delete-member="deleteMember" />
    </div>

    <!-- Pagination -->
    <Pagination v-if="meta && meta.last_page" :meta="meta" @page-changed="fetchMembers" />

</template>


<style scoped></style>