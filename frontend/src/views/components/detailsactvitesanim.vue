<template>
    <div class="card">
      <div class="card-header pb-0 px-3">
        <h4 class="mb-2 text-center">Les activités diponibles</h4>
      </div>
      <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center"> 
        <table class="table table-bordered align-items-center">
          <thead>
            <tr>
              <th class="text-uppercase text-primary opacity-7">Id</th>
              <th class="text-uppercase text-primary opacity-7">Titre</th>
              <th class="text-uppercase text-primary opacity-7">Domaine d'activité</th>
              <th class="text-center text-primary opacity-7">Détails</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(activity, index) in activities" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
              <td>
                <h6 class="mb-2 text-center">{{ activity.id }}</h6>
              </td> 
              <td class="text-center">  
                <span class="text-s">{{ activity.titre }}</span>
              </td> 
              <td class="text-center">  
                <span class="text-s">{{ activity.domaine }}</span>
              </td> 
              <td class="text-center">  
                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;" @click="showDetails(activity.id)">
                  <argon-button>Détails</argon-button>
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <argon-modal v-if="showModal" @close="closeModal">
        <template #header>
          <h5 class="modal-title">Détails de l'activité</h5>
        </template>
        <template #body>
          <div v-if="selectedActivity">
            <p><strong>ID:</strong> {{ selectedActivity.id }}</p>
            <p><strong>Domaine d'activité:</strong> {{ selectedActivity.domaine }}</p>
            <p><strong>Type d'activité:</strong> {{ selectedActivity.type }}</p>
            <p><strong>Date de début:</strong> {{ selectedActivity.date_debut }}</p>
            <p><strong>Date de fin:</strong> {{ selectedActivity.date_fin }}</p>
            <p><strong>Statuts:</strong> {{ selectedActivity.statuts }}</p>
            <p><strong>Âge max:</strong> {{ selectedActivity.age_max }}</p>
            <p><strong>Âge min:</strong> {{ selectedActivity.age_min }}</p>
            <p><strong>Effectif actuel:</strong> {{ selectedActivity.effectif_actuel }}</p>
            <p><strong>Effectif minimale:</strong> {{ selectedActivity.effectif_min }}</p>
            <p><strong>Effectif maximale:</strong> {{ selectedActivity.effectif_max }}</p>
            <p><strong>Prix:</strong> {{ selectedActivity.prix }}</p>
            <p><strong>Nombre de sessions par semaine:</strong> {{ selectedActivity.nombre_sessions }}</p>
            <p><strong>Objectifs:</strong> {{ selectedActivity.objectifs }}</p>
            <div>
              <label for="animateurDropdown">Affecter à un animateur:</label>
              <select id="animateurDropdown" v-model="selectedAnimateurId">
                <option v-for="animateur in animateurs" :key="animateur.id" :value="animateur.id">
                  {{ animateur.nom }} {{ animateur.prenom }}
                </option>
              </select>
            </div>
          </div>
        </template>
        <template #footer>
          <button class="btn btn-secondary" @click="closeModal">Fermer</button>
          <button class="btn btn-primary" @click="affecterAnimateur">Affecter</button>
        </template>
      </argon-modal>
    </div>
  </template>
  
  <script>
  import ArgonModal from '@/components/ArgonModal.vue';
  
  export default {
    name: 'Animateurs',
    components: {
      ArgonModal,
    },
    data() {
      return {
        animateurs: [
          { id: 1, nom: 'Dupont', prenom: 'Jean' },
          { id: 2, nom: 'Martin', prenom: 'Pierre' },
        ],
        activities: [
          {
            id: 1,
            titre: 'programmation',
            domaine: 'informatique',
            type: 'Atelier',
            date_debut: '2024-07-01',
            date_fin: '2024-07-31',
            statuts: 'Active',
            age_max: 17,
            age_min: 10,
            effectif_actuel: 15,
            effectif_min: 10,
            effectif_max: 20,
            prix: 600,
            nombre_sessions: 3,
            objectifs: 'Améliorer les compétences en football',
          },
          {
            id: 2,
            titre: 'Robotique',
            domaine: 'technologie',
            type: 'Peinture',
            date_debut: '2024-08-01',
            date_fin: '2024-08-31',
            statuts: 'Inactive',
            age_max: 15,
            age_min: 8,
            effectif_actuel: 10,
            effectif_min: 5,
            effectif_max: 15,
            prix: 50,
            nombre_sessions: 2,
            objectifs: 'Développer la créativité artistique',
          },
        ],
        selectedActivity: null,
        selectedAnimateurId: null,
        showModal: false,
      };
    },
    methods: {
      showDetails(activityId) {
        this.selectedActivity = this.activities.find(activity => activity.id === activityId);
        this.showModal = true;
      },
      closeModal() {
        this.showModal = false;
        this.selectedActivity = null;
      },
      affecterAnimateur() {
        console.log(`Activité ${this.selectedActivity.id} affectée à l'animateur ${this.selectedAnimateurId}`);
        this.closeModal();
      },
    },
  };
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
  