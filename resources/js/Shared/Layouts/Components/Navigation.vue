<script>
import View from '../../../Pages/Dashboard/Modals/View.vue';
import Student from '../../../Pages/Dashboard/Modals/Student.vue';
    import { router } from '@inertiajs/vue3';
    import { layoutMethods } from "@/Shared/State/helpers";
    import simplebar from "simplebar-vue";
    export default {
      props: ['notification'],

     
        data() {
            return {
                currentUrl: window.location.origin,
                text: null,
                value: null,
                myVar: 1,
                refreshInterval: null,
            };
        },
        components: {
            simplebar, View, Student
        },

        methods: {
            ...layoutMethods,
            logout() {
      router.post('/logout');
    },
    refreshNotifications() {
        console.log("Manually refreshing...");
        Inertia.visit(window.location.href, {
            only: ['notification'],
            preserveScroll: true,
        });
    },
            toggleHamburgerMenu() {
                var windowSize = document.documentElement.clientWidth;
                let layoutType = document.documentElement.getAttribute("data-layout");

                document.documentElement.setAttribute("data-sidebar-visibility", "show");
                let visiblilityType = document.documentElement.getAttribute("data-sidebar-visibility");

                if (windowSize > 767)
                    document.querySelector(".hamburger-icon").classList.toggle("open");

                //For collapse horizontal menu
                if (
                    document.documentElement.getAttribute("data-layout") === "horizontal"
                ) {
                    document.body.classList.contains("menu") ?
                        document.body.classList.remove("menu") :
                        document.body.classList.add("menu");
                }

                //For collapse vertical menu

                if (visiblilityType === "show" && (layoutType === "vertical" || layoutType === "semibox")) {
                    if (windowSize < 1025 && windowSize > 767) {
                        document.body.classList.remove("vertical-sidebar-enable");
                        document.documentElement.getAttribute("data-sidebar-size") == "sm" ?
                            document.documentElement.setAttribute("data-sidebar-size", "") :
                            document.documentElement.setAttribute("data-sidebar-size", "sm");
                    } else if (windowSize > 1025) {
                        document.body.classList.remove("vertical-sidebar-enable");
                        document.documentElement.getAttribute("data-sidebar-size") == "lg" ?
                            document.documentElement.setAttribute("data-sidebar-size", "sm") :
                            document.documentElement.setAttribute("data-sidebar-size", "lg");
                    } else if (windowSize <= 767) {
                        document.body.classList.add("vertical-sidebar-enable");
                        document.documentElement.setAttribute("data-sidebar-size", "lg");
                    }
                }

                //Two column menu
                if (document.documentElement.getAttribute("data-layout") == "twocolumn") {
                    document.body.classList.contains("twocolumn-panel") ?
                        document.body.classList.remove("twocolumn-panel") :
                        document.body.classList.add("twocolumn-panel");
                }
            },
            toggleMenu() {
                this.$parent.toggleMenu();
            },
            toggleRightSidebar() {
                this.$parent.toggleRightSidebar();
            },
            openView(data){
              this.$refs.view.show(data);
            },
            openStudent(data){
              this.$refs.student.show(data);
            }
        },

        mounted() {
            document.addEventListener("scroll", function () {
                var pageTopbar = document.getElementById("page-topbar");
                if (pageTopbar) {
                    document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50 ? pageTopbar
                        .classList.add(
                            "topbar-shadow") : pageTopbar.classList.remove("topbar-shadow");
                }
            });
            if (document.getElementById("topnav-hamburger-icon"))
                document.getElementById("topnav-hamburger-icon").addEventListener("click", this.toggleHamburgerMenu);

             

        },
    };
</script>

