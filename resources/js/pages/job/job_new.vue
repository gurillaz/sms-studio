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
                                <v-col cols="7">
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
                                <v-col cols="12">
                                    <v-text-field
                                        :error-messages="saving_errors.description"
                                        label="Te dhena shtese: *"
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
                                <div>
                                    <span class="text-uppercase">Shto eventet</span>
                                </div>
                                <div class="flex-grow-1"></div>
                            </v-row>
                            <!-- body -->
                            <v-row class="py-0">
                                <v-col class="py-0" cols="4">
                                    <v-text-field
                                        :error-messages="saving_event_errors.name"
                                        label="Emri: *"
                                        required
                                        v-model="new_event.name"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-0" cols="6">
                                    <v-text-field
                                        :error-messages="saving_event_errors.address"
                                        hint="Adresa te jete sa me e detajuar"
                                        label="Adresa: *"
                                        persistent-hint
                                        v-model="new_event.address"
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
                                        v-model="date_picker"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                :error-messages="date == '' ? saving_event_errors.date_start:[]"
                                                :value="date_picker_formated_date"
                                                label="Data e eventit*"
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
                                        required
                                        v-model="new_event.duration_hours"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-0" cols="2"></v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col class="py-0" cols="10">
                                    <v-text-field
                                        :error-messages="saving_event_errors.description"
                                        label="Detaje"
                                        required
                                        v-model="new_event.description"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="text-right" cols="2">
                                    <v-btn
                                        @click="save_new_event"
                                        color="primary"
                                        outlined
                                        block
                                    >Ruaj eventin</v-btn>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" v-if="events.length == 0">
                                    <p
                                        class="py-5 text-center headline red--text text--lighten-2"
                                    >Nuk ka evente te ruajtura. Duhet te kete te pakten nje event te ruajtur.</p>
                                </v-col>
                                <v-col cols="12" v-else>
                                    <v-container>
                                        <v-row>
                                            <v-col
                                                cols="6"
                                                v-for="(event,index) in events"
                                                :key="index"
                                            >
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
                            :disabled="events.length == 0"
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
                status: "creating",
                client_id: "",
                events: [],
                offer_id: "",
                deleted_at: ""
            },
            saving_errors: [],

            // step 2
            events: [],
            date_picker: false,
            time_picker: false,
            date: "",
            time: "",
            saving_event_errors: [],

            new_event: {
                id: "",
                name: "",
                address: "",
                status: "",
                description: "",
                date_start: "",
                duration_hours: "",
                deleted_at: ""
            },
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
        save_new_event: function() {
            let currentObj = this;
            let dt_date_start = "";
            //nese nuk jane dhene edhe data edhe koha
            if (currentObj.time != "" && currentObj.date != "") {
                dt_date_start = moment(
                    new Date(currentObj.date + " " + currentObj.time)
                ).format("YYYY-MM-DD HH:mm:ss");
            }
            currentObj.new_event.date_start = dt_date_start;
            currentObj.new_event.status = "creating_job";
            currentObj.new_event.deleted_at = moment(new Date()).format(
                "YYYY-MM-DD HH:mm:ss"
            );

            axios
                .post(`/event`, currentObj.new_event)
                .then(function(resp) {
                    currentObj.saving_event_errors = [];

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
           currentObj.new_resource.events = currentObj.events.map(event=>event.id);
            // console.log(data);

            axios
                .post(`/job`, currentObj.new_resource)
                .then(function(resp) {
                    currentObj.saving_errors = false;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Te dhenat u ruajten!"
                    });
                    currentObj.$router.push(
                        `/job/${resp.data.job.id}`
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
