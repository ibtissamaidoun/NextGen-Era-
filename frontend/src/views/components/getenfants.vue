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
              
      <tr v-for="(enfant, index) in enfants" :key="index"  class="  p-4 mb-2 bg-gray-100  border-radius-lg ">
          <td class="text-center">  
            <span class=" text-s">
              {{enfant.nom}}
            </span>
          </td> 
          <td class="text-center">  
            <span class=" text-s">
              {{enfant.prenom}}
            </span>
          </td> 
          <td class="text-center">  
            <span class=" text-s">
              {{enfant.date_de_naissance}}
            </span>
          </td> 
          <td class="text-center">  
            <span class=" text-s">
              {{enfant.niveau_etude}}
            </span>
          </td> 
           <td class="text-center">  
            <a
              class="btn btn-link text-danger text-gradient px-3 mb-0"
              href="javascript:;"
              @click="deleteEnfant(enfant.id)"
            >
              <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
            </a>
            </td>
          
            <td class="align-middle">
          <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;">
          <argon-button>
              <router-link :to="`/dashboard-parents/Enfants/Editer/${enfant.id}`" ><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i
            ></router-link>
          </argon-button>
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
  <div v-if="deleteSuccess" class="alert alert-success" role="alert" style="position: absolute; top: 0; left: 0; right: 0; z-index: 1000;">
    Enfant supprimé avec succès!
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
import axiosInstance from '@/axios-instance';

export default {
data() {
  return {
    enfants: [],
    deleteSuccess: false
  };
},
mounted() {
  axiosInstance.get('/dashboard-parents/Enfants')
    .then(response => {
      this.enfants = response.data.enfants;
      console.log('Enfants chargés:', this.enfants);
    })
    .catch(error => {
      console.error('Erreur lors de la récupération des enfants:', error);
      alert('Erreur lors de la récupération des données: ' + (error.response ? error.response.data.message : error.message));
    });
},
methods: {
  deleteEnfant(enfantId) {
    axiosInstance.delete(`/dashboard-parents/Enfants/${enfantId}`)
      .then(response => {
        console.log('Enfant supprimé:', response.data);
        this.enfants = this.enfants.filter(enfant => enfant.id !== enfantId);
        this.deleteSuccess = true;
        setTimeout(() => {
          this.deleteSuccess = false;
        }, 3000);
      })
      .catch(error => {
        console.error('Erreur lors de la suppression de l\'enfant:', error);
        alert('Erreur lors de la suppression de l\'enfant: ' + (error.response ? error.response.data.message : error.message));
      });
  }
}
};
</script>