<template>
    <div class="col-md-8">
        <div class="block-content">
            <div v-if="errors" class="text-danger">
                <ul>
                    <li v-for="error in errors"> {{error.toString()}}</li>
                </ul>
            </div>
            <form action="" @submit.prevent="updatePassword">
                <div class="form-group">
                    <div class="form-material">
                        <input type="password" class="form-control" id="password" v-model="form.password">
                        <label for="password">New Password</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="password" class="form-control" id="password_confirm"
                               v-model="form.confirm_password">
                        <label for="password_confirm">Confirm Password</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-outline-info mb-10">Update password</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {RepositoryFactory} from '../../repository/RepositoryFactory'

    const UsersRepository = RepositoryFactory.get('users');
    export default {
        data() {
            return {
                errors: [],
                form: new Form({
                    password: '',
                    confirm_password: '',
                })
            }
        },
        methods: {
            updatePassword() {
                UsersRepository.loggedInUser().then(response => {
                    this.user = response.data;
                    let data = {
                        user: response.data.id,
                        password: this.form.password,
                        password_confirmation: this.form.confirm_password,
                    };
                    UsersRepository.passwordUpdate(data).then(response => {
                        console.log(response);
                        toast.fire({
                            type: response.data.status,
                            title: response.data.message
                        });
                    }).catch(errors => {
                        if (errors.response.status == 422) {
                            this.errors = errors.response.data.errors
                        }
                        toast({
                            type: 'warning',
                            title: 'Registration failed'
                        });
                        this.form.reset()
                    })
                });
            }
        }
    }
</script>

<style scoped>

</style>
