<template>
    <div class="card pb-8">
      <div class="card-header pb-3 px-3">
        <h1 class="mb-2 text-center">Résumé</h1>
      </div>
      <div class="card-body pt-2 p-3">
    <div class="request-overview">
      <!-- Informations de la demande -->
      <div class="request-info">
        <h2>Détails de la demande</h2>
        <div class="info-item">
          <span class="label">Série de demande :</span>
          <span class="value">{{ request.series }}</span>
        </div>
        <div class="info-item">
          <span class="label">Date de demande :</span>
          <span class="value">{{ request.date }}</span>
        </div>
        <div class="info-item">
          <span class="label">Statut de demande :</span>
          <span class="value">{{ request.status }}</span>
        </div>
        <div class="info-item">
          <span class="label">Date d'expiration :</span>
          <span class="value">{{ request.expiryDate }}</span>
        </div>
        <div class="info-item">
          <span class="label">Titre de l'offre :</span>
          <span class="value">{{ request.offerTitle }}</span>
        </div>
        <!-- Tableau des enfants et des activités -->
        <div class="child-activity-table">
          <h2>Enfants et activités</h2>
          <table>
            <thead>
              <tr>
                <th>Enfant</th>
                <th>Activité</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(childActivity, index) in request.childActivities" :key="index">
                <td>{{ childActivity.child }}</td>
                <td>{{ childActivity.activity }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Informations de paiement -->
      <div class="payment-info">
        <h2>Informations de paiement</h2>
        <div class="info-item">
          <span class="label">Option de paiement :</span>
          <span class="value space-between">{{ paymentInfo.paymentOption }}</span>
        </div>
        <div class="info-item">
          <span class="label">Prix TTC :</span>
          <span class="value">{{ paymentInfo.totalPrice }}</span>
        </div>
        <div class="info-item">
          <span class="label">Prix OP :</span>
          <span class="value">{{ paymentInfo.opPrice }}</span>
        </div>
        <div class="info-item">
          <span class="label">Période :</span>
          <span class="value">{{ paymentInfo.period }}</span>
        </div>
      </div>
      <!-- Actions -->
      <div class="actions">
        <button class="btn btn-success" @click="validateRequest">Valider</button>
        <button class="btn btn-danger" @click="rejectRequest">Refuser</button>
      </div>
    </div>
    </div>
</div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        request: {
          series: "ABC123",
          date: "2024-06-15",
          status: "En attente",
          expiryDate: "2024-06-22",
          offerTitle: "Pack MULTI-ACTIVITES",
          childActivities: [
            { child: "Ahmed", activity: "Programmation" },
            { child: "Ahmed", activity: "Robotique" },
            { child: "Ahmed", activity: "Calcul mental avancé" },

          ]
        },
        paymentInfo: {
          paymentOption: "Paiement Mensuel",
          totalPrice: "1697 DH",
          opPrice: "20 DH",
          period: "6 mois"
        }
      };
    },
    methods: {
      validateRequest() {
        // Redirection vers la page de validation
        this.$router.push("/dashboard-parents/Demandes/facture");
      },
      rejectRequest() {
        // Logique pour refuser la demande
        this.$router.push("/dashboard-parents/Activites");
      }
    }
  };
  </script>
  
  <style scoped>
  h1 {
  font-family: Georgia, 'Times New Roman', Times, serif;
  color: orange;
}
  .request-overview {
    max-width: 800px;
    margin: auto;
    padding: 20px;
  }
  
  .request-info {
    margin-bottom: 30px;
  }
  
  .info-item {
    margin-bottom: 10px;
  }
  
  .info-item .label {
    font-weight: bold;
  }
  
  .child-activity-table {
    margin-bottom: 30px;
  }
  
  .child-activity-table table {
    width: 100%;
    border-collapse: collapse;
  }
  
  .child-activity-table th, .child-activity-table td {
    border: 1px solid #ccc;
    padding: 8px;
  }
  
  .actions {
    margin-top: 30px;
  }
  
  .actions button {
    margin-right: 10px;
  }
  </style>
  