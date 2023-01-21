import {createApp, nextTick} from 'vue'
import App                   from './App.vue'
import router                from './router'
import store                 from './store'
import './scss/main.scss'
import 'bootstrap'

import filters from './helpers/filters'

//sweetalert2
window.Swal  = require('sweetalert2');
//Toast
const Toast  = Swal.mixin({
    toast            : true,
    position         : 'top-end',
    showConfirmButton: false,
    timer            : 3000,
    timerProgressBar : true,
    didOpen          : (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
window.Toast = Toast;


//services
import ApiService      from '@/services/api.service.js'
import * as JwtService from "@/services/jwt.service.js";

ApiService.init();

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requireAuth) || JwtService.getToken()) {
        if (!JwtService.getToken()) {
            next({
                name: 'LoginPage', params: {nextUrl: to.fullPath}
            })
        }

        ApiService.get('/user').then(response => {
            store.commit("auth/SETUSER", response.data.data);
            next()
        }).catch(error => {
            JwtService.destroyToken();
            router.push({'name': 'LoginPage'})
        })
    }

    if (['LoginPage', 'RegisterPage'].includes(to.name) && JwtService.getToken()) {
        next({name: 'AdminDashboard'});
    }

    next();
    nextTick(() => {
        document.title = `${to.meta.title} - ${process.env.VUE_APP_TITLE}` || process.env.VUE_APP_TITLE
    })
});


const app = createApp(App)

app.config.globalProperties.$filters = filters

app.use(store).use(router).mount('#app')
