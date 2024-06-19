<template>
    <div class="card">
      <div class="card-header pb-0 table-responsive p-6">
        <h4 class="text-center mb-4">Tables des heures</h4>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0" >
          <table class="table table-bordered align-items-center  mb-0">
            <thead>
              <tr>
                <th  class="text-uppercase text-secondary opacity-7">Horaires disponibles </th>
                
                <th
                  class="text-center  text-secondary  opacity-7"
                >
                  Choisir
                </th>
                
                <th class="text-secondary opacity-7"> Editer</th>
                <th class="text-secondary opacity-7">Supprimer</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(activity, index) in horaires" :key="index" class="bg-gray-100">
                <td class="text-center">
                  <div>
                    <h6>{{ activity.horairedispo }}</h6>
                  </div>
                </td>
                
                <td class="align-middle text-center">
                  <i class="ni ni-check-bold" style="color:orange"></i>
                </td>

               
                


           <!-- <td    class="align-middle">

               <button
                class="btn btn-link text-danger text-gradient px-3 mb-0"
                 
                >
                <i class="fa fa-pencil" aria-hidden="true"></i>:env
                
              </button>
              

              </td>

             // </td>

              </td> -->

                <td class="align-middle">
            <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;">
              <argon-button><router-link to="/dashboard-animateurs/Horaires/Editer"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i
              ></router-link></argon-button>
            </a>
            </td>
                <td class="align-middle">
                  <button
                  class="btn btn-link text-danger text-gradient px-3 mb-0"
                 @click="deleteAnimateur( activity.id,index)"
                  >
                  <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
                </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
</div>
</template>

<script>
import axiosInstance from '@/axios-instance';

export default {
  name: 'Horaires',
  data() {
    return {
      horaires: [],
    };
  },
  mounted() {
    this.getHoraires();
  },
  methods: {
    getHoraires() {
      axiosInstance.get('/dashboard-animateurs/Horaires')
        .then(response => {
          this.horaires = response.data;
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des horaires:', error);
          alert('Erreur lors de la récupération des données: ' + (error.response ? error.response.data.message : error.message));
        });
    },
    async deleteHoraire(horaireId, index) {
      try {
        await axiosInstance.delete(`/dashboard-animateurs/Horaires/${horaireId}`);
        this.horaires.splice(index, 1);
      } catch (error) {
        console.error('Erreur lors de la suppression du horaire:', error);
        alert('Erreur lors de la suppression du horaire: ' + (error.response ? error.response.data.message : error.message));
      }
    },
  },
};
</script>

<style scoped>
h4 {
  font-family: Georgia, 'Times New Roman', Times, serif;
  color: orange;
}

h6 {
  color: #000080;
}

th {
  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  color: #000080;
}

span {
  font-family: Georgia, 'Times New Roman', Times, serif;
}
</style>
