<template>
    <Head title="Registrar" />
    <PageHeader title="Dashboard" pageTitle="Lists" />
    
    <BRow>
        <div class="col-md-3">
            <div class="card bg-light-subtle shadow-none border">
                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i class="ri-file-list-fill  text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14"><span class="text-body">Summary</span></h5>
                            <p class="text-muted text-truncate-two-lines fs-12">A record of all submitted document requests.</p>
                        </div>
                        <div class="flex-shrink-0">
                            
                        </div>
                    </div>
                </div>

                <div class="card-body border-bottom bg-white">
                    <p class="mb-0 text-primary fs-12 fw-semibold">Verification & Requests</p>
                </div>
                <div class="card bg-white border-bottom shadow-none mb-0" style="height: calc(100vh - 343px); overflow: auto;">
                    
                    <b-list-group flush>
                        <BListGroupItem @click="filterReminder(list)" v-for="(list,index) in reminders" v-bind:key="index" style="cursor: pointer;" :class="(isActive(list.name)) ? 'bg-info-subtle' : ''">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs">
                                        <div class="avatar-title rounded" :class="list.color">
                                        <i class="fs-15" :class="list.icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0 fs-12">{{list.name}}</h5>
                                    <p class="mb-0 fs-11 text-muted">{{list.short}}</p>
                                </div>
                                <span class="text-dark fs-12">{{list.count}} </span>
                            </div>
                        </BListGroupItem>
                    </b-list-group>

                    <p class="ms-3 mb-0 text-primary fs-12 mt-3 fw-semibold">Document Request Statuses</p>
                    <hr class="text-muted"/>
                    <ul class="list-group list-group-flush border-dashed mb-n3 mt-n3 p-3">
                        <li class="list-group-item px-0" v-for="(list,index) in stats" v-bind:key="index" style="cursor: pointer;">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-xs">
                                    <span class="avatar-title bg-light p-1 rounded-circle">
                                        <i :class="list.icon+' '+list.color"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0 fs-12">{{list.name}}</h6>
                                    <p class="fs-11 mb-0 text-muted">{{ list.description }}</p>
                                </div>
                                <div class="flex-shrink-0 text-end">
                                    <h6 class="mt-2 fs-12">{{list.count}}</h6>
                                </div>
                            </div>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card bg-light-subtle shadow-none border">

                <div class="card-header bg-light-subtle">
                    <div class="d-flex mb-n3">
                        <div class="flex-shrink-0 me-3">
                            <div style="height:2.5rem;width:2.5rem;">
                                <span class="avatar-title bg-primary-subtle rounded p-2 mt-n1">
                                    <i v-if="info" :class="info.icon+' text-primary fs-24'"></i>
                                    <i v-else class="ri-file-list-fill text-primary fs-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fs-14">
                                <span v-if="info" class="text-body">{{info.name}}</span>
                                <span v-else class="text-body">Document Requests</span>
                            </h5>
                            <p v-if="info" class="text-muted text-truncate-two-lines fs-12">{{ info.description }}</p>
                            <p v-else class="text-muted text-truncate-two-lines fs-12">A record of all submitted document requests, showing their status and details for easy tracking.</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="input-group mb-1">
                                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                                <input type="text" placeholder="Search Request" class="form-control" style="width: 40%;">
                                <b-button type="button" variant="primary">
                                    <i class="ri-add-circle-fill align-bottom me-1"></i> Search
                                </b-button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-white border-bottom shadow-none" no-body v-if="activeList == 'Document Requests' || activeList == null">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <ul class="nav nav-tabs nav-tabs-custom nav-success border border-dashed border-end-0 border-start-0 fs-12" role="tablist">
                                <li class="nav-item">
                                    <BLink @click="viewStatus(10,null)" class="nav-link py-3 active text-primary" data-bs-toggle="tab" role="tab" aria-selected="true">
                                    <i class="ri-apps-2-line me-1 align-bottom"></i> All Requests
                                    </BLink>
                                </li>
                                <li class="nav-item" v-for="(list,index) in statuses" v-bind:key="index">
                                    <BLink @click="viewStatus(index,list.value)" class="nav-link py-3" :class="(this.index == index) ? list.others+' active' : ''" data-bs-toggle="tab" role="tab" aria-selected="false">
                                        <i :class="icons[index]" class="me-1 align-bottom"></i>
                                        {{ list.name }} <BBadge v-if="counts[index] > 0" :class="list.color" class="align-middle ms-1">{{counts[index]}}</BBadge>
                                    </BLink>
                                </li>
                            </ul>
                        </div>
                        <div class="flex-shrink-0">
                            <Pagination class="ms-3 me-3" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                        </div>
                    </div>
                </div>
                <div class="card bg-white border-bottom shadow-none" no-body v-else>
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <ul class="nav nav-tabs nav-tabs-custom nav-success border border-dashed border-end-0 border-start-0 fs-12" role="tablist">
                                <li class="nav-item">
                                    <BLink @click="viewStatus(10,null)" class="nav-link py-3 active text-primary" data-bs-toggle="tab" role="tab" aria-selected="true">
                                    <i class="ri-apps-2-line me-1 align-bottom"></i> All Requests
                                    </BLink>
                                </li>
                            </ul>
                        </div>
                        <div class="flex-shrink-0">
                            <Pagination class="ms-3 me-3" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                        </div>
                    </div>
                </div>

                <div class="card-body bg-white" v-if="activeList == 'Document Requests' || activeList == null">
                    <div class="table-responsive table-card" style="margin-top: -39px; height: calc(100vh - 345px); overflow: auto;">
                        <table class="table align-middle table-centered">
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
                            <tbody class="table-white">
                                <tr v-for="(list,index) in lists" v-bind:key="index">
                                    <td class="text-center"> 
                                        {{ index + 1 }}.
                                    </td>
                                    <td class="fs-12 fw-semibold">{{list.code}}</td>
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
                <div class="card-body bg-white" v-else>
                    <div class="table-responsive table-card" style="margin-top: -39px; height: calc(100vh - 345px); overflow: auto;">
                        <table class="table align-middle table-centered">
                            <thead class="table-light">
                                <tr class="fs-11">
                                    <th style="width: 5%;"></th>
                                    <th>Name</th>
                                    <th class="text-center" style="width: 15%;">ID Number</th>
                                    <th class="text-center" style="width: 15%;">Email</th>
                                    <th class="text-center" style="width: 15%;">Contact no.</th>
                                    <th class="text-center" style="width: 15%;">Request Date</th>
                                    <th style="width: 7%;" ></th>
                                </tr>
                            </thead>
                            <tbody class="table-white" v-if="students.data.length > 0">
                                <tr v-for="(list,index) in students.data" v-bind:key="index">
                                    <td class="text-center">{{ index + 1 }}.</td>
                                    <td class="fs-12 fw-semibold">{{list.lastname}}, {{list.firstname}} {{list.middlename[0]}}.</td>
                                    <td class="fs-12 text-center">{{list.id_number}}</td>
                                    <td class="fs-12 text-center">{{list.email}}</td>
                                    <td class="fs-12 text-center">{{list.contact_no}}</td>
                                    <td class="fs-12 text-center">{{list.created_at}}</td>
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
                            <tbody class="table-white" v-else>
                                <tr>
                                    <td class="text-center text-muted" colspan="6">No students for verification</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </BRow>
    <View @update="fetch()" ref="view"/>
    <Student ref="student"/>
