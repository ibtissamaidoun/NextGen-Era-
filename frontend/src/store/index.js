// src/store/index.js
import { createStore } from "vuex";
import router from '@/router'; // Importez le routeur

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
  },
  getters: {},
});