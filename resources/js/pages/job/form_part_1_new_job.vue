<template>
    <v-row class="mx-0" style="overflow-y: scroll; min-height: 57vh">
        <FormOfferCard :offer="offer" v-bind:key="offer.id" v-for="offer in offers"></FormOfferCard>
    </v-row>
    
</template>

<script>
import FormOfferCard from "@/js/pages/job/form_job_offer_card";
import { mapFields } from "vuex-map-fields";


export default {
    name:"FormPart1",
    components: { FormOfferCard },
    data() {
        return {};
    },
    computed: {
        ...mapFields({
            offers: "form_new_job_data.offers"
        })
    }
};
</script>