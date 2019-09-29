import axios from 'axios'
import app from '@/js/app.js'


let token = document.head.querySelector('meta[name="csrf-token"]');

const instance = axios.create({
    baseURL: '/api/',
    headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': token.content
    }
})

// Add a response interceptor
instance.interceptors.response.use(
    response => {
        // console.log(response);
        return response;
    },
    error => {

        if (error.response.status === 401) {
            // alert('You need to login! 401 Error')
            app.$router.push('/login');

        }

        return Promise.reject(error);
    });

export default instance