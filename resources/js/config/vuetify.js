import Vue from "vue"
import Vuetify from "vuetify"

Vue.use(Vuetify);

export default new Vuetify({

    theme: {
        dark: false,
    },
    themes: {
        light: {
            primary: "#00FE14",
            secondary: "#b0bec5",
            accent: "#8c9eff",
            error: "#b71c1c",

        },
    },
    // icons: {
    //     iconfont: 'mdiSvg'
    //         //'mdiSvg', // 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4'
    // },
})