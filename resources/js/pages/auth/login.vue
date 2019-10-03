<template>
    <v-app>
        <v-content>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="5">
                        <v-card class="elevation-12">
                            <v-toolbar color="indigo" dark flat>
                                <v-toolbar-title>Kyqu</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text class="px-5">
                                <v-form>
                                    <v-text-field
                                        class="mt-5"
                                        label="Email:"
                                        name="email"
                                        v-model="email"
                                        prepend-inner-icon="mdi-email"
                                        type="text"
                                    ></v-text-field>

                                    <v-text-field
                                        class="mt-5"

                                        label="Fjalkalimi:"
                                        name="password"
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
    methods: {
        login() {
            let email = this.email;
            let password = this.password;
            this.$store
                .dispatch("login", { email, password })
                .then(() => this.$router.push("/"))
                .catch(err => console.log(err));
        }
    }
};
</script>
