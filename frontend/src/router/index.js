import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "../views/Dashboard.vue";
import Dashboardanim from "../views/DashboardAnim.vue";
import Dashboardparents from "../views/DashboardParents.vue"
//import utilisateurs from "../views/utilisateurs.vue";
import Administrateurs from "../views/Administrateurs.vue";
import Animateurs from "../views/Animateurs.vue";
import Parents from "../views/Parents.vue";
import Offres from "../views/offres.vue";
import Activites from "../views/Activites.vue";
import Demandes from "../views/Demandes.vue";
import RTL from "../views/Rtl.vue";
import Profile from "../views/Profile.vue";
import Signup from "../views/Signup.vue";
import Signin from "../views/Signin.vue";
import Home from "../Home.vue";
import Forget from "../views/Forget.vue";
import Reset from "../views/Reset.vue";




import Programmation from "../views/Description/Programmation.vue";
import IA from "../views/Description/IA.vue";
import Robotique from "../views/Description/Robotique.vue";
import CalculMental from "../views/Description/CalculMental.vue";
import LabChimie from "../views/Description/LabChimie.vue";
import LabBiologie from "../views/Description/LabBiologie.vue";
import Echecs from "../views/Description/Echecs.vue";




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
  },
  {
    path: "/dashboard-admin/Administrateurs",
    name: "administrateurs",
    component: Administrateurs,
  },
  {
    path: "/dashboard-admin/Animateurs",
    name: "animateurs",
    component: Animateurs,
  },
  {
    path: "/dashboard-admin/Parents",
    name: "parents",
    component: Parents,
  },
  {
    path: "/dashboard-admin/Offres",
    name: "Offres",
    component: Offres,
  },
  {
    path: "/dashboard-admin/Activites",
    name: "Activites",
    component: Activites,
  },
  {
    path: "/dashboard-admin/Demandes",
    name: "Demandes",
    component: Demandes,
  },
  {
    path: "/dashboard-admin/rtl-page",
    name: "RTL",
    component: RTL,
  },
  {
    path: "/dashboard-admin/profile",
    name: "Profile",
    component: Profile,
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
  },
  {
    path:"/dashboard-parents",
    name:"Dashboardparents",
    component:Dashboardparents,
  },
  
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
  linkActiveClass: "active",
});

export default router;
