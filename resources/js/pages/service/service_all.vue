<template>
    <div>
        <v-card class="px-5 ma-5 mt-0">

            <v-card-title>
                Te gjitha sherbimet(aktive)
                <div class="flex-grow-1"></div>
                                <v-text-field
                    v-model="search"
                    append-icon="mdi-account-search"
                    label="Kerko"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers" :items="services_active()" :search="search">
                <template v-slot:item.tasks="{ item }">
                    

                        <span class="caption">{{get_tasks_names(item.tasks)}}</span>
                </template>
                <template v-slot:item.created_at="{ item }">{{readable_date(item.updated_at)}}</template>
                <template v-slot:item.action="{ item }">
                    <v-btn
                        class="ma-2"
                        tile
                        text
                        small
                        link
                        :to="`/service/${item.id}`"
                    >
                        Shiqo
                        <v-icon small right>mdi-open-in-new</v-icon>
                    </v-btn>
                </template>
            </v-data-table>
            <v-divider class="mt-10"></v-divider>
            <v-card-title>
                Te gjitha sherbimet(pasive)

            </v-card-title>
            <v-data-table :headers="headers" :items="services_pasive()" :search="search">
                <template v-slot:item.tasks="{ item }">
                    

                        <span class="caption">{{get_tasks_names(item.tasks)}}</span>
                </template>
                <template v-slot:item.created_at="{ item }">{{readable_date(item.updated_at)}}</template>
                <template v-slot:item.action="{ item }">
                    <v-btn
                        class="ma-2"
                        tile
                        text
                        small
                        link
                        :to="`/service/${item.id}`"
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
            headers: [
                {
                    text: "Emri",
                    align: "left",

                    value: "name"
                },
                { text: "Numri i ofertave ku perdoret:", value: "offers.length", align: "center" },
                { text: "Numri i detyrave:", value: "tasks.length", align: "center" },
                { text: "Detyrat:", value: "tasks", align: "left",sortable:false },
        


                { text: "Shtuar me date:", value: "created_at", align: "left" },
                { text: "Shtuar nga:", value: "user.name", align: "left" },
                // { text: "Statusi:", value: "status", align: "left" },
                { text: "", value: "action", sortable: false, align: "right" }
            ],

            resources: [],
                
        };
    },
    computed: {},
    methods: {
        get_tasks_names(tasks){

            let names = '';
            if(tasks.length<3){
                for(let counter = 0;counter<tasks.length;counter++){

                    names = names + tasks[0].name+', ';

                }

            }else{
                names = names + tasks[0].name+', ';
                names = names + tasks[1].name+', ';
                names = names + tasks[2].name;
                if(tasks.length > 3){
                    names = `${names} + ${tasks.length -3} detyra`
                }
            }
            return names;
        },
        services_active() {
            return this.resources.filter(service => service.status == "active");
        },
        services_pasive() {
            return this.resources.filter(service => service.status == "pasive");
        },

        readable_date(date) {
            moment.locale("sq");
            return moment(date).format("DD/MM/YYYY");
        }
    },
    beforeMount() {
        var currentObj = this;
        axios
            .get("/service")
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