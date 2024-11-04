<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 700px;" header-class="p-3 bg-light" title="View Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row g-2 mt-n2">
            <div class="alert alert-info alert-dismissible fade show material-shadow fs-11" role="alert">
                <strong v-if="selected.is_express">Express Processing Fee</strong>
                <strong v-else>Regular Processing Fee</strong>
            </div>
            <div class="col-md-12 mt-n4 mb-n2"><hr class="text-muted"/></div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr class="fs-11">
                                <th style="width: 7%;"></th>
                                <th style="width: 43%;">Document</th>
                                <th style="width: 25%;" class="text-center">Status</th>
                                <th style="width: 25%;" class="text-center">Fee</th>
                            </tr>
                        </thead>
                        <tbody class="fs-12">
                            <tr v-for="(list,index) in selected.lists" v-bind:key="index">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td>{{ list.document.name.name}}</td>
                                <td class="text-center">
                                    <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                                </td>
                                <td class="text-center">{{ list.fee}}</td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3"></td>
                                <td class="text-center fs-12 fw-semibold">{{ selected.payment.total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <!-- <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button> -->
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            selected: {
                student: {},
                lists: [],
                payment: {}
            },
            form: {},
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>