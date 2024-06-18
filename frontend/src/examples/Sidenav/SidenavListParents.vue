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
          to="/dashboard-parents/Enfants"
          :class="getRoute() === 'Enfants' ? 'active' : ''"
          navText="Enfants"
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
          navText="Activités"
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
          navText="Demandes"
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
          navText="Offres"
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
          class="text-xs ps-4 text-uppercase font-weight-bolder opacity-6"
        >
          ACCOUNT PAGES
        </h6>
      </li>

      <li class="nav-item">
        <sidenav-item
          to="/dashboard-parents/profile"
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
          :class="getRoute() === 'Déconnexion' ? 'active' : ''"
          navText="Déconnexion"
        >
          <template v-slot:icon>
            <i class="ni ni-single-copy-04 text-danger text-sm opacity-10"></i>
          </template>
        </sidenav-item>
      </li>

      
    </ul>
  </div>    
  </template>