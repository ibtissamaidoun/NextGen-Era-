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
        <!-- <li class="nav-item">
        <sidenav-item
          to="/dashboard-animateurs"
          :class="getRoute() === 'dashboard-animateurs' ? 'active' : ''"
          :navText="isRTL ? 'لوحة القيادة' : 'Dashboard'"
        >
          <template v-slot:icon>
            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li> -->
      
      
      <li class="nav-item">
        <sidenav-item
          to="/dashboard-animateurs/Horaires"
          :class="getRoute() === 'Horaires' ? 'active' : ''"
          :navText="isRTL ? 'الجداول' : 'Horaires'"
        >
          <template v-slot:icon>
            <i
              class="ni ni-time-alarm text-primary text-sm opacity-10"
            ></i>
          </template>
        </sidenav-item>
      </li>

      <li class="nav-item">
        <sidenav-item
          to="/dashboard-animateurs/Edt"
          :class="getRoute() === 'Edt' ? 'active' : ''"
          :navText="isRTL ? 'الجداول' : 'Edt'"
        >
          <template v-slot:icon>
            <i
              class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"
            ></i>
          </template>
        </sidenav-item>
      </li>

      <li class="nav-item">
        <sidenav-item
          to="/dashboard-animateurs/Activites"
          :class="getRoute() === 'Activites' ? 'active' : ''"
          :navText="isRTL ? 'الجداول' : 'Activites'"
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
          to="/login"
          :class="getRoute() === 'signin' ? 'active' : ''"
          :navText="isRTL ? 'تسجيل الدخول' : 'Déconnexion'"
        >
          <template v-slot:icon>
            <i class="ni ni-single-copy-04 text-danger text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>

      
    </ul>
  </div>
      
   
  
    
  </template>