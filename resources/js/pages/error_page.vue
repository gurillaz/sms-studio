<template>
    <v-app>
        <v-container fluid fill-height blue>
            <v-row>
                <div class="flex-grow-1"></div>

                <v-col cols="10">
                    <p style="font-size:150px; color:white">
                        (
                        <span class="logo">.</span>_.)
                    </p>
                    <h1 class="white--text">Gabim!</h1>
                    <h4 class="white--text">URL nuk egziston.</h4>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>
<style lang="css" scoped>
.logo {
    -webkit-animation: flicker 2s infinite;
}

@-webkit-keyframes flicker {
    0% {
        opacity: 0;
    }
    9% {
        opacity: 0;
    }
    10% {
        opacity: 0.5;
    }
    13% {
        opacity: 0;
    }
    20% {
        opacity: 0.5;
    }
    25% {
        opacity: 1;
    }
}
</style>
