<script>
    import AdminLayout from '@/Layouts/AdminLayout.vue';

    export default {
        components: {
            AdminLayout,
        },
        props: ['payments', 'errors'],
        data() {
            return {
                editMode: false,
                isOpen: false,
                form: {
                    title: null,
                },
            }
        },
        methods: {
            openModal() {
                this.isOpen = true;
            },
            closeModal() {
                this.isOpen = false;
                this.reset();
                this.editMode=false;
            },
            reset() {
                this.form = {
                    title: null,
                    body: null,
                }
            },
            save(data) {
                this.$inertia.post('/payment/payments', data)
                this.reset();
                this.closeModal();
                this.editMode = false;
            },
            edit(data) {
                this.form = Object.assign({}, data);
                this.editMode = true;
                this.openModal();
            },
            update(data) {
                this.$inertia.patch('/payment/payments/' + data.id, data)
                this.reset();
                this.closeModal();
            },
            deleteRow(data) {
                if (!confirm('Are you sure want to remove?')) return;
                this.$inertia.delete('/payment/payments/' + data.id, data)
                this.reset();
                this.closeModal();
            },
            postOrder(data){
                let arr = {
                    application_id : data.id ,
                    amount : '100',
                    bank : 'ICBC'
                }
                    
                this.$inertia.post( route('payment.payments.createOrder')  , arr , {
                    onSuccess (page) {
                        console.log('success', page)
                    },
                    onError (errors) {
                        console.log('err', errors)
                    },
                    onFinish (visit) {
                        console.log('visit', visit)
                    }
                })
            }
        },
    }
</script>

<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                  <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-if="$page.props.flash.message">
                    <div class="flex">
                      <div>
                        <p class="text-sm">{{ $page.props.flash.message }}</p>
                      </div>
                    </div>
                  </div>
                  <button @click="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Create New Post</button>
                  <table class="table-fixed w-full">
                      <thead>
                          <tr class="bg-gray-100">
                              <th class="px-4 py-2 w-20">No.</th>
                              <th class="px-4 py-2">Merchant Id</th>
                              <th class="px-4 py-2">MerchantT Id</th>
                              <th class="px-4 py-2">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr v-for="row in payments.data" :key="row.id">
                              <td class="border px-4 py-2">{{ row.id }}</td>
                              <td class="border px-4 py-2">{{ row.merchant_id }}</td>
                              <td class="border px-4 py-2">{{ row.merchantTid }}</td>
                              <td class="border px-4 py-2">
                                  <button @click="edit(row)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                                  <button @click="deleteRow(row)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                  
                                  <!-- Post the order  -->
                                  <button @click="postOrder(row)" class="bg-stone-500 hover:bg-stone-700 text-white font-bold py-2 px-4 rounded">Post</button>
                              </td>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
    </AdminLayout>

    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
        
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Merchant ID:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Title" v-model="form.merchant_id">
                            <div v-if="$page.props.errors.merchant_id" class="text-red-500">{{ $page.props.errors.merchant_id[0] }}</div>
                        </div>
                    </div>
                    <div class="">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">MerchantT ID:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Title" v-model="form.merchantTid">
                            <div v-if="$page.props.errors.merchantTid" class="text-red-500">{{ $page.props.errors.merchantTid[0] }}</div>
                        </div>
                    </div>
                    <div class="">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">merchant_order_id:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Title" v-model="form.merchant_order_id">
                            <div v-if="$page.props.errors.merchant_order_id" class="text-red-500">{{ $page.props.errors.merchant_order_id[0] }}</div>
                        </div>
                    </div>
                    <div class="">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">merchant_user_id:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Title" v-model="form.merchant_user_id">
                            <div v-if="$page.props.errors.merchant_user_id" class="text-red-500">{{ $page.props.errors.merchant_user_id[0] }}</div>
                        </div>
                    </div>
                    <div class="">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">amount:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Title" v-model="form.amount">
                            <div v-if="$page.props.errors.amount" class="text-red-500">{{ $page.props.errors.amount[0] }}</div>
                        </div>
                    </div>
                    <div class="">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">timeout:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Title" v-model="form.timeout">
                            <div v-if="$page.props.errors.timeout" class="text-red-500">{{ $page.props.errors.timeout[0] }}</div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="!editMode" @click="save(form)">
                            Save
                        </button>
                    </span>
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="editMode" @click="update(form)">
                            Update
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                    
                        <button @click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Cancel
                        </button>
                    </span>
                </div>
            </form>
            
            </div>
        </div>
    </div>

</template>

