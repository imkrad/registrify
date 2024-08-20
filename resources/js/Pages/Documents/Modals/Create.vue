<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 600px;" header-class="p-3 bg-light" :title="(!editable) ? 'Create Document' : 'Edit Document'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3 mt-2">
                
                <BCol lg="12" class="mt-1">
                    <InputLabel value="Document Name" :message="form.errors.name"/>
                    <TextInput v-model="form.name" type="text" class="form-control" placeholder="Please enter name" :class="{ 'is-invalid': form.errors.name }" @input="handleInput('name')" :light="true"/>
                </BCol>
               
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
    <Add @selected="set" ref="conforme"/>
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { Multiselect, InputLabel, TextInput },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                name: null
            }),
            showModal: false,
            editable: false
        }
    },
    methods: { 
        show(){
            this.showModal = true;
        },
        submit(){
            this.form.post('/requests',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('success',true);
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.reset();
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>