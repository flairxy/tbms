<template>
	<div class="col-md-8">
        <div class="block-content">
            <form action="" method="post" onsubmit="return false;">
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="old_password" name="old_password">
                        <label for="old_password">Old Password</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="password" class="form-control" id="password" name="password">
                        <label for="password">New Password</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm">
                        <label for="password_confirm">password_confirm</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-lg btn-rounded btn-outline-info min-width-125 mb-10">Update password</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "wallet"
    }
</script>

<style scoped>

</style>
