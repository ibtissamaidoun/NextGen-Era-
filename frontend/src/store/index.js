// src/store/index.js
import { createStore } from "vuex";
import router from '@/router'; 
import createPersistedState from 'vuex-persistedstate';
//import http from '@/services/http';
import axios from "axios";

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
    token: null,
    refreshToken: null,
    isAuthenticated: false,
    user: null, 
    userRole: null,
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
    resetState(state) {
      state.isAuthenticated = false;
      state.user = null;
      state.userRole = null;
      state.token = null;
    },
    setUser(state, user) {
      console.log("Setting user in mutation:", user);
      state.user = user;
      state.isAuthenticated = !!user;
    },
    setAuthentication(state, isAuthenticated) {
      console.log("Setting isAuthenticated in mutation:", isAuthenticated);
      state.isAuthenticated = isAuthenticated;
    },
    setUserRole(state, role) {
      console.log("Setting userRole in mutation:", role);
      state.userRole = role;
    },
    setToken(state, token) {
      state.token = token;
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
    async login({ commit }, authData) {
      try{
      const response = await axios.post('/api/login', authData);
      console.log('API Response:', response.data);
      if (response.data.token) {
        console.log('Login successful: User and token are present');
        commit('setUser', response.data.user ||{});
        commit('setAuthentication', true);
        commit('setUserRole', response.data.role);
        commit('setToken', response.data.token);
        commit('setRefreshToken', response.data.refresh_token);
      }else {
        throw new Error('Login failed: User or token are missing from the response');
      }
    } catch(error) {
        console.error('Login failed:', error); 
        throw error; 
      }
    },
    async logout({ commit }) {
      try {
        await axios.post('/api/logout'); 
        commit('setUser', null);
        commit('setToken', null);
        commit('setRefreshToken', null);
        commit('setUserRole', null); // Réinitialiser userRole aussi
        commit('setAuthentication', false); // Réinitialiser l'authentification
      } catch (error) {
        console.error('Logout failed:', error);
      }
    }
      // Assurez-vous de gérer la déconnexion côté serveur si nécessaire
    },
    getters: {
      isAuthenticated(state) {
        console.log("Getter isAuthenticated value:", state.isAuthenticated);
        return state.isAuthenticated;
      },
      userRole(state) {
        console.log("Getter userRole value:", state.userRole);
        return state.userRole;
      },
  },
  plugins: [createPersistedState()]
});
