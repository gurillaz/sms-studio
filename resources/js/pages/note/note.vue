<template>
    <div class="mx-3">
        <v-row>
            <v-col>
                <div class="headline">Shenimi</div>
            </v-col>

            <v-col class="text-right">
                <v-btn
                    outlined
                    color="warning"
                    class="mr-3"
                    @click.stop="edit_dialog = true"
                >Ndrysho</v-btn>
                <v-btn outlined color="error">Fshij</v-btn>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <v-card color="amber lighten-2" height="77vh">
                    <v-card-title>
                        <span class="headline pl-3">{{note.name}}</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="4">
                                    <v-text-field
                                        label="Shtuar me date:"
                                        :value="formatedDate()"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        label="Shtuar nga:"
                                        :value="created_by.name"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        label="I takon::"
                                        :value="`${belongs_to.name} (${belongsToReadable()})`"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="2" class="pt-6">
                                    <v-btn
                                        block
                                        text
                                        :to="`/${model}/${belongs_to.id}`"
                                    >Shiko burimin</v-btn>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field label="Titulli:" :value="note.name" readonly></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-textarea
                                        label="Shenimi:"
                                        rows="13"
                                        :value="note.body"
                                        readonly
                                    ></v-textarea>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="edit_dialog" persistent max-width="75vw">
            <v-card color="amber lighten-2">
                <v-card-title>
                    <span class="headline pl-3">Ndrysho te dhenat</span>
                </v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-row>
                            <v-col cols="4">
                                <v-text-field
                                    label="Shtuar me date:"
                                    :value="formatedDate()"
                                    disabled
                                ></v-text-field>
                            </v-col>
                            <v-col cols="3">
                                <v-text-field label="Shtuar nga:" :value="created_by.name" disabled></v-text-field>
                            </v-col>
                            <v-col cols="3">
                                <v-text-field
                                    @click="redirectToBelonger()"
                                    label="I takon::"
                                    :value="`${belongs_to.name} (${belongsToReadable()})`"
                                    disabled
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2" class="pt-6">
                                <v-btn
                                    disabled
                                    block
                                    text
                                    :to="`/${model}/${belongs_to.id}`"
                                >Shiko burimin</v-btn>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Titulli:"
                                    v-model="edit_note.name"
                                    :error-messages="updating_errors.name"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea
                                    label="Shenimi:"
                                    rows="10"
                                    v-model="edit_note.body"
                                    :error-messages="updating_errors.body"
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="warning" text @click="edit_dialog = false">Mbyll</v-btn>
                    <v-btn color="success" text @click="update()">Ruaj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";

export default {
    props: ["id"],
    data() {
        return {
            edit_dialog: false,
            edit_note: {},
            updating_errors: [],

            note: {},
            belongs_to: {},
            created_by: {},
            model: ""
        };
    },
    methods: {
        formatedDate() {
            moment.locale("sq");
            if (this.note.created_at === this.note.updated_at) {
                return moment(this.note.updated_at).format(
                    "D MMMM Y [ora] HH:mm"
                );
            } else {
                return (
                    moment(this.note.updated_at).format(
                        "D MMMM Y [ora] HH:mm"
                    ) + "(E modifikuar )"
                );
            }
        },
        redirectToBelonger() {
            this.$router.push(`/${this.model}/${this.belongs_to.id}`);
        },
        belongsToReadable() {
            if (this.model === "Client") {
                return "Klient";
            }
            if (this.model === "Job") {
                return "Pune";
            }
            if (this.model === "Event") {
                return "Event";
            }
            if (this.model === "File") {
                return "Fajll";
            }
            if (this.model === "Inevntory") {
                return "Pajisje";
            }
            if (this.model === "Note") {
                return "Shenim";
            }
            if (this.model === "Offer") {
                return "Oferte";
            }
            if (this.model === "Payment") {
                return "Pagese";
            }
            if (this.model === "Service") {
                return "Sherbim";
            }
            if (this.model === "Task") {
                return "Detyre";
            } else {
                return this.model;
            }
        },
        update() {
            let currentObj = this;
            axios
                .put(`/note/${currentObj.id}`, currentObj.edit_note)
                .then(function(resp) {
                    currentObj.updating_errors = [];
                    currentObj.edit_dialog = false;

                    currentObj.note = resp.data.note;

                    /* Using JSON.parse to copy object, since just asignin resp.data.note only references data 
                note end edit_note keep changing when used as vue v-model
                Based on: https://scotch.io/bar-talk/copying-objects-in-javascript
                 */
                    currentObj.edit_note = JSON.parse(
                        JSON.stringify(resp.data.note)
                    );
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Te dhenat u ruajten."
                    });
                })
                .catch(function(resp) {
                    // console.log(resp);
                    currentObj.updating_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Te dhenat nuk u ruajten!"
                    });
                });
        }
    },
    beforeMount() {
        let currentObj = this;
        axios
            .get(`/note/${currentObj.id}`)
            .then(function(resp) {
                // console.log(resp.data);

                currentObj.note = resp.data.note;

                /* Using JSON.parse to copy object, since just asignin resp.data.note only references data 
                note end edit_note keep changing when used as vue v-model
                Based on: https://scotch.io/bar-talk/copying-objects-in-javascript
                 */
                currentObj.edit_note = JSON.parse(
                    JSON.stringify(resp.data.note)
                );
                currentObj.belongs_to = resp.data.belongs_to;
                currentObj.created_by = resp.data.created_by;
                currentObj.model = resp.data.model;
            })
            .catch(function(resp) {
                // console.log(resp);
                currentObj.$store.dispatch("showSnackbar", {
                    color: "error",
                    text: "Serveri nuk dergoi te dhenat. Rifresko faqen!"
                });
            });
    }
};
</script>
