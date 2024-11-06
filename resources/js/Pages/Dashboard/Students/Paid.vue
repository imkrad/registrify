<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Mark as Paid" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <div class="row p-3" >
            <div class="col-lg-12">
                <div class="align-items-center d-flex">
                    <h6 class="text-primary mb-0 flex-grow-1">Files Selected</h6>
                    <div class="flex-shrink-0">
                        <input type="file" id="file-upload" multiple @change="handleFileUpload"/>
                    </div>
                </div>
                <hr class="text-muted mt-2"/>
                <table class="table table-bordered table-nowrap align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fs-11">
                            <th style="width: 50%;" class="text-center">File Name</th>
                            <th style="width: 59%;" class="text-center">File Size</th>
                        </tr>
                    </thead>
                    <tbody v-if="files.length > 0">
                        <tr v-for="(file,index) in files" v-bind:key="index">
                            <td class="text-center"> {{ file.name }} </td>
                            <td class="text-center"> {{ (file.size / 1024).toFixed(2) }} KB </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="2" class="text-center text-muted fs-12">No files attached.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            form: {
                id: null
            },
            files: [],
            value: null,
            showModal: false
        }
    },
    methods: { 
        show(data){
            this.value = data;
            this.showModal = true;
        },
        handleFileUpload(event) {
            this.files = Array.from(event.target.files); // Convert FileList to array
        },
        submit() {
            const formData = new FormData();
            this.files.forEach((file, index) => {
                formData.append(`files[${index}]`, file);
            });
            formData.append('id', this.value);
            formData.append('option', 'receipt');

            axios.post('/dashboard', formData, {
                headers: {
                'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                this.$emit('update',response.data.data);
                this.showModal = false;
            })
            .catch(error => {
                console.error('Error uploading files:', error);
            });
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>