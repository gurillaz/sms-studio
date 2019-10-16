<template>
    <div class="mx-4 pt-0 mt-0">
    <!--    <v-row class="mt-0 pt-0">
            <v-col cols="3" class="pt-0">
                <v-card >
                    <v-sheet color="red" height="5" tile></v-sheet>
                    <v-container row class="py-0">
                    <v-col cols="3" class="pt-5">
                        <v-icon x-large right color="red">mdi-account</v-icon>
                    </v-col>
                    <v-col cols="8" class="text-center py-2">
                        <div class="red--text py-0">
                            <span class="display-1 font-weight-bold heading">7</span><br>
                            <span class="caption font-weight-bold text-uppercase ml-2"> evente gjithsej</span>
                        </div>
                    </v-col>
                    </v-container>
                </v-card>
            </v-col>
            <v-col cols="3" class="pt-0">
                <v-card >
                    <v-sheet color="purple" height="5" tile></v-sheet>
                    <v-container row class="py-0">
                    <v-col cols="3" class="pt-5">
                        <v-icon x-large right color="purple">mdi-account</v-icon>
                    </v-col>
                    <v-col cols="8" class="text-center py-2">
                        <div class="purple--text py-0">
                            <span class="display-1 font-weight-bold heading">7</span><br>
                            <span class="caption font-weight-bold text-uppercase ml-2"> evente gjithsej</span>
                        </div>
                    </v-col>
                    </v-container>
                </v-card>
            </v-col>
            <v-col cols="3" class="pt-0">
                <v-card >
                    <v-sheet color="green" height="5" tile></v-sheet>
                    <v-container row class="py-0">
                    <v-col cols="3" class="pt-5">
                        <v-icon x-large right color="green">mdi-account</v-icon>
                    </v-col>
                    <v-col cols="8" class="text-center py-2">
                        <div class="green--text py-0">
                            <span class="display-1 font-weight-bold heading">7</span><br>
                            <span class="caption font-weight-bold text-uppercase ml-2"> evente gjithsej</span>
                        </div>
                    </v-col>
                    </v-container>
                </v-card>
            </v-col>
            <v-col cols="3" class="pt-0">
                <v-card >
                    <v-sheet color="blue" height="5" tile></v-sheet>
                    <v-container row class="py-0">
                    <v-col cols="3" class="pt-5">
                        <v-icon x-large right color="blue">mdi-account</v-icon>
                    </v-col>
                    <v-col cols="8" class="text-center py-2">
                        <div class="blue--text py-0">
                            <span class="display-1 font-weight-bold heading">7</span><br>
                            <span class="caption font-weight-bold text-uppercase ml-2"> evente gjithsej</span>
                        </div>
                    </v-col>
                    </v-container>
                </v-card>
            </v-col>

        </v-row>
        -->
        <v-row>
            <v-col cols="12">
                <v-card class="">
                    <v-col>
                        <v-sheet>
                            <v-toolbar flat color="white">
                                <v-btn outlined class="mr-10" @click="setToday">Sot</v-btn>

                                <v-toolbar-title>Eventet ne: {{ title }}</v-toolbar-title>
                                <div class="flex-grow-1"></div>
                                <v-btn fab text small @click="prev">
                                    <v-icon>mdi-chevron-left</v-icon>
                                </v-btn>
                                <v-btn fab text small class="mr-5" @click="next">
                                    <v-icon>mdi-chevron-right</v-icon>
                                </v-btn>
                                <v-menu bottom right>
                                    <template v-slot:activator="{ on }">
                                        <v-btn outlined v-on="on">
                                            <span>{{ typeToLabel[type] }}</span>
                                            <v-icon right>mdi-menu-down</v-icon>
                                        </v-btn>
                                    </template>
                                    <v-list>
                                        <v-list-item @click="type = 'day'">
                                            <v-list-item-title>Dita</v-list-item-title>
                                        </v-list-item>
                                        <v-list-item @click="type = 'week'">
                                            <v-list-item-title>Java</v-list-item-title>
                                        </v-list-item>
                                        <v-list-item @click="type = 'month'">
                                            <v-list-item-title>Muaji</v-list-item-title>
                                        </v-list-item>
                                        <v-list-item @click="type = '4day'">
                                            <v-list-item-title>4 Dite</v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                            </v-toolbar>
                        </v-sheet>
                        <v-card outlined tile height="68vh" class="mx-4 mb-4">
                            <v-calendar
                                ref="calendar"
                                v-model="focus"
                                color="primary"
                                :events="events"
                                :now="today"
                                :type="type"
                                :weekdays="weekdays"
                                :weekday-format="weekdayFormat"
                                :month-format="monthFormat"
                                :interval-format="intervalFormat"
                                :event-name="eventName"
                                event-start="date_start"
                                event-end="date_end"
                                :event-color="getEventColor"
                                :event-height="30"
                                @click:event="showEvent"
                                @click:more="viewDay"
                                @click:date="viewDay"
                                @change="updateRange"
                            ></v-calendar>

                            <v-menu
                                v-model="selectedOpen"
                                :close-on-content-click="false"
                                :activator="selectedElement"
                                offset-x
                            >
                                <v-card color="grey lighten-4" min-width="350px" flat>
                                    <v-toolbar :color="selectedEvent.color" dark>
                                        <v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title>
                                        <div class="flex-grow-1"></div>
                                    </v-toolbar>
                                    <v-card-text>
                                        <span v-html="selectedEvent.address"></span>
                                        <br />
                                        <span v-html="selectedEvent.description"></span>
                                    </v-card-text>
                                    <v-card-actions>
                                        <div class="flex-grow-1"></div>

                                        <v-btn
                                            text
                                            color="secondary"
                                            @click="selectedOpen = false"
                                        >Laro</v-btn>
                                        <v-btn
                                            text
                                            color="primary"
                                            :to="`/event/${selectedEvent.id}`"
                                        >Detajet</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-menu>
                        </v-card>
                    </v-col>
                </v-card>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12"></v-col>
        </v-row>
    </div>
