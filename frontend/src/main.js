import { createApp } from "vue";
import App from "./App.vue";
import store from "./store";
import router from "./router";
import "./assets/css/nucleo-icons.css";
import "./assets/css/nucleo-svg.css";
import ArgonDashboard from "./argon-dashboard";
import axios from 'axios';
import Cookies from 'js-cookie'; // Importer js-cookie

// Configuration globale d'Axios
const axiosInstance = axios.create({
    baseURL: 'http://127.0.0.1:8000/api', // Remplacez par l'URL de votre API
    headers: {
        'Authorization': `Bearer ${Cookies.get('token')}` // Utiliser js-cookie pour obtenir le token
    }
});
// Exporter l'instance Axios configurée
export default axiosInstance;

//import Home from "./Home.vue";

const appInstance = createApp(App);
appInstance.use(store);
appInstance.use(router);
appInstance.use(ArgonDashboard);
appInstance.mount("#app");

// Note : `appInstance.mount(Home);` semble incorrect. Vous devriez probablement enlever cette ligne.
// `Home` devrait être utilisé comme composant à l'intérieur d'une route de `router`, pas monté directement ici.
