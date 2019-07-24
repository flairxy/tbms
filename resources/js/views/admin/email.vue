<template>
	<div>
        <div class="block-content bg-body-light">
            <form @submit.prevent="sendEmail">
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <label>To: ( example. user@mail.com. leave blank if message is for every user)</label>
                            <input type="email" class="form-control" v-model="form.email">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material floating">
                            <input type="text" class="form-control" required id="material-text2" v-model="form.subject">
                            <label for="material-text2">Subject</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <div class="form-material floating">
                            <textarea class="form-control" required id="material-textarea-large2" v-model="form.body" rows="8"></textarea>
                            <label for="material-textarea-large2">Body</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div v-if="processing" class="col-6 col-md-3">
                        <i class="fa fa-2x fa-cog fa-spin text-primary"></i>
                    </div>
                    <div class="col-md-9" v-else>
                        <button type="submit" class="btn btn-alt-primary">Send</button>
                    </div>
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
                processing: false,
                form: new Form({
                    id: '',
                    subject: '',
                    body: '',
                    email: '',
                })
            }
        },
        methods: {
            sendEmail() {
                this.processing = true;
                let data = {
                    subject: this.form.subject,
                    body: this.form.body,
                    email: this.form.email,
                };
                UsersRepository.sendEmails(data).then(response => {
                    toast.fire({
                        type: 'success',
                        title: 'Email sent to users'
                    });
                    this.processing = false;
                }).catch(error => {
                    if(error.response.status == 403) {
                        toast.fire({
                            type: 'error',
                            title: 'Action Unauthorized'
                        });
                        this.processing = false;
                    }else
                    toast.fire({
                        type: 'error',
                        title: 'Error!. Failed to send email'
                    });
                    this.processing = false;
                })

            }
        }
    }
</script>

<style scoped>

</style>
