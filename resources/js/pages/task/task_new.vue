<template>
    <div class="mx-3">
        <v-card>
            <v-card-title>
                <v-icon left>mdi-camera-plus-outline</v-icon>Shto detyre te re
                <div class="flex-grow-1"></div>
            </v-card-title>
            <v-container>
                <v-row class="mx-5">
                    <v-container class="pa-1">
                        <v-card outlined tile class="py-5 px-8">
                            <!-- titulli -->
                            <span class="text-uppercase">Te dhenat per detyren</span>

                            <v-row class="py-0">
                                <v-col class="py-1" cols="6">
                                    <v-text-field
                                        label="Puntori:"
                                        disabled
                                        hint="Puntori qe kryen detyren. Caktohet te Puna/Eventi."
                                        persistent-hint
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-1" cols="6">
                                    <v-text-field
                                        label="Eventi:"
                                        disabled
                                        hint="Eventi ku duhet te kryhet detyra. Caktohet te Puna/Eventi."
                                        persistent-hint
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="mt-10">
                                <v-col class="py-1" cols="6">
                                    <v-text-field
                                        :error-messages="saving_errors.name"
                                        label="Emri: *"
                                        v-model="new_resource.name"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-1" cols="6">
                                    <v-text-field
                                        :error-messages="saving_errors.payment_sum"
                                        label="Pagesa: *"
                                        v-model="new_resource.payment_sum"
                                        hint="Shuma e pageses per te cilen paguhet puntori per kryerjen e detyres. Ne baze te detyrave qe kryne puntori, caktohet rroga."
                                        persistent-hint
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="py-5">
                                <v-col class="py-1" cols="12">
                                    <v-autocomplete
                                        :error-messages="saving_errors.inventory"
                                        label="Pajisjet:"
                                        v-model="new_resource.inventory"
                                        :items="data_autofill.inventory"
                                        item-text="name"
                                        item-value="id"
                                        multiple
                                        chips
                                        deletable-chips
                                        hide-selected
                                        hint="Zgjedh nga lista nje ose me shume opsione. Pajisjet qe do perdoren ne detyre. Psh. per detyren 'Fotograf', duhen pajisjet si foto-aparati, baterit rezerve, tripod etj. "
                                        persistent-hint
                                    ></v-autocomplete>
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
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";

export default {
    components: {},
    data() {
        return {
            date_picker: false,
            new_resource: {
                name: "",
                description: "",
                payment_sum: "",
                inventory: [],
                status: "template"
            },
            data_autofill: {
                inventory: []
            },
            saving_errors: []
        };
    },
    computed: {},
    methods: {
        submit_data: function() {
            let currentObj = this;

            axios
                .post(`/task`, currentObj.new_resource)
                .then(function(resp) {
                    currentObj.saving_errors = [];
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Te dhenat u ruajten!"
                    });
                    currentObj.$router.push(
                        `/task/${resp.data.new_resource_id}`
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
    beforeMount: function() {
        let currentObj = this;
        axios
            .get("/task/create")
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
