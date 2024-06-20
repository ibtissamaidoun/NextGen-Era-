<template>
  <div class="card pb-0">
    <div class="card-header pb-5 px-3">
      <h4 class="mt-5 text-center">Détails du parent</h4>
    </div>
    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center"> 
      <table class="table table-bordered align-items-center" v-if="parentDetails">
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
            <td>{{ parentDetails.id }}</td>
            <td>{{ parentDetails.nom }}</td>
            <td>{{ parentDetails.prenom }}</td>
            <td>{{ parentDetails.email }}</td>
            <td>{{ parentDetails.telephone_portable }}</td>
            <td>{{ parentDetails.telephone_fixe }}</td>
          </tr>
        </tbody>
      </table>
      <div v-else>
        Chargement des détails ou aucun parent trouvé.
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axios-instance';

export default {
  data() {
    return {
      parentDetails: null,
    };
  },
  mounted() {
    console.log("parent ID récupéré:", this.$route.params.parentId);
    this.fetchparentDetails();
  },
  methods: {
    async fetchparentDetails() {
      try {
        const parentId = this.$route.params.parentId;
        const response = await axiosInstance.get(`/dashboard-admin/parents/details/${parentId}`);
        if (response.data && response.data.length > 0) {
          this.parentDetails = response.data[0]; // Prendre le premier élément du tableau
          console.log("Réponse de l'API:", response.data[0]);
        } else {
          throw new Error("Aucune donnée reçue de l'API ou tableau vide");
        }
      } catch (error) {
        console.error('Erreur lors de la récupération des détails du parent:', error);
        this.parentDetails = null;
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