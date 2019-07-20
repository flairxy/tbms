<template>
    <div class="bg-image" style="background-image: url('/media/photos/photo34@2x.jpg')">
        <div class="row mx-0 bg-black-op">
            <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                <div class="p-30 invisible" data-toggle="appear">
                    <p class="font-size-h3 font-w600 text-white">
                    </p>
                    <p class="font-italic text-white-op">
                        Copyright &copy; <span class="js-year-copy">2019</span>
                    </p>
                </div>
            </div>
            <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-white" data-toggle="appear"
                 data-class="animated fadeInRight">
                <div class="content content-full">
                    <!-- Header -->
                    <div class="px-30 py-10">
                        <a class="link-effect font-w700" href="/">
                            <i class="si si-fire"></i>
                            <span class="font-size-xl text-primary-dark">code</span><span
                            class="font-size-xl">base</span>
                        </a>
                        <h1 class="h3 font-w700 mt-30 mb-10">Access Your Dashboard</h1>
                        <h2 class="h5 font-w400 text-muted mb-0">Please sign in</h2>
                    </div>

                    <form class="js-validation-signin px-30" @submit.prevent="loginUser">
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input type="text" class="form-control"
                                           name="email" v-model="form.email"
                                           id="login-username" autofocus required>
                                    <label for="login-username">Email</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-material floating">
                                    <input type="password" class="form-control" id="login-password"
                                           v-model="form.password" name="password">
                                    <label for="login-password">Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                    id="remember" name="remember">
                                    <label class="custom-control-label" for="remember">Remember Me</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-hero btn-alt-primary">
                                <i class="si si-login mr-10"></i> Sign In
                            </button>
                            <div class="mt-30">
                                <router-link to="register" class="link-effect text-muted mr-10 mb-5 d-inline-block">
                                    <i class="fa fa-plus mr-5"></i> Create Account
                                </router-link>
                                <router-link to="reset-password" class="link-effect text-muted mr-10 mb-5 d-inline-block">
                                    <i class="fa fa-warning mr-5"></i> Forgot Password
                                </router-link>
                            </div>
                        </div>
                    </form>
                    <!-- END Sign In Form -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {RepositoryFactory} from '../../repository/RepositoryFactory'

    const AuthRepository = RepositoryFactory.get('users');
    export default {
        data() {
            return {
                form: new Form ({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },
        methods: {
            loginUser() {
                this.$store.dispatch('login', { email: this.form.email, password: this.form.password })
            }
        }
    }
</script>

<style scoped>

</style>
