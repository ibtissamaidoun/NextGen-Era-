<script setup>
import { onBeforeUnmount, onBeforeMount } from "vue";
import { useStore } from "vuex";



const store = useStore();
onBeforeMount(() => {
  store.state.hideConfigButton = true;
  store.state.showNavbar = false;
  store.state.showSidenav = false;
  store.state.showFooter = false;

});
onBeforeUnmount(() => {
  store.state.hideConfigButton = false;
  store.state.showNavbar = true;
  store.state.showSidenav = true;
  store.state.showFooter = true;

});
</script>

<template>
    <div class="box">
      <h4> Veuillez vérifier votre boîte e-mail pour les instructions de récupération de mot de passe</h4>
    </div>
</template>

<style scoped>
  .box{
    position: fixed center;
      width: 30%;
      margin: 150px auto;
      background-color: lightblue; 
      padding: 50px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      -moz-box-align: center;
  }
</style>