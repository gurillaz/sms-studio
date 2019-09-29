<template>
    <v-col cols="6">

        <v-card class="pb-3 pt-1 px-5" :color="is_selected ? color+' lighten-3' : color+' lighten-5'"
            :elevation="is_selected?10:'false'"
            hover
            @click="select_offer()">
            <v-container fluid class="py-0">
                <v-row class="px-2 pb-0 mt-3 mb-5 ">
                    <div>
                        <v-icon left large>mdi-tag</v-icon>
                        <span class="text-uppercase font-weight-bold">{{offer.name}}</span>
                    </div>
                    <div class="flex-grow-1"></div>


                </v-row>

                <v-row class="py-0">
              
                    <v-col cols="4" class="py-0">
                        <v-text-field :value="`${offer.discount*100} %`" label="Zbritja:" readonly class="pt-0"></v-text-field>
                    </v-col>
                    <v-col cols="8" class="py-0">
                        <v-text-field :value="offer.price" label="Cmimi me zbritje:" readonly class="pt-0"></v-text-field>
                    </v-col>
          
                </v-row>

                <v-row class="py-0">
                     <div class="text-left mt-0 pt-0" style="min-height: 6rem">
                         <p class="ml-3 overline">Sherbimet:</p>
                                <v-chip
                                    :color="randomColor()"
                                    class="ma-1"
                                    outlined
                                    small
                                    v-bind:key="service.id + i"
                                    v-for="(service, i) in offer.services"
                                >
                                    <span>{{service.name}}</span>
                                </v-chip>
                    </div>
                </v-row>
         
            </v-container>
        </v-card>

    </v-col>
</template>

<script>
import colors from "vuetify/lib/util/colors";
// https://momentjs.com/
import moment from "moment";
import { mapFields } from "vuex-map-fields";

export default {
    name: "FormOfferCard",
    props: ["offer"],

    data() {
        return {
            elevation: false,
            color: "green"
        };
    },
    methods: {
            randomColor: function() {
                let keys = Object.keys(colors);
                return colors[keys[(keys.length * Math.random()) << 0]].darken2;
            },

        select_offer() {
            this.selected_offer_id = this.offer.id;
            this.selected_offer_name = this.offer.name;


            this.created_job.name = this.offer.name+" - " + this.selected_client_name ;

            this.created_job.price = this.offer.price; 
            this.created_job.offer_id = this.offer.id; 
        }
    },
    computed: {
        ...mapFields({
            selected_offer_id: "form_new_job_data.selected_offer_id",
            selected_client_name: 'form_new_job_data.selected_client_name',
            selected_offer_name: 'form_new_job_data.selected_offer_name',

            created_job: 'form_new_job_data.created_job',
        }),
        is_selected: function() {
            if (this.offer.id === this.selected_offer_id) {
                return true;
            } else {
                return false;
            }
        }
    }
};
</script>

<style scoped>
</style>