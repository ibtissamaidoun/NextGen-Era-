<template>
  <div class="card pb-8">
    <div class="card-header pb-3 px-3">
      <h3 class="mb-2 text-center">Factures</h3>
    </div>
    <div class="card-body pt-2 p-3">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary opacity-7">ID</th>
              <th class="text-uppercase text-secondary opacity-7">Date</th>
              <th class="text-uppercase text-secondary opacity-7">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(devis, index) in devisList" :key="index">
              <td class="text-center">{{ devis.id }}</td>
              <td class="text-center">{{ devis.date }}</td>
              <td class="text-center">
                  <div class="facture-actions">
                   <div class="actions-buttons">
                <button class="download-button" @click="downloadDevis(devis.id)">
                  <i class="fa fa-download"></i> Pdf
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
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";



const devisList = ref([
  { id:2, date:"16/06/2024"},
  // Ajoutez d'autres devis ici
]);

const downloadDevis = (id) => {
  console.log(`Téléchargement du devis ${id}`);
};

const deleteDevis = (id) => {
  console.log(`Devis ${id} supprimé`);
  devisList.value = devisList.value.filter((devis) => devis.id !== id);
};

;
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

.download-button,.delete-button{
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


.delete-button {
  background-color: #000000;
  color: white;
}


</style>
