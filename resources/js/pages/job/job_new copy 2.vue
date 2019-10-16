<template>
    <div class="mx-3">

        <v-stepper v-model="current_step">
            <v-stepper-header>
                <v-stepper-step :complete="current_step > 1" editable step="1">Te dhenat baze</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="current_step > 2" editable step="2">Shto eventet</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step step="3">Kontrata & Ruaj</v-stepper-step>
            </v-stepper-header>

            <v-stepper-items>
                <v-stepper-content step="1">

                    <v-card outlined tile class="py-5 px-8">
                        <!-- titulli -->
                        <span class="text-uppercase">Te dhenat baze</span>

                        <v-row class="py-0">
                            <v-col cols="10">
                                <v-autocomplete
                                    :error-messages="saving_job_errors.offer_id"
                                    :items="data_autofill.offers"
                                    autofocus
                                    clear-icon="mdi-close"
                                    clearable
                                    height="2.1rem"
                                    hide-details
                                    hide-selected
                                    item-text="name"
                                    item-value="id"
                                    label="Zgjidh oferten: *"
                                    no-data-text="Nuk ka te dhena"
                                    v-model="select_offer"
                                >
                                    <template v-slot:selection="{attr,on,item,selected}">
                                        <span class="pt-1">
                                            <span>{{item.name}} |</span>
                                            <span
                                                class="caption"
                                                v-for="(service_name,index) in item.services.map(service=>service.name)"
                                                :key="index"
                                            >{{service_name}},</span>
                                            <span class>| {{item.price}} Euro</span>
                                        </span>
                                    </template>
                                    <template v-slot:item="{ item }">
                                        <v-list-item-avatar
                                            class="headline font-weight-light white--text text-uppercase caption"
                                            color="indigo"
                                        >
                                            {{
                                            item.price
                                            }}
                                        </v-list-item-avatar>
                                        <v-list-item-content>
                                            <span class="pt-1">
                                                <span>{{item.name}} |</span>
                                                <span
                                                    class="caption"
                                                    v-for="(service_name,index) in item.services.map(service=>service.name)"
                                                    :key="index"
                                                >{{service_name}},</span>
                                                <span class>| {{item.price}} Euro</span>
                                            </span>
                                        </v-list-item-content>
                                    </template>
                                </v-autocomplete>
                            </v-col>
                            <v-col cols="10">
                                <v-autocomplete
                                    :error-messages="saving_job_errors.client_id"
                                    :items="data_autofill.clients"
                                    autofocus
                                    clear-icon="mdi-close"
                                    clearable
                                    height="2.1rem"
                                    hide-details
                                    hide-selected
                                    item-text="name"
                                    item-value="id"
                                    label="Zgjidh klientin egzistues: *"
                                    no-data-text="Nuk ka te dhena"
                                    v-model="select_client"
                                >
                                    <template v-slot:selection="{attr,on,item,selected}">
                                        <span class="pt-1">
                                            {{item.name}} -
                                            <span class="caption">{{item.city}}</span>
                                        </span>
                                    </template>
                                    <template v-slot:item="{ item }">
                                        <v-list-item-avatar
                                            class="headline font-weight-light white--text text-uppercase"
                                            color="indigo"
                                        >
                                            {{
                                            item.name.charAt(0)
                                            }}
                                        </v-list-item-avatar>
                                        <v-list-item-content>
                                            <v-list-item-title v-text="item.name"></v-list-item-title>
                                            <v-list-item-subtitle v-text="item.city"></v-list-item-subtitle>
                                        </v-list-item-content>
                                    </template>
                                </v-autocomplete>
                            </v-col>
                            <v-col cols="2">
                                <v-btn block text class="mt-4">Shto klient i ri</v-btn>
                            </v-col>
                        </v-row>
                        <v-row class="py-0">
                            <v-col cols="7">
                                <v-text-field
                                    :error-messages="saving_job_errors.name"
                                    label="Emri: *"
                                    v-model="new_resource.name"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="3">
                                <v-text-field
                                    :error-messages="saving_job_errors.price"
                                    label="Cmimi: *"
                                    v-model="new_resource.price"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    :error-messages="saving_job_errors.description"
                                    label="Te dhena shtese: *"
                                    v-model="new_resource.description"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-card>
                    <v-row class="mt-3">
                        <v-col cols="2" class="pt-0 pr-5" v-if="current_step!=1">
                            <v-btn
                                :disabled="current_step<completed_step"
                                @click="previous_step()"
                                color="primary"
                                block
                                small
                                outlined
                            >Pas</v-btn>
                        </v-col>

                        <div class="flex-grow-1"></div>

                        <v-col cols="2" class="pt-0 pr-5" v-if="current_step<3">
                            <v-btn
                                :disabled="current_step==3"
                                @click="next_step()"
                                color="primary"
                                block
                                small
                                outlined
                            >Para</v-btn>
                        </v-col>
                    </v-row>
                </v-stepper-content>
                <v-stepper-content step="2">
                    <v-card outlined class="py-5 px-8">
                        <!-- titulli -->
                        <v-row class="px-2 mb-3">
                            <div>
                                <v-icon left>mdi-calendar-plus</v-icon>
                                <span class="text-uppercase font-weight-bold">Shto event</span>
                            </div>
                            <div class="flex-grow-1"></div>
                        </v-row>
                        <!-- body -->
                        <v-row class="py-0">
                            <v-col class="py-0" cols="5">
                                <v-text-field
                                    :error-messages="saving_event_errors.name"
                                    label="Emri: *"
                                    prepend-icon="mdi-account-card-details-outline"
                                    required
                                    v-model="new_event.name"
                                ></v-text-field>
                            </v-col>
                            <v-col class="py-0" cols="7">
                                <v-text-field
                                    :error-messages="saving_event_errors.address"

                                    hint="Adresa te jete sa me e detajuar"
                                    label="Adresa: *"
                                    persistent-hint
                                    prepend-icon="mdi-map-marker-outline"
                                    v-model="new_event.address"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row class="py-0">
                            <v-col class="py-0" cols="4">
                                <!--                                    <v-text-field v-model="new_event.date" label="Data e eventit*"></v-text-field>-->

                                <v-menu
                                    :close-on-content-click="false"
                                    max-width="290"
                                    v-model="date_picker"
                                >
                                    <template v-slot:activator="{ on }">
                                        <v-text-field
                                            :error-messages="date == '' ? saving_event_errors.date_start:[]"
                                            :value="date_picker_formated_date"
                                            label="Data e eventit*"
                                            prepend-icon="mdi-calendar"
                                            readonly
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        :min="new Date().toISOString().substr(0, 10)"
                                        @change="date_picker = false"
                                        v-model="date"
                                    ></v-date-picker>
                                </v-menu>
                            </v-col>

                            <v-col class="py-0" cols="3">
                                <!--                                    <v-text-field v-model="new_event.date" label="Data e eventit*"></v-text-field>-->

                                <v-menu
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    :return-value.sync="time"
                                    max-width="290px"
                                    min-width="290px"
                                    offset-y
                                    ref="menu"
                                    v-model="time_picker"
                                >
                                    <template v-slot:activator="{ on }">
                                        <v-text-field
                                            :error="saving_event_errors.date_start!=null &&time == '' "
                                            label="Fillon ne ora*"
                                            prepend-icon="mdi-clock-start"
                                            readonly
                                            v-model="time"
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-time-picker
                                        @click:minute="$refs.menu.save(time)"
                                        format="24hr"
                                        full-width
                                        scrollable
                                        v-if="time_picker"
                                        v-model="time"
                                    ></v-time-picker>
                                </v-menu>
                            </v-col>

                            <v-col class="py-0" cols="3">
                                <v-text-field
                                    :error-messages="saving_event_errors.duration_hours"

                                    hint="Kohezgjatja e evenitit ne ore"
                                    label="Kohezgjatja e eventit*"
                                    persistent-hint
                                    prepend-icon="mdi-clock-end"
                                    required
                                    v-model="new_event.duration_hours"
                                ></v-text-field>
                            </v-col>
                            <v-col class="py-0" cols="2"></v-col>
                        </v-row>
                        <v-row class="py-0">
                            <v-col class="py-0" cols="12">
                                <v-text-field
                                    :error-messages="saving_event_errors.description"

                                    label="Detaje"
                                    prepend-icon="mdi-card-text-outline"
                                    required
                                    v-model="new_event.description"
                                ></v-text-field>
                            </v-col>
                        </v-row>

                        <v-row class="py-0">
                            <v-col class="text-left py-0" cols="2">
                                <small>*duhet te plotesohen</small>
                            </v-col>
                            <div class="flex-grow-1"></div>
                            <v-col class="text-right py-0" cols="2">
                                <v-btn @click="save_new_event" color="primary" outlined>Ruaj eventin</v-btn>
                            </v-col>
                        </v-row>
                    </v-card>
            
                     <v-row>
                        <v-col cols="12" v-if="events.length == 0">
                            <p
                                class="py-5 text-center headline red--text text--lighten-2"
                            >Nuk ka evente te ruajtura. Duhet te kete te pakten nje event te ruajtur.</p>
                        </v-col>
                        <v-col cols="12" v-else>
                            <v-container>
                                <v-row>
                                    <v-col cols="6" v-for="(event,index) in events" :key="index">
                                        <v-card
                                            tile
                                            flat
                                            class="pb-3 pt-1 px-5"
                                            color="orange lighten-4"
                                        >
                                            <v-container fluid class="py-0">
                                                <v-row class="px-2 pb-0 mt-3 mb-3">
                                                    <div>
                                                        <v-icon left>mdi-calendar</v-icon>
                                                        <span
                                                            class="text-uppercase font-weight-bold"
                                                        >Event</span>
                                                    </div>
                                                    <div class="flex-grow-1"></div>
                                                </v-row>

                                                <v-row class="py-0">
                                                    <v-col cols="4" class="py-0">
                                                        <v-text-field
                                                            :value="event.name"
                                                            label="Emri pershkrues:"
                                                            readonly
                                                            class="pt-0"
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col cols="8" class="py-0">
                                                        <v-text-field
                                                            :value="event.address"
                                                            label="Adresa:"
                                                            readonly
                                                            class="pt-0"
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row class="py-0">
                                                    <v-col cols="6" class="py-0">
                                                        <v-text-field
                                                            :value="formatedDate(event.date_start)"
                                                            label="Data e eventit:"
                                                            readonly
                                                            class="pt-0"
                                                        ></v-text-field>
                                                    </v-col>

                                                    <v-col cols="6" class="py-0">
                                                        <v-text-field
                                                            :value="`${duration_hours(event.date_start,event.date_end)} ore`"
                                                            label="Kohezgjatja:"
                                                            readonly
                                                            class="pt-0"
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-row class="py-0">
                                                    <v-col cols="12" class="py-0">
                                                        <v-text-field
                                                            :value="event.description"
                                                            label="Detaje per eventin:"
                                                            readonly
                                                            class="pt-0"
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-col>
                    </v-row>

                    <v-row class="mt-3">
                        <v-col cols="2" class="pt-0 pr-5" v-if="current_step!=1">
                            <v-btn
                                :disabled="current_step<completed_step"
                                @click="previous_step()"
                                color="primary"
                                block
                                small
                                outlined
                            >Pas</v-btn>
                        </v-col>

                        <div class="flex-grow-1"></div>

                        <v-col cols="2" class="pt-0 pr-5" v-if="current_step>1">
                            <v-btn @click="next_step()" color="warning" block small outlined>Anulo</v-btn>
                        </v-col>
                        <v-col cols="3" class="pt-0 pr-5" v-if="current_step<3">
                            <v-btn
                                :disabled="completed_step<2"
                                @click="next_step()"
                                color="primary"
                                block
                                small
                                outlined
                            >Para</v-btn>
                        </v-col>
                    </v-row>
                </v-stepper-content>
                <v-stepper-content step="3">
                    <v-card flat class="py-5 px-8" color="indigo lighten-5">
                        <!-- titulli -->
                        <v-row class="px-2 mb-1">
                            <div>
                                <v-icon left>mdi-calendar-plus</v-icon>
                                <span class="text-uppercase font-weight-bold">Detajet per punen</span>
                            </div>
                            <div class="flex-grow-1"></div>
                        </v-row>
                        <!-- body -->
                           <v-row class="py-0">
                            <v-col cols="5" class="py-0">
                                <v-autocomplete
                                    :error-messages="saving_job_errors.offer_id"
                                    :items="data_autofill.offers"
                                    autofocus
                                    clear-icon="mdi-close"
                                    clearable
                                    height="2.1rem"
                                    hide-details
                                    hide-selected
                                    item-text="name"
                                    item-value="id"
                                    label="Zgjidh oferten: *"
                                    no-data-text="Nuk ka te dhena"
                                    v-model="select_offer"
                                >
                                    <template v-slot:selection="{attr,on,item,selected}">
                                        <span class="pt-1">
                                            <span>{{item.name}} </span>
      
                                            <span class>| {{item.price}} Euro</span>
                                        </span>
                                    </template>
                                    <template v-slot:item="{ item }">
                                        <v-list-item-avatar
                                            class="headline font-weight-light white--text text-uppercase caption"
                                            color="indigo"
                                        >
                                            {{
                                            item.price
                                            }}
                                        </v-list-item-avatar>
                                        <v-list-item-content>
                                            <span class="pt-1">
                                                <span>{{item.name}} |</span>
                                                <span
                                                    class="caption"
                                                    v-for="(service_name,index) in item.services.map(service=>service.name)"
                                                    :key="index"
                                                >{{service_name}},</span>
                                                <span class>| {{item.price}} Euro</span>
                                            </span>
                                        </v-list-item-content>
                                    </template>
                                </v-autocomplete>
                            </v-col>
                            <v-col cols="5" class="py-0">
                                <v-autocomplete
                                    :error-messages="saving_job_errors.client_id"
                                    :items="data_autofill.clients"
                                    autofocus
                                    clear-icon="mdi-close"
                                    clearable
                                    height="2.1rem"
                                    hide-details
                                    hide-selected
                                    item-text="name"
                                    item-value="id"
                                    label="Zgjidh klientin egzistues: *"
                                    no-data-text="Nuk ka te dhena"
                                    v-model="select_client"
                                >
                                    <template v-slot:selection="{attr,on,item,selected}">
                                        <span class="pt-1">
                                            {{item.name}} -
                                            <span class="caption">{{item.city}}</span>
                                        </span>
                                    </template>
                                    <template v-slot:item="{ item }">
                                        <v-list-item-avatar
                                            class="headline font-weight-light white--text text-uppercase"
                                            color="indigo"
                                        >
                                            {{
                                            item.name.charAt(0)
                                            }}
                                        </v-list-item-avatar>
                                        <v-list-item-content>
                                            <v-list-item-title v-text="item.name"></v-list-item-title>
                                            <v-list-item-subtitle v-text="item.city"></v-list-item-subtitle>
                                        </v-list-item-content>
                                    </template>
                                </v-autocomplete>
                            </v-col>
                                                             <v-col cols="2">
                                <v-btn block text class="mt-1">Shto klient te ri</v-btn>
                            </v-col>
                        </v-row>
                        <v-row class="py-2">
                            <v-col cols="7" >
                                <v-text-field
                                    :error-messages="saving_job_errors.name"
                                    label="Emri: *"
                                    v-model="new_resource.name"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="3">
                                <v-text-field
                                    :error-messages="saving_job_errors.price"
                                    label="Cmimi: *"
                                    v-model="new_resource.price"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="10" class="py-0">
                                <v-text-field
                                    :error-messages="saving_job_errors.description"
                                    label="Te dhena shtese: *"
                                    v-model="new_resource.description"
                                ></v-text-field>
                            </v-col>

                            <v-col cols="10" class="py-0">
                                                                <v-autocomplete
                                    :error-messages="saving_job_errors.description"
                                    :label="`Eventet (Gjithsej ${events.length} evente)`"
                                    :value="events.map(ev=>ev.id)"
                                    :items="events"
                                    item-text="name"
                                    item-value="id"
                                    chips
                                    readonly
                                    multiple
                                >


                                </v-autocomplete>

                            </v-col>
                                                <v-col cols="2">
                                <v-btn block text class="mt-1">Shto event</v-btn>
                            </v-col>
                        </v-row>    
 

                    </v-card>
 

                    <v-row class="mt-3">
                        <v-col cols="2" class="pt-0 pr-5" v-if="current_step!=1">
                            <v-btn
                                :disabled="current_step<completed_step"
                                @click="previous_step()"
                                color="primary"
                                block
                                small
                                outlined
                            >Pas</v-btn>
                        </v-col>

                        <div class="flex-grow-1"></div>

                        <v-col cols="2" class="pt-0 pr-5" v-if="current_step>1">
                            <v-btn @click="next_step()" color="warning" block small outlined>Anulo</v-btn>
                        </v-col>
                        <v-col cols="3" class="pt-0 pr-5">
                            <v-btn
                                :disabled="completed_step<2"
                                @click="next_step()"
                                color="success"
                                block
                                small
                            >Perfundo</v-btn>
                        </v-col>
                    </v-row>
                </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";
