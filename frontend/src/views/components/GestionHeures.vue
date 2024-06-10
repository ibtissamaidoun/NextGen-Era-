<template>
    <div class="card ">
      <div class="card-header pb-0 px-3">
        <h4 class="mb-2 text-center">La gestion des heures</h4>
      </div>
      <div class="card-body  pt-4 p-3 text-center justify-content-center align-items-center"> 
        <table class="table table-bordered align-items-center ">
            <thead >
              <tr>
                 <th
                 class="text-uppercase text-secondary opacity-7"
                >
                  Heure début
                </th>
                <th
                  class="text-uppercase text-secondary opacity-7"
                >
                  Heure fin
                </th> 
                <th
                  class="text-uppercase text-secondary opacity-7"
                >
                  Jour de semaine
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
              <h6 class="mb-2 text-center">{{activity.heuredebut}}</h6>
              
            </td> 
            <td class="text-center">  
              <h6 class="mb-2 text-center">
                {{activity.heurefin}}
              </h6>
            </td> 
            <td class="text-center">  
              <h6 class="mb-2 text-center">
                {{activity.joursemaine}}
              </h6>
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
              <argon-button><router-link to="/dashboard-admin/Horaires/Editer"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i
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
  h6{
    
    color:#000080;
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
          heuredebut: "21:00",
          heurefin: "22:30 ", 
          joursemaine: "Lundi",
        },
        {
          heuredebut: "16:30",
          heurefin: "18:00 ", 
          joursemaine: "Vendredi",
        },
        {
          heuredebut: "21:00",
          heurefin: "22:30 ", 
          joursemaine: "Mardi",
        },
        {
          heuredebut: "9:00",
          heurefin: "10:30 ", 
          joursemaine: "Mardi",
        },
        {
          heuredebut: "10:30",
          heurefin: "12:00 ", 
          joursemaine: "Samedi",
        },
      

      ]
    };
  }
};
</script>