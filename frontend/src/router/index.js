import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "../views/Admin/Dashboard.vue";
import Dashboardanim from "../views/Animateur/DashboardAnim.vue";
import Dashboardparents from "../views/Parent/DashboardParents.vue"

//dashboard-admin
import AvailablesActivites from "@/views/Admin/AvailableActivites.vue";
import Administrateurs from "../views/Admin/Administrateurs.vue";
import DetailsAdmin from "@/views/components/DetailsAdmin.vue";
import Animateurs from "../views/Admin/Animateurs.vue";
import DetailsAnim from "@/views/components/DetailsAnim.vue";
import Parents from "../views/Admin/Parents.vue";
import DetailsParents from "@/views/components/DetailsParents.vue";
import EditerHoraires from "@/views/components/Edithoraire.vue";
import HorairesAdmin from "../views/Admin/HorairesAdmin.vue";
import EditerOffre from "@/views/components/Editoffre.vue";
import Offres from "../views/Admin/offres.vue";
import Activites from "../views/Admin/Activites.vue";
import Editeractivite from "../views/components/Editactivites.vue";
import DetailsActivites from "@/views/components/DetailsActivites.vue";
import Demandes from "../views/Admin/Demandes.vue";
import DemandePayment from "../views/components/DemandePayement.vue"
import Profile from "../views/Admin/Profile.vue";
import DetailsEnfants from "@/views/components/DetailsEnfants.vue";

//authentification
import Signup from "../views/Authentification/Signup.vue";
import Signin from "../views/Authentification/Signin.vue";
import Home from "../Home.vue";
import Forget from "../views/Authentification/Forget.vue";
import Reset from "../views/Authentification/Reset.vue";

//dashboard-anim
import Horaires from "@/views/Animateur/Horaires.vue";
import EditerHorairesanim from "@/views/components/Edithoraireanim.vue";
import Edt from "@/views/Animateur/Edt.vue";
import Activitesanim from "@/views/Animateur/Activitesanim.vue";
import Editaffectsanim from "@/views/components/Editaffectsanim.vue";
import Profileanim from "@/views/Animateur/Profileanim.vue";
import ActiviteParent from "@/views/Parent/ActiviteParent.vue";
import Activitedetails from "@/views/components/Activitedetails.vue";

//dashboard-parent
import EnfantsParents from "@/views/Parent/EnfantsParents.vue";
import edtenfants from "@/views/components/edtenfants.vue";
import Editenfant from "@/views/components/Editenfant.vue";
import ActivitesParents from "@/views/Parent/ActivitesParents.vue";
import DemandesP from "@/views/Parent/DemandesParents.vue";
import Cart from "@/views/Parent/Cart.vue";
import pack from "@/views/Parent/PackParents.vue";
import devis from "@/views/Parent/Devis.vue";
import facture from "@/views/Parent/Factures.vue";
import overview from "@/views/Parent/overview.vue";
import Offresparents from "@/views/Parent/offresParents.vue";
import Enfants from "@/views/Parent/Enfants.vue";
import Profileparent from "@/views/Parent/Profileparent.vue";
import OffreDetails from "@/views/Parent/OffreDetails.vue";
import AccessDenied from "@/views/components/AccessDenied";

//description
import Programmation from "../views/Description/Programmation.vue";
import IA from "../views/Description/IA.vue";
import Robotique from "../views/Description/Robotique.vue";
import RobotiqueAvance from "@/views/Description/RobotiqueAvance.vue";
import CalculMental from "../views/Description/CalculMental.vue";
import CalculMentalAvance from "@/views/Description/CalculMentalAvance.vue";
import LabChimie from "../views/Description/LabChimie.vue";
import LabBiologie from "../views/Description/LabBiologie.vue";
import Echecs from "../views/Description/Echecs.vue";
import EchecsAvance from "../views/Description/EchecsAvance.vue";


import store from '@/store'

function requireAuth(role) {
  return function(to, from, next) {
    console.log('Is Authenticated :' ,store.getters.isAuthenticated);
    console.log('User Role :', store.getters.userRole)
    if (!store.getters.isAuthenticated) {
      return next({ name: 'Signin' });
    }
    if (store.getters.userRole !== role) {
      return next({ name: 'AccessDenied' });
    }
    next();
    
  };
}



