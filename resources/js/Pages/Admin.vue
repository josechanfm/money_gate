<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Dashboard from '@/Components/Admin/Dashboard.vue';

defineProps({
    data: Object,
    orders: Object,
});

const columns = [
    {
        title: 'Order Number',
        dataIndex: 'order_no',
        key: 'order_no',
    },{
        title: 'User No',
        dataIndex: 'merchantUserNo',
        key: 'age',
    },{
        title: 'Amount',
        dataIndex: 'amount',
        key: 'amount',
    },
]
</script>

<template>
    <AdminLayout title="Dashboard">
        <a-page-header
            title="Admin"
            sub-title="Online Payment Back-end"
        >
        </a-page-header>

        <div class="grid grid-cols-3 gap-2">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <h3 class="text-2xl font-bold dark:text-black py-2">Order</h3>
                <a-table :dataSource="orders" :columns="columns" />
            </div>
        </div>

        <!-- <Dashboard /> -->
    </AdminLayout>
</template>

