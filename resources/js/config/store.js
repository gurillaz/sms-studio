import Vue from 'vue'
import Vuex from 'vuex'
import axios from '@/js/config/axios'

Vue.use(Vuex);


// Import the `getField` getter and the `updateField`
// mutation function from the `vuex-map-fields` module.
//https://github.com/maoberlehner/vuex-map-fields
import { getField, updateField } from 'vuex-map-fields';


export default new Vuex.Store({
    state: {
        status: '',
        user_type: 'guest',
        user: {},
        snackbar: {
            show: false,
            color: '',
            timeout: 4000,
            mode: 'multi-line',
            text: '',

        },


        // form_new_job_data: {
        //
        //
        //
        //     selected_offer_id: null,
        //     selected_client_id: null,
        //     current_step: 3,
        //     select_client_tab: 0,
        //     offers: [],
        //     clients: [],
        //     events: [],
        // job: {
        //     id:'',
        //     name: '',
        //     description: '',
        //     price: '',
        //     payment_status: '',
        //     client_id: '',
        //     offer_id: '',
        // },
        //
        //
        //
        //
        // },
        form_new_job_data: {
    
            selected_offer_id: '',
            selected_client_id: '',
            selected_offer_name: '',
            selected_client_name: '',
            current_step: 1,
            select_client_tab: 0,
            job_saved: false,

            created_job: {
                id:'',
                name: '',
                description: '',
                price: '',
                payment_status: '',
                client_id: '',
                offer_id: '',
            },
            offers: [],
            clients:[],
            events: [],
            payments: []
        },
    },
    mutations: {
        updateField,
        auth_request(state) {
            state.status = 'loading'
        },
        auth_success(state, user) {
            state.status = 'success'
            state.user = user
            state.user_type = user.role
        },
        auth_error(state) {
            state.status = 'error'

        },
        logout(state) {
            state.status = ''
            state.user = {}
            state.user_type = 'guest'
        },
        set_snackbar(state, snackbar) {

            state.snackbar.show = true;
            state.snackbar.color = snackbar.color || 'primary';
            state.snackbar.timeout = snackbar.timeout || 4000;
            state.snackbar.mode = snackbar.vertical || 'multi-line';
            state.snackbar.text = snackbar.text || '';

        },
        reset_snackbar(state) {
            // state.snackbar.value = 'hidden';
            state.snackbar.show = false;
            state.snackbar.color = '';
            state.snackbar.timeout = 4000;
            state.snackbar.mode = 'multi-line';
            state.snackbar.text = '';

        },
    },
    actions: {
        login({ commit }, data) {
            return new Promise((resolve, reject) => {
                commit('auth_request')
                if (this.state.status == 'admin' || this.state.status == 'employee') {
                    resolve({ data: 'Already logged in!' })
                } else {

                    axios.post("/loginAPI", {

                        email: data.email,
                        password: data.password,

                    }).then(function (resp) {

                        const user = resp.data.user
                        // console.log(user)
                        commit('auth_success', user)
                        resolve(resp)

                    }).catch(function (resp) {
                        commit('auth_error')
                        reject(resp)
                    });
                }

            })
        },

        checkAuth({ commit }) {
            return new Promise((resolve, reject) => {
                commit('auth_request');
                axios.post("/checkAuth")
                    .then(function (resp) {
                        const user = resp.data.user;
                        // console.log(resp.data)
                        commit('auth_success', user);
                        resolve(resp)


                    }).catch(function (resp) {
                        // console.log(resp.data)
                        commit('auth_error');
                        reject(resp)

                    });
            })
        },
        //         register({commit}, user) {
        //             return new Promise((resolve, reject) => {
        //                 commit('auth_request')
        //                 axios({url: 'http://localhost:3000/register', data: user, method: 'POST'})
        //                     .then(resp => {
        //                         const token = resp.data.token
        //                         const user = resp.data.user
        //                         localStorage.setItem('token', token)
        // // Add the following line:
        //                         axios.defaults.headers.common['Authorization'] = token
        //                         commit('auth_success', token, user)
        //                         resolve(resp)
        //                     })
        //                     .catch(err => {
        //                         commit('auth_error', err)
        //                         localStorage.removeItem('token')
        //                         reject(err)
        //                     })
        //             })
        //         },
        logout({ commit }) {

            commit('logout')

        },
        async showSnackbar({ commit }, snackbar) {

            await commit('reset_snackbar');
            commit('set_snackbar', snackbar);
        }
    },
    getters: {
        getField,
        isLoggedIn: state => state.status === "success",
        authStatus: state => state.status,
        user: state => state.user,
        user_type: state => state.user_type,
        snackbar: state => state.snackbar,
    }
})