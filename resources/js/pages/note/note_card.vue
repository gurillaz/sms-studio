<template>
    <v-col cols="4">
        <v-card hover color="amber lighten-2">
            <v-list-item>
                <v-list-item-content>
                    <div class="overline mb-4">{{updated_at}}</div>
                    <v-list-item-title class="headline">{{note.name}}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-card-text class="py-0">
                        
                        <!-- </v-col> -->
                        <!-- <v-col cols="12"> -->
                            <v-textarea
                                
                                label="Shenimi:"
                                rows="6"
                                v-model="noteBody"
                                readonly
                                
                            ></v-textarea>
                        <!-- </v-col> -->
          
            </v-card-text>
            <v-card-actions>
                <div class="flex-grow-1"></div>
                <v-btn :to="`/note/${note.id}`" target="_blank" text>
                    <v-icon left small>mdi-information-outline</v-icon>Detaje
                </v-btn>
                <v-btn text color="error" @click="$parent.deleteNote(note.id)">
                    <v-icon left small>mdi-delete-outline</v-icon>Fshije</v-btn>
            </v-card-actions>
        </v-card>

<!--         <v-card hover color="amber lighten-1">
            <v-list-item>
                <v-list-item-content>
                    <div class="overline mb-4">{{updated_at}}</div>
                    <v-list-item-title class="headline">{{note.name}}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-card-text class="pt-0">
                <p class="text-justify" style="line-height:1.5rem; min-height: 8rem">{{noteBody}}</p>
            </v-card-text>
            <v-card-actions>
                <div class="flex-grow-1"></div>
                <v-btn :to="`/note/${note.id}`" target="_blank" text>
                    <v-icon left small>mdi-information-outline</v-icon>Detaje
                </v-btn>
                <v-btn text color="error" @click="$parent.deleteNote(note.id)">Fshije</v-btn>
            </v-card-actions>
        </v-card> -->
    </v-col>
</template>

<script>
import moment from "moment";
export default {
    props: ["note"],
    name: "noteCard",
    computed: {
        noteBody() {
            //nese nuk eshte note.body i zbrazet
            if (this.note.body) {
                if (this.note.body.length < 290) {
                    return this.note.body;
                } else {
                    return `${this.note.body.substring(0, 290)} ...(vazhdon)`;
                }
            }
        },
        updated_at() {
            // return 'asdasd';
            moment.locale("sq");
            return moment(this.note.updated_at).calendar();
        }
    }
};
</script>

<style scoped>
</style>