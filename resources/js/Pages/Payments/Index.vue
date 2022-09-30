<script setup>
    import AppLayout from "@/Layouts/AppLayout.vue";
    import { Head } from "@inertiajs/inertia-vue3";
    //import Button from "@/Components/Button.vue";
    import { Link } from "@inertiajs/inertia-vue3";
    import { Inertia } from "@inertiajs/inertia";
    import { useForm } from '@inertiajs/inertia-vue3';
    import Pagination from '@/Components/pagination.vue'

    const props = defineProps({
        payments: {
            type: Object,
            default: () => ({}),
        },
    });
    const form = useForm();
    
    function destroy(id) {
        if (confirm("Are you sure you want to Delete")) {
            form.delete(route('payment.destroy', id));
        }
    }
    </script>
    
    <template>
    
      <Head title="Blogs" />
    
        <AppLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Payment Index
                </h2>
            </template>
    
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div
                        v-if="$page.props.flash.message"
                        class="p-4 mb-4 text-sm text-green-500 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                        role="alert"
                    >
                        <span class="font-medium">
                            {{ $page.props.flash.message }}
                        </span>
                    </div>
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                           <div class="mb-2">
                                <Link :href="route('payment_crud.create')">
                                    <Button class="px-4 py-2 text-white bg-green-600 rounded-lg">Add Payment</Button>
                                </Link>
                            </div>
                             <div
                                class="relative overflow-x-auto shadow-md sm:rounded-lg"
                            >
                                <table
                                    class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                                >
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                                    >
                                        <tr>
                                            <th scope="col" class="px-6 py-3">#</th>
                                            <th scope="col" class="px-6 py-3">
                                                Merchant Id
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                MerchantTid
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Edit
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Show
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Delete
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="payment in payments.data"
                                            :key="payment.id"
                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                        >
                                            <th
                                                scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"
                                            >
                                                {{ payment.id }}
                                            </th>
                                            <th
                                                scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"
                                            >
                                                {{ payment.merchant_id }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ payment.merchantTid }}
                                            </td>
    
    
                                            <td class="px-6 py-4">
                                                <Link
                                                    :href="
                                                        route(
                                                            'payment_crud.edit',
                                                            payment.id
                                                        )
                                                    "
                                                   class="px-4 py-2 text-white bg-cyan-500 rounded-lg" >Edit</Link
                                                >
                                            </td>
                                            <td class="px-6 py-4">
                                                <Link
                                                    :href="
                                                        route(
                                                            'payment_crud.show',
                                                            payment.id
                                                        )
                                                    "
                                                   class="px-4 py-2 text-white bg-sky-500 rounded-lg" >Show</Link
                                                >
                                            </td>
                                            <td class="px-6 py-4">
                                                <Button
                                                    class="px-4 py-2 bg-rose-500 text-white rounded-lg"
                                                    @click="destroy(payment.id)"
                                                >
                                                    Delete
                                                </Button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <Pagination class="mt-6" :links="payments.links" />
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    </template>