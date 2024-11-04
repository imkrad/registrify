<template>
    <b-modal v-if="selected" v-model="showModal" style="--vz-modal-width: 700px;" header-class="p-3 bg-light" title="View Student" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row g-2 mt-n2">
            <div class="col-md-12">
                <div class="row g-2">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" :value="selected.lastname+', '+selected.firstname+' '+selected.middlename+'.'" class="form-control" readonly>
                            <label>Name</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" :value="selected.id_number" class="form-control" readonly>
                            <label>ID Number</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" :value="selected.email" class="form-control" readonly>
                            <label>Email</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" :value="selected.contact_no" class="form-control" readonly>
                            <label>Contact no.</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <hr class="text-muted mb-2 mt-2"/>
            </div>
            <div class="col-md-12">
                <div class="row g-2">
                    <div class="col-md-4" v-for="(list,index) in selected.attachments" v-bind:key="index">
                        <div class="d-flex bg-light border border-dashed p-2 rounded position-relative">
                            <div class="flex-shrink-0">
                                <i class="ri-image-2-line fs-17 text-danger"></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0 fs-12">
                                    <a href="javascript:void(0);" class="stretched-link">Attachment {{index+1}}</a>
                                </h6>
                                <small>{{list.size}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="save()" variant="primary" :disabled="form.processing" block>Verify</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            selected: {},
            index: null,
            form: {},
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.selected = data;
            this.showModal = true;
        },
        save(){
            this.form = this.$inertia.form({
                id: this.selected.id,
                status: 2,
            });

            this.form.put('/students/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>