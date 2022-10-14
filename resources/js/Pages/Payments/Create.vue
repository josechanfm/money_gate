<script setup>
    import AdminLayout from "@/Layouts/AdminLayout.vue";
    import { Head } from "@inertiajs/inertia-vue3";
    import { Link } from "@inertiajs/inertia-vue3";
    import { useForm } from "@inertiajs/inertia-vue3";
    import { Form } from 'ant-design-vue';
    import { defineComponent, reactive,ref } from 'vue';

    const form = useForm({
        merchant_id: '',
        merchantTid: '',
        sign:'sign'

    });

    const layout = {
      labelCol: {
        span: 8,
      },
      wrapperCol: {
        span: 16,
      },
    };
    const validateMessages = {
      required: '${label} is required!',
      types: {
        email: '${label} is not a valid email!',
        number: '${label} is not a valid number!',
      },
      number: {
        range: '${label} must be between ${min} and ${max}',
      },
    };


    const onFinish = values => {
      console.log('Success:', values);
      //form.post(route("payment.store",form));
      form.post(route("payment.store",form));
    };
    const onFinishFailed = errorInfo => {
      console.log('Failed:', errorInfo);
    };
    const onSubmit=()=>{
      console.log("submit");
      form.post(route("payment.store",form));
    }
</script>
    
    <template>
        <Head title="Payment Create" />
    
        <AdminLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Payment Create
                </h2>
            </template>
                    <div class="flex" v-if="form.errors.api">
                      <div>
                        <p class="text-sm">{{ form.errors.api }}</p>
                      </div>
                    </div>
            <a-form
                :model="form"
                v-bind="layout"
                name="nest-messages"
                :validate-messages="validateMessages"
                @finish="onFinish"
            >
                <a-form-item :name="['merchant_id']" label="Merchant Id" :rules="[{ required: true }]">
                    <a-input v-model:value="form.merchant_id" />
                </a-form-item>
                <a-form-item :name="['merchantTid']" label="Merchant Tid" :rules="[{required: true }]">
                    <a-input v-model:value="form.merchantTid" />
                </a-form-item>
                <a-form-item :name="['merchant_order_id']" label="Merchan order id" :rules="[{required: true }]">
                    <a-input v-model:value="form.merchant_order_id" />
                </a-form-item>
                <a-form-item :name="['merchant_user_id']" label="Merchan user id" :rules="[{required: true }]">
                    <a-input v-model:value="form.merchant_user_id" />
                </a-form-item>
                <a-form-item :name="['amount']" label="Amount">
                    <a-input v-model:value="form.amount" />
                </a-form-item>
                <a-input v-model:value="form.sign" type="hidden" />
                <a-form-item :wrapper-col="{ ...layout.wrapperCol, offset: 8 }">
                <a-button type="primary" html-type="submit" >Submit</a-button>
                </a-form-item>
            </a-form>

        </AdminLayout>
    </template>