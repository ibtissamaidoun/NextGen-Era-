import { createApp } from "vue";
import App from "./App.vue";
import store from "./store";
import router from "./router";
import "./assets/css/nucleo-icons.css";
import "./assets/css/nucleo-svg.css";
import ArgonDashboard from "./argon-dashboard";
import axios from 'axios'

// Configuration global d'Axios
const axiosInstance = axios.create({
    baseURL: 'http://127.0.0.1:8000/api', // Remplacez par l'URL de votre API
    headers: {
        'Authorization': `Bearer ${sessionStorage.getItem('token')}` // Inclure le token dans l'en-tête Authorization
    }
});
// Exporter l'instance Axios configurée
export default axiosInstance;


import Home from "./Home.vue";


const appInstance = createApp(App);
appInstance.use(store);
appInstance.use(router);
appInstance.use(ArgonDashboard);
appInstance.mount("#app");
appInstance.mount(Home);
