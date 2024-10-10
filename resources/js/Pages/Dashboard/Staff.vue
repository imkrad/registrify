<template>
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
    </div>
    <div class="row g-3">
        <div class="col-lg-4 col-md-6" v-for="(list,index) in documents.pending.data" v-bind:key="index" @click="openView(list)" style="cursor: pointer;">
            <div class="card tasks-box">
                <div class="card-header ribbon-box right">
                    <div class="ribbon-two ribbon-two-info" v-if="list.is_express"><span>Express</span></div>
                    <div class="flex-grow-1">
                        <h6 class="fs-13 mb-0 text-primary fw-semibold">#{{list.code}}</h6>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="badge bg-dark-subtle text-dark me-1" v-for="(doc,index2) in list.lists" v-bind:key="index2">
                                {{doc.document.name.name}}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top-dashed">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <span class="text-muted"><i class="ri-account-circle-fill align-bottom"></i> {{ list.student.firstname }} {{ list.student.lastname }}</span>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="text-muted"><i class="ri-calendar-fill align-bottom"></i> {{ list.created_at }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <View ref="view"/>
</template>
<script>
import View from './Modals/View.vue';
export default {
    props: ['counts','documents'],
    components: { View },
    methods: {
        openView(data){
            this.$refs.view.show(data);
        },
    }
}
</script>