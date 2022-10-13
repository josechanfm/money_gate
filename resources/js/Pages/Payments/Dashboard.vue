<script setup>
    import AdminLayout from "@/Layouts/AdminLayout.vue";
    import { Head } from "@inertiajs/inertia-vue3";
    //import Button from "@/Components/Button.vue";
    // import { Link } from "@inertiajs/inertia-vue3";
    // import { Inertia } from "@inertiajs/inertia";
    import { defineComponent, ref } from 'vue';
    import ListAll from '@/Pages/Payments/ListAll.vue';
    import ListSucceed from '@/Pages/Payments/ListSucceed.vue';
    import ListRefunded from '@/Pages/Payments/ListRefunded.vue';
    import ListUncaptured from '@/Pages/Payments/ListUncaptured.vue';
    import ListFailed from '@/Pages/Payments/ListFailed.vue';

    const activeKey=ref('1');
        
    </script>
    
    <template>
    
      <Head title="Payments" />
    
        <AdminLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Payment Index
                </h2>
            </template>
            <a-tabs v-model:activeKey="activeKey">
                <a-tab-pane key="1" tab="All">
                    <ListAll/>
                </a-tab-pane>
                <a-tab-pane key="2" tab="Succeeded" force-render >
                    <ListSucceed/>
                </a-tab-pane>
                <a-tab-pane key="3" tab="Refunded">
                    <ListRefunded/>
                </a-tab-pane>
                <a-tab-pane key="4" tab="Uncaptured">
                    <ListUncaptured/>
                </a-tab-pane>
                <a-tab-pane key="5" tab="Failed">
                    <ListFailed/>
                </a-tab-pane>
            </a-tabs>    

        </AdminLayout>
    </template>