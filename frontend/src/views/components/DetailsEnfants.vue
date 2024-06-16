<template>
  <div class="card pb-0">
    <div class="card-header pb-5 px-3">
      <h4 class="mt-5 text-center">Détails de l'enfant</h4>
    </div>
    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center"> 
      <table class="table table-bordered align-items-center" v-if="enfantDetails">
        <thead>
          <tr>
            <th>Id</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date de naissance</th>
            <th>Niveau étude</th>
            <th>Nom du parent</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ enfantDetails.id }}</td>
            <td>{{ enfantDetails.nom }}</td>
            <td>{{ enfantDetails.prenom }}</td>
            <td>{{ enfantDetails.date_de_naissance }}</td>
            <td>{{ enfantDetails.niveau_etude }}</td>
            <td>{{ enfantDetails.parent.nom }}</td>
          </tr>
        </tbody>
      </table>
      <div v-else>
        Chargement des détails ou aucun enfant trouvé.
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axios-instance';

export default {
  data() {
    return {
      enfantDetails: null,
    };
  },
  mounted() {
    console.log("enfant ID récupéré:", this.$route.params.enfantId);
    this.fetchenfantDetails();
  },
  methods: {
    async fetchenfantDetails() {
      try {
        const enfantId = this.$route.params.enfantId;
        const response = await axiosInstance.get(`/dashboard-admin/enfants/details/${enfantId}`);
        if (response.data && response.data.enfant) {
          this.enfantDetails = response.data.enfant; // Assurez-vous que la réponse correspond à ce format
          this.enfantDetails.parent = response.data.parent; // Ajouter les détails du parent à l'objet enfantDetails
          console.log("Réponse de l'API:", response.data);
        } else {
          throw new Error("Aucune donnée reçue de l'API ou format incorrect");
        }
      } catch (error) {
        console.error('Erreur lors de la récupération des détails de l\'enfant:', error);
        this.enfantDetails = null;
      }
    }
  }
}
</script>

<style scoped>
h4 {
  color: orange;
  font-family: Georgia, 'Times New Roman', Times, serif;
}
table th {
  color: #000080;
  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
}
</style>