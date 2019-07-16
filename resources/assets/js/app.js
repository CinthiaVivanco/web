
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// import VueCurrencyFilter from 'vue-currency-filter'

// Vue.use(VueCurrencyFilter)

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('panelcuentas', require('./components/PanelCuentas.vue'));

const app = new Vue({
    el: '#app',
    data: {
        menu : 0,
        ruta: 'http://localhost:8080/ventas'
    }
});
