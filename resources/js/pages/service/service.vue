<template>
    <div class="mx-3">
        <v-row>
            <v-col>
                <div class="headline">Sherbimi</div>
            </v-col>

            <v-col class="text-right">
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
                                <v-col cols="4">
                                    <v-text-field
                                        :value="readable_date(resource.created_at, resource.updated_at)"
                                        label="Shtuar me date:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        :value="resource.created_by.name"
                                        label="Shtuar nga:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col cols="8" class="pt-0">
                                    <v-text-field :value="resource.name" label="Emri:" readonly></v-text-field>
                                </v-col>
                                <v-col cols="4" class="pt-0">
                                    <v-text-field :value="resource.price" label="Cmimi:" readonly></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col cols="12">
                                    <v-text-field
                                        :value="resource.description"
                                        label="Te dhenat tjera::"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <!-- <relatedDataTables title="Te dhenat tjera" :relations="resource_relations"></relatedDataTables> -->

        <notesSection :notes="resource_relations.notes" :id="id" :class_name="resource.class_name"></notesSection>

        <v-dialog
            v-model="edit_dialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
        >
            <v-card color="grey lighten-5">
                <v-toolbar dark color="primary">
                    <v-toolbar-title>Ndrysho te dhenat</v-toolbar-title>
                    <div class="flex-grow-1"></div>
                    <v-toolbar-items>
                        <v-btn dark text @click="edit_dialog = false">Mbyll</v-btn>
                        <v-btn dark text @click="update_resource()">Ruaj</v-btn>
                    </v-toolbar-items>
                </v-toolbar>

                <v-container class="pa-1 mt-10">
                    <v-card outlined tile class="py-5 px-8">
                        <span class="text-uppercase">Te dhenat per sherbimin</span>
                        <v-row class="py-0">
                            <v-col cols="4">
                                <v-text-field
                                    :value="readable_date()"
                                    label="Shtuar me date:"
                                    disabled
                                ></v-text-field>
                            </v-col>
                            <v-col cols="3">
                                <v-text-field
                                    :value="resource.created_by.name"
                                    label="Shtuar nga:"
                                    disabled
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row class="mt-1">
                            <v-col class="py-1" cols="6">
                                <v-text-field
                                    :error-messages="saving_errors.name"
                                    label="Emri: *"
                                    v-model="edit_resource.name"
                                ></v-text-field>
                            </v-col>
                            <v-col class="py-1" cols="4">
                                <v-text-field
                                    :error-messages="saving_errors.price"
                                    label="Cmimi: *"
                                    v-model="edit_resource.price"
                                    hint="Cmimi i sherbimit. Kliko 'Kalkulo cmimin', per cmimin e sherbimeve ne baze te detyrave te zgjedhura."
                                    persistent-hint
                                ></v-text-field>
                            </v-col>
              
                        </v-row>
  
   

                        <v-row class="py-0">
                            <v-col class="py-1" cols="12">
                                <v-text-field
                                    :error-messages="saving_errors.description"
                                    label="Te dhena shtese:"
                                    v-model="edit_resource.description"
                                ></v-text-field>
                            </v-col>
                        </v-row>

                        <v-row class="py-0">
                            <v-col class="text-left" cols="2">
                                <small>*duhet te plotesohen</small>
                            </v-col>
                            <div class="flex-grow-1"></div>
                        </v-row>
                    </v-card>
                </v-container>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment, { now } from "moment";
import notesSection from "@/js/pages/note/notes_section";
import filesSection from "@/js/pages/file/files_section";


import { mapFields } from "vuex-map-fields";
import { mapActions } from "vuex";

export default {
    components: { notesSection, filesSection },
    data() {
        return {
            edit_dialog: false,
            saving_errors: [],

            id: this.$route.params.id,
            class_name: "",
            status_items: [
                { text: "Aktive", value: "active" },
                { text: "Pasive", value: "pasive" }
            ],
            edit_resource: {
                id: "",
                name: "",
                preice: "",
                status: "active",
                created_by: {
                    id: "",
                    name: ""
                }
            },
            resource: {
                id: "",
                name: "",
                preice: "",
                status: "active",
                created_by: {
                    id: "",
                    name: ""
                }
            },
            resource_relations: {
                inventory: [],
                notes: [],
                tasks: []
            },


        };
    },
    computed: {
        ...mapFields({
            data_autofill: "data_autofill",
            auth: "auth",
            snackBar: "snackbar"
            // notification:"notification",
        }),

    },
    beforeMount() {
        var currentObj = this;
        axios
            .get(`/service/${currentObj.id}`)
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
                currentObj.edit_resource[
                    "tasks"
                ] = currentObj.resource_relations.tasks.map(task => task.id);
                currentObj.edit_resource = JSON.parse(
                    JSON.stringify(currentObj.edit_resource)
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

            /* Create new object with properties from fileds, ONLY if field has a value.(remove properties with empty fileds) This to comply with vlidation rules in
            CreateInventoryRequest, for attributes where validation "sometimes" is set.
            
            */
            let data = {};
            Object.keys(currentObj.edit_resource).forEach(function(prop) {
                if (
                    currentObj.edit_resource[prop] != "" ||
                    currentObj.edit_resource[prop] != null
                ) {
                    data[prop] = currentObj.edit_resource[prop];
                }
            });

            axios
                .put(`/service/${currentObj.id}`, data)
                .then(function(resp) {
                    currentObj.saving_errors = [];
                    currentObj.edit_dialog = false;
                    currentObj.resource = resp.data.resource;
                    currentObj.resource_relations =
                        resp.data.resource_relations;
                    currentObj.data_autofill = resp.data.data_autofill;
                    /* Using JSON.parse to copy object, since just asignin resp.data.note only references data
                    note end edit_note keep changing when used as vue v-model
                    Based on: https://scotch.io/bar-talk/copying-objects-in-javascript
                     */
                    currentObj.edit_resource = JSON.parse(
                        JSON.stringify(resp.data.resource)
                    );

     
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
            if (confirm("Konfirmo fshirjen e e puntorit!") === false) {
                return;
            }
            axios(`/service/${currentObj.id}`, {
                method: "delete"
            })
                .then(function(resp) {
                    currentObj.$route.go("/service");
                    this.notification({
                        color: "success",
                        text: "U fshi me sukses"
                    });
                })
                .catch(function(resp) {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Nuk u fshi, rifresko faqen!"
                    });
                });
        }
    }
};
</script>