</template>
<script>
import _ from 'lodash';
import View from './Modals/View.vue';
import Student from './Modals/Student.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination2.vue";
export default {
    components: { PageHeader, Pagination, View, Student },
    props: ['statuses','counts','reminders','stats','students'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            activeList: null,
            index: null,
            info: null,
            status: null,
            keyword: null,
            icons: ['ri-information-line','ri-wallet-3-line','ri-indeterminate-circle-line','ri-checkbox-circle-line','ri-close-circle-line'],
        }
    },
    created(){
        this.fetch();
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/requests';
            axios.get(page_url,{
                params : {
                    keyword: this.keyword,
                    status: this.status,
                    count: Math.floor((window.innerHeight-390)/59),
                    option: 'lists'
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;          
                }
            })
            .catch(err => console.log(err));
        },
        viewStatus(index,status){
            this.index = index;
            this.status = status;
            this.fetch();
        },
        openView(data,index){
            this.index = index;
            this.$refs.view.show(data);
        },  
        openStudent(data){
            this.$refs.student.show(data);
        },
        filterReminder(data){
            if(data == this.activeList){
                this.activeList = null;
                this.info = null;
            }else{
                this.info = data;
                this.activeList = data.name;
            }
        },
        isActive(name) {
            return this.activeList === name;
        }
    }
}
</script>