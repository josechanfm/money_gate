<template>
  <a-table 
      :dataSource="dataSource" 
      :columns="columns" 
      :pagination="pagination"
      show-size-changer
      @change="handleTableChange"
    />
</template>
  <script>
    export default {
      setup() {
      },
      data(){
        return{
          columns: [
            {
              title: 'Name',
              dataIndex: 'merchant_id',
              key: 'merchant_id',
              sorter:true
            },
            {
              title: 'Age',
              dataIndex: 'merchantTid',
              key: 'merchantTid',
              sorter:true
            },
            {
              title: 'Address',
              dataIndex: 'currency',
              key: 'currency',
            },
          ],
          dataSource: [
          ],
          pagination:{
            current:1,
            pageSize:10
          },
          sorter:{
            field:'id',
            order:'desc'
          },
          params:{
            total:0,
            page:1,
            pageSize:10,
            sorter:'id',
            order:'asc',
            filter:'uncaptured'
          },
          loading:false
        }
      },  
      mounted(){
        this.fetchData();
      },
      methods:{
        fetchData:function(){
          this.loading=true;
          //axios.get('../payment/table_list?page='+page.current+'&pageSize='+page.pageSize+"&sorter="+this.sorter.field+'&order='+this.sorter.order)
          axios.get('../payment/table_list',{
            params:this.params
          })
            .then(response=>{
              this.dataSource=response.data.data;
              this.pagination.pageSize=response.data.per_page;
              this.pagination.total=response.data.total;
              this.pagination.current=response.data.current_page;
              this.loading=false;
            })
        },
        handleTableChange: function(pag, filters, sorter){
          this.params.page=pag.current;
          this.params.pageSize=pag.pageSize;
          this.params.sorter=sorter.order===undefined?'id':sorter.field;
          this.params.order=sorter.order===undefined?'desc':sorter.order=='ascend'?'asc':'desc';
          this.fetchData();

        },
      }
    };
  </script>