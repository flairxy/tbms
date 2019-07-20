<template>
    <div class="bg-image" style="background-image: url('/media/photos/photo34@2x.jpg')">
        <div class="row mx-0 bg-earth-op">
            <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                <div class="p-30 invisible" data-toggle="appear">
                    <p class="font-size-h3 font-w600 text-white mb-5">
                        We're very happy you are joining our community!
                    </p>
                    <p class="font-size-h5 text-white">
                        <i class="fa fa-angles-right"></i> Create your account today and receive 50% off.
                    </p>
                    <p class="font-italic text-white-op">
                        Copyright &copy; <span class="js-year-copy">2017</span>
                    </p>
                </div>
            </div>
            <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-white">
                <div class="content content-full">
                    <!-- Header -->
                    <div class="px-30 py-10">
                        <a class="link-effect font-w700" href="/">
                            <i class="si si-fire"></i>
                            <span class="font-size-xl text-primary-dark">code</span><span
                            class="font-size-xl">base</span>
                        </a>
                        <h1 class="h3 font-w700 mt-30 mb-10">Create New Account</h1>
                        <h2 class="h5 font-w400 text-muted mb-0">Please add your details</h2>
                    </div>
                    <form class="js-validation-signup px-30" @submit.prevent="registerUser" @keydown="form.onKeydown($event)">
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material floating">

                                    <input v-model="form.username" id="signup-username" type="text" name="username"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('username') }">
                                    <label for="signup-username">Username</label>
                                    <has-error :form="form" field="username"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input type="email" class="form-control" id="signup-email" name="email"
                                           :class="{ 'is-invalid': form.errors.has('email') }" v-model="form.email"
                                           >
                                    <label for="signup-email">Email</label>
                                    <has-error :form="form" field="email"></has-error>

                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input type="password" class="form-control" id="signup-password"
                                           :class="{ 'is-invalid': form.errors.has('password') }" v-model="form.password" >
                                    <has-error :form="form" field="password"></has-error>
                                    <label for="signup-password">Password</label>

                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input type="password" class="form-control" id="signup-password-confirm"
                                           v-model="form.password_confirmation" >
                                    <label for="signup-password-confirm">Password Confirmation</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-hero btn-alt-success">
                                <i class="fa fa-plus mr-10"></i> Register
                            </button>
                            <div class="mt-30">
                                <router-link to="login" class="link-effect text-muted mr-10 mb-5 d-inline-block">
                                    <i class="fa fa-user text-muted mr-5"></i> Login
                                </router-link>
                            </div>
                        </div>
                    </form>
                    <!-- END Sign Up Form -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import { Form, HasError, AlertError } from 'vform'

    Vue.component(HasError.name, HasError);
    Vue.component(AlertError.name, AlertError);
    import $ from 'jquery'
    import Swal from 'sweetalert2'
    import toast from 'sweetalert2'
    import {RepositoryFactory} from '../../repository/RepositoryFactory'

    const AuthRepository = RepositoryFactory.get('users');
    export default {
        data() {
            return {
                form: new Form ({
                    email: '',
                    password: '',
                    password_confirmation: '',
                    username: '',
                    remember: false
                })
            }
        },
        methods: {
            registerUser() {
                AuthRepository.userRegistration(this.form).then(response => {
                    toast({
                        type: 'success',
                        title: 'registration successful'
                    });
                    // console.log(response.data);
                    // toast({
                    //     type: response.data.status,
                    //     title: response.data.message
                    // })

                }).catch(error => {
                    toast({
                        type: 'warning',
                        title: 'registration failed'
                    });
                })

            }
        }
    }
</script>
