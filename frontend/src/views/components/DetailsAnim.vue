<template>
  <div>
    <h4 class="mt-5 text-center">Détails du Cours</h4>
    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center">
      <div class="course-image" v-if="activite">
        <img :src="activite.image_pub" alt="Description de l'image">
      </div>
      <div class="course-details" v-if="activite">
        <h2>{{ activite.titre }}</h2>
        <p>{{ activite.description }}</p>
        <ul>
          <li><strong>Objectifs :</strong> {{ activite.objectifs }}</li>
          <li><strong>Nombre de séances par semaine :</strong> {{ activite.nbr_seances_semaine }}</li>
          <li><strong>Prix :</strong> {{ activite.tarif }}</li>
          <li><strong>effectif minimum :</strong> {{ activite.effectif_min }}</li>
          <li><strong>effectif maximum :</strong> {{ activite.effectif_max }}</li>
          <li><strong>effectif actuels :</strong> {{ activite.effectif_actuel }}</li>
          <li><strong>Âge minimum :</strong> {{ activite.age_min }}</li>
          <li><strong>Âge maximum :</strong> {{ activite.age_max }}</li>
          <li><strong>Statut :</strong> {{ activite.status }}</li>
          <li><strong>Date de début :</strong> {{ activite.date_debut_etud }}</li>
          <li><strong>Date de fin :</strong> {{ activite.date_fin_etud }}</li>
          <li><strong>Type d'activité :</strong> {{ activite.type_activite }}</li>
          <li><strong>Domaine d'activité :</strong> {{ activite.domaine_activite }}</li>
        </ul>
        <h5>Enfants</h5>
        <ul>
          <li v-for="enfant in enfants" :key="enfant.id">{{ enfant.nom }} {{ enfant.prenom }}</li>
        </ul>
        <h5>Emploi du temps</h5>
        <ul>
          <li v-for="horaire in horaires" :key="horaire.id">{{ horaire.jour_semaine }} : {{ horaire.heure_debut }} - {{ horaire.heure_fin }}</li>
        </ul>
      </div>
      <div v-else>
        <p>Aucune donnée disponible</p>
      </div>
    </div>
  </div>
</template>
  
<script>
/* eslint-disable */
import axiosInstance from '@/axios-instance';
  
export default {
  data() {
    return {
      activite: null,
      enfants: [],
      horaires: [],
      mode_paiements: []
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      const activiteId = this.$route.params.id; // Récupération de l'ID de l'URL
      try {
        const response = await axiosInstance.get(`/dashboard-animateurs/activites/${activiteId}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        });
        this.activite = response.data.activite;
        this.enfants = response.data.enfants;
        this.horaires = response.data.horaires; // Assurez-vous que ceci correspond à la structure de la réponse de l'API
        this.mode_paiements = response.data.mode_paiements;
        console.log('Activite details:', this.activite);
        console.log('Horaires:', this.horaires); // Ajoutez ceci pour déboguer et voir les horaires dans la console
      } catch (error) {
        console.error('Error fetching activite details:', error);
      }
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