<script setup>
/* eslint-disable */
import { onBeforeUnmount, onBeforeMount } from "vue";
import { useStore } from "vuex";
import { ref } from "vue";
import { useRouter } from 'vue-router'; // Importer le routeur Vue Router

//import axios from "axios";
import axiosInstance from '@/axios-instance';


import Navbar from "@/examples/PageLayout/Navbar.vue";

const body = document.getElementsByTagName("body")[0];


const store = useStore();
onBeforeMount(() => {
  store.state.hideConfigButton = true;
  store.state.showNavbar = false;
  store.state.showSidenav = false;
  store.state.showFooter = false;
  body.classList.remove("bg-gray-100");
});
onBeforeUnmount(() => {
  store.state.hideConfigButton = false;
  store.state.showNavbar = true;
  store.state.showSidenav = true;
  store.state.showFooter = true;
  body.classList.add("bg-gray-100");
});
const router = useRouter();





</script>
<template>
    <div class="conditions">
      <h1 class="text-center" style="color:orange; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Conditions d'Utilisation</h1>
      
      
        <h2>1. Inscription et Utilisation</h2>
        <h5>En inscrivant votre enfant sur notre plateforme, vous acceptez ces conditions d'utilisation. Vous devez être le parent ou le tuteur légal de l'enfant que vous inscrivez.</h5>
        
        <h2>2. Responsabilité Parentale</h2>
        <h5>Vous êtes responsable de toute activité effectuée par votre enfant sur notre plateforme. Assurez-vous de surveiller l'utilisation que fait votre enfant de notre application.</h5>
        
        <h2>3. Protection des Données</h2>
        <h5>Nous respectons la confidentialité et la sécurité des données de votre enfant conformément à notre politique de confidentialité. Nous ne collectons que les informations nécessaires pour assurer le bon fonctionnement de notre service.</h5>
        
        <h2>4. Contenu Approprié</h2>
        <h5>Notre plateforme est conçue pour les enfants âgés entre 6 et 17 ans. Le contenu disponible est adapté à cet âge et est régulièrement examiné pour assurer sa pertinence.</h5>
        
        <h2>5. Communication</h2>
        <h5>Nous pouvons communiquer avec vous par le biais de notifications ou d'e-mails concernant l'utilisation de notre application par votre enfant.</h5>
        
        <h2>6. Modifications des Conditions</h2>
        <h5>Nous nous réservons le droit de mettre à jour ou de modifier ces conditions d'utilisation à tout moment. Les changements seront communiqués via notre site web ou par d'autres moyens appropriés.</h5>
     
    </div>
  </template>
  <style scoped>
  h2{
    color: #000080;
    font-family: Arial, Helvetica, sans-serif;
  }
  p{
    font-family:'Times New Roman', Times, serif;
  }
  </style>
  