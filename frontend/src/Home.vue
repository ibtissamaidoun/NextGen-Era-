<script>
import { onBeforeUnmount, onBeforeMount, } from "vue";
import { useStore } from "vuex"; 

export default {
  setup() {
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

    return {
    };
  },
};
</script>


<template>
  <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation" >
   <div class="container">
    <router-link
        class="navbar-brand font-weight-bolder ms-lg-0 ms-3"
        :class="darkMode ? 'text-black' : 'text-white'"
        to="/"
        >
        <img src="@/assets/img/logos/nextgenerabar.png" alt="logo" class="navbar-logo "  />
        </router-link>
       <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
       </button>
       <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
           <ul class="navbar-nav ms-auto navbar-nav-scroll">
               <li class="nav-item">
                   <a class="nav-link active" aria-current="page" href="#header">Accueil</a>
               </li>
               <li class="nav-item">

                   <a class="nav-link" href="#services">Activités</a>



               </li>
               <li class="nav-item">
                   <a class="nav-link" href="#contact">Contact Us</a>
               </li>
               <li class="nav-item dropdown">
                   <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">Plus d'infos</a>
                   <ul class="dropdown-menu" aria-labelledby="dropdown01">
                       
                       <li><a class="dropdown-item" href="#">Conditions Générales</a></li>
                       <li><div class="dropdown-divider"></div></li>
                       <li><a class="dropdown-item" href="#">Politique de Confidentialité</a></li>
                   </ul>
               </li>
           </ul>
           <span class="nav-item">
               <router-link to="/login" class="btn-solid-sm" >Connexion</router-link>
           </span>
       </div> 
   </div> 
 </nav>
 <header id="header" class="header">
   <div class="container">
       <div class="row">
           <div class="col-lg-1 col-xl-5">
               <div class="text-container">
                   <h1 class="h1-large" style="margin-top: -20%">The Next Generation Era</h1>
                   <p class="p-large">Engagez vos enfant dans les meilleurs activités d'excellence académique avec The Next Generation Era.</p>
                   <a class="btn-solid-lg" href="#services">Activités </a>
               </div>
           </div> 
           <div class="col-lg-6 col-xl-7">
               <div class="image-container">
                   <img class="img-fluid" src="assets/images/header-image__.png" alt="alternative" />
               </div> 
           </div> 
       </div> 
   </div> 
 </header> 
 <div id="services" class="cards-1 bg-gray">
  <div class="container">
      <div class="row">
          <div class="col-lg-12">
              <h2  style="text-align: center">Découvrez nos Activités</h2>
          </div> 
      </div>
      <div class="row">
          <div class="col-lg-12 ">
              <div class="card ">
                  <div class="card-body">
                    <h4 class="card-title" style="color: #000080;" >Programmation</h4>
                        <p style="padding:10%"> Apprenez les bases de la programmation et développez des compétences en codage à travers des projets passionnants.</p>
                        <router-link to="/Programmation" class="read-more no-line" >Lire Plus<span class="fas fa-long-arrow-alt-right"></span></router-link>
                  </div>
              </div>
          
              <div class="card ">
                  <div class="card-body">
                    <h4 class="card-title" style="color: #000080;" >Intelligence Artificielle</h4>
                        <p style="padding:10%"> Explorez le monde fascinant de l'intelligence artificielle et apprenez à développer des applications intelligentes.</p>
                        <router-link to="/IA" class="read-more no-line" >Lire Plus<span class="fas fa-long-arrow-alt-right"></span></router-link>
                      </div>
              </div>
            
              <div class="card ">
                  <div class="card-body"><h4 class="card-title" style="color: #000080;" >Robotique pour les débutants</h4>
                        <p style="padding:10%"> Plongez dans le domaine de la robotique en apprenant à concevoir, construire et programmer des robots.</p>
                        <router-link to="/Robotique" class="read-more no-line" >Lire Plus<span class="fas fa-long-arrow-alt-right"></span></router-link>
                  </div>
              </div>
              <div class="card ">
                  <div class="card-body"><h4 class="card-title" style="color: #000080;" >Robotique avancé</h4>
                        <p style="padding:10%"> Plongez dans le domaine de la robotique en apprenant à concevoir, construire et programmer des robots.</p>
                        <router-link to="/RobotiqueAvance" class="read-more no-line" >Lire Plus<span class="fas fa-long-arrow-alt-right"></span></router-link>
                  </div>
              </div>

              <div class="card">
                  <div class="card-body"><h4 class="card-title" style="color: #000080;" >Calcul mental pour les débutants</h4>
                        <p style="padding:10%">  Améliorez vos compétences en calcul mental à travers des exercices ludiques et stimulants.</p>
                        <router-link to="/CalculMental" class="read-more no-line" >Lire Plus<span class="fas fa-long-arrow-alt-right"></span></router-link>
                  </div>
              </div>
              <div class="card">
                  <div class="card-body"><h4 class="card-title" style="color: #000080;" >Calcul mental avancé</h4>
                        <p style="padding:10%">  Améliorez vos compétences en calcul mental à travers des exercices ludiques et stimulants.</p>
                        <router-link to="/CalculMentalAvance" class="read-more no-line" >Lire Plus<span class="fas fa-long-arrow-alt-right"></span></router-link>
                  </div>
              </div>

              <div class="card">
                  <div class="card-body"><h4 class="card-title" style="color: #000080;" >Laboratoires de Chimie</h4>
                        <p style="padding:10%"> Explorez les principes fondamentaux de la chimie à travers des expériences pratiques et des démonstrations.</p>
                        <router-link to="/LabChimie" class="read-more no-line" >Lire Plus<span class="fas fa-long-arrow-alt-right"></span></router-link>
                  </div>
              </div>

              <div class="card ">
                  <div class="card-body"><h4 class="card-title" style="color: #000080;" >Laboratoires de Biologie</h4>
                        <p style="padding:10%"> Découvrez le monde fascinant de la biologie à travers des expériences de laboratoire et des observations.</p>
                        <router-link to="/LabBiologie" class="read-more no-line" >Lire Plus<span class="fas fa-long-arrow-alt-right"></span></router-link>
                  </div>
              </div>

              <div class="card">
                  <div class="card-body"><h4 class="card-title" style="color: #000080;" >Jeux d'échecs pour débutants</h4>
                        <p style="padding:10%"> Apprenez les règles du jeu d'échecs et développez des compétences stratégiques et tactiques.</p>
                        <router-link to="/Echecs" class="read-more no-line" >Lire Plus<span class="fas fa-long-arrow-alt-right"></span></router-link>
                  </div>
              </div>

              <div class="card">
                  <div class="card-body"><h4 class="card-title" style="color: #000080;" >Jeux d'échecs avancé</h4>
                        <p style="padding:10%"> Apprenez les règles du jeu d'échecs et développez des compétences stratégiques et tactiques.</p>
                        <router-link to="/EchecsAvance" class="read-more no-line" >Lire Plus<span class="fas fa-long-arrow-alt-right"></span></router-link>
                  </div>
              </div>
              
          </div>
      </div>
  </div>
