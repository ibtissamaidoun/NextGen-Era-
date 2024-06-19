import { createApp } from "vue";
import App from "./App.vue";
import store from "./store";
import router from "./router";
import axiosInstance from './axios-instance';
import "./assets/css/nucleo-icons.css";
import "./assets/css/nucleo-svg.css";
import ArgonDashboard from "./argon-dashboard";


import axios from 'axios'; // Assurez-vous d'importer axios

// Récupérer le nonce depuis le backend
    axios.get('/get-nonce')
    .then(response => {
        const nonce = response.data.nonce;

        // Ajouter le nonce à tous les scripts existants
        const scripts = document.querySelectorAll('script');
        scripts.forEach(script => {
            script.setAttribute('nonce', nonce);
    });

        // Initialiser votre application Vue.js avec le nonce disponible
        const app = createApp(App);
        app.use(store);
        app.use(router);
        app.use(ArgonDashboard);
        app.config.globalProperties.$axios = axiosInstance;
        app.mount("#app");
    })
    .catch(error => {
        console.error('Erreur lors de la récupération du nonce:', error);



const app = createApp(App);
app.use(store);
app.use(router);
app.use(ArgonDashboard);
app.config.globalProperties.$axios = axiosInstance;
app.mount("#app");

});

//import http from '@/services/http';

// Configuration global d'Axios
// const axiosInstance = axios.create({
//     baseURL: 'http://40.127.11.222:8000/api', /// Remplacez par l'URL de votre API
//     headers: {
//         'Authorization': Bearer ${sessionStorage.getItem('token')} // Inclure le token dans l'en-tête Authorization
//     }
// });
// const axiosInstance = axios.create({
//     baseURL: 'http://127.0.0.1:8000/api',
//     withCredentials: true
// });
// axiosInstance.interceptors.request.use(function (config) {
//     const token = Cookies.get('token');;
//     config.headers.Authorization = token ? Bearer ${token} : '';
//     return config;
// });
// Exporter l'instance Axios configurée
export default axiosInstance;


// const app = createApp(App);
// app.use(store);
// app.use(router);
// app.use(ArgonDashboard);
// app.config.globalProperties.$axios = axiosInstance;
// app.mount("#app");
// app.mount("#app");