<template>
    <div class="mx-3">
        <v-card>
            <v-card-title>
                <v-icon left>mdi-account-plus</v-icon>Shto pune te re
                <div class="flex-grow-1"></div>
            </v-card-title>
            <v-container>
                <v-row class="mx-5">
                    <v-container class="pa-1">
                        <v-card outlined tile class="py-5 px-8">
                            <!-- titulli -->
                            <span class="text-uppercase">Te dhenat baze</span>

                            <v-row class="py-0">
                                <v-col cols="10">
                                    <v-autocomplete
                                        :error-messages="saving_errors.offer_id"
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
                                        :error-messages="saving_errors.client_id"
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
                                <v-col cols="4">
                                    <v-text-field
                                        :error-messages="saving_errors.name"
                                        label="Emri: *"
                                        v-model="new_resource.name"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        :error-messages="saving_errors.price"
                                        label="Cmimi: *"
                                        v-model="new_resource.price"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        :error-messages="saving_errors.payment_upfront"
                                        label="Parapagim (Kapare):"
                                        v-model="new_resource.payment_upfront"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="10">
                                    <v-text-field
                                        :error-messages="saving_errors.description"
                                        label="Te dhena shtese: "
                                        v-model="new_resource.description"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-card>
                    </v-container>
                </v-row>
                <v-row class="mx-5">
                    <v-container class="pa-1">
                        <v-card outlined tile class="py-5 px-8 mt-3">
                            <!-- titulli -->
                            <v-row class="px-2 mb-3">
                                <v-col cols="2" class="pt-0 pl-0">
                                    <span class="text-uppercase">Shto eventet</span>
                                </v-col>
                                <div class="flex-grow-1"></div>
                                <v-col cols="2" class="pt-0">
                                    <v-btn block color="primary" dark @click="add_event">Shto event</v-btn>
                                </v-col>
                            </v-row>
                            <!-- body -->

                            <v-row>
                                <!-- {{events}} -->
                                <v-col cols="12" v-if="events.length == 0">
                                    <p
                                        class="py-5 text-center headline red--text text--lighten-2"
                                    >Nuk ka evente te ruajtura. Duhet te kete te pakten nje event te ruajtur.</p>
                                </v-col>
                                <v-col cols="12" v-else>
                                    <v-row>
                                        <v-col
                                            cols="12"
                                            v-for="(event,index) in events"
                                            :key="index"
                                        >
                                            <v-card
                                                :outlined="event.saved==false"
                                                flat
                                                :color="event.saved?'green lighten-4':''"
                                                class="pb-3 pt-1 px-5"
                                            >
                                                <v-container fluid class="py-0">
                                                    <v-row class="px-2 pb-0 mt-3 mb-3">
                                                        <div>
                                                            <v-icon left>mdi-calendar</v-icon>
                                                            <span
                                                                :class="`text-uppercase font-weight-bold ${event.saved?'green--text':'red--text'}`"
                                                            >Eventi {{events.length-index}}</span>
                                                        </div>
                                                        <div class="flex-grow-1"></div>
                                        
                                                    </v-row>

                                                    <v-row class="py-0">
                                                        <v-col class="py-0" cols="4">
                                                            <v-text-field
                                                                :error-messages="event.saving_errors.name"
                                                                label="Emri: *"
                                                                required
                                                                v-model="event.name"
                                                                :readonly="event.saved"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col class="py-0" cols="6">
                                                            <v-text-field
                                                                :error-messages="event.saving_errors.address"
                                                                hint="Adresa te jete sa me e detajuar"
                                                                label="Adresa: *"
                                                                persistent-hint
                                                                v-model="event.address"
                                                                :readonly="event.saved"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col class="text-left py-0" cols="2">
                                                            <small>*duhet te plotesohen</small>
                                                        </v-col>
                                                    </v-row>
                                                    <v-row class="py-0">
                                                        <v-col class="py-0" cols="4">
                                                            <!--                                    <v-text-field v-model="new_event.date" label="Data e eventit*"></v-text-field>-->

                                                            <v-menu
                                                                :close-on-content-click="false"
                                                                max-width="290"
                                                                v-model="event.date_picker"
                                                                :readonly="event.saved"
                                                            >
                                                                <template v-slot:activator="{ on }">
                                                                    <v-text-field
                                                                        :error-messages="event.date == '' ? event.saving_errors.date_start:[]"
                                                                        :value="event.formated_date"
                                                                        label="Data e eventit*"
                                                                        readonly
                                                                        v-on="on"
                                                                    ></v-text-field>
                                                                </template>
                                                                <v-date-picker
                                                                    :min="new Date().toISOString().substr(0, 10)"
                                                                    @change="()=>{format_picked_date(event), event.date_picker = false}"
                                                                    v-model="event.date"
                                                                ></v-date-picker>
                                                            </v-menu>
                                                        </v-col>

                                                        <v-col class="py-0" cols="3">
                                                            <!--                                    <v-text-field v-model="new_event.date" label="Data e eventit*"></v-text-field>-->

                                                            <v-menu
                                                                :close-on-content-click="false"
                                                                :nudge-right="40"
                                                                :return-value.sync="event.time"
                                                                max-width="290px"
                                                                min-width="290px"
                                                                offset-y
                                                                ref="menu"
                                                                v-model="event.time_picker"
                                                                :readonly="event.saved"
                                                            >
                                                                <template v-slot:activator="{ on }">
                                                                    <v-text-field
                                                                        :error="event.saving_errors.date_start!=null &&event.time == '' "
                                                                        label="Fillon ne ora*"
                                                                        readonly
                                                                        v-model="event.time"
                                                                        v-on="on"
                                                                        :readonly="event.saved"
                                                                    ></v-text-field>
                                                                </template>
                                                                <v-time-picker
                                                                    @click:minute="$refs.menu[index].save(event.time)"
                                                                    format="24hr"
                                                                    full-width
                                                                    scrollable
                                                                    v-if="event.time_picker"
                                                                    v-model="event.time"
                                                                ></v-time-picker>
                                                            </v-menu>
                                                        </v-col>

                                                        <v-col class="py-0" cols="3">
                                                            <v-text-field
                                                                :error-messages="event.saving_errors.duration_hours"
                                                                hint="Kohezgjatja e evenitit ne ore"
                                                                label="Kohezgjatja e eventit*"
                                                                persistent-hint
                                                                required
                                                                v-model="event.duration_hours"
                                                                :readonly="event.saved"
                                                            ></v-text-field>
                                                        </v-col>
                                                               <v-col class="text-right" cols="2">
                                                            <v-btn
                                                                @click="delete_event(event)"
                                                                color="red"
                                                                outlined
                                                                block
                                                                small
                                                            >Fshij eventin</v-btn>
                                                        </v-col>
                                                    </v-row>
                                                    <v-row class="py-0">
                                                        <v-col class="py-0" cols="10">
                                                            <v-text-field
                                                                :error-messages="event.saving_errors.description"
                                                                label="Detaje"
                                                                required
                                                                v-model="event.description"
                                                                :readonly="event.saved"
                                                            ></v-text-field>
                                                        </v-col>
                                                        <v-col class="text-right" cols="2">
                                                            <v-btn
                                                                @click="save_new_event(event)"
                                                                color="primary"
                                                                outlined
                                                                block
                                                                small
                                                                :disabled="event.saved"
                                                            >Ruaj eventin</v-btn>
                                                        </v-col>
                                                    </v-row>
                                                </v-container>
                                            </v-card>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-card>
                    </v-container>
                </v-row>

                <v-row class="mx-1 mt-10">
                    <div class="flex-grow-1"></div>

                    <v-col cols="9" class="pt-0 px-5">
                        <v-btn
                            :disabled="events.length == 0"
                            @click="submit_data"
                            color="primary"
                            block
                            outlined
                        >Ruaj te dhenat dhe printo kontraten</v-btn>
                    </v-col>
                    <v-col cols="3" class="pt-0 pr-5">
                        <v-btn
                            :disabled="events.filter(event=>event.saved==true).length == 0"
                            @click="submit_data"
                            color="success"
                            block
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
import FormEventCard from "@/js/pages/job/form_job_event_card.vue";

