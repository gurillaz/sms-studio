<template>
    <div class="mx-3">
        <v-row>
            <v-col>
                <div class="headline">Sherbimi</div>
            </v-col>

            <v-col class="text-right">
                <v-btn
                    @click.stop="edit_dialog = true"
                    class="mr-3"
                    color="warning"
                    outlined
                >Ndrysho</v-btn>
                <v-btn @click="delete_resource" color="error" outlined>Fshij</v-btn>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <v-card color>
                    <v-card-title>
                        <span class="headline pl-3">{{resource.name}}</span>
                        <div class="flex-grow-1"></div>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row class="py-0">
                                <v-col cols="4">
                                    <v-text-field
                                        :value="readable_date(resource.created_at, resource.updated_at)"
                                        label="Shtuar me date:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="3">
                                    <v-text-field
                                        :value="resource.created_by.name"
                                        label="Shtuar nga:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col cols="8" class="pt-0">
                                    <v-text-field :value="resource.name" label="Emri:" readonly></v-text-field>
                                </v-col>
                                <v-col cols="4" class="pt-0">
                                    <v-text-field :value="resource.price" label="Cmimi:" readonly></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col cols="12">
                                    <p
                                        class="small"
                                    >Detyrat ({{resource_relations.tasks.length}} detyra):</p>

                                    <v-chip
                                        pill
                                        v-for="(task,index) in resource_relations.tasks"
                                        v-bind:key="index"
                                        class="mr-2 mb-2 text-capitalize"
                                        :to="`/task/${task.id}`"
                                        target="_blank"
                                    >
                                        <v-avatar
                                            left
                                            color="orange"
                                            class="text-uppercase font-weight-bold white--text"
                                        >{{task.name.substring(0,1)}}</v-avatar>
                                        {{task.name}}
                                    </v-chip>
                                </v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col cols="4">
                                    <p>Puntore ({{resource_relations.tasks.length}} puntore):</p>
                                    <v-chip
                                        pill
                                        v-for="(task,index) in resource_relations.tasks"
                                        v-bind:key="index"
                                        class="mr-2 mb-2 text-capitalize"
                                    >
                                        <v-avatar
                                            left
                                            color="green"
                                            class="text-uppercase font-weight-bold white--text"
                                        >{{index+1}}</v-avatar>
                                        <span>Puntori {{index+1}}</span>
                                    </v-chip>
                                </v-col>
                                <v-col cols="8">
                                    <p>Pajisjet ({{resource_relations.inventory.length}} paisje):</p>
                                    <v-chip
                                        pill
                                        v-for="(inventory,index) in resource_relations.inventory"
                                        v-bind:key="index"
                                        class="mr-2 mb-2 text-capitalize"
                                        :to="`/inventory/${inventory.id}`"
                                        target="_blank"
                                        small
                                        label
                                    >
                                        <!-- <v-avatar
                                            left
                                            color="teal"
                                            class="text-uppercase font-weight-bold white--text"
                                        >{{inventory.name.substring(0,1)}}</v-avatar>-->
                                        {{inventory.name}}
                                    </v-chip>
                                </v-col>
                                <!-- <v-col cols="7">
                                    <p>Detyrat ({{resource_relations.tasks.length}} detyra):</p>

                                    <v-simple-table dense height="25vh" fixed-header>
                                        <template v-slot:default>
                                            <thead>
                                                <tr>
                                                    <th class="text-left">Detyra</th>
                                                    <th class="text-left">Pajisjet</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(task,index) in resource_relations.tasks" :key="index">
                                                    <td>
                                   <v-chip
                                        pill
                                        class="mr-2 my-1 text-capitalize"
                                        :to="`/task/${task.id}`"
                                        target="_blank"
                                    >
                                        <v-avatar
                                            left
                                            
                                            color="teal"
                                            class="text-uppercase font-weight-bold white--text"
                                        >{{task.name.substring(0,1)}}</v-avatar>
                                        {{task.name}}
                                    </v-chip>

                                                    </td>
                                                    <td class="py-2"> 
                                                        <span v-for="(inventory,index) in task.inventory" :key="index">
                                                           <span> {{inventory.name}}, </span>
                                                        </span>
                                    </td>
                                                </tr>
                                            </tbody>
                                        </template>
                                    </v-simple-table>
                                </v-col>-->
                            </v-row>

                            <v-row class="py-0">
                                <v-col cols="12">
                                    <v-text-field
                                        :value="resource.description"
                                        label="Te dhenat tjera::"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <relatedDataTables title="Te dhenat tjera" :relations="resource_relations"></relatedDataTables>

        <notesSection :notes="resource_relations.notes" :id="id" :class_name="resource.class_name"></notesSection>

        <v-dialog
            v-model="edit_dialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
        >
            <v-card color="grey lighten-5">
                <v-toolbar dark color="primary">
                    <v-toolbar-title>Ndrysho te dhenat</v-toolbar-title>
                    <div class="flex-grow-1"></div>
                    <v-toolbar-items>
                        <v-btn dark text @click="edit_dialog = false">Mbyll</v-btn>
                        <v-btn dark text @click="update_resource()">Ruaj</v-btn>
                    </v-toolbar-items>
                </v-toolbar>

                <v-container class="pa-1 mt-10">
                    <v-card outlined tile class="py-5 px-8">
                        <span class="text-uppercase">Te dhenat per sherbimin</span>
                        <v-row class="py-0">
                            <v-col cols="4">
                                <v-text-field
                                    :value="readable_date()"
                                    label="Shtuar me date:"
                                    disabled
                                ></v-text-field>
                            </v-col>
                            <v-col cols="3">
                                <v-text-field
                                    :value="resource.created_by.name"
                                    label="Shtuar nga:"
                                    disabled
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row class="mt-1">
                            <v-col class="py-1" cols="6">
                                <v-text-field
                                    :error-messages="saving_errors.name"
                                    label="Emri: *"
                                    v-model="edit_resource.name"
                                ></v-text-field>
                            </v-col>
                            <v-col class="py-1" cols="4">
                                <v-text-field
                                    :error-messages="saving_errors.price"
                                    label="Cmimi: *"
                                    v-model="edit_resource.price"
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
                                    :disabled="edit_resource.tasks.length==0"
                                >Kalkulo cmimin</v-btn>
                            </v-col>
                        </v-row>
                        <v-row class="py-5">
                            <v-col class="py-1" cols="10">
                                <v-autocomplete
                                    :error-messages="saving_errors.tasks"
                                    label="Detyrat:"
                                    v-model="edit_resource.tasks"
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
                        <v-row class="py-0" v-if="edit_resource.tasks.length!=0">
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

                        <v-row class="py-0">
                            <v-col class="py-1" cols="12">
                                <v-text-field
                                    :error-messages="saving_errors.description"
                                    label="Te dhena shtese:"
                                    v-model="edit_resource.description"
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
            </v-card>
        </v-dialog>
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
import moment, { now } from "moment";
import notesSection from "@/js/pages/note/notes_section";
import filesSection from "@/js/pages/file/files_section";
import relatedDataTables from "@/js/pages/others/related_data_tables";


