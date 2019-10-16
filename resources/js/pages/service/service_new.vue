<template>
    <div class="mx-3">
        <v-card>
            <v-card-title>
                <v-icon left>mdi-camera-plus-outline</v-icon>Shto sherbim te ri
                <div class="flex-grow-1"></div>
            </v-card-title>
            <v-container>
                <v-row class="mx-5">
                    <v-container class="pa-1">
                        <v-card outlined tile class="py-5 px-8">
                            <!-- titulli -->
                            <span class="text-uppercase">Te dhenat per sherbimin</span>

                            <v-row class="py-5">
                                <v-col class="py-1" cols="10">
                                    <v-autocomplete
                                        :error-messages="saving_errors.tasks"
                                        label="Detyrat:"
                                        v-model="new_resource.tasks"
                                        :items="data_autofill.tasks"
                                        item-text="name"
                                        item-value="id"
                                        multiple
                                        chips
                                        deletable-chips
                                        hide-selected
                                        hint="Zgjidh nga detyrat(shabllon) egzistuese."
                                        persistent-hint
                                    ></v-autocomplete>
                                </v-col>
                                <v-col class="py-1" cols="2">
                                    <v-btn
                                        block
                                        text
                                        color="primary"
                                        class="mt-5"
                                        @click="new_task_dialog = true"
                                    >Shto detyre te re</v-btn>
                                </v-col>
                            </v-row>
                            <v-row class="py-0" v-if="new_resource.tasks.length!=0">
                                <v-col cols="4">
                                    <p>Puntore ({{get_employees_names.length}} puntore):</p>
                                    <v-chip
                                        pill
                                        v-for="(employee,index) in get_employees_names"
                                        v-bind:key="index"
                                        class="mr-2 mb-2 text-capitalize"
                                    >
                                        <v-avatar
                                            left
                                            color="green"
                                            class="text-uppercase font-weight-bold white--text"
                                        >{{index+1}}</v-avatar>
                                        <span>{{employee}}</span>
                                    </v-chip>
                                </v-col>
                                <v-col cols="8">
                                    <p>Paisjet ({{get_inventory_names.length}} paisje):</p>
                                    <v-chip
                                        pill
                                        v-for="(inventory,index) in get_inventory_names"
                                        v-bind:key="index"
                                        class="mr-2 mb-2 text-capitalize"
                                        :to="`/inventory/${inventory.id}`"
                                        target="_blank"
                                        small
                                        label
                                    >{{inventory.name}}</v-chip>
                                </v-col>
                            </v-row>
                            <v-row class="mt-1">
                                <v-col class="py-1" cols="6">
                                    <v-text-field
                                        :error-messages="saving_errors.name"
                                        label="Emri: *"
                                        v-model="new_resource.name"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-1" cols="4">
                                    <v-text-field
                                        :error-messages="saving_errors.price"
                                        label="Cmimi: *"
                                        v-model="new_resource.price"
                                        hint="Cmimi i sherbimit. Kliko 'Kalkulo cmimin', per cmimin e sherbimeve ne baze te detyrave te zgjedhura."
                                        persistent-hint
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-1" cols="2">
                                    <v-btn
                                        block
                                        text
                                        class="mt-5"
                                        @click="calculate_service_price()"
                                        :disabled="new_resource.tasks.length==0"
                                    >Kalkulo cmimin</v-btn>
                                </v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col class="py-1" cols="12">
                                    <v-text-field
                                        :error-messages="saving_errors.description"
                                        label="Te dhena shtese:"
                                        v-model="new_resource.description"
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
        <v-dialog v-model="new_task_dialog" persistent max-width="75vw">
            <v-card color>
                <v-card-title>
                    <span class="headline pl-3">Shto detyre te re</span>
                    <div class="flex-grow-1"></div>
                </v-card-title>
                <v-card-text>
                    <v-container class="pa-1">
                        <v-card outlined tile class="py-5 px-8">
                            <!-- titulli -->
                            <span class="text-uppercase">Te dhenat per detyren</span>

                            <v-row class="py-0">
                                <v-col class="py-1" cols="6">
                                    <v-text-field
                                        label="Puntori:"
                                        disabled
                                        hint="Puntori qe kryen detyren. Caktohet te Puna/Eventi."
                                        persistent-hint
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-1" cols="6">
                                    <v-text-field
                                        label="Eventi:"
                                        disabled
                                        hint="Eventi ku duhet te kryhet detyra. Caktohet te Puna/Eventi."
                                        persistent-hint
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="mt-10">
                                <v-col class="py-1" cols="6">
                                    <v-text-field
                                        :error-messages="new_task_saving_errors.name"
                                        label="Emri: *"
                                        v-model="new_task.name"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-1" cols="6">
                                    <v-text-field
                                        :error-messages="new_task_saving_errors.payment_sum"
                                        label="Pagesa: *"
                                        v-model="new_task.payment_sum"
                                        hint="Shuma e pageses per te cilen paguhet puntori per kryerjen e detyres. Ne baze te detyrave qe kryne puntori, caktohet rroga."
                                        persistent-hint
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="py-5">
                                <v-col class="py-1" cols="12">
                                    <v-autocomplete
                                        :error-messages="new_task_saving_errors.inventory"
                                        label="Pajisjet:"
                                        v-model="new_task.inventory"
                                        :items="data_autofill.inventory"
                                        item-text="name"
                                        item-value="id"
                                        multiple
                                        chips
                                        deletable-chips
                                        hide-selected
                                        hint="Zgjedh nga lista nje ose me shume opsione. Pajisjet qe do perdoren ne detyre. Psh. per detyren 'Fotograf', duhen pajisjet si foto-aparati, baterit rezerve, tripod etj. "
                                        persistent-hint
                                    ></v-autocomplete>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col class="py-1" cols="12">
                                    <v-text-field
                                        :error-messages="new_task_saving_errors.description"
                                        label="Te dhena shtese:"
                                        v-model="new_task.description"
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
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn @click="new_task_dialog = false" color="warning" text>Mbyll</v-btn>
                    <v-btn @click="submit_new_task_data()" color="success" text>Ruaj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";

