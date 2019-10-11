import Vue from 'vue';
import store from '@/js/config/store';
import VueRouter from 'vue-router';


import Home from '@/js/pages/home_admin';
import ErrorPage from '@/js/pages/error_page';

import Clients from '@/js/pages/client/clients'
import Client from '@/js/pages/client/client'
import NewClient from '@/js/pages/client/new_client'

import Employees from '@/js/pages/employee/employees'
import Employee from '@/js/pages/employee/employee'
import NewEmployee from '@/js/pages/employee/new_employee'

import Offers from '@/js/pages/offer/offers'
import Offer from '@/js/pages/offer/offer'
import NewOffer from '@/js/pages/offer/new_offer'

import Jobs from '@/js/pages/job/job_all'
import Job from '@/js/pages/job/job'
import NewJob from '@/js/pages/job/job_new'

import Events from '@/js/pages/event/event_all'
import Event from '@/js/pages/event/event'
import NewEvent from '@/js/pages/event/event_new'

import Note from '@/js/pages/note/note'
import Notes from '@/js/pages/note/notes'

import File from '@/js/pages/file/file'
import Files from '@/js/pages/file/file_all'

import Payment from '@/js/pages/payment/payment'
import Payments from '@/js/pages/payment/payment_all'
import NewPayment from '@/js/pages/payment/payment_new'

import Inventory from '@/js/pages/inventory/inventory'
import InventoryAll from '@/js/pages/inventory/inventory_all'
import NewInventory from '@/js/pages/inventory/inventory_new'

import Service from '@/js/pages/service/service'
import ServiceAll from '@/js/pages/service/service_all'
import NewService from '@/js/pages/service/service_new'

import Task from '@/js/pages/task/task'
import TaskAll from '@/js/pages/task/task_all'
import NewTask from '@/js/pages/task/task_new'

import Login from '@/js/pages/auth/login'


import AuthLayout from '@/js/layouts/AuthLayout';
import MainLayout from '@/js/layouts/MainLayout';

Vue.use(VueRouter);

