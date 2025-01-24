<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Add Comment" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row g-2 mt-n2">
            <form class="customform">
                <BCol lg="12" class="mt-2">
                    <InputLabel for="name" value="Comment" :message="form.errors.message"/>
                    <TextInput type="text" v-model="form.message" class="form-control" placeholder="Please add comment"  :light="true"/>
                </BCol>
            </form>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="submit()" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
export default {
    components: { TextInput, InputLabel },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                message: null
            }),
            showModal: false
        }
    },
    methods: { 
        show(id){
            this.form.id = id;
            this.showModal = true;
        },
        submit(){
            this.form = this.$inertia.form({
                id: this.form.id,
                message: this.form.message,
                type: 'comment'
            });

            this.form.post('/requests',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update',response.props.flash.data.data);
                    this.hide();
                },
            });
        },
        hide(){
            this.form.id = null;
            this.form.message = null;
            this.showModal = false;
        }
    }
}
</script>