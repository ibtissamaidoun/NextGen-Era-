<script setup>
//import Vue from 'vue';
// import BootstrapVue from 'bootstrap-vue';

// Vue.use(BootstrapVue);


import { ref, onBeforeUnmount, onBeforeMount } from "vue";
import { useStore } from "vuex";
import ArgonInput from "@/components/ArgonInput.vue";
import axiosInstance from "@/axios-instance"; 

const store = useStore();
const email = ref('');
//const refresh_token=ref('');
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
// const token=ref('');
const recoverPassword = async () => {
  
  
// if (!refresh_token.value) {
//     alert("Token est requis pour la récupération de mot de passe."); console.log('safaa', refresh_token.value);
//     return;
//   }
  try {
    
    console.log("Envoi de la requête avec email:", email.value);
    const response = await axiosInstance.post('/forget', { email: email.value });
    console.log(response.data.message); 
    
  } catch (error) {
    if (error.response && error.response.data) {
      alert(error.response.data.message);
    } else {
      alert("Erreur de réseau ou réponse non structurée");
    }
  }
 };
</script>
<template >
    <div class="box">
    <h3>Récupération de votre mot de passe</h3>
  
    <div class="mb-3">
      <argon-input v-model="email" type="email" id="email"  placeholder="Email" name="email" size="lg"/>

    </div>
   <div class="d-grid gap-2">
   
    <button class='lien' @click="recoverPassword" style="text-align: center"  data-bs-target="#collapseFour"  type="button" data-bs-toggle="collapse"  aria-expanded="false" aria-controls="collapseFour">Récupérer</button>
  
  </div>
  <!--<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">-->
     <!-- <div class="accordion-body">Veuillez vérifier votre boîte e-mail pour les instructions de récupération de mot de passe</div> -->
  </div>
  <!--</div>-->  
  </template>
  <style >
  body{
    background-color: grey;
  }
  h2{
   
      color:#000080;
      font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
      margin-top:5%;
      width: 100%;
      
      
  }
  
  
  .box input{
      width: 100%;
      height: 50px;
      padding: 25px;
      display: block;
      margin-bottom: 20px;
      margin-right: auto;
      margin-left: auto;
      margin-top: 10%;
      border-radius: 10px;
      border: 1px solid #000080; 
      
      
  }
  .box{
    position: fixed center;
      width: 30%;
      margin: 150px auto;
      background-color: rgb(255, 255, 255); /* Orange semi-transparent */
      padding: 50px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      -moz-box-align: center;
  }
  .lien{
      display:block;
      text-decoration: none;
      padding: 10px;
      background-color: #000080 ; 
      color: #fff;
      border: none;
      height: 50px;
      margin-bottom: 20px;
      margin-right:0%;
      margin-left: 0%;
      margin-top: 4%;
      border-radius: 5px; 
  
  }
  </style>