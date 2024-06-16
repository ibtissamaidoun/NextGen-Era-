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
               <h2 class="h2-heading">Atelier d'Intelligence Artificielle</h2>
               <p class="p-heading">Un atelier interactif en intelligence artificielle pour adolescents de 14 à 17 ans, visant à les initier aux principes de base de l'IA et de l'apprentissage automatique. Les participants exploreront les concepts fondamentaux de l'IA, concevront leurs premiers modèles simples, et développeront leurs compétences analytiques et critiques. Cet atelier offre une introduction pratique et ludique aux technologies avancées, préparant les jeunes à intégrer l'intelligence artificielle dans des projets concrets et innovants.</p>
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
                              Domaine d'activité : Informatique / Technologie
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
                            Introduire les concepts fondamentaux de l'intelligence artificielle de manière accessible et ludique pour les adolescents.                           </button></h5>
                       </div>
                       
                   </div>
                  
                   
                  
                   <div class="accordion-item">
                       <div class="accordion-icon orange">
                           <span class="fas fa-flag"></span>
                       </div> 
                       <div class="accordion-header" id="headingFour">
                        <h5><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Renforcer les compétences pour les jeunes entre 14 et 17 ans en permettant de créer et de comprendre des algorithmes d'intelligence artificielle.                           </button></h5>
                       </div>
                       
                   </div>

                   <div class="accordion-item">
                       <div class="accordion-icon orange">
                           <span class="fas fa-flag"></span>
                       </div> 
                       <div class="accordion-header" id="headingFour">
                        <h5><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Sensibiliser les adolescents aux enjeux éthiques et sociaux de l'IA, les encourageant à réfléchir de manière critique sur son impact sur la société et le monde.</button></h5>
                       
                    </div>
                   </div>

                   <div class="accordion-item">
                       <div class="accordion-icon blue">
                           <span class="fas fa-info"></span>
                       </div> 
                       <div class="accordion-header" id="headingTwo" style="color:white">
                             <h5>
                              Age maximum: 17 <hr>
                              Age minimum: 14 <hr>
                              Nombre de séance par semaine:1 <hr>
                              Effectif maximum : 13 <hr>
                                Effectif minimum : 9 <hr>
                                Effectif actuel :8 <hr>
                                Tarif : 700 MAD <hr>
                                Statut : Inactif <hr>
                            </h5>
                            <iframe width="560" height="315" src="https://youtu.be/yruaGbh5W04" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                       </div>
                   </div>
                  
               </div> 
           </div> 
           <div class="col-xl-7">
               <div class="image-container">
                   <img class="img-fluid" src="assets/images/IA.png" alt="alternative"/>
               </div> 
           </div> 
       </div>
   </div> 
 </div> 
</template>

<style>

</style>