<template>
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box horizontal-logo">
                        <Link href="/" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="@assets/images/job.png" alt="" height="22" />
                        </span>
                        <span class="logo-lg">
                            <img src="@assets/images/adzu.png" alt="" height="45" />
                        </span>
                        <span class="fs-24 ms-2">Registrify </span>
                        </Link>

                        <Link href="/" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="@assets/images/job.png" alt="" height="22" />
                        </span>
                        <span class="logo-lg">
                            <img src="@assets/images/adzu.png" alt="" height="45" />
                        </span>
                        </Link>
                    </div>
                    <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                        id="topnav-hamburger-icon">
                        <span class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>

                </div>

                <div class="d-flex align-items-center">
                    <BDropdown class="dropdown d-md-none topbar-head-dropdown header-item" variant="ghost-secondary"
                        dropstart :offset="{ alignmentAxis: 55, crossAxis: 15, mainAxis: 0 }"
                        toggle-class="btn-icon btn-topbar rounded-circle arrow-none"
                        menu-class="dropdown-menu-lg dropdown-menu-end p-0">
                        <template #button-content>
                            <i class="bx bx-search fs-22"></i>
                        </template>
                        <BDropdownItem aria-labelledby="page-header-search-dropdown">
                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..."
                                            aria-label="Recipient's username" />
                                        <BButton variant="primary" type="submit">
                                            <i class="mdi mdi-magnify"></i>
                                        </BButton>
                                    </div>
                                </div>
                            </form>
                        </BDropdownItem>
                    </BDropdown>

                    <BDropdown variant="ghost-dark" dropstart class="ms-1 dropdown" :offset="{ alignmentAxis: 57, crossAxis: 0, mainAxis: -42 }" toggle-class="btn-icon btn-topbar rounded-circle arrow-none"
                        id="page-header-notifications-dropdown" menu-class="dropdown-menu-lg dropdown-menu-end p-0"
                        auto-close="outside">
                        <template #button-content>
                            <i class='bx bx-bell fs-22'></i>
                              <span v-if="notification.total > 0" class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">
                                <span class="notification-badge">{{ notification.total }}</span>
                                <span class="visually-hidden">notifications</span>
                            </span>
                        </template>
                        <div class="dropdown-head bg-primary bg-pattern rounded-top dropdown-menu-lg">
                            <div class="p-3">
                                <BRow class="align-items-center">
                                    <BCol>
                                        <h6 class="m-0 fs-16 fw-semibold text-white">
                                            Notifications
                                        </h6>
                                    </BCol>
                                    <BCol cols="auto" class="dropdown-tabs">
                                        <BBadge variant="light-subtle" class="bg-light-subtle text-body fs-13"> {{ notification.total }} New
                                        </BBadge>
                                    </BCol>
                                </BRow>
                            </div>
                        </div>
                        <BTabs nav-class="dropdown-tabs nav-tab-custom bg-primary px-2 pt-2">
                            <BTab :title="notification.s" class="tab-pane fade py-2 ps-2 show" id="all-noti-tab"
                                role="tabpanel">
                                <simplebar data-simplebar style="max-height: 300px" class="pe-2">

                                  <div @click="openStudent(list)" v-for="(list,index) in notification.student_lists.data" v-bind:key="index" class="text-reset notification-item d-block dropdown-item position-relative">
                                    <div class="d-flex">
                                      <div class="avatar-xs me-3 flex-shrink-0">
                                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-16">
                                          <i class="ri-user-2-fill"></i>
                                        </span>
                                      </div>
                                      <div class="flex-grow-1">
                                        <BLink href="#!" class="stretched-link">
                                          <h6 class="mt-0 mb-2 fs-11 lh-base">
                                            <span class="fw-semibold text-primary">{{list.firstname}} {{list.lastname}}</span> <span class="text-muted">registered to the system</span> 
                                          </h6>
                                        </BLink>
                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                          <span><i class="mdi mdi-clock-outline"></i>{{list.created_at}}</span>
                                        </p>
                                      </div>
                                      <!-- <div class="px-2 fs-15">
                                        <input class="form-check-input" type="checkbox" />
                                      </div> -->
                                    </div>
                                  </div>

                                    <div class="my-3 text-center">
                                        <Link href="/dashboard">
                                          <BButton type="button" variant="soft-success">
                                            View Students 
                                            <i class="ri-arrow-right-line align-middle"></i>
                                        </BButton>
                                      </Link>
                                    </div>
                                </simplebar>
                            </BTab>

                            <BTab :title="notification.r" class="tab-pane fade py-2 ps-2" id="messages-tab" role="tabpanel"
                                aria-labelledby="messages-tab">
                               
                                <simplebar data-simplebar style="max-height: 300px" class="pe-2">
                                  
                                  <div @click="openView(list)" v-for="(list,index) in notification.document_lists.data" v-bind:key="index" class="text-reset notification-item d-block dropdown-item position-relative">
                                    <div class="d-flex">
                                      <div class="avatar-xs me-3 flex-shrink-0">
                                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-16">
                                          <i class="bx bx-message-square-dots"></i>
                                        </span>
                                      </div>
                                      <div class="flex-grow-1">
                                        <BLink href="#!" class="stretched-link">
                                          <h6 class="mt-0 mb-2 fs-11 lh-base">
                                            <span class="text-muted">New request from</span> <span class="fw-semibold text-primary">{{ list.name }}</span>
                                          </h6>
                                        </BLink>
                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                          <span><i class="mdi mdi-clock-outline"></i> {{ list.created_at }}</span>
                                        </p>
                                      </div>
                                      <!-- <div class="px-2 fs-15">
                                        <input class="form-check-input" type="checkbox" />
                                      </div> -->
                                    </div>
                                  </div>

                                    <div class="my-3 text-center">
                                      <Link href="/dashboard">
                                        <BButton type="button" variant="soft-success">
                                            View All Requests 
                                            <i class="ri-arrow-right-line align-middle"></i>
                                        </BButton>
                                      </Link>
                                    </div>
                                </simplebar>
                            </BTab>
                        </BTabs>
                    </BDropdown>

                    <BDropdown variant="link" class="ms-sm-3 header-item topbar-user"
                        toggle-class="rounded-circle arrow-none" menu-class="dropdown-menu-end"
                        :offset="{ alignmentAxis: -14, crossAxis: 0, mainAxis: 0 }">
                        <template #button-content>
                            <span class="d-flex align-items-center">
                                <img class="rounded-circle header-profile-user" :src="$page.props.user.data.avatar"
                                    :alt="$page.props.user.data.username">
                                <span class="text-start ms-xl-2">
                                    <span
                                        class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ $page.props.user.data.name }}</span>
                                    <span
                                        class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{$page.props.user.data.role}}</span>
                                </span>
                            </span>
                        </template>
                        <h6 class="dropdown-header fs-10">Welcome {{ $page.props.user.data.username }}!</h6>


                        <!-- Authentication -->
                        <form method="POST" @submit.prevent="logout" class="dropdown-item">
                            <BButton variant="none" type="submit" class="btn p-0"><i
                                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> Logout</BButton>
                        </form>
                    </BDropdown>
                </div>
            </div>
        </div>
    </header>
    <View ref="view"/>
    <Student ref="student"/>
</template>