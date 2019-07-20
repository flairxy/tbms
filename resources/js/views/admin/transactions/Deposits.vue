<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Deposit History</span>
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


                                <tr role="row" class="odd" v-for="(deposit, index) in deposits">
                                    <td class="text-center sorting_1">
                                        {{index + 1}}
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <span v-for="user in users" :key="user.id">
                                        <span v-if="user.id === deposit.user_id">{{user.email}}</span>
                                        </span>
                                    </td>
                                    <td class="d-none d-sm-table-cell text-success">
                                        <strong>+ ${{deposit.amount}}</strong>
                                    </td>
                                    <td>
                                        {{deposit.currency2}}
                                    </td>
                                    <td>
                                        <span v-if="deposit.status == '1'" class="text-success"><b>Confirmed</b></span>
                                        <span v-else class="text-warning"><b>Pending</b></span>
                                    </td>

                                    <td>
                                        {{deposit.created_at}}
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled"
                                                @click.prevent="deleteDeposit(deposit.id, deposit)">
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
                deposits: [],
                users: []
            }
        },
        methods: {
            viewDeposits(params) {
                UsersRepository.fetchDeposits(params).then(response => {
                    this.deposits = response.data.data;
                })
            },
            deleteDeposit(id, deposit) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    // Send request to the server
                    if (result.value) {
                        UsersRepository.depositDelete(id).then(response => {
                            const depositIndex = this.deposits.findIndex(p => p.id === deposit.id);
                            this.deposits.splice(depositIndex, 1);
                            swal.fire(
                                'Deleted!',
                                response.data.message,
                                response.data.status
                            );
                        }).catch(() => {
                            swal("Failed!", "There was something wrong.", "warning");
                        });
                    }
                })
            },
        },
        created() {
            this.viewDeposits();
        },
        mounted() {
            UsersRepository.fetchUsers().then(response => {
                this.users = response.data;
            })

        }
    }
</script>
