/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// J-Query Easing/Animations

import $ from 'jquery';

window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/datepicker.js';


window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});


(function ($) {
    "use strict"; // Start of use strict

    // Toggle the side navigation
    $("#sidebarToggle, #sidebarToggleTop").on('click', function (e) {
        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");
        if ($(".sidebar").hasClass("toggled")) {
            $('.sidebar .collapse').collapse('hide');
        }
        ;
    });

    // Close any open menu accordions when window is resized below 768px
    $(window).resize(function () {
        if ($(window).width() < 768) {
            $('.sidebar .collapse').collapse('hide');
        }
        ;
    });

    // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
    $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function (e) {
        if ($(window).width() > 768) {
            var e0 = e.originalEvent,
                delta = e0.wheelDelta || -e0.detail;
            this.scrollTop += (delta < 0 ? 1 : -1) * 30;
            e.preventDefault();
        }
    });

    // Scroll to top button appear
    $(document).on('scroll', function () {
        var scrollDistance = $(this).scrollTop();
        if (scrollDistance > 100) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    });

    // Smooth scrolling using jQuery easing
    $(document).on('click', 'a.scroll-to-top', function (e) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top)
        }, 1000, 'easeInOutExpo');
        e.preventDefault();
    });

})(jQuery); // End of use strict


$(document).ready(function () {
    window.clientsTable = $('#clientsTable').DataTable({
        "language": {
            "lengthMenu": "Shfaq _MENU_ rekorde per faqe",
            "zeroRecords": "Nuk u gjet azgje!",
            "info": "Faqja _PAGE_ nga _PAGES_",
            "infoEmpty": "Nuk ka te dhena!",
            "infoFiltered": "(Filtruar  nga _MAX_ gjithsej te dhena)"
            }
        });
    window.deleted_clientsTable = $('#deleted_clientsTable').DataTable({
        "language": {
            "lengthMenu": "Shfaq _MENU_ rekorde per faqe",
            "zeroRecords": "Nuk u gjet azgje!",
            "info": "Faqja _PAGE_ nga _PAGES_",
            "infoEmpty": "Nuk ka te dhena!",
            "infoFiltered": "(Filtruar  nga _MAX_ gjithsej te dhena)"
        }
    });
    window.client_events_table = $('#client_events_table').DataTable({
        "language": {
            "lengthMenu": "Shfaq _MENU_ rekorde per faqe",
            "zeroRecords": "Nuk u gjet azgje!",
            "info": "Faqja _PAGE_ nga _PAGES_",
            "infoEmpty": "Nuk ka te dhena!",
            "infoFiltered": "(Filtruar  nga _MAX_ gjithsej te dhena)"
        }
    });
    // window.client_payments_table = $('#client_payments_table').DataTable();
});

//Importing axios
window.axios = require('axios');
//setting csfr token to axios request headers
//csfr token is on head of each page(app.blade.php)
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};


//Delete note card
window.delete_note_card = function delete_note_card(note_card_id) {

    if (confirm('Konfirmo fshirjen e shenimit')) {

        axios.post('/note/' + note_card_id, {

            _method: 'DELETE'

        })
            .then(function (response) {

                $('#note_card_' + note_card_id).fadeOut(300, function () {
                    $(this).remove();
                });

            })
            .catch(function (error) {
                console.log(error);

            });
    }

}


//Delete note card
window.delete_file_card = function delete_note_card(file_card_id) {

    if (confirm('Konfirmo fshirjen e fajllit')) {

        axios.post('/file/' + file_card_id, {

            _method: 'DELETE'

        })
            .then(function (response) {

                $('#file_card_' + file_card_id).fadeOut(300, function () {
                    $(this).remove();
                });

            })
            .catch(function (error) {
                console.log(error);

            });
    }

}

//Delete Employee card
window.delete_employee_card = function delete_employee_card(employee_card_id) {

    if (confirm('Konfirmo fshirjen e puntorit')) {

        axios.post('/employee/' + employee_card_id, {

            _method: 'DELETE'

        })
            .then(function (response) {

                $('#employee_card_' + employee_card_id).fadeOut(300, function () {
                    $(this).remove();
                });

            })
            .catch(function (error) {
                console.log(error);

            });
    }

}

//Delete Employee card
window.delete_client_card = function delete_client_card(client_card_id) {

    if (confirm('Konfirmo fshirjen e klientit')) {

        axios.post('/client/' + client_card_id, {

            _method: 'DELETE'

        })
            .then(function (response) {

                $('#client_card_' + client_card_id).fadeOut(300, function () {
                    $(this).remove();
                });

            })
            .catch(function (error) {
                console.log(error);

            });
    }

}

window.search_clients_cards = function search_clients_cards(input) {


    if (!input) {

        $('div[id^="client_card_"]').each(function () {

            $(this).show();

        });


    } else {
        $('div:not([data-keywords*=' + input.toLowerCase() + '])[id^="client_card_"]').each(function () {

            $(this).hide();

        });
    }
}

window.search_employees_cards = function search_employees_cards(input) {


    if (!input) {

        $('div[id^="employee_card_"]').each(function () {

            $(this).show();

        });


    } else {
        $('div:not([data-keywords*=' + input.toLowerCase() + '])[id^="employee_card_"]').each(function () {

            $(this).hide();

        });
    }
}



