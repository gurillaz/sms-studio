<template>
    <div class="mx-3">
        <v-row>
            <v-col>
                <div class="headline">Pagesa</div>
            </v-col>

            <v-col class="text-right">
                <v-btn
                    @click.stop="edit_dialog = true"
                    class="mr-3"
                    color="warning"
                    outlined
                >Ndrysho
                </v-btn>
                <v-btn @click="delete_resource" color="error" outlined>Fshij</v-btn>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <v-card color="green lighten-5">
                    <v-card-title>
                        <span class="headline pl-3">{{payment.name}}</span>
                        <div class="flex-grow-1"></div>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="4">
                                    <v-text-field
                                        :value="readable_date(payment.created_at, payment.updated_at)"
                                        label="Shtuar me date:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        :value="payment.created_by.name"
                                        label="Shtuar nga:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        :value="payment.model != '' ? `${payment.belongs_to.name} (${belongs_to_readable(payment.model)})` : '' "
                                        label="I takon::"
                                        readonly
                                                :disabled="payment.model == ''"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="pt-6" cols="2">
                                    <v-btn
                                        :to="payment.model != ''?`/${payment.model}/${payment.belongs_to.id}`:''"
                                        block
                                        text
                                        :disabled="payment.model == ''"
                                    >Shiko burimin
                                    </v-btn>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        :value="readable_type(payment.type)"
                                        label="Hyrje/Dalje:"
                                        readonly
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="3">
                                    <v-text-field :value="payment.category" label="Kategoria:" readonly></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field :value="payment.from" label="Nga:" readonly></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field :value="payment.to" label="Per:" readonly></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field :value="payment.amount" label="Shuma:" readonly></v-text-field>
                                </v-col>

                                <v-col cols="3">
                                    <v-text-field
                                        :value="payment.name"
                                        label="Emri:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-text-field
                                        :value="payment.description"
                                        label="Pershkrimi:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <filesSection :class_name="payment.class_name" :files="payment.files" :id="id"></filesSection>

        <notesSection :class_name="payment.class_name" :id="payment.id" :notes="payment.notes"></notesSection>

        <v-dialog max-width="75vw" persistent v-model="edit_dialog">
            <v-card class="py-5 px-8" color="green lighten-5" outlined>
                <v-container>
                    <v-row>
                        <v-col cols="4">
                            <v-text-field
                                :value="readable_date()"
                                disabled
                                label="Shtuar me date:"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field
                                :value="payment.created_by.name"
                                disabled
                                label="Shtuar nga:"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field
                                :value="`${payment.belongs_to.name} (${belongs_to_readable(payment.model)})`"
                                disabled
                                label="I takon::"
                            ></v-text-field>
                        </v-col>
                        <v-col class="pt-6" cols="2">
                            <v-btn
                                :to="`/${payment.model}/${payment.belongs_to.id}`"
                                block
                                disabled
                                text
                            >Shiko burimin
                            </v-btn>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field
                                :value="readable_type(payment.type)"
                                label="Hyrje/Dalje:"
                                readonly
                            ></v-text-field>
                        </v-col>

                        <v-col cols="3">
                            <v-text-field label="Nga:" v-model="edit_payment.from"></v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field label="Per:" v-model="edit_payment.to"></v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field label="Shuma:" v-model="edit_payment.amount" :error-message="updating_errors.amount"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="3">
                            <v-text-field
                                label="Emri:"
                                v-model="edit_payment.name"
                                :error-message="updating_errors.name"

                            ></v-text-field>
                        </v-col>
                        <v-col cols="9">
                            <v-text-field
                                label="Pershkrimi:"
                                v-model="edit_payment.description"
                                :error-message="updating_errors.description"


                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-container>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn @click="edit_dialog = false" color="warning" text>Mbyll</v-btn>
                    <v-btn @click="update()" color="success" text>Ruaj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import axios from "@/js/config/axios.js";
    import no_config_axios from "axios";
    import moment from "moment";
    import notesSection from "@/js/pages/note/notes_section";

    import filesSection from "@/js/pages/file/files_section";

    export default {
        components: {notesSection, filesSection},
        props: ["id"],
        data() {
            return {
                edit_dialog: false,
                updating_errors:[],
                edit_payment: {
                    id: "",
                    name: "",
                    from: "",
                    to: "",
                    amount: "",
                    type: "",
                    description: "",

                },
                payment: {
                    id: "",
                    name: "",
                    from: "",
                    to: "",
                    amount: "",
                    type: "",
                    description: "",
                    created_at: "",
                    updated_at: "",
                    created_by: {},

                    belongs_to: {},
                    class_name: "",
                    model: "",
                    files: [],
                    notes: []
                }
            };
        },

        methods: {
            readable_type(type) {
                if (type == "in") {
                    return "Hyrje";
                } else if (type == "out") {
                    return "Dalje";
                } else {
                    return type;
                }
            },
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
                if (belongs_to === "Inventory") {
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

            update() {
                let currentObj = this;


                axios
                    .put("/payment/" + currentObj.payment.id, currentObj.edit_payment)
                    .then(function (resp) {
                        currentObj.updating_errors = [];
                        currentObj.edit_dialog = false;

                        currentObj.payment = resp.data.payment;

                        /* Using JSON.parse to copy object, since just asignin resp.data.note only references data
                    note end edit_note keep changing when used as vue v-model
                    Based on: https://scotch.io/bar-talk/copying-objects-in-javascript
                     */
                        currentObj.edit_payment = JSON.parse(
                            JSON.stringify(resp.data.payment)
                        );
                        currentObj.$store.dispatch("showSnackbar", {
                            color: "success",
                            text: "Te dhenat u ruajten."
                        });
                    })
                    .catch(function (resp) {
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
                if (confirm("Konfirmo fshirjen e pageses!") == false) {
                    return;
                }
                axios
                    .delete(`/payment/${currentObj.payment.id}`)
                    .then(function (resp) {
                        currentObj.$router.push("/payment/all");
                        currentObj.$store.dispatch("showSnackbar", {
                            color: "success",
                            text: "Pagesa u fshi!"
                        });
                    })
                    .catch(function (resp) {
                        currentObj.$store.dispatch("showSnackbar", {
                            color: "error",
                            text: "Pagesa nuk u fshi"
                        });
                    });
            }
        },

        beforeMount() {
            let currentObj = this;
            axios
                .get(`/payment/${currentObj.id}`)
                .then(function (resp) {
                    // console.log(resp.data);

                    currentObj.payment = resp.data.payment;

                    /* Using JSON.parse to copy object, since just asignin resp.data.note only references data
                    note end edit_note keep changing when used as vue v-model
                    Based on: https://scotch.io/bar-talk/copying-objects-in-javascript
                     */
                    currentObj.edit_payment = JSON.parse(
                        JSON.stringify(resp.data.payment)
                    );
                    // currentObj.belongs_to = resp.data.belongs_to;
                    // currentObj.created_by = resp.data.created_by;
                    // currentObj.model = resp.data.model;
                })
                .catch(function (resp) {
                    // console.log(resp);
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Serveri nuk dergoi te dhenat. Rifresko faqen!"
                    });
                });
        }
    };
</script>
