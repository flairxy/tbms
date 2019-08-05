<template>
    <div class="col-md-8">
        <div class="block-content">
            <span class="text-danger">New password should be different from old password </span>
            <div v-if="errors" class="text-danger">
                <ul>
                    <li v-for="error in errors"> {{error.toString()}}</li>
                </ul>
            </div>
            <form action="" @submit.prevent="updatePassword">
                <div class="form-group">
                    <div class="form-material">
                        <input type="password" class="form-control" id="old_password" v-model="form.old_password">
                        <label for="old_password">Old Password</label>
                    </div>
                </div>
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
                    old_password: ''
                })
            }
        },
        methods: {
            updatePassword() {
                axios.get('/api/user').then(response => {
                    this.user = response.data;
                    let data = {
                        user: response.data.id,
                        old_password: this.form.old_password,
                        password: this.form.password,
                        password_confirmation: this.form.confirm_password,
                    };
                    UsersRepository.passwordUpdate(data).then(response => {
                        Fire.$emit("Refresh");
                        toast.fire({
                            type: response.data.status,
                            title: response.data.message
                        });
                    }).catch(errors => {
                        if (errors.response.status == 422) {
                            this.errors = errors.response.data.errors
                        }
                        Fire.$emit("Refresh");
                        toast({
                            type: 'warning',
                            title: 'Update failed'
                        });
                        this.form.reset()
                    })
                });
            }
        },
        created() {
            Fire.$on("Refresh", () => {

            });
        }
    }
</script>

<style scoped>

</style>
