<template>
    <div>
        <v-card class="px-5 ma-5 mt-0">
            <v-card-title>
                Te gjitha fajllat
                <div class="flex-grow-1"></div>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-account-search"
                    label="Kerko"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers" :items="files" :search="search" height="70vh">
                <template v-slot:item.action="{ item }">
                    <v-btn class="ma-2" tile text small link :to="`/file/${item.id}`">
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
                { text: "I takon", value: "belongs_to_readable" },
                { text: "Fajlli:", value: "file_name" },
                { text: "Madhesia(MB):", value: "file_size" },
                { text: "Extension:", value: "file_extension" },
                { text: "Shtuar me date:", value: "updated_at_readable" },
                { text: "Shtuar nga:", value: "created_by.name" },

                { text: "", value: "action", sortable: false, align: "right" }
            ],
            files: []
        };
    },
    methods: {
        readable_date(created_at, updated_at) {
            moment.locale("sq");
            if (created_at === updated_at) {
                return moment(updated_at).format("D MMMM YYYY [ora] HH:mm");
            } else {
                return (
                    moment(updated_at).format("D MMMM YYYY [ora] HH:mm") + " (E modifikuar)"
                );
            }
        },
        belongs_to_readable(belongs_to) {
            if (belongs_to === "Employee") {
                return "Puntor";
            }
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
            .get("/file")
            .then(function(resp) {
                // console.log(resp.data);
                currentObj.files = resp.data.files;
                currentObj.files.forEach(file => {
                    file["updated_at_readable"] = currentObj.readable_date(
                        file.created_at,
                        file.updated_at
                    );
                    file["belongs_to_readable"] =
                        "(" +
                        currentObj.belongs_to_readable(file.model) +
                        ") " +
                        file.belongs_to.name;
                    return file;
                });
            })
            .catch(function(resp) {
                console.log(resp);
                alert("Could not load Files");
            });
    }
};
</script>
