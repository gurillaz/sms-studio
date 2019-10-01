<template>
    <div>
        <v-card class="px-5 ma-5">
            <v-card-title>
                <v-icon left>mdi-account-group-outline</v-icon>Te gjithe klientet
                <div class="flex-grow-1"></div>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-account-search"
                    label="Kerko"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers" :items="clients" :search="search">
                <template v-slot:item.action="{ item }">
                    <v-btn
                        class="ma-2"
                        tile
                        text
                        small
                        link
                        :to="`/client/${item.id}`"
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
export default {
    data() {
        return {
            search: "",
            headers: [
                {
                    text: "Klienti",
                    align: "left",

                    value: "name"
                },
                { text: "Telefon", value: "phone" },
                { text: "Email", value: "email" },
                { text: "Qyteti", value: "city" },
                { text: "Adresa", value: "address" },
                { text: "", value: "action", sortable: false, align: "right" }
            ],
            clients: []
        };
    },
    beforeMount() {
        let currentObj = this;
        axios
            .get("/client")
            .then(function(resp) {
                // console.log(resp.data);
                currentObj.clients = resp.data.clients;
            })
            .catch(function(resp) {
                console.log(resp);
                alert("Could not load Clients");
            });
    }
};
</script>