<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Withdrawal History</span>
        </nav>
        <div class="block">
            <div class="block-content block-content-full">
                <!-- DataTables functionality is initialized with .js-dataTable-simple class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table
                                class="table table-bordered table-striped table-vcenter js-dataTable-simple dataTable no-footer"
                                id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="text-center" tabindex="0">
                                        #
                                    </th>

                                    <th class="d-none d-sm-table-cell sorting">Email
                                    </th>
                                    <th class="d-none d-sm-table-cell">Amount
                                    </th>
                                    <th class="d-none d-sm-table-cell sorting">Gateway
                                    </th>
                                    <th class="d-none d-sm-table-cell sorting">Status
                                    </th>
                                    <th class="d-none d-sm-table-cell sorting">Date
                                    </th>
                                    <th class="text-center" style="width: 15%;" rowspan="1" colspan="1">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>


                                <tr role="row" class="odd" v-for="(withdrawal, index) in withdrawals">
                                    <td class="text-center sorting_1">
                                        {{index + 1}}
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <span v-for="user in users" :key="user.id">
                                        <span v-if="user.id === withdrawal.user_id">{{user.email}}</span>
                                        </span>
                                    </td>
                                    <td class="d-none d-sm-table-cell text-success">
                                        <strong>+ ${{withdrawal.amount}}</strong>
                                    </td>
                                    <td>
                                        {{withdrawal.currency2}}
                                    </td>
                                    <td>
                                        <span v-if="withdrawal.status == '1'" class="text-success"><b>Confirmed</b></span>
                                        <span v-else class="text-warning"><b>Pending</b></span>
                                    </td>

                                    <td>
                                        {{withdrawal.created_at}}
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
                search: '',
                queryParams: {
                    type: null
                },
                withdrawals: [],
                users: []
            }
        },
        methods: {
            viewWithdrawals(params) {
                UsersRepository.fetchWithdrawals(params).then(response => {
                    this.withdrawals = response.data.data;
                })
            }
        },
        created() {
            this.viewWithdrawals();
        },
        mounted() {
            UsersRepository.fetchUsers().then(response => {
                this.users = response.data;
            })

        }

    }
</script>
