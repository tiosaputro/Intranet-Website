import './bootstrap';
window.Vue = require('vue').default;

import Vue from 'vue';
import 'core-js/stable';
import 'regenerator-runtime/runtime';
import VueRouter from 'vue-router';
import FeatherIcon from './@core/components/feather-icon/FeatherIcon.vue'
import VueHtml2Canvas from 'vue-html2canvas';
import nocache from 'nocache';
import axios from 'axios';
import DataTable from 'laravel-vue-datatable';
import Form from 'vform';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Toasted from 'vue-toasted'
import {func} from './@core/global_function.js'
import VueProgressBar from 'vuejs-progress-bar'
import store from './store'
import { setHeaderToken } from './utils/auth'

//datatable
Vue.use(DataTable);
//vuehtmlcanvas
Vue.use(VueHtml2Canvas);
Vue.use(nocache)
//vue feather icon
Vue.use(FeatherIcon)
Vue.component(FeatherIcon.name, FeatherIcon)
//vue router
Vue.use(VueRouter);

Vue.config.productionTip = false;
axios.defaults.baseURL = '/api/'
window.Form = Form;
Vue.use(VueSweetalert2);
//toast
Vue.use(Toasted, {
    duration : 3000
})
Vue.prototype.$func = func

// const Toast = Swal.mixin({
//     toast: true,
//     position: 'top-end',
//     showConfirmButton: false,
//     timer: 3000,
//     timerProgressBar: true,
//     onOpen: (toast) => {
//       toast.addEventListener('mouseenter', Swal.stopTimer)
//       toast.addEventListener('mouseleave', Swal.resumeTimer)
//     }
//   })
// window.Swal = Swal;
// window.Toast = Toast;
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  });
// Filter Section
Vue.filter('yesno', value => (value ? '<i class="fas fa-check green"></i>' : '<i class="fas fa-times red"></i>'));

//import component layout
import Headernavbar from './components/layouts/HeaderNavbar.vue'
import Menunavigation from './components/layouts/MenuNavigation.vue';
//import routes
import routes from './router/router.js'
import {mapGetters} from 'vuex'
//routes path vue
const token = localStorage.getItem('token');

if (token) {
  setHeaderToken(token)
}
const router = new VueRouter({
    // cache : false,
    // mode : 'history',
    routes,
    // linkActiveClass : 'active',
    linkExactActiveClass : 'active',
})
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiredAuth)) {
      // this route requires auth, check if logged in
      // if not, redirect to login page.
      if (!store.getters.isLoggedIn){
          $(".horizontal-menu-wrapper").hide();
          next({ name: 'login' })
      } else {
          $(".horizontal-menu-wrapper").show();
        next() // go to wherever I'm going
      }
    } else {
      next() // does not require auth, make sure to always call next()!
    }
  })

console.log('app.js ' + token)
store.dispatch('get_user', token)
.then(() => {
    new Vue({
        cache : false,
        el: '#app-vue',
        router,
        store,
        components : {
            Headernavbar,
            Menunavigation
        },
        methods: {
            cekLogin() {
                const log = this.$store.dispatch('get_user');
            }
        },
        mounted() {

        }, //end mounted
        computed : {
            ...mapGetters({
                loggedin : 'isLoggedIn',
                authCheck : 'user',
                auth : 'user'
            })
        }
    });

}).catch((error) => {
    console.error(error);
})
