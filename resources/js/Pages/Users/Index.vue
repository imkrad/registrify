<template>
    <Head title="Users" />
    <PageHeader title="Users" pageTitle="Lists" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px); overflow: auto;" ref="box">
            <Lists :statuses="statuses"/>
        </div>
    </div>
</template>
<script>
import Lists from './Components/Lists.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, PageHeader, Lists }, 
    props: ['statuses'],
    data(){
        return {
            currentUrl: window.location.origin,
          
        }
    },
   
}
</script>