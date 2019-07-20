<template>
	<div class="col-md-8">
        <div class="block-content">
            <form action="" method="post" @submit.prevent="sendCode">
                <div class="form-group">
                    <div class="">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" disabled :value="username" id="username">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                    <input type="email" class="form-control" :value="email" id="email" name="material-text">
                    <label for="email">Email</label>
                </div>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-lg btn-rounded btn-outline-info min-width-125 mb-10">Update</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            username: String,
            email: String,
        },
       data() {
           return {
               user: ''
           }
       },
        methods: {
           sendCode() {

           },

        },
    }
</script>

<style scoped>

</style>
