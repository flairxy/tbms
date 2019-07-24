<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Gateways</span>
        </nav>
        <add-modal @show-modal="newModal()" modal-title="Gateway"/>

        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Charge</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="gateway in gateways" :key="gateway.id">
                        <td class="font-w600">{{gateway.name}}</td>
                        <td class="font-w600">{{gateway.charge}}%</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled"
                                        data-toggle="tooltip" title="" data-original-title="Edit"
                                        @click="editModal(gateway)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" @click="gatewayDelete(gateway.id, gateway)" class="btn btn-sm btn-secondary js-tooltip-enabled">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="modal-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-fadein"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 v-show="editmode" class="card-title">Update Gateway</h3>
                        <h3 v-show="!editmode" class="card-title">Add New Gateway</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Beginning of the form -->
                    <form @submit.prevent="editmode ? gatewayUpdate() : newGateway()">
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Gateway Name (example BITCOIN, ETHEREUM)</label>
                                        <input v-model="form.name" type="text" class="form-control" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="charge">Gateway Charge (%)</label>
                                        <input v-model="form.charge" type="text" class="form-control" id="charge" required>
                                    </div>
                                    <button type="submit" v-show="editmode" class="btn btn-lg btn-outline-info mb-2">
                                        Update
                                    </button>
                                    <button type="submit" v-show="!editmode"
                                            class="btn btn-lg btn-outline-success mb-2">Create
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
                editmode: false,
                gateways: [],
                form: new Form({
                    id: '',
                    name: '',
                    charge:''
                })
            }
        },
        methods: {
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#modal-fadein').modal('show')
            },
            editModal(gateway) {
                this.editmode = true;
                this.form.reset();
                $('#modal-fadein').modal('show');
                this.form.fill(gateway);
            },
            gatewayDelete(id, gateway) {
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
                        UsersRepository.deleteGateway(id).then(response=>{
                            const gatewayIndex = this.gateways.findIndex(p => p.id === gateway.id);
                            this.gateways.splice(gatewayIndex, 1);
                            swal.fire(
                                'Deleted!',
                                response.data.message,
                                response.data.status
                            );
                        }).catch(error=> {
                            if(error.response.status == 403) {
                                toast.fire({
                                    type: 'error',
                                    title: 'Action Unauthorized'
                                });
                            }else
                            swal("Failed!", "There was something wrong.", "warning");
                        });
                    }
                })
            },
            gatewayUpdate() {
                let data = {
                    name: this.form.name,
                    charge: this.form.charge,
                };
                UsersRepository.updateGateway(data, this.form.id).then(response => {
                    this.gateways = response.data;
                    Fire.$emit('Refresh');
                    $('#modal-fadein').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Gateway updated successfully'
                    });
                }).catch(error => {
                    if(error.response.status == 403) {
                        toast.fire({
                            type: 'error',
                            title: 'Action Unauthorized'
                        });
                    }else
                    toast.fire({
                        type: 'warning',
                        title: 'Failed to Update gateway'
                    });
                })
            },
            newGateway() {
                this.$Progress.start();
                let data = {
                    name: this.form.name,
                    charge: this.form.charge,
                };
                UsersRepository.createGateway(data).then(response => {
                    this.gateways = response.data;
                    $('#modal-fadein').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Gateway created successfully'
                    });
                    this.$Progress.finish();
                    Fire.$emit('Refresh');

                }).catch(err => {
                    if(err.response.status == 403) {
                        toast.fire({
                            type: 'error',
                            title: 'Action Unauthorized'
                        });
                    }
                    toast.fire({
                        type: 'warning',
                        title: 'Failed to create gateway'
                    });
                })
            },
            loadGateways() {
                UsersRepository.viewGateways().then(response => {
                    this.gateways = response.data;
                })
            }
        },
        created() {
            this.loadGateways();
            Fire.$on('Refresh', () => {
                this.loadGateways();
            });
        }
    }
</script>
