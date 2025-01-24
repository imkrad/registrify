<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 900px;" header-class="p-3 bg-light" title="View Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row align-items-center g-3">
            <div class="col-md">
                <div>
                    <h6><span class="fw-semibold text-primary fs-16">{{ selected.name }}</span></h6>
                    <div class="hstack gap-3 fs-12 flex-wrap">
                        <div><span class="text-muted">Code</span> : 
                            <span v-if="selected.code" class="fw-medium">{{selected.code}}</span>
                            <span v-else class="text-muted">Not Available</span>
                        </div>
                        <div class="vr" style="width: 1px;"></div>
                        <div><span class="text-muted">Year</span> : 
                            <span v-if="selected.year" class="fw-medium"> {{ selected.year }}</span>
                            <span v-else class="text-muted">Not Available</span>
                        </div>
                        <div class="vr" style="width: 1px;"></div>
                        <div><span class="text-muted">Total</span> : 
                            <span v-if="selected.total" class="fw-medium">{{selected.total}}</span>
                            <span v-else class="text-muted">Not Available</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-2 mt-n2">
            <div class="col-md-12 mt-0 mb-n3"><hr class="text-muted"/></div>
            <div class="row mb- mt-2 g-1 border-bottom" v-if="selected">
                <div class="col-sm-4 mb-3">
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
                <div class="col-sm-4">
                    <div class="p-1 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-0">
                                <div class="avatar-title rounded bg-transparent text-primary fs-20"><i class="ri-calendar-2-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted fs-11 mb-0">Request Date:</p>
                                <h5 class="fs-13 mb-0">{{(selected.created_at) ? selected.created_at : 'Not Available'}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
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
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr class="fs-11">
                                <th style="width: 7%;"></th>
                                <th style="width: 30%;">Document</th>
                                <th style="width: 16%;" class="text-center">Processor</th>
                                <th style="width: 16%;" class="text-center">Quantity</th>
                                <th style="width: 15%;" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="fs-12">
                            <tr v-for="(list,index) in selected.lists" v-bind:key="index">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td>{{ list.document.name.name}}</td>
                                <td class="text-center">{{ (list.user) ? list.user.profile.firstname+' '+list.user.profile.lastname : '-'}}</td>
                                <td class="text-center">{{ list.quantity }}</td>
                                <td class="text-center">
                                    <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button v-if="selected.status.name == 'Pending'" @click="submit('confirm')" variant="primary" :disabled="form.processing" block>Confirm</b-button>
            <b-button v-if="selected.status.name == 'Waiting'" @click="submit('process')" variant="primary" :disabled="form.processing" block>Process</b-button>
            <b-button v-if="a(selected.lists) && selected.status.name == 'Processing'" @click="submit('completed')" variant="primary" :disabled="form.processing" block>Mark as Completed</b-button>
            <b-button v-if="selected.status.name == 'Completed'" @click="submit('release')" variant="primary" :disabled="form.processing" block>Release</b-button>
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
                payment: {
                    status: {}
                },
                status: {}
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
        a(array) {
            return array.every(item => item.status_id === 12);
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>