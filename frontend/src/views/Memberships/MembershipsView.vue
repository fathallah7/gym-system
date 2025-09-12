<script setup>
import { reactive, ref } from 'vue';
import axios from 'axios';
import { onMounted } from 'vue';
import { useToast } from 'vue-toastification';
import Spinner from '@/components/Spinner.vue';
import Pagination from '@/components/Pagination.vue';
import MembershipsTable from './components/MembershipsTable.vue';
import PageHeader from '@/components/PageHeader.vue';
import ActionBar from '@/components/ActionBar.vue';
import EditModal from './components/EditModal.vue';

const isLoading = ref(false);
const toast = useToast();
const showModal = ref(false);

const memberships = ref();
const membershipStatusData = ref();
const memberID = ref();
const meta = ref({});

const fetchMemberships = async (page) => {
    try {
        isLoading.value = true;
        const response = await axios.get('/memberships',
            {
                params: {
                    page: page
                }
            }
        );
        console.log(response.data);
        memberships.value = response.data.data;

        if (response.data.meta) {
            meta.value = response.data.meta;
        } else {
            meta.value = {
                current_page: response.data.current_page,
                last_page: response.data.last_page,
                total: response.data.total,
            };
        }
    } catch (error) {
        console.log(error);
        toast.error('Failed to fetch memberships.');
    } finally {
        isLoading.value = false;
    }
};

const memberUpdateStatus = async () => {
    try {
        await axios.put(`/memberships/${memberID.value}`, {
            status: membershipStatusData.value,
        });
        toast.success('Membership status updated successfully.');
        fetchMemberships();
        isLoading.value = false;
        closeModal();
    } catch (error) {
        console.log(error);
        toast.error('Failed to update membership status.');
    }
};

const deleteMembership = async (id) => {
    if (confirm('Are You Sure For Delete This Membership')) {
        try {
            await axios.delete(`/memberships/${id}`);
            toast.success('Membership deleted successfully.');
            fetchMemberships();
            isLoading.value = false;
        } catch (error) {
            console.log(error);
            toast.error('Failed to delete membership.');
        }
    }
}

const attendance = async (id, name) => {
    try {
        await axios.put(`/memberships/${id}/attendance`);
        toast.success(`Attendance recorded successfully for ${name}.`);
        fetchMemberships();
        isLoading.value = false;
    } catch (error) {
        console.log(error);
        toast.error(`Failed to record attendance for ${name}.`);
    }
};

const openEditModal = (member) => {
    showModal.value = true;
    membershipStatusData.value = member.status;
    memberID.value = member.id;
};

const closeModal = () => {
    showModal.value = false;
};

onMounted(() => {
    fetchMemberships(1);
});
</script>

<template>

    <PageHeader title="Memberships" icon="fa-solid fa-id-card" />

    <div class="p-6 overflow-x-auto mx-auto max-w-8xl">
        <!-- Search Bar -->
        <ActionBar toRoute="/new-membership" buttonText="New Membership" placeholder="Search memberships.." />

        <!-- Loading Spinner -->
        <Spinner v-if="isLoading" class="flex justify-center items-center" />

        <!-- Table -->
        <MembershipsTable v-else :memberships="memberships" :isLoading="isLoading" :meta="meta"
            @edit-membership="openEditModal" @delete-membership="deleteMembership" @attendance="attendance" />

        <!-- Modal -->
        <EditModal v-if="showModal" :showModal="showModal" :isLoading="isLoading" @close-modal="closeModal"
            @member-update-status="memberUpdateStatus" v-model:membershipStatusData="membershipStatusData" />
    </div>

    <!-- Pagination -->
    <Pagination v-if="meta && meta.last_page" :meta="meta" @page-changed="fetchMemberships" />

</template>
