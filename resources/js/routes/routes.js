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
    },
    {
        path: '/agents',
        name: 'agents-index',
        components: require('../views/agents/Index'),
        meta: {
            auth: true
        }
    },
    {
        path: '/agents/:id/edit',
        name: 'agents-edit',
        components: require('../views/agents/Agent'),
        meta: {
            auth: true
        }
    },
    {
        path: '/agents/:id/products',
        name: 'agents-products-index',
        components: require('../views/agents/AgentProductsIndex'),
        meta: {
            auth: true
        }
    },
    {
        path: '/agents/:id/products/:product/edit',
        name: 'agents-products-edit',
        components: require('../views/agents/AgentProduct'),
        meta: {
            auth: true
        }
    },
    {
        path: '/agents/:id/products/create',
        name: 'agents-products-create',
        components: require('../views/agents/CreateAgentProduct'),
        meta: {
            auth: true
        }
    },
    {
        path: '/products',
        name: 'product-index',
        components: require('../views/products/Index'),
        meta: {
            auth: true
        }
    },
    {
        path: '/products/:id/edit',
        name: 'product-edit',
        components: require('../views/products/Product'),
        meta: {
            auth: true
        }
    }


]