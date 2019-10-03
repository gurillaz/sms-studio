<template>
    <div class="mx-3">
        <v-card>
            <v-card-title>
                <v-icon left>mdi-account-plus</v-icon>Shto puntor te ri
                <div class="flex-grow-1"></div>
            </v-card-title>
            <v-container>
                <v-row class="mx-5">
                    <v-container class="pa-1">
                        <v-card outlined tile class="py-5 px-8">
                            <!-- titulli -->
                                    <span class="text-uppercase">Te dhenat baze</span>

                            <v-row class="py-0">
                                <v-col class="py-1" cols="5">
                                    <v-text-field
                                        :error-messages="saving_errors.name"
                                        label="Emri: *"
                                        required
                                        v-model="new_employee.name"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-1" cols="4">
                                    <v-text-field
                                        :error-messages="saving_errors.personal_id"
                                        hint="Nr. i leternjoftimit"
                                        label="Numri personal: *"
                                        persistent-hint
                                        v-model="new_employee.personal_id"
                                        :disabled="new_employee.employee_type == 'contractor'"
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col class="py-1" cols="12">
                                    <v-text-field
                                        :error-messages="saving_errors.address"
                                        label="Adresa: *"
                                        hint="Vendbanimi (qyteti, fshati ose rruga)"
                                        v-model="new_employee.address"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col class="py-1" cols="4">
                                    <v-text-field
                                        :error-messages="saving_errors.email"
                                        label="Email adresa: *"
                                        required
                                        v-model="new_employee.email"
                                        name="new_employe_email"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-1" cols="4">
                                    <v-text-field
                                        :error-messages="saving_errors.phone"
                                        hint="Nr. i leternjoftimit"
                                        label="Numri i telefonit: *"
                                        persistent-hint
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

                <v-row class="mx-5 mt-4">
                    <v-container class="pa-1">
                        <v-card outlined tile class="py-5 px-8">
                            <!-- titulli -->
                            <v-row class="px-2 mb-3">
                           <span class="text-uppercase">Te dhenat e punes</span>
                                <div class="flex-grow-1"></div>
                            </v-row>
                            <!-- body -->
                            <!-- body -->
                            <v-row class="py-0">
                                <v-col class="py-1" cols="4">
                                    <v-select
                                        :error-messages="saving_errors.employee_type"
                                        hint="I rregullt, part-time"
                                        label="Lloji i puntorit: *"
                                        persistent-hint
                                        v-model="new_employee.employee_type"
                                        :items="employee_types"
                                        :menu-props="{'offsetY':true}"
                                    ></v-select>
                                </v-col>
                                <v-col class="py-1" cols="5">
                                    <v-text-field
                                        :error-messages="saving_errors.position"
                                        label="Pozita: *"
                                        required
                                        v-model="new_employee.position"
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col class="py-1" cols="4">
                                    <v-select
                                        :error-messages="saving_errors.salary_type"
                                        hint="Sh. Pagesa 1 here ne muaj"
                                        label="Lloji i pageses: *"
                                        persistent-hint
                                        v-model="new_employee.salary_type"
                                        :items="salary_types"
                                        :menu-props="{'offsetY':true}"
                                    ></v-select>
                                </v-col>
                                <v-col class="py-1" cols="3">
                                    <v-text-field
                                        :error-messages="saving_errors.salary_amount"
                                        label="Shuma: "
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

                <v-row class="mx-5 mt-4">
                    <v-container class="pa-1">
                        <v-card outlined tile class="py-5 px-8">
                            <!-- titulli -->
                            <v-row class="px-2 mb-3">
                                <div>
                                    <span
                                        class="text-uppercase font-weight-bold"
                                    >Qasja ne aplikacion</span>
                                </div>
                                <div class="flex-grow-1"></div>
                            </v-row>
                            <v-row>
                                <v-col cols="4">
                                    <v-text-field
                                        :error-messages="saving_errors.email"
                                        label="Email adresa: *"
                                        required
                                        v-model="new_employee.email"
                                        disabled
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="4">
                                    <v-select
                                        :error-messages="saving_errors.role"
                                        hint="Sipas llojit, caktohet qasja ne te dhena"
                                        label="Lloji i perdoruesit: *"
                                        persistent-hint
                                        v-model="new_employee.role"
                                        :items="roles"
                                        :menu-props="{'offsetY':true}"
                                    ></v-select>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="4">
                                    <v-text-field
                                        :success="new_employee.password!='' && new_employee.password == confirm_password"
                                        :error-messages="saving_errors.password"
                                        label="Fjalkalimi: *"
                                        hint="Te pakten 6 karaktere"
                                        persistent-hint
                                        v-model="new_employee.password"
                                        :append-icon="show_password_1 ? 'mdi-eye' : 'mdi-eye-off'"
                                        :type="show_password_1 ? 'text' : 'password'"
                                        counter
                                        @click:append="show_password_1 = !show_password_1"
                                        name="new_employe_psw"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="4">
                                    <v-text-field
                                        :success="confirm_password!='' && new_employee.password == confirm_password"
                                        :error="confirm_password!='' && new_employee.password != confirm_password"
                                        :error-messages="new_employee.password != confirm_password ? 'Fjalkalimi nuk perputhet': ''"
                                        label="Perserit fjalkallimin: *"
                                        v-model="confirm_password"
                                        :append-icon="show_password_2 ? 'mdi-eye' : 'mdi-eye-off'"
                                        :type="show_password_2 ? 'text' : 'password'"
                                        counter
                                        @click:append="show_password_2 = !show_password_2"
                                        name="new_employe_psw"
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
                <v-row class="mx-1 mt-5">
                    <div class="flex-grow-1"></div>

                    <v-col cols="3" class="pt-0 pr-5">
                        <v-btn
                            :disabled="false"
                            @click="submit_data"
                            color="success"
                            block
                            outlined
                        >Ruaj te dhenat</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
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
                { text: "Ore", value: "hour" },
                { text: "Dite", value: "day" },
                { text: "Jave", value: "week" },
                { text: "Muaj", value: "month" },
                { text: "E pacaktuar", value: "undefined" }
            ],

            new_employee: {
                name: "",
                personal_id: "",
                address: "",
                email: "",
                phone: "",
                employee_type: "",
                position: "",
                salary_type: "",
                salary_amount: "",
                role: "",
                password: ""
            },
            saving_errors: [],
            show_password_1: false,
            show_password_2: false,
            confirm_password: ""
        };
    },
    computed: {},
    methods: {
        submit_data: function() {
            let currentObj = this;

            axios
                .post(`/employee`, currentObj.new_employee)
                .then(function(resp) {
                    currentObj.saving_errors = false;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Klienti u krijua!"
                    });
                    currentObj.$router.push(
                        `/employee/${resp.data.new_employee_id}`
                    );
                })
                .catch(function(resp) {
                    console.log(resp.data);

                    currentObj.saving_errors = resp.response.data.errors;
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Te dhenat nuk u ruajten"
                    });
                });
        }
    },
    beforeMount: function() {}
};
</script>
