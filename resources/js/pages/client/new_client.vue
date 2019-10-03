<template>
    <div class="mx-3">
        <v-card>
            <v-card-title>
                <v-icon left>mdi-account-plus-outline</v-icon>
Shto klient te ri
                <div class="flex-grow-1"></div>
            </v-card-title>
            <v-container>
                <v-row class="mx-5">
                    <v-container class="pa-1">
                        <v-card outlined tile class="py-5 px-8">
                            <!-- titulli -->
                            <span class="text-uppercase">Te dhenat baze</span>
                            
                            <v-row>
                                <v-col cols="12" sm="6" md="4">
                                    <v-text-field
                                        v-model="new_client.name"
                                        label="Emri: *"
                                        :error-messages="saving_errors.name"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" sm="6" md="4">
                                                            <v-text-field
                                        v-model="new_client.email"
                                        label="Email: *"
                                        :error-messages="saving_errors.email"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="4">
                                             <v-text-field
                                        v-model="new_client.phone"
                                        label="Telefoni: *"
                                        :error-messages="saving_errors.phone"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" sm="6" md="4">
                                    <v-combobox
                                        :error-messages="saving_errors.city"
                                        label="Qyteti/Komuna: *"
                                        hint="Shtyp te re ose zgjedh nga lista"
                                        persistent-hint
                                        v-model="new_client.city"
                                        :items="data.cities"
                                        item-text="type"
                                        clearable
                                    ></v-combobox>
                                </v-col>
                                <v-col cols="12" sm="6" md="8">
                                    <v-text-field
                                        v-model="new_client.address"
                                        label="Adresa"
                                        hint="Adresa te jete sa me e detajuar"
                                        persistent-hint
                                        required
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                                     <v-row class="mt-5">
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
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";

export default {
    data() {
        return {
            saving_errors: [],
            data: {
                cities: []
            },
            new_client: {
                name: "",
                phone: "",
                email: "",
                city: "",
                address: ""
            }
        };
    },
    beforeMount: function() {
        let currentObj = this;
        axios
            .get("/client/create")
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
    },
    methods: {
        submit_data: function() {
            let currentObj = this;

            axios
                .post(`/client`, currentObj.new_client)
                .then(function(resp) {
                    currentObj.saving_errors = false;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Klienti u krijua!"
                    });
                    currentObj.$router.push("/client");
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
    }
};
</script>