<template>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card shadow-none border">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1 me-2">Track Request</h4>
                    <div>
                        <button @click="openForm()" class="btn bg-gradient btn-sm btn-primary mt-n2 mb-n2 w-lg fw-bold">REQUEST DOCUMENT</button>
                    </div>
                </div>
                <div class="card-body" style="height: calc(100vh - 350px); overflow: auto;">
                    <table class="table table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr class="fs-11">
                                <th style="width: 60%;">Code</th>
                                <th style="width: 30%;" class="text-center">Status</th>
                                <th style="width: 10%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(list,index) in lists.requests.data" v-bind:key="index">
                                <td> {{ list.code }} </td>
                                <td class="text-center">
                                    <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                                </td>
                                <td class="text-end">
                                    <b-button @click="openView(list)" variant="soft-info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                            <i class="ri-eye-fill align-bottom"></i>
                        </b-button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-none border">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0  me-2">Transaction History</h4>
                </div>
                <div class="card-body" style="height: calc(100vh - 350px); overflow: auto;">
                    <table class="table table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr class="fs-11">
                                <th></th>
                                <th style="width: 15%;">Code</th>
                                <th style="width: 15%;" class="text-center">Type</th>
                                <th style="width: 15%;" class="text-center">Processing</th>
                                <th style="width: 15%;" class="text-center">Payment</th>
                                <th style="width: 15%;" class="text-center">Status</th>
                                <th style="width: 15%;" class="text-center">Total</th>
                                <th style="width: 7%;" ></th>
                            </tr>
                        </thead>
                        <tbody v-if="lists.histories.data.length > 0">
                            <tr v-for="(list,index) in lists.histories.data" v-bind:key="index">
                                <td class="text-center"> 
                                   {{ index + 1 }}.
                                </td>
                                <td class="fs-12">{{list.code}}</td>
                                <td class="text-center fs-12">{{list.type.name}}</td>
                                <td class="text-center fs-12">
                                    <span v-if="list.is_express" class="badge bg-success">Express</span>
                                    <span v-else class="badge bg-info">Regular</span>
                                </td>
                                <td class="text-center fs-12">
                                    <span :class="'badge '+list.payment.status.color+' '+list.payment.status.others">{{list.payment.status.name}}</span>
                                </td>
                                <td class="text-center fs-12">
                                    <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                                </td>
                                <td class="text-center fs-12">{{list.payment.total}}</td>
                                <td class="text-end">
                                    <b-button @click="openView(list)" variant="soft-info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                        <i class="ri-eye-fill align-bottom"></i>
                                    </b-button>
                                    <b-button @click="openPrint(list.id)" variant="soft-success" class="me-1" v-b-tooltip.hover title="Print" size="sm">
                                        <i class="ri-printer-fill align-bottom"></i>
                                    </b-button>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="7" class="text-center text-muted">No transactions found</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <View ref="view"/>
    <Form :colleges="dropdowns.colleges" :graduates="dropdowns.graduates" :types="dropdowns.types" :fees="dropdowns.fees" ref="form"/>
</template>
<script>
import Form from '../Students/Form.vue';
import View from '../Students/View.vue';
export default {
    props: ['lists','dropdowns'],
    components: { View, Form },
    methods: {
        openView(data){
            this.$refs.view.show(data);
        },
        openForm(){
            this.$refs.form.show();
        }
    }
}
</script>