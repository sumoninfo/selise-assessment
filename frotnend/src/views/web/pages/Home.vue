<template>
  <div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
      <h1 class="display-5 fw-bold">{{siteName}}</h1>
      <p class="col-md-8 fs-4">Dhaka, Bangladesh</p>
    </div>
  </div>
</template>

<script setup>
import {ref} from "vue";
const siteName = ref(process.env.VUE_APP_TITLE)
</script>
