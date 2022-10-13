<script setup>
    import AdminLayout from "@/Layouts/AdminLayout.vue";
    import { Head } from "@inertiajs/inertia-vue3";
    import { Link } from "@inertiajs/inertia-vue3";
    
    const props = defineProps({
        payment: Object,
    });
        

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
                            <ul>
                                <li v-for="(value,field) in payment">
                                    {{field}}:{{value}}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </AdminLayout>
    </template>