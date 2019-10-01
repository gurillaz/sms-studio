<template>
    <div>
        <v-card class="px-5 ma-5 mt-0">
            <v-card-title>
                Te gjitha pagesat
                <div class="flex-grow-1"></div>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-account-search"
                    label="Kerko"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers" :items="payments" :search="search" height="70vh">
                <template v-slot:item.action="{ item }">
                    <v-btn class="ma-2" tile text small link :to="`/payment/${item.id}`">
                        Shiqo
                        <v-icon small right>mdi-open-in-new</v-icon>
                    </v-btn>
                </template>
            </v-data-table>
            <!-- <code>{{payments}}</code> -->
        </v-card>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";
export default {
    data() {
        return {
            search: "",
            headers: [
                {
                    text: "Emri",
                    align: "left",

                    value: "name"
                },
                { text: "I takon", value: "belongs_to_readable" },
                { text: "Dhenesi:", value: "from" },
                { text: "Marresi:", value: "to" },
                { text: "Shuma:", value: "amount" },
                { text: "Hyrje/Dalje:", value: "readable_type" },
                { text: "Kategoria:", value: "category" },
                { text: "Shtuar me date:", value: "updated_at_readable" },
                { text: "Shtuar nga:", value: "created_by.name" },

                { text: "", value: "action", sortable: false, align: "right" }
            ],
            payments: []
        };
    },
    methods: {
        readable_type(type) {
            if (type == "in") {
                return "Hyrje";
            } else if (type == "out") {
                return "Dalje";
            } else {
                return type;
            }
        },
        readable_date(created_at, updated_at) {
            moment.locale("sq");
            if (created_at === updated_at) {
                return moment(updated_at).format("D MMMM YYYY");
            } else {
                return (
                    moment(updated_at).format("D MMMM YYYY") + " (E modifikuar)"
                );
            }
        },
        belongs_to_readable(belongs_to) {
            if (belongs_to === "Employee") {
                return "Puntor";
            }
            if (belongs_to === "Client") {
                return "Klient";
            }
            if (belongs_to === "Job") {
                return "Pune";
            }
            if (belongs_to === "Event") {
                return "Event";
            }
            if (belongs_to === "File") {
                return "Fajll";
            }
            if (belongs_to === "Inventory") {
                return "Pajisje";
            }
            if (belongs_to === "Note") {
                return "Shenim";
            }
            if (belongs_to === "Offer") {
                return "Oferte";
            }
            if (belongs_to === "Payment") {
                return "Pagese";
            }
            if (belongs_to === "Service") {
                return "Sherbim";
            }
            if (belongs_to === "Task") {
                return "Detyre";
            } else {
                return belongs_to;
            }
        }
    },
    beforeMount() {
        var currentObj = this;
        axios
            .get("/payment")
            .then(function(resp) {
                // console.log(resp.data);
                currentObj.payments = resp.data.payments;
                currentObj.payments.forEach(payment => {

                    payment["updated_at_readable"] = currentObj.readable_date(
                        payment.created_at,
                        payment.updated_at
                    );
                    if(payment.belongs_to != ''){
                    payment["readable_type"] = currentObj.readable_type(
                        payment.type                    );
                    payment["belongs_to_readable"] =
                        "(" +
                        currentObj.belongs_to_readable(payment.model) +
                        ") " +
                        payment.belongs_to.name;
                        }
                    return payment;
                });
            })
            .catch(function(resp) {
                console.log(resp);
                alert("Could not load Payments");
            });
    }
};
</script>