import { mapFields } from "vuex-map-fields";

export default {
    components: {
        FormEventCard
    },
    data() {
        return {
            // step 1
            new_resource: {
                name: "",
                description: "",
                price: "",
                payment_status: "none",
                payment_upfront: 0,
                status: "creating",
                client_id: "",
                events: [],
                offer_id: "",
                deleted_at: ""
            },
            saving_errors: [],

            // step 2
            events: [],

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
                    let offer = this.data_autofill.offers.filter(
                        ofr => ofr.id == id
                    )[0];
                    this.new_resource.price = offer.price;
                    offer.services.forEach(service => {
                        this.events.push({
                            id: "",
                            name: service.name,
                            address: "",
                            status: "",
                            date_picker: false,
                            time_picker: false,
                            date: "",
                            time: "",
                            description: "",
                            date_start: "",
                            duration_hours: "",
                            deleted_at: "",
                            saved: false,
                            saving_errors: []
                        });
                    });
                } else {
                    this.new_resource.offer_id = "";
                    this.new_resource.price = "";
                    this.events = [];
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
        date_picker_formated_date(date) {
            moment.locale("sq");
            return date ? moment(date).format("D MMMM  YYYY, dddd") : "";
        }
    },
    methods: {
        delete_event(event) {
            this.events.pop(event)
        },
        add_event(event) {
            this.events.unshift({
                id: "",
                name: "",
                address: "",
                status: "",
                date_picker: false,
                time_picker: false,
                date: "",
                time: "",
                description: "",
                date_start: "",
                duration_hours: "",
                deleted_at: "",
                saved: false,
                saving_errors: []
            });
        },
        format_picked_date(event) {
            moment.locale("sq");
            event.formated_date = event.date
                ? moment(event.date).format("D MMMM  YYYY, dddd")
                : "";
        },

        save_new_event: function(event) {
            let currentObj = this;
            let dt_date_start = "";
            //nese nuk jane dhene edhe data edhe koha
            if (event.time != "" && event.date != "") {
                dt_date_start = moment(
                    new Date(event.date + " " + event.time)
                ).format("YYYY-MM-DD HH:mm:ss");
            }
            event.date_start = dt_date_start;
            event.status = "creating_job";
            event.deleted_at = moment(new Date()).format("YYYY-MM-DD HH:mm:ss");

            axios
                .post(`/event`, event)
                .then(function(resp) {
                    event.saving_errors = [];
                    event.id = resp.data.event.id;
                    event.saved = true;

                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Eventi u krijua!"
                    });
                })
                .catch(function(resp) {
                    event.saving_errors = resp.response.data.errors;
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
            currentObj.new_resource.events = currentObj.events.map(
                event => event.id
            );
            // console.log(data);

            axios
                .post(`/job`, currentObj.new_resource)
                .then(function(resp) {
                    currentObj.saving_errors = false;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Te dhenat u ruajten!"
                    });
                    currentObj.$router.push(`/job/${resp.data.job.id}`);
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
