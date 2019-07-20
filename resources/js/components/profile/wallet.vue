<template>
    <div class="col-md-8">
        <div class="block-content">
            <form action="" method="post" onsubmit="return false;">
                <div class="form-group">
                    <div class="form-material">
                        <select type="text" class="form-control" id="wallet" name="old_password">
                            <option value="" selected disabled>Choose Wallet</option>
                            <option value="btc">Bitcoin</option>
                            <option value="eth">Eherium</option>
                            <option value="bky">BKY</option>
                        </select>
                        <label for="wallet">Personal Wallet</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="password" class="form-control" id="address" name="material-text">
                        <label for="address">Address</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-lg btn-rounded btn-outline-info min-width-125 mb-10">Update wallet</button>
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