export default {
    components: {},
    data() {
        return {
            new_task_dialog: false,
            new_resource: {
                name: "",
                description: "",
                price: "",
                tasks: [],
                status: "template"
            },
            saving_errors: [],

            data_autofill: {
                tasks: [],
                inventory: []
            },

            new_task: {
                name: "",
                description: "",
                payment_sum: "",
                inventory: [],
                status: "template"
            },
            new_task_saving_errors: []
        };
    },
    computed: {
        get_employees_names() {
            let names = [];
            let counter = 1;
            this.new_resource.tasks.forEach(task_id => {
                names.push(`Puntori ${counter}`);
                counter++;
            });
            return names;
        },
        get_inventory_names() {
            let inventory = [];

            this.data_autofill.tasks
                  .forEach(task => {
                    if(this.new_resource.tasks.includes(task.id)){
                    task.inventory.forEach(inv => {
                        inventory.push(inv);
                    });
                    }
                });

            return inventory;
        }
    },
    methods: {
        calculate_service_price() {
            let price = 0;
            this.data_autofill.tasks
                .filter(ts => this.new_resource.tasks.includes(ts.id))
                .forEach(task => {
                    price = price + Number(task.payment_sum);
                });
            if (price == 0) {
                this.new_resource.price = "";
            }
            this.new_resource.price = price;
        },

        submit_data: function() {
            let currentObj = this;

            axios
                .post(`/service`, currentObj.new_resource)
                .then(function(resp) {
                    currentObj.saving_errors = [];
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Te dhenat u ruajten!"
                    });
                    currentObj.$router.push(
                        `/service/${resp.data.resource.id}`
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
        },
        submit_new_task_data: function() {
            let currentObj = this;

            axios
                .post(`/task`, currentObj.new_task)
                .then(function(resp) {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Te dhenat u ruajten!"
                    });
                    // console.log(resp.data.resource)
                    currentObj.new_task_saving_errors = [];
                    new_task = {
                        name: "",
                        description: "",
                        payment_sum: "",
                        inventory: [],
                        status: "template"
                    };
                    currentObj.new_resource.tasks.push(resp.data.resource.id);
                    currentObj.data_autofill.tasks.push(resp.data.resource);
                    currentObj.new_task_dialog = false;
                })
                .catch(function(resp) {
                    // console.log(resp.data);

                    currentObj.new_task_saving_errors =
                        resp.response.data.errors;
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
            .get("/service/create")
            .then(function(resp) {
                currentObj.data_autofill = resp.data.data_autofill;
            })
            .catch(function(resp) {
                currentObj.$store.dispatch("showSnackbar", {
                    color: "error",
                    text: "Serveri nuk dergoi te dhenat. Rifresko faqen!"
                });
            });
    }
};
</script>
