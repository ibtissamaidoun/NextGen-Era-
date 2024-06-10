import { createApp } from "vue";
import App from "./App.vue";
import store from "./store";
import router from "./router";
import axiosInstance from './axios-instance';
import "./assets/css/nucleo-icons.css";
import "./assets/css/nucleo-svg.css";
import ArgonDashboard from "./argon-dashboard";

//import http from '@/services/http';

// Configuration global d'Axios
// const axiosInstance = axios.create({
//     baseURL: 'http://40.127.11.222:8000/api', /// Remplacez par l'URL de votre API
//     headers: {
//         'Authorization': `Bearer ${sessionStorage.getItem('token')}` // Inclure le token dans l'en-tête Authorization
//     }
// });
// const axiosInstance = axios.create({
//     baseURL: 'http://127.0.0.1:8000/api',
//     withCredentials: true
// });
// axiosInstance.interceptors.request.use(function (config) {
//     const token = Cookies.get('token');;
//     config.headers.Authorization = token ? `Bearer ${token}` : '';
//     return config;
// });
// Exporter l'instance Axios configurée
//export default axiosInstance;

const app = createApp(App);
app.use(store);
app.use(router);
app.use(ArgonDashboard);
app.config.globalProperties.$axios = axiosInstance;
app.mount("#app");