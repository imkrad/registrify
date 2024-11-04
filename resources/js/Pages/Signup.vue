<template>
     <BModal v-model="showModal" style="--vz-modal-width: 700px;" hide-footer body-class="p-0" header-class="p-0"
        class="v-modal-custom" content-class="border-0 overflow-hidden" centered hide-header-close>
        <div class="modal-body login-modal p-5">
            <h5 class="text-white fs-16 mb-1 mt-n4">Sign Up</h5>
            <p class="text-white-50 fs-11 mb-4">Please fill out the form carefully to ensure all information is accurate.</p>
            <div class="vstack gap-2 justify-content-center">
               <form class="customform mb-n5" style="color: white;">
                    <BRow class="g-3 mb-4 mt-1"> 
                        <BCol lg="6" class="mt-n1">
                            <InputLabel for="name" value="ID number" :message="form.errors.id_number"/>
                            <TextInput type="text" v-model="form.id_number" class="form-control" placeholder="Please lastname" @input="handleInput('id_number')" :light="true"/>
                        </BCol>
                        <BCol lg="6" class="mt-n1">
                            <InputLabel for="name" value="Contact" :message="form.errors.contact_no"/>
                            <TextInput type="text" v-model="form.contact_no" class="form-control" placeholder="Please enter contact no." @input="handleInput('contact_no')" :light="true"/>
                        </BCol>
                        <BCol lg="12" class="mt-0">
                            <hr class="text-muted"/>
                        </BCol>
                        <BCol lg="6" class="mt-n2">
                            <InputLabel for="name" value="Lastname" :message="form.errors.lastname"/>
                            <TextInput type="text" v-model="form.lastname" class="form-control" placeholder="Please lastname" @input="handleInput('lastname')" :light="true"/>
                        </BCol>
                        <BCol lg="6" class="mt-n2">
                            <InputLabel for="name" value="Firstname" :message="form.errors.firstname"/>
                            <TextInput type="text" v-model="form.firstname" class="form-control" placeholder="Please firstname" @input="handleInput('firstname')" :light="true"/>
                        </BCol>
                        <BCol lg="6" class="mt-0">
                            <InputLabel for="name" value="Middlename" :message="form.errors.middlename"/>
                            <TextInput type="text" v-model="form.middlename" class="form-control" placeholder="Please middlename" @input="handleInput('middlename')" :light="true"/>
                        </BCol>
                        <BCol lg="6" class="mt-0">
                            <InputLabel for="name" value="Suffix" :message="form.errors.suffix"/>
                            <TextInput type="text" v-model="form.suffix" class="form-control" placeholder="Please suffix" @input="handleInput('suffix')" :light="true"/>
                        </BCol>
                    </BRow>
               </form>
            </div>
        </div>
        <div class="modal-body p-5">
            <form class="customform">
                <BRow class="g-3" style="margin-top: -35px;"> 
                    <BCol lg="8" style="margin-top: 5px; margin-bottom: -18px;" class="fs-12" :class="(form.errors.sex) ? 'text-danger' : ''">Please select sex :</BCol>
                    <BCol lg="4" style="margin-top: 5px; margin-bottom: -18px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="custom-control custom-radio mb-3">
                                    <input type="radio" id="customRadio1" class="custom-control-input me-2" @input="handleInput('sex')" value="Male" v-model="form.sex">
                                    <label class="custom-control-label fw-normal fs-12" for="customRadio1">Male</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="custom-control custom-radio mb-3">
                                    <input type="radio" id="customRadio2" class="custom-control-input me-2" @input="handleInput('sex')" value="Female" v-model="form.sex">
                                    <label class="custom-control-label fw-normal fs-12" for="customRadio2">Female</label>
                                </div>
                            </div>
                        </div>
                    </BCol>
                    <BCol lg="12" class="mt-0">
                            <hr class="text-muted"/>
                        </BCol>
                    <BCol lg="12" class="mt-n2">
                        <InputLabel for="name" value="Email" :message="form.errors.email"/>
                        <TextInput type="email" v-model="form.email" class="form-control" placeholder="Please enter email" @input="handleInput('email')" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-0">
                        <InputLabel for="name" value="Password" :message="form.errors.password"/>
                        <TextInput type="password" v-model="form.password" class="form-control" placeholder="Please enter password" @input="handleInput('email')" :light="true"/>
                    </BCol>
                    <BCol lg="6" class="mt-0">
                        <InputLabel for="name" value="Password" :message="form.errors.password_confirmation"/>
                        <TextInput type="password" v-model="form.password_confirmation" class="form-control" placeholder="Please enter password" @input="handleInput('contact_no')" :light="true"/>
                    </BCol>
                </BRow>
                <div class="mt-4 form-check">
                    <input type="checkbox" v-model="form.check" class="form-check-input" id="checkTerms">
                    <label class="form-check-label text-muted" for="checkTerms">I agree to the <span class="text-primary fw-semibold">Terms of Service & Privacy Policy</span></label>
                </div>
                <div class="text-end mt-2">
                    <button @click="submit('ok')" class="btn btn-primary btn-md" type="button" :disabled="!form.check">
                        <div class="btn-content">Submit Now</div>
                    </button>
                </div>
            </form>
        </div>
    </BModal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: {Multiselect, InputLabel, TextInput },
    data(){
        return {
            form: useForm({
                id: null,
                firstname: null,
                middlename: null,
                lastname: null,
                suffix: null,
                email: null,
                contact_no: null,
                sex: null,
                id_number: null,
                password: null,
                password_confirmation: null
            }),
            showModal: false,
            tos: false
        }
    },
    methods: {
        submit(){
            this.form.post('/register',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.form.idnumber = null;
                    this.form.clearErrors();
                    this.form.reset();
                    this.hide();
                },
            });
        },
        show(){
            this.showModal = true;
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.reset();
            this.showModal = false;
        }
    }
}
</script>