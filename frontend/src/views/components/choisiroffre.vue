<template>
  <div class="container">
    <div class="card-header pb-3 px-3">
          <h3 class="mb-2 text-center">Choisir une offre</h3>
        </div>
    <div class="row mt-5">
      <div class="col-md-6">
        <div class="card offer-card-1">
          <div class="card-header">
            <h3 class="mb-2 text-center">{{ offre1.title }}</h3>
          </div>
          <div class="card-body pt-2">
            <p style="color: black; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif ;">{{ offre1.description }}</p>
            <ul>
              <div v-for="(activity, index) in offre1.selectedActivities" :key="index">{{ activity }}</div>
            </ul>
            <ul>
              <div v-for="(option, index) in offre1.selectedPaymentOptions" :key="index">{{ option }}</div>
            </ul>
            <div class="pt-9">
            <button class="btn btn-warning mt-3" @click="showActivitySelection('offre1')">Sélectionner activités</button>
            </div>
            <button class="btn btn-warning mt-3" @click="showChildSelection('offre1')">Ajouter enfant</button>
            <div>
            <button class="btn btn-warning mt-3" @click="showPaymentOptionSelection('offre1')">Choisir option de paiement</button>
            </div>
          </div>
        
            <h5>Prix : {{ offre1.price }} DH </h5>       
      </div>
      </div>
      <div class="col-md-6">
        <div class="card offer-card-2">
          <div class="card-header">
            <h3 class="mb-2 text-center">{{ offre2.title }}</h3>
          </div>
          <div class="card-body pt-2">
            <p style="color: black; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif ;">{{ offre2.description }}</p>
            <ul>
              <div v-for="(activity, index) in offre2.selectedActivities" :key="index">{{ activity }}</div>
            </ul>
            
            <ul>
              <div v-for="(option, index) in offre2.selectedPaymentOptions" :key="index">{{ option }}</div>
            </ul>
            
            <div class="pt-10">
            <button class="btn btn-warning mt-3" @click="showActivitySelection('offre2')">Sélectionner activités</button>
            </div>
            <button class="btn btn-warning mt-3" @click="showChildSelection('offre2')">Ajouter enfant</button>
            <div>
            <button class="btn btn-warning mt-3" @click="showPaymentOptionSelection('offre2')">Choisir option de paiement</button>
            </div>
          </div>
          <h5>Prix : {{ offre2.price }} DH</h5>
        </div>
        
      </div>
    </div>

    <!-- Modal pour choisir les enfants -->
    <div v-if="showChildModal" class="modal fade show" style="display: block;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Choisir les enfants pour {{ selectedOffer }}</h5>
            <button type="button" class="btn-close" @click="closeModal"></button>
          </div>
          <div class="modal-body">
            <div v-for="(child, index) in children" :key="index" class="form-check">
              <input class="form-check-input" type="checkbox" :id="'child-' + index" v-model="selectedChildren">
              <label class="form-check-label" :for="'child-' + index">{{ child }}</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal">Fermer</button>
            <button type="button" class="btn btn-primary" @click="addChildrenToOffer">Ajouter</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal pour choisir les activités -->
    <div v-if="showActivityModal" class="modal fade show" style="display: block;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Choisir les activités pour {{ selectedOffer }}</h5>
            <button type="button" class="btn-close" @click="closeModal"></button>
          </div>
          <div class="modal-body">
            <div v-for="(activity, index) in allActivities" :key="index" class="form-check">
              <input class="form-check-input" type="checkbox" :id="'activity-' + index" v-model="selectedActivities">
              <label class="form-check-label" :for="'activity-' + index">{{ activity }}</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal">Fermer</button>
            <button type="button" class="btn btn-primary" @click="addActivitiesToOffer">Ajouter</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal pour choisir les options de paiement -->
    <div v-if="showPaymentModal" class="modal fade show" style="display: block;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Choisir les options de paiement pour {{ selectedOffer }}</h5>
            <button type="button" class="btn-close" @click="closeModal"></button>
          </div>
          <div class="modal-body">
            <div v-for="(option, index) in allPaymentOptions" :key="index" class="form-check">
              <input class="form-check-input" type="checkbox" :id="'payment-' + index" v-model="selectedPaymentOptions">
              <label class="form-check-label" :for="'payment-' + index">{{ option }}</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal">Fermer</button>
            <button type="button" class="btn btn-primary" @click="addPaymentOptionsToOffer">Ajouter</button>
          </div>
        </div>
      </div>
    </div>
 <router-link to="/dashboard-parents/Demandes/overview" class="btn btn-primary" type="button">Demander</router-link>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showChildModal: false,
      showActivityModal: false,
      showPaymentModal: false,
      selectedOffer: null,
      selectedChildren: [],
      selectedActivities: [],
      selectedPaymentOptions: [],
      children: ["Enfant 1", "Enfant 2", "Enfant 3"],
      allActivities: ["Programation", "Robotique", "Intelligence artificielle", "Calcul mental", "Laboratoire de chimie", "Laboratoire de biologie","Jeux d'échecs"],
      allPaymentOptions: ["Mensuel", "Annuel", "Trimestriel", "Semestriel"],
      offre1: {
        title: "Offre RAMADAN",
        description: "En l'honneur du mois sacré de Ramadan, nous avons conçu une offre spéciale pour les enfants, remplie d'activités qui leur permettront de comprendre et de célébrer cette période de réflexion et de partage. Cette offre combine des éléments éducatifs, culturels et ludiques pour une expérience enrichissante.",
        selectedActivities: [],
        selectedChildren: [],
        selectedPaymentOptions: [],
        price: 399
      },
      offre2: {
        title: "Offre AID AL ADHA",
        description: "Pour célébrer Aid al-Adha, nous proposons une offre spéciale permettant aux enfants de s'immerger dans les traditions et les valeurs de cette fête. Cette offre inclut des activités éducatives et ludiques qui permettront aux enfants de mieux comprendre l'importance d'Aid al-Adha tout en s'amusant.",
        selectedActivities: [],
        selectedChildren: [],
        selectedPaymentOptions: [],
        price: 499
      }
    };
  },
  methods: {
    showChildSelection(offer) {
      this.selectedOffer = offer;
      this.showChildModal = true;
      this.showActivityModal = false;
      this.showPaymentModal = false;
    },
    showActivitySelection(offer) {
      this.selectedOffer = offer;
      this.showChildModal = false;
      this.showActivityModal = true;
      this.showPaymentModal = false;
    },
    showPaymentOptionSelection(offer) {
      this.selectedOffer = offer;
      this.showChildModal = false;
      this.showActivityModal = false;
      this.showPaymentModal = true;
    },
    closeModal() {
      this.showChildModal = false;
      this.showActivityModal = false;
      this.showPaymentModal = false;
      this.selectedChildren = [];
      this.selectedActivities = [];
      this.selectedPaymentOptions = [];
    },
    addChildrenToOffer() {
      console.log(`Ajouté ${this.selectedChildren.length} enfants à ${this.selectedOffer}`);
      this.closeModal();
    },
    addActivitiesToOffer() {
      console.log(`Ajouté ${this.selectedActivities.length} activités à ${this.selectedOffer}`);
      this.closeModal();
    },
    addPaymentOptionsToOffer() {
      console.log(`Ajouté ${this.selectedPaymentOptions.length} options de paiement à ${this.selectedOffer}`);
      this.closeModal();
    }
  }
};
</script>
<style scoped>
h5{
  text-align: center;
  color: blue;
  font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
}
.text-left {
  text-align: left;
  color: blue;
}
.container {
  max-width: 1200px;
  margin: auto;
  transition: transform 0.2s;
  background-image: url('https://png.pngtree.com/thumb_back/fh260/background/20220907/pngtree-simple-blue-orange-background-image_1463611.jpg'); /* Replace with the path to your image */
  background-size: cover;
  background-position: center;
  position: relative;
  overflow: hidden;
  color: white; 
}
.offer-card-1 {
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s;
  background-image: url('https://img.freepik.com/vecteurs-libre/elegante-lune-decorative-ramadan-kareem-voeux-lanternes_1017-31069.jpg'); 
  background-size: cover;
  background-position: center;
  position: relative;
  overflow: hidden;
  color: white; 
}
.offer-card-2 {
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s;
  background-image: url('https://img.freepik.com/premium-vector/eid-mubarak-background_637136-70.jpg'); 
  background-size: cover;
  background-position: center;
  position: relative;
  overflow: hidden;
  color: white; 
} 
.offer-card:hover {
  transform: translateY(-5px);
}
.card-header h3 {
  font-family: Georgia, 'Times New Roman', Times, serif;
  color: orange;
}
.card-body {
  padding: 20px;
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
}
.modal {
  background: rgba(0, 0, 0, 0.5);
}
.modal-content {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.modal-title {
  font-family: Georgia, 'Times New Roman', Times, serif;
  color: orange;
}
.modal-body {
  padding: 20px;
}
.modal-footer {
  padding: 20px;
  justify-content: center;
}
</style>
