<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Wallet</a>
            <span class="breadcrumb-item active">Withdrawal History</span>
        </nav>
        <div class="block">
            <div class="block-content">
                <table class="js-table-sections table table-hover js-table-sections-enabled">
                    <thead>
                    <tr>
                        <th style="width: 20px;"></th>
                        <th>Amount</th>
                        <th>Address</th>
                        <th>Gateway</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody class="js-table-sections-header">
                    <tr v-for="(withdrawal, index) in withdrawals" :key="withdrawal.id">
                        <td class="text-center">{{index + 1}}</td>
                        <td class="font-size-sm text-danger">- ${{withdrawal.net_amount}}</td>
                        <td class="font-size-sm">{{withdrawal.address}}</td>
                        <td class="font-size-sm">{{withdrawal.gateway}}</td>
                        <td class="font-size-sm">
                            <span v-if="withdrawal.status == '0'" class="text-warning"><b>Pending</b></span>
                            <span v-else class="text-success"><b>Paid</b></span>
                        </td>
                        <td class="">
                            <span class="font-size-sm text-muted">{{withdrawal.created_at}}</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
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
                withdrawals: []
            }
        },
        mounted() {
            UsersRepository.loggedInUser().then(response => {
                this.user = response.data;
                UsersRepository.userWithdrawals(response.data.id).then(response => {
                    this.withdrawals = response.data;
                })
            });
        }

    }
</script>
