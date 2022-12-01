<template>
  <a-tabs v-model:activeKey="activeKey" >
    <a-tab-pane v-for="(tab,key) in tabs" :key="key" :tab="tab" >
      <a-table :columns="columns" :data-source="paymentList">
        <template #bodyCell="{ column, text, record }">
          <template v-if="['merchant_id','merchant_order_id','currency','amount','status'].includes(column.dataIndex)">
            {{ text }}
          </template>
          <template v-else>
            <a @click="edit(record.key)">Edit</a>
          </template>
        </template>
      </a-table>
    </a-tab-pane>      
  </a-tabs>
</template>

<script>
import { defineComponent, ref } from 'vue';

export default {
  props: {
    payments: {
      type: Array,
      required: true
    }
  },
  created(){
      
  },
  mounted(){
  },  
  computed:{
    paymentList(){
      return this.payments.filter( e=>{ return e.status == this.tabs[this.activeKey]}  )
    }
  },
  methods:{
    handleClick(){
      console.log("click")
    }
  },
  setup() {
    
    return {
      editableData:"",

      activeLabel: "All",

      activeKey: ref('1'),
      tabs:[
        "All","SENT","SUCCESS","Fail"
      ],
      columns: [
        {
          title: 'Merchant ID',
          dataIndex: 'merchant_id',
          key: 'merchant_id',
        },
        {
          title: 'Order ID',
          dataIndex: 'merchant_order_id',
          key: 'merchant_order_id',
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