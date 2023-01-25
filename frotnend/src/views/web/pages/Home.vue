<template>
  <section style="background-color: #eee;">
    <div class="container py-5">
      <div class="row">
        <div v-for="(book, index) in books" class="col-md-12 col-lg-3 mb-3" :key="index">
          <div class="card">
            <img :src="book.image" style="height: 250px" class="card-img-top" :alt="book.name"/>
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <p class="small"><a href="#!" class="text-muted">{{ book.author }}</a></p>
              </div>

              <div class="d-flex justify-content-between mb-3">
                <h5 class="mb-0">{{ book.name }}</h5>
              </div>

              <div class="d-flex justify-content-between mb-2">
                <h6 class="text-dark mb-0">{{ $filters.withCurrency(book.price) }}</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import {onMounted, ref}    from "vue";
import NotificationService from "@/services/notification.service";
import handleBook          from "@/composables/book";

const {fetchBooks} = handleBook();
const books        = ref([])

const getBooks = () => {
  fetchBooks().then(({data}) => {
    books.value = data.data
  }).catch(error => {
    NotificationService.error(error.response.data.message);
  })
}

onMounted(() => {
  getBooks()
})
</script>
