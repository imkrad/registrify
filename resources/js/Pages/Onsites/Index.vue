<template>
    <Head title="Onsite Transactions" />
    <PageHeader title="Onsite Transactions" pageTitle="Page" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px); overflow: auto;" ref="box">
            <Lists :types="types" :graduates="graduates" :colleges="colleges" :fees="fees"/>
        </div>
    </div>
</template>
<script>
import _ from 'lodash';
import Lists from './Components/Lists.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, PageHeader, Lists }, 
    props: ['graduates','colleges','types','fees'],
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