<template>
  <div class="card">
    <div class="card-header pb-0 px-3">
      <h4 class="mb-2 text-center">Mes Demandes</h4>
    </div>
    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center"> 
      <table class="table table-bordered align-items-center">
        <thead>
          <tr>
            <th class="text-uppercase text-primary opacity-7">
              Nº
            </th>
            <th class="text-uppercase text-primary opacity-7">
              Date de demande
              </th>
              <th class="text-uppercase text-primary opacity-7">
                Statut
              </th>
              <th class="text-uppercase text-primary opacity-7">
                Devis / Facture
              </th>
              <th class="text-uppercase text-primary opacity-7">
            Supprimer
          </th>
            
          </tr>
        </thead>
        <tbody>
          <tr v-for="(demande, index) in demandes" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
            <td>
              <h6 class="mb-2 text-center">{{ index +1 }}</h6>
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ demande.date_demande }}</span>
              </td> 
            <td class="text-center">  
              <span class="text-s">{{ demande.statut }}</span>
            </td> 
            
            <td class="align-middle">
                <template v-if="demande.statut == 'brouillon'">
                  <a @click="goToDevis(demande)" class="btn btn-link text-dark px-3 mb-0" href="javascript:;">
                    Voir le Devis
                  </a>
                </template>
                <template v-else-if="demande.statut == 'en cours'">
                  <button class="download-button" @click="downloadFacture(demande)">
                    <i class="fa fa-download"></i> Télécharger Facture
                  </button>
                </template>
                <h6 v-else>-</h6>
                  </td>
                    <td class="text-center">  
                      <template v-if="demande.statut == 'brouillon'">
                        <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"  @click="deleteDemande(demande.id, index)">
                          <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
                        </a>
                      </template>
                      <h6 v-else>-</h6>
                  </td>
          </tr>
        </tbody>
      </table>
    </div>

    
  </div>



</template>

<script>
/* eslint-disable */
import ArgonButton from '@/components/ArgonButton.vue';
import axiosInstance from '@/axios-instance';

export default {
  data() {
    return {
      demandes: [],
    };
  },
  components: {
  ArgonButton,
},
created() {
  this.fetchDemandes();
},


methods: {
  async fetchDemandes() {
    try {
      const response = await axiosInstance.get('/dashboard-parents/Demandes');
      this.demandes = response.data.demandes;
    } catch (error) {
      console.error('Error fetching demandes:', error);
    }
  },


  async deleteDemande(demande_id, index) {
    try {
      const response = await axiosInstance.delete(`/dashboard-parents/Demandes/${demande_id}/delete`);
      this.demandes.splice(index, 1);
      console.log('Demandes supprimé');
    } catch (error) {
      console.error('Erreur lors de la suppression de l\'Demandes:', error);
      alert('Erreur lors de la suppression de l\'Demandes: ' + (error.response ? error.response.data.message : error.message));
    }
  },

  goToDevis(demande) {
    this.$router.push({ name: 'devis', params: { demandeId: demande.id } });
  },

  async downloadFacture(demande) {
      try {
        const response = await axiosInstance.get(`/dashboard-parents/Demandes/${demande.id}/download-facture`, {
          responseType: 'blob'
        });
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', `Facture_${demande.id}.pdf`); // ou tout autre nom de fichier
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        console.log(`Téléchargement du devis ${this.demandeId}`);
      } catch (error) {
        console.error('Erreur lors du téléchargement du devis:', error);
      }
    },



},

  
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

.download-button {
  padding: 8px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
  background-color: navy;
  color: white;
}
</style>