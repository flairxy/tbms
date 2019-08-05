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
                        <div class="col-sm-12 col-md-6">
                            <div id="DataTables_Table_1_filter" class="dataTables_filter">
                                <label>
                                    Search:
                                    <input
                                        type="search"
                                        class="form-control form-control-sm"
                                        placeholder="Enter registration number"
                                        aria-controls="DataTables_Table_1"
                                        v-model="search"
                                    />
                                </label>
                            </div>
                        </div>
                    </div>
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
                                    <th class="d-none d-sm-table-cell">Registration NO
                                    </th>
                                    <th class="d-none d-sm-table-cell">Rating
                                    </th>
                                    <th class="d-none d-sm-table-cell">Car Type
                                    </th>
                                    <th class="d-none d-sm-table-cell">Licence Expires_at
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


                                <tr role="row" class="odd" v-for="(driver, index) in filteredDrivers">
                                    <td class="text-center sorting_1">
                                        {{index + 1}}
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        {{driver.registration_no}}
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        {{driver.rating}}
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <span v-if="driver.car_type">{{driver.car_type}}</span>
                                        <span v-else>N/A</span>
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <span v-if="driver.licence_expiry">{{driver.licence_expiry}}</span>
                                        <span v-else>N/A</span>
                                    </td>
                                    <td>
                                        <span v-if="driver.approved == '1'" class="text-success"><b>Approved</b></span>
                                        <span v-else class="text-warning"><b>Pending</b></span>
                                    </td>

                                    <td>
                                        {{driver.created_at}}
                                    </td>
                                    <td class="text-center">
                                        <button type="button" @click.prevent="editModal(driver)"
                                                class="btn btn-sm btn-secondary js-tooltip-enabled">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled"
                                                @click.prevent="deleteUser(driver.id, driver)">
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
                        <h3 class="card-title">Update Driver Status</h3>
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
                                        <label for="email">Registration NO</label>
                                        <input type="text" class="form-control" :value="form.registration_no" disabled
                                               id="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" required v-model="form.status">
                                            <option value="" selected disabled>PAYMENT STATUS</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Approve</option>
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

    const UsersRepository = RepositoryFactory.get('drivers');
    export default {
        data() {
            return {
                search: "",
                accounts: [],
                drivers: [],
                form: new Form({
                    id: '',
                    registration_no: '',
                    status: ''
                })
            }
        },
        methods: {
            updateUser() {
                let data = {
                    status: this.form.status
                };
                axios.post(`/api/admin/user/driver/${this.form.id}/status`, data).then(() => {
                    $('#modal-fadein').modal('hide');
                    Fire.$emit('Refresh');
                    toast.fire({
                        type: 'success',
                        title: 'Status updated successfully'
                    });
                }).catch(error => {
                    toast.fire({
                        type: 'error',
                        title: 'Failed to update driver status'
                    });
                })
            },
            editModal(driver) {
                this.form.reset();
                $('#modal-fadein').modal('show');
                this.form.fill(driver);
            },
            getUsers() {
                axios.get(`/api/admin/user/drivers`).then(response => {
                    this.drivers = response.data;
                })
            },
            deleteUser(id, driver) {
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
                        axios.post(`/api/admin/user/driver/${id}/delete`).then(response => {
                            const driverIndex = this.drivers.findIndex(p => p.id === driver.id);
                            this.drivers.splice(driverIndex, 1);
                            swal.fire(
                                'Deleted!',
                                response.data.message,
                                response.data.status
                            );
                        }).catch(error => {
                            if (error.response.status == 403) {
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
            Fire.$on('Refresh', () => {
                this.getUsers();
            });
        },
        computed: {
            filteredDrivers() {
                return this.drivers.filter(driver => {
                    return (
                        driver.registration_no.toLowerCase().includes(this.search.toLowerCase())
                    );
                });
            }
        }

    }
</script>
