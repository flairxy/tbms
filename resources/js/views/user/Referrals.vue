<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Referrals</span>
        </nav>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-7">
                <div class="block block-bordered">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Referral</h3>
                    </div>
                    <div class="block-content">
                        <p><strong class="">Refer Friends. Get Rewarded</strong></p>
                        <span>You can earn: up to {{amounts.value}}% approved referral bonus. Share your membership
                            link on your website or send it directly to your friends
                        </span>
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">

                        <div class="input-group">
                            <input type="text" class="form-control" name="example-input2-group1" id="referral"
                                  :value="reflink + user.username" disabled>
                            <div class="input-group-append">
                                <p class="hover-tooltip">
                                    <a href="#" data-toggle="tooltip" title="copied"></a></p>
                                <span @click.prevent="copy" class="input-group-text"><i class="fa fa-copy"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-3 col-xl-4" v-for="(user, index) in referrals" :key="user.id">
                <a class="block block-rounded block-bordered block-link-shadow" href="javascript:void(0)">
                    <div class="py-20 text-center">
                        <div>
                            <i class="fa fa-user-plus fa-2x text-info"></i>
                        </div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">{{user.username}}</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import { RepositoryFactory } from '../../repository/RepositoryFactory'
    const UsersRepository = RepositoryFactory.get('users');
    export default {
        data () {
            return {
                reflink: process.env.MIX_APP_URL + '/invite/join/',
                user: '',
                referrals: [],
                amounts: ''
            }
        },
       methods: {
           copy() {
               this.$copyText(this.reflink).then(function (e) {
                   $(".hover-tooltip a").tooltip('show');
                   setTimeout(function() {
                       $(".hover-tooltip a").tooltip('hide');
                   }, 3000);
               })
           },
       },
        created() {
            // this.getAuthUserReferrals();
        },
        mounted() {
            UsersRepository.loggedInUser().then(response => {
                this.user = response.data;
                UsersRepository.viewReferredUsers(response.data.id).then(response => {
                    this.referrals = response.data;
                })
            });
            UsersRepository.viewReferrals().then(response => {
                this.amounts = response.data;
            })

        }
    }
</script>
