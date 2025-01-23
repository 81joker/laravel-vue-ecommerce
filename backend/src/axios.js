import axios from "axios";
import store from "@/store";
import router from "./router";

const urlApis = "http://localhost/api";
const axiosClient = axios.create({
    baseURL: urlApis
    // baseURL: `${import.meta.env.VITE_API_BASE_URL}/api`
  });



// https://axios-http.com/docs/interceptors
// Axios “interceptors” : Axios provides a powerful feature called “interceptors”
// that allow us to intercept requests and responses before they are sent or received.
axiosClient.interceptors.response.use( config => {
    config.headers.Authorization = `Bearer ${store.state.user.token}`
    return config;
})

axiosClient.interceptors.response.use(response => {
    return response;
}, error => {
    
    if (error.response.status === 401) {
        console.log("error.response.status:", error.response.status)
        store.commit('setToken', null);
        router.push({name: 'login'});
    }
    throw error;
});

export default axiosClient;
