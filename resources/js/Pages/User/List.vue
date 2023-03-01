<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Dashboard from '@/Components/Admin/Dashboard.vue';
import { onMounted } from 'vue';

let props = defineProps({
    users: Object,
});

onMounted(() => {
    console.log(props.users[0])
})

const columns = [
    {
        title: 'Name',
        dataIndex: 'name',
        key: 'name',
    },{
        title: 'Email',
        dataIndex: 'email',
        key: 'email',
    },{
        title: 'Roles',
        dataIndex: 'roles',
        key: 'roles',
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

        <div class="grid  gap-2">
            <div class="bg-white shadow-xl sm:rounded-lg px-4 py-4">
                
                <h3 class="text-2xl font-bold dark:text-black py-2">User List</h3>

                <a-table :dataSource="users" :columns="columns" >
                    <template #bodyCell="{ column, record }">
                        <template v-if="column.key === 'roles'">
                            123
                        </template>
                    </template>
                </a-table>
            </div>
        </div>

        <!-- <Dashboard /> -->
    </AdminLayout>
</template>

