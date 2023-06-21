<template>
    <div class="mx-3">
        <v-row>
            <v-col>
                <div class="headline">Eventi</div>
            </v-col>

            <v-col class="text-right">
                <v-btn
                    class="mr-3"
                    color="success"
                >Printo instruksionet</v-btn>
                <v-btn
                    @click.stop="edit_tasks_dialog = true"
                    class="mr-3"
                    color="primary"
                    outlined
                >Cakto punet</v-btn>
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
                            <v-row>
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
                                <v-col cols="3">
                                    <v-text-field
                                        label="I takon punes:"
                                        :value="`${resource_relations.job.name}`"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="2" class="pt-6">
                                    <v-btn
                                        block
                                        text
                                        :to="`/job/${resource_relations.job.id}`"
                                    >Shiko punen</v-btn>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="4">
                                    <v-text-field
                                        :value="readable_event_date(resource.date_start)"
                                        label="Fillon ne:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="4">
                                    <v-text-field
                                        :value="readable_event_date(resource.date_end)"
                                        label="Mbraon ne:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="4">
                                    <v-text-field
                                        :value="readable_event_duration(resource.date_start,resource.date_end) + ' Ore'"
                                        label="Kohezgjatja:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                     <v-col cols="4" class="pt-0">
                                    <v-text-field :value="resource.name" label="Emri:" readonly></v-text-field>
                                </v-col>
                                <v-col cols="8" class="pt-0">
                                    <v-text-field
                                        :value="resource.address"
                                        label="Adresa:"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                                                  <v-row class="py-3">
                                <v-col cols="4">
                                    <p
                                        class="small"
                                    >Puntoret ({{resource_relations.tasks.map(task=>task.inventory).length}} puntore):</p>

                                    <v-chip
                                        pill
                                        v-for="(task,index) in resource_relations.tasks"
                                        v-bind:key="index"
                                        class="mr-2 mb-2 text-capitalize"
                                        :to="`/employee/${task.employee.id}`"
                                        target="_blank"
                                    >
                                        <v-avatar
                                            left
                                            color="green"
                                            class="text-uppercase font-weight-bold white--text"
                                        >{{task.employee.name.substring(0,1)}}</v-avatar>
                                        {{task.employee.name}}
                                    </v-chip>
                                </v-col>
                                <v-col cols="8">
                                    <p
                                        class="small"
                                    >Pajisjet:</p>
                                    <span v-for="(task,index) in resource_relations.tasks"
                                        v-bind:key="index">
                                                         <v-chip
                                        label
                                        small
                                        v-for="(inventory,index) in task.inventory"
                                        v-bind:key="index"
                                        class="mr-2 mb-2 text-capitalize"
                                        :to="`/inventory/${inventory.id}`"
                                        target="_blank"
                                    >
                  
                                        {{inventory.name}}
                                    </v-chip>
                                        
                                    </span>
                   
                                </v-col>
                            </v-row>
                            <v-row>
                           
                                <v-col cols="12">
                                    <v-text-field
                                        :value="resource.description"
                                        label="Te dhena tjera:"
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
        <filesSection :files="resource_relations.files" :id="id" :class_name="resource.class_name"></filesSection>
        <v-dialog
            v-model="edit_tasks_dialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
        >
            <v-card color="grey lighten-5">
                <v-toolbar dark color="primary">
                    <v-toolbar-title>Cakto punet</v-toolbar-title>
                    <div class="flex-grow-1"></div>
                    <v-toolbar-items>
                        <v-btn dark text @click="edit_tasks_dialog = false">Mbyll</v-btn>
                        <v-btn dark text @click="edit_tasks_dialog = false">Ruaj</v-btn>
                    </v-toolbar-items>
                </v-toolbar>
                <!-- {{data_autofill.inventory}}
                {{data_autofill.employees}} -->

                <v-container fluid class="mt-10">
                    <v-row class="px-10">
                        <v-col cols="10"></v-col>
                        <v-col class cols="2">
                            <v-btn
                                @click.stop="add_task"
                                color="green"
                                outlined
                                block
                                small
                            >Shto pune</v-btn>
                        </v-col>
                    </v-row>

                    <v-card outlined tile class="py-5 px-8 mx-10" style="min-height: 75vh">
                        <v-row>
                            <v-col cols="2" class="py-0 caption font-weight-bold">Puntori</v-col>
                            <v-col cols="6" class="py-0 caption font-weight-bold">Pajisjet</v-col>
                            <v-col cols="1" class="py-0 caption font-weight-bold">Detyra</v-col>
                            <v-col cols="1" class="py-0 caption font-weight-bold">Pagesa</v-col>
                            <v-col cols="1" class="py-0 caption font-weight-bold">Statusi</v-col>
                            <v-col
                                cols="1"
                                class="py-0 caption font-weight-bold text-center"
                            >Veprimi</v-col>
                            <v-col cols="12" class>
                                <v-divider></v-divider>
                            </v-col>
                        </v-row>
                        <v-row v-if="resource_relations.tasks.length == 0">
                            <v-col cols=12 class="text-center mt-5">
                            <p class="title ">Nuk ka pune te ruajtura per eventin.</p> 
                            <p>Kliko ne butonin "Shto pune" per te shtuar pune te re.</p>

                            </v-col>
                            </v-row>
                        <v-row v-else v-for="(task,index) in resource_relations.tasks" :key="index">
                            <v-col cols="2" class="py-0 mt-auto">
                                <v-autocomplete
                                    :items="data_autofill.employees"
                                    item-text="name"
                                    item-value="id"
                                    v-model="task.employee_id"
                                ></v-autocomplete>
                            </v-col>
  
                            <v-col cols="6" class="py-0 mt-auto">
                                <v-autocomplete
                                    :items="data_autofill.inventory"
                                    item-text="name"
                                    item-value="id"
                                    v-model="task.inventory"
                                    chips
                                    small-chips
                                    hide-selected
                                    deletable-chips
                                    multiple
                                ></v-autocomplete>
                            </v-col>
                                                      <v-col cols="1" class="py-0 mt-auto">
                                <v-text-field v-model="task.name"></v-text-field>
                            </v-col>
                            <v-col cols="1" class="py-0 mt-auto">
                                <v-text-field v-model="task.payment_sum"></v-text-field>
                            </v-col>
                            <v-col cols="1" class="py-0 mt-auto">
                                <v-text-field v-model="task.status"></v-text-field>
                            </v-col>
                            <v-col cols="1" class="py-0 ">
                                <v-btn small text block color="success">Ruaj</v-btn>
                                <v-btn small text block color="warning" @click="delete_task">Fshij</v-btn>
                            </v-col>
                            <v-col cols="12" class="pt-0 ">
                                <v-divider></v-divider>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-container>
            </v-card>
        </v-dialog>
        <v-dialog v-model="edit_dialog" persistent max-width="75vw">
            <v-card color>
                <v-card-title>
                    <span class="headline pl-3">Ndrysho te dhenat</span>
                    <div class="flex-grow-1"></div>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
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
                            <v-col cols="3">
                                <v-text-field
                                    label="I takon punes:"
                                    :value="`${resource_relations.job.name}`"
                                    disabled
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2" class="pt-6">
                                <v-btn
                                    block
                                    text
                                    :to="`/job/${resource_relations.job.id}`"
                                    disabled
                                >Shiko punen</v-btn>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="4">
                                <v-menu
                                    :close-on-content-click="false"
                                    max-width="290"
                                    v-model="date_picker"
                                >
                                    <template v-slot:activator="{ on }">
                                        <v-text-field
                                            :error-messages="saving_errors.date_start"
                                            :value="formatedDate"
                                            label="Data e eventit*"
                                            readonly
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        :min="new Date().toISOString().substr(0, 10)"
                                        @change="date_picker = false"
                                        v-model="date"
                                    ></v-date-picker>
                                </v-menu>
                            </v-col>
                            <v-col cols="4">
                                <v-menu
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    :return-value.sync="time"
                                    max-width="290px"
                                    min-width="290px"
                                    offset-y
                                    ref="menu"
                                    v-model="time_picker"
                                >
                                    <template v-slot:activator="{ on }">
                                        <v-text-field
                                            :error="saving_errors.date_start!=null"
                                            label="Fillon ne ora*"
                                            readonly
                                            :value="time"
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-time-picker
                                        @click:minute="$refs.menu.save(time)"
                                        format="24hr"
                                        full-width
                                        scrollable
                                        v-if="time_picker"
                                        v-model="time"
                                    ></v-time-picker>
                                </v-menu>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field
                                    :error-messages="saving_errors.duration_hours"
                                    hint="Kohezgjatja e eventit ne ore"
                                    label="Kohezgjatja e eventit*"
                                    persistent-hint
                                    required
                                    v-model="edit_resource.duration_hours"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="edit_resource.address"
                                    :error-messages="saving_errors.address"
                                    label="Adresa: *"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" class="pt-0">
                                <v-text-field
                                    v-model="edit_resource.name"
                                    :error-messages="saving_errors.name"
                                    label="Name: *"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="edit_resource.description"
                                    :error-messages="saving_errors.description"
                                    label="Detaje shtese: *"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn @click="edit_dialog = false" color="warning" text>Mbyll</v-btn>
                    <v-btn @click="update_resource()" color="success" text>Ruaj</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";
