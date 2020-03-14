
import Vue from 'vue'
import App from './App.vue'

// Vuesax Component Framework
import Vuesax from 'vuesax'
import 'material-icons/iconfont/material-icons.css' //Material Icons
import 'vuesax/dist/vuesax.css'; // Vuesax
Vue.use(Vuesax)


// axios
import axios from "./axios.js"
Vue.prototype.$http = axios

// API Calls
import "./http/requests"

// mock
// import "./fake-db/index.js"

// Theme Configurations
import '../themeConfig.js'


// Firebase
// import '@/firebase/firebaseConfig'


// // Auth0 Plugin
// import AuthPlugin from "./plugins/auth";
// Vue.use(AuthPlugin);


// ACL
// import acl from './acl/acl'


// Globally Registered Components
import './globalComponents.js'


// Styles: SCSS
import './assets/scss/main.scss'


// Tailwind
import '@/assets/css/main.css'


// Vue Router
import router from './router'


// Vuex Store
import store from './store/store'


// i18n
import i18n from './i18n/i18n'


// Vuexy Admin Filters
import './filters/filters'

//
// // Clipboard
// import VueClipboard from 'vue-clipboard2'
// Vue.use(VueClipboard);


// Tour
import VueTour from 'vue-tour'
Vue.use(VueTour)
require('vue-tour/dist/vue-tour.css')


// VeeValidate
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);


// // Google Maps
// import * as VueGoogleMaps from 'vue2-google-maps'
// Vue.use(VueGoogleMaps, {
//     load: {
//         // Add your API key here
//         key: 'YOUR_KEY',
//         libraries: 'places', // This is required if you use the Auto complete plug-in
//     },
// })

// Vuejs - Vue wrapper for hammerjs
import { VueHammer } from 'vue2-hammer'

import * as Sentry from '@sentry/browser';
import * as Integrations from '@sentry/integrations';


Vue.use(VueHammer)


// PrismJS
// import 'prismjs'
// import 'prismjs/themes/prism-tomorrow.css'


// Feather font icon
require('./assets/css/iconfont.css')

//
// import {startCase, omit} from 'lodash/core';
// Object.defineProperty(Vue.prototype, '$_.omit', { value: omit});
// Vue select css
// Note: In latest version you have to add it separately
// import 'vue-select/dist/vue-select.css';

import _ from 'lodash';
Object.defineProperty(Vue.prototype, '$_', { value: _ });

Vue.config.productionTip = false

new Vue({
    router,
    store,
    i18n,
    render: h => h(App)
}).$mount('#app');



Sentry.init({
  dsn: 'https://223da50ebf144cb69622fb11e4fe678c@sentry.io/4049470',
  integrations: [new Integrations.Vue({Vue, attachProps: true, logErrors: true})],
});
