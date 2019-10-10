<template>
    <v-card class="px-5 ma-5">
        <v-card-title>
            <v-icon left>mdi-calendar-multiple</v-icon>Te gjitha eventet
            <div class="flex-grow-1"></div>
            <v-text-field
                v-model="search"
                append-icon="mdi-account-search"
                label="Kerko"
                single-line
                hide-details
            ></v-text-field>
        </v-card-title>
        <v-data-table :headers="headers" :items="resources" :search="search" height="69vh">
            <template
                v-slot:item.created_at="{ item }"
            >{{readable_date(item.created_at,item.updated_at)}}</template>
            <template v-slot:item.start_date="{ item }">{{readable_event_date(item.date_start)}}</template>
            <template
                v-slot:item.duration="{ item }"
            >{{readable_event_duration(item.date_start,item.date_end)}}</template>
            <template v-slot:item.action="{ item }">
                <v-btn class="ma-2" tile text small link :to="`/event/${item.id}`">
                    Shiqo
                    <v-icon small right>mdi-open-in-new</v-icon>
                </v-btn>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";
export default {
    data() {
        return {
            search: "",
            headers: [
                {
                    text: "Emri",
                    align: "left",

                    value: "name"
                },
                { text: "I takon punes:", value: "job.name" },
                { text: "Klienti:", value: "job.client.name" },
                // { text: 'Adresa', value: 'address' },
                { text: "Fillon:", value: "start_date", sortable: false },
                { text: "Kohezgjatja:", value: "duration", sortable: false },
                // { text: 'Mbaron', value: 'date_end' },
                // { text: 'Email', value: 'email' },
                // { text: 'Qyteti', value: 'city' },
                // { text: 'Adresa', value: 'address' },
                { text: "Krijuar me date:", value: "created_at" },
                // { text: 'Krijuar nga:', vaslue: 'user.name' },
                { text: "", value: "action", sortable: false, align: "right" }
            ],
            resources: []
        };
    },
    beforeMount() {
        let currentObj = this;
        axios
            .get("/event")
            .then(function(resp) {
                // console.log(resp.data);
                currentObj.resources = resp.data.resources;
            })
            .catch(function(resp) {
                // console.log(resp);
                alert("Could not load data");
            });
    },
    methods: {
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
        readable_date(created_at, updated_at) {
            moment.locale("sq");
            if (created_at === updated_at) {
                return moment(updated_at).calendar();
            } else {
                return moment(updated_at).calendar() + " (E modifikuar)";
            }
        }
    }
};
</script>