<template>
    <Head title="Mobile Carwash" />
    <div class="layout-wrapper landing">
       
        <section class="py-5 bg-primary position-relative">
            <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
            <b-container class="hidemobile">
                <b-row class="align-items-center gy-4">
                    <b-col sm>
                        <div>
                            <h4 class="text-white mb-0 fw-semibold">Registrify | College Registrar's Office </h4>
                        </div>
                    </b-col>
                    <b-col sm="auto">
                        <div>
                            <button @click="openRegister()" class="btn bg-gradient btn-warning fw-bold">REQUEST DOCUMENT</button>
                        </div>
                    </b-col>
                </b-row>
            </b-container>
            <b-container class="showmobile"> 
                <b-row class="align-items-center gy-3">
                <div class="d-grid mt-n3 mb-n5" >
                    <BButton @click="openRegister()" variant="warning" class="submit-btn w-80 h-100 fw-semibold" type="submit">BOOK NOW</BButton>
                </div></b-row>
            </b-container>
        </section>

        <section class="section bg-light" id="plans">
            <div class="bg-overlay bg-overlay-pattern"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h3 class="mb-1 fw-semibold rstitle">College Registrar's Office</h3>
                            <p class="text-muted mb-4 rsdef">List of documents and fees.</p>
                        </div>
                    </div>
                </div>

                <div class="row gy-4 mt-n5">
                    
                    <div class="col-lg-12">
                        <div class="card mb-0 ribbon-box right">
                            <div class="card-body p-4 m-2">
                                <div class="ribbon-two ribbon-two-danger"><span>Popular</span></div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold rstitle1">College Unit</h5>
                                        <p class="text-muted mb-0 rsdef1">List of Documents</p>
                                    </div>
                                </div>
                                <hr class="text-muted"/>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-bordered align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr class="fs-11">
                                                        <th style="width: 30%;" class="text-center">Document</th>
                                                        <th style="width: 35%;" class="text-center">Regular Processing Fee (5-7 days)</th>
                                                        <th style="width: 35%;" class="text-center">Express Processing Fee (1-3 days)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="fs-12" v-for="(list,index) in colleges" v-bind:key="index">
                                                        <td class="text-center">{{list.name.name}}</td>
                                                        <td class="text-center">{{(list.fees[0].fee != '₱0.00') ? list.fees[0].fee : '-'}}</td>
                                                        <td class="text-center">{{(list.fees[1].fee != '₱0.00') ? list.fees[1].fee : '-'}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card mb-0 ribbon-box right">
                            <div class="card-body p-4 m-2">
                                <div class="ribbon-two ribbon-two-warning"><span>Hot</span></div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold rstitle1">Graduate School</h5>
                                        <p class="text-muted mb-0 rsdef1">List of Documents</p>
                                    </div>
                                </div>
                                <hr class="text-muted"/>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-bordered align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr class="fs-11">
                                                        <th style="width: 30%;" class="text-center">Document</th>
                                                        <th style="width: 35%;" class="text-center">Regular Processing Fee (5-7 days)</th>
                                                        <th style="width: 35%;" class="text-center">Express Processing Fee (1-3 days)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="fs-12" v-for="(list,index) in graduates" v-bind:key="index">
                                                        <td class="text-center">{{list.name.name}}</td>
                                                        <td class="text-center">{{(list.fees[0].fee != '₱0.00') ? list.fees[0].fee : '-'}}</td>
                                                        <td class="text-center">{{(list.fees[1].fee != '₱0.00') ? list.fees[1].fee : '-'}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!--end row-->
            </div>
            <!-- end container -->
        </section>

        <footer class="custom-footer bg-dark py-5 position-relative">
            <b-container>
                <b-row>
                    <b-col lg="7" class="mt-4 hidemobile">
                        <div>
                            <div>
                                <img src="images/logo-light.png" alt="logo light" height="100%" width="150">
                            </div>
                            <div class="mt-4 fs-13 hidemobile">
                                <p>Registrify | College Registrar's Office </p>
                                <p class="ff-secondary">Goodwash Mobile Carwash, brings professional car detailing right at your doorstep. Enjoy our quality services, including exterior wash, waxing, interior cleaning, and more, all at affordable prices. </p>
                            </div>
                        </div>
                    </b-col>

                    <b-col lg="5" class="ms-lg-auto hidemobile">
                        <b-row>
                            <b-col sm="12" class="mt-4 text-end">
                                <h4 class="text-white mb-0">Contact Details</h4>
                                <div class="text-muted mt-4 fs-13">
                                    <ul class="list-unstyled ff-secondary footer-list">
                                        <li>
                                            Ateneo de Zamboanga University
                                        </li>
                                        <li>
                                            BC109 University Communications
                                        </li>
                                        <li>
                                            Office Bellarmine Campion Building 
                                        </li>
                                        <li>
                                            (+63) 966 342 8252 or 991-0871 local 1011.
                                        </li>
                                    </ul>
                                </div>
                            </b-col>
                            
                            
                        </b-row>
                    </b-col>
                </b-row>

                <b-row class="text-center text-sm-start align-items-center mt-5">
                    <b-col sm="6" class="mb-3 mt-n5 showmobile">
                        <img src="images/goodwash.png" alt="logo light" height="100%" width="150">
                    </b-col>
                    <b-col sm="6">
                        <div>
                            <p class="copy-rights mb-0 currentyear">{{ new Date().getFullYear() }} © Registrify
                            </p>
                        </div>
                    </b-col>
                    <b-col sm="6">
                        <div class="text-sm-end mt-3 mt-sm-0">
                            <ul class="list-inline mb-0 footer-social-link">
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-facebook-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-github-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-linkedin-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-google-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-dribbble-line"></i>
                                        </div>
                                    </b-link>
                                </li>
                            </ul>
                        </div>
                    </b-col>
                </b-row>
            </b-container>
        </footer>
        <b-button variant="danger" @click="topFunction" class="btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </b-button>
    </div>

    <BModal v-model="showModal" style="--vz-modal-width: 500px;" hide-footer body-class="p-0" header-class="p-0"
        class="v-modal-custom" content-class="border-0 overflow-hidden" centered hide-header-close>
        <div class="modal-body login-modal p-5">
            <h5 class="text-white fs-16 mb-1 mt-n4">Booking Form</h5>
            <p class="text-white-50 fs-11 mb-4">Please fill out the form carefully to ensure all information is accurate.</p>
            <div class="vstack gap-2 justify-content-center">
               <form class="customform mb-n5" style="color: white;">
                    <BRow class="g-3 mb-2"> 
                        <BCol lg="12" class="mt-n2 mb-0">
                            <hr class="text-muted"/>
                        </BCol>
                        <BCol lg="12" class="mt-0 mb-2">
                            <div class="d-flex">
                                <div style="width: 100%;">
                                    <InputLabel for="name" value="ID Number" :message="form.errors.email"/>
                                    <TextInput id="name" v-model="form.id_number" type="email" class="form-control" placeholder="Please enter your id number" @input="handleInput('email')" :light="true"/>
                                </div>
                                <div class="flex-shrink-0">
                                    <b-button @click="openAdd()" style="margin-top: 20px;" variant="light" class="waves-effect waves-light ms-1"><i class="ri-add-circle-fill"></i></b-button>
                                </div>
                            </div>
                        </BCol>
                        <BCol lg="12" class="mt-n1">
                            <InputLabel for="name" value="Fullname" :message="form.errors.firstname"/>
                              <b-row class="g-3 mt-n3">
                                <b-col lg>
                                    <div class="input-group mb-0">
                                        <input type="text" v-model="form.firstname" placeholder="Firstname" class="form-control" style="width: 30%;">
                                        <input type="text" v-model="form.firstname" placeholder="Middlename" class="form-control" style="width: 30%;">
                                        <input type="text" v-model="form.lastname" placeholder="Lastname" class="form-control" style="width: 25%;">
                                        <input type="text" v-model="form.suffix" placeholder="Suffix" class="form-control" style="width: 15%;">
                                    </div>
                                </b-col>
                            </b-row>
                        </BCol>
                        <BCol lg="6" class="mt-0 mb-3">
                            <InputLabel for="name" value="Email Address" :message="form.errors.email"/>
                            <TextInput id="name" v-model="form.email" type="email" class="form-control" placeholder="Please enter email" @input="handleInput('email')" :light="true"/>
                        </BCol>
                        <BCol lg="6" class="mt-0 mb-3">
                            <InputLabel for="name" value="Contact no." :message="form.errors.contact_no"/>
                            <TextInput id="name" v-model="form.contact_no" type="text" class="form-control" placeholder="Please enter contact no." @input="handleInput('contact_no')" :light="true"/>
                        </BCol>
                    </BRow>
               </form>
            </div>
        </div>
       
        <div class="modal-body p-5">
            <form class="customform">
                <BRow class="g-3" style="margin-top: -35px;"> 
                    <BCol lg="12 mt-1">
                        <InputLabel for="barangay" value="Document Type" :message="form.errors.barangay_code"/>
                        <Multiselect :options="types" :searchable="true" label="name" v-model="form.barangay_code" placeholder="Select Barangay" @input="handleInput('barangay_code')"/>
                    </BCol>
                    <BCol lg="12" class="mt-0"><hr class="text-muted"/></BCol>
                </BRow>
                <div class="mt-n1 form-check">
                    <input type="checkbox" v-model="form.check" class="form-check-input" id="checkTerms">
                    <label class="form-check-label" for="checkTerms">I agree to the <span class="fw-semibold">Terms of Service</span> and Privacy Policy</label>
                </div>
                <div class="text-end mt-2">
                    <button @click="submit('ok')" class="btn btn-primary btn-md" type="button" :disabled="!form.check">
                        <div class="btn-content">Submit Now</div>
                    </button>
                </div>
            </form>
        </div>
    </BModal>
    <b-modal v-model="message" hide-footer class="v-modal-custom" modal-class="zoomIn" body-class="p-0" centered hide-header-close style="z-index: 5000;">
        <div class="text-end me-4">
            <button type="button" class="btn-close text-end" @click="check()"></button>
        </div>
        <div class="text-center px-5 pt-2">
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
        <div class="modal-footer bg-light p-3 mt-5 justify-content-center">
            <p class="mb-0 text-muted fs-10">Thank you for signing up! We look forward to your participation</p>
        </div>
    </b-modal>
</template>
<script>
import Map from './Map.vue';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default { 
    layout: null,
    components: {Multiselect, InputLabel, TextInput, Map},
    props: ['graduates','colleges','types'],
    data() {
        return {
            showModal: false,
            form: useForm({
                firstname: null,
                lastname: null,
                contact_no: null,
                email: null,
                type: null,
                barangay_code: null,
                address: null,
                date: null,
                time: null,
                longitude: null,
                latitude: null,
                service: null,
                check: false
            }),
            coordinates: {},
            tos: false
        };
    },
    methods: {
        submit(){
            this.form.post('/',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.form.clearErrors();
                    this.form.reset();
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        openRegister(){
            this.form.check = false;
            this.showModal = true;
            this.$refs.map.view();
        },
        topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        },
        hide(){
            this.showModal = false;
        },
        check(){
            this.$page.props.flash = {};
            this.message = false;
        },
        handleCoordinates(coords) {
            this.coordinates = coords;
            this.form.longitude = this.coordinates.lng;
            this.form.latitude = this.coordinates.lat;
        },
    },
    mounted() {
        let backtoTop = document.getElementById("back-to-top");
        if (backtoTop) {
            backtoTop = document.getElementById("back-to-top");
            window.onscroll = function () {
                if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                    backtoTop.style.display = "block";
                } else {
                    backtoTop.style.display = "none";
                }
            };
        }
        window.addEventListener('scroll', function (ev) {
            ev.preventDefault();
            var navbar = document.getElementById("navbar");
            if (navbar) {
                if (document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50) {
                    navbar.classList.add("is-sticky");
                } else {
                    navbar.classList.remove("is-sticky");
                }
            }
        });
    },
    computed: {
        message() {
            return (this.$page.props.flash.message) ?  true : false;
        }
    },
};
</script>
<style>
 .question {
    font-size: 20px !important;
}
.details {
    font-size: 14px !important;
}
.showmobile {
    display: none;
}
.hidemobile1 {
    display: block;
}
.rstitle1 {
    font-size: 16px;
}
.rsdef1 {
    font-size: 13px;
}
.rsfont {
    font-size: 14px;
}
@media only screen and (max-width: 768px) {
    .logo {
        display: block;
        margin: 0 auto;
        text-align: center;
        margin-top: 20px;
    }
    .cntr {
        text-align: center;
    }
    .question {
        font-size: 14px !important;
    }
    .details {
        font-size: 11px !important;
    }
    .rightpic {
        display: none;
    }
    .hidemobile {
        display: none;
    }
    .showmobile {
        display: block;
    }
    .hidemobile1 {
        display: none;
    }
    .rstitle {
        margin-top: -20px;
        font-size: 15px;
    }
    .rsdef {
        margin-bottom: -50px;
        font-size: 13px;
    }
    .rstitle1 {
        font-size: 14px;
    }
    .rsdef1 {
        margin-top: 10px;
        font-size: 12px;
    }
    .rsdetails {
        font-size: 13px;
    }
    .rsfont {
        font-size: 12px;
    }
}</style>