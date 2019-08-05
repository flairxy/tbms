<template>
    <div>
        <div class="mt-3">
            <div>
                <div class="row align-items-center">
                    <div class="col">
                        <ul class="nav nav-tabs nav-tabs-alt js-tabs-enabled" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="personal-tab" data-toggle="tab" href="#personal"
                                   role="tab"
                                   aria-controls="personal" aria-selected="true"
                                >Personal Data</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade show active mt-3" id="personal" role="tabpanel"
                         aria-labelledby="personal-tab">

                        <div class="form-group mt-3"
                             v-if="driver.car_type != null && driver.licence_expiry != null && driver.approved == '0'">
                            <h2 class="text-muted">Account under review</h2>
                        </div>

                        <div class="col-12 col-md-6 col-xl-6 text-center"
                             v-else-if="driver.car_type != null && driver.licence_expiry != null && driver.approved == '1'">
                            <div class="text-left mt-3">
                                <div class="">
                                    <div class="font-w600">Status:
                                        <a class="badge badge-success text-white text-left" v-if="driver.approved == '1'">Approved</a>
                                        <a class="badge badge-warning text-white text-left" v-else>Pending</a>
                                    </div>
                                    <br>
                                    <div class="font-w600">Name:
                                        <a class="text-left"><b class="text-primary">{{user.name}}</b></a>
                                    </div>
                                    <br>
                                    <div class="font-w600">Phone:
                                        <a class="text-left"><b class="text-primary">{{user.phone}}</b></a>
                                    </div>
                                    <br>
                                    <div class="font-w600">Registration No:
                                        <a class="text-left"><b class="text-primary">{{driver.registration_no}}</b></a>
                                    </div>
                                    <br>
                                    <div class="font-w600">Car Type:
                                        <i class="fa fa-cab" v-if="driver.car_type === 'taxi'"> Taxi</i>
                                        <i class="fa fa-bus" v-else> Bus</i>
                                    </div>
                                    <br>
                                    <div class="font-w600">Rating:
                                        <span class="js-rating" style="cursor: pointer;">
                                        <i v-for="index in driver.rating" data-alt="2"
                                           class="fa fa-fw fa-star text-warning"></i>&nbsp&nbsp;
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form @submit.prevent="updateProfile(driver.id)" v-else>
                            <div class="form-group row">
                                <label class="col-12 col-form-label">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" :value="user.name" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-form-label">Email</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" :value="user.email" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-form-label">Car Type</label>
                                <div class="col-md-6">
                                    <select class="form-control" id="example-select"
                                            v-model="form.car_type"
                                            name="example-select">
                                        <option value="0" disabled>Car Type</option>
                                        <option value="taxi">Taxi</option>
                                        <option value="bus">Bus</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-form-label">Licence Expiry Date</label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control"
                                           v-model="form.licence_expiry"
                                    >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-form-label">License Upload</label>
                                <div class="col-md-6">
                                    <div class="custom-file">
                                        <input type="file"
                                               class="custom-file-input js-custom-file-input-enabled"
                                               @change="onLicenceChanged" accept=".jpg, .png, .jpeg"
                                               data-toggle="custom-file-input">
                                        <label class="custom-file-label">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-form-label">Passport Upload</label>
                                <div class="col-md-6">
                                    <div class="custom-file">
                                        <input type="file"
                                               class="custom-file-input js-custom-file-input-enabled"
                                               @change="onPassportChanged" accept=".jpg, .png, .jpeg"
                                               data-toggle="custom-file-input">
                                        <label class="custom-file-label">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-info mb-10">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import SecurityComponent from '../../components/profile/security'

    import {RepositoryFactory} from '../../repository/RepositoryFactory'

    const UsersRepository = RepositoryFactory.get('users');

    export default {
        components: {
            // SecurityComponent,
        },
        data() {
            return {
                image1: '/media/avatars/avatar15.jpg',
                avatar: '/media/avatars/avatar9.jpg',
                user: '',
                driver: '',
                file1: [],
                file2: [],
                userPassport: '',
                licence: '',
                form: new Form({
                    car_type: '',
                    licence_expiry: ''
                })
            }
        },
        methods: {
            onLicenceChanged(event) {
                let licence = event.target.files[0];
                this.file1.push(licence)
            },
            onPassportChanged(event) {
                let passport = event.target.files[0];
                this.file2.push(passport)
            },
            updateProfile(id) {
                console.log(id)
                const formData = new FormData();
                formData.append('licence', this.file1[0]);
                formData.append('passport', this.file2[0]);
                formData.append('car_type', this.form.car_type);
                formData.append('licence_expiry', this.form.licence_expiry);
                axios.post(`/api/user/driver/update/${id}`, formData).then(response => {
                    Fire.$emit("Refresh");
                    toast.fire({
                        type: "success",
                        title: "Profile Updated. Application under review"
                    });
                }).catch(err => {
                    toast.fire({
                        type: "error",
                        title: "Profile Updated Failed. Check provided information"
                    });
                });
            },
            authUser() {
                axios.get('/api/user').then(response => {
                    this.user = response.data;
                    axios.get(`/api/user/driver/${response.data.id}`).then(res => {
                        this.driver = res.data;
                        axios.get(`/api/user/driver/${res.data.id}/pending-rides`).then(resp => {
                            this.count = resp.data
                        });
                    });
                });
            }
        },
        created() {
            this.authUser();
            Fire.$on('Refresh', () => {
                this.authUser();
            })
        }
    }
</script>

<style scoped>
    #bg-image {
        background-image: url('/media/photos/photo13@2x.jpg');
    }
</style>
