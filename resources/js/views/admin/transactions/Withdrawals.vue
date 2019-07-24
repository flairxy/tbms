<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Withdrawal History</span>
        </nav>
        <div class="block">
            <div class="block-content block-content-full">
                <!-- DataTables functionality is initialized with .js-dataTable-simple class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                <div class="table-responsive">
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
                                            <strong>+ ${{withdrawal.net_amount}}</strong>
                                        </td>
                                        <td>
                                            {{withdrawal.gateway}}
                                        </td>
                                        <td>
                                        <span v-if="withdrawal.status == '1'"
                                              class="text-success"><b>Confirmed</b></span>
                                            <span v-else class="text-warning"><b>Pending</b></span>
                                        </td>

                                        <td>
                                            {{withdrawal.created_at}}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" @click.prevent="editModal(withdrawal)"
                                                    class="btn btn-sm btn-secondary js-tooltip-enabled">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button"
                                                    @click.prevent="deleteWithdrawal(withdrawal.id, withdrawal)"
                                                    class="btn btn-sm btn-secondary js-tooltip-enabled">
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
        <div class="modal fade" id="modal-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-fadein"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="card-title">Update Withdrawal Request</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Beginning of the form -->
                    <form @submit.prevent="updateWithdrawal">
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Amount</label>
                                        <input type="text" class="form-control" :value="form.net_amount" disabled
                                               id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <input v-model="form.id" type="hidden" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="charge">Hash</label>
                                        <input v-model="form.hash" type="text" class="form-control" id="charge"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" v-model="form.status">
                                            <option value="" selected disabled>PAYMENT STATUS</option>
                                            <option value="0">PENDING</option>
                                            <option value="1">PAID</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-lg btn-outline-info mb-2">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
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
                users: [],
                form: new Form({
                    id: '',
                    hash: '',
                    net_amount: '',
                    status: ''
                })
            }
        },
        methods: {
            editModal(withdraw) {
                this.form.reset();
                $('#modal-fadein').modal('show');
                this.form.fill(withdraw);
            },
            updateWithdrawal() {
                let data = {
                    hash: this.form.hash,
                    status: this.form.status,
                };
                UsersRepository.withdrawalUpdate(data, this.form.id).then(() => {
                    $('#modal-fadein').modal('hide');
                    Fire.$emit('Refresh');
                    toast.fire({
                        type: 'success',
                        title: 'Withdrawal updated successfully'
                    });
                }).catch(error => {
                    if(error.response.status == 403) {
                        toast.fire({
                            type: 'error',
                            title: 'Action Unauthorized'
                        });
                    }
                })
            },
            viewWithdrawals(params) {
                UsersRepository.fetchWithdrawals(params).then(response => {
                    this.withdrawals = response.data.data;
                })
            },
            deleteWithdrawal(id, withdraw) {
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
                        UsersRepository.withdrawalDelete(id).then(response => {
                            const withdrawalIndex = this.withdrawals.findIndex(p => p.id === withdraw.id);
                            this.withdrawals.splice(withdrawalIndex, 1);
                            swal.fire(
                                'Deleted!',
                                response.data.message,
                                response.data.status
                            );
                        }).catch(error => {
                            if(error.response.status == 403) {
                                toast.fire({
                                    type: 'error',
                                    title: 'Action Unauthorized'
                                });
                            }
                            swal("Failed!", "There was something wrong.", "warning");
                        });
                    }
                })
            },

        },
        created() {
            this.viewWithdrawals();
            Fire.$on('Refresh', () => {
                this.viewWithdrawals();
            });
        },
        mounted() {
            UsersRepository.fetchUsers().then(response => {
                this.users = response.data;
            })
        }

    }
</script>
