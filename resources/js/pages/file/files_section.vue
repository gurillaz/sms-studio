<template>
    <div class="mt-5">
        <v-row>
            <v-col>
                <div class="headline">Fajllat</div>
            </v-col>

            <v-col class="text-right">
                <v-btn
                    outlined
                    dark
                    @click.stop="new_file_dialog = true"
                    color="primary"
                    class="mr-3"
                >Shto fajll</v-btn>
            </v-col>
        </v-row>
        <v-row v-if="files.length > 0">
            <fileCard v-for="file in files" v-bind:key="file.id" :file="file"></fileCard>
        </v-row>

        <v-row v-if="files.length == 0">
            <v-col cols="12" class="ma-12 text-center">
                <p class="display-1 grey--text">Nuk ka fajlla te ruajtura</p>
            </v-col>
        </v-row>
        <v-dialog v-model="new_file_dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">Fajll i ri</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row v-show="new_file_errors != false">
                            <v-col cols="12" sm="6" md="12">
                                <v-sheet color="red lighten-3" class="pa-3">
                                    <ul>
                                        <!--     <template v-for="field_error in new_file_errors">
                                            <li class="white--text font-weight-bold" v-for="error in field_error">
                                                {{error}}
                                            </li>
                                        </template>-->
                                    </ul>
                                </v-sheet>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field v-model="new_file_name" label="Emri*" required></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea
                                    outlined
                                    label="Pershkrimi"
                                    rows="6"
                                    v-model="new_file_description"
                                ></v-textarea>
                            </v-col>

                            <v-col cols="12">
                                <v-file-input
                                    show-size
                                    v-model="new_file_file"
                                    label="Zgjidh fajllin"
                                ></v-file-input>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small>*Duhet te plotesohen</small>
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="blue darken-1" text @click="new_file_dialog = false">Mbyll</v-btn>
                    <v-btn color="blue darken-1" text @click="newFile()">Ruaj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import fileCard from "@/js/pages/file/file_card";
import axios from "@/js/config/axios.js";

export default {
    components: { fileCard },
    props: ["files", "class_name", "id"],
    name: "fileSection",
    data() {
        return {
            new_file_name: "",
            new_file_file: [],
            new_file_description: "",
            new_file_dialog: false,
            new_file_errors: false
        };
    },
    methods: {
        deleteFile(id) {
            let currentObj = this;
            if (confirm("Konfirmo fshirjen e fajllit!") == false) {
                return;
            }
            axios(`/file/${id}`, {
                method: "delete"
            })
                .then(function(resp) {
                    currentObj.files = currentObj.files.filter(
                        file => file.id != id
                    );

                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Fajlli u fshi!"
                    });
                })
                .catch(function(resp) {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Fajlli nuk u fshi"
                    });
                });
        },
        newFile() {
            let currentObj = this;
            let formdata = new FormData();
            formdata.append("name", currentObj.new_file_name);
            formdata.append("description", currentObj.new_file_description);
            formdata.append("file", currentObj.new_file_file);
            formdata.append("fileable_type", currentObj.class_name);
            formdata.append("fileable_id", currentObj.id);

            axios
                .post("/file", formdata, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(function(resp) {
                    // console.log(this.files)
                    currentObj.files.push(resp.data.file);
                    currentObj.new_file_dialog = false;
                    currentObj.new_file_errors = false;
                    currentObj.new_file_name = "";
                    currentObj.new_file_file = [];
                    currentObj.new_file_description = "";
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Fajlli u shtua me sukses!"
                    });
                })
                .catch(function(resp) {
                    currentObj.new_file_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "warning",
                        text: "Fajlli nuk u shtua!"
                    });
                });
        }
    }
};
</script>

<style scoped>
</style>