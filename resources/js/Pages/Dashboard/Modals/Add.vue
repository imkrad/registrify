<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Add User" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-2">
                <BCol lg="12" class="mt-0">
                    <InputLabel value="ID Number" :message="form.errors.id_number"/>
                    <TextInput v-model="form.id_number" type="text" class="form-control" placeholder="Please enter id number" :light="true"/>
                </BCol>   
                <BCol lg="6" class="mt-0">
                    <InputLabel value="First name" :message="form.errors.firstname"/>
                    <TextInput v-model="form.firstname" type="text" class="form-control" placeholder="Please enter first name" :light="true"/>
                </BCol>   
                <BCol lg="6" class="mt-0">
                    <InputLabel value="Last name" :message="form.errors.lastname"/>
                    <TextInput v-model="form.lastname" type="text" class="form-control" placeholder="Please enter last name" :light="true"/>
                </BCol>   
                <BCol lg="6" class="mt-0">
                    <InputLabel value="Contact no." :message="form.errors.contact_no"/>
                    <TextInput v-model="form.contact_no" type="text" class="form-control" placeholder="Please enter contact" :light="true"/>
                </BCol>  
                <BCol lg="6" class="mt-0">
                    <InputLabel value="Email" :message="form.errors.email"/>
                    <TextInput v-model="form.email" type="text" class="form-control" placeholder="Please enter email address" :light="true"/>
                </BCol>  
                <BCol lg="12" class="mt-0 mb-n2"><hr class="text-muted"/></BCol>
                <BCol lg="7" style="margin-top: 5px; margin-bottom: -18px;" class="fs-12" :class="(form.errors.sex) ? 'text-danger' : ''">Please select sex :</BCol>
                <BCol lg="5" style="margin-top: 5px; margin-bottom: -18px;">
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
                <BCol lg="12" class="mt-0 mb-n2"><hr class="text-muted"/></BCol>
            </BRow>     
        </form>       
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput },
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id_number: null,
                firstname: null,
                lastname: null,
                contact_no: null,
                email: null,
                sex: null,
                is_onsite: 'onsite'
            }),
            showModal: false
        }
    },
    methods: { 
        show(){
            this.showModal = true;
        },
        submit(){
            this.form.post('/register',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('selected',this.$page.props.flash.data);
                    this.form.clearErrors();
                    this.form.reset();
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>