<template>
    <div class="card pb-8">
      <div class="card-header pb-3 px-3">
        <h3 class="mb-2 text-center">Gestion du Devis</h3>
      </div>
      <div class="card-body pt-2 p-3">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary opacity-7">ID</th>
                <th class="text-uppercase text-secondary opacity-7">Date</th>
                <th class="text-uppercase text-secondary opacity-7">Statut</th>
                <th class="text-uppercase text-secondary opacity-7">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(devis, index) in devisList" :key="index">
                <td class="text-center">{{ devis.id }}</td>
                <td class="text-center">{{ devis.date }}</td>
                <td class="text-center">{{ devis.status }}</td>
                <td class="text-center">
                    <div class="facture-actions">
                     <div class="actions-buttons">
                  <button class="download-button" @click="downloadDevis(devis.id)">
                    <i class="fa fa-download"></i> Pdf
                  </button>
                  <button class="accept-button" @click="validateDevis(devis.id)">
                    <i class="fa fa-check"></i> Valider
                  </button>
                  <button class="refuse-button" @click="showRefusalForm = devis.id">
                    <i class="fa fa-times"></i> Refuser
                  </button>
                  <button class="delete-button" @click="deleteDevis(devis.id)">
                    <i class="fa fa-trash"></i> Supprimer
                  </button>
                    </div>
                </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div v-if="showRefusalForm" class="refusal-form pt-4 p-3">
          <h5 class="subtitle">Motif de Refus</h5>
          <textarea v-model="refusalReason" placeholder="Entrez le motif de refus" class="motif-input"></textarea>
          <button class="submit-button" @click="submitRefusal(showRefusalForm)">Soumettre</button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from "vue";
  
  const showRefusalForm = ref(null);
  const refusalReason = ref("");
  
  const devisList = ref([
    { id: 1, date:"17/09/2023", status: "En attente" },
    { id: 2, date:"12/12/2024",status: "Validé" },
    { id: 3, date:"12/12/2024",status: "Refusé" },
    // Ajoutez d'autres devis ici
  ]);
  
  const downloadDevis = (id) => {
    console.log(`Téléchargement du devis ${id}`);
  };
  
  const validateDevis = (id) => {
    console.log(`Devis ${id} validé`);
    const devis = devisList.value.find((devis) => devis.id === id);
    devis.status = "Validé";
  };
  
  const deleteDevis = (id) => {
    console.log(`Devis ${id} supprimé`);
    devisList.value = devisList.value.filter((devis) => devis.id !== id);
  };
  
  const submitRefusal = (id) => {
    if (refusalReason.value.trim()) {
      console.log(`Motif de refus pour le devis ${id} soumis:`, refusalReason.value);
      const devis = devisList.value.find((devis) => devis.id === id);
      devis.status = "Refusé";
      showRefusalForm.value = null;
      refusalReason.value = "";
    } else {
      alert("Veuillez entrer un motif de refus.");
    }
  };
  </script>
  
  <style scoped>
  .card-header h3 {
    font-family: Georgia, 'Times New Roman', Times, serif;
    color: orange;
  }
  
  .table th,
  .table td {
    vertical-align: middle;
  }
  
  .download-button, .accept-button, .refuse-button, .delete-button, .submit-button {
    padding: 8px 20px;
    margin-top: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  }
  
  .facture-actions {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .download-button {
    background-color: #000080;
    color: white;
  }
  .actions-buttons {
    display: flex;
    gap: 20px;
    align-items: center;
  }
  
  .accept-button {
    background-color: orange;
    color: white;
  }
  
  .refuse-button {
    background-color: #ff0019;
    color: white;
  }
  
  .delete-button {
    background-color: #000000;
    color: white;
  }
  
  .submit-button {
    background-color: #007bff;
    color: white;
  }
  
  .motif-input {
    width: 100%;
    height: 100px;
    padding: 10px;
    margin-top: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
  }
  </style>
  