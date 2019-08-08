<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Overview</span>
        </nav>
        <div class="row" v-if="drivers.length > 0">
            <div class="col-md-6 col-xl-3"
                 v-for="driver in drivers"
                 :key="driver.id"
                 @click.prevent="continueBooking(driver.id)"
            >
                <a class="block text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full block-content-sm bg-info">
                    <span class="font-w600 text-white">
                        <span v-for="name in users" :key="name.id">
                            <span v-if="name.id == driver.user_id">{{name.name}}</span>
                        </span>
                    </span>
                    </div>
                    <div class="block-content bg-info-light">
                        <img class="img-avatar img-avatar-thumb" src="/media/avatars/avatar11.jpg" v-if="driver.approved == '0'"/>
                        <img class="img-avatar img-avatar-thumb" :src="image_src + driver.passport" v-else/>
                    </div>
                    <div class="block-content">
                        <div class="row items-push text-center">
                            <div class="col-6">
                                <div class="mb-5">
                                    <div class="js-rating" style="cursor: pointer;">
                                        <i v-for="index in driver.rating" data-alt="2"
                                           class="fa fa-fw fa-star text-warning"></i>&nbsp&nbsp;
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="font-size-sm text-muted">
                                    <div class="font-size-sm text-muted">
                                        <i class="fa fa-circle text-success"></i> available
                                    </div>
                                    <div class="font-size-sm text-muted" v-if="driver.car_type == 'bus'">
                                        <i class="fa fa-bus text-success"></i> Bus
                                    </div>
                                    <div class="font-size-sm text-muted" v-else>
                                        <i class="fa fa-cab text-success"></i> Taxi
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div v-else>
            <h3 class="text-muted">There are no drivers available at the moment</h3>
        </div>
        <!-- verify account modal-->
        <div
            class="modal fade"
            id="modal-pop"
            tabindex="-1"
            role="dialog"
            aria-labelledby="modal-popin"
            style="display: none;"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-popin" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-gd-primary">
                            <h3 class="block-title">Complete Booking</h3>
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
                            <form @submit.prevent="completeBooking(user.id, driver_id)">
                                <div class="form-group">
                                    <div class="form-material">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="location"
                                            v-model="form.location"
                                            name="old_password"
                                        />
                                        <label for="location">Location</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="destination"
                                                v-model="form.destination"
                                                name="destination"
                                            />
                                            <label for="destination">Destination</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <input
                                                type="date"
                                                class="form-control"
                                                id="date"
                                                v-model="form.date"
                                                name="date"
                                            />
                                            <label for="date">Date</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <input
                                                type="time"
                                                class="form-control"
                                                id="time"
                                                v-model="form.time"
                                                name="time"
                                            />
                                            <label for="date">Time</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <div v-if="booking" class="col-6 col-md-3">
                                                <i class="fa fa-2x fa-cog fa-spin text-primary"></i>
                                            </div>
                                            <button type="submit" v-else class="btn bg-primary text-white mb-10">Book
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end continue booking modal -->
    </div>
</template>

<script>
    import {RepositoryFactory} from "../../repository/RepositoryFactory";

    const UsersRepository = RepositoryFactory.get("users");
    export default {
        data() {
            return {
                drivers: [],
                users: [],
                rides: [],
                image_src: '/files/passport/',
                processing: false,
                booking: false,
                driver_id: '',
                user: "",
                form: new Form({
                    time: "",
                    date: "",
                    destination: "",
                    location: "",
                    driver: ""
                })
            };
        },
        methods: {
            filterDrivers() {
                this.processing = true;
            },
            continueBooking(driver) {
                $("#modal-pop").modal("show");
                this.driver_id = driver
            },
            completeBooking(id, driver) {
                this.booking = true;
                let data = {
                    user: id,
                    location: this.form.location,
                    destination: this.form.destination,
                    driver: driver,
                    date: this.form.date,
                    time: this.form.time
                };
                axios.post(`/api/user/book/ride`, data).then(response => {
                    $("#modal-pop").modal("hide");
                    this.booking = false;
                    toast.fire({
                        type: 'success',
                        title: 'Ride request initiated successfully. Redirecting to payment page'
                    });
                    setTimeout(function() {
                        window.location = "/user/payment";
                    }, 3000);
                }).catch(err => {
                    this.booking = false;
                    toast.fire({
                        type: 'error',
                        title: 'Ride request failed. Check provided information'
                    });
                });
            },
        },
        mounted() {
            axios.get('/api/user').then(response => {
                this.user = response.data;
            });
            axios.get(`/api/user/drivers`).then(response => {
                // this.drivers = response.drivers;
                this.drivers = response.data.drivers;
                this.users = response.data.users;
                for (let rides in response.da)
                this.rides = response.data.rides;
            });
        },
    };
</script>
