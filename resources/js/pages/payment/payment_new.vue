<template>
    <div class="mx-6">
        <v-card>
            <v-card-title>Pagese e re</v-card-title>
            <v-tabs v-model="tab" centered grow slider-color="green" background-color="transparent">
                <v-tab>Hyrje</v-tab>
                <v-tab>Dalje</v-tab>
            </v-tabs>

            <v-tabs-items v-model="tab">
                <v-tab-item>
                    <v-container>
                        <v-row class="mx-5 mt-5">
                            {{new_in_payment}}
                            <v-col cols="12">
                                <v-card outlined tile class="py-5 px-8">
                                    <v-row class="py-0">
                                        <v-col class="py-1" cols="3">
                                            <v-text-field
                                                :error-messages="saving_errors.amount"
                                                label="Shuma: "
                                                prepend-icon="mdi-numeric"
                                                v-model="new_in_payment.amount"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="py-0">
                                        <div class="flex-grow-6"></div>
                                        <v-col class="py-1" cols="6">
                                            <v-autocomplete
                                                :items="for_items"
                                                autofocus
                                                prepend-icon="mdi-numeric"
                                                clear-icon="mdi-close"
                                                clearable
                                                item-text="name"
                                                item-value="id"
                                                label="I takon:"
                                                no-data-text="Nuk ka te dhena!"
                                                return-object
                                                v-model="for_select"
                                            >
                                                <template
                                                    v-slot:selection="{attr,on,item,selected}"
                                                >
                                                <v-row class="pa-0 ma-0">
                                                    <v-col cols='3' class="pa-0 ma-0">{{belongs_to_readable(item.model)}}</v-col>
                                                    <v-col cols='9' class="pa-0 ma-0">{{item.name}}</v-col>
                                                </v-row>
                                   
                                                </template>
                                                <template v-slot:item="{ item }">
                                                  <v-row>
                                                    <v-col cols='9'>{{item.name}}</v-col>
                                                    <v-col cols='3' class="text-right">{{belongs_to_readable(item.model)}}</v-col>
                                                </v-row>
                                                </template>
                                            </v-autocomplete>
                                        </v-col>
                                        <v-col class="py-1" cols="6">
                                            <v-combobox
                                                label="Kategoria:"
                                                :error-messages="saving_errors.category"
                                                v-model="new_in_payment.category"
                                                :items="data.categories"
                                                item-text="category"
                                                prepend-icon="mdi-numeric"
                                                clearable
                                            ></v-combobox>
                                        </v-col>
                                        <v-col class="py-1" cols="6">
                                            <v-text-field
                                                :error-messages="saving_errors.from"
                                                label="Nga: "
                                                prepend-icon="mdi-numeric"
                                                v-model="new_in_payment.from"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col class="py-1" cols="6">
                                            <v-text-field
                                                :error-messages="saving_errors.to"
                                                label="Per: "
                                                prepend-icon="mdi-numeric"
                                                v-model="new_in_payment.to"
                                                disabled
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col class="py-1" cols="4">
                                            <v-text-field
                                                :error-messages="saving_errors.name"
                                                label="Emri: "
                                                prepend-icon="mdi-numeric"
                                                v-model="new_in_payment.name"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col class="py-1" cols="8">
                                            <v-text-field
                                                :error-messages="saving_errors.description"
                                                label="Pershkrimi: "
                                                prepend-icon="mdi-numeric"
                                                v-model="new_in_payment.description"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-card>
                            </v-col>
                        </v-row>

                        <v-row class="mx-0 mt-5">
                            <div class="flex-grow-1"></div>

                            <v-col cols="3" class="pt-0 pr-5">
                                <v-btn
                                    :disabled="false"
                                    @click="submit_payment_in"
                                    color="success"
                                    block
                                    outlined
                                >Ruaj te dhenat</v-btn>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-tab-item>
                <v-tab-item>
                    <v-container>
                        <v-row class="mx-5 mt-5">
                            <v-col cols="12">
                                <v-card outlined tile class="py-5 px-8"></v-card>
                            </v-col>
                        </v-row>

                        <v-row class="mx-0 mt-5">
                            <div class="flex-grow-1"></div>

                            <v-col cols="3" class="pt-0 pr-5">
                                <v-btn
                                    :disabled="false"
                                    @click="submit_payment_out"
                                    color="success"
                                    block
                                    outlined
                                >Ruaj te dhenat</v-btn>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-tab-item>
            </v-tabs-items>
        </v-card>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";

