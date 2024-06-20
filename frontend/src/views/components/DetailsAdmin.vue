<template>
  <div class="card pb-0">
    <div class="card-header pb-5 px-3">
      <h4 class="mt-5 text-center">Détails de l'administrateur</h4>
    </div>
    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center"> 
      <table class="table table-bordered align-items-center" v-if="adminDetails">
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
            <td>{{ adminDetails.id }}</td>
            <td>{{ adminDetails.nom }}</td>
            <td>{{ adminDetails.prenom }}</td>
            <td>{{ adminDetails.email }}</td>
            <td>{{ adminDetails.telephone_portable }}</td>
            <td>{{ adminDetails.telephone_fixe }}</td>
          </tr>
        </tbody>
      </table>
      <div v-else>
        Chargement des détails ou aucun administrateur trouvé.
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axios-instance';

export default {
  data() {
    return {
      adminDetails: null,
    };
  },
  mounted() {
    this.fetchAdminDetails();
  },
  methods: {
    async fetchAdminDetails() {
      try {
        const adminId = this.$route.params.adminId;
        const response = await axiosInstance.get(`/dashboard-admin/admins/details/${adminId}`);
        this.adminDetails = response.data[0]; // Accéder au premier élément du tableau
      } catch (error) {
        console.error('Erreur lors de la récupération des détails de l\'administrateur:', error);
        this.adminDetails = null;
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