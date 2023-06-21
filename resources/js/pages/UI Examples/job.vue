<template>
    <div class="mx-3">
        <v-row>
            <v-col>
                <div class="headline">Puna</div>
            </v-col>

            <v-col class="text-right">
                <v-btn
                    @click.stop="edit_tasks_dialog = true"
                    class="mr-3"
                    color="warning"
                    outlined
                >Cakto punet</v-btn>
                <v-btn
                    @click.stop="edit_dialog = true"
                    class="mr-3"
                    color="warning"
                    outlined
                >Ndrysho</v-btn>
                <v-btn @click="delete_resource" color="error" outlined>Fshij</v-btn>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <v-card color>
                    <v-card-title>
                        <span class="headline pl-3">{{resource.name}}</span>
                        <div class="flex-grow-1"></div>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row class="py-0">
                                <v-col cols="4" class="py-0">
                                    <v-text-field
                                        :value="readable_date(resource.created_at, resource.updated_at)"
                                        label="Shtuar me date:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="3" class="py-0">
                                    <v-text-field
                                        :value="resource.created_by.name"
                                        label="Shtuar nga:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="7" class="py-0">
                                    <v-row>
                                        <v-col cols="8" class="pt-0">
                                            <v-text-field
                                                :value="resource.name"
                                                label="Emri:"
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="4" class="pt-0">
                                            <v-text-field
                                                :value="resource.price"
                                                label="Cmimi:"
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" class="pt-0">
                                            <v-text-field
                                                :value="resource.description"
                                                label="Te dhena tjera:"
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>

                                <v-col cols="5" class="py-0">
                                    <v-row>
                                        <v-col cols="8" class="pt-0">
                                            <v-select
                                                label="Klienti:"
                                                :items="data_autofill.clients"
                                                item-text="name"
                                                item-value="id"
                                                v-model="resource.client_id"
                                                readonly
                                            ></v-select>
                                        </v-col>
                                        <v-col cols="4" class="pt-3">
                                            <v-btn
                                                block
                                                text
                                                :to="`/client/${resource.client_id}`"
                                            >Shiko klientin</v-btn>
                                        </v-col>
                                        <v-col cols="8" class="pt-0">
                                            <v-select
                                                label="Oferta:"
                                                :items="data_autofill.offers"
                                                item-text="name"
                                                item-value="id"
                                                v-model="resource.offer_id"
                                                readonly
                                            ></v-select>
                                        </v-col>
                                        <v-col cols="4" class="pt-3">
                                            <v-btn
                                                block
                                                text
                                                :to="`/offer/${resource.offer_id}`"
                                            >Shiko oferten</v-btn>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col cols="12" class="pt-0">
                                    <eventsSection :events="resource_relations.events" :id="id"></eventsSection>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <relatedDataTables title="Te dhenat tjera" :relations="resource_relations"></relatedDataTables>

        <filesSection :files="resource_relations.files" :id="id" :class_name="resource.class_name"></filesSection>
        <notesSection :notes="resource_relations.notes" :id="id" :class_name="resource.class_name"></notesSection>
        <v-dialog
            v-model="edit_tasks_dialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
        >
            <v-card color="grey lighten-5">
                <v-toolbar dark color="primary">
                    <v-toolbar-title>Cakto detyrat</v-toolbar-title>
                    <div class="flex-grow-1"></div>
                    <v-toolbar-items>
                        <v-btn dark text @click="edit_tasks_dialog = false">Mbyll</v-btn>
                        <v-btn dark text @click="edit_tasks_dialog = false">Ruaj</v-btn>
                    </v-toolbar-items>
                </v-toolbar>

                <v-container fluid class="pa-1 mt-10">
                    <v-card outlined tile class="py-5 px-8 mx-10">
                        <v-simple-table>
                            <template v-slot:default>
                                <thead>
                                    <tr>
                                        <th class="text-left">Emri</th>
                                        <th class="text-left">Puntori</th>
                                        <th class="text-left">Eventi</th>
                                        <th class="text-left">Pagesa</th>
                                        <th class="text-left">Pajisjet</th>
                                        <th class="text-left">Statusi</th>
                                        <th class="text-left">Aktiviteti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="task in resource_relations.tasks" :key="task.id">
                                        <td>{{ task.name }}</td>
                                        <td> <v-autocomplete
                                            :items="data_autofill.employees"
                                            item-text="name"
                                            item-value="id"
                                            v-model="task.employee_id"
                                        ></v-autocomplete></td>
                                        <td>                          <v-autocomplete
                                            :items="resource_relations.events"
                                            item-text="name"
                                            item-value="id"
                                            v-model="task.event_id"
                                        ></v-autocomplete></td>
                                        <td><v-text-field 
                                        v-model="task.payment_sum"
                                        ></v-text-field></td>
                                        <td>Pajisjet</td>
                                        <td>{{task.status}}</td>
                                        <td><v-btn small text color="success">Ruaj</v-btn><v-btn small text color="warning">Fshij</v-btn></td>
                                    </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                    </v-card>
                </v-container>
            </v-card>
        </v-dialog>

        <v-dialog v-model="edit_dialog" persistent max-width="75vw">
            <v-card color>
                <v-card-title>
                    <span class="headline pl-3">Ndrysho te dhenat</span>
                    <div class="flex-grow-1"></div>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row class="py-0">
                            <v-col cols="4" class="py-0">
                                <v-text-field
                                    :value="readable_date()"
                                    label="Shtuar me date:"
                                    disabled
                                ></v-text-field>
                            </v-col>
                            <v-col cols="3" class="py-0">
                                <v-text-field
                                    :value="resource.created_by.name"
                                    label="Shtuar nga:"
                                    disabled
                                ></v-text-field>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="7" class="py-0">
                                <v-row>
                                    <v-col cols="8" class="pt-0">
                                        <v-text-field
                                            :error-messages="saving_errors.name"
                                            v-model="edit_resource.name"
                                            label="Emri: *"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="4" class="pt-0">
                                        <v-text-field
                                            :error-messages="saving_errors.price"
                                            v-model="edit_resource.price"
                                            label="Cmimi: *"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" class="pt-0">
                                        <v-text-field
                                            :error-messages="saving_errors.description"
                                            v-model="edit_resource.description"
                                            label="Te dhena shtese:"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-col>

                            <v-col cols="5" class="py-0">
                                <v-row>
                                    <v-col cols="12" class="pt-0">
                                        <v-autocomplete
                                            :error-messages="saving_errors.client_id"
                                            label="Klienti: *"
                                            :items="data_autofill.clients"
                                            item-text="name"
                                            item-value="id"
                                            v-model="edit_resource.client_id"
                                        ></v-autocomplete>
                                    </v-col>

                                    <v-col cols="12" class="pt-0">
                                        <v-autocomplete
                                            :error-messages="saving_errors.offer_id"
                                            label="Klienti: *"
                                            :items="data_autofill.offers"
                                            item-text="name"
                                            item-value="id"
                                            v-model="edit_resource.offer_id"
                                        ></v-autocomplete>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col class="text-left" cols="2">
                                <small>*duhet te plotesohen</small>
                            </v-col>
                            <div class="flex-grow-1"></div>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn @click="edit_dialog = false" color="warning" text>Mbyll</v-btn>
                    <v-btn @click="update_resource()" color="success" text>Ruaj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";
