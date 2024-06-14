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
               <h2 class="h2-heading">Atelier de Programmation</h2>
               <p class="p-heading">Un atelier interactif de programmation destiné aux adolescents de 14 à 17 ans, conçu pour les initier aux bases du codage et de la logique informatique. Les participants apprendront à créer des programmes simples, développeront leur esprit analytique et leur créativité, et travailleront sur des projets concrets en groupe. Cet atelier offre une introduction pratique et ludique aux concepts de programmation, préparant les jeunes à résoudre des problèmes complexes et à poursuivre leur apprentissage technologique.</p>
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
                              Domaine d'activité : Informatique
                           </button></h5>
                       </div>
                   </div>
                  
                  
                   <div class="accordion-item">
                       <div class="accordion-icon blue">
                           <span class="fas fa-tools"></span>
                       </div> 
                       <div class="accordion-header" id="headingTwo">
                        <h5> <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              Type d'activité : Atelier
                           </button></h5>
                       </div>
                       
                   </div>


                  
                  
                   <div class="accordion-item">
                       <div class="accordion-icon orange">
                           <span class="fas fa-flag"></span>
                       </div> 
                       <div class="accordion-header" id="headingThree">
                        <h5><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Permettre aux adolescents d'acquérir des compétences avancées en programmation à travers des projets pratiques et des défis stimulants.                           </button></h5>
                       </div>
                       
                   </div>
                  
                   
                  
                   <div class="accordion-item">
                       <div class="accordion-icon orange">
                           <span class="fas fa-flag"></span>
                       </div> 
                       <div class="accordion-header" id="headingFour">
                        <h5><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Préparer les adolescents à des carrières dans les domaines de la technologie en leur fournissant des compétences pratiques et une compréhension approfondie des principes fondamentaux de la programmation.                           </button></h5>
                       </div>
                       
                   </div>


                   <div class="accordion-item">
                       <div class="accordion-icon blue">
                           <span class="fas fa-info"></span>
                       </div> 
                       <div class="accordion-header" id="headingTwo" style="color:white">
                        <!-- <h5> <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> -->
                            <h5 >  
                            Age maximum: 17 <hr>
                              Age minimum: 14 <hr>
                              Nombre de séance par semaine:2 <hr>
                              Effectif maximum : 15 <hr>
                                Effectif minimum : 10 <hr>
                                Effectif actuel :12 <hr>
                                Tarif : 600 MAD <hr>
                                Statut : Actif <hr>
                               
                           </h5>
                           <iframe width="560" height="315" src="https://www.youtube.com/embed/iZmRz9nBy9U" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <!-- </button>-->
                       </div>
                   </div>

                   <!-- <div class="accordion-item">
                       <div class="accordion-icon orange">
                        <span class="fa-brands fa-youtube"></span>
                       </div> 
                       <div class="accordion-header" id="headingFour">
                        <h5><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                         <link href="https://youtu.be/iZmRz9nBy9U">   
                            </button>
                            lien youtube 
                            </h5>
                       </div> 
                   </div>-->

                  
               </div> 
           </div> 
           <div class="col-xl-7">
               <div class="image-container">
                   <img class="img-fluid" src="assets/images/Programmation.png" alt="alternative"/>
               </div> 
           </div> 
       </div>
   </div> 
 </div> 
</template>

<style>

</style>