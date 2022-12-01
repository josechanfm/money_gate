<template>
    <a-table :columns="columns" :data-source="orderList">
        <template #bodyCell="{ column, text, record }">
            <template v-if="column.dataIndex == 'operation'">
                <a @click="edit(record.key)">Edit</a>
            </template>
            <template v-else>
                {{ text }}
            </template>
        </template>
    </a-table>
  </template>
  
<script>
import { defineComponent, ref } from 'vue';
  
export default {
    props: {
        orders: {
            type: Array,
            required: true
        }
    },
    created(){
        
    },
    mounted(){
    },  
    computed:{
        orderList(){
            return this.orders;
        }
        
    },
    methods:{
    },
    setup() {
        return {
            
            statusFilter: "",
            columns: [
                {
                    title: 'Id',
                    dataIndex: 'id',
                    key: 'id',
                },
                {
                    title: 'Order ID',
                    dataIndex: 'merchantOrderId',
                    key: 'merchantOrderId',
                },
                {
                    title: 'Currency',
                    dataIndex: 'currency',
                    key: 'currency',
                },
                {
                    title: 'Amount',
                    dataIndex: 'amount',
                    key: 'amount',
                },
                {
                    title: 'Status',
                    dataIndex: 'status',
                    key: 'status',
                },
                {
                    title: 'operation',
                    dataIndex: 'operation',
                },
            ],
        };
    },
};
</script>