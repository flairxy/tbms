<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Wallet</a>
            <span class="breadcrumb-item active">Deposit History</span>
        </nav>
        <div class="block">
            <div class="block-content">
                <table class="js-table-sections table table-hover js-table-sections-enabled">
                    <thead>
                    <tr>
                        <th style="width: 20px;"></th>
                        <th>Amount</th>
                        <th>Gateway</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody class="js-table-sections-header">
                    <tr v-for="(deposit, index) in deposits" :key="deposit.id">
                        <td class="text-center">{{index + 1}}</td>
                        <td class="font-size-sm text-success">+ ${{deposit.amount}}</td>
                        <td class="font-size-sm">{{deposit.currency2}}</td>
                        <td class="font-size-sm">
                            <span v-if="deposit.status == '0'" class="text-warning"><b>Pending</b></span>
                            <span v-else class="text-success"><b>Paid</b></span>
                        </td>
                        <td class="">
                            <span class="font-size-sm text-muted">{{deposit.created_at}}</span>
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
                deposits: []
            }
        },
        mounted() {
            UsersRepository.loggedInUser().then(response => {
                this.user = response.data;
                UsersRepository.userDeposits(response.data.id).then(response => {
                    this.deposits = response.data;
                })
            });
        }

    }
</script>
