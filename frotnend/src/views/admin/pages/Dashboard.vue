<template>
    <div>
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
        </div>
        <div class="row">

            <!-- Total Products -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Products
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ dashboard.products }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState} from "vuex";
import ApiService from "@/services/api.service";

export default {
    name    : "AdminDashboard",
    data    : () => ({
        dashboard: {
            products: 0,
        }
    }),
    computed: {
        ...mapState({
            user: state => state.auth.user
        }),
    },
    mounted() {
        this.getDashboardData();
    },
    methods: {
        getDashboardData() {
            ApiService.get('/dashboard-data').then(response => {
                this.dashboard = response.data;
            }).catch(error => {
                console.log(error, 'error')
            })
        }
    }
}
</script>
