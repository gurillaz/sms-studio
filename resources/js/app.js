/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */



import Vue from 'vue';


import router from '@/js/config/routes.js';
import store from '@/js/config/store.js';

import App from '@/js/layouts/App';
import vuetify from '@/js/config/vuetify';


Vue.config.productionTip = false;

;

const app = new Vue({
    store,

    // created(){
    //    store.dispatch('checkAuth')
    // },
    vuetify,
    router,
    render: h => h(App)
}).$mount('#app')



export default app;
