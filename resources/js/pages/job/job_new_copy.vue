<template>
    <div class="mx-3">
        <v-stepper v-model="current_step">
            <v-stepper-header>
                <v-stepper-step :complete="current_step > 1" step="1">Zgjidh oferten</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="current_step > 2" step="2">Zgjidh klientin</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="current_step > 3" step="3">Shto eventet</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="current_step > 4" step="4">Detajet</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="5">Kontrata dhe pagesat</v-stepper-step>
            </v-stepper-header>

            <v-stepper-items>
                <v-stepper-content step="1">

                     <v-row>
            <v-col cols="3" class="pt-0 pr-5" v-if="current_step!=1">
                <v-btn
                    :disabled="current_step<finished_step"
                    @click="current_step = current_step - 1"
                    color="primary"
                    block
                    small
                    outlined
                >Pas</v-btn>
            </v-col>

            <div class="flex-grow-1"></div>

            <v-col cols="3" class="pt-0 pr-5" v-if="current_step<5">
                <v-btn
                    :disabled="current_step==4"
                    @click="current_step = current_step + 1"
                    color="primary"
                    block
                    small
                    outlined
                >Para</v-btn>
            </v-col>
        </v-row>

                    <FormPart1></FormPart1>

                   <v-row class="mx-2 mt-5">
                        <v-col cols="3" class="pt-0"><v-btn color="warning" outlined block>Anulo</v-btn></v-col>
                        <div class="flex-grow-1"></div>
                    
                        <v-col cols="3" class="pt-0 pr-5">
                        <v-btn
                                :disabled="selected_offer_id == ''"
                                @click="current_step = 2"
                                color="success"
                                block
                                
                                outlined
                            >
                 
                            Para</v-btn>
                   
                            </v-col>
                
                    </v-row>
                </v-stepper-content>

                <v-stepper-content step="2">
                 <FormNavigationButtons></FormNavigationButtons>
                 <!-- TODO navigation buttons top and bottom -->

         <!--            <v-row class="mx-2">
                        <v-col cols="3" class="pt-0 pr-5">
                        <v-btn
                              
                                @click="current_step = 1"
                                color="primary"
                                block
                                small
                                outlined
                            >
    
                            Mbrapa</v-btn>
                   
                            </v-col>
                        <div class="flex-grow-1"></div>
                    
                        <v-col cols="3" class="pt-0 pr-5">
                        <v-btn
                                 :disabled="selected_client_id == ''"
                                @click="current_step = 3"
                                color="success"
                                block
                                small
                                outlined
                            >
                            Para</v-btn>
                   
                            </v-col>
                
                    </v-row> -->

                    <FormPart2></FormPart2>

                    <v-row class="mt-5 mb-2 mx-4">
                        <div class="flex-grow-1"></div>

                        <div>
                            <v-btn color="warning" outlined>Anulo</v-btn>
                            <v-btn @click="current_step = 1" color="primary" outlined>Mbrapa</v-btn>

                            <v-btn
                                :disabled="selected_client_id == ''"
                                @click="current_step = 3"
                                color="success"
                            >Para</v-btn>
                        </div>
                    </v-row>
                </v-stepper-content>

                <v-stepper-content step="3">
                   
                 <FormNavigationButtons></FormNavigationButtons>
                    <FormPart3></FormPart3>

                    <v-row class="mt-5 mb-2 mx-4">
                        <div class="flex-grow-1"></div>

                        <div>
                            <v-btn color="warning" outlined>Anulo</v-btn>
                            <v-btn @click="current_step = 2" color="primary" outlined>Mbrapa</v-btn>

                            <v-btn
                                :disabled="events.length === 0"
                                @click="current_step = 4"
                                color="success"
                            >Para</v-btn>
                        </div>
                    </v-row>
                </v-stepper-content>

                <v-stepper-content step="4">
                    
                 <FormNavigationButtons></FormNavigationButtons>
                    <FormPart4></FormPart4>

                    <v-row class="mt-5 mb-2 mx-4">
                        <div class="flex-grow-1"></div>

                        <div>
                            <v-btn color="warning" outlined>Anulo</v-btn>
                            <v-btn @click="current_step = 3" :disabled="job_saved" color="primary" outlined>Mbrapa</v-btn>
                            <v-btn
                                :disabled="!job_saved"
                                color="success"
                                  @click="current_step = 5"
                            >Vazhdo</v-btn>
                        </div>
                    </v-row>
                </v-stepper-content>
                <v-stepper-content step="5">
                    
                 <FormNavigationButtons></FormNavigationButtons>
                    <FormPart5></FormPart5>



                    <v-row class="mt-5 mb-2 mx-4">
                        <div class="flex-grow-1"></div>

                        <div>
                            <!-- <v-btn @click="print_bill" :disabled="payments.length == 0" color="primary">Shtyp faturen</v-btn>
                            <v-btn @click="print_contract" :disabled="!job_saved" color="primary">Shtyp Kontraten</v-btn>
                            <v-btn @click="current_step = 4" color="primary" outlined>Mbrapa</v-btn> -->

                            <v-btn :to="`/job/${created_job.id}`" color="success">Largohu</v-btn>
                        </div>
                    </v-row>
                </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";

import FormPart1 from "@/js/pages/job/form_part_1_new_job";
import FormPart2 from "@/js/pages/job/form_part_2_new_job";
import FormPart3 from "@/js/pages/job/form_part_3_new_job";
import FormPart4 from "@/js/pages/job/form_part_4_new_job";
import FormPart5 from "@/js/pages/job/form_part_5_new_job";
import FormNavigationButtons from "@/js/pages/job/form_job_navigation_buttons";
import { mapFields } from "vuex-map-fields";

export default {
    components: {
        FormPart1,
        FormPart2,
        FormPart3,
        FormPart4,
        FormPart5,
        FormNavigationButtons
    },
    data() {
        return {};
    },
    computed: {
        ...mapFields({
            selected_offer_id: "form_new_job_data.selected_offer_id",
            selected_client_id: "form_new_job_data.selected_client_id",
  

            current_step: "form_new_job_data.current_step",
            events: "form_new_job_data.events",
            offers: "form_new_job_data.offers",
            payments: "form_new_job_data.payments",
            clients: "form_new_job_data.clients",
            created_job: "form_new_job_data.created_job",
            job_saved: "form_new_job_data.job_saved",
        }),

    },
    beforeMount: function() {
        let currentObj = this;

        axios
            .get("/job/create")
            .then(function(resp) {
                currentObj.offers = resp.data.offers;
                currentObj.clients = resp.data.clients;

                console.table(resp.data);
            })

            .catch(function(resp) {
                console.log(resp);
                alert("Gabim");
            });
    }
};
</script>