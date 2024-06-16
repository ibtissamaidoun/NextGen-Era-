<template>
  <div class="card">
    <div class="card-header pb-0 px-3">
      <h4 class="mb-2 text-center">La gestion des enfants</h4>
    </div>
    
    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center"> 
      <table class="table table-bordered align-items-center">
        <thead>
          <tr>
            <th class="text-uppercase text-primary opacity-7">
              Id
            </th>
            <th class="text-uppercase text-primary opacity-7">
              Nom
            </th>
            <th class="text-uppercase text-primary opacity-7">
              Prénom
            </th>
            <th class="text-center text-primary opacity-7">
              Détails
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(enfant, index) in this.enfants" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
            <td>
              <h6 class="mb-2 text-center">{{ enfant.id }}</h6>
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ enfant.nom }}</span>
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ enfant.prenom }}</span>
            </td> 
            <td class="text-center">  
               <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;">
                 <argon-button>
                    <router-link :to="`/dashboard-admin/enfants/Details/${enfant.id}`">Détails</router-link>
                </argon-button>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axios-instance'; // Assurez-vous que le chemin d'importation est correct

export default {
  name: 'enfants',
  data() {
    return {
      enfants: []
    };
  },
  mounted() {
    this.getenfants();
  },
  methods: {
    getenfants() {
  axiosInstance.get('/dashboard-admin/enfants')
    .then(response => {
      this.enfants = response.data.enfants; // Assurez-vous d'accéder à la clé 'enfants'
      console.log('Enfants chargés:', this.enfants);
    })
    .catch(error => {
      console.error('Erreur lors de la récupération des enfants:', error);
      alert('Erreur lors de la récupération des données: ' + (error.response ? error.response.data.message : error.message));
        });
    }
  }
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