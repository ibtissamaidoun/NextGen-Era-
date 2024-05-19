<template>
    <div class="card">
        <div class="row">
      <div class="col-12-end text-end">
        <argon-button color="dark" variant="gradient" @click="toggleEmailInput">
          en cours
        </argon-button>
      </div>
    </div>
      <div class="card-header pb-0 px-3">
        <h4 class="mb-2 text-center">Les demandes actuels</h4>
      </div>
      <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center"> 
        <table class="table table-bordered align-items-center">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary opacity-7">
                Id
              </th>
              <th class="text-uppercase text-secondary opacity-7">
                Option de paiement 
              </th>
              <th class="text-uppercase text-secondary opacity-7">
                Titre d'offre
              </th>
              <th class="text-uppercase text-secondary opacity-7">
                Nom parent
              </th>
              <th class="text-center text-secondary opacity-7">
                Prenom parent
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(activity, index) in affectes" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
              <td>
                <h6 class="mb-2 text-center">{{ activity.id }}</h6>
              </td> 
              <td class="text-center">  
                <span class="text-s">{{ activity.optionpaie }}</span>
              </td> 
              <td class="text-center">  
                <span class="text-s">{{ activity.Titreoffre }}</span>
              </td> 
              <td class="text-center">  
                <span class="text-s">{{ activity.nomparent }}</span>
              </td>
              <td class="text-center">  
                <span class="text-s">{{ activity.prenomparent }}</span>
              </td>
              
              
            </tr>
          </tbody>
        </table>
      </div>
      <!-- Affichage des détails -->
      <div v-if="selectedActivity" class="card-footer">
        <h5>Détails du parent:</h5>
        <p>Nom: {{ selectedActivity.nom }}</p>
        <p>Prénom: {{ selectedActivity.prenom }}</p>
        <p>Email: {{ selectedActivity.email }}</p>
        <p>Téléphone portable: {{ selectedActivity.telPortable }}</p>
        <p>Téléphone fixe: {{ selectedActivity.telFixe }}</p>
        <p>fonction: {{ selectedActivity.fonction }}</p>
        
      </div>
    </div>
  </template>
  
  <script>
  /* eslint-disable */
  import ArgonButton from '@/components/ArgonButton.vue';
  
  export default {
    data() {
      return {
        affectes: [
          {
            id: "1",
            nom: "Oulad Maalem", 
            prenom: "Ayoub",
            email: "ayoub@example.com",
            telPortable: "0612345678",
            telFixe: "0123456789",
            fonction:"Haddad",
          },
          {
            id: "4",
            nom: "DOCTEUUUUR", 
            prenom: "Taha",
            email: "taha@example.com",
            telPortable: "0698765432",
            telFixe: "0987654321",
            fonction:"Najaar",
          },
          {
            id: "1",
            nom: "Oulad Maalem", 
            prenom: "Ayoub",
            email: "ayoub@example.com",
            telPortable: "0612345678",
            telFixe: "0123456789",
            fonction:"Haddad",
          },
          {
            id: "4",
            nom: "DOCTEUUUUR", 
            prenom: "Taha",
            email: "taha@example.com",
            telPortable: "0698765432",
            telFixe: "0987654321",
            fonction:"Najaar",
          },
          {
            id: "1",
            nom: "Oulad Maalem", 
            prenom: "Ayoub",
            email: "ayoub@example.com",
            telPortable: "0612345678",
            telFixe: "0123456789",
            fonction:"Haddad",
          },
          {
            id: "4",
            nom: "DOCTEUUUUR", 
            prenom: "Taha",
            email: "taha@example.com",
            telPortable: "0698765432",
            telFixe: "0987654321",
            fonction:"Najaar",
          },
        ],
        selectedActivity: null,
      };
    },
    methods: {
      showDetails(activity) {
        this.selectedActivity = activity;
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
  