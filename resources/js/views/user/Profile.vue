<template>
    <div>
        <div class="row">
            <div class="col-md-8 col-xl-3">
                <a class="block block-link-shadow" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="text-right float-right mt-10">
                            <div class="font-w600 mb-5 text-danger">
                                <a class="badge badge-warning" href="javascript:void(0)">Not Verified</a>
                            </div>
                            <div class="font-size-sm text-muted">joined: {{user.created_at}}</div>
                        </div>
                        <div class="float-left">
                            <img class="img-avatar" :src="avatar">
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="mt-3">
            <div>
                <div class="row align-items-center">
                    <div class="col">
                        <ul class="nav nav-tabs nav-tabs-alt js-tabs-enabled" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="personal-tab" data-toggle="tab" href="#personal"
                                   role="tab"
                                   aria-controls="personal" aria-selected="true"
                                >Personal Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="security-tab" data-toggle="tab"
                                   href="#security" role="tab" aria-controls="security" aria-selected="false">Security</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="wallet-tab" data-toggle="tab" href="#wallet"
                                   role="tab"
                                   aria-controls="wallet" aria-selected="false">Wallet</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                        <personal-component :email="user.email" :username="user.username"/>
                    </div>
                    <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                        <security-component/>
                    </div>
                    <div class="tab-pane fade" id="wallet" role="tabpanel" aria-labelledby="wallet-tab">
                        <wallet-component/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import WalletComponent from '../../components/profile/wallet'
    import SecurityComponent from '../../components/profile/security'
    import PersonalComponent from '../../components/profile/personal'

    import { RepositoryFactory } from '../../repository/RepositoryFactory'
    const UsersRepository = RepositoryFactory.get('users');

    export default {
        components: {
            WalletComponent,
            SecurityComponent,
            PersonalComponent
        },
        data() {
            return {
                image1: '/media/avatars/avatar15.jpg',
                avatar: '/media/avatars/avatar9.jpg',
                user: ''
            }
        },
        mounted() {
            UsersRepository.loggedInUser().then(response => {
                this.user = response.data;
            })

        }
    }
</script>

<style scoped>
    #bg-image {
        background-image: url('/media/photos/photo13@2x.jpg');
    }
</style>