import FormEventCard from "@/js/pages/job/form_job_event_card.vue";

import { mapFields } from "vuex-map-fields";

export default {
    components: {
        FormEventCard
    },
    data() {
        return {
            current_step: 3,
            completed_step: 0,

            // step 1
            new_resource: {
                name: "",
                description: "",
                price: "",
                payment_status: "none",
                status: "creating",
                client_id: "",
                offer_id: "",
                deleted_at: ""
            },
            saving_errors: [],
            saving_job_errors: [],

            // step 2
            events: [],
            date_picker: false,
            time_picker: false,
            date: "",
            time: "",
            saving_event_errors: [],
            new_event_section_color: "orange lighten-5",

            new_event: {
                id: "",
                name: "",
                address: "",
                status: "",
                description: "",
                date_start: "",
                duration_hours: "",
                deleted_at: ""
            }
        };
    },
    computed: {
        ...mapFields({
            data_autofill: "data_autofill"

            // notification:"notification",
        }),
        select_offer: {
            get: function() {
                return this.new_resource.offer_id;
            },
            set: function(id) {
                this.new_resource.offer_id = id;
                if (id != null) {
                    this.new_resource.offer_id = id;
                    let price = this.data_autofill.offers.filter(
                        offer => offer.id == id
                    )[0].price;

                    this.new_resource.price = price;
                }
            }
        },
        select_client: {
            get: function() {
                return this.new_resource.client_id;
            },
            set: function(id) {
                this.new_resource.client_id = id;
                if (id != null) {
                    this.new_resource.client_id = id;
                    let client_name = this.data_autofill.clients.filter(
                        client => client.id == id
                    )[0].name;
                    moment.locale("sq");
                    this.new_resource.name =
                        client_name + " " + moment().format("MMMM YYYY");
                }
            }
        },
        date_picker_formated_date() {
            moment.locale("sq");
            return this.date
                ? moment(this.date).format("D MMMM  YYYY, dddd")
                : "";
        }
    },
    methods: {
        next_step() {
            if (this.current_step == 1) {
                if (this.completed_step >= 1) {
                    this.current_step = 2;
                    return;
                }
                this.submit_job();
            }
            if (this.current_step == 2) {
                if (this.completed_step >= 2) {
                    this.current_step = 3;
                    return;
                }
                // this.current_step = this.current_step + 1;
                this.new_event();
            }
            if (this.current_step == 3) {
                this.current_step = this.current_step + 1;
            }
        },
        previous_step() {
            this.current_step = this.current_step - 1;
        },
        submit_job() {
            let currentObj = this;

            // console.log(data);

            axios
                .post(`/job`, currentObj.new_resource)
                .then(function(resp) {
                    currentObj.saving_job_errors = false;
                    currentObj.new_resource = resp.data.job;
                    currentObj.completed_step = 1;
                    currentObj.current_step = 2;

                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Klienti u krijua!"
                    });
                })
                .catch(function(resp) {
                    console.log(resp.data);

                    currentObj.saving_job_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Te dhenat nuk u ruajten"
                    });
                });
        },

        save_new_event: function() {
            let currentObj = this;
            let dt_date_start = "";
            //nese nuk jane dhene edhe data edhe koha
            if (currentObj.time != "" && currentObj.date != "") {
                dt_date_start = moment(
                    new Date(currentObj.date + " " + currentObj.time)
                ).format("YYYY-MM-DD HH:mm:ss");
            }
            currentObj.new_event.job_id = currentObj.new_resource.id;
            currentObj.new_event.date_start = dt_date_start;
            currentObj.new_event.status = "creating_job";
            currentObj.new_event.deleted_at = moment(new Date()).format(
                "YYYY-MM-DD HH:mm:ss"
            );

            axios
                .post(`/event`, currentObj.new_event)
                .then(function(resp) {
                    currentObj.saving_event_errors = [];
                    if(currentObj.completed_step < 2){
                        currentObj.completed_step = 2;
                    }
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Eventi u krijua!"
                    });

                    currentObj.events.push(resp.data.event);
                    currentObj.time = "";
                    currentObj.date = "";
                    currentObj.new_event = {
                        name: "",
                        address: "",
                        status: "",
                        description: "",
                        date_start: "",
                        duration_hours: "",
                        deleted_at: ""
                    };
                })
                .catch(function(resp) {
                    currentObj.saving_event_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Eventi nuk u ruajt."
                    });
                });
        },
        submit_data: function() {
            let currentObj = this;
            /* Create new object with properties from fileds, ONLY if field has a value.(remove properties with empty fileds) This to comply with vlidation rules in
            CreateInventoryRequest, for attributes where validation "sometimes" is set.
            
            */
            let data = {};
            Object.keys(currentObj.new_inventory).forEach(function(prop) {
                if (currentObj.new_inventory[prop] != "") {
                    return (data[prop] = currentObj.new_inventory[prop]);
                }
            });

            // console.log(data);

            axios
                .post(`/job`, data)
                .then(function(resp) {
                    currentObj.saving_errors = false;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Klienti u krijua!"
                    });
                    currentObj.$router.push(
                        `/inventory/${resp.data.new_inventory_id}`
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
        formatedDate(date) {
            moment.locale("sq");
            return moment(date).format("D MMMM  YYYY, dddd");
        },
        duration_hours(start, end) {
            return moment(end).diff(moment(start), "hours", true);
        }
    },
    beforeMount: function() {
        let currentObj = this;
        axios
            .get("/job/create")
            .then(function(resp) {
                // console.log(resp.data);

                currentObj.data_autofill = resp.data.data_autofill;

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
