<script setup>
/* eslint-disable */
import { onBeforeUnmount, onBeforeMount } from "vue";
import { useStore } from "vuex";
import { ref } from "vue";
import { useRouter } from 'vue-router'; // Importer le routeur Vue Router

//import axios from "axios";
import axiosInstance from '@/axios-instance';


import Navbar from "@/examples/PageLayout/Navbar.vue";
import AppFooter from "@/examples/PageLayout/Footer.vue";
import ArgonInput from "@/components/ArgonInput.vue";
import ArgonCheckbox from "@/components/ArgonCheckbox.vue";
const body = document.getElementsByTagName("body")[0];
const user = ref ({
  nom : "",
  prenom : "",
  email : "",
  telephone_portable : "",
  telephone_fixe : "",
  mot_de_passe : "",
  mot_de_passe_confirmation : ""
})

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
const HandleSubmit = async (e)=>{
  e.preventDefault()
  console.log(user.value)
  const response = await axiosInstance.post("/register",user.value);
  if(response.status == 202){
    sessionStorage.setItem('token', response.data.token);
    
    router.push('/login'); 
  }
  
  console.log(response)
}



</script>
<template>
 <div class="container top-0 position-sticky z-index-sticky">
    <div class="row">
      <div class="col-12">
       <!-- <navbar/>-->

<navbar/>



      </div>
    </div>
  </div>
  <main class="main-content">
    <div
      class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
      style=" background-image: url(https://miro.medium.com/v2/resize:fit:1400/format:webp/1*OU6gcmWMHaDjOj_EdFmbJA.jpeg); background-position: top; background-size: 60%;">
     <span class="mask bg-gradient-dark opacity-6"></span>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-center pt-4">
              <h5>Inscription</h5>
            </div>
           
            <div class="card-body">
              <form role="form" @submit="HandleSubmit">
                <argon-input id="nom" type="text" placeholder="Nom" aria-label="Nom" v-model="user.nom" />
                <argon-input  id="prenom"  type="text"  placeholder="Prénom"  aria-label="Prénom"  v-model="user.prenom"/>
                <argon-input id="tele"  type="text"  placeholder="Numéro de téléphone" aria-label="Numéro de téléphone" v-model="user.telephone_portable"/>
                <argon-input id="tele" type="text" placeholder="Numéro de fixe" aria-label="Numéro de fixe" v-model="user.telephone_fixe"/>
                <argon-input id="email" type="email"  placeholder="Email" aria-label="Email" v-model="user.email"/>
                <argon-input  id="password" type="password" placeholder="Mot de passe"  aria-label="Mot de passe" v-model="user.mot_de_passe"/>
                <argon-input id="password_confirmation" name="mot_de_passe_confirmation" type="password" placeholder="Confirmez le mot de passe" aria-label="Confirmez le mot de passe" v-model="user.mot_de_passe_confirmation"/>
                <argon-checkbox checked>
                  <label class="form-check-label" for="flexCheckDefault">J'accepte les <router-link to="/Conditions" class="text-dark font-weight-bolder">Conditions Générales d'Utilisation</router-link>
                  </label>
                </argon-checkbox>
                <div class="text-center">
                    <button class="text-white font-weight-bolder" style="background-color: #000080; color: #fff;  border: none; border-radius: 5px;  margin-top:5%;  padding: 8px; width:100%;" >S'inscrire</button>
                </div>
                <p class="text-sm mt-3 mb-0">
                  Avez-vous déjà un compte?
                  <router-link to="/login" class="text-dark font-weight-bolder">se connecter</router-link>
                </p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <app-footer />
</template>