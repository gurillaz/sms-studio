<template>
    <v-col cols="6">
        <v-card tile class="pb-3 pt-1 px-5" :color="color">
            <v-container fluid class="py-0">
                <v-row class="px-2 pb-0 mt-3 mb-3 ">
                    <div>
                        <v-icon left large>mdi-cash</v-icon>
                        <span class="text-uppercase font-weight-bold">pagese</span>
                    </div>
                    <div class="flex-grow-1"></div>

                    <v-btn text color="warning" class="pr-0" @click="deletePayment">Fshij</v-btn>
                </v-row>

                <v-row class="py-0">
              
                    <v-col cols="4" class="py-0">
                        <v-text-field :value="formatedDate" label="Me date:" readonly class="pt-0"></v-text-field>
                    </v-col>
                    <v-col cols="4" class="py-0">
                        <v-text-field :value="payment.from" label="Nga:" readonly class="pt-0"></v-text-field>
                    </v-col>
                    <v-col cols="4" class="py-0">
                        <v-text-field :value="payment.to" label="Per:" readonly class="pt-0"></v-text-field>
                    </v-col>
                </v-row>

                <v-row class="py-0">
                     <v-col cols="7" class="py-0">
                        <v-text-field :value="payment.name" label="Emri pershkrues:" readonly class="pt-0"></v-text-field>
                    </v-col>
                    
                     <v-col cols="5" class="py-0">
                        <v-text-field :value="payment.amount+' njesi'" label="Shuma:" readonly class="pt-0"></v-text-field>
                    </v-col>
                </v-row>
                <v-row class="py-0">
                     <v-col cols="12" class="py-0">
                        <v-text-field :value="payment.description" label="Detaje per pagesen:" readonly class="pt-0"></v-text-field>
                    </v-col>
                </v-row>
         
            </v-container>
        </v-card>
    </v-col>
</template>

<script>
import axios from "@/js/config/axios";
import { mapFields } from "vuex-map-fields";
import moment from "moment";

export default {
    name: "FormPaymentCard",

    props: ["payment"],

    data() {
        return {
            color: "green lighten-4"
        };
    },
    methods: {
        deletePayment() {
            if (confirm("Konfirmo fshirjen e pageses.")) {
                let currentObj = this;

                axios
                    .post(`/payment/${currentObj.payment.id}`, {
                        _method: "DELETE"
                    })
                    .then(function(resp) {
                        currentObj.$store.dispatch("showSnackbar", {
                            color: "success",
                            text: "Pagesa u fshi!"
                        });
                        currentObj.payments = currentObj.payments.filter(
                            pm => pm.id !== currentObj.payment.id
                        );
                    })
                    .catch(function(resp) {
                        console.log(resp.data);

                        currentObj.saving_errors = resp.response.data.errors;
                        currentObj.$store.dispatch("showSnackbar", {
                            color: "warning",
                            text: "Pagesa nuk u fshi."
                        });
                    });
            }
        }
    },
    computed: {
        ...mapFields({
            payments: "form_new_job_data.payments"
        }),
        formatedDate() {
            moment.locale("sq");
            return moment(this.payment.updated_at).format('D/MM/Y - hh:mm');
        }
    }
};
</script>

<style scoped>
</style>