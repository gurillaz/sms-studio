<template>
    <v-app>
        <v-content>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="5">
                        <v-card class="elevation-12">
                            <v-toolbar color="indigo" dark flat>
                                <v-toolbar-title>Log In</v-toolbar-title>
                            </v-toolbar>
            
                            <v-card-text class="px-5">
                                <!-- {{Number(new Date(3600000))}} -->
                                <v-form>
                                    <v-text-field
                                        class="mt-5"
                                        label="Email:"
                                        v-model="email"
                                        prepend-inner-icon="mdi-email"
                                        type="text"
                                    ></v-text-field>

                                    <v-text-field
                                        class="mt-5"
                                        label="Fjalkalimi:"
                                        v-model="password"
                                        prepend-inner-icon="mdi-lock"
                                        type="password"
                                    ></v-text-field>
                                </v-form>
                            </v-card-text>
                            <v-card-actions class="pa-5">
                                <div class="flex-grow-1"></div>
                                <v-btn color="primary" @click="login" block>Kyqu</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
import axios from "@/js/config/axios";

export default {
    data() {
        return {
            email: "",
            password: ""
        };
    },
    created() {
        const lastActivityAt = localStorage.getItem("LS_LAST_ACTIVITY_AT_KEY");

        const hasBeenActiveRecently = Boolean(
            //3600000 miliseconds 1 hour
            lastActivityAt && Date.now() - Number(lastActivityAt) < 3600000
        );
        if(!hasBeenActiveRecently && lastActivityAt != null){
            // location.reload();
        }
    },

    methods: {
        login() {
            let email = this.email;
            let password = this.password;
            const lastRoutePath = localStorage.getItem("LS_ROUTE_KEY");
            const lastActivityAt = localStorage.getItem(
                "LS_LAST_ACTIVITY_AT_KEY"
            );

            const hasBeenActiveRecently = Boolean(
                //3600000 miliseconds 1 hour
                lastActivityAt && Date.now() - Number(lastActivityAt) < 3600000
            );

            this.$store
                .dispatch("login", { email, password })
                .then(() => {
                    // If has been active last hour, redirect to last known path, else redirect to dashboard-home /
                    if (hasBeenActiveRecently) {
                        this.$router.push({ path: lastRoutePath });
                    } else {
                        this.$router.push({ path: "/" });
                    }
                })

                .catch(err => console.log(err));
        }
    }
};
</script>
