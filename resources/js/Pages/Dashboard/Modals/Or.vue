<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="View Request" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row g-2 mt-n2">
            <div class="col-md-12">
                <div class="form-floating">
                    <input type="text" v-model="or_number" class="form-control">
                    <label>Or Number</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <input type="text" :value="total" class="form-control" readonly>
                    <label>Total</label>
                </div>
            </div>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="submit(9)" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            form: {},
            id: null,
            status: null,
            or_number: null,
            total: null,
            showModal: false
        }
    },
    methods: { 
        show(data,id,total){
            this.status = data;
            this.id = id;
            this.total = total;
            this.showModal = true;
        },
        submit(data){
            this.form = this.$inertia.form({
                id: this.id,
                or_number: this.or_number,
                status_id: this.status,
                option: 'request'
            });

            this.form.put('/dashboard/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('success',true);
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