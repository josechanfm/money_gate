
    <template>
        <Head title="Payments" />
        <admin-layout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Payment Index 
                </h2>
            </template>
            <!-- <a-button type="primary" href="./payment/create">Primary Button</a-button> -->
            <!-- <a-tabs v-model:activeKey="activeKey"> -->
                <!-- <a-tab-pane key="1" tab="All">
                    <template>
                        <a-table 
                            :dataSource="dataSource" 
                            :columns="columns" 
                            :pagination="pagination"
                            :loading="loading"
                            show-size-changer
                            :customRow="customRow"
                            @change="handleTableChange"
                            />
                    </template>
                </a-tab-pane> -->
                <list :payments="payments"></list>
                <!-- <a-tab-pane key="1" tab="All">
                    <ListAll/>
                </a-tab-pane> -->
                <!-- <a-tab-pane key="1" tab="All">
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
                </a-tab-pane> -->
    </admin-layout>

</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
// import { Head, Link } from "@inertiajs/inertia-vue3";
//import Button from "@/Components/Button.vue";
// import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import List from '@/Pages/Payments/List.vue';
import ListAll from '@/Pages/Payments/ListAll.vue';
import ListSucceed from '@/Pages/Payments/ListSucceed.vue';
import ListRefunded from '@/Pages/Payments/ListRefunded.vue';
import ListUncaptured from '@/Pages/Payments/ListUncaptured.vue';
import ListFailed from '@/Pages/Payments/ListFailed.vue';


// const activeKey=ref('1');

export default {
    props:['payments'],
    components: {
        AdminLayout,
        List,
        ListAll,
        ListFailed,
        ListSucceed,
        ListRefunded,
        ListUncaptured,
        Inertia,
    },
};

</script>
