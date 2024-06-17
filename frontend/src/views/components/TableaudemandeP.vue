<template>
  <div class="card">
    <div class="card-header pb-0 px-3">
      <h4 class="mb-2 text-center">Demandes de parent</h4>
    </div>
    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center"> 
      <table class="table table-bordered align-items-center">
        <thead>
          <tr>
            <th class="text-uppercase text-primary opacity-7">
              Id
            </th>
            <th class="text-uppercase text-primary opacity-7">
              Statut
            </th>
            <th class="text-uppercase text-primary opacity-7">
              Date de demandes
            </th>
            <th class="text-center text-primary opacity-7">
            Supprimer
          </th>
          
            
          </tr>
        </thead>
        <tbody>
          <tr v-for="(activity, index) in affectes" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
            <td>
              <h6 class="mb-2 text-center">{{ activity.id }}</h6>
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ activity.statut }}</span>
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ activity.date_demande }}</span>
            </td> 
            
            <td class="text-center">  
            <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"  @click="deleteDemande(activity.id, index)">
              <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
            </a>
          </td>
          
        </tr>
        </tbody>
      </table>
    </div>

    
  </div>



</template>

<script>
/* eslint-disable */
import ArgonButton from '@/components/ArgonButton.vue';
import axiosInstance from '@/axios-instance';

export default {
  data() {
    return {
      affectes: [],
    };
  },
  components: {
  ArgonButton,
},
created() {
  this.fetchDemandes();
},


methods: {
  async fetchDemandes() {
    try {
      const response = await axiosInstance.get('/dashboard-parents/Demandes');
      this.affectes = response.data.demandes;
    } catch (error) {
      console.error('Error fetching demandes:', error);
    }
  },


  async deleteDemande(demande_id, index) {
    try {
      const response = await axiosInstance.delete(`/dashboard-parents/Demandes/${demande_id}/delete`);
      this.affectes.splice(index, 1);
      console.log('Demandes supprimé');
    } catch (error) {
      console.error('Erreur lors de la suppression de l\'Demandes:', error);
      alert('Erreur lors de la suppression de l\'Demandes: ' + (error.response ? error.response.data.message : error.message));
    }
  }


},

  
}
</script>

<style scoped>
h4 {
  font-family: Georgia, 'Times New Roman', Times, serif;
  color: orange;
}

th {
  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  color: #000080;
}

span {
  font-family: Georgia, 'Times New Roman', Times, serif;
}
</style>