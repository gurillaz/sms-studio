<template>
    <div>
        <v-card class="px-5 ma-5 mt-0">

            <v-card-title>
                Detyrat e perfunduara
                <div class="flex-grow-1"></div>
                                <v-text-field
                    v-model="search"
                    append-icon="mdi-account-search"
                    label="Kerko"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers_finished" :items="events_finished()" :search="search">
                <template v-slot:item.rating="{ item }">
                    <v-rating
                        :value="item.rating"
                        color="yellow darken-3"
                        background-color="grey darken-1"
                        samll
                        readonly
                    ></v-rating>
                </template>
                <template v-slot:item.created_at="{ item }">{{readable_date(item.updated_at)}}</template>
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

            <v-divider class="mt-10"></v-divider>
            <v-card-title>
                Te tjera(Te konfirmuara, te pa-konfirmuara dhe te refuzuara)
                <div class="flex-grow-1"></div>
            </v-card-title>
            <v-data-table :headers="headers_others" :items="events_other()" :search="search">
                <template v-slot:item.rating="{ item }">
                    <v-rating
                        :value="item.rating"
                        color="yellow darken-3"
                        background-color="grey darken-1"
                        samll
                        readonly
                    ></v-rating>
                </template>
                <template v-slot:item.created_at="{ item }">{{readable_date(item.updated_at)}}</template>
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
            <v-divider class="mt-10"></v-divider>

                        <v-card-title>
                Detyrat (Shabllon)
                <div class="flex-grow-1"></div>

            </v-card-title>

            <v-data-table :headers="headers_template" :items="events_template()" :search="search">
                <template v-slot:item.created_at="{ item }">{{readable_date(item.updated_at)}}</template>
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
        </v-card>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";
export default {
    data() {
        return {
            search: "",
            headers_template: [
                {
                    text: "Emri",
                    align: "left",

                    value: "name"
                },
                { text: "Pagesa:", value: "payment_sum", align: "center" },
                {
                    text: "Nr. i paisjeve qe perdoren:",
                    value: "inventory.length",
                    align: "center"
                },

                { text: "", value: "", align: "left" },
                { text: "", value: "", align: "left" },
                { text: "", value: "", align: "left" },
                { text: "Statusi:", value: "status", align: "left" },
                { text: "Shtuar me date:", value: "created_at", align: "left" },
                { text: "Shtuar nga:", value: "user.name", align: "left" },
                { text: "", value: "action", sortable: false, align: "right" }
            ],
            headers_finished: [
                {
                    text: "Emri",
                    align: "left",

                    value: "name"
                },
                { text: "Eventi:", value: "event.name" },
                { text: "Puntori:", value: "employee.name" },
                { text: "Rankimi:", value: "rating", align: "center" },
                { text: "Pagesa:", value: "payment_sum", align: "center" },

                { text: "Shtuar me date:", value: "created_at", align: "left" },
                { text: "Shtuar nga:", value: "user.name", align: "left" },
                { text: "", value: "action", sortable: false, align: "right" }
            ],
            headers_others: [
                {
                    text: "Emri",
                    align: "left",

                    value: "name"
                },
                { text: "Eventi:", value: "event.name" },
                { text: "Puntori:", value: "employee.name" },
                { text: "Rankimi:", value: "rating", align: "center" },
                { text: "Statusi:", value: "status", align: "left" },

                { text: "Shtuar me date:", value: "created_at", align: "left" },
                { text: "Shtuar nga:", value: "user.name", align: "left" },

                { text: "", value: "action", sortable: false, align: "right" }
            ],
            resources: []
        };
    },
    computed: {},
    methods: {
        events_template() {
            return this.resources.filter(event => event.status == "template");
        },
        events_finished() {
            return this.resources.filter(event => event.status == "finished");
        },
        events_other() {
            return this.resources.filter(
                event =>
                    event.status != "finished" && event.status != "template"
            );
        },
        readable_date(date) {
            moment.locale("sq");
            return moment(date).format("DD/MM/YYYY");
        }
    },
    beforeMount() {
        var currentObj = this;
        axios
            .get("/task")
            .then(function(resp) {
                // console.log(resp.data);
                currentObj.resources = resp.data.resources;
                // currentObj.resources.forEach(res=>res.created_at=currentObj.formatDate(res.created_at))
            })
            .catch(function(resp) {
                console.log(resp);
                alert("Could not load Employees");
            });
    }
};
</script>