<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Dashboard from '@/Components/Admin/Dashboard.vue'
defineProps({
    data: Object,
});

</script>

<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <Dashboard />
    </AdminLayout>
</template>

