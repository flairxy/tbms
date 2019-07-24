<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Overview</span>
        </nav>

        <div class="row gutters-tiny">
            <div class="col-md-6">
                <!-- Modern on Background Color -->
                <div class="block">
                    <div class="block-content block-content-full ribbon ribbon-left ribbon-bookmark ribbon-warning">
                        <div class="ribbon-box" v-if="pendingDeposits">{{pendingDeposits}} Pending</div>
                        <div class="py-20 text-center">
                            <div class="mb-20">
                                <i class="si si-wallet fa-4x text-success"></i>
                            </div>
                            <div class="font-size-h3 font-w600" v-if="deposits">${{deposits}}</div>
                            <div class="font-size-h3 font-w600" v-else>$0.00</div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Deposits</div>
                        </div>
                    </div>
                </div>
                <!-- END Modern on Background Color -->
            </div>
            <div class="col-md-6">
                <!-- Modern on Background Color -->
                <div class="block">
                    <div class="block-content block-content-full ribbon ribbon-left ribbon-bookmark ribbon-warning">
                        <div class="ribbon-box" v-if="pendingWithdrawals">{{pendingWithdrawals}} Pending</div>
                        <div class="py-20 text-center">
                            <div class="mb-20">
                                <i class="si si-wallet fa-4x text-danger"></i>
                            </div>
                            <div class="font-size-h3 font-w600" v-if="withdrawals">${{withdrawals}}</div>
                            <div class="font-size-h3 font-w600" v-else>$0.00</div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Withdrawals</div>
                        </div>
                    </div>
                </div>
                <!-- END Modern on Background Color -->
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="py-20 text-center">
                            <div class="mb-20">
                                <i class="si si-users fa-4x text-info"></i>
                            </div>
                            <div class="font-size-h3 font-w600" v-if="users">{{users}}</div>
                            <div class="font-size-h3 font-w600" v-else>0</div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Users</div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END Row #2 -->
        </div>
    </div>
</template>

<script>
    import {RepositoryFactory} from '../../repository/RepositoryFactory'

    const UsersRepository = RepositoryFactory.get('users');
    export default {
        data() {
            return {
                deposits: '',
                withdrawals: '',
                users: '',
                pendingDeposits: '',
                pendingWithdrawals: '',
            }
        },
        mounted() {
            UsersRepository.totalDeposits().then(response => {
                this.deposits = response.data;
            });
            UsersRepository.totalWithdrawals().then(response => {
                this.withdrawals = response.data;
            });
            UsersRepository.totalUsers().then(response => {
                this.users = response.data;
            });
            UsersRepository.totalPendingDeposits().then(response => {
                this.pendingDeposits = response.data;
            });
            UsersRepository.totalPendingWithdrawals().then(response => {
                this.pendingWithdrawals = response.data;
            });
        }
    }
</script>
