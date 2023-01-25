<template>
  <section style="background-color: #eee;">
    <div class="container py-5">
      <div class="row">
        <div v-for="(book, index) in lists" class="col-md-12 col-lg-3 mb-3" :key="index">
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
      <pagination v-if="lists.length>0" :pagination="table.pagination" @paginate="getList" :offset="5"/>
    </div>
  </section>
</template>

<script setup>
import {onMounted, ref}    from "vue";
import NotificationService from "@/services/notification.service";
import handleBook          from "@/composables/book";
import Pagination          from "@/components/Pagination.vue";

const {fetchBooks} = handleBook();
const lists        = ref([])

const table = ref({
  search    : '',
  pagination: {
    current_page: 1,
    per_page    : 10,
  }
})

const getList = () => {
  let params = {
    search  : table.value.search,
    per_page: table.value.pagination.per_page,
    page    : table.value.pagination.current_page,
  };
  fetchBooks(params).then(({data}) => {
    lists.value                  = data.data
    const {links, path, ...meta} = data.meta;
    table.value.pagination       = meta
  }).catch(error => {
    NotificationService.error(error.response.data.message);
  })
}

onMounted(() => {
  getList()
})
</script>
