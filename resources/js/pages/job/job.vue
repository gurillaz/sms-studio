<template>
    <div class="mx-3">
        <v-row>
            <v-col>
                <div class="headline">Puna - {{job.name}}</div>
            </v-col>

            <v-col class="text-right">
                <v-btn
                    outlined
                    color="warning"
                    class="mr-3"
                    @click.stop="edit_dialog = true"
                >Ndrysho</v-btn>
                <v-btn outlined color="error">Fshij</v-btn>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols-12>
            <v-card class="py-5 px-8" :color="job_details_section_color">
                <!-- titulli -->
                <v-row class="px-2 mb-1">
                    <div>
                        <v-icon left>mdi-calendar-plus</v-icon>
                        <span
                            class="text-uppercase font-weight-bold"
                        >Detajet per punen</span>
                    </div>
                    <div class="flex-grow-1"></div>
                </v-row>
                <!-- body -->
                <v-row class="py-0">
                    <v-col cols="6">
                        <v-row>
                            <v-col cols="12" class="py-0">
                                <v-text-field
                                    label="Emri i punes:"
                                    prepend-icon="mdi-account-card-details-outline"
                                    readonly
                                    :value="job.name"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" class="py-0">
                                <v-text-field
                                    label="Cmimi i punes:"
                                    prepend-icon="mdi-cash-multiple"
                                    readonly
                                    :value="job.price"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" class="py-0">
                                <v-text-field
                                    label="Pershkrimi:"
                                    prepend-icon="mdi-card-text-outline"
                                    readonly
                                    :value="job.description"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-col>
                    <div class="flex-grow-1"></div>
                    <v-col cols="5">
                        <v-row class="py-0">
                            <v-col class="py-0" cols="12">
                                <v-text-field
                                    :value="offer.name"
                                    label="Oferta e zgjedhur:"
                                    prepend-icon="mdi-tag"
                                    readonly
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row class="py-0">
                            <v-col class="py-0" cols="12">
                                <v-text-field
                                    :value="client.name"
                                    label="Klienti:"
                                    prepend-icon="mdi-account-outline"
                                    readonly
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row class="py-0">
                            <v-col class="py-0" cols="12">
        
                                <v-text-field
                                    :value="events.map(ev => ev.name + ' ')"
                                    prepend-icon="mdi-calendar"
                                    label="Eventet:"
                                    readonly
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card>
            </v-col>
        </v-row>

                <notesSection :notes="notes" :id="id" :class_name="class_name"></notesSection>
        <filesSection :files="files" :id="id" :class_name="class_name"></filesSection>
        <paymentsSection :payments="payments" :id="id" :class_name="class_name"></paymentsSection>


    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
    import notesSection from '@/js/pages/note/notes_section';
    import filesSection from '@/js/pages/file/files_section';
    import paymentsSection from '@/js/pages/payment/payments_section';

    export default {
        components: {notesSection,filesSection,paymentsSection},
    data() {
        return {
            job_details_section_color: "indigo lighten-5",

            id:this.$route.params.id,
  
                job: {},
                client: {},
                offer: {},
                events: [],
                files: [],
                payments: [],
                notes: [],
                class_name: "",
  

            edit_dialog: false
        };
    },
    beforeMount() {
        let currentObj = this;
        axios
            .get(`job/${currentObj.id}`)
            .then(function(resp) {
                // console.log(resp.data);
                currentObj.job = resp.data.job;
                currentObj.client = resp.data.client;
                currentObj.offer = resp.data.offer;
                currentObj.events = resp.data.events;
                currentObj.files = resp.data.files;
                currentObj.payments = resp.data.payments;
                currentObj.notes = resp.data.notes;
                currentObj.class_name = resp.data.class_name;
            })
            .catch(function(resp) {
                console.log(resp.data);
                alert("Could not load Client");
            });
    }
};
</script>