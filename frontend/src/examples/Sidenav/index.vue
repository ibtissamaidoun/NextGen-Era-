<script setup>
import { computed } from "vue";
import { useStore } from "vuex";
import SidenavList from "./SidenavList.vue";
import logo from "@/assets/img/logos/nextgenera.png";
import logoWhite from "@/assets/img/logos/nextgenera.png";

const store = useStore();
const isRTL = computed(() => store.state.isRTL);
const layout = computed(() => store.state.layout);
const sidebarType = computed(() => store.state.sidebarType);
const darkMode = computed(() => store.state.darkMode);
</script>
<template>
  <!-- <div
    v-show="layout === 'default'"
    class="min-height-300 position-absolute w-100"
    :class="`${darkMode ? 'bg-transparent' : 'bg-success'}`"
  /> -->

  <aside
    class="my-3 overflow-auto border-0 sidenav  navbar-vertical navbar-expand-xs border-radius-xl"
    :class="`${isRTL ? 'me-3 rotate-caret fixed-end' : 'fixed-start ms-3'}    
      ${
        layout === 'landing' ? 'bg-transparent shadow-none' : ' '
      } ${sidebarType}`"
    id="sidenav-main"
  >
    <div class="sidenav-header">
       <i
        class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
        aria-hidden="true"
        id="iconSidenav"
      ></i> 

    <router-link class=" navbar-brand d-flex justify-content-center align-items-center" to="/">
    <img 
      :src="darkMode || sidebarType === 'bg-default' ? logoWhite : logo"
      class="navbar-brand-img h-100"
      alt="main_logo"
    />
    </router-link>
    </div>

    <!-- <hr class="mt-0 horizontal dark" /> -->

    <sidenav-list />
  </aside>
</template>

