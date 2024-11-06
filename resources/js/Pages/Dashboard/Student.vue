<template>
    <div class="layout-wrapper m-2">
        <div class="container-fluid">
            <div class="profile-foreground position-relative mx-n4 mt-n4">
                <div class="profile-wid-bg">
                    <img src="assets/images/profile-bg.jpg" alt="" class="profile-wid-img">
                </div>
            </div>
            <div class="pt-4 m-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
                <div class="row g-4">
                    <div class="col-auto">
                        <div class="avatar-md">
                            <img src="images/avatars/avatar.jpg" alt="user-img" class="img-thumbnail rounded-circle">
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2">
                            <h3 class="text-white mb-1">{{ $page.props.user.data.name }}</h3>
                            <div class="hstack text-white-50 gap-1">
                                <div class="me-4"><i class="ri-qr-code-fill me-1 text-white text-opacity-75 fs-16 align-middle"></i>{{ $page.props.user.data.username }}</div>
                                <div class="me-4"><i class="ri-mail-fill me-1 text-white text-opacity-75 fs-16 align-middle"></i>{{ $page.props.user.data.email }}</div>
                                <div><i class="ri-phone-fill me-1 text-white text-opacity-75 fs-16 align-middle"></i>{{ $page.props.user.data.mobile }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-auto order-last order-lg-0">
                        <form method="POST" @submit.prevent="logout">
                            <button type="submit" class="btn btn-warning"><i class="ri-shut-down-line align-bottom"></i> Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mt-n2">
                    <div class="card bg-light" style="margin-left: 20px; margin-right: 20px;" v-if="$page.props.user.data.status != 1 && $page.props.user.data.status != 15">
                        <div class="card-header bg-light align-items-center d-flex">
                            <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#today" role="tab" aria-selected="true">
                                        Overview
                                    </a>
                                </li>
                                <!-- <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#weekly" role="tab" aria-selected="false" tabindex="-1">
                                        Requests
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#monthly" role="tab" aria-selected="false" tabindex="-1">
                                        Activity Logs
                                    </a>
                                </li> -->
                            </ul>
                        </div>
                        <div class="card-body" style="height: calc(100vh - 240px); overflow: auto;">
                            <div class="tab-content text-muted">
                                <div class="tab-pane active show" id="today" role="tabpanel">
                                    <Overview :lists="lists" :dropdowns="dropdowns" ref="overview"/>
                                </div>
                                <div class="tab-pane" id="weekly" role="tabpanel">
                                    <Request ref="request"/>
                                </div>
                                <div class="tab-pane" id="monthly" role="tabpanel">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" v-else>
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0  me-2">My Profile</h4>
                            <div class="flex-shrink-0 ms-auto">
                               
                            </div>
                        </div>
                        <div class="card-body" style="height: calc(100vh - 240px); overflow: auto;">
                            <BRow class="d-flex justify-content-center align-items-center h-100">
                                <BRow class="justify-content-center">
                                    <BCol md="8" lg="6" xl="5" v-if="status == 1">
                                        <div class="alert alert-warning material-shadow" role="alert">
                                            Your account is <b>not yet verified.</b> Please provide the following attachments.
                                        </div>
                                        <ul class="mt-n2">
                                            <li>School ID</li>
                                            <li>Governtment Issued ID</li>
                                            <li>Authorization</li>
                                        </ul>
                                        <hr class="text-muted mb-2"/>
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
                                        <div class="d-grid gap-2 mt-4">
                                            <button @click="submitFiles" :disabled="!files.length" class="btn btn-primary" type="button">Submit</button>
                                        </div>
                                    </BCol>
                                    <BCol md="8" lg="6" xl="5" v-else>
                                        <div class="alert alert-info material-shadow text-center" role="alert">
                                            Please wait while our staff reviews your account request. <br /> Upon confirmation of your account, you will be able to submit document requests.
                                        </div>
                                    </BCol>
                                </BRow>
                            </BRow>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <b-modal v-model="message" hide-footer hide-header class="v-modal-custom" modal-class="zoomIn" body-class="p-0" centered hide-header-close style="z-index: 5000;">
        <div class="text-end me-4">
            <button type="button" class="btn-close text-end" @click="check()"></button>
        </div>
        <div class="text-center px-5 pt-2 mb-5">
            <div class="mt-2">
                 <div class="avatar-md mx-auto">
                    <div class="avatar-title rounded-circle bg-light">
                        <i v-if="$page.props.flash.status" class="ri-checkbox-circle-fill text-success h1 mb-0"></i>
                        <i v-else class="ri-close-circle-fill text-danger h1 mb-0"></i>
                    </div>
                </div>
                <h5 class="mb-1 mt-4 fs-14">{{$page.props.flash.message }}</h5>
                <p v-if="$page.props.flash.info" class="text-muted fs-12">{{$page.props.flash.info }}</p>
            </div>
        </div>
    </b-modal>
</template>
<script>
import { layoutComputed } from "@/Shared/State/helpers";
import Overview from './Students/Overview.vue';
import Request from './Students/Request.vue';
export default {
    props: ['lists','dropdowns'],
    layout: null,
    components: { Overview, Request },
    data(){
        return {
            status: this.$page.props.user.data.status,
            files: []
        }
    },
    computed: {
        ...layoutComputed,
        message() {
            return (this.$page.props.flash.message) ?  true : false;
        }
    },
    methods: {
        handleFileUpload(event) {
            this.files = Array.from(event.target.files); // Convert FileList to array
        },
        submitFiles() {
            const formData = new FormData();
            this.files.forEach((file, index) => {
                formData.append(`files[${index}]`, file);
            });

            axios.post('/profile', formData, {
                headers: {
                'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                this.status = response.data.status;
            })
            .catch(error => {
                console.error('Error uploading files:', error);
            });
        },
        logout() {
            axios.post('/logout').then(() => {
                window.location.href = '/login';
            }).catch(error => {
                console.error("Logout failed:", error);
            });
        },
        check(){
            this.$page.props.flash = {};
            this.message = false;
        }
    }
}
</script>