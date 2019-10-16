<template>
    <v-card class="mt-5">
        <v-card-title>{{title}}</v-card-title>
        <v-tabs v-model="tab_index" left slider-color="green" background-color="transparent">

            <v-tab
                v-if="Object.keys(relations).includes('tasks')"
            >Detyrat({{relations.tasks.length}})</v-tab>
                        <v-tab
                v-if="Object.keys(relations).includes('inventory')"
            >Pajisjet({{relations.inventory.length}})</v-tab>
            <v-tab v-if="Object.keys(relations).includes('jobs')">Punet({{relations.jobs.length}})</v-tab>

            <v-tab
                v-if="Object.keys(relations).includes('events')"
            >Eventet({{relations.events.length}})</v-tab>
            <v-tab
                v-if="Object.keys(relations).includes('services')"
            >Eventet({{relations.services.length}})</v-tab>

            <v-tab
                v-if="Object.keys(relations).includes('payments')"
            >Pagesat({{relations.payments.length}})</v-tab>

            <v-tab
                v-if="Object.keys(relations).includes('files')"
            >Fajllat({{relations.files.length}})</v-tab>

            <v-tab
                v-if="Object.keys(relations).includes('notes')"
            >Shenimet({{relations.notes.length}})</v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab_index">
            <v-tab-item v-if="Object.keys(relations).includes('tasks')">
                <v-container>
                    <v-data-table
                        :headers="table_headers.tasks"
                        :items="relations.tasks"
                        height="55vh"
                        no-data-text="Nuk ka te dhena"
                    >
                        <template v-slot:item.rating="{ item }">
                            <v-rating
                                :value="item.rating"
                                color="yellow darken-3"
                                background-color="grey darken-1"
                                samll
                                readonly
                            ></v-rating>
                        </template>
                        <template
                            v-slot:item.created_by="{ item }"
                        >{{created_by_name_only(item.user.name)}}</template>
                        <template
                            v-slot:item.created_at="{ item }"
                        >{{readable_date(item.created_at,item.updated_at)}}</template>
                        <template v-slot:item.action="{ item }">
                            <v-btn
                                class="ma-2"
                                tile
                                text
                                small
                                link
                                :to="`/task/${item.id}`"
                                target="_blank"
                            >
                                Shiqo
                                <v-icon small right>mdi-open-in-new</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-container>
            </v-tab-item>
            <v-tab-item v-if="Object.keys(relations).includes('inventory')">
                <v-container>
                    <v-data-table
                        :headers="table_headers.inventory"
                        :items="relations.inventory"
                        height="55vh"
                        no-data-text="Nuk ka te dhena"

                    >

                        <template
                            v-slot:item.created_by="{ item }"
                        >{{created_by_name_only(item.user.name)}}</template>
                        <template
                            v-slot:item.created_at="{ item }"
                        >{{readable_date(item.created_at,item.updated_at)}}</template>
                        <template v-slot:item.action="{ item }">
                            <v-btn
                                class="ma-2"
                                tile
                                text
                                small
                                link
                                :to="`/inventory/${item.id}`"
                                target="_blank"
                            >
                                Shiqo
                                <v-icon small right>mdi-open-in-new</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-container>
            </v-tab-item>
            <v-tab-item v-if="Object.keys(relations).includes('jobs')">
                <v-container>
                    <v-data-table
                        :headers="table_headers.jobs"
                        :items="relations.jobs"
                        height="55vh"
                    >
                        <template
                            v-slot:item.created_by="{ item }"
                        >{{created_by_name_only(item.user.name)}}</template>
                        <template
                            v-slot:item.created_at="{ item }"
                        >{{readable_date(item.created_at,item.updated_at)}}</template>
                        <template v-slot:item.action="{ item }">
                            <v-btn class="ma-2" tile text small link :to="`/job/${item.id}`">
                                Shiqo
                                <v-icon small right>mdi-open-in-new</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-container>
            </v-tab-item>
            <v-tab-item v-if="Object.keys(relations).includes('events')">
                <v-container>
                    <v-data-table
                        :headers="table_headers.events"
                        :items="relations.events"
                        height="55vh"
                    >
                        <template
                            v-slot:item.start_date="{ item }"
                        >{{readable_event_date(item.date_start)}}</template>
                        <template
                            v-slot:item.duration="{ item }"
                        >{{readable_event_duration(item.date_start,item.date_end)}}</template>
                        <template
                            v-slot:item.created_by="{ item }"
                        >{{created_by_name_only(item.user.name)}}</template>
                        <template
                            v-slot:item.created_at="{ item }"
                        >{{readable_date(item.created_at,item.updated_at)}}</template>
                        <template v-slot:item.action="{ item }">
                            <v-btn class="ma-2" tile text small link :to="`/event/${item.id}`">
                                Shiqo
                                <v-icon small right>mdi-open-in-new</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-container>
            </v-tab-item>
            <v-tab-item v-if="Object.keys(relations).includes('services')">
                <v-container>
                    <v-data-table
                        :headers="table_headers.services"
                        :items="relations.services"
                        height="55vh"
                    >

                        <template
                            v-slot:item.created_by="{ item }"
                        >{{created_by_name_only(item.user.name)}}</template>
                        <template
                            v-slot:item.created_at="{ item }"
                        >{{readable_date(item.created_at,item.updated_at)}}</template>
                        <template v-slot:item.action="{ item }">
                            <v-btn class="ma-2" tile text small link :to="`/event/${item.id}`">
                                Shiqo
                                <v-icon small right>mdi-open-in-new</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-container>
            </v-tab-item>

            <v-tab-item v-if="Object.keys(relations).includes('payments')">
                <v-container>
                    <v-data-table
                        :headers="table_headers.payments"
                        :items="relations.payments"
                        height="55vh"
                        no-data-text="Nuk ka pagesa te ruajtura"

                    >
                        <template
                            v-slot:item.created_by="{ item }"
                        >{{created_by_name_only(item.user.name)}}</template>
                        <template v-slot:item.action="{ item }">
                            <v-btn class="ma-2" tile text small link :to="`/payment/${item.id}`">
                                Shiqo
                                <v-icon small right>mdi-open-in-new</v-icon>
                            </v-btn>
                        </template>
                        <template
                            v-slot:item.created_at="{ item }"
                        >{{readable_date(item.created_at,item.updated_at)}}</template>
                        <template v-slot:item.payment_type="{ item }">{{payment_type(item.type)}}</template>
                    </v-data-table>
                </v-container>
            </v-tab-item>

            <v-tab-item v-if="Object.keys(relations).includes('files')">
                <v-container>
                    <v-data-table
                        :headers="table_headers.files"
                        :items="relations.files"
                        height="55vh"
                        no-data-text="Nuk ka fajlla te ruajtura"

                    >
                        <template v-slot:item.file_extension="{ item }">
                            <span class="text-uppercase">{{item.file.split('.')[1]}}</span>
                        </template>
                        <template
                            v-slot:item.created_by="{ item }"
                        >{{created_by_name_only(item.user.name)}}</template>
                        <template v-slot:item.action="{ item }">
                            <v-btn class="ma-2" tile text small link :to="`/file/${item.id}`">
                                Shiqo
                                <v-icon small right>mdi-open-in-new</v-icon>
                            </v-btn>
                        </template>
                        <template
                            v-slot:item.created_at="{ item }"
                        >{{readable_date(item.created_at,item.updated_at)}}</template>
                    </v-data-table>
                </v-container>
            </v-tab-item>

            <v-tab-item v-if="Object.keys(relations).includes('notes')">
                <v-container>
                    <v-data-table
                        :headers="table_headers.notes"
                        :items="relations.notes"
                        height="55vh"
                        no-data-text="Nuk ka shenime te ruajtura"

                    >
                        <template
                            v-slot:item.created_by="{ item }"
                        >{{created_by_name_only(item.user.name)}}</template>
                        <template v-slot:item.action="{ item }">
                            <v-btn class="ma-2" tile text small link :to="`/note/${item.id}`">
                                Shiqo
                                <v-icon small right>mdi-open-in-new</v-icon>
                            </v-btn>
                        </template>
                        <template
                            v-slot:item.created_at="{ item }"
                        >{{readable_date(item.created_at,item.updated_at)}}</template>
                        <template
                            v-slot:item.body="{ item }"
                        >{{(item.body.length > 60 ? item.body.substr(0,60)+'...':item.body)}}</template>
                    </v-data-table>
                </v-container>
            </v-tab-item>
        </v-tabs-items>
    </v-card>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";

