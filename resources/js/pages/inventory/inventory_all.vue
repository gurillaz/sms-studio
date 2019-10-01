<template>
    <div>

    <v-card class="px-5 ma-5 mt-0">

        <v-card-title>
            Te gjithe pajisjet
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
                :items="inventories"
                :search="search"
                height="70vh"
        >
            <template v-slot:item.action="{ item }">
                <v-btn class="ma-2" tile text small link :to="`/inventory/${item.id}`" target="_blank">
                    Shiqo
                    <v-icon small right>mdi-open-in-new</v-icon>
                </v-btn>
            </template>



        </v-data-table>
    </v-card>
    </div>
</template>

<script>
    import axios from '@/js/config/axios.js'
import moment from 'moment';
    export default {
        data () {
            return {
                search: '',
                headers: [
                    {
                        text: 'Emri',
                        align: 'left',

                        value: 'name',
                    },
                    { text: 'Lloji', value: 'type' },
                    { text: 'Cmimi i blerjes', value: 'price' },
                    { text: 'Data e blerjes', value: 'purchase_date' },
                    { text: 'Shtuar me date:', value: 'created_at' },

                    { text: 'Statusi:', value: 'status' },
                    { text: '', value: 'action', sortable: false, align:'right' },

                ],
                inventories: [],
            }
        },
        methods: {
            formatDate(date){
                moment.locale('sq');
                    return moment(date).format('D MMMM YYYY')
            }
        },
        beforeMount() {
            var currentObj = this;
            axios.get('/inventory')
                .then(function (resp) {
                    // console.log(resp.data);
                    currentObj.inventories= resp.data.data;
                    currentObj.inventories.forEach(inv=>inv.created_at=currentObj.formatDate(inv.created_at))

                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load Employees");
                });
        },
    }
</script>