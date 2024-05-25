import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "../views/Dashboard.vue";
import Dashboardanim from "../views/DashboardAnim.vue";
import Dashboardparents from "../views/DashboardParents.vue"
import AvailablesActivites from "@/views/AvailableActivites.vue";

//import utilisateurs from "../views/utilisateurs.vue";
import Administrateurs from "../views/Administrateurs.vue";
import DetailsAdmin from "@/views/components/DetailsAdmin.vue";
import Animateurs from "../views/Animateurs.vue";
import DetailsAnim from "@/views/components/DetailsAnim.vue";
import Parents from "../views/Parents.vue";
import DetailsParents from "@/views/components/DetailsParents.vue"
import HorairesAdmin from "../views/HorairesAdmin.vue";
import Offres from "../views/offres.vue";
import Activites from "../views/Activites.vue";
import DetailsActivites from "@/views/components/DetailsActivites.vue";
import Demandes from "../views/Demandes.vue";
import RTL from "../views/Rtl.vue";
import Profile from "../views/Profile.vue";
import Paiement from "../views/Paiement.vue";
import Enfants from "@/views/Enfants.vue";
import DetailsEnfants from "@/views/components/DetailsEnfants.vue"


import Signup from "../views/Signup.vue";
import Signin from "../views/Signin.vue";
import Home from "../Home.vue";
import Forget from "../views/Forget.vue";
import Reset from "../views/Reset.vue";

import Horaires from "@/views/Horaires.vue";
import Edt from "@/views/Edt.vue";
import Activitesanim from "@/views/Activitesanim.vue"


import Programmation from "../views/Description/Programmation.vue";
import IA from "../views/Description/IA.vue";
import Robotique from "../views/Description/Robotique.vue";
import CalculMental from "../views/Description/CalculMental.vue";
import LabChimie from "../views/Description/LabChimie.vue";
import LabBiologie from "../views/Description/LabBiologie.vue";
import Echecs from "../views/Description/Echecs.vue";

import store from '@/store'

function requireAuth(role) {
  return function(to, from, next) {
    if (!store.getters['auth/authenticated']) {
      return next({ name: 'Signin' });
    }
    const user = store.getters['auth/user'];
    if (user.type !== role) {
      return next({ name: 'NotFound2' });
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
    path: "/dashboard-admin",
    name: "Dashboard",
    component: Dashboard,
    beforeEnter: requireAuth('admin')
  },
  
  {
    path: "/dashboard-admin/Administrateurs",
    name: "administrateurs",
    component: Administrateurs,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Administrateurs/Details",
    name: "DetailsAdmin",
    component: DetailsAdmin,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Animateurs",
    name: "animateurs",
    component: Animateurs,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Animateurs/Details",
    name: "DetailsAnim",
    component: DetailsAnim,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Parents",
    name: "parents",
    component: Parents,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Parents/Details",
    name: "DetailsParents",
    component: DetailsParents,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Horaires",
    name: "HorairesAdmin",
    component: HorairesAdmin,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Offres",
    name: "Offres",
    component: Offres,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Activites",
    name: "Activites",
    component: Activites,
    beforeEnter: requireAuth('admin')
  },
  {
  path: "/dashboard-admin/Activites/Details",
  name: "DetailsActivites",
  component: DetailsActivites,
  beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Demandes",
    name: "Demandes",
    component: Demandes,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/AvailablesActivites",
    name: "AvailablesActivites",
    component: AvailablesActivites,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Enfants",
    name: "Enfants",
    component: Enfants,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Enfants/Details",
    name: "DetailsEnfants",
    component: DetailsEnfants,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/Paiement",
    name: "Paiement",
    component: Paiement,
    beforeEnter: requireAuth('admin')
  },



  {
    path: "/dashboard-admin/rtl-page",
    name: "RTL",
    component: RTL,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/dashboard-admin/profile",
    name: "Profile",
    component: Profile,
    beforeEnter: requireAuth('admin')
  },
  {
    path: "/signin",
    name: "Signin",
    component: Signin,
  },
  {
    path: "/signup",
    name: "Signup",
    component: Signup,
  },
  {
    path:"/Forget",
    name:"Forget",
    component: Forget,
  },
  {
    path:"/Reset",
    name:"Reset",
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
    path:"/CalculMental",
    name:"CalculMental",
    component:CalculMental,
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
  //dashboard-animateurs:
  {
    path:"/dashboard-animateurs",
    name:"Dashboardanim",
    component:Dashboardanim,
    beforeEnter: requireAuth('animateur')
  },
  {
    path:"/dashboard-animateurs/Horaires",
    name:"Horaires",
    component:Horaires,
    beforeEnter: requireAuth('animateur')
  },
  {
    path:"/dashboard-animateurs/Edt",
    name:"Edt",
    component:Edt,
    beforeEnter: requireAuth('animateur')
  },
  {
    path:"/dashboard-animateurs/Activites",
    name:"Activitesanim",
    component:Activitesanim,
    beforeEnter: requireAuth('animateur')
  },


  //dashboard-parents:
  {
    path:"/dashboard-parents",
    name:"Dashboardparents",
    component:Dashboardparents,
    beforeEnter: requireAuth('parent')
  },
  
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
  linkActiveClass: "active",
});

export default router;
