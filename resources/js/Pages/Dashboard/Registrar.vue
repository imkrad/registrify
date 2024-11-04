<template>
    <Head title="Cashier" />
    <PageHeader title="Dashboard" pageTitle="Lists" />
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header border-1 align-items-center d-flex">
                    <h4 class="card-title mb-0 fs-14 flex-grow-1">Students for Review ({{ students.data.length }})</h4>
                    <div>
                       
                    </div>
                </div>
                <div class="card-body" style="height: calc(100vh - 280px); overflow: auto;">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fs-11">
                                    <th style="width: 90%;">Name</th>
                                    <th style="width: 10%;" ></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(list,index) in students.data" v-bind:key="index">
                                    <td class="fs-12">
                                        <h5 class="fs-13 mb-0 text-dark">{{list.lastname}}, {{list.firstname}} {{list.middlename[0]}}.</h5>
                                        <p class="fs-12 text-muted mb-0">{{list.id_number}}</p>
                                    </td>
                                    <td class="text-end">
                                        <b-button @click="openStudent(list)" variant="soft-info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                                            <i class="ri-eye-fill align-bottom"></i>
                                        </b-button>
                                        <!-- <b-button @click="openPrint(list.id)" variant="soft-success" class="me-1" v-b-tooltip.hover title="Print" size="sm">
                                            <i class="ri-printer-fill align-bottom"></i>
                                        </b-button> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row g-3">
                <div class="col-lg-4 col-md-6" v-for="(list,index) in counts" v-bind:key="index">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-light rounded-circle fs-3 material-shadow" :class="list.color">
                                        <i :class="list.icon+' align-middle'"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">{{ list.name }}</p>
                                    <h4 class=" mb-0">{{list.count}}</h4>
                                </div>
                                <div class="flex-shrink-0 align-self-end">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-n2">
                    <div class="card">
                        <div class="card-body" style="height: calc(100vh - 326px); overflow: auto;">
                            <table class="table table-nowrap align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="fs-11">
                                        <th></th>
                                        <th style="width: 10%;">Code</th>
                                        <th style="width: 20%;" class="text-center">Student</th>
                                        <th style="width: 12%;" class="text-center">Type</th>
                                        <th style="width: 12%;" class="text-center">Processing</th>
                                        <th style="width: 12%;" class="text-center">Payment</th>
                                        <th style="width: 12%;" class="text-center">Status</th>
                                        <th style="width: 12%;" class="text-center">Total</th>
                                        <th style="width: 7%;" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list,index) in requests.data" v-bind:key="index">
                                        <td class="text-center"> 
                                            {{ index + 1 }}.
                                        </td>
                                        <td class="fs-12">{{list.code}}</td>
                                        <td class="text-center">{{list.student.lastname}}, {{list.student.firstname}} {{list.student.middlename[0]}}.</td>
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
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Student ref="student"/>
    <View ref="view"/>
</template>
<script>
import Student from './Modals/Student.vue';
import View from './Modals/Registrar.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, PageHeader, Student, View }, 
    props: ['requests','students','counts'],
    data(){
        return {
            currentUrl: window.location.origin,
            filter: {
                keyword: null
            },
            index: null
          
        }
    },
    methods: {
        openStudent(data,index){
            this.index = index;
            this.$refs.student.show(data);
        },  
        openView(data,index){
            this.index = index;
            this.$refs.view.show(data);
        },  
    }
   
}
</script>