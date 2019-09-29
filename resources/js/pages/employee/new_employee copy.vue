<template>
    <div class="mx-3">
        <v-stepper v-model="current_step">
            <v-stepper-header class="px-12">
                <v-stepper-step :complete="stpe_1_completed" step="1">Te dhenat baze</v-stepper-step>
                <v-divider></v-divider>

                <v-stepper-step :complete="current_step > 2" step="2">Te dhenat e punes</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step :complete="current_step > 3" step="3">Qasja ne aplikacion</v-stepper-step>
                <v-divider></v-divider>

                <v-stepper-step step="4">Perfundo</v-stepper-step>
            </v-stepper-header>

            <v-stepper-items>
                <v-stepper-content step="1">
                    <v-row class="mx-0" color="green lighten-5" style="min-height: 65vh">
                        <v-container class="pa-1">
                            <v-card
                                outlined
                                class="py-5 px-8"
                                color="green lighten-5"
                                style="min-height:60vh"
                            >
                                <!-- titulli -->
                                <v-row class="px-2 mb-3">
                                    <div>
                                        <v-icon left>mdi-account-plus</v-icon>
                                        <span class="text-uppercase font-weight-bold">Te dhenat baze</span>
                                    </div>
                                    <div class="flex-grow-1"></div>
                                </v-row>

                                <v-row class="py-0">
                                    <v-col cols="5">
                                        <v-text-field
                                            :error-messages="saving_errors.name"
                                            label="Emri: *"
                                            prepend-icon="mdi-account-card-details-outline"
                                            required
                                            v-model="new_employee.name"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="4">
                                        <v-text-field
                                            :error-messages="saving_errors.personal_id"
                                            hint="Nr. i leternjoftimit"
                                            label="Numri personal: *"
                                            persistent-hint
                                            prepend-icon="mdi-numeric"
                                            v-model="new_employee.personal_id"
                                            :disabled="new_employee.employee_type == 'contractor'"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>

                                <v-row class="py-0">
                                    <v-col cols="12">
                                        <v-text-field
                                            :error-messages="saving_errors.address"
                                            label="Adresa: *"
                                            hint="Vendbanimi (qyteti, fshati ose rruga)"
                                            prepend-icon="mdi-map-marker-outline"
                                            v-model="new_employee.address"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row class="py-0">
                                    <v-col cols="4">
                                        <v-text-field
                                            :error-messages="saving_errors.email"
                                            label="Email adresa: *"
                                            prepend-icon="mdi-email-variant"
                                            required
                                            v-model="new_employee.email"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="4">
                                        <v-text-field
                                            :error-messages="saving_errors.phone"
                                            hint="Nr. i leternjoftimit"
                                            label="Numri i telefonit: *"
                                            persistent-hint
                                            prepend-icon="mdi-cellphone-text"
                                            v-model="new_employee.phone"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>

                                <v-row class="py-0">
                                    <v-col class="text-left" cols="2">
                                        <small>*duhet te plotesohen</small>
                                    </v-col>
                                    <div class="flex-grow-1"></div>
                                </v-row>
                            </v-card>
                        </v-container>
                    </v-row>

                    <v-row class="mx-2 mt-5">
                        <v-col cols="3" class="pt-0">
                            <v-btn color="warning" outlined block small>Anulo</v-btn>
                        </v-col>
                        <div class="flex-grow-1"></div>

                        <v-col cols="3" class="pt-0 pr-5">
                            <v-btn
                                :disabled="!step_1_completed"
                                @click="current_step = 2"
                                color="success"
                                block
                                small
                                outlined
                            >Para</v-btn>
                        </v-col>
                    </v-row>
                </v-stepper-content>
                <v-stepper-content step="2">
                    <v-row class="mx-0" style="min-height: 65vh">
                        <v-container class="pa-1">
                            <v-card
                                outlined
                                class="py-5 px-8"
                                color="orange lighten-5"
                                style="min-height:60vh"
                            >
                                <!-- titulli -->
                                <v-row class="px-2 mb-3">
                                    <div>
                                        <v-icon left>mdi-account-plus</v-icon>
                                        <span
                                            class="text-uppercase font-weight-bold"
                                        >Te dhenat e punes</span>
                                    </div>
                                    <div class="flex-grow-1"></div>
                                </v-row>
                                <!-- body -->
                                <!-- body -->
                                <v-row class="py-0">
                                    <v-col cols="4">
                                        <v-select
                                            :error-messages="saving_errors.employee_type"
                                            hint="I rregullt, part-time"
                                            label="Lloji i puntorit: *"
                                            persistent-hint
                                            prepend-icon="mdi-account-supervisor"
                                            v-model="new_employee.employee_type"
                                            :items="employee_types"
                                            :menu-props="{'offsetY':true}"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="5">
                                        <v-text-field
                                            :error-messages="saving_errors.position"
                                            label="Pozita: *"
                                            prepend-icon="mdi-account-tie"
                                            required
                                            v-model="new_employee.position"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>

                                <v-row class="py-0">
                                    <v-col cols="4">
                                        <v-select
                                            :error-messages="saving_errors.salary_type"
                                            hint="Sh. Pagesa 1 here ne muaj"
                                            label="Lloji i pageses: *"
                                            persistent-hint
                                            prepend-icon="mdi-cash-usd"
                                            v-model="new_employee.personal_id"
                                            :items="salary_types"
                                            :menu-props="{'offsetY':true}"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="3">
                                        <v-text-field
                                            :error-messages="saving_errors.salary_amount"
                                            label="Shuma: "
                                            prepend-icon="mdi-numeric"
                                            v-model="new_employee.salary_amount"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>

                                <v-row class="py-0">
                                    <v-col class="text-left" cols="2">
                                        <small>*duhet te plotesohen</small>
                                    </v-col>
                                    <div class="flex-grow-1"></div>
                                </v-row>
                            </v-card>
                        </v-container>
                    </v-row>

                    <v-row class="mx-2 mt-5">
                        <v-col cols="3" class="pt-0">
                            <v-btn
                                :disabled="false"
                                @click="current_step = 1"
                                block
                                small
                                outlined
                            >Mbrapa</v-btn>
                        </v-col>
                        <div class="flex-grow-1"></div>

                        <v-col cols="3" class="pt-0 pr-5">
                            <v-btn
                                :disabled="false"
                                @click="current_step = 3"
                                color="success"
                                block
                                small
                                outlined
                            >Para</v-btn>
                        </v-col>
                    </v-row>
                </v-stepper-content>
                <v-stepper-content step="3">
                    <v-row class="mx-0" style="min-height: 65vh">
                        <v-container class="pa-1">
                            <v-card
                                outlined
                                class="py-5 px-8"
                                color="red lighten-5"
                                style="min-height:60vh"
                            >
                                <!-- titulli -->
                                <v-row class="px-2 mb-3">
                                    <div>
                                        <v-icon left>mdi-account-plus</v-icon>
                                        <span
                                            class="text-uppercase font-weight-bold red--text"
                                        >Qasja ne aplikacion</span>
                                    </div>
                                    <div class="flex-grow-1"></div>
                                </v-row>
                                <v-row class="py-0">
                                    <v-col cols="4">
                                        <v-text-field
                                            :error-messages="saving_errors.email"
                                            label="Email adresa: *"
                                            prepend-icon="mdi-email-variant"
                                            required
                                            v-model="new_employee.email"
                                            disabled
                                        ></v-text-field>
                                    </v-col>
                                </v-row>

                                <v-row class="py-0">
                                    <v-col cols="4">
                                        <v-select
                                            :error-messages="saving_errors.role"
                                            hint="Sipas llojit, caktohet qasja ne te dhena"
                                            label="Lloji i perdoruesit: *"
                                            persistent-hint
                                            prepend-icon="mdi-shield-account-outline"
                                            v-model="new_employee.role"
                                            :items="roles"
                                            :menu-props="{'offsetY':true}"
                                        ></v-select>
                                    </v-col>
                                </v-row>
                                <v-row class="py-0">
                                    <v-col cols="4">
                                        <v-text-field
                                            :success="new_employee.password!='' && new_employee.password == confirm_password"
                                            :error-messages="saving_errors.password"
                                            label="Fjalkalimi: *"
                                            hint="Te pakten 6 karaktere"
                                            persistent-hint
                                            prepend-icon="mdi-onepassword"
                                            v-model="new_employee.password"
                                            :append-icon="show_password_1 ? 'mdi-eye' : 'mdi-eye-off'"
                                            :type="show_password_1 ? 'text' : 'password'"
                                            counter
                                            @click:append="show_password_1 = !show_password_1"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="4">
                                        <v-text-field
                                            :success="confirm_password!='' && new_employee.password == confirm_password"
                                            :error="confirm_password!='' && new_employee.password != confirm_password"
                                            :error-messages="saving_errors.password"
                                            label="Perserit fjalkallimin: *"
                                            prepend-icon="mdi-onepassword"
                                            v-model="confirm_password"
                                            :append-icon="show_password_2 ? 'mdi-eye' : 'mdi-eye-off'"
                                            :type="show_password_2 ? 'text' : 'password'"
                                            counter
                                            @click:append="show_password_2 = !show_password_2"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>

                                <v-row class="py-0">
                                    <v-col class="text-left" cols="2">
                                        <small>*duhet te plotesohen</small>
                                    </v-col>
                                    <div class="flex-grow-1"></div>
                                </v-row>
                            </v-card>
                        </v-container>
                    </v-row>

                    <v-row class="mx-2 mt-5">
                        <v-col cols="3" class="pt-0">
                            <v-btn
                                :disabled="false"
                                @click="current_step = 2"
                                block
                                small
                                outlined
                            >Mbrapa</v-btn>
                        </v-col>
                        <div class="flex-grow-1"></div>

                        <v-col cols="3" class="pt-0 pr-5">
                            <v-btn
                                :disabled="!step_1_completed"
                                @click="current_step = 4"
                                color="success"
                                block
                                small
                                outlined
                            >Para</v-btn>
                        </v-col>
                    </v-row>
                </v-stepper-content>

                <v-stepper-content step="4">
                    <v-card outlined class="py-5 px-8" color="green lighten-5">
                        <!-- titulli -->
                        <v-row class="px-1">
                            <div>
                                <v-icon left>mdi-account-plus</v-icon>
                                <span class="text-uppercase font-weight-bold">Te dhenat baze</span>
                            </div>
                            <div class="flex-grow-1"></div>

                            <v-btn @click="current_step = 3" color="warning" small text>Ndrysho</v-btn>
                        </v-row>

                        <v-row class="py-0">
                            <v-col class="py-0" cols="5">
                                <v-text-field
                                    label="Emri: *"
                                    prepend-icon="mdi-account-card-details-outline"
                                    disabled
                                    v-model="new_employee.name"
                                ></v-text-field>
                            </v-col>
                            <v-col class="py-0" cols="4">
                                <v-text-field
                                    label="Numri personal: *"
                                    prepend-icon="mdi-numeric"
                                    v-model="new_employee.personal_id"
                                    disabled
                                ></v-text-field>
                            </v-col>
                        </v-row>

                        <v-row class="py-0">
                            <v-col class="py-0" cols="12">
                                <v-text-field
                                    label="Adresa: *"
                                    prepend-icon="mdi-map-marker-outline"
                                    v-model="new_employee.address"
                                    disabled
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row class="py-0">
                            <v-col class="py-0" cols="4">
                                <v-text-field
                                    label="Email adresa: *"
                                    prepend-icon="mdi-email-variant"
                                    v-model="new_employee.email"
                                    disabled
                                ></v-text-field>
                            </v-col>
                            <v-col class="py-0" cols="4">
                                <v-text-field
                                    label="Numri i telefonit: *"
                                    prepend-icon="mdi-cellphone-text"
                                    v-model="new_employee.phone"
                                    disabled
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-card>
                    <v-card outlined class="py-5 mt-3 px-8" color="orange lighten-5">
                        <!-- titulli -->
                        <v-row class="px-2">
                            <div>
                                <v-icon left>mdi-account-plus</v-icon>
                                <span class="text-uppercase font-weight-bold">Te dhenat e punes</span>
                            </div>
                            <div class="flex-grow-1"></div>
                            <v-btn @click="current_step = 2" color="warning" small text>Ndrysho</v-btn>
                        </v-row>
                        <!-- body -->
                        <!-- body -->
                        <v-row class="py-0">
                            <v-col class="py-0" cols="4">
                                <v-select
                                    label="Lloji i puntorit: *"
                                    prepend-icon="mdi-account-supervisor"
                                    v-model="new_employee.employee_type"
                                    :items="employee_types"
                                    disabled
                                ></v-select>
                            </v-col>
                            <v-col class="py-0" cols="5">
                                <v-text-field
                                    label="Pozita: *"
                                    prepend-icon="mdi-account-tie"
                                    v-model="new_employee.position"
                                    disabled
                                ></v-text-field>
                            </v-col>
                        </v-row>

                        <v-row class="py-0">
                            <v-col class="py-0" cols="4">
                                <v-select
                                    label="Lloji i pageses: *"
                                    prepend-icon="mdi-cash-usd"
                                    v-model="new_employee.personal_id"
                                    :items="salary_types"
                                    disabled
                                ></v-select>
                            </v-col>
                            <v-col class="py-0" cols="3">
                                <v-text-field
                                    :error-messages="saving_errors.salary_amount"
                                    label="Shuma: "
                                    prepend-icon="mdi-numeric"
                                    v-model="new_employee.salary_amount"
                                    disabled
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-card>
                    <v-card outlined class="py-5 px-8 mt-3" color="red lighten-5">
                        <!-- titulli -->
                        <v-row class="px-2">
                            <div>
                                <v-icon left>mdi-account-plus</v-icon>
                                <span
                                    class="text-uppercase font-weight-bold red--text"
                                >Qasja ne aplikacion</span>
                            </div>
                            <div class="flex-grow-1"></div>
                            <v-btn @click="current_step = 3" color="warning" small text>Ndrysho</v-btn>
                        </v-row>
                        <v-row class="py-0">
                            <v-col class="py-0" cols="4">
                                <v-text-field
                                    :error-messages="saving_errors.email"
                                    label="Email adresa: *"
                                    prepend-icon="mdi-email-variant"
                                    required
                                    v-model="new_employee.email"
                                    disabled
                                ></v-text-field>
                            </v-col>

                            <v-col class="py-0" cols="4">
                                <v-select
                                    label="Lloji i perdoruesit: *"
                                    prepend-icon="mdi-shield-account-outline"
                                    v-model="new_employee.role"
                                    :items="roles"
                                    disabled
                                ></v-select>
                            </v-col>
                        </v-row>
                        <v-row class="py-0">
                            <v-col class="py-0" cols="4">
                                <v-text-field
                                    label="Fjalkalimi: *"
                                    prepend-icon="mdi-onepassword"
                                    v-model="new_employee.password"
                                    :append-icon="show_password_1 ? 'mdi-eye' : 'mdi-eye-off'"
                                    :type="show_password_1 ? 'text' : 'password'"
                                    @click:append="show_password_1 = !show_password_1"
                                    readonly
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-card>
                    <v-row class="mx-2 mt-5">
                        <v-col cols="3" class="pt-0">
                            <v-btn
                                :disabled="false"
                                @click="current_step = 3"
                                block
                                small
                                outlined
                            >Mbrapa</v-btn>
                        </v-col>
                        <div class="flex-grow-1"></div>

                        <v-col cols="3" class="pt-0 pr-5">
                            <v-btn
                                :disabled="false"
                                @click="current_step = 4"
                                color="success"
                                block
                                small
                                outlined
                            >Para</v-btn>
                        </v-col>
                    </v-row>
                </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";

export default {
    components: {},
    data() {
        return {
            roles: [
                { text: "Administrator", value: "admin" },
                { text: "Puntor", value: "employee" }
            ],
            employee_types: [
                { text: "I rregullt", value: "regular" },
                { text: "Part Time", value: "part_time" }
            ],
            salary_types: [
                { text: "Dite", value: "day" },
                { text: "Jave", value: "week" },
                { text: "Muaj", value: "month" },
                { text: "E pacaktuar", value: "undefined" }
            ],
            current_step: 4,
            new_employee: {
                employee_type: "",
                name: "",
                personal_id: "",
                address: "",
                phone: "",
                position: "",
                salary_type: "",
                salary_amount: "",
                password: ""
            },
            saving_errors: [],
            show_password_1: false,
            show_password_2: false,
            confirm_password: ""
        };
    },
    computed: {
        step_1_completed: function() {
            return;
            new_employee.name != "" &&
                new_employee.personal_id != "" &&
                new_employee.address != "" &&
                new_employee.email != "" &&
                new_employee.phone != "";
        }
    },
    methods: {
        submit_data() {
            alert("submiting data!");
        }
    },
    beforeMount: function() {}
};
</script>