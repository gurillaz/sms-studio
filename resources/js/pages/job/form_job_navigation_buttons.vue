<template>

        <v-row >
    
            <v-col cols="3" class="pt-0 pr-5" v-if="current_step!=1">
                <v-btn
                    :disabled="disabled_prev"
                    @click="$parent.current_step = current_step - 1"
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
                    @click="$parent.current_step = current_step + 1"
                    color="primary"
                    block
                    small
                    outlined
                >Para</v-btn>
            </v-col>
        </v-row>



</template>

<script>

export default {
    name: "FormNavigationButtons",
    props:['current_step','finished_step'],


    data() {
        return {
            // current_step,
            // finished_step
        };
    },
    methods: {
  
    },
    computed: {

        disabled_next:function() {
            if(this.current_step== 1 < this.finished_step){
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
