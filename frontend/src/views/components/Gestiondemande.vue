<template>
  <div class="card">
    <div class="card-header pb-0 px-3">
      <h4 class="mb-2 text-center">La gestion des demandes</h4>
    </div>
    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center">
      <table class="table table-bordered align-items-center">
        <thead>
          <tr>
            <th class="text-uppercase text-primary opacity-7">Id</th>
            <th class="text-uppercase text-primary opacity-7">Parent</th>
            <th class="text-uppercase text-primary opacity-7">Date de demande</th>
            <th class="text-center text-primary opacity-7">Statut</th>
            <th class="text-center text-primary opacity-7">Payé</th>
            <th class="text-center text-primary opacity-7">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(demande, index) in demandes" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
            <td>
              <h6 class="mb-2 text-center">{{ demande.id }}</h6>
            </td>
            <td class="text-center">
              <span class="text-s">{{ demande.parent_name }}</span>
            </td>
            <td class="text-center">
              <span class="text-s">{{ demande.date_demande }}</span>
            </td>
            <td class="text-center">
              <span class="text-s">{{ demande.statut }}</span>
            </td>
            <td class="text-center">
              <span class="text-s">{{ demande.paiement_option }}</span>
            </td>
            <td class="text-center">
              <button class="btn btn-success" @click="validateDemande(demande.id)">Valider</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axios-instance';

export default {
  name: 'Demandes',
  data() {
    return {
      demandes: []
    };
  },
  mounted() {
    this.getDemandes();
  },
  methods: {
    getDemandes() {
      axiosInstance.get('/dashboard-admin/demandes')
        .then(response => {
          if (response.data && response.data.demandes) {
            this.demandes = response.data.demandes.map(demande => ({
              ...demande,
              date_demande: new Date(demande.date_demande).toLocaleDateString('fr-FR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
              })
            }));
            console.log('Demandes chargées:', this.demandes);
          } else {
            console.error('Erreur: Données de demande manquantes dans la réponse.');
          }
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des demandes:', error);
          alert('Erreur lors de la récupération des données: ' + (error.response ? error.response.data.message : error.message));
        });
    },
    validateDemande(demandeId) {
      axiosInstance.post(`/demandes/${demandeId}/paye`)
        .then(response => {
          console.log('Demande validée:', response.data);
        })
        .catch(error => {
          console.error('Erreur lors de la validation de la demande:', error);
          alert('Erreur lors de la validation de la demande: ' + (error.response ? error.response.data.message : error.message));
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

.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 1rem;
  background-color: transparent;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}
</style>