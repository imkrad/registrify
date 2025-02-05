<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 1100px;" header-class="p-3 bg-light" title="View Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row align-items-center g-3">
            <div class="col-md-10">
                <div>
                    <h6><span class="fw-semibold text-primary fs-16">{{ selected.name }}</span></h6>
                    <div class="hstack gap-3 fs-12 flex-wrap mt-n1">
                        <div>
                            <!-- <span class="text-muted">Code</span> :  -->
                            <span v-if="selected.code" class="fw-medium">{{selected.code}}</span>
                            <span v-else class="text-muted">Not Available</span>
                        </div>
                        <div class="vr" style="width: 1px;"></div>
                        <div><span class="text-muted">Status</span> : 
                            <span v-if="selected.status" class="fw-medium"> {{ selected.status.name }}</span>
                            <span v-else class="text-muted">Not Available</span>
                        </div>
                        <div class="vr" style="width: 1px;"></div>
                        <div><span class="text-muted">ID Number</span> : 
                            <span v-if="selected.student.id_number" class="fw-medium"> {{ selected.student.id_number }}</span>
                            <span v-else class="text-muted">Not Available</span>
                        </div>
                        <div class="vr" style="width: 1px;"></div>
                        <div><span class="text-muted">Email</span> : 
                            <span v-if="selected.student.email" class="fw-medium">{{selected.student.email}}</span>
                            <span v-else class="text-muted">Not Available</span>
                        </div>
                        <div class="vr" style="width: 1px;"></div>
                        <div><span class="text-muted">Contact no.</span> : 
                            <span v-if="selected.student.contact_no" class="fw-medium">{{selected.student.contact_no}}</span>
                            <span v-else class="text-muted">Not Available</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <b-button variant="primary" class="btn-label btn-sm waves-effect waves-light mt-n3 float-end" @click="viewMore(selected)">
                    <i class="ri-user-smile-line label-icon align-middle fs-16 me-2"></i> View details
                </b-button>
            </div>
        </div>

        <div v-if="selected.authorization" class="alert alert-warning alert-dismissible alert-label-icon label-arrow material-shadow mt-4" role="alert" aria-live="polite" aria-atomic="true">
            <i class="ri-alert-line label-icon"></i>Authorized Representative : <strong>{{ selected.authorization.name }} </strong> 
            <span class="float-end fw-semibold">
                <a :href="currentUrl+'/storage/'+selected.authorization.file" target="_blank" class="stretched-link">View Attachment</a>
            </span>
        </div>

        <div class="row g-3 mt-n2">
            <div class="col-md-12 mt-0 mb-n3"><hr class="text-muted"/></div>
            <div class="row mt-0 g-3" v-if="selected">
                <div class="col-sm-3 mb-3">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-0">
                                <div class="avatar-title rounded bg-transparent text-primary fs-24"><i class="ri-price-tag-2-line"></i></div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted fs-11 mb-0">Processing type :</p>
                                <h5 class="fs-13 mb-0">{{(selected.is_express) ? 'Express' : 'Regular'}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-0">
                                <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-calendar-2-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted fs-11 mb-0">Due Date:</p>
                                <h5 class="fs-13 mb-0">{{(selected.due_at) ? selected.due_at : 'Not Available'}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-0">
                                <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-calendar-2-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted fs-11 mb-0">Claimed Date:</p>
                                <h5 class="fs-13 mb-0">{{(selected.claimed_at) ? selected.claimed_at : 'Not Available'}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-0">
                                <div class="avatar-title rounded bg-transparent text-primary fs-24"><i class="ri-price-tag-2-line"></i></div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted fs-11 mb-0">Payment :</p>
                                <span :class="'badge '+selected.payment.status.color+' '+selected.payment.status.others">{{selected.payment.status.name}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-n3 mb-n3"><hr class="text-muted"/></div>
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
                                <BButton v-if="selected.comments.length == 0" variant="danger" class="btn-label btn-sm waves-effect waves-light" @click="openComment(selected.id)">
                                    <i class="ri-message-3-fill label-icon align-middle fs-16 me-2"></i> Add Comment
                                </BButton>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <div class="table-responsive table-card" v-if="selected.status.name == 'Pending'">
                            <table class="table table-nowrap align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="fs-11">
                                        <th style="width: 7%;"></th>
                                        <th style="width: 30%;">Document</th>
                                        <th style="width: 16%;" class="text-center">Status</th>
                                        <th style="width: 16%;" class="text-center">Pages</th>
                                        <th style="width: 16%;" class="text-center">Computation</th>
                                        <th style="width: 15%;" class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-12">
                                    <tr v-for="(list,index) in selected.lists" v-bind:key="index">
                                        <td class="text-center">{{ index + 1 }}</td>
                                        <td>{{ list.document.name.name}}</td>
                                        <td class="text-center">
                                            <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                                        </td>
                                        <td class="text-center">
                                            <center v-if="list.document.is_perpage">
                                                <input v-if="selected.status.name == 'Pending'" type="text" v-model="list.pages" class="form-control form-control-sm" style="width: 50px; text-align: center;">
                                                <div v-else>{{ list.pages }}</div>
                                            </center>
                                            <center v-else>
                                                -
                                            </center>
                                        </td>
                                        <td class="text-center">({{ list.quantity}} x {{ list.pages }}) * {{ list.fee }}</td>
                                        <td class="text-center">{{ total(list.quantity,list.pages,list.fee)}}</td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="5"></td>
                                        <td class="text-center fs-12 fw-semibold">{{ selected.payment.total }}</td>
                                        <td v-if="selected.status.id == 6"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="table-responsive table-card" v-else>
                            <table class="table table-nowrap align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="fs-11">
                                        <th style="width: 7%;"></th>
                                        <th style="width: 30%;">Document</th>
                                        <th style="width: 16%;" class="text-center">Processor</th>
                                        <th style="width: 16%;" class="text-center">Quantity</th>
                                        <th style="width: 16%;" class="text-center">Pages</th>
                                        <th style="width: 15%;" class="text-center">Status</th>
                                        <th style="width: 10%;" class="text-center" v-if="selected.status.name == 'Processing'"></th>
                                    </tr>
                                </thead>
                                <tbody class="fs-12">
                                    <tr v-for="(list,index) in selected.lists" v-bind:key="index">
                                        <td class="text-center">{{ index + 1 }}</td>
                                        <td>{{ list.document.name.name}}</td>
                                        <td class="text-center">{{ (list.user) ? list.user.profile.firstname+' '+list.user.profile.lastname : '-'}}</td>
                                        <td class="text-center">{{ list.quantity }}</td>
                                        <td class="text-center">{{ list.pages }}</td>
                                        <td class="text-center">
                                            <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                                        </td>
                                        <td v-if="selected.status.name == 'Processing'">
                                            <b-button v-if="list.status.name == 'Pending'"  @click="update(list.id,11,index)" variant="primary" class="btn-sm" :disabled="form.processing" block>Start Processing</b-button>
                                            <b-button v-if="list.status.name == 'Ongoing'"  @click="update(list.id,12,index)" variant="warning" class="btn-sm" :disabled="form.processing" block>End Processing</b-button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-0 mb-n4" v-if="selected.comments.length > 0">
                <div class="card bg-light-subtle shadow-none border">
                    <div class="card-header bg-light-subtle">
                        <div class="d-flex mb-n3">
                            <div class="flex-shrink-0 me-3">
                                <div style="height:2.2rem;width:2.2rem;">
                                    <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                        <i class="ri-message-3-fill text-primary fs-24"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-13">
                                    <span class="text-body">Comments</span>
                                </h5>
                                <p class="text-muted text-truncate-two-lines fs-11">List of comments</p>
                            </div>
                            <div class="flex-shrink-0">
                                <BButton variant="danger" class="btn-sm waves-effect waves-light" @click="openComment(selected.id)">
                                    Add Comment
                                </BButton>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-white border-bottom shadow-none mb-0" style="max-height: 100px; overflow: auto;">
                        <b-list-group flush>
                            <BListGroupItem v-for="(list,index) in selected.comments" v-bind:key="index">
                                <div class="d-flex align-items-center mb-n3">
                                    <div class="flex-shrink-0">
                                        <h5 class="fs-12 mb-0">{{list.user.profile.firstname}} {{list.user.profile.lastname}} <small class="text-muted ms-2">({{ list.created_at }})</small></h5>
                                        <p class="text-muted fs-11">{{ list.message }}</p>
                                    </div>
                                </div>
                            </BListGroupItem>
                        </b-list-group>
                    </div>
                </div>
            </div>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button v-if="selected.status.name == 'Confirmed'" @click="markasPaid()" variant="primary" :disabled="form.processing" block>Mark as Paid</b-button>
            <b-button v-if="selected.status.name == 'Pending'" @click="submit('confirm')" variant="primary" :disabled="form.processing" block>Confirm</b-button>
            <b-button v-if="selected.status.name == 'Waiting'" @click="submit('process')" variant="primary" :disabled="form.processing" block>Process</b-button>
            <b-button v-if="a(selected.lists) && selected.status.name == 'Processing'" @click="submit('completed')" variant="primary" :disabled="form.processing" block>Mark as Completed</b-button>
            <b-button v-if="selected.status.name == 'Completed'" @click="submit('release')" variant="primary" :disabled="form.processing" block>Release</b-button>
        </template>
    </b-modal>    
    <More ref="more"/>
    <Paid @update="updateData" ref="paid"/>
    <Comment @update="updateComment" ref="comment"/>
</template>
<script>
import Paid from './Paid.vue';
import More from './More.vue';
import Comment from './Comment.vue';
export default {
    components: { Comment, More, Paid },
    data(){
        return {
            currentUrl: window.location.origin,
            selected: {
                student: {},
                lists: [],
                payment: {
                    status: {}
                },
                status: {},
                comments: []
            },
            index: null,
            form: {},
            totals: [],
            showModal: false
        }
    },
    computed: {
        grandTotal() {
            return `₱${this.selected.lists
            .map(item => {
                const fee = parseFloat(item.fee.replace('₱', '').replace(/,/g, '').trim());
                return item.quantity * item.pages * fee;
            })
            .reduce((sum, itemTotal) => sum + itemTotal, 0)
            .toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        submit(data){
            this.form = this.$inertia.form({
                id: this.selected.id,
                lists: this.selected.lists,
                type: data
            });

            this.form.post('/requests',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update',true);
                    this.hide();
                },
            });
        },
        total(quantity,page,fee){
            const numericFee = parseFloat(fee.replace('₱', '').replace(/,/g, '').trim());
            const result = (quantity * page) * numericFee;
            this.totals.push(result);
            return `₱${result.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        },
        update(id,data,index){
            this.index = index;
            this.form = this.$inertia.form({
                id: id,
                status_id: data,
            });

            this.form.put('/requests/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.selected.lists[this.index] = response.props.flash.data;
                },
            });
        },
        updateComment(data){
            this.selected.comments = data.comments;
        },
        updateData(data){
            this.selected.payment = data[0].payment;
            this.selected.status = data[0].status;
        },
        a(array) {
            return array.every(item => item.status_id === 12);
        },
        viewMore(data){
            this.$refs.more.show(data);
        },  
        openComment(id){
            this.$refs.comment.show(id);
        },
        hide(){
            this.showModal = false;
        },
        markasPaid(){
            this.$refs.paid.show(this.selected.id);
        },
    }
}
</script>