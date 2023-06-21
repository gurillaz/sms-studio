<template>
    <div class="mx-3">
        <v-row>
            <v-col>
                <div class="headline">Oferta</div>
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
                                    <v-text-field
                                        :value="resource.name"
                                        label="Emri i ofertes:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="4" class="pt-0">
                                    <v-text-field
                                        :value="resource.price"
                                        label="Cmimi i ofertes:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col cols="12">
                                    <p
                                        class="small"
                                    >Sherbimet ({{resource_relations.services.length}} sherbime):</p>

                                    <v-chip
                                        pill
                                        v-for="(service,index) in resource_relations.services"
                                        v-bind:key="index"
                                        class="mr-2 mb-2 text-capitalize"
                                        :to="`/service/${service.id}`"
                                        target="_blank"
                                    >
                                        <v-avatar
                                            left
                                            color="orange"
                                            class="text-uppercase font-weight-bold white--text"
                                        >{{service.name.substring(0,1)}}</v-avatar>
                                        {{service.name}}
                                    </v-chip>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col cols="12">
                                    <v-text-field
                                        :value="resource.description"
                                        label="Te dhenat tjera:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <relatedDataTables title="Te dhenat tjera" :relations="resource_relations"></relatedDataTables>

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
                        <!-- titulli -->
                        <span class="text-uppercase">Te dhenat per oferten</span>

                        <v-row class="py-5">
                            <v-col class="py-1" cols="10">
                                <v-autocomplete
                                    :error-messages="saving_errors.services"
                                    label="Sherbimet:"
                                    v-model="edit_resource.services"
                                    :items="data_autofill.services"
                                    item-text="name"
                                    item-value="id"
                                    multiple
                                    chips
                                    deletable-chips
                                    hide-selected
                                    hint="Zgjidh nga sherbimet egzistuese."
                                    persistent-hint
                                ></v-autocomplete>
                            </v-col>
                            <v-col class="py-1" cols="2">
                                <v-btn
                                    block
                                    text
                                    color="primary"
                                    class="mt-5"
                                    @click="new_service_dialog = true"
                                >Shto sherbim te ri</v-btn>
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
                                    hint="Cmimi i ofertes. Kliko 'Kalkulo cmimin', per cmimin e ofertes ne baze te sherbimeve te zgjedhura."
                                    persistent-hint
                                ></v-text-field>
                            </v-col>
                            <v-col class="py-1" cols="2">
                                <v-btn
                                    block
                                    text
                                    class="mt-5"
                                    @click="calculate_offer_price()"
                                    :disabled="edit_resource.services.length==0"
                                >Kalkulo cmimin</v-btn>
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
        <v-dialog v-model="new_service_dialog" persistent max-width="75vw">
            <v-card>
                <v-card-title>
                    <span class="headline pl-3">Shto sherbim te ri</span>
                    <div class="flex-grow-1"></div>
                </v-card-title>
                <v-card-text>
                    <v-container class="pa-1">
                        <v-card outlined tile class="py-5 px-8">
                            <!-- titulli -->
                            <span class="text-uppercase">Te dhenat per sherbimin</span>

                            <v-row class="mt-1">
                                <v-col class="py-1" cols="6">
                                    <v-text-field
                                        :error-messages="new_service_errors.name"
                                        label="Emri i sherbimit: *"
                                        v-model="new_service.name"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-1" cols="4">
                                    <v-text-field
                                        :error-messages="new_service_errors.price"
                                        label="Cmimi: *"
                                        v-model="new_service.price"
                                        hint="Cmimi i sherbimit."
                                        persistent-hint
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col class="py-1" cols="12">
                                    <v-text-field
                                        :error-messages="new_service_errors.description"
                                        label="Te dhena shtese:"
                                        v-model="new_service.description"
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
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn @click="new_service_dialog = false" color="warning" text>Mbyll</v-btn>
                    <v-btn @click="submit_new_service_data()" color="success" text>Ruaj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment, { now } from "moment";
import notesSection from "@/js/pages/note/notes_section";
import filesSection from "@/js/pages/file/files_section";
import relatedDataTables from "@/js/pages/others/related_data_tables";

import { mapFields } from "vuex-map-fields";
import { mapActions } from "vuex";

export default {
    components: { notesSection, filesSection, relatedDataTables },
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
                services: [],
                price: "",
                description: "",
                created_by: {
                    id: "",
                    name: ""
                }
            },
            resource: {
                id: "",
                name: "",
                service: [],
                price: "",
                description: "",
                created_by: {
                    id: "",
                    name: ""
                }
            },
            resource_relations: {
                services: [],
                notes: []
            },

            new_service_dialog: false,
            new_service: {
                name: "",
                description: "",
                price: ""
            },
            new_service_errors: []
        };
    },
    computed: {
        ...mapFields({
            data_autofill: "data_autofill",
            auth: "auth",
            snackBar: "snackbar"
            // notification:"notification",
        }),
        get_employees_names() {
            let names = [];
            let counter = 1;
            this.edit_resource.tasks.forEach(task_id => {
                names.push(`Puntori ${counter}`);
                counter++;
            });
            return names;
        },
        get_inventory_names() {
            let inventory = [];
            // return [];
            this.data_autofill.tasks.forEach(task => {
                if (this.edit_resource.tasks.includes(task.id)) {
                    task.inventory.forEach(inv => {
                        inventory.push(inv);
                    });
                }
            });

            return inventory;
        }
    },
    beforeMount() {
        var currentObj = this;
        axios
            .get(`/offer/${currentObj.id}`)
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
                    "services"
                ] = currentObj.resource_relations.services.map(
                    service => service.id
                );
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
        ...mapActions({
            notification: "showSnackbar" // map `this.add()` to `this.$store.dispatch('increment')`
        }),
        calculate_offer_price() {
            let price = 0;
            this.data_autofill.services
                .filter(serv => this.edit_resource.services.includes(serv.id))
                .forEach(service => {
                    price = price + Number(service.price);
                });
            if (price == 0) {
                this.edit_resource.price = "";
            }
            this.edit_resource.price = price;
        },

        get_all_tasks_inventory(tasks) {
            let inventory = [];
            tasks.forEach(task => {
                task.inventory.forEach(inv => {
                    inventory.push(inv);
                });
            });
            return inventory;
        },
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
        submit_new_service_data: function() {
            let currentObj = this;

            axios
                .post(`/service`, currentObj.new_service)
                .then(function(resp) {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Te dhenat u ruajten!"
                    });
                    // console.log(resp.data.resource)
                    currentObj.new_service_errors = [];
                    currentObj.new_service = {
                        name: "",
                        description: "",
                        price: ""
                    };
                    currentObj.edit_resource.services.push(
                        resp.data.resource.id
                    );
                    currentObj.data_autofill.services.push(resp.data.resource);
                    currentObj.new_service_dialog = false;
                })
                .catch(function(resp) {
                    // console.log(resp.data);

                    currentObj.new_service_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Te dhenat nuk u ruajten"
                    });
                });
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
                .put(`/offer/${currentObj.id}`, data)
                .then(function(resp) {
                    currentObj.saving_errors = [];
                    currentObj.edit_dialog = false;
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
                        "services"
                    ] = currentObj.resource_relations.services.map(
                        service => service.id
                    );
                    currentObj.edit_resource = JSON.parse(
                        JSON.stringify(currentObj.edit_resource)
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