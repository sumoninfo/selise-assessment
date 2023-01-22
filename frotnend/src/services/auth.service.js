import router          from "@/router";
import * as JwtService from "@/services/jwt.service";
import ApiService      from "@/services/api.service";
import store           from "@/store";
import {nextTick}      from "vue";

const AuthCheckService = {
    checkAuth() {
        router.beforeEach((to, from, next) => {
            if (to.matched.some(record => record.meta.requireAuth)) {
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
    },

};

export default AuthCheckService;
