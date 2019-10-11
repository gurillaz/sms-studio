<template>
    <div>
        <v-row>
            <v-col>
                <div class="subtitle text-uppercase pt-3">Eventet:</div>
            </v-col>

            <v-col class="text-right">
                <v-btn
                    text
                    dark
                    @click.stop="new_event_dialog = true"
                    color="primary"
                    class="mr-3"
                    
                >Shto event</v-btn>
            </v-col>
        </v-row>

        <!--        {{notes}}-->

        <v-row v-if="events != undefined && events.length > 0">
            <eventCard v-for="event in events" v-bind:key="event.id" :event="event"></eventCard>
        </v-row>

        <v-row v-if="events != undefined && events.length == 0">
            <v-col cols="12" class="ma-12 text-center">
                <p class="display-1 grey--text">Nuk ka evente te ruajtura</p>
            </v-col>
        </v-row>

        <v-dialog v-model="new_event_dialog" persistent max-width="70vw">
           
            <v-card color="orange lighten-5">
                <v-col cols="12">
                <v-container>
                <v-row class="px-2 mb-3">
                                 <v-icon left>mdi-calendar</v-icon>
                    <span class="text-uppercase">Eventi i ri</span>
                    <div class="flex-grow-1"></div>
                </v-row>
                <v-row>
 
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

                    <v-col cols="5">
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

                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="warning" text @click="new_event_dialog = false">Mbyll</v-btn>
                    <v-btn color="success" text @click="submit_data()">Ruaj</v-btn>
                </v-card-actions>
                </v-container>
                </v-col>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from 'moment';
import eventCard from "@/js/pages/event/event_card";

export default {
    components: { eventCard },
    props: ["events", "id"],
    name: "eventSection",
    data() {
        return {
            new_event_dialog: false,
            saving_errors: [],

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
                job_id: ""
            }
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
        delete_event(id) {
            let currentObj = this;
            if (confirm("Konfirmo fshirjen e eventit!") === false) {
                return;
            }
            axios(`/event/${id}`, {
                method: "delete"
            })
                .then(function(resp) {
                    currentObj.events = currentObj.events.filter(
                        event => event.id != id
                    );
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Eventi u fshi!"
                    });
                })
                .catch(function(resp) {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Eventi nuk u fshi!"
                    });
                });
        },
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
            this.new_event.job_id = this.id;

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
                        job_id: ""
                    };
                    currentObj.events.unshift(resp.data.event);
                    currentObj.new_event_dialog = false;
                    // currentObj.$router.push(`/event/${resp.data.event.id}`);
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

