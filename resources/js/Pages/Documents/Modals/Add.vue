<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 500px;" header-class="p-3 bg-light" :title="(!editable) ? 'Add Addon' : 'Edit Addon'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3">
                <BCol lg="12">
                    <InputLabel value="Fee" :message="form.errors.amount"/>
                    <Amount @amount="amount" ref="testing1" :readonly="false" @input="handleInput('amount')"/>
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-n1"/></BCol>
                <BCol lg="12" class="mt-n2">
                    <InputLabel value="Document Name" :message="form.errors.name_id"/>
                    <Multiselect 
                    :key="multiselectKey"
                    :options="names" 
                    v-model="name"
                    @input="handleInput"
                    :searchable="true" label="name"
                    placeholder="Select name"/>
                </BCol>
            </BRow>
            
            <ul class="list-group mt-3">
                <li class="list-group-item d-flex justify-content-between align-items-center" v-for="(list,index) in form.lists" v-bind:key="index">
                   {{list.name}} <span @click="removeSelected(index)" class="badge bg-danger" style="cursor: pointer;">Remove</span>
                </li>
            </ul>

        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
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
    props: ['names'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                fee: null,
                lists: [],
                type: null,
                option: 'addon'
            }),
            name: null,
            multiselectKey: 0,
            selectedNames: [],
            showModal: false,
            editable: false
        }
    },
    methods: { 
        show(type,id){
            this.form.reset();
            this.form.id = id;
            this.form.type = type;
            this.showModal = true;
        },
        handleInput(selectedName) {
            const selected = this.names.find(name => name.value === selectedName);
            const index = this.names.findIndex(name => name.value === selectedName);
            if (selected) {
                this.names.splice(index, 1);
                this.form.lists.push(selected);
            }
            this.name = null;
            this.multiselectKey += 1;
        },
        removeSelected(index) {
            const removedItem = this.form.lists.splice(index, 1)[0];
            this.names.push(removedItem);
        },
        edit(data){
            this.editable = true;
            this.form.id = data.id;
            this.form.fee = data.fee;
            this.showModal = true;
        },
        amount(val){
            this.form.fee = val;
        },
        submit(){
            if(this.editable){
                this.form.put('/documents/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        // this.$emit('updateData',this.$page.props.flash.data.data);
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
        // handleInput(field) {
        //     this.form.errors[field] = false;
        // },
        hide(){
            this.form.reset();
            this.showModal = false;
        }
    }
}
</script>