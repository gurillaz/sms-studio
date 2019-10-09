<template>
    <div class="mx-3">
        <v-row>
            <v-col>
                <div class="headline">Puntori</div>
            </v-col>

            <v-col class="text-right">
                <!-- <v-btn
                    @click.stop="edit_dialog = true"
                    class="mr-3"
                    color="warning"
                    outlined
                >Ndrysho</v-btn>-->

                <v-menu offset-y>
                    <template v-slot:activator="{ on }">
                        <v-btn class="mr-3 px-10" color="warning" v-on="on">
                            Ndrysho
                            <v-icon right>mdi-chevron-down</v-icon>
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item @click.stop="edit_dialog_1 = true">
                            <v-list-item-title>Te dhenat baze</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click.stop="edit_dialog_2 = true">
                            <v-list-item-title>Te dhenat per punen</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click.stop="edit_dialog_3 = true">
                            <v-list-item-title>Qasjen ne aplikacion</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>

                <v-btn @click="delete_resource" color="error" outlined>Fshij</v-btn>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <v-card outlined class="py-5 px-8" color="green lighten-5">
                    <v-row>
                        <!-- <div class="flex-grow-1"></div> -->
                        <v-col cols="4">
                            <v-sheet
                                color="grey lighten-5"
                                class="d-flex align-center justify-center"
                                style="height:45vh"
                            >
                                <v-icon x-large>mdi-image</v-icon>
                            </v-sheet>
                        </v-col>
                        <v-col cols="8">
                            <!-- titulli -->
                            <v-row class="px-1">
                                <div>
                                    <v-icon left>mdi-account-plus</v-icon>
                                    <span class="text-uppercase font-weight-bold">Te dhenat baze</span>
                                </div>
                                <div class="flex-grow-1"></div>
                            </v-row>

                            <v-row class="py-0">
                                <v-col class="py-0" cols="6">
                                    <v-text-field label="Emri:" readonly v-model="resource.name"></v-text-field>
                                </v-col>
                                <v-col class="py-0" cols="6">
                                    <v-text-field
                                        label="Numri personal:"
                                        v-model="resource.personal_id"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col class="py-0" cols="12">
                                    <v-text-field
                                        label="Adresa:"
                                        v-model="resource.address"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col class="py-0" cols="6">
                                    <v-text-field
                                        label="Email adresa:"
                                        v-model="resource.email"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-0" cols="6">
                                    <v-text-field
                                        label="Numri i telefonit:"
                                        v-model="resource.phone"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <!-- titulli -->
                            <v-row class="px-2">
                                <div>
                                    <v-icon left>mdi-account-plus</v-icon>
                                    <span class="text-uppercase font-weight-bold">Te dhenat e punes</span>
                                </div>
                                <div class="flex-grow-1"></div>
                            </v-row>
                            <!-- body -->
                            <!-- body -->
                            <v-row class="py-0">
                                <v-col class="py-0" cols="4">
                                    <v-select
                                        label="Lloji i puntorit:"
                                        v-model="resource.employee_type"
                                        :items="employee_types"
                                        readonly
                                    ></v-select>
                                </v-col>
                                <v-col class="py-0" cols="4">
                                    <v-text-field
                                        label="Pozita:"
                                        v-model="resource.position"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-0" cols="4">
                                    <v-select
                                        label="Lloji i perdoruesit:"
                                        v-model="resource.role"
                                        :items="roles"
                                        readonly
                                    ></v-select>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col class="py-0" cols="4">
                                    <v-select
                                        label="Lloji i pageses:"
                                        v-model="resource.salary_type"
                                        :items="salary_types"
                                        readonly
                                    ></v-select>
                                </v-col>
                                <v-col class="py-0" cols="4">
                                    <v-text-field
                                        label="Shuma: "
                                        v-model="resource.salary_amount"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-0" cols="4">
                                    <v-select
                                        label="Statusi:"
                                        v-model="resource.status"
                                        :items="status_items"
                                        readonly
                                    ></v-select>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
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

        <v-dialog v-model="edit_dialog_1" persistent max-width="75vw">
            <v-card outlined tile class="py-5 px-8">
                <!-- titulli -->
                <span class="text-uppercase">Te dhenat baze</span>

                <v-row class="py-0">
                    <v-col class="py-1" cols="5">
                        <v-text-field
                            :error-messages="saving_errors.name"
                            label="Emri: *"
                            required
                            v-model="edit_resource.name"
                        ></v-text-field>
                    </v-col>
                    <v-col class="py-1" cols="4">
                        <v-text-field
                            :error-messages="saving_errors.personal_id"
                            hint="Nr. i leternjoftimit"
                            label="Numri personal: *"
                            persistent-hint
                            v-model="edit_resource.personal_id"
                            :disabled="edit_resource.employee_type == 'contractor'"
                        ></v-text-field>
                    </v-col>
                </v-row>

                <v-row class="py-0">
                    <v-col class="py-1" cols="12">
                        <v-text-field
                            :error-messages="saving_errors.address"
                            label="Adresa: *"
                            hint="Vendbanimi (qyteti, fshati ose rruga)"
                            v-model="edit_resource.address"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row class="py-0">
                    <v-col class="py-1" cols="4">
                        <v-text-field
                            :error-messages="saving_errors.email"
                            label="Email adresa: *"
                            required
                            v-model="edit_resource.email"
                            name="new_employe_email"
                        ></v-text-field>
                    </v-col>
                    <v-col class="py-1" cols="4">
                        <v-text-field
                            :error-messages="saving_errors.phone"
                            hint="Nr. i leternjoftimit"
                            label="Numri i telefonit: *"
                            persistent-hint
                            v-model="edit_resource.phone"
                        ></v-text-field>
                    </v-col>
                </v-row>

                <v-row class="py-0">
                    <v-col class="text-left" cols="2">
                        <small>*duhet te plotesohen</small>
                    </v-col>
                    <div class="flex-grow-1"></div>
                </v-row>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn @click="edit_dialog_1 = false" color="warning" text>Mbyll</v-btn>
                    <v-btn @click="update_resource_basic_info()" color="success" text>Ruaj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="edit_dialog_2" persistent max-width="75vw">
            <v-card outlined tile class="py-5 px-8">
                <!-- titulli -->
                <v-row class="px-2 mb-3">
                    <span class="text-uppercase">Te dhenat e punes</span>
                    <div class="flex-grow-1"></div>
                </v-row>
                <!-- body -->
                <!-- body -->
                <v-row class="py-0">
                    <v-col class="py-1" cols="4">
                        <v-select
                            :error-messages="saving_errors.employee_type"
                            hint="I rregullt, part-time"
                            label="Lloji i puntorit: *"
                            persistent-hint
                            v-model="edit_resource.employee_type"
                            :items="employee_types"
                            :menu-props="{'offsetY':true}"
                        ></v-select>
                    </v-col>
                    <v-col class="py-1" cols="5">
                        <v-text-field
                            :error-messages="saving_errors.position"
                            label="Pozita: *"
                            required
                            v-model="edit_resource.position"
                        ></v-text-field>
                    </v-col>
                </v-row>

                <v-row class="py-0">
                    <v-col class="py-1" cols="4">
                        <v-select
                            :error-messages="saving_errors.salary_type"
                            hint="Sh. Pagesa 1 here ne muaj"
                            label="Lloji i pageses: *"
                            persistent-hint
                            v-model="edit_resource.salary_type"
                            :items="salary_types"
                            :menu-props="{'offsetY':true}"
                        ></v-select>
                    </v-col>
                    <v-col class="py-1" cols="3">
                        <v-text-field
                            :error-messages="saving_errors.salary_amount"
                            label="Shuma: "
                            v-model="edit_resource.salary_amount"
                        ></v-text-field>
                    </v-col>
                </v-row>

                <v-row class="py-0">
                    <v-col class="text-left" cols="2">
                        <small>*duhet te plotesohen</small>
                    </v-col>
                    <div class="flex-grow-1"></div>
                </v-row>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn @click="edit_dialog_2 = false" color="warning" text>Mbyll</v-btn>
                    <v-btn @click="update_resource_work_info()" color="success" text>Ruaj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="edit_dialog_3" persistent max-width="75vw">
            <v-card outlined tile class="py-5 px-8">
                <!-- titulli -->
                <v-row class="px-2 mb-3">
                    <div>
                        <span class="text-uppercase font-weight-bold">Qasja ne aplikacion</span>
                    </div>
                    <div class="flex-grow-1"></div>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-text-field
                            :error-messages="saving_errors.email"
                            label="Email adresa: *"
                            required
                            v-model="edit_resource.email"
                            disabled
                        ></v-text-field>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="4">
                        <v-select
                            :error-messages="saving_errors.role"
                            hint="Sipas llojit, caktohet qasja ne te dhena"
                            label="Lloji i perdoruesit: *"
                            persistent-hint
                            v-model="edit_resource.role"
                            :items="roles"
                            :menu-props="{'offsetY':true}"
                        ></v-select>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-text-field
                            :success="edit_resource.password!='' && edit_resource.password == confirm_password"
                            :error-messages="saving_errors.password"
                            label="Fjalkalimi: *"
                            hint="Te pakten 6 karaktere"
                            persistent-hint
                            v-model="edit_resource.password"
                            :append-icon="show_password_1 ? 'mdi-eye' : 'mdi-eye-off'"
                            :type="show_password_1 ? 'text' : 'password'"
                            counter
                            @click:append="show_password_1 = !show_password_1"
                            name="new_employe_psw"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="4">
                        <v-text-field
                            :success="confirm_password!='' && edit_resource.password == confirm_password"
                            :error="confirm_password!='' && edit_resource.password != confirm_password"
                            :error-messages="edit_resource.password != confirm_password ? 'Fjalkalimi nuk perputhet': ''"
                            label="Perserit fjalkallimin: *"
                            v-model="confirm_password"
                            :append-icon="show_password_2 ? 'mdi-eye' : 'mdi-eye-off'"
                            :type="show_password_2 ? 'text' : 'password'"
                            counter
                            @click:append="show_password_2 = !show_password_2"
                            name="new_employe_psw"
                        ></v-text-field>
                    </v-col>
                </v-row>

                <v-row class="py-0">
                    <v-col class="text-left" cols="2">
                        <small>*duhet te plotesohen</small>
                    </v-col>
                    <div class="flex-grow-1"></div>
                </v-row>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn @click="edit_dialog_3 = false" color="warning" text>Mbyll</v-btn>
                    <v-btn @click="update_resource_access_info()" color="success" text>Ruaj</v-btn>
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
            roles: [
                { text: "Administrator", value: "admin" },
                { text: "Puntor", value: "employee" }
            ],
            employee_types: [
                { text: "I rregullt", value: "regular" },
                { text: "Part Time", value: "part_time" }
            ],
            salary_types: [
                { text: "Dite", value: "day" },
                { text: "Jave", value: "week" },
                { text: "Muaj", value: "month" },
                { text: "E pacaktuar", value: "undefined" }
            ],
            show_password_1: false,
            show_password_2: false,
            confirm_password: "",
            edit_dialog_1: false,
            edit_dialog_2: false,
            edit_dialog_3: false,
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
    computed: {},
    beforeMount() {
        var currentObj = this;
        axios
            .get(`/employee/${currentObj.id}`)
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
        update_resource_basic_info: function() {
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
                .put(`/employee_update_basic_info/${currentObj.id}`, data)
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
                    currentObj.edit_dialog_1 = false;

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
        update_resource_work_info: function() {
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
                .put(`/employee_update_work_info/${currentObj.id}`, data)
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
                    currentObj.edit_dialog_2 = false;

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
        update_resource_access_info: function() {
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
                .put(`/employee_update_access_info/${currentObj.id}`, data)
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
                    currentObj.edit_dialog_3 = false;

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
            axios(`/employee/${currentObj.id}`, {
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