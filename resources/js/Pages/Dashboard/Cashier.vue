<template>
    <Head title="Cashier" />
    <PageHeader title="Dashboard" pageTitle="Lists" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px); overflow: auto;" ref="box">
            <b-row class="g-2 mb-2 mt-n2">
                <b-col lg>
                    <div class="input-group mb-1">
                        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                        <input type="text" v-model="filter.keyword" placeholder="Search Requests" class="form-control" style="width: 60%;">
                  
                        <b-button type="button" variant="primary">
                            <i class="bx bx-refresh search-icon"></i>
                        </b-button>
                    </div>
                </b-col>
            </b-row>

            <div class="table-responsive">
                <table class="table table-nowrap align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fs-11">
                            <th></th>
                            <th style="width: 10%;">Code</th>
                            <th style="width: 20%;" class="text-center">Student</th>
                            <th style="width: 15%;" class="text-center">Type</th>
                            <th style="width: 15%;" class="text-center">Processing</th>
                            <th style="width: 10%;" class="text-center">Payment</th>
                            <th style="width: 10%;" class="text-center">Status</th>
                            <th style="width: 10%;" class="text-center">Total</th>
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
    <View ref="view"/>
</template>
<script>
import View from './Modals/Cashier.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, PageHeader, View }, 
    props: ['requests'],
    data(){
        return {
            currentUrl: window.location.origin,
            filter: {
                keyword: null
            }
          
        }
    },
    methods: {
        openView(data,index){
            this.index = index;
            this.$refs.view.show(data);
        },  
    }
   
}
</script>