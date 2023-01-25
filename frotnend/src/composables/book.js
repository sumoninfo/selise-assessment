import {ref}      from 'vue'
import ApiService from "@/services/api.service";

export default function handleBook() {
    const loading    = ref(false)
    const fetchBooks = () => {
        return ApiService.get('/fetch-books')
    }

    return {
        fetchBooks
    }
}
