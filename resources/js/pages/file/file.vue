<template>
    <div class="mx-3">
        <v-row>
            <v-col>
                <div class="headline">Fajlli</div>
            </v-col>

            <v-col class="text-right">
                <v-btn
                    outlined
                    color="warning"
                    class="mr-3"
                    @click.stop="edit_dialog = true"
                >Ndrysho</v-btn>
                <v-btn 
                outlined 
                color="error"
                @click="delete_resource"
                
                >Fshij</v-btn>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <v-card color="indigo lighten-5" style="min-height:77vh">
                    <v-card-title>
                        <span class="headline pl-3">{{file.name}}</span>
                        <div class="flex-grow-1"></div>
                        <v-col cols="4" class="py-0">
                            <v-btn
                                color="primary darken-1"
                                block
                                large
                                @click="download_file"
                            >Shkarko ({{file.file_size}}Mb)</v-btn>
                        </v-col>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="4">
                                    <v-text-field
                                        label="Shtuar me date:"
                                        :value="readable_date(file.created_at, file.updated_at)"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        label="Shtuar nga:"
                                        :value="file.created_by.name"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        label="I takon::"
                                        :value="`${file.belongs_to.name} (${belongs_to_readable(file.model)})`"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="2" class="pt-6">
                                    <v-btn
                                        block
                                        text
                                        :to="`/${file.model}/${file.belongs_to.id}`"
                                    >Shiko burimin</v-btn>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        label="Shtesa e fajllit:"
                                        :value="file.file_extension"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        label="Lloji i fajllit:"
                                        :value="file.file_type"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        label="Emri i fajllit:"
                                        :value="file.file_name"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        label="Madhesia e fajllit:"
                                        :value="`${file.file_size} Mb`"
                                        readonly
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="6">
                                    <v-text-field label="Emri:" :value="file.name" readonly></v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-text-field
                                        label="Pershkrimi:"
                                        :value="file.description"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <!-- {{file}} -->
                            </v-row>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-col>
            <form action="#" method="get" ref="downloadForm" style="display: none;"></form>
        </v-row>
        <v-dialog v-model="edit_dialog" persistent max-width="75vw">
            <v-card color="indigo lighten-5">
                <v-card-title>
                    <span class="headline pl-3">Ndrysho te dhenat</span>
                </v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-row>
                            <v-col cols="4">
                                <v-text-field
                                    label="Shtuar me date:"
                                    :value="readable_date()"
                                    disabled
                                ></v-text-field>
                            </v-col>
                            <v-col cols="3">
                                <v-text-field
                                    label="Shtuar nga:"
                                    :value="file.created_by.name"
                                    disabled
                                ></v-text-field>
                            </v-col>
                            <v-col cols="3">
                                <v-text-field
                                    label="I takon::"
                                    :value="`${file.belongs_to.name} (${belongs_to_readable(file.model)})`"
                                    disabled
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2" class="pt-6">
                                <v-btn
                                    block
                                    text
                                    :to="`/${file.model}/${file.belongs_to.id}`"
                                    disabled
                                >Shiko burimin</v-btn>
                            </v-col>

                            <v-col cols="12">
                                <v-text-field
                                    :error-messages="updating_errors.name"
                                    label="Emri:"
                                    v-model="edit_file.name"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    :error-messages="updating_errors.description"
                                    label="Pershkrimi:"
                                    v-model="edit_file.description"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-file-input
                                    :error-messages="updating_errors.file"
                                    show-size
                                    v-model="edit_file_new_file"
                                    label="Zgjidh fajllin:"
                                ></v-file-input>
                            </v-col>
                            <!-- {{file}} -->
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="warning" text @click="edit_dialog = false">Mbyll</v-btn>
                    <v-btn color="success" text @click="update">Ruaj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import no_config_axios from "axios";
import moment from "moment";

