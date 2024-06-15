<template>
  <div class="card">
    <div class="card-header pb-0 px-3">
      <h4 class="mb-2 text-center">La gestion des administrateurs</h4>
    </div>
    
    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center"> 
      <table class="table table-bordered align-items-center">
        <thead>
          <tr>
            <th class="text-uppercase text-primary opacity-7">Id</th>
            <th class="text-uppercase text-primary opacity-7">Nom</th>
            <th class="text-uppercase text-primary opacity-7">Prénom</th>
            <th class="text-center text-primary opacity-7">Supprimer</th>
            <th class="text-center text-primary opacity-7">Détails</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(administrateur, index) in administrateurs" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
            <td>
              <h6 class="mb-2 text-center">{{ administrateur.id }}</h6>
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ administrateur.nom }}</span>
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ administrateur.prenom }}</span>
            </td> 
            <td class="text-center">
              <button class="btn btn-link text-danger text-gradient px-3 mb-0" @click="deleteAdministrateur(administrateur.id, index)">
                <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
              </button>
            </td>
            <td class="text-center">  
              <router-link :to="`/dashboard-admin/Admins/Details/${administrateur.id}`" class="btn btn-link text-primary text-gradient px-3 mb-0">
                Détails
              </router-link>
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
  name: 'Administrateurs',
  data() {
    return {
      administrateurs: [],
    };
  },
  mounted() {
    this.getAdministrateurs();
  },
  methods: {
    getAdministrateurs() {
      axiosInstance.get('/dashboard-admin/admins')
        .then(response => {
          this.administrateurs = response.data;
          console.log('Administrateurs chargés:', this.administrateurs);
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des administrateurs:', error);
          alert('Erreur lors de la récupération des données: ' + (error.response ? error.response.data.message : error.message));
        });
    },
    async deleteAdministrateur(administrateurId, index) {
      try {
        await axiosInstance.delete(`/dashboard-admin/admins/${administrateurId}`);
        this.administrateurs.splice(index, 1);
        console.log('Administrateur supprimé');
      } catch (error) {
        console.error('Erreur lors de la suppression de l\'administrateur:', error);
        alert('Erreur lors de la suppression de l\'administrateur: ' + (error.response ? error.response.data.message : error.message));
      }
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
