<template>
  <div class="card">
    <div class="card-header pb-0 px-3">
      <h4 class="mb-2 text-center">Les offres disponibles</h4>
    </div>
    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center">
      <table class="table table-responsive align-middle">
        <thead>
          <tr>
            <th class="text-uppercase text-primary opacity-7">id</th>
            <th class="text-uppercase text-primary opacity-7">Titre</th>
            <th class="text-uppercase text-primary opacity-7">Remise</th>
            <th class="text-uppercase text-primary opacity-7">Date de début d'inscription</th>
            <th class="text-uppercase text-primary opacity-7">Date de la fin d'inscription</th>
            <th class="text-uppercase text-primary opacity-7">Supprimer</th>
            <th class="text-uppercase text-primary opacity-7">Editer</th>
            <th class="text-uppercase text-primary opacity-7">Détails</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(offre, index) in offres" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
            <td><h6 class="text-center">{{ offre.id }}</h6></td>
            <td><h6 class="mb-2 text-center">{{ offre.titre }}</h6></td>
            <td><h6 class="mb-2 text-center">{{ offre.remise }}</h6></td>
            <td><h6 class="mb-2 text-center">{{ offre.date_debut }}</h6></td>
            <td><h6 class="mb-2 text-center">{{ offre.date_fin }}</h6></td>
            <td class="text-center">
              <button class="btn btn-link text-danger text-gradient px-3 mb-0" @click="deleteOffre(offre.id, index)">
                <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
              </button>
            </td>
            <td class="align-middle">
              <router-link class="btn btn-link text-dark px-3 mb-0" :to="`/dashboard-admin/offres/Editer/${offre.id}`">
                <i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>
              </router-link>
            </td>
            <td class="text-center">
              <button class="btn btn-link text-primary px-3 mb-0" @click="showDetails(offre)">
                Détails
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal for showing details -->
    <div v-if="selectedOffre" class="modal" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Détails de l'offre</h5>
            <button type="button" class="close" @click="selectedOffre = null" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p><strong>ID:</strong> {{ selectedOffre.id }}</p>
            <p><strong>Titre:</strong> {{ selectedOffre.titre }}</p>
            <p><strong>Description:</strong> {{ selectedOffre.description }}</p>
            <p><strong>Remise:</strong> {{ selectedOffre.remise }}%</p>
            <p><strong>Date de début:</strong> {{ selectedOffre.date_debut }}</p>
            <p><strong>Date de fin:</strong> {{ selectedOffre.date_fin }}</p>
            <p><strong>Created At:</strong> {{ selectedOffre.created_at }}</p>
            <p><strong>Administrateur ID:</strong> {{ selectedOffre.administrateur_id }}</p>
            <p><strong>Option Paiement:</strong> {{ selectedOffre.paiement.option_paiement }}</p>
            <p><strong>Activités:</strong>
              <ul>
                <li v-for="activite in selectedOffre.activites" :key="activite.id">
                  {{ activite.titre }}
                  <ul>
                    <li v-for="horaire in activite.horaires" :key="horaire.jour_semaine">
                      {{ horaire.jour_semaine }}: {{ horaire.heure_debut }} - {{ horaire.heure_fin }}
                    </li>
                  </ul>
                </li>
              </ul>
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="selectedOffre = null">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
h4 {
  font-family: Georgia, 'Times New Roman', Times, serif;
  color: orange;
}
h6 {
  font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
  color: #000080;
}
th {
  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  color: #000080;
}
span {
  font-family: Georgia, 'Times New Roman', Times, serif;
}
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>

<script>
import axiosInstance from '@/axios-instance';

export default {
  data() {
    return {
      offres: [],
      selectedOffre: null,
      loading: false,
      error: null
    };
  },
  created() {
    this.fetchOffres();
  },
  methods: {
    async fetchOffres() {
      this.loading = true;
      try {
        const response = await axiosInstance.get('/dashboard-admin/offres');
        this.offres = response.data.offre;
        console.log(response.data);
      } catch (error) {
        this.error = 'Erreur lors de la récupération des offres';
        console.error(error);
      } finally {
        this.loading = false;
      }
    },
    async deleteOffre(offre_id, index) {
      try {
        await axiosInstance.delete(`/dashboard-admin/offres/${offre_id}`);
        this.offres.splice(index, 1);
      } catch (error) {
        this.error = 'Erreur lors de la suppression de l\'offre';
        console.error(error);
      }
    },
    async showDetails(offre) {
      try {
        console.log('Fetching details for offer:', offre.id); // Log the offer ID
        const response = await axiosInstance.get(`/dashboard-admin/offres/${offre.id}`);
        console.log('API response:', response.data); // Log the response
        this.selectedOffre = response.data[0]; // Extract the offer from the array
        console.log('Selected offer:', this.selectedOffre); // Log the selected offer
      } catch (error) {
        this.error = 'Erreur lors de la récupération des détails de l\'offre';
        console.error(error);
      }
    }
  }
};
</script>