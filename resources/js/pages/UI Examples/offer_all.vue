<template>
    <v-container>
          <v-row>
            <v-col>
                <div class="headline">Ofertat</div>
            </v-col>
          </v-row>
        <v-row v-if="resources.length >0">
            <v-col cols="4" v-for="(offer,index) in resources" :key="index">
                <v-card hover>
                    <v-sheet height="7rem" color="indigo lighten-1" tile dark>
                        <v-container>
                            <v-row>
                                <v-col cols="10" class="py-0"><span class="font-weight-medium">{{offer.name}}</span></v-col>

                                <v-col cols="2" class="py-0">
                                    <v-icon right>mdi-tag-multiple</v-icon>
                                </v-col>
                                <v-col cols="12" class="py-0">
                                    <span class="display-1 font-weight-bold">{{(offer.price).toFixed(2)}}</span>
                                
                                </v-col>
                          
                            </v-row>
                        </v-container>
                    </v-sheet>
                    <v-container>
                        <v-row>
                            <v-col cols="12" class="py-0"><p class="caption py-0">Gjithsej {{offer.services.length}} sherbime:</p></v-col>
                            <v-col cols="12" class="py-0"><p class="py-0 subtitle-2" style="height:3.5rem">{{services_names(offer.services)}}</p></v-col>
                        </v-row>
             
                    </v-container>
                    <div class="caption py-0 ml-3">E shtuar {{readable_date(offer.created_at,offer.updated_at)}} nga {{offer.user.name.split(' ')[0]}}</div>
                    <v-card-actions>
                        <v-btn block color="indigo darken-4`" dark :to="`/offer/${offer.id}`">Shiko Oferten</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-row v-else>
            <v-col
                cols="12"
            >Nuk ka oferta te ruajtura. Duhet te shtoni te pakten nje oferte, per te shtuar pune te re.</v-col>
        </v-row>
    </v-container>
</template>

<script>
import axios from "@/js/config/axios.js";
import moment from "moment";
export default {
    data() {
        return {
            resources: [],
            
        };
    },
    beforeMount() {
        let currentObj = this;
        axios
            .get("/offer")
            .then(function(resp) {
                // console.log(resp.data);
                currentObj.resources = resp.data.resources;
            })
            .catch(function(resp) {
                currentObj.$store.dispatch("showSnackbar", {
                    color: "error",
                    text: "Serveri nuk dergoi te dhena!"
                });
            });
    },
    methods: {
        services_names(services){
            let names = '';
            if(services.length<7){
            services.forEach(service => {
                names = names + service.name +', '
            });
            }else if(services.length == 7){
                names =
                services[0].name + ', '+
                services[1].name + ', '+
                services[2].name + ', '+
                services[3].name + ', '+
                services[4].name + ', '+
                services[5].name + ', '+
                services[6].name;
            }else if(services.length == 8){
                names =
                services[0].name + ', '+
                services[1].name + ', '+
                services[2].name + ', '+
                services[3].name + ', '+
                services[4].name + ', '+
                services[5].name + ', '+
                services[6].name + ` + 1 sherbim tjeter.`
            }
            else{
                                names =
                services[0].name + ', '+
                services[1].name + ', '+
                services[2].name + ', '+
                services[3].name + ', '+
                services[4].name + ', '+
                services[5].name + ', '+
                services[6].name + ` + ${services.length-7} sherbime tjera.`
            }
            return names;
        },
        readable_date(created_at, updated_at) {
            moment.locale("sq");
            if (created_at === updated_at) {
                return moment(updated_at).calendar();
            } else {
                return moment(updated_at).calendar() + " (M)";
            }
        }
    }
};
</script>