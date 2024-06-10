<template>
    <div class="card ">
      <div class="card-header pb-0 px-3">
        <h4 class="mb-2 text-center">Les activités affectés à l'animateur</h4>
      </div>
      <div class="card-body  pt-4 p-3 text-center justify-content-center align-items-center"> 
        <table class="table table-bordered align-items-center ">
            <thead >
              <tr>
                <th
                  class="text-uppercase text-secondary opacity-7"
                >
                  Atelier/Laboratoire
                </th>
                <th
                  class="text-uppercase text-secondary opacity-7"
                >
                  Domaine d'activité
                </th>
                <th
                  class="text-uppercase text-secondary opacity-7"
                >
                  Effectif actuel
                </th>
                <th
                  class="text-center  text-secondary  opacity-7"
                >
                  Supprimer
                </th>
                
                <th class="text-secondary opacity-7"> Editer</th>
                
              </tr>
            </thead>
            
            
            <tbody>
                
        <tr v-for="(activity, index) in affectes" :key="index"  class="  p-4 mb-2 bg-gray-100  border-radius-lg ">
            <td >
              <h6 class="mb-2 text-center"><router-link :to="activity.path" class="read-more no-line" style="color:#000080;" >{{activity.title}}</router-link></h6>
              
            </td> 
            <td class="text-center">  
              <span class=" text-s">
                {{activity.domaine}}
              </span>
            </td> 
            <td class="text-center">  
              <span class=" text-s">
                {{activity.Effectif}}
              </span>
            </td> 
             <td class="text-center">  
              <a
                class="btn btn-link text-danger text-gradient px-3 mb-0"
                href="javascript:;"
              >
                <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
              </a>
              </td>
            
              <td class="align-middle">
            <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;">
              <argon-button><router-link to="/dashboard-animateurs/Horaires/Editer"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i
              ></router-link></argon-button>
            </a>
            </td>
        </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  <style scoped>
  h4{
    font-family: Georgia, 'Times New Roman', Times, serif;
    color:orange;
  }
  
    
  th{
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    color:#000080;
  }
  span{
    font-family:Georgia, 'Times New Roman', Times, serif;
    

  }
  </style>

<script>
export default {
  data() {
    return {
      affectes: [
        {
          path:"/Programmation",
          title: "Atelier de Programmation",
          domaine: "informatique ", 
          Effectif: "10",
        },
        {
          path:"/IA",
          title: "Atelier d'intelligence",
          domaine: "informatique ", 
          Effectif: "15",
        },
        {
          path:"/Robotique",
          title: "Atelier de Robotique",
          domaine: "technologique ", 
          Effectif: "9",
        },
        {
          path:"/CalculMental",
          title: "Atelier de calcul mental",
          domaine: "informatique ", 
          Effectif: "20",
        },
        {
          path:"/Labchimie",
          title: "Laboratoire de chimie",
          domaine: "informatique ", 
          Effectif: "10",
        },
        {
          path:"/LabBiologie",
          title: "Laboratoire de biologie",
          domaine: "Science ", 
          Effectif: "10",
        },
        {
          path:"/Echecs",
          title: "Jeux d'échecs",
          domaine: "informatique ", 
          Effectif: "10",
        },
      

      ]
    };
  }
}; 
//  <script>
//    import axiosInstance from '@/main';

//     export default {
//       data() {
//         return {
//           getActivites: []
//         }},
      
//         async created(){
//           try {
//           let response = await axiosInstance.get("animateur/activites");
//           this.getActivites= response.data;
//           console.log(response.data);
//         }
//         catch (error) {
//       console.error('Erreur lors de récupération des activites:', error);
//     }
//     },
//     methods: {
//     async deleteActivities(horaire_id, index) {

//       try {
//         this.horaires.splice(index, 1); // Supprime l'entrée du tableau local
//         await axiosInstance.delete("animateur/horaires/"+horaire_id); // Remplacez par l'URL correcte
        
//       } catch (error) {
//         console.error('Erreur lors de la suppression de l\'animateur:', error);
//       }}}}
  
   
   
//     </script>-->
