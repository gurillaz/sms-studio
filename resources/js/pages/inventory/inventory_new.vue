<template>
    <div class="mx-3">
        <v-card>
            <v-card-title>
                <v-icon left>mdi-camera-plus-outline</v-icon>Shto pajisje te re
                <div class="flex-grow-1"></div>
            </v-card-title>
            <v-container>
                <v-row class="mx-5">
                    <v-container class="pa-1">
                        <v-card outlined tile class="py-5 px-8">
                            <!-- titulli -->
                            <span class="text-uppercase">Te dhenat baze</span>

                            <v-row class="py-0">
                                <v-col class="py-1" cols="9">
                                    <v-text-field
                                        :error-messages="saving_errors.name"
                                        label="Emri: *"
                                        v-model="new_inventory.name"
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col class="py-1" cols="5">
                                    <v-combobox
                                        :error-messages="saving_errors.type"
                                        label="Lloji i pajisjes: *"
                                        hint="Shtyp te re ose zgjedh nga lista"
                                        persistent-hint
                                        v-model="new_inventory.type"
                                        :items="data.types"
                                        item-text="type"
                                        clearable
                                    ></v-combobox>
                                </v-col>
                                <v-col class="py-1" cols="4">
                                    <v-text-field
                                        :error-messages="saving_errors.serial"
                                        label="Nr. serial:"
                                        v-model="new_inventory.serial"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-1" cols="3">
                                    <v-text-field
                                        :error-messages="saving_errors.status"
                                        label="Statusi: *"
                                        v-model="new_inventory.status"
                                        disabled
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col class="py-1" cols="12">
                                    <v-text-field
                                        :error-messages="saving_errors.description"
                                        label="Te dhena shtese:"
                                        hint="Shtype te dhena shtese per pajisjen"
                                        v-model="new_inventory.description"
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col class="text-left" cols="2">
                                    <small>*duhet te plotesohen</small>
                                </v-col>
                                <div class="flex-grow-1"></div>
                            </v-row>
                        </v-card>
                    </v-container>
                </v-row>

                <v-row class="mx-5 mt-4">
                    <v-container class="pa-1">
                        <v-card outlined tile class="py-5 px-8">
                            <!-- titulli -->
                            <v-row class="px-2 mb-3">
                                <span class="text-uppercase">Te dhenat e furnizimit</span>
                                <div class="flex-grow-1"></div>
                            </v-row>
                            <!-- body -->
                            <!-- body -->
                            <v-row class="py-0">
                                <v-col class="py-1" cols="4">
                                    <v-text-field
                                        :error-messages="saving_errors.price"
                                        label="Cmimi i furnizimit:"
                                        v-model="new_inventory.price"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-1" cols="5">
                                    <v-combobox
                                        :error-messages="saving_errors.supplier"
                                        label="Furnitori:"
                                        hint="Shtyp te re ose zgjedh nga lista"
                                        persistent-hint
                                        v-model="new_inventory.supplier"
                                        :items="data.suppliers"
                                        item-text="type"
                                        clearable
                                    ></v-combobox>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col class="py-1" cols="4">
                                    <v-menu
                                        :close-on-content-click="false"
                                        max-width="290"
                                        v-model="date_picker"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                :value="readable_date"
                                                :error-messages="saving_errors.purchase_date"
                                                label="Data e blerjes:"
                                                hint="Zgjidh daten ne kalendar"
                                                persistent-hint
                                                readonly
                                                v-on="on"
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="new_inventory.purchase_date"
                                            @change="date_picker = false"
                                        ></v-date-picker>
                                    </v-menu>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col class="text-left" cols="2">
                                    <small>*duhet te plotesohen</small>
                                </v-col>
                                <div class="flex-grow-1"></div>
                            </v-row>
                        </v-card>
                    </v-container>
                </v-row>

                <v-row class="mx-1 mt-5">
                    <div class="flex-grow-1"></div>

                    <v-col cols="3" class="pt-0 pr-5">
                        <v-btn
                            :disabled="false"
                            @click="submit_data"
                            color="success"
                            block
                            outlined
                        >Ruaj te dhenat</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";

export default {
    components: {},
    data() {
        return {
            date_picker: false,
            new_inventory: {
                name: "",
                description: "",
                price: "",
                supplier: "",
                purchase_date: "",
                type: "",
                serial: "",
                status: "active"
            },
            data: {},
            saving_errors: []
        };
    },
    computed: {
        readable_date() {
            moment.locale("sq");
            return this.new_inventory.purchase_date
                ? moment(this.date).format("D MMMM  YYYY, dddd")
                : "";
        }
    },
    methods: {
        submit_data: function() {
            let currentObj = this;
            /* Create new object with properties from fileds, ONLY if field has a value.(remove properties with empty fileds) This to comply with vlidation rules in
            CreateInventoryRequest, for attributes where validation "sometimes" is set.
            
            */
            let data = {};
            Object.keys(currentObj.new_inventory).forEach(function(prop) {
                if (currentObj.new_inventory[prop] != "") {
                    return (data[prop] = currentObj.new_inventory[prop]);
                }
            });

            // console.log(data);

            axios
                .post(`/inventory`, data)
                .then(function(resp) {
                    currentObj.saving_errors = false;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Klienti u krijua!"
                    });
                    currentObj.$router.push(
                        `/inventory/${resp.data.new_inventory_id}`
                    );
                })
                .catch(function(resp) {
                    console.log(resp.data);

                    currentObj.saving_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Te dhenat nuk u ruajten"
                    });
                });
        }
    },
    beforeMount: function() {
        let currentObj = this;
        axios
            .get("/inventory/create")
            .then(function(resp) {
                // console.log(resp.data);

                currentObj.data = resp.data.data;

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
