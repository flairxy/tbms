<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Investment</span>
        </nav>
        <div class="block-content block-content-full">

            <button type="button" class="btn bg-gd-default text-white mr-5 mb-5" @click.prevent="InvestModal">
                <i class="fa fa-plus mr-5"></i> Add Investment
            </button>
        </div>
        <div class="block">
            <div class="block-content">
                <div class="table-responsive">
                    <table class="js-table-sections table table-hover js-table-sections-enabled"
                           v-if="investments.length > 0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Amount</th>
                            <th>Plan</th>
                            <th>Gateway</th>
                            <th>Status</th>
                            <th>Starts</th>
                            <th>Ends</th>
                        </tr>
                        </thead>
                        <tbody class="js-table-sections-header">
                        <tr v-for="(investment, index) in investments" :key="investment.id">
                            <td class="text-center">{{index + 1}}</td>
                            <td class="font-size-sm">${{investment.amount}}</td>
                            <td class="font-size-sm">{{investment.plan}}</td>
                            <td class="font-size-sm">{{investment.gateway}}</td>
                            <td class="font-size-sm">
                                <span v-if="investment.status == '0'" class="text-warning"><b>Running</b></span>
                                <span v-else class="text-success"><b>Completed</b></span>
                            </td>
                            <td class="">
                                <span class="font-size-sm text-muted">{{investment.start}}</span>
                            </td>
                            <td class="">
                                <span class="font-size-sm text-muted">{{investment.end}}</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <h1 v-else class="text-muted"> You have no investment history</h1>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-popin" tabindex="-1" role="dialog" aria-labelledby="modal-popin"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popin" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-flat-darker">
                            <h3 class="block-title">Invest Funds</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal"
                                        aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <form @submit.prevent="investFund(user.id)">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-material">
                                            <select type="text" class="form-control" id="wallet" v-model="form.gateway"
                                                    name="old_password">
                                                <option value="" selected disabled>Choose Wallet</option>
                                                <option value="BKY">
                                                    BKY
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <select type="text" @change="getPlan" class="form-control" id="plan"
                                                    v-model="form.plan"
                                                    name="old_password">
                                                <option value="" selected disabled>Choose Plan</option>
                                                <option v-for="plan in plans" :value="plan.id">
                                                    {{plan.name}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <input type="number" class="form-control" id="amount"
                                                   v-model="form.amount" name="old_password"/>
                                            <label for="amount">Amount (dollars)</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-material">
                                            <label for="amount">Estimated Return</label>
                                            <span class="text-primary">
                                                   <b>${{form.amount * (rate.percentage / 100)}} </b><span v-if="rate">{{style}} For {{rate.duration}} Weeks</span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-material">
                                            <div v-if="processing" class="col-6 col-md-3">
                                                <i class="fa fa-2x fa-cog fa-spin text-primary"></i>
                                            </div>
                                            <button v-else type="submit"
                                                    class="btn btn-outline-primary mb-10">
                                                Invest
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
                investments: [],
                processing: false,
                user: '',
                style: '',
                rate: '',
                rateVal: false,
                plans: [],
                gateways: [],
                form: new Form({
                    gateway: '',
                    amount: '',
                    plan: '',
                    user: ''
                }),
            }
        },
        methods: {
            getPlan(event) {
                this.rateVal = true;
                let planId = event.target.value;
                UsersRepository.editHedgePlan(planId).then(response => {
                    this.rate = response.data;
                    let plan = response.data;
                    UsersRepository.viewStyles().then(response => {
                        let styles = response.data;
                        for (let x in styles) {
                            if (styles[x].id === plan.style_id) {
                                this.style = styles[x].name;
                            }
                        }

                    })
                })
            },
            InvestModal() {
                UsersRepository.viewHedgePlans().then(response => {
                    this.plans = response.data;
                });
                UsersRepository.viewGateways().then(response => {
                    this.gateways = response.data;
                });
                this.form.reset();
                $("#modal-popin").modal('show');
            },
            investFund(id) {
                this.processing = true;
                let data = {
                    user: id,
                    amount: this.form.amount,
                    gateway: this.form.gateway,
                    plan: this.form.plan
                };
                UsersRepository.userInvest(data).then(response => {
                    this.investments = response.data;
                    $("#modal-popin").modal('hide');
                    this.processing = false;
                    Fire.$emit('Refresh');
                    toast.fire({
                        type: response.data.status,
                        title: response.data.message
                    });
                }).catch(err => {
                    this.processing = false;
                    toast.fire({
                        type: 'error',
                        title: 'Error!. Check provided information'
                    });
                })
            },
            loadInvestments() {
                UsersRepository.loggedInUser().then(response => {
                    this.user = response.data;
                    UsersRepository.userInvestments(response.data.id).then(response => {
                        this.investments = response.data;
                    });
                });
            }
        },

        created() {
            this.loadInvestments();
            Fire.$on('Refresh', () => {
                this.loadInvestments();
            });
        }

    }
</script>
