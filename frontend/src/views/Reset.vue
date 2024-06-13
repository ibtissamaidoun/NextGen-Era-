<script setup>
import { ref, onBeforeUnmount, onBeforeMount } from "vue";
import { useStore } from "vuex";
import ArgonInput from "@/components/ArgonInput.vue";
import { useRouter } from 'vue-router';
import axiosInstance from "@/main"; // Assurez-vous que le chemin est correct
const router = useRouter();
const store = useStore();
const password = ref('');
const confirmPassword = ref('');
const token = ref('');
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
 // Récupérez ce token plus sécuritairement, peut-être via des props ou un store Vuex


const resetPassword = async () => { 
  //  if (!token.value) {
  //   alert("Le token de réinitialisation est requis.");
  //   return;
  // }
  ////
  try {
    console.log('safaa');
    const response = await axiosInstance.post('/reset', {
      mot_de_passe: password.value,
      mot_de_passe_confirmation: confirmPassword.value,
      token: token.value
      
    });
    
    console.log('safaa',response);
    alert(response.data.message);
    console.log('safaa',response);
    router.push('/login');
  } catch (error) { 
    //alert(error.response?.data?.message || "Erreur de réseau");
    
  }
};
</script>

<template >
    <div class="box">
    <h3>Réinitialiser votre mot de passe</h3>
  
    <div class="mb-3" >
      <argon-input v-model="password" id="password" type="password" placeholder="Mot de passe" name="password" size="lg" />
      <argon-input v-model="confirmPassword"
                  id="password_confirmation" name="mot_de_passe_confirmation" type="password"
                  placeholder="Confirmez le mot de passe" aria-label="Confirmez le mot de passe"
                />
    </div>


   <h5>
    <router-link class='lien' @click="resetPassword" style="text-align: center" to="/login" >Rénitialiser</router-link>
  </h5>
    </div>
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