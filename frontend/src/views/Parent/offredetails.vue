<template>
    <div class="container">
      <div v-if="offer" class="card shadow-lg">
        <div class="card-header bg-primary text-white">
          <h3 class="mb-2 text-center">{{ offer.titre }}</h3>
        </div>
        <div class="card-body">
          <p class="lead">{{ offer.description }}</p>
          <p>Date de début: <span class="text-info">{{ offer.date_debut }}</span></p>
          <p>Date de fin: <span class="text-info">{{ offer.date_fin }}</span></p>
          <p>Option de paiement: <span class="badge bg-success">{{ offer.paiement.option_paiement }}</span></p>
  
          <h4 class="mt-4">Activités:</h4>
          <div v-for="activity in offer.activites" :key="activity.id" class="card mb-3 shadow-sm">
            <div class="card-header bg-secondary text-white">
              <h5>{{ activity.titre }}</h5>
            </div>
            <div class="card-body">
              <!-- Button to toggle visibility -->
              <button @click="showActivityDetails(activity)" class="btn btn-primary">Show More</button>
              
              <!-- Details hidden initially, shown when showDetails is true -->
              <div v-if="activity.showDetails">
                <p>{{ activity.description }}</p>
                <p>Objectifs: <span class="text-muted">{{ activity.objectifs }}</span></p>
                <p>Nombre de séances par semaine: <span class="badge bg-info">{{ activity.nbr_seances_semaine }}</span></p>
                <p>Effectif actuel: <span class="badge bg-danger">{{ activity.effectif_actuel }}</span></p>
                <p>Âge minimum: <span class="badge bg-primary">{{ activity.age_min }}</span></p>
                <p>Âge maximum: <span class="badge bg-primary">{{ activity.age_max }}</span></p>
              </div>
            </div>
          </div>
  
          <h4 class="mt-4">Sélectionner les enfants:</h4>
          <div v-for="child in enfants" :key="child.id" class="form-check">
            <input class="form-check-input" type="checkbox" :id="'child-' + child.id" v-model="selectedChildren" :value="child.id">
            <label class="form-check-label" :for="'child-' + child.id">
              {{ child.nom }} {{ child.prenom }} ({{ child.niveau_etude }})
            </label>
          </div>
  
          <button @click="submitSelection" class="btn btn-primary mt-3">Soumettre</button>
        </div>
      </div>
      <div v-else class="text-center mt-5">
        <p>Loading...</p>
      </div>
    </div>
  </template>
  
  <script>
  import axiosInstance from '@/axios-instance'; // Ensure axios is correctly imported
  
  export default {
    data() {
      return {
        offer: null,
        enfants: [],
        selectedChildren: [],
        offerId: null  
      };
    },
    methods: {
      fetchOfferDetails() {
        this.offerId = this.$route.params.id;  // Set offerId from route parameters
        axiosInstance.get(`dashboard-parents/Offres/${this.offerId}`)
          .then(response => {
            console.log(response); // Log the full response
            this.offer = response.data.offres;
            this.enfants = response.data.enfant;
            // Initialize showDetails for each activity
            if (this.offer && this.offer.activites) {
              this.offer.activites.forEach(activity => {
                this.$set(activity, 'showDetails', false);
              });
            }
          })
          .catch(error => {
            console.error('Error fetching offer details:', error);
          });
      },
      submitSelection() {
        // Handle the selected children (this.selectedChildren) as needed
        console.log('Selected children:', this.selectedChildren);
        // You can make an API call or process the selection as needed
        axiosInstance.post(`/dashboard-parents/offres/${this.offerId}`, {  // Use offerId here
          enfants: this.selectedChildren
        })
        // .then(response => {
        //   alert('Offer submitted successfully!');
        //   // Optionally redirect or update the UI to reflect the submission
        // })
        .catch(error => {
          console.error('Failed to submit offer:', error);
          alert('Failed to submit offer: ' + error.response.data.message);
        });
      },
      showActivityDetails(activity) {
        // Toggle the showDetails property
        activity.showDetails = !activity.showDetails;
      }
    },
    created() {
      this.fetchOfferDetails();
    }
  };
  </script>
  
  <style scoped>
  .container {
    max-width: 800px;
    margin: auto;
    margin-top: 20px;
  }
  .card {
    margin-bottom: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
  }
  .card-header {
    background-color: #007bff;
    color: white;
    border-radius: 10px 10px 0 0;
  }
  .card-body {
    background-color: #f8f9fa;
    padding: 20px;
  }
  .form-check-input {
    margin-right: 10px;
  }
  .form-check-label {
    font-weight: bold;
  }
  </style>