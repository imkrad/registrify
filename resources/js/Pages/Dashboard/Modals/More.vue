<template>
    <b-modal v-if="selected" v-model="showModal" header-class="p-3 bg-light" title="More Details" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row">
            <div class="col-md-12">
                <div class="row g-2" v-if="selected.attachments.length > 0">
                    <div class="col-md-12" v-for="(list,index) in selected.attachments" v-bind:key="index">
                        <div class="d-flex bg-light border border-dashed p-2 rounded position-relative">
                            <div class="flex-shrink-0">
                                <i class="ri-image-2-line fs-17 text-danger"></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0 fs-12">
                                    <a :href="currentUrl+'/storage/'+list.file" target="_blank" class="stretched-link">Attachment {{index+1}}</a>
                                </h6>
                                <small>{{list.size}}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-2" v-else>
                    <div class="col-md-12 mb-n4">
                        <div data-v-e683f25c="" class="text-center fs-12 alert alert-danger material-shadow" role="alert" aria-live="polite" aria-atomic="true">Attachment not yet available. No receipt yet.</div>
                    </div>
                </div>
            </div> 
            <div class="col-md-12">
                <hr class="text-muted"/>
            </div>
            <div class="col-md-12 mt-n2 mb-n4" v-if="selected.log">
                <div class="profile-timeline">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item border-0">
                            <div class="accordion-header" id="headingOne">
                                <b-link class="accordion-button p-2 shadow-none" v-b-toggle.collapseOne>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title rounded-circle" :class="(selected.log.prepared_by) ? 'bg-success' : 'bg-light text-danger'">
                                                <i :class="(selected.log.prepared_by) ? 'ri-checkbox-circle-fill' : 'ri-close-circle-fill'"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fs-12 mb-0 fw-semibold" :class="(selected.log.prepared_by) ? '' : 'text-muted'">
                                                Preparation Details
                                            </h6>
                                        </div>
                                    </div>
                                </b-link>
                            </div>
                            <b-collapse id="collapseOne" v-if="selected.log.prepared_by">
                                <div class="accordion-body ms-2 ps-5 pt-0 mb-n4">
                                    <h6 class="mb-0 fs-11">Prepared By : {{ selected.log.prepared.profile.firstname }} {{ selected.log.prepared.profile.lastname }}</h6>
                                    <p class="text-muted fs-11">Prepared Date : {{ selected.log.prepared_date }}</p>
                                </div>
                            </b-collapse>
                        </div>
                        <div class="accordion-item border-0">
                            <div class="accordion-header" id="headingTwo">
                                <b-link class="accordion-button p-2 shadow-none" v-b-toggle.collapseTwo>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title rounded-circle" :class="(selected.log.processed_by) ? 'bg-success' : 'bg-light text-danger'">
                                                <i :class="(selected.log.processed_by) ? 'ri-checkbox-circle-fill' : 'ri-close-circle-fill'"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fs-12 mb-1 fw-semibold" :class="(selected.log.processed_by) ? '' : 'text-muted'">
                                               Processed Details
                                            </h6>
                                        </div>
                                    </div>
                                </b-link>
                            </div>
                            <b-collapse id="collapseTwo" v-if="selected.log.processed_by">
                                <div class="accordion-body ms-2 ps-5 pt-0 mb-n4">
                                    <h6 class="mb-0 fs-11">Processed By : {{ selected.log.processed.profile.firstname }} {{ selected.log.processed.profile.lastname }}</h6>
                                    <p class="text-muted fs-11">Processed Date : {{ selected.log.processed_date }}</p>
                                </div>
                            </b-collapse>
                        </div>
                        <div class="accordion-item border-0">
                            <div class="accordion-header" id="headingThree">
                                <b-link class="accordion-button p-2 shadow-none" v-b-toggle.collapseThree>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title rounded-circle" :class="(selected.log.completed_by) ? 'bg-success' : 'bg-light text-danger'">
                                                <i :class="(selected.log.completed_by) ? 'ri-checkbox-circle-fill' : 'ri-close-circle-fill'"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fs-12 mb-1 fw-semibold" :class="(selected.log.completed_by) ? '' : 'text-muted'">
                                               Completed Details
                                            </h6>
                                        </div>
                                    </div>
                                </b-link>
                            </div>
                            <b-collapse id="collapseThree" v-if="selected.log.completed_by">
                                <div class="accordion-body ms-2 ps-5 pt-0 mb-n4">
                                    <h6 class="mb-0 fs-11">Completed By : {{ selected.log.completed.profile.firstname }} {{ selected.log.completed.profile.lastname }}</h6>
                                    <p class="text-muted fs-11">Completed Date : {{ selected.log.completed_date }}</p>
                                </div>
                            </b-collapse>
                        </div>
                        <div class="accordion-item border-0">
                            <div class="accordion-header" id="headingFour">
                                <b-link class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseFour"
                                    aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title rounded-circle" :class="(selected.log.released_by) ? 'bg-success' : 'bg-light text-danger'">
                                                <i :class="(selected.log.released_by) ? 'ri-checkbox-circle-fill' : 'ri-close-circle-fill'"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fs-12 mb-0 fw-semibold" :class="(selected.log.released_by) ? '' : 'text-muted'">
                                                Released Details
                                            </h6>
                                        </div>
                                    </div>
                                </b-link>
                            </div>
                            <b-collapse id="collapseFour" v-if="selected.log.released_by">
                                <div class="accordion-body ms-2 ps-5 pt-0">
                                    <h6 class="mb-0 fs-11">Released By : {{ selected.log.released.profile.firstname }} {{ selected.log.released.profile.lastname }}</h6>
                                    <p class="text-muted fs-11">Released Date : {{ selected.log.released_date }}</p>
                                </div>
                            </b-collapse>
                        </div>
                    
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-n2 mb-n4" v-else>
                <div data-v-e683f25c="" class="text-center fs-12 alert alert-warning material-shadow" role="alert" aria-live="polite" aria-atomic="true">No logs found</div>
            </div>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            selected: null,
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>