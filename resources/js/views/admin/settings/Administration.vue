<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Administrators</span>
        </nav>
        <div class="block-content block-content-full">

            <button type="button" class="btn bg-gd-default text-white mr-5 mb-5" @click.prevent="adminModal">
                <i class="fa fa-plus mr-5"></i> Add Admin
            </button>
        </div>
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
                        <h3 class="card-title">Update Admin Role</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Beginning of the form -->
                    <form @submit.prevent="updateUserAdmin">
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
                                        <div class="form-material">
                                            <label>Current Role</label>
                                            <input type="text" class="form-control" :value="adminRole" disabled required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Update Role</label>
                                        <select class="form-control" v-model="form.admin_role">
                                            <option v-for="role in roles" :key="role.id" :value="role.id">
                                                {{role.slug}}
                                            </option>
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
        <div class="modal fade" id="modal-popin" tabindex="-1" role="dialog" aria-labelledby="modal-popin"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popin" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-flat-darker">
                            <h3 class="block-title">New Admin</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal"
                                        aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <form @submit.prevent="newAdmin">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-material">
                                            <input type="text" class="form-control"
                                                   v-model="form.username" name="old_password"/>
                                            <label>Username</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <input type="email" class="form-control"
                                                   v-model="form.email" name="old_password"/>
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <input type="password" class="form-control"
                                                   v-model="form.password"/>
                                            <label>Password</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <input type="password" class="form-control"
                                                   v-model="form.password_confirmation"/>
                                            <label>Confirm Password</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-material">
                                            <select type="text" class="form-control" id="wallet" v-model="form.admin_role"
                                                    name="old_password">
                                                <option value="" selected disabled>Select Role</option>
                                                <option v-for="role in roles" :key="role.id" :value="role.id">
                                                    {{role.slug}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <div v-if="processing" class="col-6 col-md-3">
                                                <i class="fa fa-2x fa-cog fa-spin text-primary"></i>
                                            </div>
                                            <button v-else type="submit"
                                                    class="btn btn-outline-primary mb-10">
                                                Create
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
                processing: false,
                accounts: [],
                users: [],
                roles: [],
                adminRole: '',
                form: new Form({
                    id: '',
                    username: '',
                    email: '',
                    ban: '',
                    password: '',
                    password_confirmation: '',
                    admin_role: ''
                })
            }
        },
        methods: {
            newAdmin() {
                this.processing = true;
                let data = {
                    email: this.form.email,
                    password: this.form.password,
                    password_confirmation: this.form.password_confirmation,
                    username: this.form.username,
                    role: this.form.admin_role
                };
                UsersRepository.userRegistration(data).then(() => {
                    Fire.$emit('Refresh');
                    $("#modal-popin").modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Role updated successfully'
                    });
                    this.processing = false;
                }).catch(error => {
                    $("#modal-popin").modal('hide');
                    // console.log(error.code)
                    if(error.response.status == 403) {
                        toast.fire({
                            type: 'error',
                            title: 'Action Unauthorized'
                        });
                    }
                })
            },
            adminModal() {
                this.form.reset();
                $("#modal-popin").modal('show');
            },
            updateUserAdmin() {
                this.processing = true;
                let data = {
                    role: this.form.admin_role
                };
                UsersRepository.userAdminStatusUpdate(data, this.form.id).then(() => {
                    $('#modal-fadein').modal('hide');
                    Fire.$emit('Refresh');
                    toast.fire({
                        type: 'success',
                        title: 'Status updated successfully'
                    });
                    this.processing = false;
                }).catch(error => {
                    $("#modal-fadein").modal('hide');
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
                UsersRepository.fetchAdminRoles(user.id).then(response => {
                    this.adminRole = response.data;
                })
            },
            getUsers() {
                UsersRepository.fetchAdminUsers().then(response => {
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
            getRoles() {
                UsersRepository.fetchUserRoles().then(response => {
                    this.roles = response.data;
                })
            },

        },
        created() {
            this.getRoles();
            // this.getAdminRoles();
            this.getUsers();
            this.getBalances();
            Fire.$on('Refresh', () => {
                this.getUsers();
                this.getBalances();
            });
        },
    }
</script>
