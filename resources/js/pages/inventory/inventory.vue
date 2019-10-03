<template>
    <div class="mx-3">
        <v-row>
            <v-col>
                <div class="headline">Pajisja</div>
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
                                <v-col cols="6">
                                    <v-row class="py-0">
                                        <v-col cols="6" class="py-0">
                                            <v-text-field
                                                :value="resource.price"
                                                label="Cmimi i furnizimit:"
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" class="py-0">
                                            <v-text-field
                                                :value="resource.supplier"
                                                label="Furnitori:"
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" class="py-0">
                                            <v-text-field
                                                :value="resource.purchase_date"
                                                label="E blere me date:"
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col cols="6">
                                    <v-row class="py-0">
                                        <v-col cols="12" class="py-0">
                                            <v-text-field
                                                :value="resource.type"
                                                label="Lloji:"
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" class="py-0">
                                            <v-text-field
                                                :value="resource.serial"
                                                label="Nr. Serial:"
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" class="py-0">
                                            <v-text-field
                                                :value="edit_resource.status"
                                                label="Status:"
                                                readonly
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col cols="12" class="pt-0">
                                    <v-text-field :value="resource.name" label="Emri:" readonly></v-text-field>
                                </v-col>
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

        <notesSection :notes="resource_relations.notes" :id="id" :class_name="resource.class_name"></notesSection>
        <filesSection :files="resource_relations.files" :id="id" :class_name="resource.class_name"></filesSection>
        <paymentsSection
            :payments="resource_relations.payments"
            :id="id"
            :class_name="resource.class_name"
        ></paymentsSection>

        <v-dialog v-model="edit_dialog" persistent max-width="75vw">
            <v-card color>
                <v-card-title>
                    <span class="headline pl-3">Ndrysho te dhenat</span>
                    <div class="flex-grow-1"></div>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row class="py-0">
                            <v-col cols="6">
                                <v-row>
                                    <v-col cols="6">
                                        <v-text-field
                                            :error-messages="saving_errors.price"
                                            label="Cmimi i furnizimit:"
                                            v-model="edit_resource.price"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-combobox
                                            :error-messages="saving_errors.supplier"
                                            label="Furnitori:"
                                            hint="Shtyp te re ose zgjedh nga lista"
                                            persistent-hint
                                            v-model="edit_resource.supplier"
                                            :items="data_autofill.suppliers"
                                            item-text="supplier"
                                            clearable
                                        ></v-combobox>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-menu
                                            :close-on-content-click="false"
                                            max-width="290"
                                            v-model="date_picker"
                                        >
                                            <template v-slot:activator="{ on }">
                                                <v-text-field
                                                    :value="date_picker_readable_date"
                                                    :error-messages="saving_errors.purchase_date"
                                                    label="Data e blerjes:"
                                                    hint="Zgjidh daten ne kalendar"
                                                    persistent-hint
                                                    readonly
                                                    v-on="on"
                                                ></v-text-field>
                                            </template>
                                            <v-date-picker
                                                v-model="edit_resource.purchase_date"
                                                @change="date_picker = false"
                                            ></v-date-picker>
                                        </v-menu>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="6">
                                <v-row>
                                    <v-col cols="12">
                                        <v-combobox
                                            :error-messages="saving_errors.type"
                                            label="Lloji i pajisjes: *"
                                            hint="Shtyp te re ose zgjedh nga lista"
                                            persistent-hint
                                            v-model="edit_resource.type"
                                            :items="data_autofill.types"
                                            item-text="type"
                                            clearable
                                        ></v-combobox>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field
                                        :error-messages="saving_errors.serial"
                                        label="Nr. serial:"
                                        v-model="edit_resource.serial"
                                    ></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-select
                                            :error-messages="saving_errors.status"
                                            label="Statusi: *"
                                            v-model="edit_resource.status"
                                            :items="status_items"
                                        ></v-select>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                        :error-messages="saving_errors.name"
                                        label="Emri: *"
                                        v-model="edit_resource.name"
                                    ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                        :error-messages="saving_errors.description"
                                        label="Te dhena shtese:"
                                        hint="Shtype te dhena shtese per pajisjen"
                                        v-model="edit_resource.description"
                                    ></v-text-field>
                            </v-col>
                        </v-row>
                         <v-row class="py-0">
                                <v-col class="text-left py-0" cols="2">
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

export default {
    components: { notesSection, filesSection, paymentsSection },
    data() {
        return {
            edit_dialog: false,
            saving_errors: [],
            date_picker: false,

            id: this.$route.params.id,
            class_name: "",
            status_items: [
                { text: "Aktive", value: "active" },
                { text: "Pasive", value: "pasive" }
            ],
            edit_resource: {
                id: "",
                name: "",
                type: "",
                purchase_date: "",
                supplier: "",
                price: "",
                serial: "",
                description: "",
                status: "",

                deleted_at: "",
                created_at: "",
                updated_at: "",
                class_name: ""
            },
            resource: {
                id: "",
                name: "",
                type: "",
                purchase_date: "",
                supplier: "",
                price: "",
                serial: "",
                description: "",
                status: "",

                deleted_at: "",
                created_at: "",
                updated_at: "",
                class_name: "",
                created_by: { name: "" }
            },
            resource_relations: {
                files: {},
                notes: {},
                payments: {}
            },
            data_autofill: {
                suppliers: [],
                types: []
            }
        };
    },
    computed: {
        date_picker_readable_date() {
            moment.locale("sq");
            return this.edit_resource.purchase_date
                ? moment(this.edit_resource.purchase_date).format(
                      "D MMMM  YYYY, dddd"
                  )
                : "";
        }
    },
    beforeMount() {
        var currentObj = this;
        axios
            .get(`/inventory/${currentObj.id}`)
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

            /* Create new object with properties from fileds, ONLY if field has a value.(remove properties with empty fileds) This to comply with vlidation rules in
            CreateInventoryRequest, for attributes where validation "sometimes" is set.
            
            */
            let data = {};
            Object.keys(currentObj.edit_resource).forEach(function(prop) {
                if (currentObj.edit_resource[prop] != "" || currentObj.edit_resource[prop] != null) {
                    data[prop] = currentObj.edit_resource[prop];
                }
            });

            axios
                .put(`/inventory/${currentObj.id}`, data)
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
            if (confirm("Konfirmo fshirjen e e puntorit!") === false) {
                return;
            }
            axios(`/note/${currentObj.id}`, {
                method: "delete"
            })
                .then(function(resp) {
                    currentObj.$route.go("/employee");
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Puntori u fshi!"
                    });
                })
                .catch(function(resp) {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Puntori nuk u fshi, rifresko faqen!"
                    });
                });
        }
    }
};
</script>