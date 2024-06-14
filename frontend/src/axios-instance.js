// src/axios-instance.js
import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', // URL de notre API backend
  withCredentials: true 
});
//baseURL: 'http://127.0.0.1:8000/api', // URL de votre API backend
axiosInstance.interceptors.request.use(
    config => {
      console.log('Request made with ', config);
      return config;
    },
    error => {
      return Promise.reject(error);
    }
  );
// Intercepteur pour les erreurs 401
axiosInstance.interceptors.response.use(
  response => response,
  async error => {
    const originalRequest = error.config;
    if (error.response && error.response.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true;
      try {
        await axiosInstance.post('/refresh-token');
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
