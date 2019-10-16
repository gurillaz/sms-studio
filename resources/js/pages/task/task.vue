<template>
    <div class="mx-3">
        <v-row>
            <v-col>
                <div class="headline">
                    Detyra
                    <span v-if="resource.status == 'template'">(Shabllon)</span>
                </div>
            </v-col>

            <v-col class="text-right">
                <v-tooltip left v-if="resource.status == 'finished'">
                    <template v-slot:activator="{ on }">
                        <v-btn class="mr-3" color="grey lighten-1" outlined v-on="on">Ndrysho</v-btn>
                    </template>
                    <span>Detyra tashme eshte perfunduar dhe nuk mund te ndryshohet.</span>
                </v-tooltip>
                <v-btn
                    v-else
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
                <v-card>
                    <v-card-title>
                        <span class="headline pl-3">{{resource.name}}</span>
                        <div class="flex-grow-1"></div>


                            <div class="text-right mr-3">
                                <div v-if="resource.status=='finished'" class="overline pb-0">Ranko punen: {{resource.rating}}/5</div>
                                <div v-else class="overline">Ranko punen: 0/5</div>
      
     
                            </div>
                            <div class="text-right">
    
                                <v-rating
                                    v-if="resource.status === 'finished'"
                                    v-model="resource.rating"
                                    color="yellow darken-3"
                                    background-color="grey darken-1"
                                    clearable
                                    hover
                                    v-on:input="update_rating"
                                ></v-rating>
                                <v-tooltip bottom v-else-if="resource.status === 'template'">
                                    <template v-slot:activator="{ on }">
                                        <div v-on="on">
                                            <v-rating
                                                :value="0"
                                                color="yellow darken-3"
                                                background-color="grey darken-1"
                                                clearable
                                                hover
                                                readonly
                                            ></v-rating>
                                        </div>
                                    </template>
                                    <span>Detyra eshte vetem shabllon. Nuk mund te rankohet.</span>
                                </v-tooltip>
                                <v-tooltip bottom v-else>
                                    <template v-slot:activator="{ on }">
                                        <div v-on="on">
                                            <v-rating
                                                :value="0"
                                                color="yellow darken-3"
                                                background-color="grey darken-1"
                                                clearable
                                                hover
                                                readonly
                                            ></v-rating>
                                        </div>
                                    </template>
                                    <span>Detyra ende nuk eshte perfunduar per ta vlersuar.</span>
                                </v-tooltip>
                            </div>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row class="py-0">
                                <v-col cols="3">
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
                                <div class="flex-grow-1"></div>
                                <div class="flex-grow-1"></div>
                                <div class="flex-grow-1"></div>

 

                                <v-col>
                                    <v-chip v-if="resource.status == 'template'" label outlined 
                                        class="px-10 py-6"
                                    
                                    >
                                        <v-avatar left>
                                            <v-icon>mdi-account-circle</v-icon>
                                        </v-avatar>Shabllon
                                    </v-chip>
                                    <v-chip
                                        v-if="resource.status == 'finished'"
                                        label
                                        outlined
                                        color="green"
                                        class="px-10 py-6"
                                    >
                                        <v-avatar left>
                                            <v-icon>mdi-account-circle</v-icon>
                                        </v-avatar>E perfunduar
                                    </v-chip>
                                    <v-chip
                                        v-if="resource.status == 'refused'"
                                        label
                                        outlined
                                        color="red"
                                        class="px-10 py-6"
                                    >
                                        <v-avatar left>
                                            <v-icon>mdi-account-circle</v-icon>
                                        </v-avatar>E refuzuar
                                    </v-chip>
                                    <v-chip
                                        v-if="resource.status == 'pending'"
                                        label
                                        outlined
                                        color="orange"
                                        class="px-10 py-6"
                                    >
                                        <v-avatar left>
                                            <v-icon>mdi-account-circle</v-icon>
                                        </v-avatar>E pakonfirmuar
                                    </v-chip>
                                    <v-chip
                                        v-if="resource.status == 'accepted'"
                                        label
                                        outlined
                                        color="green"
                                        class="px-10 py-6"
                                        
                                    >
                                        <v-avatar left>
                                            <v-icon>mdi-account-circle</v-icon>
                                        </v-avatar>E konfirmuar
                                    </v-chip>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="4">
                                    <v-select
                                        label="Puntori:"
                                        :disabled="resource.status == 'template'"
                                        :items="data_autofill.employees"
                                        item-text="name"
                                        item-value="id"
                                        :value="resource.employee_id"
                                        hint="Puntori qe kryen detyren. Caktohet te Puna/Eventi."
                                        persistent-hint
                                        readonly
                                    ></v-select>
                                </v-col>
                                <v-col cols="2">
                                    <v-btn
                                        text
                                        block
                                        class="mt-5"
                                        :disabled="resource.status == 'template'"
                                        :to="`/employee/${resource.employee_id}`"
                                    >Shiko puntorin</v-btn>
                                </v-col>
                                <v-col cols="4">
                                    <v-select
                                        label="Eventi:"
                                        :disabled="resource.status == 'template'"
                                        :items="data_autofill.events"
                                        item-text="name"
                                        item-value="id"
                                        :value="resource.event_id"
                                        hint="Eventi ku duhet te kryhet detyra. Caktohet te Puna/Eventi."
                                        persistent-hint
                                        readonly
                                    ></v-select>
                                </v-col>
                                <v-col cols="2">
                                    <v-btn
                                        text
                                        block
                                        class="mt-5"
                                        :disabled="resource.status == 'template'"
                                        :to="`/event/${resource.event_id}`"
                                    >Shiko eventin</v-btn>
                                </v-col>
                            </v-row>

                            <v-row class="mt-2">
                                <v-col cols="6">
                                    <v-text-field label="Emri:" :value="resource.name" readonly></v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-text-field
                                        label="Pagesa:"
                                        :value="resource.payment_sum"
                                        hint="Shuma e pageses per te cilen paguhet puntori per kryerjen e detyres. Ne baze te detyrave qe kryne puntori, caktohet rroga."
                                        persistent-hint
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="py-3">
                                <v-col cols="12">
                                    <p
                                        class="small"
                                    >Paisjet ({{resource.inventory.length}} pajisje):</p>

                                    <v-chip
                                        pill
                                        v-for="(inventory,index) in resource.inventory"
                                        v-bind:key="index"
                                        class="mr-2 mb-2 text-capitalize"
                                        :to="`/inventory/${inventory}`"
                                        target="_blank"
                                    >
                                        <v-avatar
                                            left
                                            color="green"
                                            class="text-uppercase font-weight-bold white--text"
                                        >{{get_inventory(inventory).name.substring(0,1)}}</v-avatar>
                                        {{get_inventory(inventory).name}}
                                    </v-chip>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                        label="Te dhena shtese:"
                                        v-model="resource.description"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

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
                        <span class="text-uppercase">Te dhenat per detyren</span>


                <v-card-text>
                    <v-row class="py-0">
                                <v-col cols="3">
                                    <v-text-field
                                        :value="readable_date()"
                                        label="Shtuar me date:"
                                        disabled
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="4">
                                    <v-text-field
                                        :value="resource.created_by.name"
                                        label="Shtuar nga:"
                                        disabled
                                    ></v-text-field>
                                </v-col>
                    </v-row>
                    <v-row class="py-0">
                        <v-col class="py-1" cols="6">
                            <v-select
                                :disabled="resource.status=='template'"
                                label="Puntori: *"
                                :items="data_autofill.employees"
                                item-text="name"
                                item-value="id"
                                v-model="edit_resource.employee_id"
                                hint="Puntori qe kryen detyren. Caktohet te Puna/Eventi."
                                persistent-hint
                            ></v-select>
                        </v-col>
                        <v-col class="py-1" cols="6">
                            <v-select
                            :disabled="resource.status=='template'"
                                label="Eventi: *"
                                :items="data_autofill.events"
                                item-text="name"
                                item-value="id"
                                v-model="edit_resource.event_id"
                                hint="Eventi ku duhet te kryhet detyra. Caktohet te Puna/Eventi."
                                persistent-hint
                            ></v-select>
                        </v-col>
                    </v-row>

                    <v-row class="mt-5">
                        <v-col class="py-1" cols="6">
                            <v-text-field
                                :error-messages="saving_errors.name"
                                label="Emri: *"
                                v-model="edit_resource.name"
                            ></v-text-field>
                        </v-col>
                        <v-col class="py-1" cols="6">
                            <v-text-field
                                :error-messages="saving_errors.payment_sum"
                                label="Pagesa: *"
                                v-model="edit_resource.payment_sum"
                                hint="Shuma e pageses per te cilen paguhet puntori per kryerjen e detyres. Ne baze te detyrave qe kryne puntori, caktohet rroga."
                                persistent-hint
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row class="py-5">
                        <v-col class="py-1" cols="12">
                            <v-autocomplete
                                :error-messages="saving_errors.inventory"
                                label="Pajisjet:"
                                v-model="edit_resource.inventory"
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
                </v-card-text>
     
            </v-card>
                </v-container>
     
            </v-card>
        </v-dialog>
        <!-- <v-dialog v-model="edit_dialog" persistent max-width="75vw">
            <v-card color>
                <v-card-title>
                    <span class="headline pl-3">Ndrysho te dhenat</span>
                    <div class="flex-grow-1"></div>
                </v-card-title>
                <v-card-text>
                    <v-row class="py-0">
                        <v-col class="py-1" cols="6">
                            <v-select
                                :disabled="resource.status='template'"
                                label="Puntori: *"
                                :items="data_autofill.employees"
                                item-text="name"
                                item-value="id"
                                v-model="edit_resource.employee_id"
                                hint="Puntori qe kryen detyren. Caktohet te Puna/Eventi."
                                persistent-hint
                            ></v-select>
                        </v-col>
                        <v-col class="py-1" cols="6">
                            <v-select
                            :disabled="resource.status='template'"
                                label="Eventi: *"
                                :items="data_autofill.events"
                                item-text="name"
                                item-value="id"
                                v-model="edit_resource.event_id"
                                hint="Eventi ku duhet te kryhet detyra. Caktohet te Puna/Eventi."
                                persistent-hint
                            ></v-select>
                        </v-col>
                    </v-row>

                    <v-row class="mt-5">
                        <v-col class="py-1" cols="6">
                            <v-text-field
                                :error-messages="saving_errors.name"
                                label="Emri: *"
                                v-model="edit_resource.name"
                            ></v-text-field>
                        </v-col>
                        <v-col class="py-1" cols="6">
                            <v-text-field
                                :error-messages="saving_errors.payment_sum"
                                label="Pagesa: *"
                                v-model="edit_resource.payment_sum"
                                hint="Shuma e pageses per te cilen paguhet puntori per kryerjen e detyres. Ne baze te detyrave qe kryne puntori, caktohet rroga."
                                persistent-hint
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row class="py-5">
                        <v-col class="py-1" cols="12">
                            <v-autocomplete
                                :error-messages="saving_errors.inventory"
                                label="Pajisjet:"
                                v-model="edit_resource.inventory"
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
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn @click="edit_dialog = false" color="warning" text>Mbyll</v-btn>
                    <v-btn @click="update_resource()" color="success" text>Ruaj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog> -->
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";
import notesSection from "@/js/pages/note/notes_section";
import filesSection from "@/js/pages/file/files_section";
import paymentsSection from "@/js/pages/payment/payments_section";

