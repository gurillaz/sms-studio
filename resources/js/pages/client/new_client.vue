<template>

    <div class="mx-3">

        <v-row>
            <v-col cols="12">

                <v-card>
                    <v-card-title>
                        <v-icon left>mdi-account-plus-outline</v-icon>
                        <span class="headline">Shto klient te ri</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>

                            <v-row v-show="saving_errors != false">
                                <v-col cols="12" sm="6" md="12">
                                    <v-sheet color="red lighten-3" class="pa-3">
                                        <ul>
                                            <template v-for="field_error in saving_errors">
                                                <li class="white--text font-weight-bold" v-for="error in field_error">
                                                    {{error}}
                                                </li>
                                            </template>
                                        </ul>
                                    </v-sheet>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" sm="6" md="4">
                                    <v-text-field v-model="new_client.name" label="Emri" required></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" sm="6" md="4">
                                    <v-text-field v-model="new_client.email" label="Email"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="4">
                                    <v-text-field v-model="new_client.phone" label="Telefoni" required></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" sm="6" md="4">
                                    <v-text-field v-model="new_client.city" label="Qyteti"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="8">
                                    <v-text-field
                                            v-model="new_client.address"
                                            label="Adresa"
                                            hint="Adresa te jete sa me e detajuar"
                                            persistent-hint
                                            required
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                        </v-container>
                        <small>*duhet te plotesohen</small>
                    </v-card-text>
                    <v-card-actions>
                        <div class="flex-grow-1"></div>
                        <v-btn color="primary" text @click="save_new_client">Ruaj te dhenat</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>


    </div>

</template>

<script>
    import axios from '@/js/config/axios.js';


    export default {

        data() {
            return {

                saving_errors: [],
                new_client: {
                    name: '',
                    phone: '',
                    email: '',
                    city: '',
                    address: '',
                }
            }
        },
        methods: {
            save_new_client: function () {
                let currentObj = this;

                axios.post(`/client`, currentObj.new_client)
                    .then(function (resp) {
                        currentObj.saving_errors = false;
                        currentObj.$store.dispatch('showSnackbar', {color: 'success', text: 'Klienti u krijua!'})
                        currentObj.$router.push('/client')


                    })
                    .catch(function (resp) {
                        console.log(resp.data)

                        currentObj.saving_errors = resp.response.data.errors;
                        currentObj.$store.dispatch('showSnackbar', {color: 'error', text: 'Te dhenat nuk u ruajten'})


                    });
            },

        },

    }
</script>