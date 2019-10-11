<template>
    <div>

    <v-card class="px-5 ma-5 mt-0">

        <v-card-title>
            Te gjitha sherbimet
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
                height="70vh"
        >
            <template v-slot:item.created_at="{ item }">

                {{readable_date(item.updated_at)}}
            </template>
            <template v-slot:item.action="{ item }">
                <v-btn class="ma-2" tile text small link :to="`/task/${item.id}`" target="_blank">
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
                    { text: 'Nr. i detyrave ne sherbim(Gjithesej):', value: 'tasks.length',align:'center' },
                    { text: 'Perdoret ne oferta(Gjithesej):', value: 'offers.length',align:'center' },
                    { text: 'Cmimi:', value: 'price' },
     

                    { text: 'Statusi:', value: 'status',align:'left' },
                    { text: 'Shtuar me date:', value: 'created_at', align:'left' },
                    { text: 'Shtuar nga:', value: 'user.name', align:'right' },
                    { text: '', value: 'action', sortable: false, align:'right' },

                ],
                resources: [],
            }
        },
        methods: {
            readable_date(date){
                moment.locale('sq');
                    return moment(date).format('DD/MM/YYYY')
            }
        },
        beforeMount() {
            var currentObj = this;
            axios.get('/service')
                .then(function (resp) {
                    // console.log(resp.data);
                    currentObj.resources= resp.data.resources;
                    // currentObj.resources.forEach(res=>res.created_at=currentObj.formatDate(res.created_at))

                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load services");
                });
        },
    }
</script>