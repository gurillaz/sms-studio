<template>
    <v-app id="inspire">
        <v-content>
            <v-container
                    class="fill-height"
                    fluid
            >
                <v-row
                        align="center"
                        justify="center"
                >
                    <v-col
                            cols="12"
                            sm="8"
                            md="4"
                    >
                        <v-card class="elevation-12">
                            <v-toolbar
                                    color="primary"
                                    dark
                                    flat
                            >
                                <v-toolbar-title>Kyqu</v-toolbar-title>

                            </v-toolbar>
                            <v-card-text>
                                <v-form >

<!--                                    <input type="hidden" name="_token" :value="token">-->
                                    <v-text-field
                                            label="Login"
                                            name="email"
                                            v-model="email"
                                            prepend-icon="mdi-email"
                                            type="text"
                                    ></v-text-field>

                                    <v-text-field

                                            label="Password"
                                            name="password"
                                            v-model="password"

                                            prepend-icon="mdi-lock"
                                            type="password"
                                    ></v-text-field>
                                </v-form>
                            </v-card-text>
                            <v-card-actions class="pa-5">
                                <div class="flex-grow-1"></div>
                                <v-btn color="primary" @click="login">Kyqu</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import axios from '@/js/config/axios';

    export default {

        data() {
            return {
                email: '',
                password: '',

            }
        },
        methods: {
            login() {
                let email = this.email;
                let password = this.password;
                this.$store.dispatch('login', { email, password })
                    .then(() => this.$router.push('/'))
                    .catch(err => console.log(err))
            },


        },

    }
</script>
