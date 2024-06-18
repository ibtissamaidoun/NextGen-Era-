<template>
    <div class="modal fade show" tabindex="-1" role="dialog" style="display: block;" @click.self="closeModal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Détails de l'activité</h5>
            <button type="button" class="btn-close" aria-label="Close" @click="closeModal"></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>ID:</label>
              <p>{{ activity.id }}</p>
            </div>
            <div class="form-group">
              <label>Domaine d'activité:</label>
              <p>{{ activity.domaine_activite }}</p>
            </div>
            <div class="form-group">
              <label>Type d'activité:</label>
              <p>{{ activity.type_activite }}</p>
            </div>
            <div class="form-group">
              <label>Date de début:</label>
              <p>{{ activity.date_debut }}</p>
            </div>
            <div class="form-group">
              <label>Date de fin:</label>
              <p>{{ activity.date_fin }}</p>
            </div>
            <div class="form-group">
              <label>Statuts:</label>
              <p>{{ activity.statuts }}</p>
            </div>
            <div class="form-group">
              <label>Âge max:</label>
              <p>{{ activity.age_max }}</p>
            </div>
            <div class="form-group">
              <label>Âge min:</label>
              <p>{{ activity.age_min }}</p>
            </div>
            <div class="form-group">
              <label>Effectif actuel:</label>
              <p>{{ activity.effectif_actuel }}</p>
            </div>
            <div class="form-group">
              <label>Effectif minimal:</label>
              <p>{{ activity.effectif_minimal }}</p>
            </div>
            <div class="form-group">
              <label>Effectif maximal:</label>
              <p>{{ activity.effectif_maximal }}</p>
            </div>
            <div class="form-group">
              <label>Prix:</label>
              <p>{{ activity.prix }}</p>
            </div>
            <div class="form-group">
              <label>Nombre de sessions par semaine:</label>
              <p>{{ activity.nombre_sessions_semaine }}</p>
            </div>
            <div class="form-group">
              <label>Objectifs:</label>
              <p>{{ activity.objectifs }}</p>
            </div>
            <div class="form-group">
              <label>Affecter à un animateur:</label>
              <select class="form-control" v-model="selectedAnimateurId">
                <option v-for="animateur in animateurs" :key="animateur.id" :value="animateur.id">{{ animateur.nom }} {{ animateur.prenom }}</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal">Fermer</button>
            <button type="button" class="btn btn-primary" @click="assignAnimateur">Affecter</button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'ActivityDetailsModal',
    props: {
      activity: Object,
      animateurs: Array
    },
    data() {
      return {
        selectedAnimateurId: null
      };
    },
    methods: {
      closeModal() {
        this.$emit('close');
      },
      assignAnimateur() {
        if (this.selectedAnimateurId) {
          // Logique pour affecter l'activité à l'animateur sélectionné
          console.log('Affecter l\'activité à l\'animateur avec ID:', this.selectedAnimateurId);
          this.closeModal();
        } else {
          alert('Veuillez sélectionner un animateur.');
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .modal {
    background: rgba(0, 0, 0, 0.5);
  }
  </style>
  