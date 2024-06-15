// src/axios-instance.js
import axios from 'axios';
import store from "@/store/index.js";

const axiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', // URL de votre API backend
  withCredentials: true // Assurez-vous que les cookies sont envoyés avec les requêtes
});
//baseURL: 'http://127.0.0.1:8000/api', // URL de votre API backend

// Ajouter un intercepteur de requête pour inclure le token d'authentification dans toutes les requêtes sortantes
axiosInstance.interceptors.request.use(config => {
  // Récupérer le token d'authentification de votre source appropriée (local storage, Vuex, etc.)
  const token = store.state.refreshToken; // Remplacez par la méthode appropriée pour récupérer le token

  // Vérifier si le token est disponible et ajouter l'en-tête d'authentification
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, error => {
  return Promise.reject(error);
});
// Intercepteur pour les erreurs 401
axiosInstance.interceptors.response.use(
  response => response,
  async error => {
    const originalRequest = error.config;
    if (error.response && error.response.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true;
      try {
        const refresh_token = store.state.refreshToken;
        const user = store.state.user;
        await axiosInstance.post('/refresh-token',{user: user},{headers: {
          'Authorization': `Bearer ${refresh_token}`}
        });
        return axiosInstance(originalRequest);
      } catch (err) {
        console.error('Refresh token failed', err);
        // Gérer la déconnexion si nécessaire
      }
    }
    return Promise.reject(error);
  }
);

export default axiosInstance;