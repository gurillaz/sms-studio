<template>
    <div class="mx-3">
        <v-row>
            <v-col cols="12">
                <v-card outlined class="py-5 px-8" color="green lighten-5">
                    <v-row>
                        <!-- <div class="flex-grow-1"></div> -->
                        <v-col cols="4">
                        <v-sheet color="grey lighten-5" class="d-flex align-center justify-center" style="height:45vh">
                            <v-icon x-large >mdi-image</v-icon>
                        </v-sheet>


                        </v-col>
                        <v-col cols="8">
                            <!-- titulli -->
                            <v-row class="px-1">
                                <div>
                                    <v-icon left>mdi-account-plus</v-icon>
                                    <span class="text-uppercase font-weight-bold">Te dhenat baze</span>
                                </div>
                                <div class="flex-grow-1"></div>
                            </v-row>

                            <v-row class="py-0">
                                <v-col class="py-0" cols="6">
                                    <v-text-field
                                        label="Emri:"
                                        readonly
                                        v-model="employee.name"
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-0" cols="6">
                                    <v-text-field
                                        label="Numri personal:"
                                        v-model="employee.personal_id"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col class="py-0" cols="12">
                                    <v-text-field
                                        label="Adresa:"
                                        v-model="employee.address"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row class="py-0">
                                <v-col class="py-0" cols="6">
                                    <v-text-field
                                        label="Email adresa:"
                                        v-model="employee.email"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-0" cols="6">
                                    <v-text-field
                                        label="Numri i telefonit:"
                                        v-model="employee.phone"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <!-- titulli -->
                            <v-row class="px-2">
                                <div>
                                    <v-icon left>mdi-account-plus</v-icon>
                                    <span class="text-uppercase font-weight-bold">Te dhenat e punes</span>
                                </div>
                                <div class="flex-grow-1"></div>
                            </v-row>
                            <!-- body -->
                            <!-- body -->
                            <v-row class="py-0">
                                <v-col class="py-0" cols="4">
                                    <v-select
                                        label="Lloji i puntorit:"
                                        v-model="employee.employee_type"
                                        :items="employee_types"
                                        readonly
                                    ></v-select>
                                </v-col>
                                <v-col class="py-0" cols="4">
                                    <v-text-field
                                        label="Pozita:"
                                        v-model="employee.position"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col class="py-0" cols="4">
                                    <v-select
                                        label="Lloji i perdoruesit:"
                                        v-model="employee.role"
                                        :items="roles"
                                        readonly
                                    ></v-select>
                                </v-col>
                            </v-row>

                            <v-row class="py-0">
                                <v-col class="py-0" cols="4">
                                    <v-select
                                        label="Lloji i pageses:"
                                        v-model="employee.salary_type"
                                        :items="salary_types"
                                        readonly
                                    ></v-select>
                                </v-col>
                                <v-col class="py-0" cols="3">
                                    <v-text-field
                                        label="Shuma: "
                                        v-model="employee.salary_amount"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
        

        <notesSection :notes="notes" :id="id" :class_name="class_name"></notesSection>
        <filesSection :files="files" :id="id" :class_name="class_name"></filesSection>
        <paymentsSection :payments="payments" :id="id" :class_name="class_name"></paymentsSection>

        <v-row>
            <!--            {{files}}-->
            <!--            <noteCard v-for="note in notes" v-bind:key="note.id" :note="note"></noteCard>-->
        </v-row>
    </div>
</template>

<script>
import axios from "@/js/config/axios.js";
import notesSection from "@/js/pages/note/notes_section";
import filesSection from "@/js/pages/file/files_section";
import paymentsSection from "@/js/pages/payment/payments_section";

export default {
    components: { notesSection, filesSection, paymentsSection },
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
            id: this.$route.params.id,
            class_name: "",
            employee: {},
            files: {},
            notes: {},
            payments: {}
        };
    },
    beforeMount() {
        var currentObj = this;
        axios
            .get(`/employee/${currentObj.id}`)
            .then(function(resp) {
                currentObj.employee = resp.data.employee;
                currentObj.files = resp.data.files;
                currentObj.payments = resp.data.payments;
                currentObj.notes = resp.data.notes;
                currentObj.class_name = resp.data.class_name;
            })
            .catch(function(resp) {
                console.log(resp);
                alert("Could not load Employee");
            });
    },
    methods: {
        deleteEmployee() {
            let currentObj = this;
            if (confirm("Konfirmo fshirjen e e puntorit!") === false) {
                return;
            }
            axios(`/note/${currentObj.id}`, {
                method: "delete"
            })
                .then(function(resp) {
                    currentObj.$route.go("/employee");
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "success",
                        text: "Puntori u fshi!"
                    });
                })
                .catch(function(resp) {
                    currentObj.$store.dispatch("showSnackbar", {
                        color: "error",
                        text: "Puntori nuk u fshi, rifresko faqen!"
                    });
                });
        }
    }
};
</script>