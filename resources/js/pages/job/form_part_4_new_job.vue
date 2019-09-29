<template>
    <v-container class="mx-1" style="min-height: 55vh">
        
            <v-card outlined class="py-5 px-8" :color="job_details_section_color">

                    <!-- titulli -->
                    <v-row class="px-2 mb-1">
                        <div>
                            <v-icon left >mdi-calendar-plus</v-icon>
                            <span class="text-uppercase font-weight-bold">Detajet per punen</span>
                        </div>
                        <div class="flex-grow-1"></div>
                    </v-row>
                    <!-- body -->
                    <v-row class="py-0">
                        <v-col cols="6">
                            <v-row>
                                <v-col cols="12" class="py-0">
                                    <v-text-field
                                        hint="Bazuar ne emrin e ofertes dhe klientit"
                                        label="Emri i punes"
                                        persistent-hint
                                        prepend-icon="mdi-account-card-details-outline"

                                        :error-messages="saving_errors.name"
                                        :disabled="job_saved"
                                        v-model="created_job.name"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" class="py-0">
                                    <v-text-field
                                        hint="Bazuar ne cmimin e ofertes"
                                        label="Cmimi i punes"
                                        persistent-hint
                                        prepend-icon="mdi-cash-multiple"
                                        :disabled="job_saved"
                                        :error-messages="saving_errors.price"
                                        v-model="created_job.price"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" class="py-0">
                                    <v-text-field
                                        label="Pershkrimi"
                                        prepend-icon="mdi-card-text-outline"
                                        rows="2"
                                        :disabled="job_saved"
                                        :readonly="job_saved"
                                        v-model="created_job.description"
                                        :error-messages="saving_errors.description"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-col>
                        <div class="flex-grow-1"></div>
                        <v-col cols="5">
                            <v-row class="py-0">
                                <v-col class="py-0" cols="7">
                                    <v-text-field
                                        :value="selected_offer_name"
                                        label="Oferta e zgjedhur:"
                                        prepend-icon="mdi-tag"
                                        
                                        disabled
                                        :error-messages="saving_errors.offer_id"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="5">
                                    <v-btn @click="current_step = 1" text>
                                        <v-icon left>mdi-playlist-edit</v-icon>Ndrysho oferten
                                    </v-btn>
                                </v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col class="py-0" cols="7">
                                    <v-text-field
                                        :value="selected_client_name"
                                        label="Klienti:"
                                        prepend-icon="mdi-account-outline"

                                        disabled
                                        :error-messages="saving_errors.client_id"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="5">
                                    <v-btn @click="current_step = 2" text>
                                        <v-icon left>mdi-playlist-edit</v-icon>Ndrysho klientin
                                    </v-btn>
                                </v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col class="py-0" cols="7">
                                    <v-text-field
                                        :value="events.map(ev => ev.name + ' ')"
                                        :error-messages="saving_errors.event_ids"
                                        prepend-icon="mdi-calendar"
                                        label="Eventet:"
                                        disabled
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="5">
                                    <v-btn @click="current_step = 3" text>
                                        <v-icon left>mdi-playlist-edit</v-icon>Shto event tjeter
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                          <v-row class="py-0">
                        <v-col class="text-left py-0" cols="2">
                            <small>*duhet te plotesohen</small>
                        </v-col>
                        <div class="flex-grow-1"></div>
                        <v-col class="text-right py-0" cols="4">
                            <v-btn :disabled="disabled_submit || job_saved == true" @click="save_job" color="primary" outlined>Ruaj detajet per punen</v-btn>
                        </v-col>
                    </v-row>
        
            </v-card>

        <v-row class="py-0 mt-8">
            <v-col cols="12 py-0"><span class="title font-weight-light">Eventet:</span></v-col>
 
                <FormEventCard :event="event" v-bind:key="index" v-for="(event, index) in events"></FormEventCard>
          
        </v-row>

    </v-container>
</template>

<script>
import axios from "@/js/config/axios.js";

import { mapFields } from "vuex-map-fields";
import FormEventCard from "@/js/pages/job/form_job_event_card.vue";

export default {
    name: "FormPart4",
    components: { FormEventCard },

    data() {
        return {
            job_details_section_color: "indigo lighten-5",
            saving_errors: []
        };
    },
    computed: {
        ...mapFields({
            selected_offer_id: "form_new_job_data.selected_offer_id",
            selected_offer_name: "form_new_job_data.selected_offer_name",
            selected_client_id: "form_new_job_data.selected_client_id",
            selected_client_name: "form_new_job_data.selected_client_name",
            job_saved: "form_new_job_data.job_saved",
            current_step: "form_new_job_data.current_step",
            select_client_tab: "form_new_job_data.select_client_tab",
            offers: "form_new_job_data.offers",
            clients: "form_new_job_data.clients",
            events: "form_new_job_data.events",

            created_job: "form_new_job_data.created_job"
        }),
        disabled_submit: function() {
            return (
                this.created_job.name == "" ||
                this.created_job.price == "" ||
                this.created_job.offer_id == "" ||
                this.events.length == 0
            );
        }
    },

    methods: {
        save_job: function() {
            let currentObj = this;

            if (!currentObj.disabled_submit) {
                axios
                    .post("/job", currentObj.created_job)
                    .then(function(resp) {
                        currentObj.$store.dispatch("showSnackbar", {
                            color: "success",
                            text: "Puna u shtua!"
                        });
                        currentObj.created_job.id = resp.data.job.id;
                        return resp;
                    })
                    .then(function(resp) {
                        let events_data = {
                            job_id: currentObj.created_job.id,
                            event_ids: currentObj.events.map(event => event.id)
                        };
                        axios
                            .post("/job/addEvents", events_data)
                            .then(function(resp) {
                                currentObj.$store.dispatch("showSnackbar", {
                                    color: "success",
                                    text: "Eventet u ruajten!"
                                });
                                // let job_id = currentObj.created_job.id;
                                currentObj.job_saved = true;
                                // currentObj.current_step = "5";

                                // currentObj.saving_errors = [];
                                // currentObj.selected_offer_id = "";
                                // currentObj.selected_offer_name = "";
                                // currentObj.selected_client_id = "";
                                // currentObj.selected_client_name = "";
                                // currentObj.current_step = "5";
                                // currentObj.select_client_tab = 0;
                                // currentObj.offers = [];
                                // currentObj.clients = [];
                                // currentObj.events = [];

                                // currentObj.created_job = [];
                            })
                            .catch(function(resp) {
                                currentObj.saving_errors =
                                    resp.response.data.errors;
                                currentObj.$store.dispatch("showSnackbar", {
                                    color: "error",
                                    text: "Eventet nuk u ruajten!"
                                });
                            });
                    })

                    .catch(function(resp) {
                        // console.error(resp);
                        currentObj.saving_errors = resp.response.data.errors;
                        currentObj.$store.dispatch("showSnackbar", {
                            color: "error",
                            text: "Puna nuk u ruajt!"
                        });
                    });

                //  this.$router.replace('swasdasd');
            }
        }
    }
};
</script>