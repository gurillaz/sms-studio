<template>
    <v-container class="mx-1" style="min-height: 55vh">
        <v-card outlined class="py-5 px-8" :color="new_event_section_color">
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
                        :error-messages="new_event.name== '' ? saving_errors.name:[]"
                        label="Emri*"
                        prepend-icon="mdi-account-card-details-outline"
                        required
                        v-model="new_event.name"
                    ></v-text-field>
                </v-col>
                <v-col class="py-0" cols="7">
                    <v-text-field
                        :error-messages="new_event.address== '' ? saving_errors.address:[]"
                        hint="Adresa te jete sa me e detajuar"
                        label="Adresa*"
                        persistent-hint
                        prepend-icon="mdi-map-marker-outline"
                        v-model="new_event.address"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row class="py-0">
                <v-col class="py-0" cols="4">
                    <!--                                    <v-text-field v-model="new_event.date" label="Data e eventit*"></v-text-field>-->

                    <v-menu :close-on-content-click="false" max-width="290" v-model="date_picker">
                        <template v-slot:activator="{ on }">
                            <v-text-field
                                :error-messages="date == '' ? saving_errors.date_start:[]"
                                :value="formatedDate"
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
                                :error="saving_errors.date_start!=null &&time == '' "
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
                        :error-messages="new_event.duration_hours == '' ? saving_errors.duration_hours:[]"
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
                        :error-messages="new_event.description== '' ? saving_errors.description:[]"
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

        <v-row class="py-0 mt-8">
            <v-col cols="12 py-0">
                <span class="title font-weight-light">Eventet:</span>
            </v-col>

            <FormEventCard :event="event" v-bind:key="index" v-for="(event, index) in events"></FormEventCard>
        </v-row>
    </v-container>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";
import { mapFields } from "vuex-map-fields";
import FormEventCard from "@/js/pages/job/form_job_event_card.vue";

export default {
    name: "FormPart3",
    components: { FormEventCard },

    data() {
        return {
            date_picker: false,
            time_picker: false,
            date: "",
            time: "",
            saving_errors: [],
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
            events: "form_new_job_data.events"
        }),

        formatedDate() {
            moment.locale("sq");
            return this.date
                ? moment(this.date).format("D MMMM  YYYY, dddd")
                : "";
        }
    },

    methods: {
        save_new_event: function() {
            let dt_date_start = "";
            //nese nuk jane dhene edhe data edhe koha
            if (this.time != "" && this.date != "") {
                dt_date_start = moment(
                    new Date(this.date + " " + this.time)
                ).format("YYYY-MM-DD HH:mm:ss");
            }
            this.new_event.date_start = dt_date_start;
            this.new_event.status = "creating_job";
            this.new_event.deleted_at = moment(new Date()).format(
                "YYYY-MM-DD HH:mm:ss"
            );

            let currentObj = this;
            axios
                .post(`/event`, currentObj.new_event)
                .then(function(resp) {
                    currentObj.saving_errors = [];
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
                    console.log(resp.data);

                    currentObj.saving_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Eventi nuk u ruajt."
                    });
                });
        }
    }
};
</script>