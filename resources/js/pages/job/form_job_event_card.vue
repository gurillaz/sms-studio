<template>
    <v-col cols="6">
        <v-card tile class="pb-3 pt-1 px-5" :color="color">
            <v-container fluid class="py-0">
                <v-row class="px-2 pb-0 mt-3 mb-3">
                    <div>
                        <v-icon left>mdi-calendar</v-icon>
                        <span class="text-uppercase font-weight-bold">Event</span>
                    </div>
                    <div class="flex-grow-1"></div>

                    <v-btn text color="warning" class="pr-0" @click="deleteEvent" :disabled="job_saved">Fshij</v-btn>
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
                        <v-text-field :value="event.address" label="Adresa:" readonly class="pt-0"></v-text-field>
                    </v-col>
                </v-row>
                <v-row class="py-0">
                    <v-col cols="6" class="py-0">
                        <v-text-field
                            :value="formatedDate"
                            label="Data e eventit:"
                            readonly
                            class="pt-0"
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6" class="py-0">
                        <v-text-field
                            :value="`${duration_hours} ore`"
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
</template>

<script>
import { mapFields } from "vuex-map-fields";
import moment from "moment";

export default {
    name: "FormEventCard",

    props: ["event"],

    data() {
        return {
            elevation: false,
            color: "orange  lighten-4"
        };
    },
    methods: {
        deleteEvent() {
            if (confirm("Konfirmo fshirjen e eventit.")) {
                this.events = this.events.filter(
                    ev => ev.temp_id !== this.event.temp_id
                );
            }
        }
    },
    computed: {
        ...mapFields({
            events: "form_new_job_data.events",
            job_saved: "form_new_job_data.job_saved"
             
        }),
        formatedDate() {
            moment.locale("sq");
            return moment(this.event.date_start).format("D MMMM  YYYY, dddd");
        },
        duration_hours() {
            return moment(this.event.date_end).diff(
                moment(this.event.date_start),
                "hours",
                true
            );
        }
    }
};
</script>
