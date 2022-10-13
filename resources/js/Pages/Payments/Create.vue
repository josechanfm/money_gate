<script setup>
    import AdminLayout from "@/Layouts/AdminLayout.vue";
    import { Head } from "@inertiajs/inertia-vue3";
    //import BreezeButton from "@/Components/Button.vue";
    import { Link } from "@inertiajs/inertia-vue3";
    import { useForm } from "@inertiajs/inertia-vue3";
    import { Form } from 'ant-design-vue';

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
        <Head title="Payment Create" />
    
        <AdminLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Payment Create
                </h2>
            </template>
    
            <a-form-item label="username" :rules="[{required:true}]">
                <a-input v-model="form.username"></a-input>
                <a-input name="b"></a-input>
            </a-form-item>
        </AdminLayout>
    </template>