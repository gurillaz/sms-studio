<template>
    <div>

    <v-card class="px-5 ma-5 mt-0">

        <v-card-title>
        <v-icon left>mdi-account-group</v-icon>
            Te gjithe puntoret
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
                :items="employees"
                :search="search"
                height="65vh"
        >
            <template v-slot:item.action="{ item }">
                <v-btn class="ma-2" tile text small link :to="`/employee/${item.id}`" target="_blank">
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
                        text: 'Puntori',
                        align: 'left',

                        value: 'name',
                    },
                    { text: 'Pozita', value: 'position' },
                    { text: 'Telefon', value: 'phone' },
                    { text: 'Email', value: 'email' },
                    // { text: 'Qyteti', value: 'city' },
                    { text: 'Adresa', value: 'address' },
                    { text: 'Filloi me date:', value: 'created_at' },

                    { text: 'Statusi:', value: 'status' },
                    { text: '', value: 'action', sortable: false, align:'right' },

                ],
                employees: [],
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
            axios.get('/employee')
                .then(function (resp) {
                    // console.log(resp.data);
                    currentObj.employees= resp.data.data;
                    currentObj.employees.forEach(emp=>emp.created_at=currentObj.formatDate(emp.created_at))

                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load Employees");
                });
        },
    }
</script>