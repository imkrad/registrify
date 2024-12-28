<template>
    <Head title="Dashboard" />
    <PageHeader title="Dashboard" pageTitle="Page" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px); overflow: auto;" ref="box">
            <div class="row">
                <div class="col-xl-6">
                    <div class="card card-height-100">
                        <div class="card-header bg-primary-subtle  align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Activity Logs</h4>
                            <div class="flex-shrink-0">
                            
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-nowrap align-middle mb-0">
                                    <thead class="table-light">
                                        <tr class="fs-11">
                                            <th></th>
                                            <th style="width: 95%;">Logs Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(list,index) in activities.data" v-bind:key="index">
                                            <td>
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-light text-primary rounded-3 fs-15">
                                                        <i :class="'ri-'+list.type+'-fill '+list.attempt"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <h5 class="fs-13 mb-0 text-dark">{{list.log_name}} - {{ list.event }}</h5>
                                                <p class="fs-12 text-muted mb-0">{{ list.description }} 
                                                    <span v-if="list.event === 'updated'">
                                            Updated <span class="text-warning fst-italic" v-for="(old,key,index) in list.properties.old" v-bind:key="index">{{key}} : {{old}}, </span> to <span class="text-success fst-italic" v-for="(news,key,index) in list.properties.attributes" v-bind:key="index">{{key}} : {{news}}, </span>
                                                    </span>
                                                </p>
                                            </td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card card-height-100">
                        <div class="card-header bg-primary-subtle align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Authentication Logs</h4>
                            <div class="flex-shrink-0">
                            
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-nowrap align-middle mb-0">
                                    <thead class="table-light">
                                        <tr class="fs-11">
                                            <th></th>
                                            <th style="width: 25%;">Browser</th>
                                            <th style="width: 17%;" class="text-center">IP Address</th>
                                            <th style="width: 20%;" class="text-center">Date</th>
                                            <th style="width: 15%;" class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(list,index) in authentications.data" v-bind:key="index">
                                            <td>
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-light text-primary rounded-3 fs-15">
                                                        <i :class="'ri-'+list.type+'-fill '+list.attempt"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <h5 class="fs-13 mb-0 text-dark">{{list.platform}} <span class="fs-12 text-muted">({{list.browser}})</span></h5>
                                                <p v-if="list.location" class="fs-12 text-muted mb-0">{{ list.location.city }},  {{ list.location.state_name }}, {{ list.location.country }}</p>
                                                <p v-else class="fs-12 text-muted mb-0">Not Available</p>
                                            </td>
                                            <td class="text-center">{{list.ip}} </td>   
                                            <td class="text-center text-muted fs-11">{{list.created_at}}</td>
                                            <td class="text-center">
                                                <span :class="(!list.is_failed) ? 'badge bg-success' : 'badge bg-danger'">
                                                    <span v-if="list.is_suspicious">Suspicious</span>
                                                    <span v-if="!list.is_failed">Successful</span>
                                                    <span v-else>Failed</span>
                                                </span>
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
    </div>
</template>
<script>
import _ from 'lodash';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    props: ['authentications','activities'],
    components: { Pagination, PageHeader }, 
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            index: null,
            filter: {
                keyword: null,
                status: null,
                sortby: 'Created At',
                sort: 'desc'
            },
            index: null,
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        }
    },
    created(){
        // this.fetch();
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/customers';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    status: this.filter.status,
                    sortby: this.filter.sortby,
                    sort: this.filter.sort,
                    count: ((window.innerHeight-420)/52)
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
        openView(data,index){
            this.index = index;
            this.$refs.view.show(data);
        },  
        viewStatus(index,status){
            this.index = index;
            this.filter.status = status;
            this.fetch();
        },
        viewSort(sortby,sort){
            this.filter.sortby = sortby;
            this.filter.sort = sort;
            this.fetch();
        },
        updateItem(data){
            this.lists[this.index] = data;
        },
    }
}
</script>