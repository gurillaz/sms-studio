<template>

    <div class="mx-3">

        <v-row>
            <v-col>
                <div class="headline"> Klienti</div>


            </v-col>
            {{class_name}}
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
        <paymentsSection :payments="payments" :id="id" :class_name="class_name"></paymentsSection>

        <v-dialog v-model="edit_dialog" persistent max-width="75vw">
            <v-card>
                <v-card-title>
                    <span class="headline">Ndrysho te dhenat</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="client.name" label="Emri" required></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field label="Legal middle name" hint="example of helper text only on focus"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field
                                        label="Legal last name*"
                                        hint="example of persistent helper text"
                                        persistent-hint
                                        required
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field label="Email*" required></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field label="Password*" type="password" required></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-select
                                        :items="['0-17', '18-29', '30-54', '54+']"
                                        label="Age*"
                                        required
                                ></v-select>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-autocomplete
                                        :items="['Skiing', 'Ice hockey', 'Soccer', 'Basketball', 'Hockey', 'Reading', 'Writing', 'Coding', 'Basejump']"
                                        label="Interests"
                                        multiple
                                ></v-autocomplete>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small>*indicates required field</small>
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="blue darken-1" text @click="edit_dialog = false">Anulo</v-btn>
                    <v-btn color="blue darken-1" text @click="edit_dialog= false">Ruaj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </div>

</template>

<script>
    import axios from '@/js/config/axios.js';
    import notesSection from '@/js/pages/note/notes_section';
    import filesSection from '@/js/pages/file/files_section';
    import paymentsSection from '@/js/pages/payment/payments_section';

    export default {
        components: {notesSection,filesSection,paymentsSection},
        data() {
            return {

                id: this.$route.params.id,
                class_name:"",
                client: {},
                files: {},
                notes: {},
                payments: {},
                edit_dialog:false,
            }
        },
        beforeMount() {
            var app = this;
            axios.get(`/client/${app.id}`)
                .then(function (resp) {
                    // console.log(resp.data);
                    app.client = resp.data.client;
                    app.files = resp.data.files;
                    app.payments = resp.data.payments;
                    app.notes = resp.data.notes;
                    app.class_name = resp.data.class_name;

                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load Client");
                });
        },
    }
</script>