export default {
    components: {},
    data() {
        return {
            tab: 0,
            payment_type: [
                { text: "Hyrje", value: "in" },
                { text: "Dalje", value: "out" }
            ],
            selected_for_item: { name: "", model: "" },
            data: {
                for: [],
                categories:[]
            },

            new_in_payment: {
                id: "",
                name: "",
                from: "",
                to: "Studio",
                amount: "",
                type: "in",
                status: "paid",
                category: "",
                description: "",
                paymentable_type: "",
                paymentable_id: ""
            },
            new_out_payment: {
                id: "",
                name: "",
                from: "Studio",
                to: "",
                amount: "",
                type: "out",
                description: "",
                created_at: "",
                updated_at: "",
                created_by: {},

                belongs_to: {},
                class_name: "",
                model: ""
            },

            saving_errors: {}
        };
    },
    computed: {
        for_select: {
            set: function(item) {
                let currentObj = this;
                if (item != null) {
                    currentObj.new_in_payment.from = item.name;

                    if (item.model == "App\\Job") {
                        currentObj.new_in_payment.from =
                            item.client + "(Klienti)";
                    }
                    currentObj.new_in_payment.name = item.name + "(Pagese)";

                    currentObj.new_in_payment.paymentable_type = item.model;
                    currentObj.new_in_payment.paymentable_id = item.id;
                    // currentObj.selected_for_item = item;
                } else {
                    currentObj.new_in_payment.name = "";

                    currentObj.new_in_payment.from = "";
                    currentObj.new_in_payment.paymentable_type = "";
                    currentObj.new_in_payment.paymentable_id = "";
                }
            },
            get: function() {}
        },
        for_items: function() {
            this.data.for.unshift({
                name: "E paspecifikuar",
                model: ""
            });
            return this.data.for;
        },
        clients: function() {
            let clients_map = [];
            clients_map = this.data.clients.map(function(client) {
                return { text: client.name, value: client.id };
            });
            clients_map.unshift({ text: "E paspecifikuar", value: -1 });

            return clients_map;
        },
        client_jobs: function() {
            let currentObj = this;
            let clients_jobs_map = [];
            clients_jobs_map = currentObj.data.jobs.filter(
                job => job.client_id === currentObj.selected_client_id
            );
            clients_jobs_map = clients_jobs_map.map(function(job) {
                return { text: job.name, value: job.id };
            });

            clients_jobs_map.unshift({ text: "E paspecifikuar", value: -1 });
            return clients_jobs_map;
        }
    },
    methods: {
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
            if (belongs_to === "Inevntory") {
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
        },

        submit_payment_in: function() {
            let currentObj = this;
            if (currentObj.selected_client_id == -1) {
                currentObj.new_in_payment.from = "E pacaktuar";
                delete currentObj.new_in_payment.paymentable_type;
                delete currentObj.new_in_payment.paymentable_id;
            }

            axios
                .post(`/payment`, currentObj.new_in_payment)
                .then(function(resp) {
                    currentObj.saving_errors = {};
                    currentObj.new_in_payment = {
                        id: "",
                        name: "",
                        from: "",
                        to: "Studio",
                        amount: "",
                        type: "in",
                        status: "paid",
                        description: "",
                        category: "",
                        paymentable_type: "",
                        paymentable_id: ""
                    };
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Te dhenat per pagesen u ruajten!"
                    });
                })
                .catch(function(resp) {
                    currentObj.saving_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Te dhenat nuk u ruajten"
                    });
                });
        },
        submit_payment_out: function() {
            let currentObj = this;

            axios
                .post(`/employee`, currentObj.new_employee)
                .then(function(resp) {
                    currentObj.saving_errors = [];
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Klienti u krijua!"
                    });
                    currentObj.$router.push(
                        `/employee/${resp.data.new_employee_id}`
                    );
                })
                .catch(function(resp) {
                    console.log(resp.data);

                    currentObj.saving_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Te dhenat nuk u ruajten"
                    });
                });
        }
    },
    beforeMount() {
        let currentObj = this;
        axios
            .get("/payment/create")
            .then(function(resp) {
                // console.log(resp.data);

                currentObj.data = resp.data.data;

                // currentObj.belongs_to = resp.data.belongs_to;
                // currentObj.created_by = resp.data.created_by;
                // currentObj.model = resp.data.model;
            })
            .catch(function(resp) {
                // console.log(resp);
                currentObj.$store.dispatch("showSnackbar", {
                    color: "error",
                    text: "Serveri nuk dergoi te dhenat. Rifresko faqen!"
                });
            });
    }
};
</script>
