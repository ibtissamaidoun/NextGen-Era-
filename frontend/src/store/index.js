import { createStore } from 'vuex';
import router from '@/router';
import createPersistedState from 'vuex-persistedstate';
import axios from 'axios';

export default createStore({
  state: {
    // State related to the cart
    cart: [],
    cartTotal: 0,

    // Other state properties
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
    // Cart-related mutations
    async initialiseStore(state) {
      if (localStorage.getItem('cart')) {
        state.cart = JSON.parse(localStorage.getItem('cart'));
      }
      if (localStorage.getItem('cartTotal')) {
        state.cartTotal = parseFloat(localStorage.getItem('cartTotal'));
      }
      return true;
    },
    addRemoveCart(state, payload) {
      if (payload.toAdd) {
        const existingProduct = state.cart.find(item => item.id === payload.product.id);
        if (existingProduct) {
          existingProduct.qty += payload.product.qty;
        } else {
          state.cart.push(payload.product);
        }
      } else {
        state.cart = state.cart.filter(item => item.id !== payload.product.id);
      }

      // Calculating the total
      state.cartTotal = state.cart.reduce((accumulator, object) => {
        return parseFloat(accumulator) + parseFloat(object.price * object.qty);
      }, 0);

      // Saving in web storage
      localStorage.setItem('cartTotal', JSON.stringify(state.cartTotal));
      localStorage.setItem('cart', JSON.stringify(state.cart));
    },
    updateCart(state, payload) {
      // Update quantity
      const product = state.cart.find(o => o.id === payload.product.id);
      if (product) {
        product.qty = payload.product.qty;
      }

      // Calculating the total
      state.cartTotal = state.cart.reduce((accumulator, object) => {
        return parseFloat(accumulator) + parseFloat(object.price * object.qty);
      }, 0);

      // Saving in web storage
      localStorage.setItem('cartTotal', JSON.stringify(state.cartTotal));
      localStorage.setItem('cart', JSON.stringify(state.cart));
    },

    // Other mutations
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
    // Actions for the cart (none provided, but can be added if needed)

    // Other actions
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
      try {
        const response = await axios.post('/api/login', authData);
        console.log('API Response:', response.data);
        if (response.data.token) {
          console.log('Login successful: User and token are present');
          commit('setUser', response.data.utilisateur || {});
          commit('setAuthentication', true);
          commit('setUserRole', response.data.role);
          commit('setToken', response.data.token);
          commit('setRefreshToken', response.data.refresh_token);
        } else {
          throw new Error('Login failed: User or token are missing from the response');
        }
      } catch (error) {
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
        commit('setUserRole', null);
        commit('setAuthentication', false);
      } catch (error) {
        console.error('Logout failed:', error);
      }
    }
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
