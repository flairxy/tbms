<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Overview</span>
        </nav>

        <div class="row gutters-tiny">
            <div class="col-md-6">
                <!-- Modern on Background Color -->
                <div class="block">
                    <div class="block-content block-content-full ribbon ribbon-left ribbon-bookmark ribbon-warning">
                        <div class="py-20 text-center">
                            <div class="mb-20">
                                <i class="si si-wallet fa-4x text-success"></i>
                            </div>
                            <div class="font-size-h3 font-w600" v-if="payments">N{{payments}}</div>
                            <div class="font-size-h3 font-w600" v-else>N0.00</div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Payments</div>
                        </div>
                    </div>
                </div>
                <!-- END Modern on Background Color -->
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="py-20 text-center">
                            <div class="mb-20">
                                <i class="si si-users fa-4x text-info"></i>
                            </div>
                            <div class="font-size-h3 font-w600" v-if="riders">{{riders}}</div>
                            <div class="font-size-h3 font-w600" v-else>0</div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Riders</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl-3">
                <a class="block block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="py-20 text-center">
                            <div class="mb-20">
                                <i class="fa fa-cab fa-4x text-info"></i>
                            </div>
                            <div class="font-size-h3 font-w600" v-if="drivers">{{drivers}}</div>
                            <div class="font-size-h3 font-w600" v-else>0</div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Drivers</div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END Row #2 -->
        </div>
    </div>
</template>

<script>
    import {RepositoryFactory} from '../../repository/RepositoryFactory'

    const UsersRepository = RepositoryFactory.get('drivers');
    export default {
        data() {
            return {
                payments: '',
                riders: '',
                drivers: ''
            }
        },
        mounted() {
            axios.get('/api/admin/rides/payments').then(response => {
                this.payments = response.data;
            });
            axios.get('/api/admin/users/total-drivers').then(response => {
                this.drivers = response.data;
            });
            axios.get('/api/admin/users/total-riders').then(response => {
                this.riders = response.data;
            });
        }
    }
</script>
