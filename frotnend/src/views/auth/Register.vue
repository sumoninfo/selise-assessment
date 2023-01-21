<template>
  <div id="login-section" class="align-items-center d-flex">
    <div class="container">
      <div class="row justify-content-center">
        <div class="bg-opacity-25 bg-primary border border-primary col-5 my-5 p-5 rounded">
          <form @submit.prevent="registerSubmit()" class="needs-validation" novalidate>
            <h3 class="text-center mb-4 text-primary">Register</h3>
            <div class="mb-3">
              <input v-model="form.first_name" type="text" class="form-control "
                     :class="{ 'is-invalid': errors['first_name'] }"
                     id="name" required placeholder="FIRST NAME">
              <div v-if="errors['first_name']" class="invalid-feedback">
                {{ errors['first_name'][0] }}
              </div>
            </div>
            <div class="mb-3">
              <input v-model="form.last_name" type="text" class="form-control "
                     :class="{ 'is-invalid': errors['last_name'] }"
                     id="name" required placeholder="LAST NAME">
              <div v-if="errors['last_name']" class="invalid-feedback">
                {{ errors['last_name'][0] }}
              </div>
            </div>
            <div class="mb-3">
              <input v-model="form.email" type="email" class="form-control "
                     :class="{ 'is-invalid': errors['email'] }"
                     id="email" required placeholder="EMAIL">
              <div v-if="errors['email']" class="invalid-feedback">
                {{ errors['email'][0] }}
              </div>
            </div>
            <div class="mb-3">
              <input v-model="form.password" type="password" class="form-control "
                     :class="{ 'is-invalid': errors['password'] }" id="password" required
                     placeholder="PASSWORD">
              <div v-if="errors['password']" class="invalid-feedback">
                {{ errors['password'][0] }}
              </div>
            </div>
            <div class="mb-3">
              <input v-model="form.confirm_password" type="password" class="form-control "
                     :class="{ 'is-invalid': errors['confirm_password'] }" id="confirm_password" required
                     placeholder="CONFIRM PASSWORD">
              <div v-if="errors['confirm_password']" class="invalid-feedback">
                {{ errors['confirm_password'][0] }}
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary w-100 text-light">Register</button>
            </div>
            <div class="text-center">
              Already have an account?
              <router-link :to="{name:'LoginPage'}" class="m-2" type="submit">
                Login here
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

const {register} = handleAuth();
import {ref}               from "vue";
import {useRouter}         from "vue-router";

const form = ref({
  first_name      : "",
  last_name       : "",
  email           : "",
  password        : "",
  confirm_password: ""
});

const errors         = ref([])
const router         = useRouter()
const registerSubmit = () => {
  register(form.value).then(({data}) => {
    errors.value = []
    NotificationService.success(data.message);
    router.push({name: "LoginPage"})
  }).catch(error => {
    errors.value = error.response.data.errors;
    NotificationService.error(error.response.data.message);
  })
}
</script>
