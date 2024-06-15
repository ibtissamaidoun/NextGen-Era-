<script setup>
import { useRoute } from "vue-router";
import SidenavItem from "./SidenavItem.vue";

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
          to="/dashboard-admin/Admins"
          :class="getRoute() === 'Administrateurs' ? 'active' : ''"
          navText="Administrateurs"
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
        navText="animateurs"
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
          navText="Parents"
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
          navText="HorairesAdmin"
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
          navText="Offres"
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
          navText="Activités disponibles"
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
          navText="Activités"
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
          navText="Enfants"
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
          navText="Demandes"
        >
          <template v-slot:icon>
            <i class="ni ni-books text-warning text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>

      

      

      

      <li class="mt-3 nav-item">
        <h6
          class="text-xs ps-4 text-uppercase font-weight-bolder opacity-6"
        >
          ACCOUNT PAGES
        </h6>
      </li>

      <li class="nav-item">
        <sidenav-item
          to="/dashboard-admin/profile"
          :class="getRoute() === 'profile' ? 'active' : ''"
          navText="Profile"
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

    
  </template>