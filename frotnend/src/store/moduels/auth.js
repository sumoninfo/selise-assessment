import ApiService from "@/services/api.service";

export default {
    namespaced: true,
    // module assets
    state    : () => ({
        user        : {},
        loading_user: true
    }),
    getters  : {
        getUserFromGetters(state) {
            return state.user
        },
    },
    actions  : {
        getUser(context) {
            ApiService.get('/user').then(response => {
                context.commit("GETUSER", response.data.data);
            }).catch(error => {
                console.log(error, 'error')
            }).finally(() => {
                context.commit("LOADER", false)
            });
        },
        setUser(context, data) {
            context.commit("SETUSER", data);
        }
    },
    mutations: {
        GETUSER(state, data) {
            return state.user = data
        },
        LOADER(state, data) {
            return state.loading_user = data
        },
        SETUSER(state, data) {
            return state.user = data
        }
    },
}
