//import 'babel-polyfill';
 // require('./bootstrap');


import Vue from 'vue'
import VueRouter from 'vue-router';
import routes from './routes/routes';
Vue.use(VueRouter);


import App from './views/App';
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/themes/confetti.css';
import Notifications from 'vue-notification';
import axios from 'axios';
import VueAxios from 'vue-axios';
Vue.use(VueAxios, axios);
Vue.use(flatPickr);


Vue.use(Notifications);
import VModal from 'vue-js-modal';
Vue.use(VModal, { dynamic: true});
window.Vue = require('vue');


window.axios = require('axios');
axios.defaults.baseURL = '/api';


const router = new VueRouter({
    mode: 'history',
    routes,
});
Vue.router = router;

Vue.use(require('@websanova/vue-auth'), {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
});

router.beforeEach((to, from, next) => {
    // This goes through the matched routes from last to first, finding the closest route with a title.
    // eg. if we have /some/deep/nested/route and /some, /deep, and /nested have titles, nested's will be chosen.
    const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);

    // Find the nearest route element with meta tags.
    const nearestWithMeta = to.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);
    const previousNearestWithMeta = from.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);

    // If a route with a title was found, set the document (page) title to that value.
    if(nearestWithTitle) document.title = nearestWithTitle.meta.title;

    // Remove any stale meta tags from the document using the key attribute we set below.
    Array.from(document.querySelectorAll('[data-vue-router-controlled]')).map(el => el.parentNode.removeChild(el));

    // Skip rendering meta tags if there are none.
    if(!nearestWithMeta) return next();

    // Turn the meta tag definitions into actual elements in the head.
    nearestWithMeta.meta.metaTags.map(tagDef => {
        const tag = document.createElement('meta');

        Object.keys(tagDef).forEach(key => {
            tag.setAttribute(key, tagDef[key]);
        });

        // We use this to track which meta tags we create, so we don't interfere with other ones.
        tag.setAttribute('data-vue-router-controlled', '');

        return tag;
    })
    // Add the meta tags to the document head.
        .forEach(tag => document.head.appendChild(tag));
    next()
});
Vue.filter('capitalize', function (value) {
    if (!value) return '';
    value = value.toString();
    return value.charAt(0).toUpperCase() + value.slice(1)
});
App.router = Vue.router;

Vue.component('DatePicker', require('vue-flatpickr-component'));
window.EventBus = new Vue();

// new Vue(App).$mount('#app');
const app =new Vue({
    el: '#app',
    template: '<App/>',
    components: { App },
    router,
}).$mount('#app');

