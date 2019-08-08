<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Overview</span>
        </nav>
        <div  v-if="driver.approved == '0'">

            <div class="block">
                <div class="block-content">
                    <h4>Account Under Review</h4>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="block">
                <div class="block-content">
                    <div class="col-6">
                        <label class="css-control css-control-success css-switch">
                            <input type="checkbox" v-model="driver.available"
                                   @click.prevent="toggleAvailability(driver.id, driver)" class="css-control-input">
                            <span class="css-control-indicator"></span>
                            <span class="text-success" v-if="driver.available == '1'">Available</span>
                            <span class="text-danger" v-else>Unavailable</span>
                        </label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 col-md-4 col-xl-4">
                    <router-link class="block block-link-shadow text-center" to="history">
                        <div class="block-content ribbon ribbon-bookmark ribbon-success ribbon-left">
                            <div class="ribbon-box">{{count}}</div>
                            <p class="mt-5">
                                <i class="fa fa-cab fa-3x"></i>
                            </p>
                            <p class="font-w600">Pending Ride Request</p>
                        </div>
                    </router-link>
                </div>

            </div>
        </div>
        <!-- verify account modal-->
        <div
            class="modal fade"
            id="modal-pop1"
            tabindex="-1"
            role="dialog"
            aria-labelledby="modal-popin"
            style="display: none;"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-popin modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-gd-primary">
                            <h3 class="block-title">Account Verification</h3>
                            <div class="block-options">
                                <button
                                    type="button"
                                    class="btn-block-option"
                                    data-dismiss="modal"
                                    aria-label="Close"
                                >
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <!-- verify account content -->
                            <div class="alert alert-info mb-3">
                                Click on
                                <a
                                    @click.prevent="viewProfile"
                                    href
                                    style="text-decoration: underline;"
                                >Settings</a> to update your profile.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end verify account modal -->
    </div>
</template>

<script>
    import {RepositoryFactory} from "../../repository/RepositoryFactory";

    const UsersRepository = RepositoryFactory.get("users");
    export default {
        data() {
            return {
                checked: true,
                rides: '',
                driver: "",
                count: null,
            };
        },
        methods: {
            viewProfile() {
                window.location = "/driver/profile";
            },
            toggleAvailability(id, driver) {
                this.checked = !this.checked;
                console.log(driver.available)
                if (driver.available == '1') {
                    let data = {
                        status: 0,
                    };
                    axios.post(`/api/user/driver/availability/${id}`, data).then(response => {
                        Fire.$emit("Refresh");
                    });
                } else {
                    let data = {
                        status: 1,
                    };
                    axios.post(`/api/user/driver/availability/${id}`, data).then(response => {
                        Fire.$emit("Refresh");
                    });
                }
            },
            authUser() {
                axios.get('/api/user').then(response => {
                    axios.get(`/api/user/driver/${response.data.id}`).then(response => {
                        this.driver = response.data;
                        if (response.data.licence_expiry == null || response.data.car_type == null) {
                            setTimeout(function () {
                                $("#modal-pop1").modal("show");
                            }, 3000);
                        }
                    });
                });
            }
        },
        mounted() {
            axios.get('/api/user').then(response => {
                this.user = response.data;
                axios.get(`/api/user/driver/${response.data.id}`).then(res => {
                    this.driver = res.data;
                    axios.get(`/api/user/driver/${res.data.id}/pending-rides`).then(resp => {
                        this.count = resp.data
                    });
                });
            });
        },
        created() {
            this.authUser();
            Fire.$on("Refresh", () => {
                this.authUser();
            });
        }
    };
</script>
