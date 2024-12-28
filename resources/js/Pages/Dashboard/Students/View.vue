<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 700px;" header-class="p-3 bg-light" title="View Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row g-2 mt-n2" >
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
                                <th style="width: 40%;">Document</th>
                                <th style="width: 20%;" class="text-center">Status</th>
                                <th style="width: 10%;" class="text-center">Quantity</th>
                                <th style="width: 15%;" class="text-center">Fee</th>
                            </tr>
                        </thead>
                        <tbody class="fs-12">
                            <tr v-for="(list,index) in selected.lists" v-bind:key="index">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td>{{ list.document.name.name}} <span v-if="list.document.is_perpage" class="text-muted fs-12">(Price per page)</span></td>
                                <td class="text-center">
                                    <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                                </td>
                                <td class="text-center">{{ list.quantity }}</td>
                                <td class="text-center">{{ list.total}}</td>
                                  
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4"></td>
                                <td class="text-center fs-12 fw-semibold">{{ selected.payment.total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-md-12" v-if="selected.comments.length > 0">
                <hr class="text-muted mb-2 mt-2"/>
            </div>
            <div class="col-md-12" v-if="selected.comments.length > 0">
                <span class="text-muted fs-11">Comments: </span>
                <div class="alert alert-dark border-0 mb-0" role="alert">
                    <ul class="mb-0">
                        <li v-for="(list,index) in selected.comments" v-bind:key="index">{{list.message}}</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-12">
                <hr class="text-muted mb-2 mt-2"/>
            </div>
            <div class="col-md-12">
                <div class="row g-2">
                    <div class="col-md-4" v-for="(list,index) in selected.attachments" v-bind:key="index">
                        <div class="d-flex bg-light border border-dashed p-2 rounded position-relative">
                            <div class="flex-shrink-0">
                                <i class="ri-image-2-line fs-17 text-danger"></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0 fs-12">
                                    <a :href="currentUrl+'/storage/'+list.file" target="_blank" class="stretched-link">Attachment {{index+1}}</a>
                                </h6>
                                <small>{{list.size}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button v-if="selected.status.name == 'Confirmed'" @click="submit('ok')" variant="primary" :disabled="form.processing" block>Mark as Paid</b-button>
        </template>
    </b-modal>
    <Paid @update="updateData" ref="paid"/>
</template>
<script>
import Paid from './Paid.vue';
export default {
    components: { Paid },
    data(){
        return {
            currentUrl: window.location.origin,
            selected: {
                student: {},
                lists: [],
                payment: {},
                status: {},
                comments: []
            },
            form: {},
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            if(data.comments.length > 0){
                this.form = this.$inertia.form({
                    id: this.selected.id,
                    option: 'seen'
                });

                this.form.post('/dashboard',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        
                    },
                });
            }
            this.showModal = true;
        },
        submit(){
            this.$refs.paid.show(this.selected.id);
        },
        updateData(data){
            this.$emit('update',data);
            this.showModal = false;
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>