<template>
     <BModal v-model="showModal" style="--vz-modal-width: 700px;" hide-footer body-class="p-0" header-class="p-0"
        class="v-modal-custom" content-class="border-0 overflow-hidden" centered hide-header-close>
        <div class="modal-body login-modal p-5">
            <h5 class="text-white fs-16 mb-1 mt-n4">Request Form</h5>
            <p class="text-white-50 fs-11 mb-4">Please fill out the form carefully to ensure all information is accurate.</p>
            <div class="vstack gap-2 justify-content-center">
               <form class="customform mb-n5" style="color: white;">
                    <BRow class="g-3 mb-2"> 
                        <BCol lg="12" class="mt-n2 mb-0">
                            <hr class="text-muted"/>
                        </BCol>
                        <BCol lg="12" class="mt-0 mb-2">
                            <div class="d-flex">
                                <div style="width: 100%;">
                                    <InputLabel for="name" value="ID Number" :message="form.errors.email"/>
                                    <TextInput id="name" v-model="form.idnumber" type="email" class="form-control" placeholder="Please enter your id number" @input="handleInput('idnumber')" :light="true"/>
                                </div>
                                <div class="flex-shrink-0">
                                    <b-button @click="openAdd()" style="margin-top: 20px;" variant="light" class="waves-effect waves-light ms-1"><i class="ri-add-circle-fill"></i></b-button>
                                    <b-button @click="searchId()" style="margin-top: 20px;" variant="success" class="waves-effect waves-light ms-1"><i class="ri-search-eye-line"></i></b-button>
                                </div>
                            </div>
                        </BCol>
                        <BCol lg="12" v-if="!searched">
                            <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-12 mt-n3" role="alert">
                                <i class="ri-alert-line label-icon"></i><strong>No student selected</strong> - Search for the ID number. If it does not exist, please add it.
                            </div>
                        </BCol>
                        <BCol lg="12" v-else>
                            <div v-if="student" class="mt-n3">
                                <div class="col">
                                    <div class="card card-body">
                                        <div class="d-flex mb-0 align-items-center">
                                            <div class="flex-shrink-0">
                                                <img  src="images/avatar.png" alt="" class="avatar-sm rounded-circle">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="card-title text-primary mb-1">{{student.lastname}}, {{student.firstname}} {{student.middlename}}</h5>
                                                <div class="hstack text-dark gap-3 fs-12 flex-wrap">
                                                    <div><span class="text-muted">ID number :</span> <span class="">{{student.id_number}}</span></div>
                                                    <div class="vr"></div>
                                                    <div><span class="text-muted">Email :</span> <span class="">{{student.email}}</span></div>
                                                    <div class="vr"></div>
                                                    <div><span class="text-muted">Contact no.</span> : <span class="">{{student.contact_no}}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show material-shadow fs-12 mt-n3" role="alert">
                                <i class="ri-alert-line label-icon"></i><strong>Student not found</strong> - You entered an incorrect or non-existent ID number.
                            </div>
                        </BCol>
                    </BRow>
               </form>
            </div>
        </div>
        <div class="modal-body p-5">
            <form class="customform">
                <BRow class="g-3" style="margin-top: -35px;"> 
                    <BCol lg="12" style="margin-top: 13px; margin-bottom: -12px;">
                        <div class="row">
                            <BCol lg="6" class="fs-12" :class="(form.errors.sex) ? 'text-danger' : ''">Please select a type :</BCol>
                            <div class="col-md-3" v-for="(list,index) in types"  v-bind:key="index">
                                <div class="custom-control custom-radio mb-3">
                                    <input type="radio" id="customRadio1" class="custom-control-input me-2" @input="handleInput('type')" :value="list.value" v-model="form.type">
                                    <label class="custom-control-label fw-normal fs-12" for="customRadio1">{{list.name}}</label>
                                </div>
                            </div>
                        </div>
                    </BCol>
                    <BCol lg="12" class="mt-n2 mb-n3"><hr class="text-muted"/></BCol>
                    <BCol lg="12" v-if="form.type">
                        <div class="primary-documents-grid fs-14">
                            <div v-for="(primaryDoc, index) in primaryDocuments" :key="index" class="primary-item">
                                <BFormGroup class="form-check-primary mb-n1">
                                    <BFormCheckbox :value="primaryDoc.value" v-model="form.checked" :id="'formCheck'+index"><span class="fs-12">{{ primaryDoc.name }}</span></BFormCheckbox>
                                </BFormGroup>
                            </div>
                        </div>
                    </BCol>
                    <BCol lg="12" v-if="form.type" class="mt-1 mb-n4"><hr class="text-muted"/></BCol>
                    <BCol lg="12" v-if="form.type">
                        <InputLabel value="Others" :message="form.errors.name_id"/>
                        <Multiselect 
                        :options="nonPrimaryDocuments" 
                        v-model="form.others"
                        @input="handleInput('others')"
                        :searchable="true" label="name"
                        mode="tags"
                        placeholder="Select name"/>
                    </BCol>
                    <BCol lg="12" v-if="form.type" class="mt-1 mb-n4"><hr class="text-muted"/></BCol>
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
    props: ['graduates','colleges','types'],
    data(){
        return {
            form: useForm({
                idnumber: null,
                checked: [],
                others: [],
                type: null,
                check: false
            }),
            student: null,
            showModal: false,
            searched: false,
            primaryDocuments: [],
            nonPrimaryDocuments: [],
            tos: false
        }
    },
    watch: {
        'form.type': function(newType) {
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
            this.form.post('/',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.form.clearErrors();
                    this.form.reset();
                    this.hide();
                },
            });
        },
        searchId(){
            this.searched = true;
            axios.get('/',{
                params : {
                    idnumber: this.form.idnumber,
                    option: 'search'
                }
            })
            .then(response => {
                this.student = response.data;
            })
            .catch(err => console.log(err));
        },
        show(){
            this.showModal = true;
        },
        handleInput(field) {
            this.form.errors[field] = false;
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
  grid-template-columns: repeat(2, 1fr); /* Two equal columns */
  gap: 10px; /* Gap between columns */
}

.primary-item {
  display: flex;
  align-items: center;
}
</style>