</template>

<script>
import axios from "@/js/config/axios";
import moment from "moment";
import { constants } from "crypto";
import colors from "vuetify/lib/util/colors";

export default {
    data: () => ({
        today: new Date().toISOString().substr(0, 10),
        focus: new Date().toISOString().substr(0, 10),
        weekdays: [1, 2, 3, 4, 5, 6, 0],

        type: "month",
        typeToLabel: {
            month: "Muaji",
            week: "Java",
            day: "Dita",
            "4day": "4 Dite"
        },
        start: null,
        end: null,
        selectedEvent: {},
        selectedElement: null,
        selectedOpen: false,
        events: []
    }),
    computed: {
        // convert the list of events into a map of lists keyed by date
        eventName() {
            return function(event) {
                console.log(event);
                return `<span class="font-weight-bold">${event.start.time}</span> ${event.input.name}`;
            };
        },
        intervalFormat() {
            return function(interval) {
                // console.log(interval);
                return interval.time;
            };
        },
        monthFormat() {
            return function(date) {
                moment.locale("sq");

                return moment.months(date.month - 1);
            };
        },
        weekdayFormat() {
            return function(date) {
                moment.locale("sq");

                return moment.weekdays(date.weekday);
            };
        },
        title() {
            moment.locale("sq");
            const { start, end } = this;
            if (!start || !end) {
                return "";
            }

            const startMonth = moment.months(start.month - 1);
            const endMonth = moment.months(end.month - 1);

            const startYear = start.year;
            const endYear = end.year;

            const startDay = start.day;
            const endDay = end.day;

            switch (this.type) {
                case "month":
                    return `${startMonth} ${startYear}`;
                case "week":
                case "4day":
                    if (startMonth == endMonth) {
                        return `${startDay} - ${endDay} ${startMonth}  ${startYear}`;
                    }
                    if (startMonth !== endMonth && startYear === endYear) {
                        return `${startDay} ${startMonth} - ${endDay} ${endMonth} ${startYear}`;
                    }
                    if (startYear !== endYear) {
                        return `${startDay} ${startMonth} ${startYear} - ${endDay} ${endMonth} ${endYear}`;
                    }

                    return "";

                case "day":
                    return ` ${startDay} ${startMonth} ${startYear}`;
            }
            return "";
        },
        monthFormatter() {
            return this.$refs.calendar.getFormatter({
                timeZone: "UTC",
                month: "long"
            });
        }
    },
    mounted() {
        this.$refs.calendar.checkChange();
        // this.$refs.calendar.set();
    },
    beforeMount() {
        let currentObj = this;
        axios
            .get("/event")
            .then(function(resp) {
                // console.log(resp.data);
                let evn = resp.data.resources;

                evn.forEach(ev => {
                    return (ev["color"] = currentObj.randomColor());
                });
                currentObj.events = evn;
                // console.table(currentObj.events);
            })
            .catch(function(resp) {
                console.log(resp.data);
                alert("Could not load Events");
            });
    },
    methods: {
        randomColor: function() {
            let keys = Object.keys(colors);
            return colors[keys[(keys.length * Math.random()) << 0]].darken2;
        },
        viewDay({ date }) {
            this.focus = date;
            this.type = "day";
        },

        getEventColor(event) {
            return event.color;
        },
        setToday() {
            this.focus = this.today;
        },
        prev() {
            this.$refs.calendar.prev();
        },
        next() {
            this.$refs.calendar.next();
        },
        showEvent({ nativeEvent, event }) {
            const open = () => {
                this.selectedEvent = event;
                this.selectedElement = nativeEvent.target;
                setTimeout(() => (this.selectedOpen = true), 10);
            };

            if (this.selectedOpen) {
                this.selectedOpen = false;
                setTimeout(open, 10);
            } else {
                open();
            }

            nativeEvent.stopPropagation();
        },
        updateRange({ start, end }) {
            this.start = start;
            this.end = end;
        }
    }
};
</script>