const routes = [

  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: '/access-denied',
    name: 'AccessDenied',
    component: AccessDenied,
  },
  {
    path: "/dashboard-admin",
    name: "Dashboard",
    component: Dashboard,
    beforeEnter: requireAuth('admin')
  },
  {
      path: "/dashboard-admin/admins",
      name: "administrateurs",
      component: Administrateurs,
    //  beforeEnter: requireAuth('admin')
    
  },

  {
    path: '/dashboard-admin/admins/details/:adminId',
    name: "DetailsAdmin",
    component: DetailsAdmin,
   // beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Animateurs",
    name: "animateurs",
    component: Animateurs,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/animateurs/details/:animateurId",
    name: "DetailsAnim",
    component: DetailsAnim,
    //beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Parents",
    name: "parents",
    component: Parents,
    //beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/parents/details/:parentId",
    name: "DetailsParents",
    component: DetailsParents,
   // beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Horaires",
    name: "HorairesAdmin",
    component: HorairesAdmin,
   // beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Horaires/Editer/:heureId",
    name: "EditerHoraires",
    component: EditerHoraires,
  },
  {
    path: "/dashboard-admin/offres",
    name: "Offres",
    component: Offres,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/offres/Editer/:id",
    name: "EditerOffre",
    component: EditerOffre,
   // beforeEnter: requireAuth('admin')
  },

  {
    path: "/dashboard-admin/Activites",
    name: "Activites",
    component: Activites,
   // beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Activites/Editer",
    name: "Editeractivite",
    component: Editeractivite,
   // beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Activites/Details/:id",
    name: "DetailsActivites",
    component: DetailsActivites,
    props: true  // Assurez-vous que props est true pour passer l'ID comme prop
 // beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Demandes",
    name: "Demandes",
    component: Demandes,
   // beforeEnter: requireAuth('admin')
  },
  { path: "/dashboard-admin/Demandes/:demandeId/paye",
    name: "DemandePayment",
    component: DemandePayment,
    props: true
   // beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/AvailablesActivites",
    name: "AvailablesActivites",
    component: AvailablesActivites,
  //  beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Enfants",
    name: "Enfants",
    component: Enfants,
   // beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/enfants/details/:enfantId",
    name: "DetailsEnfants",
    component: DetailsEnfants,
   // beforeEnter: requireAuth('admin')
  },
  



  {
    path: "/dashboard-admin/profile",
    name: "Profile",
    component: Profile,
   // beforeEnter: requireAuth('admin')
  },
  {
    path: "/login",
    name: "login",
    component: Signin,
  },
  {
    path: "/register",
    name: "register",
    component: Signup,
  },
  {
    path:"/forget",
    name:"Forget",
    component: Forget,
  },
  {
    path:"/reset",
    name:"reset",
    component: Reset,
  },
  
  {
    path:"/Programmation",
    name:"Programmation",
    component:Programmation,
  },
  {
    path:"/IA",
    name:"intelligenceArtificielle",
    component:IA,
  },
  {
    path:"/Robotique",
    name:"Robotique",
    component:Robotique,
  },
  {
    path:"/RobotiqueAvance",
    name:"RobotiqueAvance",
    component:RobotiqueAvance,
  },
  {
    path:"/CalculMental",
    name:"CalculMental",
    component:CalculMental,
  },
  {
    path:"/CalculMentalAvance",
    name:"CalculMentalAvance",
    component:CalculMentalAvance,
  },
  {
    path:"/LabChimie",
    name:"LabChimie",
    component:LabChimie,
  },
  {
    path:"/LabBiologie",
    name:"LabBiologie",
    component:LabBiologie,
  },
  {
    path:"/Echecs",
    name:"Echecs",
    component:Echecs,
  },
  {
    path:"/EchecsAvance",
    name:"EchecsAvance",
    component:EchecsAvance,
  },



  //dashboard-animateurs:
  {
    path:"/dashboard-animateurs",
    name:"Dashboardanim",
    component:Dashboardanim,
   // beforeEnter: requireAuth('animateur')
  },
  {
    path:"/dashboard-animateurs/Horaires",
    name:"Horaires",
    component:Horaires,
  },
  {
    path: "/dashboard-animateurs/Horaires/Editer/:heureId",
    name:"EditerHorairesanim",
    component:EditerHorairesanim,
  },
  {
    path:"/dashboard-animateurs/Edt",
    name:"Edt",
    component:Edt,
  },
  {
    path:"/dashboard-animateurs/Activites",
    name:"Activitesanim",
    component:Activitesanim,
  },
  {
    path:"/dashboard-animateurs/Activites/Details/:id",
        name:"Activitedetails",
    component:Activitedetails,
  },
  {
    path:"/dashboard-animateurs/Activites/Editer",
    name:"Editaffectsanim",
    component:Editaffectsanim,
  },
  {
    path: "/dashboard-animateurs/profile",
    name: "Profileanim",
    component: Profileanim,
  },


  //dashboard-parents:
  {
    path:"/dashboard-parents",
    name:"Dashboardparents",
    component:Dashboardparents,
  },
  {
    path:"/dashboard-parents/Enfants",
    name:"EnfantsParents",
    component:EnfantsParents,
  },
  {
    path:"/dashboard-parents/Enfants/Edt",
    name:"edtenfants",
    component:edtenfants,
  },
  {
    path:'/dashboard-parents/Enfants/Editer/:id',
    name:"Editenfant",
    component:Editenfant,
  },
  {
    path:"/dashboard-parents/Activites",
    name:"ActivitesParents",
    component:ActivitesParents,
  },
  {
    path:"/dashboard-parents/Activites/:id",
    name:"ActiviteDetail",
    component:ActiviteParent,
  },
  {
    path:"/dashboard-parents/Demandes",
    name:"DemandesP",
    component:DemandesP,
  },
  {
    path:"/dashboard-parents/Cart",
    name:"Cart",
    component:Cart,
  },
  {
    path:"/dashboard-parents/Demandes/:demandeId/pack",
    name:"pack",
    component:pack,
  },
  {
    path:"/dashboard-parents/Demandes/:demandeId/Devis",
    name:"devis",
    component:devis,
  },
  {
    path:"/dashboard-parents/Demandes/:demandeId/facture",
    name:"facture",
    component:facture,
  },
  {
    path:"/dashboard-parents/Demandes/overview",
    name:"overview",
    component:overview,
  },
  {
    path:"/dashboard-parents/Offres",
    name:"Offresparents",
    component:Offresparents,
  },
  {
    path: "/dashboard-parents/profile",
    name: "Profileparent",
    component: Profileparent,
  },
  {
    path:"/dashboard-parents/Offres/:id",
    name:"OffreDetails",
    component: OffreDetails,
    props: true
  },
  
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
  linkActiveClass: "active",
});

export default router;