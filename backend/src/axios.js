import axios, { toFormData } from "axios";
import store from "./store";
import router from "./router";

const axiosClient = axios.create({
    baseURL: `${$import.meta.env.VITE_API_URL}/api`
});


// TODO: SEARCH for  **interceptors**

axiosClient.interceptors.response.use( response => {
    return response;
},
    error => {
        if (error.response.state == 401) {
            sessionStorage.removeItem('TOKEN')
            router.push({name: 'login'})
        }
    throw error;

})

export default axiosClient;