// function requireAuth(to, from, next) {
//     if (store.getters.user_type == "admin" || store.getters.user_type == "employee") {
//         next()
//
//     } else {
//         store.dispatch('checkAuth')
//             .then(() => {
//                 next()
//             })
//             .catch(() => {
//                 next({
//                     path: '/login',
//                 })
//             })
//     }
// }
//

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/', component: MainLayout,
            children: [
                {
                    path: '/',
                    name: 'dashboard',
                    component: Home,
                },
            ]
        },
        {
            path: '/client', component: MainLayout,
            children: [
                {
                    path: '/',
                    name: 'client.base',

                    beforeEnter: (to, from, next) => {
                        next('/client/all')
                    }
                }, {
                    path: 'all',
                    name: 'client.all',
                    component: Clients,
                    // beforeEnter: requireAuth
                },
                {
                    path: 'new',
                    name: 'client.new',

                    component: NewClient
                },
                {
                    path: ':id',
                    name: 'client.client',
                    component: Client,

                    props: true
                },
            ]
        },

        {
            path: '/employee', component: MainLayout,
            children: [
                {
                    path: '/',
                    name: 'employee.base',

                    beforeEnter: (to, from, next) => {
                        next('/employee/all')
                    }
                }, {
                    path: 'all',
                    name: 'employee.all',
                    component: Employees,
                    // beforeEnter: requireAuth
                },
                {
                    path: 'new',
                    name: 'employee.new',

                    component: NewEmployee
                },
                {
                    path: ':id',
                    name: 'employee.employee',
                    component: Employee,

                    props: true
                },
            ]
        },

        {
            path: '/offer', component: MainLayout,
            children: [
                {
                    path: '/',
                    name: 'offer.base',

                    beforeEnter: (to, from, next) => {
                        next('/offer/all')
                    }
                }, {
                    path: 'all',
                    name: 'offer.all',
                    component: Offers,
                    // beforeEnter: requireAuth
                },
                {
                    path: 'new',
                    name: 'offer.new',

                    component: NewOffer
                },
                {
                    path: ':id',
                    name: 'offer.offer',
                    component: Offer,

                    props: true
                },
            ]
        },


        {
            path: '/job', component: MainLayout,
            children: [
                {
                    path: '/',
                    name: 'job.base',

                    beforeEnter: (to, from, next) => {
                        next('/job/all')
                    }
                }, {
                    path: 'all',
                    name: 'job.all',
                    component: Jobs,
                    // beforeEnter: requireAuth
                },
                {
                    path: 'new',
                    name: 'job.new',

                    component: NewJob
                },
                {
                    path: ':id',
                    name: 'job.job',
                    component: Job,

                    props: true
                },
            ]
        },
        {
            path: '/event', component: MainLayout,
            children: [
                {
                    path: '/',
                    name: 'event.base',

                    beforeEnter: (to, from, next) => {
                        next('/event/all')
                    }
                }, {
                    path: 'all',
                    name: 'event.all',
                    component: Events,
                    // beforeEnter: requireAuth
                },
                {
                    path: 'new',
                    name: 'event.new',

                    component: NewEvent
                },
                {
                    path: ':id',
                    name: 'event.event',
                    component: Event,

                    props: true
                },
            ]
        },
        {
            path: '/note', component: MainLayout,
            children: [
                {
                    path: '/',
                    name: 'note.base',

                    beforeEnter: (to, from, next) => {
                        next('/note/all')
                    }
                }, {
                    path: 'all',
                    name: 'note.all',
                    component: Notes,
                    // beforeEnter: requireAuth
                },
                {
                    path: ':id',
                    name: 'note.note',
                    component: Note,

                    props: true
                },
            ]
        },
        {
            path: '/inventory', component: MainLayout,
            children: [
                {
                    path: '/',
                    name: 'inventory.base',

                    beforeEnter: (to, from, next) => {
                        next('/inventory/all')
                    }
                }, {
                    path: 'all',
                    name: 'inventory.all',
                    component: InventoryAll,
                    // beforeEnter: requireAuth
                },
                {
                    path: 'new',
                    name: 'inventory.new',

                    component: NewInventory
                },
                {
                    path: ':id',
                    name: 'inventory.inventory',
                    component: Inventory,

                    props: true
                },
            ]
        },
        {
            path: '/payment', component: MainLayout,
            children: [
                {
                    path: '/',
                    name: 'payment.base',

                    beforeEnter: (to, from, next) => {
                        next('/payment/all')
                    }
                }, {
                    path: 'all',
                    name: 'payment.all',
                    component: Payments,
                    // beforeEnter: requireAuth
                },
                {
                    path: 'new',
                    name: 'payment.new',

                    component: NewPayment
                },
                {
                    path: ':id',
                    name: 'payment.payment',
                    component: Payment,

                    props: true
                },
            ]
        },

        {
            path: '/file', component: MainLayout,
            children: [
                {
                    path: '/',
                    name: 'file.base',

                    beforeEnter: (to, from, next) => {
                        next('/file/all')
                    }
                }, {
                    path: 'all',
                    name: 'file.all',
                    component: Files,
                    // beforeEnter: requireAuth
                },
                {
                    path: ':id',
                    name: 'file.file',
                    component: File,

                    props: true
                },
            ]
        },

        {
            path: '/service', component: MainLayout,
            children: [
                {
                    path: '/',
                    name: 'service.base',

                    beforeEnter: (to, from, next) => {
                        next('/service/all')
                    }
                }, {
                    path: 'all',
                    name: 'service.all',
                    component: ServiceAll,
                    // beforeEnter: requireAuth
                },
                {
                    path: 'new',
                    name: 'service.new',

                    component: NewService
                },
                {
                    path: ':id',
                    name: 'service.service',
                    component: Service,

                    props: true
                },
            ]
        },
        {
            path: '/task', component: MainLayout,
            children: [
                {
                    path: '/',
                    name: 'task.base',

                    beforeEnter: (to, from, next) => {
                        next('/task/all')
                    }
                }, {
                    path: 'all',
                    name: 'task.all',
                    component: TaskAll,
                    // beforeEnter: requireAuth
                },
                {
                    path: 'new',
                    name: 'task.new',

                    component: NewTask
                },
                {
                    path: ':id',
                    name: 'task.task',
                    component: Task,

                    props: true
                },
            ]
        },



        {
            path: '/auth', component: AuthLayout,
            children: [
                { path: '/login', name: 'auth.login', component: Login },
            ]
        },
        {
            path: '/*',
            name: 'main.error',
            component: ErrorPage
        }


    ],
    //https://reactgo.com/scroll-to-anchor-tags-vue-router/
    scrollBehavior: function (to) {
        if (to.hash) {
            return {
                selector: to.hash
            }
        }
    },

});
router.afterEach((to,from,next) => {
    if(to.path != '/login'){
    localStorage.setItem('LS_ROUTE_KEY', to.path);
    localStorage.setItem('LS_LAST_ACTIVITY_AT_KEY', Date.now());
    }
  });

router.beforeEach((to, from, next) => {

    if (to.path == '/login') {

        next()
    }
    else {
        // if (store.getters.user_type == 'employee' || store.getters.user_type == 'admin') {
        //     next();
        // }
        // else {
            store.dispatch('checkAuth')
                .then(() => {
                    // console.log(store.getters.router_copy);
                    // console.error(history.go)

                    next()
         
                })
                .catch(() => {

                    next({
                        path: '/login',

                    })
                })
        // }
    }

    // console.log(to.path)
    // console.log(from)
    // console.log(next)
});



export default router;