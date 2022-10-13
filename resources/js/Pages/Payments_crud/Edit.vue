<script setup>
    import AdminLayout from "@/Layouts/AdminLayout.vue";
    import { Head } from "@inertiajs/inertia-vue3";
    //import BreezeButton from "@/Components/Button.vue";
    import { Link } from "@inertiajs/inertia-vue3";
    import { useForm } from "@inertiajs/inertia-vue3";
    
    const props = defineProps({
        payment: Object,
    });
    
    const form = useForm({
        id: props.payment.id,
        merchant_id: props.payment.merchant_id,
        merchantTid: props.payment.merchantTid,
        content: props.payment.content,
    });
    
    
    const submit = () => {
        form.put(route("payment.update", props.payment.id));
    };
    </script>
    
    <template>
        <Head title="Blog Edit" />
    
        <AdminLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Payment Edit
                </h2>
            </template>
    
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <form @submit.prevent="submit">
                                <div class="mb-6">
                                    <label
                                        for="Merchant_id"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        >Merchant ID</label
                                    >
                                    <input
                                        type="text"
                                        v-model="form.merchant_id"
                                        name="merchant_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder=""
                                    />
                                    <div
                                        v-if="form.errors.merchant_id"
                                        class="text-sm text-red-600"
                                    >
                                        {{ form.errors.merchant_id }}
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <label
                                        for="MerchantTid"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        >MertchantTid</label
                                    >
                                    <input
                                        type="text"
                                        v-model="form.merchantTid"
                                        name="merchantTid"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder=""
                                    />
                                    <div
                                        v-if="form.errors.merchantTid"
                                        class="text-sm text-red-600"
                                    >
                                        {{ form.errors.merchanTid }}
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