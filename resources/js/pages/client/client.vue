<template>
    <div class="mx-3">
        <v-row>
            <v-col>
                <div class="headline">Klienti</div>
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
                                <v-col cols="12" class="pt-0">
                                    <v-text-field :value="resource.name" label="Emri:" readonly></v-text-field>
                                </v-col>
                                <v-col cols="6" class="pt-0">
                                    <v-text-field
                                        :value="resource.phone"
                                        label="Telefoni:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="6" class="pt-0">
                                    <v-text-field :value="resource.email" label="Email:" readonly></v-text-field>
                                </v-col>
                                <v-col cols="6" class="pt-0">
                                    <v-text-field :value="resource.city" label="Qyteti:" readonly></v-text-field>
                                </v-col>
                                <v-col cols="12" class="pt-0">
                                    <v-text-field
                                        :value="resource.address"
                                        label="Adresa:"
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

                        <v-row class="py-0">
                            <v-col cols="12" class="pt-0">
                                <v-text-field 
                                v-model="edit_resource.name"
                                :error-messages="saving_errors.name"
                                 label="Emri: *"
                                  ></v-text-field>
                            </v-col>
                            <v-col cols="6" class="pt-0">
                                <v-text-field
                                  v-model="edit_resource.phone"
                                :error-messages="saving_errors.phone"
                                  label="Telefoni: *"
                                  ></v-text-field>
                            </v-col>
                            <v-col cols="6" class="pt-0">
                                 <v-text-field
                                  v-model="edit_resource.email"
                                :error-messages="saving_errors.email"
                                  label="Email: *"
                                  ></v-text-field>
                            </v-col>
                            <v-col cols="6" class="pt-0">
                                    <v-combobox
                                        :error-messages="saving_errors.city"
                                        label="Qyteti/Komuna: *"
                                        hint="Shtyp te re ose zgjedh nga lista"
                                        persistent-hint
                                        v-model="edit_resource.city"
                                        :items="data_autofill.cities"
                                        item-text="type"
                                        clearable
                                    ></v-combobox>
                            </v-col>
                            <v-col cols="12" class="pt-0">
                                                  <v-text-field
                                  v-model="edit_resource.address"
                                :error-messages="saving_errors.address"
                                  label="Adresa: *"
                                  ></v-text-field>
                            </v-col>
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
    id:'',
    name: '',
    phone: '',
    email: '',
    city: '',
    address: '',
    created_by: {
      name: ''
    },
    deleted_at: null,
    created_at: null,
    updated_at: null,
    class_name: ''
            },
            resource: {
    id:'',
    name: '',
    phone: '',
    email: '',
    city: '',
    address: '',
    created_by: {
      name: ''
    },
    deleted_at: null,
    created_at: null,
    updated_at: null,
    class_name: ''
            },
            resource_relations: {
                files: {},
                notes: {},
                payments: {}
            },
            data_autofill: {
                cities: []
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
            .get(`/client/${currentObj.id}`)
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
                .put(`/client/${currentObj.id}`, currentObj.edit_resource)
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
            if (confirm("Konfirmo fshirjen e klientit!") === false) {
                return;
            }
            axios.delete(`/client/${currentObj.id}`)
                .then(function(resp) {
                    // currentObj.router.go('/client');
                    currentObj.$router.replace({name:'client.all'});
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Klienti u fshi!"
                    });
                })
                .catch(function(resp) {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Klienti nuk u fshi, rifresko faqen!"
                    });
                });
        }
    }
};
</script>