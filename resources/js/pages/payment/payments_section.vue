<template>
    <div class="mt-5">
        <v-row>
            <v-col>
                <div class="headline">Pagesat</div>
            </v-col>

            <v-col class="text-right">
                <v-btn
                    outlined
                    dark
                    @click.stop="new_payment_dialog = true"
                    color="primary"
                    class="mr-3"
                >Shto pagese</v-btn>
            </v-col>
        </v-row>


        <v-row v-if="payments.length > 0">
            <paymentCard v-for="payment in payments" v-bind:key="payment.id" :payment="payment"></paymentCard>
        </v-row>

        <v-row v-if="payments.length == 0">
            <v-col cols="12" class="ma-12 text-center">
                <p class="display-1 grey--text">Nuk ka pagesa te ruajtura</p>
            </v-col>
        </v-row>
    <v-row justify="center">
           
        <v-dialog v-model="new_payment_dialog" persistent max-width="70vw">
           
         
            <v-card outlined class="py-5 px-8" :color="new_payment_section_color">
      
                <v-row class="px-2 mb-3">
                    <div>
                        <v-icon left large>mdi-cash</v-icon>
                        <span class="text-uppercase font-weight-bold">Shto pagese</span>
                    </div>
                    <div class="flex-grow-1"></div>
                </v-row>
                <v-row class="py-0">
                    <v-col cols="4" class="py-0">
                        <v-text-field
                            value="Tani"
                            label="Me date:"
                            prepend-icon="mdi-calendar-clock"
                            disabled
                            class="pt-0"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="4" class="py-0">
                        <v-text-field
                            value="asdasd"
                            label="Nga:"
                            prepend-icon="mdi-account"
                            disabled
                            class="pt-0"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="4" class="py-0">
                        <v-text-field
                            value="Studion"
                            label="Per:"
                            prepend-icon="mdi-account-outline"
                            disabled
                            class="pt-0"
                        ></v-text-field>
                    </v-col>
                </v-row>

                <v-row class="py-0">
                    <v-col cols="7" class="py-0">
                        <v-text-field
                            :error-messages="new_payment.name== '' ? saving_errors.name:[]"
                            label="*Emri pershkrues:"
                            prepend-icon="mdi-account-card-details-outline"
                            required
                            v-model="new_payment.name"
                            class="pt-0"
                        ></v-text-field>
                    </v-col>

                    <v-col cols="5" class="py-0">
                        <v-text-field
                            :error-messages="new_payment.amount== '' ? saving_errors.amount:[]"
                            hint="Shembull 20 ose 20.3"
                            label="*Shuma:"
                            prepend-icon="mdi-cash-multiple"
                            v-model="new_payment.amount"
                            class="pt-0"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row class="py-0">
                    <v-col cols="12" class="pt-2 pb-0">
                        <v-text-field
                            :error-messages="new_payment.description== '' ? saving_errors.description:[]"
                            label="Detaje per pagesen:"
                            prepend-icon="mdi-card-text-outline"
                            required
                            v-model="new_payment.description"
                            class="pt-0"
                        ></v-text-field>
                    </v-col>
                </v-row>

                <v-row class="py-0">
                    <v-col class="text-left py-0" cols="2">
                        <small>*duhet te plotesohen</small>
                    </v-col>
                    <div class="flex-grow-1"></div>
                    <v-col class="text-right py-0" cols="2">
                        <v-btn @click="new_payment_dialog=false" color="warning" outlined>Mbyll</v-btn>
                    </v-col>
                    <v-col class="text-right py-0" cols="2">
                        <v-btn @click="save_new_payment" color="primary" outlined>Ruaj pagesen</v-btn>
                    </v-col>
                </v-row>
      
            </v-card>
            
            
        </v-dialog>
         
                </v-row> 

    </div>
</template>

<script>
import paymentCard from "@/js/pages/payment/payment_card";
import axios from "@/js/config/axios.js";

export default {
    components: { paymentCard },
    props: ["payments", "class_name", "id"],
    name: "paymentsSection",
    data() {
        return {
            new_payment_dialog: false,
            new_payment_section_color: "green lighten-5",
            saving_errors: [],

            new_payment: {
                name: "",
                from: "",
                to: "",
                amount: "",
                status: "paid",
                description: "",
                type: "in",
                paymentable_type: "",
                paymentable_id: ""
            }
        };
    },
    computed: {

    },
    methods: {
        deletepayment(id) {
            let currentObj = this;
            if (confirm("Konfirmo fshirjen e shenimit!") === false) {
                return;
            }
            axios(`/payment/${id}`, {
                method: "delete"
            })
                .then(function(resp) {
                    currentObj.$parent.payments = currentObj.payments.filter(
                        payment => payment.id != id
                    );
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Shenimi u fshi!"
                    });
                })
                .catch(function(resp) {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Shenimi nuk u fshi!"
                    });
                });
        },
        save_new_payment: function() {
            let currentObj = this;
            currentObj.new_payment.paymentable_type = currentObj.class_name;
            currentObj.new_payment.paymentable_id = currentObj.id;
            currentObj.new_payment.from = "Blla Blla";
            currentObj.new_payment.to = "Studion";
            axios
                .post(`/payment`, currentObj.new_payment)
                .then(function(resp) {
                    currentObj.saving_errors = [];
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Pagesa u shtua!"
                    });

                    currentObj.payments.push(resp.data.payment);

                    currentObj.new_payment = {
                        name: "",
                        amount: "",
                        status: "paid",
                        description: "",
                        type: "in",
                        paymentable_type: "",
                        paymentable_id: ""
                    };
                })
                .catch(function(resp) {
                    console.log(resp.data);

                    currentObj.saving_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Pagesa nuk u ruajt."
                    });
                });
        }
    }
};
</script>
