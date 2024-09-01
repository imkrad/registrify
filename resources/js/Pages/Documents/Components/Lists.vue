<template>
    <b-row class="g-2 mb-2 mt-n2">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="filter.keyword" placeholder="Search Documents" class="form-control" style="width: 60%;">
                <select v-model="filter.type" @change="fetch()" class="form-select" id="inputGroupSelect01" style="width: 100px;">
                    <option :value="null" selected>Select Type</option>
                    <option :value="list.value" v-for="list in documents" v-bind:key="list.id">{{list.name}}</option>
                </select>
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
                    <th style="width: 45%;">Document</th>
                    <th style="width: 15%;" class="text-center">Regular Fee</th>
                    <th style="width: 15%;" class="text-center">Express Fee</th>
                    <th style="width: 15%;" class="text-center">Per page</th>
                    <th style="width: 7%;" ></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(list,index) in lists" v-bind:key="index">
                    <td class="text-center"> 
                        {{ (meta.current_page - 1) * meta.per_page + index + 1 }}.
                    </td>
                    <td>
                        <h5 class="fs-13 mb-0 text-dark">{{list.name}}</h5>
                        <p class="fs-12 text-muted mb-0">{{list.type}}</p>
                    </td>
                    <td class="text-center fs-12">{{list.fees[0].fee}}</td>
                    <td class="text-center fs-12">{{list.fees[1].fee}}</td>
                    <td class="text-center fs-12">
                        <span v-if="list.is_perpage" class="badge bg-success">True</span>
                        <span v-else class="badge bg-danger">False</span>
                    </td>
                    <td class="text-end">
                        <b-button @click="openView(list)" variant="soft-info" class="me-1" v-b-tooltip.hover title="View" size="sm">
                            <i class="ri-eye-fill align-bottom"></i>
                        </b-button>
                        <b-button @click="openEdit(list,index)" variant="soft-warning" class="me-1" v-b-tooltip.hover title="Edit" size="sm">
                            <i class="ri-pencil-fill align-bottom"></i>
                        </b-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
    <View :names="subnames" ref="view"/>
    <Create :documents="documents" :fees="fees" :names="names" @update="fetch()" @updateData="updateData" ref="create"/>
</template>
<script>
import _ from 'lodash';
import View from '../Modals/View.vue';
import Create from '../Modals/Create.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, Create, View },
    props:['documents','names','fees','subnames'],
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
            page_url = page_url || '/documents';
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
        openCreate(){
            this.$refs.create.show();
        },
        openEdit(data,index){
            this.index = index;
            this.$refs.create.edit(data);
        },
        openView(data){
            this.$refs.view.show(data);
        },
        updateData(data){
            this.lists[this.index] = data;
        }
    }
}
</script>