<template>
   <b-modal v-model="showModal" style="--vz-modal-width: 600px;" header-class="p-3 bg-light" title="Confirm" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3 mt-2"> 
                <BCol lg="12" class="mt-0 mb-2" :class="(errors.purpose) ? 'text-danger' : ''">
                    <div class="form-floating">
                        <input type="text" v-model="form.purpose" class="form-control">
                        <label :class="(errors.purpose) ? 'text-danger' : ''">Purpose</label>
                    </div>
                </BCol>      
                <BCol lg="12" class="mt-n3 mb-n4"><hr class="text-muted"/></BCol>
                <BCol lg="12" style="margin-top: 13px; margin-bottom: -5px;">
                    <div class="row fs-11">
                        <BCol lg="5" :class="(errors.is_personal) ? 'text-danger' : ''">Pickup Method :</BCol>
                        <div class="col-md-3" v-for="(list,index) in pickups"  v-bind:key="index">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="customRadio1" class="custom-control-input me-2" @input="handleInput('is_personal')" :value="list.value" v-model="form.is_personal">
                                <label class="custom-control-label fw-normal" for="customRadio1">{{list.name}}</label>
                            </div>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12" v-if="form.is_personal == false" class="mt-n3 mb-n4"><hr class="text-muted"/></BCol>
                <BCol lg="12" v-if="form.is_personal == false" style="margin-top: 13px; margin-bottom: -5px;">
                    <div class="row fs-11">
                        <BCol lg="6" :class="(form.errors.is_personal) ? 'text-danger' : ''">
                            <div class="form-floating">
                                <input type="text" v-model="form.name" class="form-control">
                                <label :class="(errors.name) ? 'text-danger' : ''">Authorized Person</label>
                            </div>
                        </BCol>
                        <BCol lg="6">
                            <input class="mt-3" type="file" id="file-upload" multiple @change="uploadFieldChange"/>
                        </BCol>
                    </div>
                </BCol>
                <BCol lg="12" :class="(form.is_personal == false) ? 'mt-n2 mb-n4' : 'mt-n3 mb-n4'"><hr class="text-muted"/></BCol>
                         
            </BRow>
            <div class="mt-4 form-check">
                <input type="checkbox" v-model="form.check" class="form-check-input" id="checkTerms">
                <label class="form-check-label text-muted" for="checkTerms">I agree to the <span class="text-primary fw-semibold">Terms of Service & Privacy Policy</span></label>
            </div>
        </form>
       
       <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" ::disabled="form.processing || !isFormValid" block>Submit</b-button>
        </template>
   </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
   components: {Multiselect, InputLabel, TextInput },
   props: ['graduates','colleges','types','fees'],
   data(){
       return {
           form: useForm({
               is_personal: null,
               name: null,
               purpose: null,
               check: false,
               attachments: []
           }),
           pickups: [
               {
                   'value': 1,
                   'name': 'Personal'
               },
               {
                   'value': 0,
                   'name': 'Authorized Person'
               }
           ],
           errors: [],
           tos: false,
           showModal: false,
       }
   },
   computed: {
        isFormValid() {
            return this.form.is_express && this.form.purpose;
        }
    },
   methods: {
        show(){
            this.showModal = true;
        },  
        submit(){
            this.$emit('submit', {
                form: {
                    purpose: this.form.purpose,
                    is_personal: this.form.is_personal,
                    name: this.form.name,
                    attachments: this.form.attachments
                }
            });
            this.showModal = false;
        },
       uploadFieldChange(e) {
           e.preventDefault();
           var files = e.target.files || e.dataTransfer.files;

           if (!files.length)
               return;
           for (var i = files.length - 1; i >= 0; i--) {
               this.form.attachments.push(files[i]);
           }
       },
       handleInput(field) {
           this.errors[field] = false;
       },
   }
}
</script>
