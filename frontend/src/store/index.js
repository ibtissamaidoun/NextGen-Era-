// src/store/index.js
import { createStore } from "vuex";
import router from '@/router'; // Importez le routeur
//import http from '@/services/http';
import axios from 'axios'

export default createStore({
  state: {
    hideConfigButton: false,
    isPinned: false, 
    showConfig: false,
    sidebarType: "bg-white",
    isRTL: false,
    mcolor: "",
    darkMode: false,
    isNavFixed: false,
    isAbsolute: false,
    showNavs: true,
    showSidenav: true,
    showNavbar: true,
    showFooter: true,
    showMain: true,
    layout: "default",
    accessToken: null,
    refreshToken: null,
  },
  mutations: {
    toggleConfigurator(state) {
      state.showConfig = !state.showConfig;
    },
    sidebarMinimize(state) {
      let sidenav_show = document.querySelector("#app");
      if (state.isPinned) {
        sidenav_show.classList.add("g-sidenav-hidden");
        sidenav_show.classList.remove("g-sidenav-pinned");
        state.isPinned = false;
      } else {
        sidenav_show.classList.add("g-sidenav-pinned");
        sidenav_show.classList.remove("g-sidenav-hidden");
        state.isPinned = true;
      }
    },
    sidebarType(state, payload) {
      state.sidebarType = payload;
    },
    navbarFixed(state) {
      state.isNavFixed = !state.isNavFixed;
    },
    updateShowNavbar(state, value) {
      state.showNavbar = value;
    },
    updateShowSidenav(state, value) {
      state.showSidenav = value;
    },
    updateShowFooter(state, value) {
      state.showFooter = value;
    },
    updateHideConfigButton(state, value) {
      state.hideConfigButton = value;
    },
    setUser(state, user) {
      state.user = user;
    },
    setToken(state, token) {
      state.accessToken = token;
    },
    setRefreshToken(state, refreshToken) {
      state.refreshToken = refreshToken;
    },
  },
  actions: {
    toggleSidebarColor({ commit }, payload) {
      commit("sidebarType", payload);
    },
    navigateTo({ commit }, { route, navbar, sidenav, footer, hideConfigButton }) {
      commit('updateShowNavbar', navbar);
      commit('updateShowSidenav', sidenav);
      commit('updateShowFooter', footer);
      commit('updateHideConfigButton', hideConfigButton);
      router.push(route);
    },
    login({ commit }, authData) {
      return axios.post('/login', {
        email: authData.email,
        password: authData.password
      }).then(res => {
        commit('setToken', res.data.token);
        commit('setRefreshToken', res.data.refresh_token);
      }).catch(error => {
        console.error('Login failed:', error);  
      });
    }
    },
    logout({ commit }) {
      commit('setToken', null);
      commit('setRefreshToken', null);
      // Assurez-vous de gérer la déconnexion côté serveur si nécessaire
    },
  getters: {
    // Vous pouvez également ajouter des getters si nécessaire
    isAuthenticated(state) {
      return !!state.user;
    },
    userRole(state) {
      return state.user ? state.user.role : null;
    }
  }
});
