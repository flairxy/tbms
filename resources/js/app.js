// import Vue from 'vue'
// window.Vue = require('vue');
// import moment from 'moment';
import 'bootstrap'
import VueRouter from 'vue-router'
import App from './views/App'
import { routes } from './router';
import css from './css'
import { Form, HasError, AlertError } from 'vform'
import Vuex from 'vuex'
import store from './store/Store'
import NProgress from 'nprogress'
import '../../node_modules/nprogress/nprogress.css';
import VueClipboard from 'vue-clipboard2'
import VueQRCodeComponent from 'vue-qrcode-component'
import MyDataTable from './components/DataTable'
import AddModal from './components/AddModal'
import VueProgressBar from 'vue-progressbar'
import swal from 'sweetalert2'



window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

Vue.use(VueClipboard);
Vue.use(Vuex);
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
});



Vue.component('qr-code', VueQRCodeComponent);
Vue.component('add-modal', AddModal);
Vue.component('my-data-table', MyDataTable);
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

window.Form = Form;
window.Fire =  new Vue();

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeResolve((to, from, next) => {
    if (to.name) {
        NProgress.start()
    }
    next()
});


router.afterEach((to, from) => {
    NProgress.done()

});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    css,
    store,
    Fire
});
