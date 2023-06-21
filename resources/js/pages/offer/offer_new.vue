<template>
    <div class="mx-3">
        <v-card>
            <v-card-title>
                <v-icon left>mdi-camera-plus-outline</v-icon>Shto oferte te re
                <div class="flex-grow-1"></div>
            </v-card-title>
            <v-container>
                <v-row class="mx-5">
                    <v-container class="pa-1">
                        <v-card outlined tile class="py-5 px-8">
                            <!-- titulli -->
                            <span class="text-uppercase">Te dhenat per oferten</span>

                            <v-row class="py-5">
                                <v-col class="py-1" cols="10">
                                    <v-autocomplete
                                        :error-messages="saving_errors.services"
                                        label="Sherbimet:"
                                        v-model="new_resource.services"
                                        :items="data_autofill.services"
                                        item-text="name"
                                        item-value="id"
                                        multiple
                                        chips
                                        deletable-chips
                                        hide-selected
                                        hint="Zgjidh nga sherbimet egzistuese."
                                        persistent-hint
                                    ></v-autocomplete>
                                </v-col>
                                <v-col class="py-1" cols="2">
                                    <v-btn
                                        block
                                        text
                                        color="primary"
                                        class="mt-5"
                                        @click="new_service_dialog = true"
                                    >Shto sherbim te ri</v-btn>
                                </v-col>
                            </v-row>

                            <v-row class="mt-1">
                                <v-col class="py-1" cols="6">
                                    <v-text-field
                                        :error-messages="saving_errors.name"
                                        label="Emri: *"
                                        v-model="new_resource.name"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-1" cols="4">
                                    <v-text-field
                                        :error-messages="saving_errors.price"
                                        label="Cmimi: *"
                                        v-model="new_resource.price"
                                        hint="Cmimi i ofertes. Kliko 'Kalkulo cmimin', per cmimin e ofertes ne baze te sherbimeve te zgjedhura."
                                        persistent-hint
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-1" cols="2">
                                    <v-btn
                                        block
                                        text
                                        class="mt-5"
                                        @click="calculate_offer_price()"
                                        :disabled="new_resource.services.length==0"
                                    >Kalkulo cmimin</v-btn>
                                </v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col class="py-1" cols="12">
                                    <v-text-field
                                        :error-messages="saving_errors.description"
                                        label="Te dhena shtese:"
                                        v-model="new_resource.description"
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col class="text-left" cols="2">
                                    <small>*duhet te plotesohen</small>
                                </v-col>
                                <div class="flex-grow-1"></div>
                            </v-row>
                        </v-card>
                    </v-container>
                </v-row>

                <v-row class="mx-1 mt-5">
                    <div class="flex-grow-1"></div>

                    <v-col cols="3" class="pt-0 pr-5">
                        <v-btn
                            :disabled="false"
                            @click="submit_data"
                            color="success"
                            block
                            outlined
                        >Ruaj te dhenat</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
        <v-dialog v-model="new_service_dialog" persistent max-width="75vw">
            <v-card >
                <v-card-title>
                    <span class="headline pl-3">Shto sherbim te ri</span>
                    <div class="flex-grow-1"></div>
                </v-card-title>
                <v-card-text>
                    <v-container class="pa-1">
                        <v-card outlined tile class="py-5 px-8">
                            <!-- titulli -->
                            <span class="text-uppercase">Te dhenat per sherbimin</span>


                            <v-row class="mt-1">
                                <v-col class="py-1" cols="6">
                                    <v-text-field
                                        :error-messages="new_service_errors.name"
                                        label="Emri i sherbimit: *"
                                        v-model="new_service.name"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-1" cols="4">
                                    <v-text-field
                                        :error-messages="new_service_errors.price"
                                        label="Cmimi: *"
                                        v-model="new_service.price"
                                        hint="Cmimi i sherbimit."
                                        persistent-hint
                                    ></v-text-field>
                                </v-col>

                            </v-row>
                            <v-row class="py-0">
                                <v-col class="py-1" cols="12">
                                    <v-text-field
                                        :error-messages="new_service_errors.description"
                                        label="Te dhena shtese:"
                                        v-model="new_service.description"
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col class="text-left" cols="2">
                                    <small>*duhet te plotesohen</small>
                                </v-col>
                                <div class="flex-grow-1"></div>
                            </v-row>
   

                        </v-card>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn @click="new_service_dialog = false" color="warning" text>Mbyll</v-btn>
                    <v-btn @click="submit_new_service_data()" color="success" text>Ruaj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";

export default {
    components: {},
    data() {
        return {
            new_resource: {
                name: "",
                description: "",
                price: "",
                services: [],
            },
            saving_errors: [],

            data_autofill: {
                services: [],
            },

            new_service_dialog: false,
            new_service: {
                name: "",
                description: "",
                price: "",
            },
            new_service_errors: []
        };
    },
    computed: {

    },
    methods: {
        calculate_offer_price() {
            let price = 0;
            this.data_autofill.services
                .filter(serv => this.new_resource.services.includes(serv.id))
                .forEach(service => {
                    price = price + Number(service.price);
                });
            if (price == 0) {
                this.new_resource.price = "";
            }
            this.new_resource.price = price;
        },

        submit_data: function() {
            let currentObj = this;

            axios
                .post(`/offer`, currentObj.new_resource)
                .then(function(resp) {
                    currentObj.saving_errors = [];
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Te dhenat u ruajten!"
                    });
                    currentObj.$router.push(
                        `/offer/${resp.data.resource.id}`
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
        },
        submit_new_service_data: function() {
            let currentObj = this;

            axios
                .post(`/service`, currentObj.new_service)
                .then(function(resp) {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Te dhenat u ruajten!"
                    });
                    // console.log(resp.data.resource)
                    currentObj.new_service_errors = [];
                    currentObj.new_service = {
                        name: "",
                        description: "",
                        price: "",
                    };
                    currentObj.new_resource.services.push(resp.data.resource.id);
                    currentObj.data_autofill.services.push(resp.data.resource);
                    currentObj.new_service_dialog = false;
                })
                .catch(function(resp) {
                    // console.log(resp.data);

                    currentObj.new_service_errors =
                        resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Te dhenat nuk u ruajten"
                    });
                });
        }
    },
    beforeMount: function() {
        let currentObj = this;
        axios
            .get("/offer/create")
            .then(function(resp) {
                currentObj.data_autofill = resp.data.data_autofill;
            })
            .catch(function(resp) {
                currentObj.$store.dispatch("showSnackbar", {
                    color: "error",
                    text: "Serveri nuk dergoi te dhenat. Rifresko faqen!"
                });
            });
    }
};
</script>
