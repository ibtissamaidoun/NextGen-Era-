<template>
  <div>
    <h4 class="mt-5 text-center">Course Details</h4>
    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center">
      <div class="course-image" v-if="activite">
        <img :src="activite.image_pub" alt="Image description">
      </div>
      <div class="course-details">
        <div v-if="activite">
          <h2>{{ activite.titre }}</h2>
          <p>{{ activite.description }}</p>
          <ul>
            <li><strong>Objectives:</strong> {{ activite.objectifs }}</li>
            <li><strong>Number of Sessions per Week:</strong> {{ activite.nbr_seances_semaine }}</li>
            <li><strong>Price:</strong> {{ activite.tarif }}</li>
            <li><strong>Minimum Participants:</strong> {{ activite.effectif_min }}</li>
            <li><strong>Maximum Participants:</strong> {{ activite.effectif_max }}</li>
            <li><strong>Current Participants:</strong> {{ activite.effectif_actuel }}</li>
            <li><strong>Minimum Age:</strong> {{ activite.age_min }}</li>
            <li><strong>Maximum Age:</strong> {{ activite.age_max }}</li>
            <li><strong>Status:</strong> {{ activite.status }}</li>
            <li><strong>Start Date:</strong> {{ activite.date_debut_etud }}</li>
            <li><strong>End Date:</strong> {{ activite.date_fin_etud }}</li>
            <li><strong>Activity Type:</strong> {{ activite.type_activite }}</li>
            <li><strong>Activity Domain:</strong> {{ activite.domaine_activite }}</li>
          </ul>
        </div>
        <div v-else>
          <p>No data available</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import axiosInstance from '@/axios-instance';

export default {
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      activite: null,
      horaires: [],
      mode_paiements: []
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      try {
        const response = await axiosInstance.get(`/dashboard-admin/Activites/Details/${this.id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}` // Assurez-vous que le token est stocké dans localStorage
          }
        });
        this.activite = response.data.activite; // Ajustez pour correspondre à la structure de réponse
        this.horaires = response.data.horaires;
        this.mode_paiements = response.data.mode_paiements;
        console.log('Activite details:', this.activite);
      } catch (error) {
        console.error('Error fetching activite details:', error);
      }
    },
  },
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
