<template>
    <div class="px-5">

        <v-row>
            <v-col>
                <div class="headline">
                    <v-icon left>mdi-tag-multiple</v-icon>
                    Te gjitha ofertat
                </div>


            </v-col>

            <v-col class="text-right">

                <v-btn class="mr-3" color="primary" outlined to="/offer/new">
                    <v-icon left>mdi-tag-plus</v-icon>
                    Shto oferte te re
                </v-btn>


            </v-col>

        </v-row>
        <v-row v-if="offers!==-1&&offers.length > 0">


            <offerCard :offer="offer" v-bind:key="offer.id" v-for="offer in offers"></offerCard>


        </v-row>

        <v-row v-if="offers!==-1&& offers.length===0">
            <v-col class="ma-12 text-center" cols="12">


                <p class="display-1 grey--text">Nuk ka oferta te ruajtura!</p>
                <p class="display-1 grey--text">Shto te re</p>
            </v-col>


        </v-row>

    </div>
</template>

<script>
    import axios from '@/js/config/axios.js';
    import offerCard from '@/js/pages/offer/offerCard';

    export default {
        components: {offerCard},
        data() {
            return {

                offers: -1,


            }
        },
        beforeMount() {
            let currentObj = this;

            axios.get('/offer')
                .then(function (resp) {
                    currentObj.offers = resp.data.offers;


                })
                .catch(function (resp) {

                    console.log(resp);
                    alert("Could not load Offers");
                });
        },


    }
</script>