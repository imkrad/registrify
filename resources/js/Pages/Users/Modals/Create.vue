<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 700px;" header-class="p-3 bg-light" :title="(!editable) ? 'Create Staff' : 'Edit Staff'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3 mt-2">
                
                <BCol lg="6" class="mt-n1">
                    <InputLabel for="name" value="Lastname" :message="form.errors.lastname"/>
                    <TextInput type="text" v-model="form.lastname" class="form-control" placeholder="Please lastname" @input="handleInput('lastname')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-n1">
                    <InputLabel for="name" value="Firstname" :message="form.errors.firstname"/>
                    <TextInput type="text" v-model="form.firstname" class="form-control" placeholder="Please firstname" @input="handleInput('firstname')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-n1">
                    <InputLabel for="name" value="Middlename" :message="form.errors.middlename"/>
                    <TextInput type="text" v-model="form.middlename" class="form-control" placeholder="Please middlename" @input="handleInput('middlename')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-n1">
                    <InputLabel for="name" value="Suffix" :message="form.errors.suffix"/>
                    <TextInput type="text" v-model="form.suffix" class="form-control" placeholder="Please suffix" @input="handleInput('suffix')" :light="true"/>
                </BCol>
                <BCol lg="12" class="mt-0 mb-n3"><hr class="text-muted"/></BCol>
                <BCol lg="8" style="margin-top: 13px; margin-bottom: -12px;" class="fs-12" :class="(form.errors.sex) ? 'text-danger' : ''">Please select sex :</BCol>
                <BCol lg="4" style="margin-top: 13px; margin-bottom: -12px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="customRadio1" class="custom-control-input me-2" @input="handleInput('gender')" value="Male" v-model="form.gender">
                                <label class="custom-control-label fw-normal fs-12" for="customRadio1">Male</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="customRadio2" class="custom-control-input me-2" @input="handleInput('gender')" value="Female" v-model="form.gender">
                                <label class="custom-control-label fw-normal fs-12" for="customRadio2">Female</label>
                            </div>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12" class="mt-n2 mb-n3"><hr class="text-muted"/></BCol>
                 <BCol lg="6" class="mt-2">
                    <InputLabel for="name" value="Email" :message="form.errors.email"/>
                    <TextInput type="text" v-model="form.email" class="form-control" placeholder="Please email" @input="handleInput('email')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-2">
                    <InputLabel for="name" value="Contact no." :message="form.errors.mobile"/>
                    <TextInput type="text" v-model="form.mobile" class="form-control" placeholder="Please mobile" @input="handleInput('mobile')" :light="true"/>
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
    props: ['names','documents','fees'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                firstname: null,
                middlename: null,
                lastname: null,
                suffix: null,
                email: null,
                mobile: null,
                gender: null,
                role: 'Registrar'
            }),
            showModal: false,
            editable: false
        }
    },
    methods: { 
        show(){
            this.form.reset();
            this.showModal = true;
        },
        edit(data){
            this.editable = true;
            this.form.id = data.id;
            this.form.firstname = data.firstname;
            this.form.middlename = data.middlename;
            this.form.lastname = data.lastname;
            this.form.suffix = data.suffix;
            this.form.email = data.email;
            this.form.mobile = data.mobile;
            this.form.gender = data.gender;
            this.form.role = 'Registrar';
            this.showModal = true;
        },
        submit(){
            if(this.editable){
                this.form.put('/users/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('update',true);
                        this.form.reset();
                        this.hide();
                    }
                });
            }else{
                this.form.post('/users',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('update',true);
                        this.hide();
                    },
                });
            }
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