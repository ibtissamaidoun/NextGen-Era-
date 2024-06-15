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
              
      <tr v-for="(horaire, index) in horaires" :key="index"  class="  p-4 mb-2 bg-gray-100  border-radius-lg ">
          <td >
            <h6 class="mb-2 text-center">{{ horaire.heure_debut }}</h6>
            
          </td> 
          <td class="text-center">  
            <h6 class="mb-2 text-center">
              {{ horaire.heure_fin }}
            </h6>
          </td> 
          <td class="text-center">  
            <h6 class="mb-2 text-center">
              {{ horaire.jour_semaine }}
            </h6>
          </td> 
           <td class="text-center">  
            <a
              class="btn btn-link text-danger text-gradient px-3 mb-0"
              @click="deletehoraire(horaire.id, index)"
            >
              <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
            </a>
            </td>
          
            <td class="align-middle">
          <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;">
            <argon-button>                  
                <router-link :to="`/dashboard-admin/horaires/Editer/${horaire.id}`"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i
                  ></router-link>
            </argon-button>
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
import axiosInstance from '@/axios-instance'; // Assurez-vous que le chemin d'importation est correct

export default {
  name: 'horaires',
  data() {
    return {
      horaires: []
    };
  },
  mounted() {
    this.gethoraires();
  },
  methods: {
    gethoraires() {
      axiosInstance.get('/dashboard-admin/horaires')
        .then(response => {
          this.horaires = response.data;
          console.log('horaires chargés:', this.horaires); // Vérifiez la structure ici
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des horaires:', error);
          alert('Erreur lors de la récupération des données: ' + (error.response ? error.response.data.message : error.message));
        });
    },
    async deletehoraire(horaire_id, index) {
      try {
        await axiosInstance.delete(`/dashboard-admin/horaires/${horaire_id}`);
        this.horaires.splice(index, 1);
        console.log('horaire supprimée');
      } catch (error) {
        console.error('Erreur lors de la suppression du horaire:', error);
        alert('Erreur lors de la suppression du horaire: ' + (error.response ? error.response.data.message : error.message));
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