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

                        <div class="col-12 col-md-6 col-xl-6 text-center">
                            <div class="text-left mt-3">
                                <div class="">
                                    <br>
                                    <div class="font-w600">Name:
                                        <a class="text-left"><b class="text-primary">{{user.name}}</b></a>
                                    </div>
                                    <br>
                                    <div class="font-w600">Phone:
                                        <a class="text-left"><b class="text-primary">{{user.phone}}</b></a>
                                    </div>
                                    <br>
                                    <div class="font-w600">Email:
                                        <a class="text-left"><b class="text-primary">{{user.email}}</b></a>
                                    </div>
                                    </div>
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
