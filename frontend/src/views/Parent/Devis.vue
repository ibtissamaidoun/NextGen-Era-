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
              <th class="text-uppercase text-secondary opacity-7">Tarif TTC</th>
              <th class="text-uppercase text-secondary opacity-7">Statut</th>
              <th class="text-uppercase text-secondary opacity-7">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="devis in devisList" :key="devis.id">
              <td class="text-center">{{ devis.id }}</td>
              <td class="text-center">{{ devis.tarif_ttc }}</td>
              <td class="text-center">{{ devis.statut }}</td>
              <td class="text-center">
                <div class="facture-actions">
                  <div class="actions-buttons">
                    <button class="download-button" @click="downloadDevis(devis.id)">
                      <i class="fa fa-download"></i> Pdf
                    </button>
                    <button class="accept-button" @click="validateAndRedirect(devis.id)">
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

<script>
import axiosInstance from '@/axios-instance';

export default {
  data() {
    return {
      devisList: [],
      showRefusalForm: null,
      refusalReason: "",
    };
  },
  created() {
    this.fetchDevis();
  },
  methods: {
    async fetchDevis() {
      try {
        const response = await axiosInstance.get('/dashboard-parents/Devis/');
        this.devisList = response.data.devis;
      } catch (error) {
        console.error('Erreur lors de la récupération des devis:', error);
      }
    },
    async deleteDevis(devis_id) {
      try {
        await axiosInstance.delete(`/dashboard-parents/Devis/${devis_id}`);
        this.devisList = this.devisList.filter(devis => devis.id !== devis_id);
        console.log('Devis supprimé');
      } catch (error) {
        console.error('Erreur lors de la suppression du devis:', error);
        alert('Erreur lors de la suppression du devis: ' + (error.response ? error.response.data.message : error.message));
      }
    },
    async validateAndRedirect(demande_id) {
      try {
        await axiosInstance.post(`/dashboard-parents/${demande_id}/Devis/validate`);
        console.log(`Devis ${demande_id} validé`);

        const devis = this.devisList.find(devis => devis.id === demande_id);
        if (devis) {
          devis.statut = "Validé";
        } else {
          console.error(`Devis with ID ${demande_id} not found in devisList`);
        }

        this.$router.push({ name: 'facture' });
      } catch (error) {
        console.error('Erreur lors de la validation du devis:', error);
      }
    },
    submitRefusal(id) {
      if (this.refusalReason.trim()) {
        console.log(`Motif de refus pour le devis ${id} soumis:`, this.refusalReason);
        const devis = this.devisList.find(devis => devis.id === id);
        if (devis) {
          devis.statut = "Refusé";
        } else {
          console.error(`Devis with ID ${id} not found in devisList`);
        }
        this.showRefusalForm = null;
        this.refusalReason = "";
      } else {
        alert("Veuillez entrer un motif de refus.");
      }
    },
    downloadDevis(id) {
      console.log(`Téléchargement du devis ${id}`);
      // Implémentez la logique de téléchargement si nécessaire
    },
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
