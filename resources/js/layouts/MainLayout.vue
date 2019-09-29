<template>
    <v-app>
        <v-navigation-drawer
            v-model="drawer"
            :mini-variant.sync="mini"
            width="285"
            mini-variant-width="95"
            app
            color="indigo accent-4"
            dark
        >
            <v-toolbar color="indigo accent-4" dark flat>
                <v-list-item class>
                    <v-icon large>mdi-video-image</v-icon>
                    <v-toolbar-title class="ml-0 pl-3">
                        <span class>SMS-Studio</span>
                    </v-toolbar-title>
                </v-list-item>
            </v-toolbar>
            <v-list dense>
                <v-list-item to="/">
                    <v-list-item-icon>
                        <v-icon>mdi-view-dashboard</v-icon>
                    </v-list-item-icon>

                    <v-list-item-title>Dashboard</v-list-item-title>
                </v-list-item>
            </v-list>
            <v-divider class="mx-3"></v-divider>

            <v-list dense v-for="(section, index) in links" :key="index">
                <v-subheader
                    v-bind:class="mini ? 'justify-center' : 'ml-1'"
                    class="text-uppercase font-weight-bold"
                >{{section.name}}</v-subheader>

                <v-list-group
                    v-for="(group, index) in section.groups"
                    :key="index"
                    :prepend-icon="group.icon"
                    no-action
                    color="white"
                    :group="group.name"
                >
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title>{{group.title}}</v-list-item-title>
                        </v-list-item-content>
                    </template>

                    <v-list-item :to="item.to" v-for="(item, index) in group.items" :key="index">
                        <v-list-item-title>{{item.title}}</v-list-item-title>
                        <v-list-item-icon>
                            <v-icon>{{item.icon}}</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                </v-list-group>
                <v-divider class="mx-3"></v-divider>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app flat color="#fafafa">
            <v-btn icon @click.stop="mini = !mini">
                <v-icon v-if="mini==true">mdi-chevron-right</v-icon>
                <v-icon v-if="mini==false">mdi-chevron-left</v-icon>
            </v-btn>
            <!--            <v-toolbar-title>Application</v-toolbar-title>-->

            <div class="ml-auto">
                <v-btn text to="/client/new">
                    <v-icon left>mdi-account-plus-outline</v-icon>Klient i ri
                </v-btn>
                <v-btn text class="mx-3" to="/job/new">
                    <v-icon left>mdi-calendar-plus</v-icon>Pune e re
                </v-btn>

                <v-menu transition="slide-y-transition" offset-y>
                    <template v-slot:activator="{ on }">
                        <v-btn v-on="on" text>
                            <v-icon left large class="mr-4">mdi-account-circle</v-icon>
                            {{user.name}}
                            <v-icon right>mdi-chevron-down</v-icon>
                        </v-btn>
                    </template>
                    <v-list dense>
                        <v-subheader>{{user.name}}</v-subheader>
                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon>mdi-account-details</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Profili</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="logout()">
                            <v-list-item-icon>
                                <v-icon>mdi-logout-variant</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Dil</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>

                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                    <input type="hidden" name="_token" :value="token" />
                </form>
            </div>
        </v-app-bar>

        <v-content>
            <v-container fluid>
                <router-view></router-view>
            </v-container>
        </v-content>
        <!--        <v-footer-->
        <!--                color="indigo"-->
        <!--                app-->
        <!--        >-->
        <!--            <span class="white&#45;&#45;text">&copy; 2019</span>-->
        <!--        </v-footer>-->

        <v-snackbar
            v-model="snackbar.show"
            :bottom="true"
            :right="true"
            :color="snackbar.color"
            :timeout="snackbar.timeout"
            :vertical="snackbar.mode === 'vertical'"
            :multi-line="snackbar.mode === 'multi-line'"
        >
            {{ snackbar.text }}
            <v-btn dark text @click="snackbar.show = false">Close</v-btn>
        </v-snackbar>
    </v-app>
</template>

<script>
import links from "@/js/config/sidebarLinks";
import { mapState } from "vuex";
export default {
    data() {
        return {
            drawer: true,
            links: links,
            mini: false,
            user: this.$store.getters.user

            // snackbar: this.$store.getters.snackbar
        };
    },
    computed: {
        ...mapState(["snackbar"]),

        token() {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            return token.content;
        }
    },
    methods: {
        logout() {
            this.$store.dispatch("logout");
            document.getElementById("logout-form").submit();
        }
    },

    watch: {
        snackbar(changed_snackbar, snackbar) {
            if (changed_snackbar.show === true) {
                snackbar = changed_snackbar;
            }
        }
    }
};
</script>
