<template>
  <div class="card">
    <div class="card-header pb-0 px-3">
      <h4 class="mb-2 text-center">La gestion des parents</h4>
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
          <tr v-for="(parent, index) in this.parents" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
            <td>
              <h6 class="mb-2 text-center">{{ parent.id }}</h6>
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ parent.nom }}</span>
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ parent.prenom }}</span>
            </td> 
            <td class="text-center">
              <button class="btn btn-link text-danger text-gradient px-3 mb-0" @click="deleteparent(parent.id, index)">
                <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
              </button>
            </td>
            <td class="text-center">  
               <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;">
                 <argon-button>
                    <router-link :to="`/dashboard-admin/parents/Details/${parent.id}`">Détails</router-link>
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
  name: 'parents',
  data() {
    return {
      parents: []
    };
  },
  mounted() {
    this.getparents();
  },
  methods: {
    getparents() {
      axiosInstance.get('/dashboard-admin/parents')
        .then(response => {
          // Assurez-vous que la réponse contient un tableau et accédez au premier élément
          if (Array.isArray(response.data) && response.data.length > 0) {
            this.parents = response.data[0]; // Accédez au premier élément qui contient le tableau des parents
            console.log('parents chargés:', this.parents);
          } else {
            console.error('Format de données inattendu:', response.data);
            alert('Erreur lors de la récupération des données: Format incorrect');
          }
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des parents:', error);
          alert('Erreur lors de la récupération des données: ' + (error.response ? error.response.data.message : error.message));
        });
    },
    async deleteparent(parent_id, index) {
      try {
        await axiosInstance.delete(`/dashboard-admin/parents/${parent_id}`);
        this.parents.splice(index, 1);
        console.log('parent supprimée');
      } catch (error) {
        console.error('Erreur lors de la suppression du parent:', error);
        alert('Erreur lors de la suppression du parent: ' + (error.response ? error.response.data.message : error.message));
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