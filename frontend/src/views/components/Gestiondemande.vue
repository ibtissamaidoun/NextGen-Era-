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
            <td class="align-middle">
              <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;">
                <argon-button>
                  <router-link :to="`/dashboard-admin/Demandes/${demande.id}/paye`">
                    <i class="fas fa-user-check text-dark me-2" aria-hidden="true"></i>payé
                  </router-link>
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
import axiosInstance from '@/axios-instance';

export default {
  name: 'Demandes',
  data() {
    return {
      demandes: []
    };
  },
  mounted() {
    this.getdemandes();
  },
  methods: {
    getdemandes() {
      axiosInstance.get('/demandes') // Modifier l'URL selon votre configuration d'API
        .then(response => {
          this.demandes = response.data.demandes;
          console.log('Demandes chargées:', this.demandes);
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des demandes:', error);
          alert('Erreur lors de la récupération des données: ' + (error.response ? error.response.data.message : error.message));
        });
    }
  }
}
</script>

<style scoped>
/* Vos styles CSS */
</style>
