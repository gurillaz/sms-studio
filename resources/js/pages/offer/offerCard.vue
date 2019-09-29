<template>
    <v-col cols="4">

        <v-card
                hover
        >
            <v-list-item>
                <v-list-item-content>
                    <div class="overline mb-4">{{updated_at}} nga {{offer.created_by}}</div>
                    <v-list-item-title align="center" class="headline thin">{{offer.name}}</v-list-item-title>

                </v-list-item-content>

            </v-list-item>
            <div class="pt-0">
                <v-card-text>

                    <!--                <p class="pb-0 mb-0 text-uppercase grey&#45;&#45;text">Cmimi:</p>-->
                    <div class="text-center">
                        <p class="display-1 thin">{{offer.price}}€ <span class="font-weight-bold">(-{{offer.discount*100}}%)</span>
                        </p>
                    </div>


                    <div class="text-center" style="min-height: 8rem">
                        <p class="pb-0 mb-0 text-uppercase grey--text">Sherbimet:</p>
                        <v-chip
                                :color="randomColor()"


                                class="ma-1"
                                outlined
                                small


                                v-bind:key="service.id + i"

                                v-for="(service, i) in offer.services"


                        >
                            <span>{{service.name}}</span>
                        </v-chip>
                    </div>

                </v-card-text>
            </div>
            <v-card-actions>
                <div class="flex-grow-1"></div>
<!--                <v-btn
                        @click="select_offer"
                        text>
                    <v-icon left small>mdi-calendar-plus</v-icon>
                    Zgjidh oferten
                </v-btn>-->
                <v-btn
                        :to="`/offer/${offer.id}`"
                        target="_blank"
                        text>
                    <v-icon left small>mdi-information-outline</v-icon>
                    Detaje
                </v-btn>


                <!--                <v-btn text color="error" @click="$parent.deleteOffer(offer.id)">Fshije</v-btn>-->
            </v-card-actions>
        </v-card>


    </v-col>

</template>

<script>
    import colors from 'vuetify/lib/util/colors'
    // https://momentjs.com/
    import moment from 'moment';

    export default {
        data() {
            return {
                elevation: 1,
                color: 'white',
            }
        },
        props: ['offer'],
        name: "offerCard",
        methods: {

            randomColor: function () {
                let keys = Object.keys(colors);
                return colors[keys[keys.length * Math.random() << 0]].darken2;
            },

        },
        computed: {
            updated_at() {
                // return 'asdasd';
                moment.locale('sq');
                return moment(this.offer.updated_at).calendar();

            },

        }


    }
</script>

<style scoped>

</style>