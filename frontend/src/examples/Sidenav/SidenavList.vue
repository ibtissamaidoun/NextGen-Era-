<template>
    <div>
      
      <sidenav-list-admin v-if="currentRoute === 'dashboard-admin'" />
      <sidenav-list-animateurs v-else-if="currentRoute === 'dashboard-animateurs'" />
      <sidenav-list-parents v-if="currentRoute === 'dashboard-parents'" />
      
      
    </div>
  </template>
  
  <script setup>
  import { ref, watch } from "vue";
  import { useRoute } from "vue-router";
 
  import SidenavListAnimateurs from "./SidenavListAnimateurs.vue";
  import SidenavListAdmin from "./SidenavListAdmin.vue";
  import SidenavListParents from "./SidenavListParents.vue";



  const currentRoute = ref("");
  const route = useRoute();
  
  watch(() => route.path, (newVal) => {
    const routeArr = newVal.split("/");
    currentRoute.value = routeArr[1];
  });
  </script>
  