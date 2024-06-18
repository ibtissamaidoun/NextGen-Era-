<template>
  <div class="card">
    <div class="card-header pb-0 px-3">
      <h4 class="mb-2 text-center">La gestion des animateurs</h4>
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
              Supprimer
            </th>
            <th class="text-center text-primary opacity-7">
              Détails
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(animateur, index) in animateurs" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
            <td>
              <h6 class="mb-2 text-center">{{ animateur.id }}</h6>
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ animateur.nom }}</span>
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ animateur.prenom }}</span>
            </td> 
            <td class="text-center">  
              <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;" @click="deleteanimateur(animateur.id, index)">
                <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
              </a>
            </td>
            <td class="text-center">  
               <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;">
                 <argon-button>
                    <router-link :to="`/dashboard-admin/animateurs/Details/${animateur.id}`">Détails</router-link>
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
  name: 'animateurs',
  data() {
    return {
      animateurs: []
    };
  },
  mounted() {
    this.getAnimateurs();
  },
  methods: {
    getAnimateurs() {
      axiosInstance.get('/dashboard-admin/animateurs')
        .then(response => {
          this.animateurs = response.data[0]; // Access the first element of the outer array
          console.log('Animateurs chargés:', this.animateurs);
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des animateurs:', error);
          alert('Erreur lors de la récupération des données: ' + (error.response ? error.response.data.message : error.message));
        });
    },
    async deleteanimateur(animateur_id, index) {
      const url =`/dashboard-admin/animateurs/${animateur_id}`;
      console.log('Tentative de suppression à l\'URL:', url);
      try {
        const response = await axiosInstance.delete(url);
        console.log('Réponse de suppression:', response);
        this.animateurs.splice(index, 1);
        console.log('Animateur supprimé');
      } catch (error) {
        console.error('Erreur lors de la suppression de l\'animateur:', error);
        let errorMessage = 'Erreur inconnue'; // Message par défaut si l'erreur n'est pas structurée comme prévu
        if (error.response && error.response.data) {
          errorMessage = error.response.data.message || JSON.stringify(error.response.data);
        } else if (error.message) {
          errorMessage = error.message;
        }
        alert('Erreur lors de la suppression de l\'animateur: ' + errorMessage);
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
