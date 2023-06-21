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
                :items="resources"
                :search="search"
                height="69vh"
        >
            <template v-slot:item.created_at="{ item }">
                {{readable_date(item.created_at,item.updated_at)}}
            </template>
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
                    { text: 'Klienti', value: 'client.name' },
                    { text: 'Oferta', value: 'offer.name' },
                    { text: 'Cmimi', value: 'price' },
                    { text: 'Pagesa:', value: 'payment_status' },
                    // { text: 'Email', value: 'email' },
                    // { text: 'Qyteti', value: 'city' },
                    // { text: 'Adresa', value: 'address' },
                    { text: 'Krijuar me date:', value: 'created_at' },
                    { text: 'Krijuar nga:', value: 'created_by.name' },
                    { text: '', value: 'action', sortable: false, align:'right' },

                ],
                resources: [],
            }
        },
        beforeMount() {
            let currentObj = this;
            axios.get('/job')
                .then(function (resp) {
                    // console.log(resp.data);
                    currentObj.resources= resp.data.resources;

                })
                .catch(function (resp) {
                    // console.log(resp);
                    alert("Could not load data");
                });
        },
        methods: {
                    readable_date(created_at, updated_at) {
            moment.locale("sq");
            if (created_at === updated_at) {
                return moment(updated_at).calendar();
            } else {
                return (
                    moment(updated_at).calendar() +
                    " (E modifikuar)"
                );
            }
        },
        },
    }
</script>