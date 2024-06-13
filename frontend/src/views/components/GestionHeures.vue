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
              
      <tr v-for="(horaires, index) in affectes" :key="index"  class="  p-4 mb-2 bg-gray-100  border-radius-lg ">
          <td >
            <h6 class="mb-2 text-center">{{horaires.heure_debut}}</h6>
            
          </td> 
          <td class="text-center">  
            <h6 class="mb-2 text-center">
              {{horaires.heure_fin}}
            </h6>
          </td> 
          <td class="text-center">  
            <h6 class="mb-2 text-center">
              {{horaires.jour_semaine}}
            </h6>
          </td> 
           <td class="text-center">  
            <a
              class="btn btn-link text-danger text-gradient px-3 mb-0"
              @click="deleteHoraire(horaires.id)"
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
import axiosInstance from '@/axios-instance';

export default {
data() {
  return {
    affectes: [],
  };
},
mounted() {
  this.fetchHoraires();
},
methods: {
  async fetchHoraires() {
    try {
      const response = await axiosInstance.get('/dashboard-admin/Horaires');
      this.affectes = response.data;
    } catch (error) {
      console.error('Error fetching horaires:', error);
    }
  },
  async deleteHoraire(id) {
    try {
      await axiosInstance.delete(`/dashboard-admin/Horaires/${id}`);
      this.affectes = this.affectes.filter(horaire => horaire.id !== id);
    } catch (error) {
      console.error('Error deleting horaire:', error);
    }
  },
},
};
</script>