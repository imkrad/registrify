<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 800px;" header-class="p-3 bg-light" :title="(!editable) ? 'Create Document' : 'Edit Document'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3 mt-2">
                
                <BCol lg="6" class="mt-1">
                    <InputLabel value="Document Name" :message="form.errors.name_id"/>
                    <Multiselect 
                    :options="names" 
                    v-model="form.name_id"
                    @input="handleInput('name_id')"
                    :searchable="true" label="name"
                    placeholder="Select name"/>
                </BCol>
                <BCol lg="6" class="mt-1">
                    <InputLabel value="Document Type" :message="form.errors.type_id"/>
                    <Multiselect 
                    :options="documents" 
                    v-model="form.type_id"
                    @input="handleInput('type_id')"
                    :searchable="true" label="name"
                    placeholder="Select type"/>
                </BCol>
                <BCol lg="12" class="mt-0 mb-n3"><hr class="text-muted"/></BCol>
                <BCol lg="8" style="margin-top: 13px; margin-bottom: -12px;" class="fs-12" :class="(form.errors.is_perpage) ? 'text-danger' : ''">Is the payment calculated per page?</BCol>
                <BCol lg="4" style="margin-top: 13px; margin-bottom: -12px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="customRadio1" class="custom-control-input me-2" @input="handleInput('is_perpage')" :value="true" v-model="form.is_perpage">
                                <label class="custom-control-label fw-normal fs-12" for="customRadio1">Yes</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="customRadio2" class="custom-control-input me-2" @input="handleInput('is_perpage')" :value="false" v-model="form.is_perpage">
                                <label class="custom-control-label fw-normal fs-12" for="customRadio2">No</label>
                            </div>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12" class="mt-n2 mb-n3"><hr class="text-muted"/></BCol>
                <!-- <BCol lg="6 mt-2 mb-n3">
                    <InputLabel value="Fee Type" :message="form.errors.type_id"/>
                    <Multiselect 
                    :options="fees" 
                    v-model="form.type_id"
                    @input="handleInput('type_id')"
                    :searchable="true" label="name"
                    placeholder="Select type"/>
                </BCol> -->
                <BCol lg="6 mt-2 mb-n3">
                    <InputLabel value="Regular Processing Fee" :message="form.errors.amount"/>
                    <Amount @amount="regular" ref="testing1" :readonly="false" @input="handleInput('amount')"/>
                </BCol>
                <BCol lg="6 mt-2 mb-n3">
                    <InputLabel value="Express Processing Fee" :message="form.errors.amount"/>
                    <Amount @amount="express" ref="testing2" :readonly="false" @input="handleInput('amount')"/>
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
import Amount from '@/Shared/Components/Forms/Amount.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { Multiselect, InputLabel, TextInput, Amount },
    props: ['names','documents','fees'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                name_id: null,
                is_perpage: null,
                type_id: null,
                fees: [
                    {id: null, type_id: 4 , amount: null},
                    {id: null, type_id: 5 , amount: null}
                ]
            }),
            showModal: false,
            editable: false
        }
    },
    methods: { 
        show(){
            this.form.reset();
            this.$refs.testing1.empty();
            this.$refs.testing2.empty();
            this.showModal = true;
        },
        edit(data){
            this.editable = true;
            this.form.id = data.id;
            this.form.name_id = data.name_id;
            this.form.type_id = data.type_id;
            this.form.is_perpage = (data.is_perpage) ? true : false;
            this.$refs.testing1.emitValue(data.fees[0].fee);
            this.$refs.testing2.emitValue(data.fees[1].fee);
            this.form.fees[0].id = data.fees[0].id;
            this.form.fees[1].id = data.fees[1].id;
            this.showModal = true;
        },
        regular(val){
            this.form.fees[0].amount = val;
        },
        express(val){
            this.form.fees[1].amount = val;
        },
        submit(){
            if(this.editable){
                this.form.put('/documents/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('updateData',this.$page.props.flash.data.data);
                        this.form.reset();
                        this.hide();
                    }
                });
            }else{
                this.form.post('/documents',{
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
            this.$refs.testing1.empty();
            this.$refs.testing2.empty();
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>