export default {
    props: ["id"],
    data() {
        return {
            edit_dialog: false,
            edit_file: {
                name: "",
                description: ""
            },
            edit_file_new_file: [],

            updating_errors: [],

            file: {
                id: "",
                name: "",
                description: "",
                created_at: "",
                updated_at: "",
                created_by: {},
                file_extension: "",
                file_type: "",
                file_size: "",
                file_name: "",
                belongs_to: {},
                model: ""
            }
        };
    },

    methods: {
        readable_date(created_at, updated_at) {
            moment.locale("sq");
            if (created_at === updated_at) {
                return moment(updated_at).format("D MMMM YYYY [ora] H:m");
            } else {
                return (
                    moment(updated_at).format("D MMMM YYYY [ora] H:m") +
                    " (E modifikuar)"
                );
            }
        },
        belongs_to_readable(belongs_to) {
            if (belongs_to === "Employee") {
                return "Puntor";
            }
            if (belongs_to === "Client") {
                return "Klient";
            }
            if (belongs_to === "Job") {
                return "Pune";
            }
            if (belongs_to === "Event") {
                return "Event";
            }
            if (belongs_to === "File") {
                return "Fajll";
            }
            if (belongs_to === "Inevntory") {
                return "Pajisje";
            }
            if (belongs_to === "Note") {
                return "Shenim";
            }
            if (belongs_to === "Offer") {
                return "Oferte";
            }
            if (belongs_to === "Payment") {
                return "Pagese";
            }
            if (belongs_to === "Service") {
                return "Sherbim";
            }
            if (belongs_to === "Task") {
                return "Detyre";
            } else {
                return belongs_to;
            }
        },

        redirect_to_belonger() {
            this.$router.push(`/${this.model}/${this.belongs_to.id}`);
        },
        download_file() {
            let currentObj = this;
            axios
                .get(`/checkIfFileExists/${currentObj.file.file_name}`)
                .then(resp => {
                    currentObj.$refs.downloadForm.action = resp.data.path;
                    currentObj.$refs.downloadForm.submit();
                })
                .catch(resp => {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "warning",
                        text: "Fajlli nuk u gjet ne server!"
                    });
                });
        },
        update() {
            let currentObj = this;
            let formdata = new FormData();
            formdata.append("_method", "PUT");
            formdata.append("name", currentObj.edit_file.name);
            formdata.append("description", currentObj.edit_file.description);
            /* If new file is not provided, don't submit an emty file to pass validation. */
            if (currentObj.edit_file_new_file.length != 0) {
                formdata.append("file", currentObj.edit_file_new_file);
            }

            axios
                .post("/file/" + currentObj.file.id, formdata, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(function(resp) {
                    currentObj.updating_errors = [];
                    currentObj.edit_dialog = false;

                    currentObj.file = resp.data.file;

                    /* Using JSON.parse to copy object, since just asignin resp.data.note only references data 
                note end edit_note keep changing when used as vue v-model
                Based on: https://scotch.io/bar-talk/copying-objects-in-javascript
                 */
                    currentObj.edit_file = JSON.parse(
                        JSON.stringify(resp.data.file)
                    );
                    edit_file_new_file = [];
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Te dhenat u ruajten."
                    });
                })
                .catch(function(resp) {
                    // console.log(resp.response);
                    currentObj.updating_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Te dhenat nuk u ruajten!"
                    });
                });
        },
        delete_resource() {
            let currentObj = this;
                   if (confirm("Konfirmo fshirjen e fajllit!") == false) {
                return;
            }
            axios.delete(`/file/${currentObj.file.id}`)
                .then(function(resp) {
                    currentObj.$router.push('/file/all');
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
        
        }
    },

    beforeMount() {
        let currentObj = this;
        axios
            .get(`/file/${currentObj.id}`)
            .then(function(resp) {
                // console.log(resp.data);

                currentObj.file = resp.data.file;

                /* Using JSON.parse to copy object, since just asignin resp.data.note only references data 
                note end edit_note keep changing when used as vue v-model
                Based on: https://scotch.io/bar-talk/copying-objects-in-javascript
                 */
                currentObj.edit_file = JSON.parse(
                    JSON.stringify(resp.data.file)
                );
                // currentObj.belongs_to = resp.data.belongs_to;
                // currentObj.created_by = resp.data.created_by;
                // currentObj.model = resp.data.model;
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