<template>
  <div class="card pb-0">
    <div class="card-header pb-5 px-3">
      <h4 class="mt-5 text-center">Détails de l'animateur</h4>
    </div>
    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center"> 
      <table class="table table-bordered align-items-center" v-if="animateurDetails">
        <thead>
          <tr>
            <th>Id</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Téléphone portable</th>
            <th>Téléphone fixe</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ animateurDetails.id }}</td>
            <td>{{ animateurDetails.nom }}</td>
            <td>{{ animateurDetails.prenom }}</td>
            <td>{{ animateurDetails.email }}</td>
            <td>{{ animateurDetails.telephone_portable }}</td>
            <td>{{ animateurDetails.telephone_fixe }}</td>
          </tr>
        </tbody>
      </table>
      <div v-else class="text-muted">
        Chargement des détails de l'animateur en cours...
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axios-instance';

export default {
  data() {
    return {
      animateurDetails: null,
    };
  },
  mounted() {
    console.log("ID de l'animateur récupéré:", this.$route.params.animateurId);
    this.fetchAnimateurDetails();
  },
  methods: {
    async fetchAnimateurDetails() {
      try {
        const animateurId = this.$route.params.animateurId;
        const response = await axiosInstance.get(`/dashboard-admin/animateurs/details/${animateurId}`);
        if (response.data) {
          this.animateurDetails = response.data;
          console.log("Réponse de l'API:", response.data);
        } else {
          throw new Error("Aucune donnée reçue de l'API");
        }
      } catch (error) {
        console.error('Erreur lors de la récupération des détails de l\'animateur:', error);
        this.animateurDetails = null;
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
