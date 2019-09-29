<template>
    <v-row class="mx-1" style="overflow-y: scroll; height: 57vh">
        <!--                            <code>{{selected_client_id}}</code>-->

        <v-tabs
            :hide-slider="true"
            background-color="white"
            color="primary accent-4"
            right
            v-model="select_client_tab"
        >
            <v-tab @click="selected_client_id = null">Klient i ri</v-tab>
            <v-tab>Klient egzistues</v-tab>

            <v-tab-item reverse-transition="false" transition="false">
                <div class="mx-3">
                    <v-container>
                        <v-row>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field
                                    v-model="new_client.name"
                                    label="Emri*"
                                    prepend-inner-icon="mdi-account-card-details-outline"
                                    :error-messages="new_client.name === '' ? saving_errors.name : []"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field
                                    v-model="new_client.phone"
                                    label="Telefoni*"
                                    prepend-inner-icon="mdi-contact-phone-outline"
                                    :error-messages="new_client.phone === '' ? saving_errors.phone : []"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field
                                    v-model="new_client.email"
                                    label="Email"
                                    prepend-inner-icon="mdi-email-outline"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field
                                    v-model="new_client.city"
                                    label="Qyteti*"
                                    prepend-inner-icon="mdi-city-variant-outline"
                                    :error-messages="new_client.city === '' ? saving_errors.city : []"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="8">
                                <v-text-field
                                    v-model="new_client.address"
                                    label="Adresa*"
                                    hint="Adresa te jete sa me e detajuar"
                                    persistent-hint
                                    prepend-inner-icon="mdi-map-marker-outline"
                                    :error-messages="new_client.address === '' ? saving_errors.address : []"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small>*duhet te plotesohen</small>

                    <v-card-actions>
                        <div class="flex-grow-1"></div>
                        <v-btn color="warning" @click="save_new_client">Ruaj te dhenat</v-btn>
                    </v-card-actions>
                </div>
            </v-tab-item>
            <v-tab-item reverse-transition="false" transition="false">
                <v-container fluid>
                    <v-row>
                        <v-col cols="12">
                            <p class="headline mb-6">Zgjidh klientin egzistues</p>

                            <v-autocomplete
                                :items="clients"
                                autofocus
                                clear-icon="mdi-close"
                                clearable
                                height="4rem"
                                hide-details
                                hide-selected
                                item-text="name"
                                item-value="id"
                                label="Zgjidh klientin egzistues"
                                no-data-text="Klienti nuk egziston"
                                solo
                                v-model="select_client"
                            >
                                <template v-slot:selection="{attr,on,item,selected}">
                                    <v-list-item-avatar
                                        :input-value="selected"
                                        class="headline font-weight-light white--text text-uppercase"
                                        color="indigo"
                                        v-bind="attr"
                                        v-on="on"
                                    >
                                        {{
                                        item.name.charAt(0)
                                        }}
                                    </v-list-item-avatar>
                                    <v-list-item-content>
                                        <v-list-item-title v-text="item.name"></v-list-item-title>
                                        <v-list-item-subtitle v-text="item.city"></v-list-item-subtitle>
                                    </v-list-item-content>
                                </template>
                                <template v-slot:item="{ item }">
                                    <v-list-item-avatar
                                        class="headline font-weight-light white--text text-uppercase"
                                        color="indigo"
                                    >
                                        {{
                                        item.name.charAt(0)
                                        }}
                                    </v-list-item-avatar>
                                    <v-list-item-content>
                                        <v-list-item-title v-text="item.name"></v-list-item-title>
                                        <v-list-item-subtitle v-text="item.city"></v-list-item-subtitle>
                                    </v-list-item-content>
                                </template>
                            </v-autocomplete>
                        </v-col>
                    </v-row>
                </v-container>
            </v-tab-item>
        </v-tabs>
    </v-row>
</template>

<script>
import axios from "@/js/config/axios.js";
import { mapFields } from "vuex-map-fields";

export default {
    name: "FormPart2",
    data() {
        return {
            saving_errors: [],
            new_client: {
                name: "",
                phone: "",
                email: "",
                city: "",
                address: "",
                id: ""
            }
        };
    },
    computed: {
        ...mapFields({
            selected_client_id: "form_new_job_data.selected_client_id",
            selected_client_name: "form_new_job_data.selected_client_name",
            select_client_tab: "form_new_job_data.select_client_tab",
            current_step: "form_new_job_data.current_step",
            clients: "form_new_job_data.clients",

            created_job: "form_new_job_data.created_job",
            selected_offer_name: "form_new_job_data.selected_offer_name"
        }),

        select_client: {
            get: function() {
                return this.selected_client_id;
            },
            set: function(id) {
                this.selected_client_id = id;
                if (id != null) {
                    this.selected_client_id = id;

                    let client_name = this.clients.filter(
                        cli => cli.id == id
                    )[0].name;
                    this.created_job.name =
                        this.selected_offer_name + " - " + client_name;
                    this.created_job.client_id = id;

                    this.selected_client_name = client_name;
                }
            }
        }
    },

    methods: {
        save_new_client: function() {
            let currentObj = this;

            axios
                .post(`/client`, currentObj.new_client)
                .then(function(resp) {
                    currentObj.saving_errors = false;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Klienti u krijua!"
                    });
                    //Add new client temporarly to clients array in store
                    currentObj.clients.push(resp.data.client);

                    let client_name = resp.data.client.name;
                    /* Update temporary created job name in store to selected offer name and client name
                        job name will update dynamically, based on selected offer name and selected client name.
                    */
                    currentObj.created_job.name =
                        currentObj.selected_offer_name + " - " + client_name;
                    currentObj.created_job.client_id = resp.data.client.id;
                    /* Selected client name is saved in store, if user changed the offer -- created job name is updated to newly selected offer name and currenlty selected client name. IN CASE USER GOES STEPES BACK IN FORM */
                    currentObj.selected_client_name = client_name;

                    currentObj.selected_client_id = resp.data.client.id;
                    //
                    currentObj.current_step = 3;
                    /* If user has created or selected client, the form will show newly created client or selected existing client ---- if user goes stepes back in form. */
                    currentObj.select_client_tab = 1;
                })
                .catch(function(resp) {
                    currentObj.saving_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Klienti nasuk u ruajt!"
                    });
                });
        }
    }
};
</script>