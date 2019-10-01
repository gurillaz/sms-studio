<template>
<v-card class="px-5 ma-5">

            <v-card-title>
                <v-icon left>mdi-calendar-multiple</v-icon>Te gjitha punet
                <div class="flex-grow-1"></div>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-account-search"
                    label="Kerko"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
        <v-data-table
                :headers="headers"
                :items="jobs"
                :search="search"
        >
            <template v-slot:item.action="{ item }">
                <v-btn class="ma-2" tile text small link :to="`/job/${item.id}`">
                    Shiqo
                    <v-icon small right>mdi-open-in-new</v-icon>
                </v-btn>
            </template>



        </v-data-table>
    </v-card>
</template>

<script>
    import axios from '@/js/config/axios.js'
    export default {
        data () {
            return {
                search: '',
                headers: [
                    {
                        text: 'Puna',
                        align: 'left',

                        value: 'name',
                    },
                    { text: 'Cmimi', value: 'price' },
                    // { text: 'Email', value: 'email' },
                    // { text: 'Qyteti', value: 'city' },
                    // { text: 'Adresa', value: 'address' },
                    { text: '', value: 'action', sortable: false, align:'right' },

                ],
                jobs: [],
            }
        },
        beforeMount() {
            let currentObj = this;
            axios.get('/job')
                .then(function (resp) {
                    // console.log(resp.data);
                    currentObj.jobs= resp.data.jobs;

                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load Jobs");
                });
        },
    }
</script>