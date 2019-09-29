<template>

        <v-row class="mx-2">
    
            <v-col cols="3" class="pt-0 pr-5" v-if="current_step!=1">
                <v-btn
                    :disabled="disabled_prev"
                    @click="current_step = current_step - 1"
                    color="primary"
                    block
                    small
                    outlined
                >Pas</v-btn>
            </v-col>

            <div class="flex-grow-1"></div>

            <v-col cols="3" class="pt-0 pr-5" v-if="current_step<5">
                <v-btn
                    :disabled="disabled_next"
                    @click="current_step = current_step + 1"
                    color="primary"
                    block
                    small
                    outlined
                >Para</v-btn>
            </v-col>
        </v-row>



</template>

<script>
import { mapFields } from "vuex-map-fields";

export default {
    name: "FormNavigationButtons",



    data() {
        return {
 
        };
    },
    methods: {
  
    },
    computed: {
        ...mapFields({
             selected_offer_id: "form_new_job_data.selected_offer_id",
            selected_client_id: "form_new_job_data.selected_client_id",
  

            current_step: "form_new_job_data.current_step",
            events: "form_new_job_data.events",
            offers: "form_new_job_data.offers",
            payments: "form_new_job_data.payments",
            clients: "form_new_job_data.clients",
            created_job: "form_new_job_data.created_job",
            job_saved: "form_new_job_data.job_saved",
        }),
        disabled_next:function() {
            if(this.current_step== 1 && this.selected_offer_id == ''){
                return true;
            }
            else if(this.current_step== 2 && this.selected_client_id == ''){
                return true;
            }
            
            else if(this.current_step== 3 && this.events.length === 0){
                return true;
            }
            else if(this.current_step== 4 && this.job_saved!=true){
                return true;
            }
            else{
                return false;
            }
        },
        disabled_prev:function() {
            if(this.current_step==4 && this.job_saved){
                return true;
            }
            else if(this.current_step<4 ){
                return false;
            }
       
            else{
                return false;
            }
        }

    }
};
</script>
