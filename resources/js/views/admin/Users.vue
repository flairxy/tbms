<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Users</span>
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

                                    <th class="d-none d-sm-table-cell sorting">Username
                                    </th>
                                    <th class="d-none d-sm-table-cell">Email
                                    </th>
                                    <th class="d-none d-sm-table-cell">Balance
                                    </th>
                                    <th class="d-none d-sm-table-cell sorting">Status
                                    </th>
                                    <th class="d-none d-sm-table-cell sorting">Joined
                                    </th>
                                    <th class="text-center" style="width: 15%;" rowspan="1" colspan="1">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>


                                <tr role="row" class="odd" v-for="(user, index) in users">
                                    <td class="text-center sorting_1">
                                        {{index + 1}}
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        {{user.username}}
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        {{user.email}}
                                    </td>
                                    <td>
                                        <span v-for="account in accounts" :key="account.id">
                                            <span v-if="account.user_id === user.id">${{account.bky}}</span>
                                        </span>
                                    </td>
                                    <td>
                                        <span v-if="user.ban == '0'" class="text-success"><b>Active</b></span>
                                        <span v-else class="text-warning"><b>Banned</b></span>
                                    </td>

                                    <td>
                                        {{user.created_at}}
                                    </td>
                                    <td class="text-center">
                                        <button type="button" @click.prevent="editModal(user)"
                                                class="btn btn-sm btn-secondary js-tooltip-enabled">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled"
                                                @click.prevent="deleteUser(user.id, user)">
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
        <div class="modal fade" id="modal-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-fadein"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="card-title">Update User Status</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Beginning of the form -->
                    <form @submit.prevent="updateUser">
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Username</label>
                                        <input type="text" class="form-control" :value="form.username" disabled
                                               id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" :value="form.email" disabled
                                               id="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" required v-model="form.ban">
                                            <option value="" selected disabled>PAYMENT STATUS</option>
                                            <option value="0">Activate</option>
                                            <option value="1">Ban</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input v-model="form.id" type="hidden" class="form-control" required>
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
    import {RepositoryFactory} from '../../repository/RepositoryFactory'

    const UsersRepository = RepositoryFactory.get('users');
    export default {
        data() {
            return {
                accounts:[],
                users:[],
                form: new Form({
                    id: '',
                    username: '',
                    email: '',
                    ban: ''
                })
            }
        },
        methods: {
            updateUser() {
                let data = {
                    status: this.form.ban
                };
                UsersRepository.userStatusUpdate(data, this.form.id).then(() => {
                    $('#modal-fadein').modal('hide');
                    Fire.$emit('Refresh');
                    toast.fire({
                        type: 'success',
                        title: 'Status updated successfully'
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
            editModal(user) {
                this.form.reset();
                $('#modal-fadein').modal('show');
                this.form.fill(user);
            },
            getUsers() {
                UsersRepository.fetchUsers().then(response => {
                    this.users = response.data;
                })
            },
            getBalances() {
                UsersRepository.getAccounts().then(response => {
                    this.accounts = response.data;
                })
            },
            deleteUser(id, user) {
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
                        UsersRepository.userDelete(id).then(response => {
                            const userIndex = this.users.findIndex(p => p.id === user.id);
                            this.users.splice(userIndex, 1);
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
            this.getUsers();
            this.getBalances();
            Fire.$on('Refresh', () => {
                this.getUsers();
                this.getBalances();            });
        }

    }
</script>
