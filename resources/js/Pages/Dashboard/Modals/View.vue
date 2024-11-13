<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 700px;" header-class="p-3 bg-light" title="View Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row g-2 mt-n2">
            <div class="col-md-12">
                <div class="form-floating">
                    <input type="text" :value="selected.student.lastname+', '+selected.student.firstname+' '+selected.student.middlename+'.'" class="form-control" readonly>
                    <label>Name</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" :value="selected.student.id_number" class="form-control" readonly>
                    <label>ID Number</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" :value="selected.student.email" class="form-control" readonly>
                    <label>Email</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="text" :value="selected.student.contact_no" class="form-control" readonly>
                    <label>Contact no.</label>
                </div>
            </div>
            <div class="col-md-12 mt-0 mb-n3"><hr class="text-muted"/></div>
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
                                <th style="width: 25%;" class="text-center">Quantity</th>
                                <th style="width: 25%;" class="text-center">Fee</th>
                                <th style="width: 25%;" class="text-center" v-if="selected.status.id == 6"></th>
                            </tr>
                        </thead>
                        <tbody class="fs-12">
                            <tr v-for="(list,index) in selected.lists" v-bind:key="index">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td>{{ list.document.name.name}}</td>
                                <td class="text-center">
                                    <span :class="'badge '+list.status.color">{{list.status.name}}</span> 
                                </td>
                                <td class="text-center">{{ list.quantity}}</td>
                                <td class="text-center">{{ list.total}}</td>
                                <td class="text-end" v-if="selected.status.id == 6">
                                    <b-button v-if="list.status_id == 10" @click="update(list.id,11,index)" size="sm" variant="success" :disabled="form.processing" block>Start Now</b-button>
                                    <b-button v-if="list.status_id == 11" @click="update(list.id,12,index)" size="sm" variant="warning" :disabled="form.processing" block>End Now</b-button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4"></td>
                                <td class="text-center fs-12 fw-semibold">{{ selected.payment.total }}</td>
                                <td v-if="selected.status.id == 6"></td>
                            </tr>
                        </tfoot>
                    </table>
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
            <b-button v-if="$page.props.user.data.role == 'Receiver' && selected.status.id == 13" @click="submit(6)" variant="primary" :disabled="form.processing" block>Confirm</b-button>
            <b-button v-if="$page.props.user.data.role == 'Processor' && selected.status.id == 6 && allStatusId10(selected.lists)" @click="addComment(selected.id)" variant="primary" :disabled="form.processing" block>Add Comment</b-button>
            <b-button v-if="$page.props.user.data.role == 'Processor' && selected.status.id == 6 && allStatusId12(selected.lists)" @click="submit(7)" variant="primary" :disabled="form.processing" block>Process</b-button>
            <b-button v-if="$page.props.user.data.role == 'Releaser' && selected.status.id == 7" @click="submit(14)" variant="primary" :disabled="form.processing" block>Release</b-button>
        </template>
    </b-modal>    
    <Comment ref="comment"/>
</template>
<script>
import Comment from './Comment.vue';
export default {
    components: { Comment },
    data(){
        return {
            currentUrl: window.location.origin,
            selected: {
                student: {},
                lists: [],
                payment: {},
                status: {}
            },
            index: null,
            form: {},
            showModal: false
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
                status_id: data,
                option: 'request'
            });

            this.form.post('/dashboard',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        update(id,data,index){
            this.index = index;
            this.form = this.$inertia.form({
                id: id,
                status_id: data,
                option: 'list'
            });

            this.form.put('/dashboard/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.selected.lists[this.index] = response.props.flash.data;
                    this.hide();
                },
            });
        },
        allStatusId12(array) {
            return array.every(item => item.status_id === 12);
        },
        allStatusId10(array) {
            return array.every(item => item.status_id === 10);
        },
        addComment(id){
            this.$refs.comment.show(id);
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>