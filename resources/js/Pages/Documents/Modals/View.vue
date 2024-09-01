<template>
    <b-modal v-if="selected" v-model="showModal" style="--vz-modal-width: 800px;" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <template v-slot:header>
            <h5 class="modal-title">{{selected.name}} </h5>
            <span class="ms-2 text-muted fs-14">({{ selected.type }})</span>
            <button @click="showModal = false" type="button" class="btn-close" aria-label="Close"></button>
        </template>
        <div class="table-responsive">
            <table class="table table-nowrap table-bordered align-middle mb-0">
                <thead class="table-dark">
                    <tr class="fs-11">
                        <th style="width: 50%;" class="text-center">Regular Processing Fee </th>
                        <th style="width: 50%;" class="text-center">Express Processing Fee</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td @click="openAdd('fee',list.id)" class="text-center" v-for="(list,index) in selected.fees" v-bind:key="index" style="cursor: pointer;">{{ list.fee }}</td>
                    </tr>
                    <tr>
                        <td>
                            <ul v-for="(list,index) in selected.fees[0].addons" v-bind:key="index">
                                <li class="fs-12 ms-n2 text-muted" style="list-style-type: none;">Plus :</li>
                                <li class="text-muted fs-11" v-for="(list1,index) in list.lists" v-bind:key="index">{{ list1.name.name }}</li>
                                <li class="fs-13 ms-n2 mt-2 mb-n3" style="list-style-type: none;">{{ list.fee }}</li>
                            </ul>
                        </td>
                        <td>
                            <ul v-for="(list,index) in selected.fees[1].addons" v-bind:key="index">
                                <li class="fs-12 ms-n2 text-muted" style="list-style-type: none;">Plus :</li>
                                <li class="text-muted fs-11" v-for="(list1,index) in list.lists" v-bind:key="index">{{ list1.name.name }}</li>
                                <li class="fs-13 ms-n2 mt-2 mb-n3" style="list-style-type: none;">{{ list.fee }}</li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr class="text-muted"/>
        <b-row class="g-2 mb-2 mt-n2">
            <b-col lg>
                <div class="input-group mb-1">
                    <span class="input-group-text fw-semibold" style="width: 88%;"> List of Addons</span>
                    <b-button @click="openAdd('document',selected.id)" type="button" variant="primary" style="width: 12%;">
                        <i class="ri-add-circle-fill align-bottom me-1"></i> Add
                    </b-button>
                </div>
            </b-col>
        </b-row>
        
        <ul class="list-group" v-if="selected.addons.length == 0">
            <li class="list-group-item text-center text-muted">
                No addons added
            </li>
        </ul>
        <ul class="list-group" v-else>
            <li class="list-group-item d-flex justify-content-between align-items-center" v-for="(list,index) in selected.addons" v-bind:key="index">
                <span v-for="(list1,index) in list.lists" v-bind:key="index">{{ list1.name.name }}</span><span>{{list.fee}}</span>
            </li>
        </ul>

        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
        </template>
    </b-modal>
    <Add :names="names" ref="add"/>
</template>
<script>
import Add from './Add.vue';
export default {
    props: ['names'],
    components: { Add }, 
    data(){
        return {
            currentUrl: window.location.origin,
            selected: null,
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        openAdd(type,id){
            this.$refs.add.show(type,id);
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>
<style>
.modal-header {
    padding: 1rem !important;
    background-color:#f3f6f9;
}
</style>