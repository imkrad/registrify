<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 850px;" header-class="p-3 bg-light" title="View Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row align-items-center g-3">
            <div class="col-md-9">
                <div>
                    <h6><span class="fw-semibold text-primary fs-16">{{ selected.code }}</span></h6>
                    <div class="hstack gap-3 fs-12 flex-wrap mt-n1">
                        <div><span class="text-muted">Status</span> : 
                            <span v-if="selected.status" class="fw-medium"> {{ selected.status.name }}</span>
                            <span v-else class="text-muted">Not Available</span>
                        </div>
                        <div class="vr" style="width: 1px;"></div>
                        <div><span class="text-muted">Processing Type</span> : 
                            <span v-if="selected.is_express" class="fw-medium">Express Processing Fee</span>
                            <span v-else class="fw-medium">Regular Processing Fee</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row g-2 mt-n3">
                    <div class="col-md-12" v-for="(list,index) in selected.attachments" v-bind:key="index">
                        <div class="d-flex bg-light border border-dashed p-2 rounded position-relative">
                            <div class="flex-shrink-0">
                                <i class="ri-price-tag-2-fill ms-1 fs-17 text-danger"></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0 fs-12">
                                    <a :href="currentUrl+'/storage/'+list.file" target="_blank" class="stretched-link">Receipt</a>
                                </h6>
                                <small class="fs-10">{{list.size}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-2 mt-0" >
            
            <div class="col-md-12 mt-n1 mb-n2"><hr class="text-muted"/></div>
            <div class="col-md-12 mt-n3" v-if="selected.authorization">
                <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow material-shadow mt-4" role="alert" aria-live="polite" aria-atomic="true">
                    <i class="ri-alert-line label-icon"></i>Authorized Representative : <strong>{{ selected.authorization.name }} </strong> 
                    <span class="float-end fw-semibold">
                        <a :href="currentUrl+'/storage/'+selected.authorization.file" target="_blank" class="stretched-link">View Attachment</a>
                    </span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2.2rem;width:2.2rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i v-if="info" :class="info.icon+' text-primary fs-24'"></i>
                                        <i v-else class="ri-file-list-fill text-primary fs-24"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-13">
                                    <span class="text-body">Documents Requested</span>
                                </h5>
                                <p class="text-muted text-truncate-two-lines fs-11">List of documents requested by students for processing</p>
                            </div>
                            <div class="flex-shrink-0">
                              
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <div class="table-responsive table-card">
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
                </div>
            </div>
            <div class="col-md-12" v-if="selected.comments.length > 0">
                <hr class="text-muted mt-n3"/>
            </div>
            <div class="col-md-12 mt-n2" v-if="selected.comments.length > 0">
                <span class="text-muted fs-11">Comments: </span>
                <div class="alert alert-dark border-0 mb-0" role="alert">
                    <ul class="mb-0">
                        <li v-for="(list,index) in selected.comments" v-bind:key="index">{{list.message}}</li>
                    </ul>
                </div>
            </div>
            <!-- <div class="col-md-12">
                <hr class="text-muted mb-2 mt-n3"/>
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
            </div> -->
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