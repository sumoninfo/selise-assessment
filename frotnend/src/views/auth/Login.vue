<template>
    <div id="login-section" class="align-items-center d-flex">
        <div class="container">
            <div class="row justify-content-center">
                <div class="bg-opacity-25 bg-primary border border-primary col-5 my-5 p-5 rounded">
                    <form @submit.prevent="loginSubmit()" class="needs-validation" novalidate>
                        <h3 class="text-center mb-4 text-primary">Login</h3>
                        <div class="mb-3">
                            <input v-model="form.email" type="email" class="form-control text-center"
                                   :class="{ 'is-invalid': errors['email'] }"
                                   id="email" required placeholder="USERNAME">
                            <div v-if="errors['email']" class="invalid-feedback">
                                {{ errors['email'][0] }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <input v-model="form.password" type="password" class="form-control text-center"
                                   :class="{ 'is-invalid': errors['password'] }" id="password" required
                                   placeholder="PASSWORD">
                            <div v-if="errors['password']" class="invalid-feedback">
                                {{ errors['password'][0] }}
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100 text-light">Login</button>
                        </div>
                        <div class="text-center">
                            Don't have an account
                            <router-link :to="{name:'RegisterPage'}" class="m-2" type="submit">
                                Register
                            </router-link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import NotificationService from "@/services/notification.service";
import handleAuth          from "@/services/modules/auth";

const {login, afterLoginRegister} = handleAuth();
import {ref}               from "vue";

const form = ref({
    email   : "",
    password: ""
});

const errors = ref([])

const loginSubmit = () => {
    login(form.value).then(({data}) => {
        errors.value = []
        afterLoginRegister(data)
    }).catch(error => {
        errors.value = error.response.data.errors;
        NotificationService.error(error.response.data.message);
    })
}

</script>
