<template>
    <div class="mt-5">
        <v-row>
            <v-col>
                <div class="headline">Shenimet</div>
            </v-col>

            <v-col class="text-right">
                <v-btn
                    outlined
                    dark
                    @click.stop="new_note_dialog = true"
                    color="primary"
                    class="mr-3"
                >Shto shenim</v-btn>
            </v-col>
        </v-row>

        <!--        {{notes}}-->

        <v-row v-if="notes.length > 0">
            <noteCard v-for="note in notes" v-bind:key="note.id" :note="note"></noteCard>
        </v-row>

        <v-row v-if="notes.length == 0">
            <v-col cols="12" class="ma-12 text-center">
                <p class="display-1 grey--text">Nuk ka shenime te ruajtura</p>
            </v-col>
        </v-row>

        <v-dialog v-model="new_note_dialog" persistent max-width="600px">
            <v-card color="amber lighten-2">
                <v-card-title>
                    <span class="headline">Shenim i ri</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="new_note.name"
                                    label="Titulli*"
                                    required
                                    :error-messages="saving_errors.name"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea
                                    outlined
                                    label="Shenimi*"
                                    rows="8"
                                    v-model="new_note.body"
                                    :error-messages="saving_errors.body"
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small>*Duhet te plotesohen</small>
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="warning" text @click="new_note_dialog = false">Mbyll</v-btn>
                    <v-btn color="success" text @click="submit_data()">Ruaj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import noteCard from "@/js/pages/note/note_card";
import axios from "@/js/config/axios.js";

export default {
    components: { noteCard },
    props: ["notes", "class_name", "id"],
    name: "noteSection",
    data() {
        return {
            new_note_dialog: false,
            saving_errors: [],
            new_note: {
                name: "",
                body: "",
                noteable_type: '',
                noteable_id: ''
            }
        };
    },
    methods: {
        deleteNote(id) {
            let currentObj = this;
            if (confirm("Konfirmo fshirjen e shenimit!") === false) {
                return;
            }
            axios(`/note/${id}`, {
                method: "delete"
            })
                .then(function(resp) {
                    currentObj.notes = currentObj.notes.filter(
                        note => note.id != id
                    );
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Shenimi u fshi!"
                    });
                })
                .catch(function(resp) {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Shenimi nuk u fshi!"
                    });
                });
        },
        submit_data() {
            let currentObj = this;
            currentObj.new_note.noteable_type = currentObj.class_name;
            currentObj.new_note.noteable_id = currentObj.id;

            axios
                .post("/note", currentObj.new_note)
                .then(function(resp) {
                    // console.log(this.notes)
                    currentObj.new_note_dialog = false;
                    currentObj.notes.push(resp.data.note);
                    currentObj.new_note= {
                name: "",
                body: "",
                noteable_type: '',
                noteable_id: ''
            }
                    currentObj.saving_errors = [];
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Shenimi u shtua me sukses!"
                    });
                })
                .catch(function(resp) {
                    currentObj.saving_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "warning",
                        text: "Shenimi nuk u shtua!"
                    });
                });
        }
    }
};
</script>

<style scoped>
</style>