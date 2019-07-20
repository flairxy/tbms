<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Wallet</a>
            <span class="breadcrumb-item active">Overview</span>
        </nav>
        <div class="block-content block-content-full">

            <button type="button" class="btn btn-outline-info mr-5 mb-5" @click.prevent="depositModal">
                <i class="fa fa-download mr-5"></i> Receive
            </button>
            <button type="button" class="btn btn-outline-danger mr-5 mb-5" @click.prevent="withdrawModal">
                <i class="fa fa-send-o mr-5"></i> Send
            </button>
            <button type="button" class="btn btn-success mr-5 mb-5" @click.prevent="exchangeModal">
                <i class="fa fa-exchange mr-5"></i> Exchange
            </button>
        </div>
        <div class="row" v-if="redirect">
            <div class="col-md-4"></div>
            <div class="col-4 col-md-4">
                <div id="page-loader" class="show bg-gd-default"></div>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row" v-else>
            <div class="col-sm-6 col-xl-4">
                <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-right mt-15 d-none d-sm-block">
                            <i class="si si-wallet fa-2x text-earth-light"></i>
                        </div>
                        <div class="font-size-h3 font-w600 text-earth">
                            <span data-toggle="countTo" data-speed="1000"
                                  class="js-count-to-enabled"> ${{accounts.btc}} BTC
                        </span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-4">
                <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-right mt-15 d-none d-sm-block">
                            <i class="si si-wallet fa-2x text-earth-light"></i>
                        </div>
                        <div class="font-size-h3 font-w600 text-earth">
                            <span data-toggle="countTo" data-speed="1000"
                                  class="js-count-to-enabled"> ${{accounts.eth}} ETH
                        </span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-xl-4">
                <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-right mt-15 d-none d-sm-block">
                            <i class="si si-wallet fa-2x text-earth-light"></i>
                        </div>
                        <div class="font-size-h3 font-w600 text-earth">
                            <span data-toggle="countTo" data-speed="1000"
                                  class="js-count-to-enabled"> {{accounts.bky2}} BKY
                        </span>
                        </div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">${{accounts.bky}}</div>
                    </div>
                </a>
            </div>
        </div>
        <div class="modal fade" id="modal-popin" tabindex="-1" role="dialog" aria-labelledby="modal-popin"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popin" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 v-if="!withdraw" class="block-title">Deposit Funds</h3>
                            <h3 v-else class="block-title">Withdraw Funds</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal"
                                        aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div v-if="!withdraw" class="block-content">
                            <form @submit.prevent="depositFund(user.id, user)">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-material">
                                            <select type="text" class="form-control" id="wallet" v-model="form.gateway"
                                                    name="old_password">
                                                <option value="" selected disabled>Choose Wallet</option>
                                                <option v-for="gateway in gateways" :value="gateway.id">
                                                    {{gateway.name}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <input type="number" class="form-control" id="amount"
                                                   v-model="form.amount" name="old_password"/>
                                            <label for="amount">Amount</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-material">
                                            <div v-if="processing" class="col-6 col-md-3">
                                                <i class="fa fa-2x fa-cog fa-spin text-success"></i>
                                            </div>
                                            <button type="submit" v-else
                                                    class="btn btn-outline-success min-width-125 mb-10">
                                                Deposit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div v-else class="block-content">
                            <form @submit.prevent="withdrawFund(user.id)">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-material">
                                            <select class="form-control"
                                                    v-model="form.gateway" id="type" name="old_password">
                                                <option value="" selected disabled>Choose Wallet</option>
                                                <option v-for="gateway in gateways" :value="gateway.id">
                                                    {{gateway.name}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <input type="number" class="form-control" v-model="form.amount">
                                            <label>Amount</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <input type="text" class="form-control" v-model="form.address">
                                            <label>Address</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div v-if="processing" class="col-6 col-md-3">
                                            <i class="fa fa-2x fa-cog fa-spin text-danger"></i>
                                        </div>
                                        <button type="submit" v-else
                                                class="btn btn-outline-danger min-width-125 mb-10">
                                            withdraw
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-pop" tabindex="-1" role="dialog" aria-labelledby="modal-popin"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popin" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Exchange Funds</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal"
                                        aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <form @submit.prevent="exchangeFund(user.id, user)">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-material">
                                            <label> Convert From: </label>
                                            <select type="text" class="form-control" v-model="form.old"
                                                    name="old_password">
                                                <option value="" selected disabled>Choose Wallet</option>
                                                <option value="BTC">
                                                    BITCOIN
                                                </option>
                                                <option value="ETH">
                                                    ETHEREUM
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <label> Convert To: </label>
                                            <select type="text" class="form-control" v-model="form.new"
                                                    name="old_password">
                                                <option value="" selected disabled>Choose Wallet</option>
                                                <option value="BKY" selected>BLUEKEY</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <input type="number" class="form-control"
                                                   v-model="form.amount"/>
                                            <label for="amount">Amount</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <label for="amount">Estimated BKY value</label>
                                            <input type="number" DISABLED
                                                   :value="form.amount / rate"/> BKY
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-material">
                                            <div v-if="processing" class="col-6 col-md-3">
                                                <i class="fa fa-2x fa-cog fa-spin text-success"></i>
                                            </div>
                                            <button type="submit" v-else
                                                    class="btn btn-outline-success min-width-125 mb-10">
                                                Exchange
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import {RepositoryFactory} from '../../../repository/RepositoryFactory'

    const UsersRepository = RepositoryFactory.get('users');
    export default {
        data() {
            return {
                processing: false,
                rate: '',
                user: '',
                gateways: [],
                accounts: [],
                address: '',
                withdraw: false,
                form: new Form({
                    gateway: '',
                    amount: '',
                    address: '',
                    new: '',
                    old: '',
                }),
                redirect: false
            }
        },
        methods: {
            copy() {
                if (this.address) {
                    this.$copyText(this.address).then(function (e) {
                        $(".hover-tooltip a").tooltip('show');
                        setTimeout(function () {
                            $(".hover-tooltip a").tooltip('hide');
                        }, 3000);
                    })
                }
            },
            withdrawModal() {
                this.withdraw = true;
                this.form.reset();
                $("#modal-popin").modal('show');
            },
            exchangeModal() {
                this.form.reset();
                UsersRepository.viewRate().then(response => {
                    this.rate = response.data;
                });
                $("#modal-pop").modal('show');
            },
            depositModal() {
                this.form.reset();
                this.withdraw = false;
                $("#modal-popin").modal('show');
            },
            withdrawFund(id) {
                this.processing = true;
                let data = {
                    user: id,
                    amount: this.form.amount,
                    gateway: this.form.gateway,
                    address: this.form.address
                };
                UsersRepository.userWithdrawal(data).then(response => {
                    $("#modal-popin").modal('hide');
                    toast.fire({
                        type: response.data.status,
                        title: response.data.message
                    });
                    Fire.$emit('Refresh');
                    this.processing = false;

                }).catch(err => {
                    this.processing = false;
                    toast.fire({
                        type: 'error',
                        title: 'Error initiating withdrawal. Check provided information'
                    });
                })
            },
            exchangeFund(id) {
                this.processing = true;
                let data = {
                    user: id,
                    old: this.form.old,
                    new: this.form.new,
                    amount: this.form.amount,
                };
                UsersRepository.fundExchange(data).then(response => {
                    $("#modal-pop").modal('hide');
                    toast.fire({
                        type: response.data.status,
                        title: response.data.message
                    });
                    Fire.$emit('Refresh');
                    this.processing = false;

                }).catch(err => {
                    this.processing = false;
                    toast.fire({
                        type: 'error',
                        title: 'Error initiating exchange. Check provided information'
                    });
                })
            },
            depositFund(id) {
                this.processing = true;
                let data = {
                    user: id,
                    amount: this.form.amount,
                    gateway: this.form.gateway,
                };
                UsersRepository.userDeposit(data).then(response => {
                    $("#modal-popin").modal('hide');
                    toast.fire({
                        type: 'info',
                        title: 'Redirecting to payment page'
                    });
                    this.redirect = true;
                    window.location = response.data.data;
                    this.processing = false;

                }).catch(err => {
                    this.processing = false;
                    toast.fire({
                        type: 'error',
                        title: 'Error initiating deposit. Check provided information'
                    });
                })
            },
            userAccounts() {
                UsersRepository.loggedInUser().then(response => {
                    this.user = response.data;
                    UsersRepository.viewAccounts(response.data.id).then(response => {
                        this.accounts = response.data;
                    })
                });
            },
        },
        mounted() {
            UsersRepository.viewGateways().then(response => {
                this.gateways = response.data;
            });
        },
        created() {
            this.userAccounts();
            Fire.$on('Refresh', () => {
                this.userAccounts();
            });
        },
    }
</script>
