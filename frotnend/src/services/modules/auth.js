import {ref}               from 'vue'
import ApiService          from "@/services/api.service";
import JwtService          from "@/services/jwt.service";
import NotificationService from "@/services/notification.service";
import {useRouter}         from "vue-router";

export default function handleAuth() {
    const loading  = ref(false)
    const login    = (data) => {
        return ApiService.post('/login', data)
    }
    const register = (data) => {
        return ApiService.post('/register', data)
    }
    const logout   = () => {
        return ApiService.post('/logout')
    }

    const router = useRouter()

    const afterLoginRegister = (data) => {
        JwtService.saveToken(data.data.access_token);
        localStorage.setItem("expires_at", data.data.expires_at);
        ApiService.init();
        NotificationService.success(data.message);
        router.push({name: "AdminDashboard"})
    }

    return {
        login,
        register,
        logout,
        afterLoginRegister,
        loading
    }
}