</div>

 <div id="details" class="basic-1">
   <div class="container">
       <div class="row">
           <div class="col-lg-6 col-xl-7">
               <div class="image-container">
                   <img class="img-fluid" src="assets/images/details-1_.png" alt="alternative" />
               </div> 
           </div> 
           <div class="col-lg-6 col-xl-5">
               <div class="text-container">
                   <div class="section-title">CE QUE NOUS FAISONS</div>
                   <h2>Guidés par nos animateurs, vos enfants s'épanouissent</h2>
                   <p>NextGen ERA, spécialisée dans l'accompagnement et l'éclosion des potentiels chez les enfants, vous offre une opportunité unique d'inscrire vos enfants à une variété d'activités soigneusement conçues pour favoriser leur croissance, leur confiance en soi et leur succès futur. Nous offrons un éventail d'options pour répondre aux besoins uniques de chaque enfant. Rejoignez-nous dans cette aventure transformative où chaque pas est guidé par la passion de voir vos enfants s'épanouir et atteindre leur plein potentiel.</p>
                   <a class="btn-solid-reg" href="#contact" style="margin-top: -5%">Restez Informés!</a>
               </div> 
           </div> 
       </div>
   </div> 
 </div>
 <div class="basic-2">
   <div class="container">
       <div class="row">
           <div class="col-lg-6 col-xl-5">
               <div class="text-container">
                   <div class="section-title">SUR NOUS</div>
                   <h2>Dix ans d'expérience au service de votre enfant</h2>
                   <p>Avec des années d'expérience dans le coaching et le développement personnel pour enfants, nous sommes passionnés par l'accompagnement des jeunes dans leur parcours vers la réussite. 
                    Faites confiance à notre expertise pour guider votre enfant vers un avenir brillant et épanouissant.</p>
                   <router-link to="/register" class="btn-outline-reg" >Inscription</router-link>
               </div> 
           </div> 
           <div class="col-lg-6 col-xl-7">
               <div class="image-container">
                   <img class="img-fluid" src="assets/images/details-2-.png" alt="alternative" />
               </div> 
           </div> 
       </div>
   </div> 
 </div> 

 <div class="slider-1">
   <div class="container">
       <div class="row">
           <div class="col-lg-12">
               <h4>Ils nous ont fait confiance</h4>
               <hr class="section-divider" />
            
               <div class="slider-container">
                   <div class="swiper-container image-slider">
                       <div class="swiper-wrapper">
                           <div class="swiper-slide">
                               <img class="img-fluid" src="assets/images/customer-logo-1_.png" alt="alternative" />
                           </div>
                           <div class="swiper-slide">
                               <img class="img-fluid" src="assets/images/customer-logo-2_.png" alt="alternative" />
                           </div>
                           <div class="swiper-slide">
                               <img class="img-fluid" src="assets/images/customer-logo-3_.png" alt="alternative" />
                           </div>
                           <div class="swiper-slide">
                               <img class="img-fluid" src="assets/images/customer-logo-4_.png" alt="alternative" />
                           </div>
                           <div class="swiper-slide">
                               <img class="img-fluid" src="assets/images/customer-logo-5_.png" alt="alternative" />
                           </div>
                           <div class="swiper-slide">
                               <img class="img-fluid" src="assets/images/customer-logo-6_.png" alt="alternative" />
                           </div>
                       </div>
                   </div> 
               </div> 
              
           </div> 
       </div>
   </div> 
 </div> 
 ]
 <div class="basic-3">
   <div class="container">
       <div class="row">
           <div class="col-lg-12">
               <div class="text-container">
                   <h2>Découvrez Nos Activités Enrichissantes</h2>
                   <p class="p-large">Explorez notre gamme d'activités pour stimuler la croissance et le développement de votre enfant</p>
                   <a class="btn-solid-lg" href="#contact">Restez Informés!</a>
               </div> 
           </div> 
       </div>
   </div> 
 </div> 
 <div id="contact" class="form-1">
   <div class="container">
       <div class="row">
           <div class="col-lg-6">
               <div class="text-container">
                   <div class="section-title">Restez Informés!</div>
                   <h2>Soumettre le formulaire </h2>
                   <h6>Rejoignez notre communauté et restez informé ! Inscrivez-vous dès maintenant pour recevoir les dernières mises à jour, offres exclusives et actualités passionnantes directement dans votre boîte de réception. Ne manquez jamais une occasion de découvrir nos nouveautés et de profiter de nos promotions spéciales. Rejoignez-nous dès aujourd'hui et restez connecté avec tout ce qui se passe dans notre univers !</h6>
               </div> 
           </div> 
           <div class="col-lg-6">
              
               <form>
                   <div class="form-group">
                       <input type="text" class="form-control-input" style="margin-top:20% ;" placeholder="Nom Complet" required />
                   </div>
                   
                   <div class="form-group">
                       <input type="email" class="form-control-input" placeholder="Email" required />
                   </div>
                   
                   
                   <div class="form-group">
                       <button type="submit" style="margin-top:2%" class="form-control-submit-button">Soumettre</button>
                   </div>
               </form>
             
           </div> 
       </div>
   </div> 
 </div>
 <div class="footer bg-gray">
   <img class="decoration-circles" src="assets/images/decoration-circles.png" alt="alternative" />
   <div class="container">
       <div class="row">
           <div class="col-lg-12">
               <h4>Si vous souhaitez découvrir plus sur NextGen ERA, suivez-nous.</h4>
               <div class="social-container">
                   <span class="fa-stack">
                       <a href="#your-link">
                           <i class="fas fa-circle fa-stack-2x"></i>
                           <i class="fab fa-facebook-f fa-stack-1x"></i>
                       </a>
                   </span>
                   <span class="fa-stack">
                       <a href="#your-link">
                           <i class="fas fa-circle fa-stack-2x"></i>
                           <i class="fab fa-twitter fa-stack-1x"></i>
                       </a>
                   </span>
                   
                   <span class="fa-stack">
                       <a href="#your-link">
                           <i class="fas fa-circle fa-stack-2x"></i>
                           <i class="fab fa-instagram fa-stack-1x"></i>
                       </a>
                   </span>
                   <span class="fa-stack">
                       <a href="#your-link">
                           <i class="fas fa-circle fa-stack-2x"></i>
                           <i class="fab fa-youtube fa-stack-1x"></i>
                       </a>
                   </span>
               </div> 
           </div> 
       </div>
   </div> 
 </div> 
 <div class="copyright bg-gray">
   <div class="container">
       <div class="row">
           <div class="col-lg-6 col-md-12 col-sm-12">
               <ul class="list-unstyled li-space-lg p-small">
                   <li><a href="#">Conditions Générales</a></li>
                   <li><a href="#">Politique de Confidentialité</a></li>
               </ul>
               <div class="card-icon green">
                      <span class="far fa-comments">  Contact Us</span>
                  </div>
               <ul class="list-unstyled li-space-lg p-small">    
                   <li><p class="p-small statement">+212618293546</p></li>
               </ul>
               <ul class="list-unstyled li-space-lg p-small">
                   <li><p class="p-small statement">nextgenera10@gmail.com</p></li>
               </ul>
           </div> 
          
           <div class="col-lg-3 col-md-12 col-sm-12">
               <p class="p-small statement">Copyright © <a href="#">NextGen ERA</a></p>
           </div> 
           <div class="col-lg-3 col-md-12 col-sm-12">
               <p class="p-small statement">Distribué par <router-link to="/" target="_blank">NextGen ERA</router-link></p>
           </div> 
       </div> 
   </div> 
 </div>
 <button id="myBtn">
   <img src="assets/images/up-arrow.png" alt="alternative" />
 </button>
 </template>
 
 
 
 <style>
 #Home {
   font-family: Avenir, Helvetica, Arial, sans-serif;
   -webkit-font-smoothing: antialiased;
   -moz-osx-font-smoothing: grayscale;
   text-align: center;
   color: #2c3e50;
   margin-top: 60px;
 }
 .card-body{
    text-align: center;
    flex:1;
 }
.col-lg-12{
    text-align: center;
    /* display: flex;
    flex-wrap: wrap;
    justify-content: center; */
}

.text-container{
    text-align: center;

}
.d-flex {
    display: flex;
  }
  
.flex-fill {
flex: 1;
}
.cards-1 .card .card-body {
  flex: 1 1 calc(33.333% - 20px); /* Ajustez cette valeur en fonction du nombre de colonnes que vous voulez */
    margin: 10px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
}
 </style>
