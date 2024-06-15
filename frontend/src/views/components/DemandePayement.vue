<template>
    <div class="card">
      <div class="card-header pb-0 px-3">
        <h4 class="mb-2 text-center">La gestion des demandes</h4>
      </div>
  
      <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center">
        <table class="table table-bordered align-items-center">
          <thead>
            <tr>
              <th class="text-uppercase text-primary opacity-7">
                Traite
              </th>
              <th class="text-uppercase text-primary opacity-7">
                Date de sortie
              </th>
              <th class="text-uppercase text-primary opacity-7">
                Date de paiement
              </th>
              <th class="text-uppercase text-primary opacity-7">
                Delai
              </th>
              <th class="text-uppercase text-primary opacity-7">
                Payé
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(demande, index) in demandes" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
              <td>
                <h6 class="mb-2 text-center">{{ demande.traite }}</h6>
              </td>
              <td class="text-center">
                <span class="text-s">{{demande.datesortie}}</span>
              </td>
              <td class="text-center">
                <span class="text-s">{{ demande.datepaiement }}</span>
              </td>
              <td class="text-center">
                <span class="text-s">{{ demande.delai }}</span>
              </td>
              <td class="text-center">
              <button class="btn btn-link text-danger text-gradient px-3 mb-0" >
                <i class="fa-sharp fa-thin fa-badge-check"></i>
              </button>
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
    name: 'demandes',
    data() {
      return {
        demandes: [1,'salim','19/02/2023','en cours'],
        parents: []
      };
    },
    mounted() {
      this.getdemandes();
      this.getParents();
    },
    methods: {
      getdemandes() {
        axiosInstance.get('/dashboard-admin/demandes')
          .then(response => {
            this.demandes = response.data.demandes;
            console.log('Demandes chargées:', this.demandes);
          })
          .catch(error => {
            console.error('Erreur lors de la récupération des demandes:', error);
            alert('Erreur lors de la récupération des données: ' + (error.response ? error.response.data.message : error.message));
          });
      },
      getParents() {
        axiosInstance.get('/dashboard-admin/parents')
          .then(response => {
            this.parents = response.data.parents;
            console.log('Parents chargés:', this.parents);
          })
          .catch(error => {
            console.error('Erreur lors de la récupération des parents:', error);
            alert('Erreur lors de la récupération des données: ' + (error.response ? error.response.data.message : error.message));
          });
      },
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
  