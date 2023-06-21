<template>
    <div class="mx-3">
        <v-card>
            <v-card-title>
                <v-icon left>mdi-camera-plus-outline</v-icon>Shto sherbim te ri
                <div class="flex-grow-1"></div>
            </v-card-title>
            <v-container>
                <v-row class="mx-5">
                    <v-container class="pa-1">
                        <v-card outlined tile class="py-5 px-8">
                            <!-- titulli -->
                            <span class="text-uppercase">Te dhenat per sherbimin</span>


                            <v-row class="mt-1">
                                <v-col class="py-1" cols="6">
                                    <v-text-field
                                        :error-messages="saving_errors.name"
                                        label="Emri i sherbimit: *"
                                        v-model="new_resource.name"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-1" cols="4">
                                    <v-text-field
                                        :error-messages="saving_errors.price"
                                        label="Cmimi: *"
                                        v-model="new_resource.price"
                                        hint="Cmimi i sherbimit."
                                        persistent-hint
                                    ></v-text-field>
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
            new_resource: {
                name: "",
                description: "",
                price: "",
                status:'active'
            },
            saving_errors: [],

        }

    },
    computed: {

    },
    methods: {


        submit_data: function() {
            let currentObj = this;

            axios
                .post(`/service`, currentObj.new_resource)
                .then(function(resp) {
                    currentObj.saving_errors = [];
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Te dhenat u ruajten!"
                    });
                    currentObj.$router.push(
                        `/service/${resp.data.resource.id}`
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

    },
    beforeMount: function() {

    }
};
</script>