export default {
    components: { notesSection, filesSection, paymentsSection },
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
                payment_sum: "",
                description: "",
                event_id: "",
                employee_id: "",
                status: "",
                rating:'',
                inventory: [],
                created_at: "",
                updated_at: "",
                class_name: "",
                created_by: { name: "" }
            },
            resource: {
                id: "",
                name: "",
                payment_sum: "",
                description: "",
                event_id: "",
                employee_id: "",
                status: "",
                rating:'',
                inventory: [],
                created_at: "",
                updated_at: "",
                class_name: "",
                created_by: { name: "" }
            },
            resource_relations: {
                notes: []
            },
            data_autofill: {
                employees: [],
                events: [],
                inventory: []
            }
        };
    },
    computed: {
        date_picker_readable_date() {
            moment.locale("sq");
            return this.edit_resource.purchase_date
                ? moment(this.edit_resource.purchase_date).format(
                      "D MMMM  YYYY, dddd"
                  )
                : "";
        }
        // edit_resource_inventory: {
        //     get:function(){
        //         return this.resource_relations.inventory.map(inv=>inv.id)
        //     },
        //     set:function(selected_invetory){
        //         this.edit_resource.inventory = selected_invetory;
        //     }

        // }
    },
    beforeMount() {
        var currentObj = this;
        axios
            .get(`/task/${currentObj.id}`)
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
        get_inventory(inventory_id) {
            return this.data_autofill.inventory.filter(
                inv => inv.id != inventory_id
            )[0];
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
        update_rating: function() {
            let currentObj = this;


            axios
                .post(`/task/rating/${currentObj.id}`, {rating:currentObj.resource.rating})
                .then(function(resp) {
                    currentObj.saving_errors = [];
  

                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Vlersim u ruajt!"
                    });
                })
                .catch(function(resp) {
                    currentObj.saving_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Vlersimi nuk u ruajt!"
                    });
                });
        },
        update_resource: function() {
            let currentObj = this;

            if (currentObj.edit_resource.employee_id == null) {
                delete currentObj.edit_resource.employee_id;
            }
            if (currentObj.edit_resource.event_id == null) {
                delete currentObj.edit_resource.event_id;
            }

            axios
                .put(`/task/${currentObj.id}`, currentObj.edit_resource)
                .then(function(resp) {
                    currentObj.saving_errors = [];
                    currentObj.resource = resp.data.resource;

                    /* Using JSON.parse to copy object, since just asignin resp.data.note only references data
                    note end edit_note keep changing when used as vue v-model
                    Based on: https://scotch.io/bar-talk/copying-objects-in-javascript
                     */
                    currentObj.edit_resource = JSON.parse(
                        JSON.stringify(resp.data.resource)
                    );
                    currentObj.edit_dialog = false;

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
            axios(`/note/${currentObj.id}`, {
                method: "delete"
            })
                .then(function(resp) {
                    currentObj.$route.go("/employee");
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Detyra u fshi!"
                    });
                })
                .catch(function(resp) {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Detyra nuk u fshi, rifresko faqen!"
                    });
                });
        }
    }
};
</script>