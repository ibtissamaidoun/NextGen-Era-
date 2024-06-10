// src/services/http.js
import axios from 'axios';
import store from '@/store';
const instance = axios.create({
    baseURL: 'http://votreapi.com/api',
    timeout: 10000,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
});
// Ajout d'un intercepteur de réponse
instance.interceptors.response.use(
    response => response,
    async error => {
        const originalRequest = error.config;

        // Vérifiez si le token a expiré
        if (error.response.status === 401 && !originalRequest._retry) {
            originalRequest._retry = true;
            try {
                const res = await instance.post('/refresh-token', {
                    refresh_token: store.state.refreshToken // Assurez-vous que le refreshToken est stocké dans votre store
                });
                store.commit('setToken', res.data.token); // Mettez à jour le token dans le store
                originalRequest.headers['Authorization'] = `Bearer ${res.data.token}`;
                return instance(originalRequest); // Renvoie la requête avec le nouveau token
            } catch (refreshError) {
                console.error('Unable to refresh token:', refreshError);
                return Promise.reject(refreshError);
            }
        }

        return Promise.reject(error);
    }
);

export default instance;
