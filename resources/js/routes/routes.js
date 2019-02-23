import Booking from "../views/bookings/Booking";

export default [

    {
        path: '/',
        name: 'Dashboard',
        components: require('../views/dashboard/Index'),
        meta: {
            auth: true
        },
    },
    // {
    //     path: '/login',
    //     name: 'Login',
    //     components: require('../views/Login'),
    //     meta: {
    //         auth: false
    //     }
    // },
    {
        path: '/bookings',
        name: 'booking-index',
        components: require('../views/bookings/Index'),
        meta: {
            auth: true
        },
        // children:[
        //     {
        //         path:':id/edit',
        //         name: 'booking-edit',
        //         component: require('../views/bookings/Booking'),
        //         meta: {
        //             auth: true
        //         }
        //     }
        //
        // ]
    },
    {
        path: '/bookings/:id/edit',
        name: 'booking-edit',
        components: require('../views/bookings/Booking'),
        meta: {
            auth: true
        }
    }, 
    {
        path: '/reports',
        name: 'reports-index',
        components: require('../views/reports/Index'),
        meta: {
            auth: true
        }
    },
    {
        path: '/reports/schedule',
        name: 'reports-index',
        components: require('../views/reports/Schedule'),
        meta: {
            auth: true
        }
    }


]