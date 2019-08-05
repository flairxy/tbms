<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">History</span>
        </nav>
        <div class="block">
            <div class="block-content">
                <div class="table-responsive" v-if="rides.length > 0">
                    <table class="js-table-sections table table-hover js-table-sections-enabled">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Destination</th>
                            <th>Driver</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="js-table-sections-header">
                        <tr v-for="(ride, index) in rides" :key="ride.id">
                            <td class="text-center">{{index + 1}}</td>
                            <td class="font-size-sm">{{ride.destination}}</td>
                            <td class="font-size-sm">
                                <span v-for="user in users" :key="user.id">
                                    <span v-if="user.id == ride.driver_id">{{user.name}}</span>
                                </span>
                            </td>
                            <td class="font-size-sm">
                                <span v-if="ride.status == '0'" class="text-warning"><b>Ongoing</b></span>
                                <span v-else-if="ride.status == '1'" class="text-success"><b>Completed</b></span>
                                <span v-else class="text-danger"><b>Cancelled</b></span>
                            </td>
                            <td class="font-size-sm">{{ride.created_at}}</td>
                            <td class="row">
                                <a @click.prevent="viewModal(ride.id, ride.driver_id)" class="mb-1 mr-1 btn btn-sm text-white btn-primary"
                                   v-if="ride.rating == null && ride.status != '2'">Rate</a>
                                <span class="font-size-sm text-corporate" v-else>
                                    <span class="js-rating" style="cursor: pointer;">
                                        <i v-for="index in ride.rating" data-alt="2"
                                           class="fa fa-fw fa-star text-warning"></i>&nbsp&nbsp;
                                    </span>
                                </span>
                                <a @click.prevent="cancelRide(ride.id)" class="col-auto btn btn-sm text-white btn-danger"
                                   v-if="ride.status == '0'">Cancel</a>
                                <button disabled class="font-size-sm btn btn-sm" v-if="ride.status == '2'">cancelled</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else>
                    <h3 class="text-muted">You have no ride history</h3>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-pop" tabindex="-1" role="dialog"
             aria-labelledby="modal-popin" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popin modal-md" role="document">
                <div class="modal-content">
                    <div class="block block-transparent mb-0">
                        <div class="block-content">
                            <!-- verify account content -->
                            <div class="js-rating" style="cursor: pointer;">
                                <star-rating :increment="1"
                                             :max-rating="5"
                                             :star-size="50"
                                             @@rating-selected="setRating"
                                             v-model="rating"
                                >
                                </star-rating>
                            </div>
                            <div class="form-group">
                                <div class="form-material">
                                    <button type="submit" @click.prevent="rateCurrentRide"
                                            class="btn bg-primary text-white mb-10">Rate
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {RepositoryFactory} from '../../repository/RepositoryFactory'

    const UsersRepository = RepositoryFactory.get('users');
    export default {
        data() {
            return {
                rides: [],
                users: [],
                user: '',
                ride_id: '',
                driver_id: '',
                rating: 0,
            }
        },
        methods: {
            cancelRide(id) {
                axios.post(`/api/user/ride/${id}/cancel`).then(response => {
                    Fire.$emit("Refresh");
                    toast.fire({
                        type: 'success',
                        title: 'Ride Cancelled'
                    })
                })
            },
            rateCurrentRide(id) {
                let data = {
                    rating: this.rating,
                    ride: this.ride_id,
                    driver: this.driver_id,
                };
                axios.post(`/api/user/rate-ride`, data).then(response => {
                    $("#modal-pop").modal("hide");
                    Fire.$emit("Refresh");
                    toast.fire({
                        type: 'success',
                        title: 'Rating successful'
                    })
                }).catch(err => {
                    $("#modal-pop").modal("hide");
                    toast.fire({
                        type: 'error',
                        title: 'Failed to complete rating'
                    })
                });
            },
            setRating(rating) {
                this.rating = rating
            },
            viewModal(id, driver) {
                $("#modal-pop").modal("show");
                this.ride_id = id;
                this.driver_id = driver;
            },
            history() {
                axios.get(`/api/user`).then(response => {
                    this.user = response.data;
                    axios.get(`/api/user/rides/${response.data.id}`).then(response => {
                        this.rides = response.data.rides;
                        this.users = response.data.drivers;
                    });
                });
            }
        },
        created() {
            this.history();
            Fire.$on("Refresh", () => {
                this.history();
            });
        }

    }
</script>
