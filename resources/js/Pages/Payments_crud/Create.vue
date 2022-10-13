<script setup>
    import AdminLayout from "@/Layouts/AdminLayout.vue";
    import { Head } from "@inertiajs/inertia-vue3";
    //import BreezeButton from "@/Components/Button.vue";
    import { Link } from "@inertiajs/inertia-vue3";
    import { useForm } from "@inertiajs/inertia-vue3";
    
    const props = defineProps({
        payment: {
            type: Object,
            default: () => ({}),
        },
    });
    
    
    const form = useForm();
    
    const submit = () => {
        form.post(route("payment_crud.store",form));
    };
    </script>
    
    <template>
        <Head title="Blog Create" />
    
        <AdminLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Blog Create
                </h2>
            </template>
    
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <form @submit.prevent="submit">
                                <div class="mb-6">
                                    <label for="merchant_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" >Merchant Id</label>
                                    <input type="text" v-model="form.merchant_id" name="merchant_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder=""/>
                                    <div v-if="form.errors.merchant_id" class="text-sm text-red-600">
                                        {{ form.errors.merchant_id }}
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <label for="MerchanTid" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" >MerchanTid</label>
                                    <input type="text" v-model="form.merchantTid" name="merchantTid" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder=""/>
                                    <div v-if="form.errors.merchantTid" class="text-sm text-red-600">
                                        {{ form.errors.merchantTid }}
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <label for="MerchanTid" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" >merchant_order_id</label>
                                    <input type="text" v-model="form.merchant_order_id" name="merchant_order_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder=""/>
                                    <div v-if="form.errors.merchant_order_id" class="text-sm text-red-600">
                                        {{ form.errors.merchant_order_id }}
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <label for="MerchanTid" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" >merchant_user_id</label>
                                    <input type="text" v-model="form.merchant_user_id" name="merchant_user_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder=""/>
                                    <div v-if="form.errors.merchant_user_id" class="text-sm text-red-600">
                                        {{ form.errors.merchant_user_id }}
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <label for="MerchanTid" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" >amount</label>
                                    <input type="text" v-model="form.amount" name="amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder=""/>
                                    <div v-if="form.errors.amount" class="text-sm text-red-600">
                                        {{ form.errors.amount }}
                                    </div>
                                </div>
                                
                                <!-- <div class="mb-6">
                                    <label
                                        for="slug"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        >Content</label
                                    >
                                    <textarea
                                        type="text"
                                        v-model="form.content"
                                        name="content"
                                        id=""
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    ></textarea>
    
                                    <div
                                        v-if="form.errors.content"
                                        class="text-sm text-red-600"
                                    >
                                        {{ form.errors.content }}
                                    </div>
                                </div> -->
                                <button
                                    type="submit"
                                    class="text-white bg-blue-700  focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 "
                                    :disabled="form.processing"
                                    :class="{ 'opacity-25': form.processing }"
                                >
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AdminLayout>
    </template>