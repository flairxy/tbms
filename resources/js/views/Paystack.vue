<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">paystack</span>
        </nav>
        <div class="block">
            <div class="block-content">
                <paystack
                    :amount="amount"
                    :email="email"
                    :paystackkey="paystackkey"
                    :reference="reference"
                    :callback="callback"
                    :close="close"
                    :embed="true"
                >
                    <i class="fas fa-money"></i>
                    Make Payment
                </paystack>
            </div>
        </div>
    </div>
</template>

<script>
    import {RepositoryFactory} from "../repository/RepositoryFactory";
    import paystack from "vue-paystack";

    const UsersRepository = RepositoryFactory.get("users");
    export default {
        components: {
            paystack
        },
        data() {
            return {
                paystackkey: "pk_test_86d32aa1nV4l1da7120ce530f0b221c3cb97cbcc", //paystack public key
                email: "foobar@example.com", // Customer email
                amount: 1000000, // in kobo
                drivers: [],
                processing: false,
                booking: false,
                user: "",
                form: new Form({
                    gateway: "",
                    amount: "",
                    plan: "",
                    user: ""
                })
            };
        },
        methods: {
            filterDrivers() {
                this.processing = true;
            },
            completeBooking(id) {
                this.booking = true;
                $("#modal-pop").modal("hide");
                $("#modal-pop1").modal("show");

                //   UsersRepository.bookRide().then(response => {
                //     $("#modal-pop").modal("hide");
                //     this.processing = false;
                //   });
            },
            continueBooking() {
                $("#modal-pop").modal("show");
            },
            callback: function (response) {
                console.log(response);
            },
            close: function () {
                console.log("Payment closed");
            }
        },
        mounted() {
            UsersRepository.loggedInUser().then(response => {
                this.user = response.data;
            });
        },
        computed: {
            reference() {
                let text = "";
                let possible =
                    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

                for (let i = 0; i < 10; i++)
                    text += possible.charAt(Math.floor(Math.random() * possible.length));

                return text;
            }
        }
    };
</script>
