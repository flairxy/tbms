<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Plans</span>
        </nav>
        <add-modal @show-modal="newModal()" modal-title="Plan"/>

        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Minimum</th>
                        <th>Style</th>
                        <th>Duration</th>
                        <th>Percentage</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="plan in plans" :key="plan.id">
                        <td class="font-w600">{{plan.name}}</td>
                        <td>${{plan.min}}</td>
                        <td>
                            <span v-for="style in styles" :key="style.id">
                                <span v-if="style.id == plan.style_id"> {{style.name}}</span>
                            </span>
                        </td>
                        <td>{{plan.duration}}</td>
                        <td>{{plan.percentage}}%</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled"
                                        data-toggle="tooltip" title="" data-original-title="Edit"
                                        @click="editModal(plan)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" @click="planDelete(plan.id, plan)" class="btn btn-sm btn-secondary js-tooltip-enabled">
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
                        <h3 v-show="editmode" class="card-title">Update Hedge Plan</h3>
                        <h3 v-show="!editmode" class="card-title">Add New Hedge Plan</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Beginning of the form -->
                    <form @submit.prevent="editmode ? planUpdate() : newPlan()">
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Plan Name</label>
                                        <input v-model="form.name" type="text" class="form-control" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="max">Minimum deposit amount</label>
                                        <input type="text" class="form-control" id="max" required v-model="form.min">
                                    </div>
                                    <div class="form-group">
                                        <label for="percentage">Percentage (example 20, 30)</label>
                                        <input type="number" class="form-control" id="percentage" required
                                               v-model="form.percentage">
                                    </div>
                                    <div class="form-group">
                                        <label>Plan Style</label>
                                        <select class="form-control" required v-model="form.style">
                                            <option selected value="">Choose Style...</option>
                                            <option v-for="style in styles" :value="style.id" :key="style.id" >{{style.name}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="duration">Duration</label>
                                        <input type="text" class="form-control" id="duration" required
                                               v-model="form.duration">
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
                plans: [],
                styles: [],
                form: new Form({
                    id: '',
                    name: '',
                    style: '',
                    min: '',
                    duration: '',
                    percentage: '',
                })
            }
        },
        methods: {
            resetData() {
                this.form = []
            },
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#modal-fadein').modal('show')
            },
            editModal(plan) {
                this.editmode = true;
                this.form.reset();
                $('#modal-fadein').modal('show');
                this.form.fill(plan);
            },
            planDelete(id, plan) {
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
                        UsersRepository.deleteHedgePlan(id).then(response=>{
                            const projectIndex = this.plans.findIndex(p => p.id === plan.id);
                            this.plans.splice(projectIndex, 1);
                            swal.fire(
                                'Deleted!',
                                response.data.message,
                                response.data.status
                            );
                        }).catch(()=> {
                            swal("Failed!", "There was something wrong.", "warning");
                        });
                    }
                })
            },
            planUpdate() {
                let data = {
                    name: this.form.name,
                    style_id: this.form.style,
                    min: this.form.min,
                    duration: this.form.duration,
                    percentage: this.form.percentage,
                };
                UsersRepository.updateHedgePlan(data, this.form.id).then(response => {
                    this.plans = response.data;
                    Fire.$emit('Refresh');
                    $('#modal-fadein').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Plan updated successfully'
                    });
                })
            },
            newPlan() {
                this.$Progress.start();
                let data = {
                    name: this.form.name,
                    style_id: this.form.style,
                    min: this.form.min,
                    duration: this.form.duration,
                    percentage: this.form.percentage,
                };
                UsersRepository.createHedgePlan(data).then(response => {
                    this.plans = response.data;
                    $('#modal-fadein').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Plan created successfully'
                    });
                    this.$Progress.finish();
                    Fire.$emit('Refresh');

                }).catch(err => {

                })
            },
            loadPlans() {
                UsersRepository.viewHedgePlans().then(response => {
                    this.plans = response.data;
                })
            }
        },
        created() {
            this.loadPlans();
            Fire.$on('Refresh', () => {
                this.loadPlans();
            });
        },
        mounted() {
            UsersRepository.viewStyles().then(response => {
                this.styles = response.data;
            })
        }
    }
</script>
