<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Deposit History</span>
        </nav>
        <div class="block">
            <div class="block-content block-content-full">
                <div class="table-responsive">
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
                                            <span v-if="deposit.status == '1'"
                                                  class="text-success"><b>Confirmed</b></span>
                                            <span v-else class="text-warning"><b>Pending</b></span>
                                        </td>

                                        <td>
                                            {{deposit.created_at}}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" @click.prevent="editModal(deposit)"
                                                    class="btn btn-sm btn-secondary js-tooltip-enabled">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled"
                                                    @click.prevent="deleteDeposit(deposit.id, deposit)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <pagination :data="deposits" @pagination-change-page="viewDeposits">
                                        <span slot="prev-nav">&lt; Previous</span>
                                        <span slot="next-nav">Next &gt;</span>
                                    </pagination>
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
                        <h3 class="card-title">Update Deposit Request</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Beginning of the form -->
                    <form @submit.prevent="updateDeposit">
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
                                        <label>Status</label>
                                        <select class="form-control" v-model="form.status" required>
                                            <option value="2" selected disabled>PAYMENT STATUS</option>
                                            <option value="1">CONFIRM</option>
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
                deposits: [],
                users: [],
                form: new Form({
                    id: '',
                    user_id: '',
                    net_amount: '',
                    status: '',
                    gateway_id: ''
                })
            }
        },
        methods: {
            editModal(deposit) {
                this.form.reset();
                $('#modal-fadein').modal('show');
                this.form.fill(deposit);
            },
            updateDeposit() {
                let data = {
                    status: this.form.status,
                    user: this.form.user_id,
                    gateway: this.form.gateway_id,
                    amount: this.form.gateway_id,
                };
                UsersRepository.depositUpdate(data, this.form.id).then(() => {
                    $('#modal-fadein').modal('hide');
                    Fire.$emit('Refresh');
                    toast.fire({
                        type: 'success',
                        title: 'Deposit updated successfully'
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
            viewDeposits(page = 1) {
                UsersRepository.fetchDeposits(page).then(response => {
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
            this.viewDeposits();
            Fire.$on('Refresh', () => {
                this.viewDeposits();
            });
        },
        mounted() {
            UsersRepository.fetchUsers().then(response => {
                this.users = response.data;
            })

        }
    }
</script>
