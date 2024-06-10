<template>
    <div class="card ">
      <div class="card-header pb-0 px-3">
        <h4 class="mb-2 text-center">Mes enfants</h4>
      </div>
      <div class="card-body px-0 pt-0 pb-2" style="padding:100%">
        <div class="table-responsive p-0">
        <table class="table table-bordered align-items-center ">
            <thead >
              <tr>
                <th
                  class="text-uppercase text-secondary opacity-7"
                >
                  Nom
                </th>
                <th
                  class="text-uppercase text-secondary opacity-7"
                >
                  Prénom
                </th>
                <th
                  class="text-uppercase text-secondary opacity-7"
                >
                  Date de naissance
                </th>
                <th
                  class="text-uppercase  text-secondary  opacity-7"
                >
                  Niveau d'étude 
                </th>
                <th class="text-secondary opacity-7"> supprimer</th>

                
                <th class="text-secondary opacity-7"> Editer</th>
                <th class="text-secondary opacity-7"> Détails</th>
                
              </tr>
            </thead>
            
            
            <tbody>
                
        <tr v-for="(activity, index) in affectes" :key="index"  class="  p-4 mb-2 bg-gray-100  border-radius-lg ">
            <td class="text-center">  
              <span class=" text-s">
                {{activity.nom}}
              </span>
            </td> 
            <td class="text-center">  
              <span class=" text-s">
                {{activity.prenom}}
              </span>
            </td> 
            <td class="text-center">  
              <span class=" text-s">
                {{activity.date_de_naissance}}
              </span>
            </td> 
            <td class="text-center">  
              <span class=" text-s">
                {{activity.niveau_etude}}
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
              <argon-button><router-link to="/dashboard-parents/Enfants/Editer"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i
              ></router-link></argon-button>
            </a>
            </td>
            <td class="text-center">  
              <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;">
                <argon-button><router-link to="/dashboard-parents/Enfants/Edt">Edt</router-link></argon-button>
            </a>
            </td>
        </tr>
          </tbody>
        </table>
      </div>
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
    nom: "Deckow",
    prenom: "Bethel",
    date_de_naissance: "2009-01-01",
    niveau_etude: "College"
    },
    {
    nom: "Deckow",
    prenom: "Bethel",
    date_de_naissance: "2009-01-01",
    niveau_etude: "College"
    },
    {
    nom: "Deckow",
    prenom: "Bethel",
    date_de_naissance: "2009-01-01",
    niveau_etude: "College"
    },

      ]
    };
  }
};
</script>