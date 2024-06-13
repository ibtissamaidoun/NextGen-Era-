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
        <!-- <li class="nav-item">
        <sidenav-item
          to="/dashboard-admin"
          :class="getRoute() === 'dashboard-admin' ? 'active' : ''"
          :navText="isRTL ? 'لوحة القيادة' : 'Dashboard'"
        >
          <template v-slot:icon>
            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li> -->



      <li class="nav-item">
        <sidenav-item
          to="/dashboard-admin/Admins"
          :class="getRoute() === 'Administrateurs' ? 'active' : ''"
          :navText="isRTL ? 'الواقع الافتراضي' : 'Administrateurs'"
        >
          <template v-slot:icon>
            <i class="ni ni-bold-right text-warning text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          to="/dashboard-admin/Animateurs"
          :class="getRoute() === 'Animateurs' ? 'active' : ''"
          :navText="isRTL ? 'الواقع الافتراضي' : 'animateurs'"
        >
          <template v-slot:icon>
            <i class="ni ni-bold-right text-primary text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          to="/dashboard-admin/Parents"
          :class="getRoute() === 'Parents' ? 'active' : ''"
          :navText="isRTL ? 'الواقع الافتراضي' : 'Parents'"
        >
          <template v-slot:icon>
            <i class="ni ni-bold-right text-warning text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>

      <li class="nav-item">
        <sidenav-item
          to="/dashboard-admin/Horaires"
          :class="getRoute() === 'HorairesAdmin' ? 'active' : ''"
          :navText="isRTL ? 'الواقع الافتراضي' : 'HorairesAdmin'"
        >
          <template v-slot:icon>
            <i class="ni ni-time-alarm text-primary text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          to="/dashboard-admin/Offres"
          :class="getRoute() === 'Offres' ? 'active' : ''"
          :navText="isRTL ? 'الجداول' : 'Offres'"
        >
          <template v-slot:icon>
            <i
              class="ni ni-planet text-warning text-sm opacity-10"
            ></i>
          </template>
        </sidenav-item>
      </li>
      <li class="nav-item">
        <sidenav-item
          to="/dashboard-admin/AvailablesActivites"
          :class="getRoute() === 'AvailablesActivites' ? 'active' : ''"
          :navText="isRTL ? 'الواقع الافتراضي' : 'Activités disponibles'"
        >
          <template v-slot:icon>
            <i class="ni ni-check-bold text-primary text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>

      <li class="nav-item">
        <sidenav-item
          to="/dashboard-admin/Activites"
          :class="getRoute() === 'Activites' ? 'active' : ''"
          :navText="isRTL ? 'الجداول' : 'Activites'"
        >
          <template v-slot:icon>
            <i
              class="ni ni-spaceship text-warning text-sm opacity-10"
            ></i>
          </template>
        </sidenav-item>
      </li>

      <li class="nav-item">
        <sidenav-item
          to="/dashboard-admin/Enfants"
          :class="getRoute() === 'Enfants' ? 'active' : ''"
          :navText="isRTL ? 'الواقع الافتراضي' : 'Enfants'"
        >
          <template v-slot:icon>
            <i class="ni ni-badge text-primary text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>


      <li class="nav-item">
        <sidenav-item
          to="/dashboard-admin/Demandes"
          :class="getRoute() === 'Demandes' ? 'active' : ''"
          :navText="isRTL ? 'الواقع الافتراضي' : 'Demandes'"
        >
          <template v-slot:icon>
            <i class="ni ni-books text-warning text-sm opacity-10"></i>
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
          :class="getRoute() === 'login' ? 'active' : ''"
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