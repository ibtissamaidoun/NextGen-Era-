<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";

import SidenavItem from "./SidenavItem.vue";
//import SidenavCard from "./SidenavCard.vue";

const store = useStore();
const isRTL = computed(() => store.state.isRTL);

const getRoute = () => {
  const route = useRoute();
  const routeArr = route.path.split("/");
  return routeArr[1];
};
</script>

<template>
    
        <div
    class="collapse navbar-collapse w-auto h-auto p-4"
    id="sidenav-collapse-main"
  >
    <ul class="navbar-nav">
      <li class="nav-item">
        <sidenav-item
          to="/dashboard-parents/Enfants"
          :class="getRoute() === 'Enfants' ? 'active' : ''"
          :navText="isRTL ? 'الجداول' : 'Enfants'"
        >
          <template v-slot:icon>
            <i
              class="ni ni-circle-08 text-primary text-sm opacity-10"
            ></i>
          </template>
        </sidenav-item>
      </li>

      <li class="nav-item">
        <sidenav-item
          to="/dashboard-parents/Activites"
          :class="getRoute() === 'Activités' ? 'active' : ''"
          :navText="isRTL ? 'الجداول' : 'Activités'"
        >
          <template v-slot:icon>
            <i
              class="ni ni-controller text-warning text-sm opacity-10"
            ></i>
          </template>
        </sidenav-item>
      </li>

      <li class="nav-item">
        <sidenav-item
          to="/dashboard-parents/DemandesParents"
          :class="getRoute() === 'Demandes' ? 'active' : ''"
          :navText="isRTL ? 'الجداول' : 'Demandes'"
        >
          <template v-slot:icon>
            <i
              class="ni ni-books text-primary text-sm opacity-10"
            ></i>
          </template>
        </sidenav-item>
      </li>

      <!-- <li class="nav-item">
        <sidenav-item
          to="/dashboard-parents/Devis"
          :class="getRoute() === 'Devis' ? 'active' : ''"
          :navText="isRTL ? 'الجداول' : 'Devis'"
        >
          <template v-slot:icon>
            <i
              class="ni ni-credit-card text-warning text-sm opacity-10"
            ></i>
          </template>
        </sidenav-item>
      </li>
      
      <li class="nav-item">
        <sidenav-item
          to="/dashboard-parents/Factures"
          :class="getRoute() === 'Factures' ? 'active' : ''"
          :navText="isRTL ? 'الجداول' : 'Factures'"
        >
          <template v-slot:icon>
            <i
              class="ni ni-single-copy-04 text-primary text-sm opacity-10"
            ></i>
          </template>
        </sidenav-item>
      </li> -->
      <li class="nav-item">
        <sidenav-item
          to="/dashboard-animateurs/Activites"
          :class="getRoute() === 'Offres' ? 'active' : ''"
          :navText="isRTL ? 'الجداول' : 'Offres'"
        >
          <template v-slot:icon>
            <i
              class="fa fa-birthday-cake text-info text-sm opacity-10"
            ></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          to="/dashboard-animateurs/Activites"
          :class="getRoute() === 'Notifications' ? 'active' : ''"
          :navText="isRTL ? 'الجداول' : 'Notifications'"
        >
          <template v-slot:icon>
            <i
              class="ni ni-controller text-info text-sm opacity-10"
            ></i>
          </template>
        </sidenav-item>
      </li>
      <li class="mt-3 nav-item">
        <h6
          v-if="isRTL"
          class="text-xs ps-4 text-uppercase font-weight-bolder opacity-6"
          :class="isRTL ? 'me-4' : 'ms-2'"
        >
          صفحات المرافق
        </h6>

      <h6
          v-else
          class="text-xs ps-4 text-uppercase font-weight-bolder opacity-6"
          :class="isRTL ? 'me-4' : 'ms-2'"
        >
          ACCOUNT PAGES
        </h6>
      </li>

      <li class="nav-item">
        <sidenav-item
          to="/dashboard-admin/profile"
          :class="getRoute() === 'profile' ? 'active' : ''"
          :navText="isRTL ? 'حساب تعريفي' : 'Profile'"
        >
          <template v-slot:icon>
            <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>

      <li class="nav-item">
        <sidenav-item
          to="/signin"
          :class="getRoute() === 'signin' ? 'active' : ''"
          :navText="isRTL ? 'تسجيل الدخول' : 'Déconnexion'"
        >
          <template v-slot:icon>
            <i class="ni ni-single-copy-04 text-danger text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>

      <li class="nav-item">
        <sidenav-item
          to="/register"
          :class="getRoute() === 'register' ? 'active' : ''"
          :navText="isRTL ? 'اشتراك' : 'Sign Up'"
        >
          <template v-slot:icon>
            <i class="ni ni-collection text-info text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
    </ul>
  </div>  
  </template>