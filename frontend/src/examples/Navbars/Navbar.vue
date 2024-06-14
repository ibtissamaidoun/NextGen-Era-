<template>
  <div>
    
    <Navbar-animateurs v-if="currentRoute === 'dashboard-animateurs'" />
    <Navbar-admin v-else-if="currentRoute === 'dashboard-admin'" />
    <Navbar-parents v-else-if="currentRoute === 'dashboard-parents'" />
    
    
  </div>
</template>

<script setup>
import { ref,watch} from "vue";
import { useRoute } from "vue-router";

import NavbarAdmin from "./NavbarAdmin.vue";
import NavbarAnimateurs from "./NavbarAnimateurs.vue";
import NavbarParents from "./NavbarParents.vue";
const currentRoute = ref("");
const route = useRoute();

watch(() => route.path, (newVal) => {
  const routeArr = newVal.split("/");
  currentRoute.value = routeArr[1];
});
</script>
