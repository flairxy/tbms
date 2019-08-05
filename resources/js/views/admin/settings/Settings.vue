<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Setting</span>
        </nav>
        <add-modal @show-modal="newModal()" modal-title="create settings"/>

        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Amount</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="setting in settings" :key="setting.id">
                        <td class="font-w600">{{setting.name}}</td>
                        <td class="font-w600">{{setting.amount}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" @click="settingDelete(setting.id, setting)"
                                        class="btn btn-sm btn-secondary js-tooltip-enabled">
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
                        <h3 class="card-title">Add New Setting</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Beginning of the form -->
                    <form @submit.prevent="setSetting()">
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name" class="text-muted">Name</label>
                                        <select class="form-control" v-model="form.name">
                                            <option value="" disabled>select name</option>
                                            <option value="taxi">Taxi Price</option>
                                            <option value="bus">Bus Price</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="text-muted">Value</label>
                                        <input v-model="form.amount" type="text" class="form-control" id="name"
                                               required>
                                    </div>
                                    <button type="submit" class="btn btn-lg btn-outline-success mb-2">Create
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
                settings: [],
                form: new Form({
                    id: '',
                    name: '',
                    amount: ''
                })
            }
        },
        methods: {
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#modal-fadein').modal('show')
            },
            editModal(setting) {
                this.editmode = true;
                this.form.reset();
                $('#modal-fadein').modal('show');
                this.form.fill(setting);
            },
            settingDelete(id, setting) {
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
                        axios.post(`/api/admin/setting/${id}/delete`).then(response => {
                            const settingIndex = this.settings.findIndex(p => p.id === setting.id);
                            this.settings.splice(settingIndex, 1);
                            toast.fire({
                                type: 'success',
                                title: 'Deleted!'
                            });
                        }).catch(error => {
                            swal("Failed!", "There was something wrong.", "warning");
                        });
                    }
                })
            },
            setSetting() {
                this.$Progress.start();
                let data = {
                    name: this.form.name,
                    value: this.form.value,
                };
                UsersRepository.createSetting(data).then(response => {
                    this.settings = response.data;
                    $('#modal-fadein').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Setting created successfully'
                    });
                    this.$Progress.finish();
                    Fire.$emit('Refresh');

                }).catch(error => {
                    if (error.response.status == 403) {
                        toast.fire({
                            type: 'error',
                            title: 'Action Unauthorized'
                        });
                    } else
                        toast.fire({
                            type: 'warning',
                            title: 'Failed to create setting'
                        });
                })
            },
            loadSettings() {
                UsersRepository.viewSettings().then(response => {
                    this.settings = response.data
                })
            }
        },
        created() {
            this.loadSettings();
            Fire.$on('Refresh', () => {
                this.loadSettings();
            });
        }
    }
</script>
