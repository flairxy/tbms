<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Payment</span>
        </nav>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="block">
                    <div class="block-header bg-primary">
                        <h3 class="block-title text-white">Payment</h3>
                    </div>
                    <div class="block-content">
                        <!--                content-->
                        <form action="be_forms_premade.html" method="post" onsubmit="return false;">
                            <div class="form-group row">
                                <label class="col-12" for="card">Card Number</label>
                                <div class="col-12">
                                    <input type="tel" class="form-control" id="card"
                                           placeholder="0000 0000 0000 0000" required autofocus
                                    >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12" for="expiry">Expiry Date</label>
                                <div class="col-12">
                                    <input type="tel" class="form-control" id="expiry" placeholder="MM/YY" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12" for="cvv">CVV</label>
                                <div class="col-12">
                                    <input type="tel" class="form-control" id="cvv" placeholder="987" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-alt-primary">
                                        <i class="fa fa-plus mr-5"></i> Pay
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>

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
