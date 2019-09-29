<template>
    <v-container class="mx-1" style="min-height: 55vh">
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
                        :value="selected_client_name"
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
                    <v-btn @click="save_new_payment" color="primary" outlined>Ruaj pagesen</v-btn>
                </v-col>
            </v-row>
        </v-card>
        <v-row class="mt-5 mb-2 mx-4">
            <v-col cols="6">
                <v-btn
                    @click="print_bill"
                    :disabled="payments.length == 0"
                    color="success"
                    outlined
                    large
                    block
                >Shtyp faturen</v-btn>
            </v-col>
            <v-col cols="6">
                <v-btn
                    @click="print_contract"
                    :disabled="!job_saved"
                    color="orange darken-4"
                    large
                    outlined
                    block
                >Shtyp Kontraten</v-btn>
            </v-col>
        </v-row>




        <v-row class="py-0 mt-8">
            <v-col cols="12 py-0">
                <span class="title font-weight-light">Pagesat:</span>
            </v-col>

            <FormPaymentCard
                :payment="payment"
                v-bind:key="index"
                v-for="(payment, index) in payments"
            ></FormPaymentCard>
        </v-row>
    </v-container>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";
import { mapFields } from "vuex-map-fields";
import FormPaymentCard from "@/js/pages/job/form_job_payment_card.vue";

export default {
    name: "FormPart5",
    components: { FormPaymentCard },

    data() {
        return {
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
                paymentable_type: "App/Job",
                paymentable_id: ""
            }
        };
    },
    computed: {
        ...mapFields({
            payments: "form_new_job_data.payments",
            created_job: "form_new_job_data.created_job",
            selected_client_name: "form_new_job_data.selected_client_name",
            job_saved: "form_new_job_data.job_saved"
        }),

        formatedDate() {
            moment.locale("sq");
            return this.date
                ? moment(this.date).format("D MMMM  YYYY, dddd")
                : "";
        }
    },

    methods: {
        print_bill: function() {},
        print_contract: function() {},
        save_new_payment: function() {
            let currentObj = this;
            currentObj.new_payment.paymentable_type = "`App\Job`";
            currentObj.new_payment.paymentable_id = currentObj.created_job.id;
            currentObj.new_payment.from = currentObj.selected_client_name;
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
                        paymentable_type: "App/Job",
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