import { mapFields } from "vuex-map-fields";
import { mapActions } from "vuex";

export default {
    components: { notesSection, filesSection,relatedDataTables },
    data() {
        return {
            edit_dialog: false,
            saving_errors: [],

            id: this.$route.params.id,
            class_name: "",
            status_items: [
                { text: "Aktive", value: "active" },
                { text: "Pasive", value: "pasive" }
            ],
            edit_resource: {
                id: "",
                name: "",
                tasks: [],
                preice: "",
                status: "active",
                created_by: {
                    id: "",
                    name: ""
                }
            },
            resource: {
                id: "",
                name: "",
                tasks: [],
                preice: "",
                status: "active",
                created_by: {
                    id: "",
                    name: ""
                }
            },
            resource_relations: {
                inventory: [],
                notes: [],
                tasks: []
            },

            new_task_dialog: false,

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
        ...mapFields({
            data_autofill: "data_autofill",
            auth: "auth",
            snackBar: "snackbar"
            // notification:"notification",
        }),
        get_employees_names() {
            let names = [];
            let counter = 1;
            this.edit_resource.tasks.forEach(task_id => {
                names.push(`Puntori ${counter}`);
                counter++;
            });
            return names;
        },
        get_inventory_names() {
            let inventory = [];
            // return [];
            this.data_autofill.tasks.forEach(task => {
                if (this.edit_resource.tasks.includes(task.id)) {
                    task.inventory.forEach(inv => {
                        inventory.push(inv);
                    });
                }
            });

            return inventory;
        }
    },
    beforeMount() {
        var currentObj = this;
        axios
            .get(`/service/${currentObj.id}`)
            .then(function(resp) {
                currentObj.resource = resp.data.resource;
                currentObj.resource_relations = resp.data.resource_relations;
                currentObj.data_autofill = resp.data.data_autofill;
                /* Using JSON.parse to copy object, since just asignin resp.data.note only references data
                    note end edit_note keep changing when used as vue v-model
                    Based on: https://scotch.io/bar-talk/copying-objects-in-javascript
                     */
                currentObj.edit_resource = JSON.parse(
                    JSON.stringify(resp.data.resource)
                );
                currentObj.edit_resource[
                    "tasks"
                ] = currentObj.resource_relations.tasks.map(task => task.id);
                currentObj.edit_resource = JSON.parse(
                    JSON.stringify(currentObj.edit_resource)
                );
            })
            .catch(function(resp) {
                console.log(resp);
                currentObj.$store.dispatch("showSnackbar", {
                    color: "error",
                    text: "Serveri nuk dergoi te dhenat!"
                });
            });
    },
    methods: {
        ...mapActions({
            notification: "showSnackbar" // map `this.add()` to `this.$store.dispatch('increment')`
        }),
        calculate_service_price() {
            let price = 0;

            this.data_autofill.tasks.forEach(task => {
                if (this.edit_resource.tasks.includes(task.id)) {
                    price = price + Number(task.payment_sum);
                }
            });

            if (price == 0) {
                this.edit_resource.price = "";
            }
            this.edit_resource.price = price;
        },

        get_all_tasks_inventory(tasks) {
            let inventory = [];
            tasks.forEach(task => {
                task.inventory.forEach(inv => {
                    inventory.push(inv);
                });
            });
            return inventory;
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
        submit_new_task_data: function() {
            let currentObj = this;

            axios
                .post(`/task`, currentObj.new_task)
                .then(function(resp) {
                    // console.log(resp.data.resource)
                    currentObj.new_task_saving_errors = [];
                    currentObj.new_task = {
                        name: "",
                        description: "",
                        payment_sum: "",
                        inventory: [],
                        status: "template"
                    };
                    currentObj.edit_resource.tasks.push(resp.data.resource.id);
                    currentObj.data_autofill.tasks.push(resp.data.resource);
                    currentObj.resource_relations.tasks.push(
                        resp.data.resource
                    );
                    currentObj.new_task_dialog = false;

                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Te dhenat u ruajten!"
                    });
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
        },
        update_resource: function() {
            let currentObj = this;

            /* Create new object with properties from fileds, ONLY if field has a value.(remove properties with empty fileds) This to comply with vlidation rules in
            CreateInventoryRequest, for attributes where validation "sometimes" is set.
            
            */
            let data = {};
            Object.keys(currentObj.edit_resource).forEach(function(prop) {
                if (
                    currentObj.edit_resource[prop] != "" ||
                    currentObj.edit_resource[prop] != null
                ) {
                    data[prop] = currentObj.edit_resource[prop];
                }
            });

            axios
                .put(`/service/${currentObj.id}`, data)
                .then(function(resp) {
                    currentObj.saving_errors = [];
                    currentObj.edit_dialog = false;
                    currentObj.resource = resp.data.resource;
                    currentObj.resource_relations =
                        resp.data.resource_relations;
                    currentObj.data_autofill = resp.data.data_autofill;
                    /* Using JSON.parse to copy object, since just asignin resp.data.note only references data
                    note end edit_note keep changing when used as vue v-model
                    Based on: https://scotch.io/bar-talk/copying-objects-in-javascript
                     */
                    currentObj.edit_resource = JSON.parse(
                        JSON.stringify(resp.data.resource)
                    );
                    currentObj.edit_resource.tasks = currentObj.resource_relations.tasks.map(
                        task => task.id
                    );
                    currentObj.edit_resource = JSON.parse(
                        JSON.stringify(currentObj.edit_resource)
                    );
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Ndryshimet u ruajten!"
                    });
                })
                .catch(function(resp) {
                    currentObj.saving_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Ndryshimet nuk u ruajten!"
                    });
                });
        },
        delete_resource() {

            let currentObj = this;
            if (confirm("Konfirmo fshirjen e e puntorit!") === false) {
                return;
            }
            axios(`/service/${currentObj.id}`, {
                method: "delete"
            })
                .then(function(resp) {
                    currentObj.$route.go("/service");
                    this.notification({
                        color: "success",
                        text: "U fshi me sukses"
                    });
                })
                .catch(function(resp) {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Nuk u fshi, rifresko faqen!"
                    });
                });
        }
    }
};
</script>