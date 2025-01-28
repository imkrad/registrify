<template>
    <b-row class="g-2 mb-2 mt-n2">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="filter.keyword" placeholder="Search Transaction" class="form-control" style="width: 60%;">
                <!-- <select v-model="filter.type" @change="fetch()" class="form-select" id="inputGroupSelect01" style="width: 100px;">
                    <option :value="null" selected>Select Type</option>
                    <option :value="list.value" v-for="list in documents" v-bind:key="list.id">{{list.name}}</option>
                </select> -->
                <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                    <i class="bx bx-refresh search-icon"></i>
                </span>
                <b-button type="button" variant="primary" @click="openCreate">
                    <i class="ri-add-circle-fill align-bottom me-1"></i> Create
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
                    <th style="width: 20%;" class="text-center">Name</th>
                    <th style="width: 15%;" class="text-center">Year & Section</th>
                    <th style="width: 15%;" class="text-center">Documents</th>
                    <th style="width: 10%;" class="text-center">Request Date</th>
                    <th style="width: 10%;" class="text-center">Claimed Date</th>
                    <th style="width: 10%;" class="text-center">Status</th>
                    <th style="width: 7%;" ></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(list,index) in lists" v-bind:key="index">
                    <td class="text-center"> 
                        {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                    </td>
                    <td class="fs-12">{{list.code}}</td>
                    <td class="text-center">{{list.name}}.</td>
                    <td class="text-center fs-12">{{list.year}}</td>
                    <td class="text-center fs-12">
                        -
                    </td>
                    <td class="text-center fs-12">{{list.created_at}}</td>
                    <td class="text-center fs-12">{{list.claimed_at}}</td>
                    <td class="text-center fs-12">
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
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
    <View @update="fetch()" ref="view"/>
    <Create  :types="types" :graduates="graduates" :colleges="colleges" :fees="fees" @update="fetch()" ref="create"/>
</template>
<script>
import _ from 'lodash';
import View from '../Modals/View.vue';
import Create from '../Modals/Create.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, View, Create },
    props: ['graduates','colleges','types','fees'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
                type: null,
            },
            index: null
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
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
            page_url = page_url || '/onsites';
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    type: this.filter.type,
                    option: 'lists',
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
        openView(data){
            this.$refs.view.show(data);
        },
        openCreate(){
            this.$refs.create.show();
        }
    }
}
</script>