import notesSection from "@/js/pages/note/notes_section";
import filesSection from "@/js/pages/file/files_section";
import paymentsSection from "@/js/pages/payment/payments_section";
import eventsSection from "@/js/pages/event/event_section";
import relatedDataTables from "@/js/pages/others/related_data_tables";


export default {
    components: { notesSection, filesSection, paymentsSection, eventsSection,relatedDataTables },
    data() {
        return {
            tab:0,
            edit_dialog: false,
            edit_tasks_dialog: false,
            saving_errors: [],

            id: this.$route.params.id,
            class_name: "",

            edit_resource: {
                id: "",
                name: "",
                price: "",
                status: "",
                description: "",

                job_id: "",

                created_at: "",
                updated_at: "",
                class_name: "",
                created_by: { name: "" }
            },
            resource: {
                id: "",
                name: "",
                price: "",
                status: "",
                description: "",

                job_id: "",

                created_at: "",
                updated_at: "",
                class_name: "",
                created_by: { name: "" }
            },
            resource_relations: {
                events: [],
                tasks: [],
                notes: [],
                payments: []
            },
            data_autofill: {
                clients: [{ id: "", name: "" }],
                offers: [{ id: "", name: "" }]
            }
        };
    },
    computed: {},

    beforeMount() {
        var currentObj = this;
        axios
            .get(`/job/${currentObj.id}`)
            .then(function(resp) {
                currentObj.resource = resp.data.resource;
                currentObj.resource_relations = resp.data.resource_relations;
                currentObj.data_autofill = resp.data.data_autofill;

                /* Using JSON.parse to copy object, since just asignin resp.data.note only references data
                    note end edit_note keep changing when used as vue v-model
                    Based on: https://scotch.io/bar-talk/copying-objects-in-javascript
                     */
                currentObj.edit_resource = JSON.parse(
                    JSON.stringify(resp.data.resource)
                );
            })
            .catch(function(resp) {
                console.log(resp);
                currentObj.$store.dispatch("showSnackbar", {
                    color: "error",
                    text: "Serveri nuk dergoi te dhenat!"
                });
            });
    },
    methods: {
        readable_date(created_at, updated_at) {
            moment.locale("sq");
            if (created_at === updated_at) {
                return moment(updated_at).format("D MMMM YYYY [ora] HH:mm");
            } else {
                return (
                    moment(updated_at).format("D MMMM YYYY [ora] HH:mm") +
                    " (E modifikuar)"
                );
            }
        },
        update_resource: function() {
            let currentObj = this;

            axios
                .put(`/job/${currentObj.id}`, currentObj.edit_resource)
                .then(function(resp) {
                    currentObj.saving_errors = [];
                    currentObj.resource = resp.data.resource;

                    /* Using JSON.parse to copy object, since just asignin resp.data.note only references data
                    note end edit_note keep changing when used as vue v-model
                    Based on: https://scotch.io/bar-talk/copying-objects-in-javascript
                     */
                    currentObj.edit_resource = JSON.parse(
                        JSON.stringify(resp.data.resource)
                    );

                    currentObj.edit_dialog = false;

                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Ndryshimet u ruajten!"
                    });
                })
                .catch(function(resp) {
                    currentObj.saving_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Ndryshimet nuk u ruajten!"
                    });
                });
        },
        delete_resource() {
            let currentObj = this;
            if (confirm("Konfirmo fshirjen e eventit!") === false) {
                return;
            }
            axios(`/event/${currentObj.id}`, {
                method: "delete"
            })
                .then(function(resp) {
                    currentObj.$router.replace("/event");
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Eventi u fshi!"
                    });
                })
                .catch(function(resp) {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Eventi nuk u fshi, rifresko faqen!"
                    });
                });
        }
    }
};
</script>