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
<nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
    <div class="container">
        <!-- Logo à gauche -->
        <router-link class="navbar-brand font-weight-bolder ms-lg-0 ms-3" :class="darkMode ? 'text-black' : 'text-white'" to="/">
            <img src="@/assets/img/logos/nextgenerabar.png" alt="logo" class="navbar-logo" />
        </router-link>
        <!-- Bouton de basculement pour le menu -->
        <button class="navbar-toggler p-0 border-0 ms-auto" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Contenu du menu aligné à droite -->
        <div class="navbar-collapse offcanvas-collapse justify-content-end">
            <!-- Liens d'inscription et de connexion -->
            <span class="nav-item">
                <router-link to="/register" class="btn-outline-sm orange">Inscription</router-link>
            </span>
            <span class="nav-item">
                <router-link to="/login" class="btn-solid-sm">Connexion</router-link>
            </span>
    
           
        </div>
    </div>
</nav>

  <div id="features" class="accordion-1">
   <div class="container">
       <div class="row">
           <div class="col-xl-12">
               <h2 class="h2-heading">Laboratoires de Chimie</h2>
               <p class="p-heading"> Cet atelier offre aux enfants âgés de 9 à 12 ans une expérience immersive dans le monde de la chimie. À travers une série d'expériences pratiques et amusantes, les participants découvrent les réactions chimiques, les propriétés des éléments et les applications de la chimie dans la vie quotidienne, tout en développant leur esprit critique et leur sens de l'observation.</p>
           </div> 
       </div>   
       <div class="row">
           <div class="col-xl-5">
               <div class="accordion" id="accordionExample">
                   
                  
                   <div class="accordion-item">
                       <div class="accordion-icon">
                           <span class="fas fa-tv"></span>
                       </div> 
                       <div class="accordion-header" id="headingOne">
                        <h5>   <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              Domaine d'activité : Sciences / Éducation
                           </button></h5>
                       </div>
                      <!-- <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                           <div class="accordion-body">Mauris ornare libero et pharetra hendrerit. Cura elementum lectus quis tellus pretium, vitae lobortis dui sagittis aliquam et enim vel semon anticus</div>
                       </div>-->
                   </div>
                  
                  
                   <div class="accordion-item">
                       <div class="accordion-icon blue">
                           <span class="fas fa-tools"></span>
                       </div> 
                       <div class="accordion-header" id="headingTwo">
                        <h5> <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              Type d'activité : Laboratoire
                           </button></h5>
                       </div>
                       
                   </div>
                  
                  
                   <div class="accordion-item">
                       <div class="accordion-icon orange">
                           <span class="fas fa-flag"></span>
                       </div> 
                       <div class="accordion-header" id="headingThree">
                        <h5><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Initier les enfants à la magie des éléments chimiques et des réactions, à travers des expériences ludiques et interactives.                           </button></h5>
                       </div>
                       
                   </div>
                  
                   
                  
                   <div class="accordion-item">
                       <div class="accordion-icon orange">
                           <span class="fas fa-flag"></span>
                       </div> 
                       <div class="accordion-header" id="headingFour">
                        <h5><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Enseigner aux enfants les bases de la chimie, comme la structure de la matière...                            </button></h5>
                       </div>
                       
                   </div>
                   <div class="accordion-item">
                       <div class="accordion-icon orange">
                           <span class="fas fa-flag"></span>
                       </div> 
                       <div class="accordion-header" id="headingFour">
                        <h5><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Sensibiliser les enfants aux bonnes pratiques de sécurité en laboratoire et à l'importance de préserver notre environnement en évitant les substances nocives.     </button></h5>                 
                       </div>
                   </div>
                   <div class="accordion-item">
                       <div class="accordion-icon blue">
                           <span class="fas fa-info"></span>
                       </div> 
                       <div class="accordion-header" id="headingTwo" style="color:white">
                             <h5>
                              Age maximum: 12 <hr>
                              Age minimum: 9 <hr>
                              Nombre de séance par semaine:1 <hr>
                              Effectif maximum : 8 <hr>
                                Effectif minimum : 5 <hr>
                                Effectif actuel :6 <hr>
                                Tarif : 500 MAD <hr>
                                Statut : Actif <hr>
                            </h5>
                            <iframe width="560" height="315" src="https://youtu.be/BldE3YslCgo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                       </div>
                   </div>
                  
               </div> 
           </div> 
           <div class="col-xl-7">
               <div class="image-container">
                   <img class="img-fluid" src="assets/images/labchimie.png" alt="alternative"/>
               </div> 
           </div> 
       </div>
   </div> 
 </div> 
</template>

<style>

</style>