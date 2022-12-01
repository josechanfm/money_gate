
<template>
    <Head title="Payments" />
    <admin-layout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Payment Index 
            </h2>
        </template>
        <list :orders="orders"></list>
    </admin-layout>

</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import List from '@/Pages/Orders/List.vue';


// const activeKey=ref('1');

export default {
    props:['orders'],
    components: {
        AdminLayout,
        List,
        Inertia,
    },
};

</script>
