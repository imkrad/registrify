<template>
    <b-row class="g-2 mb-2 mt-n2">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="filter.keyword" placeholder="Search Documents" class="form-control" style="width: 60%;">
                <select v-model="filter.type" @change="fetch()" class="form-select" id="inputGroupSelect01" style="width: 100px;">
                    <option :value="null" selected>Select Laboratory</option>
                    <!-- <option :value="list.value" v-for="list in dropdowns.laboratories" v-bind:key="list.id">{{list.name}}</option> -->
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
    <Create ref="create"/>
</template>
<script>
import _ from 'lodash';
import Create from '../Modals/Create.vue';
export default {
    components: { Create },
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
        openCreate(){
            this.$refs.create.show();
        }
    }
}
</script>