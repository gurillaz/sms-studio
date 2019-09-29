<template>

    <div class="mx-3">

        <v-row>
            <v-col>
                <div class="headline"> Klienti</div>


            </v-col>

            <v-col class="text-right">

                <v-btn outlined color="warning" class="mr-3" @click.stop="edit_dialog = true">Ndrysho</v-btn>
                <v-btn outlined color="error">Fshij</v-btn>


            </v-col>
        </v-row>

        <v-row>
            <v-col>
                <v-row>
                    <v-col>
                        <v-card>

                            <v-card-text>

                                <span class="display-1 text--primary">
                                    <v-icon x-large left color="primary">mdi-account-circle-outline</v-icon>
                                    {{client.name}}
                                </span>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-card class="d-flex align-self-stretch">
                            <v-card-text>

                                <span class="subtitle-1 mb-5">
                                    <v-icon left>mdi-information-outline</v-icon>
                                    Te dhenat e tjera
                                </span>
                                <p></p>
                                <v-simple-table>

                                    <tbody>
                                    <tr>
                                        <td>Pune</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td>Pagesa</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td>Fajlla</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td>Shenime</td>
                                        <td>5</td>
                                    </tr>
                                    </tbody>
                                </v-simple-table>

                            </v-card-text>


                        </v-card>
                    </v-col>
                </v-row>

            </v-col>

            <v-col class="d-flex align-content-stretch">
                <v-row>
                    <v-col>

                        <v-card height="100%">

                            <v-card-text>

                                <span class="subtitle-1">
                                    <v-icon left>mdi-information-outline</v-icon>
                                    Te dhenat baze
                                </span>
                                <p></p>
                                <v-simple-table>

                                    <tbody>
                                    <tr>
                                        <td>Emri:</td>
                                        <td class="font-weight-bold">{{client.name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Telefon:</td>
                                        <td class="font-weight-bold">{{client.phone}}</td>
                                    </tr>
                                    <tr>
                                        <td>Emaili:</td>
                                        <td class="font-weight-bold">{{client.email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Qyteti:</td>
                                        <td class="font-weight-bold">{{client.city}}</td>
                                    </tr>
                                    <tr>
                                        <td>Adresa:</td>
                                        <td class="font-weight-bold">{{client.address}}</td>
                                    </tr>
                                    </tbody>
                                </v-simple-table>
                            </v-card-text>
                        </v-card>


                    </v-col>
                </v-row>
            </v-col>
        </v-row>

        <notesSection :notes="notes" :id="id" :class_name="class_name"></notesSection>


        <filesSection :files="files" :id="id" :class_name="class_name"></filesSection>


        <v-dialog v-model="edit_dialog" persistent max-width="75vw">
            <v-card>
                <v-card-title>
                    <span class="headline">Ndrysho te dhenat</span>
                </v-card-title>
                <v-card-text>
                    <v-container>

                        <v-row v-show="updating_errors != false">
                            <v-col cols="12" sm="6" md="12">
                                <v-sheet color="red lighten-3" class="pa-3">
                                <ul>
                                    <template v-for="field_error in updating_errors">
                                        <li class="white--text font-weight-bold" v-for="error in field_error">{{error}}</li>
                                    </template>
                                </ul>
                                </v-sheet>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="updated_client.name" label="Emri" required></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="updated_client.email" label="Email"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="updated_client.phone" label="Telefoni" required></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="updated_client.city" label="Qyteti"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="8">
                                <v-text-field
                                        v-model="updated_client.address"
                                        label="Adresa"
                                        hint="Adresa te jete sa me e detajuar"
                                        persistent-hint
                                        required
                                ></v-text-field>
                            </v-col>
                        </v-row>

                    </v-container>
                    <small>*indicates required field</small>
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="blue darken-1" text @click="edit_dialog = false">Anulo</v-btn>
                    <v-btn color="blue darken-1" text @click="update_client">Ruaj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </div>

</template>

<script>
    import axios from '@/js/config/axios.js';
    import notesSection from '@/js/pages/note/notes_section';

    import filesSection from '@/js/pages/file/files_section';

    export default {
        components: {notesSection,filesSection},
        data() {
            return {

                id: this.$route.params.id,
                class_name: "",
                client: {},
                files: {},
                notes: {},
                payments: {},
                edit_dialog: false,
                updated_client: {},
                updating_errors: false,

            }
        },
        methods:{
          update_client:function (){
              let currentObj = this;

              axios.put(`/client/${currentObj.id}`,currentObj.updated_client)
                  .then(function (resp) {

                      currentObj.client = resp.data.client;
                      currentObj.updated_client = resp.data.client;
                      currentObj.edit_dialog = false;
                      currentObj.updating_errors = false;
                      currentObj.$store.dispatch('showSnackbar', {color:'success', text: 'Ndryshimet u ruajten!'})


                  })
                  .catch(function (resp) {

                      currentObj.updating_errors = resp.response.data.errors;
                      currentObj.$store.dispatch('showSnackbar', {color:'error', text: 'Ndryshimet nuk u ruajten!'})



                  });
          },

        },
        beforeMount() {
            let currentObj = this;
            axios.get(`/client/${currentObj.id}`)
                .then(function (resp) {
                    // console.log(resp.data);
                    currentObj.client = resp.data.client;
                    currentObj.updated_client = resp.data.client;
                    currentObj.files = resp.data.files;
                    currentObj.payments = resp.data.payments;
                    currentObj.notes = resp.data.notes;
                    currentObj.class_name = resp.data.class_name;

                })
                .catch(function (resp) {

                    currentObj.$store.dispatch('showSnackbar', {color:'error', text: 'Te dhenat e kerkuara, nuk egzistojne!'})
                    currentObj.$router.push('/client/all')
                });
        },
    }
</script>