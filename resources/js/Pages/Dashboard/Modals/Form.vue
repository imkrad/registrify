<template>
    <BModal v-model="showModal" style="--vz-modal-width: 800px;" hide-footer body-class="p-0" header-class="p-0"
       class="v-modal-custom" content-class="border-0 overflow-hidden" centered hide-header-close>
       <div class="modal-body login-modal p-5">
           <h5 class="text-white fs-14 mb-1 mt-n4">Onsite Request Form</h5>
           <p class="text-white-50 fs-10 mb-4">Please fill out the form carefully to ensure all information is accurate.</p>
           <div class="vstack gap-2 justify-content-center">
              <form class="customform mb-n5">
                   <BRow class="g-3 mb-2"> 
                       <BCol lg="12" class="mt-n2 mb-0">
                           <hr class="text-muted"/>
                       </BCol>
                       <BCol lg="12">
                            <div class="d-flex mt-n4 mb-3">
                                <div style="width: 100%;">
                                    <InputLabel for="conforme" value="User" :message="form.errors.user_id" style="color: white;"/>
                                    <Multiselect 
                                    @search-change="fetchUser" 
                                    :options="users" 
                                    v-model="form.user" 
                                    label="name"
                                    object
                                    @input="handleInput('user')"
                                    :searchable="true" 
                                    placeholder="Select User"/>
                                </div>
                                <div class="flex-shrink-0">
                                    <b-button @click="openAdd()" style="margin-top: 20px;" variant="light" class="waves-effect waves-light ms-1"><i class="ri-add-circle-fill"></i></b-button>
                                </div>
                            </div>
                       </BCol>
                   </BRow>
              </form>
           </div>
       </div>
       <div class="modal-body p-5">
           <form class="customform">
               <BRow class="g-3" style="margin-top: -44px;"> 
                   <BCol lg="12" style="margin-top: 13px; margin-bottom: -12px;">
                       <div class="row fs-11">
                           <BCol lg="6" :class="(form.errors.sex) ? 'text-danger' : ''">Please select a type :</BCol>
                           <div class="col-md-3" v-for="(list,index) in types"  v-bind:key="index">
                               <div class="custom-control custom-radio mb-3">
                                   <input type="radio" id="customRadio1" class="custom-control-input me-2" @input="handleInput('type')" :value="list.value" v-model="form.type_id">
                                   <label class="custom-control-label fw-normal" for="customRadio1">{{list.name}}</label>
                               </div>
                           </div>
                       </div>
                   </BCol>
                   <BCol lg="12" class="mt-n2 mb-n3">
                       <hr class="text-muted"/>
                   </BCol>
                   <BCol lg="12" v-if="form.type_id" class="mt-2 mb-n2">
                       <span class="fs-11 text-muted">Primary Documents <span v-if="errors.checked" class="text-danger fs-10">(Select at least 1 document)</span></span>
                   </BCol>
                   <BCol lg="12" v-if="form.type_id">
                       <div class="primary-documents-grid fs-14">
                           <div v-for="(primaryDoc, index) in primaryDocuments" :key="index" class="primary-item">
                               <BFormGroup class="form-check-primary mb-n1">
                                   <BFormCheckbox 
                                   :value="primaryDoc" 
                                   v-model="form.checked" 
                                   @input="handleInput('checked')"
                                   @change="onCheckboxChange(primaryDoc)"
                                   :id="'formCheck'+index">
                                       <span class="fs-11">{{ primaryDoc.name }}</span>
                                       <span class="ms-1 text-muted">({{primaryDoc.quantity}} 
                                           <span v-if="primaryDoc.quantity == 1">copy</span>
                                           <span v-else>copies</span>)
                                       </span>
                                   </BFormCheckbox>
                               </BFormGroup>
                           </div>
                       </div>
                   </BCol>
                   <BCol lg="12" v-if="form.type_id && nonPrimaryDocuments.length > 0" class="mt-1 mb-n1">
                       <hr class="text-muted mb-2"/>
                       <span class="fs-11 text-muted">Other Documents</span>
                   </BCol>
                   <BCol lg="12" v-if="form.type_id" class="mt-2">
                       <div class="primary-documents-grid fs-14">
                           <div v-for="(primaryDoc, index) in nonPrimaryDocuments" :key="index" class="primary-item">
                               <BFormGroup class="form-check-primary mb-n1">
                                   <BFormCheckbox 
                                   :value="primaryDoc" 
                                   v-model="form.checked" 
                                   @change="onCheckboxChange(primaryDoc)"
                                   :id="'formCheckS'+index">
                                   <span class="fs-11">{{ (primaryDoc.subname) ? primaryDoc.subname : primaryDoc.name }}</span>
                                       <span class="ms-1 fs-11 text-muted">({{primaryDoc.quantity}} 
                                           <span v-if="primaryDoc.quantity == 1">copy</span>
                                           <span v-else>copies</span>)
                                       </span>
                                   </BFormCheckbox>
                               </BFormGroup>
                           </div>
                       </div>
                   </BCol>
                   <BCol lg="12" v-if="form.type_id" class="mt-0 mb-n3"><hr class="text-muted"/></BCol>
                   <BCol lg="12" v-if="form.type_id" style="margin-top: 13px; margin-bottom: -5px;">
                       <div class="row fs-11">
                           <BCol lg="6" :class="(errors.is_express) ? 'text-danger' : ''">Processing Type :</BCol>
                           <div class="col-md-3" v-for="(list,index) in fees"  v-bind:key="index">
                               <div class="custom-control custom-radio mb-3">
                                   <input type="radio" id="customRadio1" class="custom-control-input me-2" @input="handleInput('is_express')" :value="list.value" v-model="form.is_express">
                                   <label class="custom-control-label fw-normal" for="customRadio1">{{list.type}} <span class="text-muted fs-11">({{ list.others }})</span></label>
                               </div>
                           </div>
                       </div>
                   </BCol>
                   <BCol lg="12" v-if="form.type_id" class="mt-n3 mb-n4"><hr class="text-muted"/></BCol>
                   <BCol lg="12" v-if="form.type_id" style="margin-top: 13px; margin-bottom: -5px;">
                       <div class="row fs-11">
                           <BCol lg="6" :class="(errors.is_personal) ? 'text-danger' : ''">Pickup Method :</BCol>
                           <div class="col-md-3" v-for="(list,index) in pickups"  v-bind:key="index">
                               <div class="custom-control custom-radio mb-3">
                                   <input type="radio" id="customRadio1" class="custom-control-input me-2" @input="handleInput('is_personal')" :value="list.value" v-model="form.is_personal">
                                   <label class="custom-control-label fw-normal" for="customRadio1">{{list.name}}</label>
                               </div>
                           </div>
                       </div>
                   </BCol>
                   <BCol lg="12" class="mt-n3 mb-n4"><hr class="text-muted"/></BCol>
                   <BCol lg="6" v-if="form.is_personal == false" style="margin-top: 13px; margin-bottom: -5px;">
                        <div class="form-floating">
                            <input type="text" v-model="form.name" class="form-control">
                            <label :class="(errors.name) ? 'text-danger' : ''">Authorized Person</label>
                        </div>
                   </BCol>
                   <!-- <BCol lg="12" :class="(form.is_personal == false) ? 'mt-n2 mb-n4' : 'mt-n3 mb-n4'"><hr class="text-muted"/></BCol> -->
                   
                   <BCol :lg="(form.is_personal == false) ? '6' : '12'" v-if="form.type_id" :class="(errors.purpose) ? 'text-danger' : ''" style="margin-top: 13px; margin-bottom: -5px;">
                       <div class="form-floating">
                           <input type="text" v-model="form.purpose" class="form-control">
                           <label :class="(errors.purpose) ? 'text-danger' : ''">Purpose</label>
                       </div>
                   </BCol>                
               </BRow>
               <div class="mt-3 form-check">
                   <input type="checkbox" v-model="form.check" class="form-check-input" id="checkTerms">
                   <label class="form-check-label text-muted" for="checkTerms">I agree to the <span class="text-primary fw-semibold">Terms of Service & Privacy Policy</span></label>
               </div>
               <div class="text-end mt-2 mb-n4">
                   <button @click="submit('ok')" class="btn btn-primary btn-md" type="button" :disabled="!form.check">
                       <div class="btn-content">Submit Now</div>
                   </button>
               </div>
           </form>
       </div>
   </BModal>
   <BModal v-model="showQuantityModal" style="--vz-modal-width: 500px;" hide-footer hide-header centered hide-header-close>
       <div class="modal-body p-2 mt-4" v-if="selectedDoc">
           <h6 class="fs-12 text-muted mb-3">Please specify how many copies of the {{ selectedDoc.name }} you would like to request?</h6>
           <BFormGroup >
               <BFormInput
                   id="quantityInput"
                   v-model="selectedDoc.quantity"
                   type="number"
                   min="1"
                   required
               />
           </BFormGroup>
           <div class="text-end mt-2">
               <button @click="confirmQuantity" class="btn btn-primary" type="button">
                   Confirm
               </button>
           </div>
       </div>
   </BModal>
   <Add @selected="set" ref="add"/>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Add from './Add.vue';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
   components: {Multiselect, InputLabel, TextInput, Add },
   props: ['graduates','colleges','types','fees'],
   data(){
       return {
           form: useForm({
               idnumber: null,
               checked: [],
               others: [],
               type_id: null,
               is_express: null,
               is_personal: null,
               is_onsite: 1,
               user_id: null,
               name: null,
               purpose: null,
               check: false,
               attachments: []
           }),
           errors: [],
           users: [],
           showQuantityModal: false,
           selectedDoc: null,
           student: null,
           showModal: false,
           searched: false,
           primaryDocuments: [],
           nonPrimaryDocuments: [],
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
           tos: false
       }
   },
   watch: {
       'form.type_id': function(newType) {
           let selectedArray = [];
           if (newType === 2) {
               selectedArray = this.colleges;
           } else if (newType === 3) {
               selectedArray = this.graduates;
           }

           this.primaryDocuments = selectedArray.filter(doc => doc.is_primary === 1);
           this.nonPrimaryDocuments = selectedArray.filter(doc => doc.is_primary === 0);
       },
       'form.idnumber': function(newValue) {
           if (!newValue) {
               this.form.student = null;
           }
       }
   },
   methods: {
       submit(){
           let data = new FormData();
           data.append('idnumber',(this.form.user) ? this.form.user.idnumber : null);
           data.append('checked[]', (this.form.checked.length != 0) ? JSON.stringify(this.form.checked) : []);
           data.append('others[]', (this.form.others.length != 0) ? JSON.stringify(this.form.others) : []);
           data.append('is_express', (this.form.is_express) ? this.form.is_express : '');
           data.append('is_personal', this.form.is_personal);
           data.append('is_onsite', this.form.is_onsite);
           data.append('purpose', (this.form.purpose) ? this.form.purpose : '');
           data.append('user_id', (this.form.user) ? this.form.user.value : null);
           data.append('type_id', this.form.type_id);
           (!this.form.is_personal) ? data.append('name', this.form.name) : '';
           if(this.form.attachments.length > 0){
               for (var i = this.form.attachments.length - 1; i >= 0; i--) {
                   data.append('files[]', this.form.attachments[i]);
               }
           }else{
               data.append('files[]', []);
           }
           this.$inertia.post('/', data, {
               preserveScroll: true,
               forceFormData: true,
               onSuccess: (response) => {
                   this.$emit('update',true);
                   this.showModal = false;
               },
               onError: () => {
                   this.errors = this.$page.props.errors;
               }
           });
       },
       onCheckboxChange(doc) {
           if (this.form.checked.includes(doc)) {
               this.selectedDoc = doc;
               this.showQuantityModal = true;
           } else {
               doc.quantity = 1;
           }
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
       confirmQuantity() {
           this.showQuantityModal = false;
       },
       show(){
           this.form.reset();
           this.resetDocumentQuantities(); 
           this.showModal = true;
       },
       resetDocumentQuantities() {
           this.primaryDocuments.forEach(doc => {
               doc.quantity = 1;
           });

           this.nonPrimaryDocuments.forEach(doc => {
               doc.quantity = 1;
           });
       },
       handleInput(field) {
           this.errors[field] = false;
       },
       openAdd(){
            this.$refs.add.show();
        },
        fetchUser(code){
            if(code != ''){
                axios.get('/students',{
                    params: {
                        option: 'students',
                        keyword: code
                    }
                })
                .then(response => {
                    this.users = response.data;
                })
                .catch(err => console.log(err));
            }
        },
        set(data){
            this.users = [];
            this.users.push(data);
            this.form.user = data;
        },
   }
}
</script>
<style scoped>
span.multiselect-tag:nth-child(1) {
 padding: 0px 7px;
 font-size: 9px;
}
span.multiselect-tag:nth-child(2) {
 padding: 0px 7px;
 font-size: 9px;
}
span.multiselect-tag:nth-child(3) {
 padding: 0px 7px;
 font-size: 9px;
}
span.multiselect-tag:nth-child(4) {
 padding: 0px 7px;
 font-size: 9px;
}
.primary-documents-grid {
 display: grid;
 grid-template-columns: repeat(3, 1fr); /* Two equal columns */
 gap: 10px; /* Gap between columns */
}

.primary-item {
 display: flex;
 align-items: center;
}
</style>