import notesSection from "@/js/pages/note/notes_section";
import filesSection from "@/js/pages/file/files_section";
import paymentsSection from "@/js/pages/payment/payments_section";
import relatedDataTables from "@/js/pages/others/related_data_tables";

export default {
    components: {
        notesSection,
        filesSection,
        paymentsSection,
        relatedDataTables
    },
    data() {
        return {
            edit_dialog: false,
            edit_tasks_dialog: false,
            saving_errors: [],

            id: this.$route.params.id,
            class_name: "",

            date_picker: false,
            time_picker: false,
            date: "",
            time: "",
            tasks: [],

            edit_resource: {
                id: "",
                name: "",
                address: "",
                status: "",
                description: "",
                date_start: "",
                date_end: "",
                duration_hours: "",
                job_id: "",

                created_at: "",
                updated_at: "",
                class_name: "",
                created_by: { name: "" }
            },
            resource: {
                id: "",
                name: "",
                address: "",
                status: "",
                description: "",
                date_start: "",
                date_end: "",
                duration_hours: "",
                job_id: "",

                created_at: "",
                updated_at: "",
                class_name: "",
                created_by: { name: "" }
            },
            resource_relations: {
                tasks: [],
                inventory: [],
                files: [],
                notes: [],
                payments: [],
                job: []
            },
            data_autofill: {}
        };
    },
    computed: {
        formatedDate() {
            moment.locale("sq");
            return this.date
                ? moment(this.date).format("D MMMM  YYYY, dddd")
                : "";
        }
    },

    beforeMount() {
        var currentObj = this;
        axios
            .get(`/event/${currentObj.id}`)
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
                currentObj.date = moment(currentObj.resource.date_start).format(
                    "YYYY-MM-DD"
                );
                currentObj.time = moment(currentObj.resource.date_start).format(
                    "HH:mm"
                );
                currentObj.edit_resource.duration_hours = Math.abs(
                    moment
                        .duration(
                            moment(currentObj.resource.date_start).diff(
                                moment(currentObj.resource.date_end)
                            )
                        )
                        .get("hours")
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
        delete_task(task) {
            this.resource_relations.tasks.pop(task);
        },
        add_task() {
            this.resource_relations.tasks.unshift({
                id: "",
                name: "",
                employee_id: "",
                inventory: "",
                saved: false,
                status:'unsaved',
                saving_errors: []
            });
        },

        readable_event_date(date) {
            moment.locale("sq");

            return moment(date).format("DD MMMM YYYY, dddd [ora] HH:mm");
            // + Math.abs(moment.duration(moment(start_date).diff(moment(end_date))).get('hours')) + ' Ore';
        },
        readable_event_duration(start_date, end_date) {
            moment.locale("sq");

            // return moment(start_date).format('DD/MM/YY HH:mm')+' '+moment(end_date).format('[deri] DD/MM/YY HH:mm')
            return Math.abs(
                moment
                    .duration(moment(start_date).diff(moment(end_date)))
                    .get("hours")
            );
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
        update_resource: function() {
            let currentObj = this;

            let dt_date_start = "";
            //nese nuk jane dhene edhe data edhe koha
            if (currentObj.time != "" && currentObj.date != "") {
                dt_date_start = moment(
                    new Date(this.date + " " + this.time)
                ).format("YYYY-MM-DD HH:mm:ss");
            }
            currentObj.edit_resource.date_start = dt_date_start;
            currentObj.edit_resource.status = "active";

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
                .put(`/event/${currentObj.id}`, data)
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

                    currentObj.date = moment(
                        currentObj.resource.date_start
                    ).format("YYYY-MM-DD");
                    currentObj.time = moment(
                        currentObj.resource.date_start
                    ).format("HH:mm");
                    currentObj.edit_resource.duration_hours = Math.abs(
                        moment
                            .duration(
                                moment(currentObj.resource.date_start).diff(
                                    moment(currentObj.resource.date_end)
                                )
                            )
                            .get("hours")
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
            if (confirm("Konfirmo fshirjen e eventit!") === false) {
                return;
            }
            axios(`/event/${currentObj.id}`, {
                method: "delete"
            })
                .then(function(resp) {
                    currentObj.$router.replace("/event");
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Eventi u fshi!"
                    });
                })
                .catch(function(resp) {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Eventi nuk u fshi, rifresko faqen!"
                    });
                });
        }
    }
};
</script>