const links = [
    {
        name: 'Menaxhimi',
        groups: [
            {
                icon: 'mdi-account-tie',
                name: 'employee',
                title: 'Stafi',
                items: [
                    {
                        to: '/employee/all',
                        title: 'Te gjith puntoret',
                        icon: 'mdi-account-group'
                    },
                    {
                        to: '/employee/new',
                        title: 'Shto puntor te ri',
                        icon: 'mdi-account-plus'
                    },
                ],

            },
            {
                icon: 'mdi-account-outline',
                name: 'client',
                title: 'Klientet',
                items: [
                    {
                        to: '/client/all',
                        title: 'Te gjithe klientet',
                        icon: 'mdi-account-group-outline'
                    },
                    {
                        to: '/client/new',
                        title: 'Shto klient te ri',
                        icon: 'mdi-account-plus-outline'
                    }
                ],

            },


            {
                icon: 'mdi-calendar-account',
                name: 'job|event',
                title: 'Rezervimet / Eventet',
                items: [
                    {
                        to: '/job/all',
                        title: 'Te gjitha rezervimet',
                        icon: 'mdi-calendar-multiple'
                    },
                    {
                        to: '/job/new',
                        title: 'Shto rezervim',
                        icon: 'mdi-calendar-plus'
                    },
                    {
                        to: '/event/all',
                        title: 'Te gjitha eventet',
                        icon: 'mdi-calendar-multiselect'
                    },
                    {
                        to: '/event/new',
                        title: 'Shto event',
                        icon: 'mdi-calendar-plus'
                    },
                ],

            },

        ],
    },
    {
        name: 'Studio',
        groups: [



            {
                icon: 'mdi-tag',
                name: 'offer|service',
                title: 'Ofertat / Sherbimet',
                items: [
                    {
                        to: '/offer/all',
                        title: 'Te gjitha ofertat',
                        icon: 'mdi-tag-multiple'
                    },
                    {
                        to: '/offer/new',
                        title: 'Shto oferte te re',
                        icon: 'mdi-tag-plus'
                    },
                    {
                        to: '/service/all',
                        title: 'Te gjitha sherbimet',
                        icon: 'mdi-account-box-outline'
                    },
                    {
                        to: '/service/new',
                        title: 'Shto sherbim',
                        icon: 'mdi-account-box-outline'
                    },
                ],

            },
            {
                icon: 'mdi-check-decagram',
                name: 'task',
                title: 'Punet',
                items: [

                    {
                        to: '/task/all',
                        title: 'Te gjitha punet',
                        icon: 'mdi-account-plus-outline'
                    },
                    {
                        to: '/task/new',
                        title: 'Shto pune',
                        icon: 'mdi-account-plus-outline'
                    }
                ],

            },

            {
                icon: 'mdi-camera-outline',
                name: 'inventory',
                title: 'Pajisjet',
                items: [
                    {
                        to: '/inventory/all',
                        title: 'Te gjitha pajisjet',
                        icon: 'mdi-monitor-multiple'
                    },
                    {
                        to: '/inventory/new',
                        title: 'Shto pajisje te re',
                        icon: 'mdi-camera-plus-outline'
                    },
                ],

            },
            {
                icon: 'mdi-cash',
                name: 'payment',
                title: 'Pagesat',
                items: [
                    {
                        to: '/payment/all',
                        title: 'Te gjitha pagesat',
                        icon: 'mdi-cash-multiple'
                    },
                    {
                        to: '/payment/new',
                        title: 'Shto pagese',
                        icon: 'mdi-cash'
                    },
                ],

            },


            {
                icon: 'mdi-file-cabinet',
                name: "file|note",
                title: 'Fajllat / Shenimet',
                items: [
                    {
                        to: '/file',
                        title: 'Fajllat',
                        icon: 'mdi-file-document-outline'
                    },
                    {
                        to: '/note',
                        title: 'Shenimet',
                        icon: 'mdi-file-document-box-outline'
                    }
                ],

            },


        ],
    },

]


export default links