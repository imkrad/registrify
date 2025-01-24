<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 700px;" header-class="p-3 bg-light" :title="(!editable) ? 'Create Onsite Request' : 'Edit Onsite Request'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3 mt-2">
                
                <BCol lg="6" class="mt-n1">
                    <InputLabel for="name" value="Fullname" :message="form.errors.name"/>
                    <TextInput type="text" v-model="form.name" class="form-control" placeholder="Please enter name" @input="handleInput('name')" :light="true"/>
                </BCol>
                <BCol lg="6" class="mt-n1">
                    <InputLabel for="name" value="Course & Year" :message="form.errors.year"/>
                    <TextInput type="text" v-model="form.year" class="form-control" placeholder="Please enter course and year" @input="handleInput('year')" :light="true"/>
                </BCol>
                
                <BCol lg="12" class="mt-0 mb-n3"><hr class="text-muted"/></BCol>
                <BCol lg="12" style="margin-top: 13px; margin-bottom: -5px;">
                    <div class="row fs-11">
                        <BCol lg="6" :class="(form.errors.is_express) ? 'text-danger' : ''">Processing Type :</BCol>
                        <div class="col-md-3" v-for="(list,index) in fees"  v-bind:key="index">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="customRadio1" class="custom-control-input me-2" @input="handleInput('is_express')" :value="list.value" v-model="form.is_express">
                                <label class="custom-control-label fw-normal" for="customRadio1">{{list.type}} <span class="text-muted fs-11">({{ list.others }})</span></label>
                            </div>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12" class="mt-n3 mb-n3"><hr class="text-muted"/></BCol>
                <BCol lg="12" style="margin-top: 13px; margin-bottom: -12px;">
                    <div class="row fs-11">
                        <BCol lg="6" :class="(form.errors.type_id) ? 'text-danger' : ''">Please select a type :</BCol>
                        <div class="col-md-3" v-for="(list,index) in types"  v-bind:key="index">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="customRadio1" class="custom-control-input me-2" @input="handleInput('type')" :value="list.value" v-model="form.type_id">
                                <label class="custom-control-label fw-normal" for="customRadio1">{{list.name}}</label>
                            </div>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12" class="mt-n2 mb-n3"><hr class="text-muted"/></BCol>
                    <BCol lg="12" v-if="form.type_id" class="mt-2 mb-n2">
                        <span class="fs-11 text-muted">Primary Documents</span>
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
                                        <span class="fs-12">{{ primaryDoc.name }}</span>
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
                                        <span class="fs-11">{{ primaryDoc.name }}</span>
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
            </BRow>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
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
</template>
<script>
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { Multiselect, InputLabel, TextInput },
    props: ['graduates','colleges','types','fees'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                type_id: null,
                name: null,
                year: null,
                is_express: null,
                checked: [],
                others: [],
            }),
            primaryDocuments: [],
            nonPrimaryDocuments: [],
            showModal: false,
            editable: false,
            showQuantityModal: false,
            selectedDoc: null,
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
        }
    },
    methods: { 
        show(){
            this.form.reset();
            this.showModal = true;
        },
        submit(){
            if(this.editable){
                this.form.put('/students/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('updateData',this.$page.props.flash.data.data);
                        this.hide();
                    }
                });
            }else{
                this.form.post('/onsites',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('update',true);
                        this.hide();
                    },
                });
            }
        },
        onCheckboxChange(doc) {
            if (this.form.checked.includes(doc)) {
                this.selectedDoc = doc;
                this.showQuantityModal = true;
            } else {
                doc.quantity = 1;
            }
        }, 
        confirmQuantity() {
            this.showQuantityModal = false;
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.reset();
            this.resetDocumentQuantities(); 
            this.editable = false;
            this.showModal = false;
        },

        resetDocumentQuantities() {
            this.primaryDocuments.forEach(doc => {
                doc.quantity = 1;
            });

            this.nonPrimaryDocuments.forEach(doc => {
                doc.quantity = 1;
            });
        },
    }
}
</script>
<style scoped>
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