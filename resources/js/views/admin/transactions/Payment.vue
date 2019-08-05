<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Rides</span>
        </nav>
        <div class="block">
            <div class="block-content">
                <div class="table-responsive" v-if="payments.length > 0">
                    <table class="js-table-sections table table-hover js-table-sections-enabled">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Transaction ID</th>
                            <th>Amount</th>
                            <th>Driver No</th>
                            <th>Rider</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody class="js-table-sections-header">
                        <tr v-for="(payment, index) in payments" :key="payment.id">
                            <td class="text-center">{{index + 1}}</td>
                            <td class="font-size-sm">{{payment.transaction_id}}</td>
                            <td class="font-size-sm">N{{payment.amount}}</td>
                            <td class="font-size-sm">
                                <span v-for="driver in drivers" :key="driver.id">
                                    <span v-if="driver.id === payment.driver_id">{{driver.registration_no}}</span>
                                </span>
                            </td>
                            <td class="font-size-sm">
                                <span v-for="user in users" :key="user.id">
                                    <span v-if="user.id == payment.rider_id">{{user.name}}</span>
                                </span>
                            </td>
                            <td class="font-size-sm">
                                <span v-if="payment.status == '0'" class="text-warning"><b>Pending</b></span>
                                <span v-else-if="payment.status == '1'" class="text-success"><b>Completed</b></span>
                                <span v-else class="text-danger"><b>Cancelled</b></span>
                            </td>
                            <td class="font-size-sm">{{payment.created_at}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else>
                    <h3 class="text-muted">There are no payment history</h3>
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
                payments: [],
                users: [],
                user: '',
                payment_id: '',
                driver_id: '',
                rating: 0,
            }
        },
        methods: {
            history() {
                axios.get(`/api/admin/rides/transactions`).then(response => {
                    this.payments = response.data.payments;
                    this.users = response.data.users;
                    this.drivers = response.data.drivers;
                });
            }
        },
        created() {
            this.history();
            Fire.$on("Refresh", () => {
                this.history();
            });
        }

    }
</script>