export default {
    props: ["title", "relations"],
    data() {
        return {
            tab_index: 0,
            table_headers: {
                jobs: [
                    {
                        text: "Emri",
                        align: "left",

                        value: "name"
                    },
                    { text: "Klienti", value: "client.name" },
                    { text: "Oferta", value: "offer.name" },
                    { text: "Cmimi", value: "price" },
                    { text: "Pagesa:", value: "payment_status" },
                    // { text: 'Email', value: 'email' },
                    // { text: 'Qyteti', value: 'city' },
                    // { text: 'Adresa', value: 'address' },
                    { text: "Krijuar me date:", value: "created_at" },
                    { text: "Krijuar nga:", value: "created_by" },
                    {
                        text: "",
                        value: "action",
                        sortable: false,
                        align: "right"
                    }
                ],
                events: [
                    {
                        text: "Emri",
                        align: "left",

                        value: "name"
                    },
                    { text: "I takon punes:", value: "job.name" },
                    { text: "Klienti:", value: "job.client.name" },
                    // { text: 'Adresa', value: 'address' },
                    { text: "Fillon:", value: "start_date", sortable: false },
                    {
                        text: "Kohezgjatja:",
                        value: "duration",
                        sortable: false
                    },
                    // { text: 'Email', value: 'email' },
                    // { text: 'Qyteti', value: 'city' },
                    // { text: 'Adresa', value: 'address' },
                    { text: "Krijuar me date:", value: "created_at" },
                    { text: "Krijuar nga:", value: "created_by" },
                    {
                        text: "",
                        value: "action",
                        sortable: false,
                        align: "right"
                    }
                ],
                payments: [
                    {
                        text: "Emri",
                        align: "left",

                        value: "name"
                    },
                    { text: "Dhenesi:", value: "from" },
                    { text: "Marresi:", value: "to" },
                    { text: "Shuma:", value: "amount" },
                    { text: "Kategoria:", value: "category" },
                    { text: "Shtuar me date:", value: "created_at" },
                    { text: "Shtuar nga:", value: "created_by" },

                    {
                        text: "",
                        value: "action",
                        sortable: false,
                        align: "right"
                    }
                ],
                files: [
                    {
                        text: "Emri",
                        align: "left",

                        value: "name"
                    },
                    { text: "Fajlli:", value: "file" },
                    { text: "Extension:", value: "file_extension" },
                    { text: "I takon", value: "fileable.name" },
                    { text: "Shtuar me date:", value: "created_at" },
                    { text: "Shtuar nga:", value: "created_by" },

                    {
                        text: "",
                        value: "action",
                        sortable: false,
                        align: "right"
                    }
                ],
                notes: [
                    { text: "Emri", align: "left", value: "name" },
                    { text: "Shenimi:", value: "body" },
                    { text: "I takon", value: "noteable.name" },

                    { text: "Shtuar me date:", value: "created_at" },
                    { text: "Shtuar nga:", value: "created_by" },

                    {
                        text: "",
                        value: "action",
                        sortable: false,
                        align: "right"
                    }
                ],
                tasks: [
                    {
                        text: "Emri",
                        align: "left",

                        value: "name"
                    },
                    { text: "Eventi:", value: "event.name" },
                    { text: "Puntori:", value: "employee.name" },
                    { text: "Rankimi:", value: "rating", align: "center" },
                    { text: "Pagesa:", value: "payment_sum", align: "center" },
                    { text: "Statusi:", value: "status", align: "center" },

                    {
                        text: "Shtuar me date:",
                        value: "created_at",
                        align: "left"
                    },
                    { text: "Shtuar nga:", value: "created_by", align: "left" },
                    {
                        text: "",
                        value: "action",
                        sortable: false,
                        align: "right"
                    }
                ],
                services: [
                    {
                        text: "Emri",
                        align: "left",

                        value: "name"
                    },


                    {
                        text: "Shtuar me date:",
                        value: "created_at",
                        align: "left"
                    },
                    { text: "Shtuar nga:", value: "created_by", align: "left" },
                    {
                        text: "",
                        value: "action",
                        sortable: false,
                        align: "right"
                    }
                ],
                inventory: [
                    {
                        text: "Emri",
                        align: "left",

                        value: "name"
                    },

                                            { text: 'Lloji:', value: 'type' },
                    { text: 'Cmimi i blerjes:', value: 'price' },
                    { text: 'Data e blerjes:', value: 'purchase_date' },

                    {
                        text: "Shtuar me date:",
                        value: "created_at",
                        align: "left"
                    },
                    { text: "Shtuar nga:", value: "created_by", align: "left" },
                    {
                        text: "",
                        value: "action",
                        sortable: false,
                        align: "right"
                    }
                ]
            }
        };
    },
    computed: {},

    methods: {
        payment_type(type) {
            if (type == "in") {
                return "Hyrje";
            } else if (type == "out") {
                return "Dalje";
            } else {
                return type;
            }
        },
        readable_event_date(date) {
            moment.locale("sq");

            return moment(date).format("DD/MM/YY HH:mm");
            // + Math.abs(moment.duration(moment(start_date).diff(moment(end_date))).get('hours')) + ' Ore';
        },
        readable_event_duration(start_date, end_date) {
            moment.locale("sq");

            // return moment(start_date).format('DD/MM/YY HH:mm')+' '+moment(end_date).format('[deri] DD/MM/YY HH:mm')
            return (
                Math.abs(
                    moment
                        .duration(moment(start_date).diff(moment(end_date)))
                        .get("hours")
                ) + " Ore"
            );
        },
        created_by_name_only(fullname) {
            return fullname.split(" ")[0];
        },
        readable_date(created_at, updated_at) {
            moment.locale("sq");
            if (created_at === updated_at) {
                return moment(updated_at).format("D MMMM YYYY");
            } else {
                return moment(updated_at).format("D/M/YYYY") + " (M)";
            }
        }
    }
};
</script>