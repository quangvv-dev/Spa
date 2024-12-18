
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Paginate from 'vuejs-paginate'
Vue.component('paginate', Paginate)
import vSelect from 'vue-select'

Vue.component('v-select', vSelect)
import 'vue-select/dist/vue-select.css';

import VueCookies from 'vue-cookies'
Vue.use(VueCookies, { expire: '7d'})

import Popover from 'vue-js-popover';
Vue.use(Popover)

import VueLazyload from 'vue-lazyload';
Vue.use(VueLazyload)

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
Vue.component('setting-source-component', require('./components/settingSourceComponent.vue').default);
Vue.component('chat-component', require('./components/chat-messagers/chatComponent.vue').default);
Vue.component('chat-multi-component', require('./components/chat-messagers/chatMultiPageComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app'
// });
console.log(234234324);
if(document.getElementById('vue-component')) {
    const app = new Vue({
        el: '#vue-component',
    });
}
