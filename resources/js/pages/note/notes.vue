<template>
    <div>
        <v-card class="px-5 ma-5 mt-0">
            <v-card-title>
                Te gjitha shenimet
                <div class="flex-grow-1"></div>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-account-search"
                    label="Kerko"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
      
            <v-data-table :headers="headers" :items="notes" :search="search" height="70vh">
                <template v-slot:item.action="{ item }">
                    <v-btn class="ma-2" tile text small link :to="`/note/${item.id}`">
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
                    text: "Titulli",
                    align: "left",

                    value: "name"
                },
                { text: "I takon", value: "belongs_to_readable" },
                { text: "Shtuar me date:", value: "updated_at_readable" },
                { text: "Shtuar nga:", value: "created_by.name" },

                { text: "", value: "action", sortable: false, align: "right" }
            ],
            notes: []
        };
    },
    methods: {
        formatDate(created_at, updated_at) {
            moment.locale("sq");
            if(created_at===updated_at){
            return moment(updated_at).format("D MMMM YYYY");
            }
            else{
            return moment(updated_at).format("D MMMM YYYY")+' (E modifikuar)';

            }
        },
        belongsToReadable(belongs_to) {
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
            if (belongs_to === "Inevntory") {
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
        }
    },
    beforeMount() {
        var currentObj = this;
        axios
            .get("/note")
            .then(function(resp) {
                // console.log(resp.data);
                currentObj.notes = resp.data.notes;
                currentObj.notes.forEach(
                    note =>{
                        note['updated_at_readable'] = currentObj.formatDate(
                            note.created_at,note.updated_at
                        );
                        note['belongs_to_readable'] = '('+currentObj.belongsToReadable(note.model)+') '+note.belongs_to.name;
                        return note;
            }
                );
            })
            .catch(function(resp) {
                console.log(resp);
                alert("Could not load Notes");
            });
    }
};
</script>