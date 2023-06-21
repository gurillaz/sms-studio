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
                            <v-col cols="12">
                                <v-card outlined tile class="py-5 px-8">
                                    <v-row class="py-0">
                                        <v-col class="py-1" cols="3">
                                            <v-text-field
                                                :error-messages="saving_errors_in.amount"
                                                label="Shuma: *"
                                                v-model="new_in_payment.amount"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="py-0">
                                        <div class="flex-grow-6"></div>
                                        <v-col class="py-1" cols="6">
                                            <v-autocomplete
                                                :items="for_in_items"
                                                clear-icon="mdi-close"
                                                clearable
                                                item-text="name"
                                                item-value="id"
                                                label="I takon: *"
                                                no-data-text="Nuk ka te dhena!"
                                                return-object
                                                v-model="for_in_select"
                                                hint="Nese eshte pagese per punen e meparashme."
                                                persistent-hint
                                            >
                                                <template
                                                    v-slot:selection="{attr,on,item,selected}"
                                                >
                                                    <v-row class="pa-0 ma-0">
                                                        <v-col
                                                            cols="9"
                                                            class="pa-0 ma-0"
                                                        >{{item.name}} {{belongs_to_readable(item.model)}}</v-col>
                                                    </v-row>
                                                </template>
                                                <template v-slot:item="{ item }">
                                                    <v-row>
                                                        <v-col cols="9">{{item.name}}</v-col>
                                                        <v-col
                                                            cols="3"
                                                            class="text-right"
                                                        >{{belongs_to_readable(item.model)}}</v-col>
                                                    </v-row>
                                                </template>
                                            </v-autocomplete>
                                        </v-col>
                                        <v-col class="py-1" cols="6">
                                            <v-combobox
                                                label="Kategoria: *"
                                                :error-messages="saving_errors_in.category"
                                                v-model="new_in_payment.category"
                                                :items="data.categories"
                                                item-text="category"
                                                clearable
                                            ></v-combobox>
                                        </v-col>
                                        <v-col class="py-1" cols="6">
                                            <v-text-field
                                                :error-messages="saving_errors_in.from"
                                                label="Nga: *"
                                                v-model="new_in_payment.from"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col class="py-1" cols="6">
                                            <v-text-field
                                                :error-messages="saving_errors_in.to"
                                                label="Per: "
                                                v-model="new_in_payment.to"
                                                disabled
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col class="py-1" cols="4">
                                            <v-text-field
                                                :error-messages="saving_errors_in.name"
                                                label="Emri pershkrues: *"
                                                v-model="new_in_payment.name"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col class="py-1" cols="8">
                                            <v-text-field
                                                :error-messages="saving_errors_in.description"
                                                label="Detaje: "
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
                                <v-card outlined tile class="py-5 px-8">
                                    <v-row class="py-0">
                                        <v-col class="py-1" cols="3">
                                            <v-text-field
                                                :error-messages="saving_errors_out.amount"
                                                label="Shuma: *"
                                                v-model="new_out_payment.amount"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row class="py-0">
                                        <div class="flex-grow-6"></div>
                                        <v-col class="py-1" cols="6">
                                            <v-autocomplete
                                                :items="for_out_items"
                                                clear-icon="mdi-close"
                                                clearable
                                                item-text="name"
                                                item-value="id"
                                                label="I takon: *"
                                                no-data-text="Nuk ka te dhena!"
                                                return-object
                                                v-model="for_out_select"
                                                hint="Nese eshte pagese per punen e meparashme."
                                                persistent-hint
                                            >
                                                <template
                                                    v-slot:selection="{attr,on,item,selected}"
                                                >
                                                    <v-row class="pa-0 ma-0">
                                                        <v-col
                                                            cols="9"
                                                            class="pa-0 ma-0"
                                                        >{{item.name}} {{belongs_to_readable(item.model)}}</v-col>
                                                    </v-row>
                                                </template>
                                                <template v-slot:item="{ item }">
                                                    <v-row>
                                                        <v-col cols="9">{{item.name}}</v-col>
                                                        <v-col
                                                            cols="3"
                                                            class="text-right"
                                                        >{{belongs_to_readable(item.model)}}</v-col>
                                                    </v-row>
                                                </template>
                                            </v-autocomplete>
                                        </v-col>
                                        <v-col class="py-1" cols="6">
                                            <v-combobox
                                                label="Kategoria: *"
                                                :error-messages="saving_errors_out.category"
                                                v-model="new_out_payment.category"
                                                :items="data.categories"
                                                item-text="category"
                                                clearable
                                            ></v-combobox>
                                        </v-col>
                                        <v-col class="py-1" cols="6">
                                            <v-text-field
                                                :error-messages="saving_errors_out.from"
                                                label="Nga: *"
                                                v-model="new_out_payment.from"
                                                disabled
                                            ></v-text-field>
                                        </v-col>

                                        <v-col class="py-1" cols="6">
                                            <v-text-field
                                                :error-messages="saving_errors_out.to"
                                                label="Per: "
                                                v-model="new_out_payment.to"
                                                
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col class="py-1" cols="4">
                                            <v-text-field
                                                :error-messages="saving_errors_out.name"
                                                label="Emri pershkrues: *"
                                                v-model="new_out_payment.name"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col class="py-1" cols="8">
                                            <v-text-field
                                                :error-messages="saving_errors_out.description"
                                                label="Detaje: "
                                                v-model="new_out_payment.description"
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

            selected_for_in_item: { name: "", model: "" },
            selected_for_out_item: { name: "", model: "" },
            data: {
                for_in: [],
                for_out: [],
                categories: []
            },

            new_in_payment: {
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
                name: "",
                from: "Studio",
                to: "",
                amount: "",
                type: "out",
                status: "paid",
                category: "",
                description: "",
                paymentable_type: "",
                paymentable_id: ""
            },

            saving_errors_in: {},
            saving_errors_out: {}
        };
    },
    computed: {
        for_in_select: {
            set: function(item) {
                let currentObj = this;
                if (item != null && item.model != "") {
                    currentObj.new_in_payment.from = item.name;

                    if (item.model == "App\\Job") {
                        currentObj.new_in_payment.from =
                            item.client + "(Klienti)";
                    }
                    currentObj.new_in_payment.name = item.name + "(Pagese)";
                    currentObj.selected_for_in_item = item;
                    currentObj.new_in_payment.paymentable_type =
                        "App\\" + item.model;
                    currentObj.new_in_payment.paymentable_id = item.id;
                    // currentObj.selected_for_item = item;
                } else {
                    currentObj.new_in_payment.name = "";

                    currentObj.new_in_payment.from = "";
                    currentObj.new_in_payment.paymentable_type = "";
                    currentObj.new_in_payment.paymentable_id = "";
                }
            },
            get: function() {
                return this.selected_for_in_item;
            }
        },
        for_out_select: {
            set: function(item) {
                let currentObj = this;
                if (item != null && item.model != "") {
                    currentObj.new_out_payment.to = item.name;


                    currentObj.new_out_payment.name = item.name + "(Pagese)";
                    currentObj.selected_for_out_item = item;
                    currentObj.new_out_payment.paymentable_type =
                        "App\\" + item.model;
                    currentObj.new_out_payment.paymentable_id = item.id;
                    // currentObj.selected_for_item = item;
                } else {
                    currentObj.new_out_payment.name = "";

                    currentObj.new_out_payment.to = "";
                    currentObj.new_out_payment.paymentable_type = "";
                    currentObj.new_out_payment.paymentable_id = "";
                }
            },
            get: function() {
                return this.selected_for_out_item;
            }
        },
        for_in_items: function() {
            this.data.for_in.unshift({
                name: "E paspecifikuar",
                model: ""
            });
            return this.data.for_in;
        },
        for_out_items: function() {
            this.data.for_out.unshift({
                name: "E paspecifikuar",
                model: ""
            });
            return this.data.for_out;
        },

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
        },

        submit_payment_in: function() {
            let currentObj = this;
            if (currentObj.new_in_payment.paymentable_type == "") {
                delete currentObj.new_in_payment.paymentable_type;
                delete currentObj.new_in_payment.paymentable_id;
            }

            axios
                .post(`/payment`, currentObj.new_in_payment)
                .then(function(resp) {
                    currentObj.saving_errors_in = {};
                    currentObj.data.categories.push(currentObj.new_in_payment.category);
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
                    currentObj.selected_for_in_item = { name: "", model: "" };
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Te dhenat per pagesen u ruajten!"
                    });
                })
                .catch(function(resp) {
                    currentObj.saving_errors_in = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Te dhenat nuk u ruajten"
                    });
                });
        },
        submit_payment_out: function() {
            let currentObj = this;
            if (currentObj.new_out_payment.paymentable_type == "") {
                delete currentObj.new_out_payment.paymentable_type;
                delete currentObj.new_out_payment.paymentable_id;
            }

            axios
                .post(`/payment`, currentObj.new_out_payment)
                .then(function(resp) {
                    currentObj.saving_errors_out = {};
                    currentObj.data.categories.push(currentObj.new_out_payment.category);

                    currentObj.new_out_payment = {
                        id: "",
                        name: "",
                        from: "Studio",
                        to: "",
                        amount: "",
                        type: "out",
                        status: "paid",
                        description: "",
                        category: "",
                        paymentable_type: "",
                        paymentable_id: ""
                    };
                    currentObj.selected_for_out_item = { name: "", model: "" };
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Te dhenat per pagesen u ruajten!"
                    });
                })
                .catch(function(resp) {
                    currentObj.saving_errors_out = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Te dhenat nuk u ruajten"
                    });
                });
        },

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
