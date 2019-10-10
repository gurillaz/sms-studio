<template>
    <div class="mx-3">
        <v-card>
            <v-card-title>
                <v-icon left>mdi-account-plus</v-icon>Shto event te ri
                <div class="flex-grow-1"></div>
            </v-card-title>
            <v-row class="mx-5 mt-4">
                <v-container class="pa-1">
                    <v-card outlined tile class="py-5 px-8">
                        <!-- titulli -->
                        <v-row class="px-2 mb-3">
                            <span class="text-uppercase">Te dhenat e punes</span>
                            <div class="flex-grow-1"></div>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-select
                                    :error-messages="saving_errors.job_id"
                                    label="I takon punes: *"
                                    :items="autofill_data.jobs"
                                    item-text="name"
                                    item-value="id"
                                    v-model="new_event.job_id"
                                ></v-select>
                            </v-col>
                            <v-col cols="5">
                                <v-text-field
                                    :error-messages="saving_errors.name"
                                    label="Emri*"
                                    required
                                    v-model="new_event.name"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="7">
                                <v-text-field
                                    :error-messages="saving_errors.address"
                                    hint="Adresa te jete sa me e detajuar"
                                    label="Adresa*"
                                    persistent-hint
                                    v-model="new_event.address"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="4">
                                <!--                                    <v-text-field v-model="new_event.date" label="Data e eventit*"></v-text-field>-->

                                <v-menu
                                    :close-on-content-click="false"
                                    max-width="290"
                                    v-model="date_picker"
                                >
                                    <template v-slot:activator="{ on }">
                                        <v-text-field
                                            :error-messages="date == '' ? saving_errors.date_start:[]"
                                            :value="formatedDate"
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

                            <v-col cols="3">
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
                                            :error="saving_errors.date_start!=null &&time == '' "
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

                            <v-col cols="3">
                                <v-text-field
                                    :error-messages="new_event.duration_hours == '' ? saving_errors.duration_hours:[]"
                                    hint="Kohezgjatja e evenitit ne ore"
                                    label="Kohezgjatja e eventit*"
                                    persistent-hint
                                    required
                                    v-model="new_event.duration_hours"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2"></v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    :error-messages="new_event.description== '' ? saving_errors.description:[]"
                                    label="Detaje"
                                    required
                                    v-model="new_event.description"
                                ></v-text-field>
                            </v-col>
                        </v-row>

                        <v-row>
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
            time_picker: false,
            date: "",
            time: "",
            autofill_data: {
                jobs: []
            },
            new_event: {
                id: "",
                name: "",
                address: "",
                status: "",
                description: "",
                date_start: "",
                duration_hours: "",
                job_id:''
            },
            saving_errors: [],

        };
    },
    computed: {
        formatedDate() {
            moment.locale("sq");
            return this.date
                ? moment(this.date).format("D MMMM  YYYY, dddd")
                : "";
        }
    },
    methods: {
        submit_data: function() {
            let dt_date_start = "";
            //nese nuk jane dhene edhe data edhe koha
            if (this.time != "" && this.date != "") {
                dt_date_start = moment(
                    new Date(this.date + " " + this.time)
                ).format("YYYY-MM-DD HH:mm:ss");
            }
            this.new_event.date_start = dt_date_start;
            this.new_event.status = "active";

            let currentObj = this;
            axios
                .post(`/event`, currentObj.new_event)
                .then(function(resp) {
                    currentObj.saving_errors = [];
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Eventi u krijua!"
                    });

                    currentObj.time = "";
                    currentObj.date = "";
                    currentObj.new_event = {
                        id: "",
                        name: "",
                        address: "",
                        status: "",
                        description: "",
                        date_start: "",
                        duration_hours: "",
                        job_id:''
                    };
                    currentObj.$router.push(`/event/${resp.data.event.id}`)
                })
                .catch(function(resp) {
                    console.log(resp.data);

                    currentObj.saving_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Eventi nuk u ruajt."
                    });
                });
        }
    },
    beforeMount: function() {
        let currentObj = this;
        axios
            .get("/event/create")
            .then(function(resp) {
                // console.log(resp.data);

                currentObj.autofill_data = resp.data.autofill_data;

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
