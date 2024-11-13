<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Add Comment" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row g-2 mt-n2">
            <form class="customform mb-n5">

            </form>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="submit()" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            form: {
                id: null,
                message: null
            },
            showModal: false
        }
    },
    methods: { 
        show(id){
            this.form.id = id;
            this.showModal = true;
        },
        submit(){
            this.form = this.$inertia.form({
                id: this.form.id,
                message: this.form.message,
                option: 'comment'
            });

            this.form.post('/dashboard',{
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