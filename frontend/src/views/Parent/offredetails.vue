<template>
  <div class="container">
    <div v-if="loading" class="loading-bar">Loading...</div>
    <div v-else-if="offer" class="card shadow-lg">
      <div class="card-header">
        <h3>{{ offer.titre }}</h3>
      </div>
      <div class="card-body">
        <p class="lead">{{ offer.description }}</p>
        <p><strong>Date de début:</strong> {{ offer.date_debut }}</p>
        <p><strong>Date de fin:</strong> {{ offer.date_fin }}</p>
        <p><strong>Option de paiement:</strong> {{ offer.paiement.option_paiement }}</p>

        <h4>Les activités:</h4>
        <div v-for="(activity, index) in offer.activites" :key="activity.id" class="card mb-3 shadow-sm">
          <div class="card-header">
            <h5>{{ index + 1 }}. {{ activity.titre }}</h5>
          </div>
          <div class="card-body">
            <p>{{ activity.description }}</p>
            <h5>Objectifs</h5>
            <p>{{ activity.objectifs }}</p>

            <h5>Détails</h5>
            <table>
              <tr>
                <th><strong>Domaine d'activité</strong></th>
                <td>{{ activity.domaine_activite }}</td>
              </tr>
              <tr>
                <th><strong>Type d'activité</strong></th>
                <td>{{ activity.type_activite }}</td>
              </tr>
              <tr>
                <th><strong>Plage d'Age</strong></th>
                <td>de {{ activity.age_min }} à {{ activity.age_max }} ans</td>
              </tr>
              <tr>
                <th><strong>Nombre de séances</strong></th>
                <td>{{ activity.nbr_seances_semaine }} séances par semaine</td>
              </tr>
              <tr>
                <th><strong>Effectif actuel</strong></th>
                <td>{{ activity.effectif_actuel }} places rempli</td>
              </tr>
              <tr>
                <th><strong>Tarif</strong></th>
                <td>{{ activity.tarif }} MAD</td>
              </tr>
            </table>

            <h5>Les horaires d'étude</h5>
            <table>
              <thead>
                <tr>
                  <th><strong>Jour</strong></th>
                  <th><strong>Heure de début</strong></th>
                  <th><strong>Heure de fin</strong></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="horaire in activity.horaires" :key="horaire.id">
                  <td>{{ horaire.jour_semaine }}</td>
                  <td>{{ horaire.heure_debut }}</td>
                  <td>{{ horaire.heure_fin }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <h4>Sélectionner les enfants:</h4>
        <div v-for="child in enfants" :key="child.id" class="form-check">
          <input class="form-check-input" type="checkbox" :id="'child-' + child.id" v-model="selectedChildren" :value="child.id">
          <label class="form-check-label" :for="'child-' + child.id">
            {{ child.nom }} {{ child.prenom }} ({{ child.niveau_etude }})
          </label>
        </div>

        <button @click="submitSelection" class="btn btn-primary mt-3" :disabled="submitting">
          {{ submitting ? 'Submitting...' : 'Soumettre' }}
        </button>
      </div>
    </div>
    <div v-else class="text-center mt-5">
      <p>No data available.</p>
    </div>
  </div>
</template>

<style scoped>
  .lead {
    text-align: justify;
    margin-bottom: 20px;
  }

  table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 35px;
  }

  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }

  th {
    background-color: #f0f0f0;
  }

  tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  tr:hover {
    background-color: #ccc;
  }

  .form-check {
    margin-bottom: 10px;
  }

  .form-check-input {
    margin-right: 10px;
  }

  button {
    background-color: #4CAF50;
    color: #ffffff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  button:hover {
    background-color: #3e8e41;
  }

  .card {
    margin-bottom: 20px;
  }

  .card-header h5 {
    margin: 0;
  }

  .card-body h5 {
    margin-top: 20px;
  }

  .loading-bar {
    width: 100%;
    background-color: #ddd;
    text-align: center;
    padding: 10px;
    font-size: 18px;
    color: #666;
  }
</style>

<script>
import axiosInstance from '@/axios-instance'; // Ensure axios is correctly imported

export default {
  data() {
    return {
      offer: null,
      enfants: [],
      selectedChildren: [],
      offerId: null,
      loading: false,
      submitting: false  // Add this line to track submission state
    };
  },
  methods: {
    fetchOfferDetails() {
      this.loading = true;  // Set loading to true when fetch starts
      this.offerId = this.$route.params.id;  // Set offerId from route parameters
      axiosInstance.get(`dashboard-parents/Offres/${this.offerId}`)
        .then(response => {
          console.log('API Response:', response); // Log the entire response object
          this.offer = response.data.offres; // Ensure 'offres' is the correct property
          this.enfants = response.data.enfant; // Ensure 'enfant' is the correct property
          // Initialize showDetails for each activity
          if (this.offer && this.offer.activites) {
            this.offer.activites.forEach(activity => {
              this.$set(activity, 'showDetails', false);
            });
          }
          this.loading = false;  // Set loading to false when fetch completes
        })
        .catch(error => {
          console.error('Error fetching offer details:', error);
          this.loading = false;  // Ensure loading is set to false on error
        });
    },
    submitSelection() {
      this.submitting = true;  // Set submitting to true when submission starts
      axiosInstance.post(`/dashboard-parents/Offres/${this.offerId}`, {  // Use offerId here
        enfants: this.selectedChildren
      })
      .then(() => {
        this.$router.push({ name: 'DemandesP' });
        this.submitting = false;  // Set submitting to false when submission completes
      })
      .catch(error => {
        console.error('Failed to submit offer:', error);
        alert('Failed to submit offer: ' + error.response.data.message);
        this.submitting = false;  // Ensure submitting is set to false on error
      });
    }
  },
  created() {
    this.fetchOfferDetails();
  }
};
</script>
