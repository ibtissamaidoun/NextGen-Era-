<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";

import SidenavItem from "./SidenavItem.vue";

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
    class="collapse navbar-collapse w-auto h-auto h-100"
    id="sidenav-collapse-main"
  >
    <ul class="navbar-nav">
        <li class="nav-item">
        <sidenav-item
          to="/dashboard-parents/Enfants"
          :class="getRoute() === 'Enfants' ? 'active' : ''"
          :navText="isRTL ? 'لوحة القيادة' : 'Enfants'"
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
          to="/dashboard-parents/Demandes"
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
      

     
      <li class="nav-item">
        <sidenav-item
          to="/dashboard-parents/Offres"
          :class="getRoute() === 'Offres' ? 'active' : ''"
          :navText="isRTL ? 'الجداول' : 'Offres'"
        >
          <template v-slot:icon>
            <i
              class="fa fa-star text-warning text-sm opacity-10"
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
          to="/profile"
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
          :class="getRoute() === 'Déconnexion' ? 'active' : ''"
          :navText="isRTL ? 'تسجيل الدخول' : 'Déconnexion'"
        >
          <template v-slot:icon>
            <i class="ni ni-single-copy-04 text-danger text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>

      
    </ul>
  </div>

  <div class="pt-3 mx-3 mt-3 sidenav-footer">
    <sidenav-card
      :card="{
        title: 'Need Help?',
        description: 'Please check our docs',
        links: [
          {
            label: 'Documentation',
            route:
              'https://www.creative-tim.com/learning-lab/vue/overview/argon-dashboard/',
            color: 'dark',
          },
          {
            label: 'Buy now',
            route:
              'https://www.creative-tim.com/product/vue-argon-dashboard-pro?ref=vadp',
            color: 'success',
          },
        ],
      }"
    />
  </div>
    
  </template>