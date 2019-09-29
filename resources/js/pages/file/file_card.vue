<template>
    <v-col cols="4">
        <v-card hover color="indigo lighten-5">
            <v-list-item>
                <v-list-item-content>
                    <div class="overline mb-4">{{updated_at}}</div>
                    <v-list-item-title class="headline">{{file.name}}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-card-text class="py-0">
                <!-- </v-col> -->
                <!-- <v-col cols="12"> -->
                <v-textarea label="Shenimi:" rows="3" v-model="file_description" readonly></v-textarea>
                <!-- </v-col> -->
            </v-card-text>
            <v-card-actions>
                <!-- <div class="flex-grow-1"></div>
                -->
                <v-col cols="6" class="py-0">
                    <v-btn outlined block small @click="download_file()">Shkarko</v-btn>
                </v-col>
                <v-col cols="3" class="py-0">
                    <v-btn :to="`/file/${file.id}`" target="_blank" text block>
                        <v-icon left small>mdi-information-outline</v-icon>Detaje
                    </v-btn>
                </v-col>
                <v-col cols="3" class="py-0">
                    <v-btn text color="error" @click="$parent.deleteFile(file.id)" block>
                        <v-icon left small>mdi-delete-outline</v-icon>Fshije
                    </v-btn>
                </v-col>
            </v-card-actions>
        </v-card>
        <form action="#" method="get" ref="downloadForm" style="display: none;"></form>

    </v-col>
    <!-- <v-col cols="3">

        <v-card


                hover


        >
            <v-list-item>
                <v-list-item-content>
                    <div class="overline mb-4">{{file.created_at}}</div>
                    <v-list-item-title class="headline">{{file.name}}</v-list-item-title>

                </v-list-item-content>

            </v-list-item>
            <v-card-text class="pt-0">
                <p class="text-justify " style="line-height:1.1rem; min-height: 3rem">
                    {{file.description}}</p>


            </v-card-text>
            <v-card-actions>




                        <v-row class="">
                        <v-col cols="12" class="py-0 px-5">
                            <v-btn outlined block small color="primary" @click="downloadFile()">Shkarko</v-btn>
                        </v-col>
                            <v-col cols="12" class="pb-0 text-right">



                                <v-btn
                                        :to="`/file/${file.id}`"
                                        target="_blank"
                                        text>
                                    <v-icon left small>mdi-information-outline</v-icon>
                                    Detaje
                                </v-btn>
                                <v-btn text color="error" @click="$parent.deleteFile(file.id)">Fshije</v-btn>

                            </v-col>
                        </v-row>




            </v-card-actions>
        </v-card>
        <form action="#" method="get" ref="downloadForm" style="display: none;"></form>

    </v-col>-->
</template>

<script>
import axios from "@/js/config/axios";
import moment from 'moment'

export default {
    data() {
        return {};
    },
    computed: {
                updated_at() {
            // return 'asdasd';
            moment.locale("sq");
            return moment(this.file.updated_at).calendar();
        },
        file_description() {
            //nese nuk eshte note.body i zbrazet
            if (this.file.description) {
                if (this.file.description.length < 290) {
                    return this.file.description;
                } else {
                    return `${this.file.description.substring(
                        0,
                        290
                    )} ...(vazhdon)`;
                }
            }
        },
        
    },
    props: ["file"],
    name: "fileCard",
    methods: {

        download_file() {
            let currentObj = this;
            axios
                .get(`/checkIfFileExists/${currentObj.file.file}`)
                .then(resp => {
                    currentObj.$refs.downloadForm.action = resp.data.path;
                    currentObj.$refs.downloadForm.submit();
                })
                .catch(resp => {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "warning",
                        text: "Fajlli nuk u gjet ne server!"
                    });
                });
        }
    }
};
</script>
