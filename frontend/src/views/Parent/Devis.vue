<template>
  <div class="card pb-8">
    <div class="card-header pb-3 px-3">
      <h3 class="mb-2 text-center">Devis de la Demande : {{ Devis.serie }}</h3>
    </div>
    <div class="card-body pt-2 p-3">
      <div class="table-responsive">
        <table class="table">
          
            <tr>
              <th class="text-uppercase text-secondary opacity-7">Serie</th>
              <td >{{ Devis.serie }}</td>
            </tr>
            <tr>
              <th class="text-uppercase text-secondary opacity-7">date d'Expiration</th>
              <td >{{ Devis.expiration }}</td>
            </tr>
            <tr v-if="Devis.offre !== null && Devis.offre !== undefined">
              <th class="text-uppercase text-secondary opacity-7">Offre</th>
              <td >{{ Devis.offre.titre }}</td>
            </tr>
            <tr v-if="Devis.pack !== null && Devis.pack !== undefined">
              <th class="text-uppercase text-secondary opacity-7">Demande Pack</th>
              <td>{{ Devis.pack.type }}</td>
            </tr>
            <tr>
              <th class="text-uppercase text-secondary opacity-7">L'Option Paiment</th>
              <td >{{ Devis.optionPaiment }}</td>
            </tr>
            <tr>
              <th class="text-uppercase text-secondary opacity-7">Duree de paiment</th>
              <td >{{ Devis.period }}</td>
            </tr>
            <tr>
              <th class="text-uppercase text-secondary opacity-7">Tarif Hors taxe</th>
              <td >{{ parseFloat(Devis.prixHT).toFixed(2) }}</td>
            </tr>
            <tr>
              <th class="text-uppercase text-secondary opacity-7">Tarif a remise appliquée</th>
              <td >{{ parseFloat(Devis.prixRemise).toFixed(2) }}</td>
            </tr>
            <tr>
              <th class="text-uppercase text-secondary opacity-7">tva</th>
              <td >{{ Devis.TVA }} %</td>
            </tr>
            <tr>
              <th class="text-uppercase text-secondary opacity-7">Tarif TTC</th>
              <td >{{ parseFloat(Devis.TTC).toFixed(2) }}</td>
            </tr>
            <tr>
              <th class="text-uppercase text-secondary opacity-7">Tarif par Periode</th>
              <td >{{ Devis.prixOP }}</td>
            </tr>

            <tr>
               <th class="text-uppercase text-secondary opacity-7">Actions</th>
               <td >
                <div class="facture-actions">
                  <div class="actions-buttons">
                    <button class="download-button" @click="downloadDevis()">
                      <i class="fa fa-download"></i> Télécharger Devis
                    </button>
                    <button class="accept-button" @click="validateAndRedirect()">
                      <i class="fa fa-check"></i> Valider
                    </button>
                    <button class="refuse-button" @click="RefuseDevis()">
                      <i class="fa fa-times"></i> Refuser
                    </button>
                    
                  </div>
                </div>
               </td>
            </tr>
            </table>
              <div v-if="showRefusalForm" class="refusal-form pt-4 p-3">
                <h5 class="subtitle">Votre Motif de Refus</h5>
                <textarea v-model="refusalReason" placeholder="Entrez le motif de refus" class="motif-input"></textarea>
                <button class="submit-button" @click="submitRefusal()">Soumettre</button>
              </div> 
         <h5 style="padding: 20px;">Information sur l'affectation des enfants</h5>
         <table  class="table">
          <thead style="background-color: #00000005;">
          <tr>
            <th class="text-uppercase text-secondary opacity-7" >mes Enfants</th>
            <th class="text-uppercase text-secondary opacity-7">Activités</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(myData, index) in Devis.enfantsActivites" :key="index">
              <td :style="{ paddingBlock: '7px', paddingInline: '20px' }">
                {{ myData.enfant }}
              </td>
              <td style="padding-block: 7px; padding-inline: 20px;">{{ myData.activite }}</td>
          </tr>
          </tbody>
        </table>



      </div>
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
        Devis: [],
        showRefusalForm: false,
        refusalReason: "",
        displayedChildren: new Set(),
        
      };
    },
    components: {
      ArgonButton,
    },
    created() {
      this.fetchDevis();
    },
    computed:{
      demandeId (){
        return this.$route.params.demandeId;
      },
      demande(){
        return this.$route.params.demande;
      }
    },
    methods: {
      async fetchDevis() {
      try {
        const response = await axiosInstance.get(`/dashboard-parents/Demandes/${this.demandeId}/overview`);
        this.Devis = response.data;
        console.log(this.Devis);
      } catch (error) {
        console.error('Erreur lors de la récupération des devis:', error);
      }
    },

      async downloadDevis() {
        try {
          const response = await axiosInstance.get(`/dashboard-parents/Demandes/${this.demandeId}/download-devis`, {
            responseType: 'blob'
          });
          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', `Devis_${this.demandeId}.pdf`); // ou tout autre nom de fichier
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
          console.log(`Téléchargement du devis ${this.demandeId}`);
        } catch (error) {
          console.error('Erreur lors du téléchargement du devis:', error);
        }
      },



      async validateAndRedirect() {
        try {
          const response = await axiosInstance.post(`/dashboard-parents/Demandes/${this.demandeId}/devis/validate`);
         alert(response.data.message);
          // Rediriger vers la page de facture si nécessaire
          this.$router.push({ name: 'DemandesP'});
        } catch (error) {
          console.error('Erreur lors de la validation du devis:', error);
        }
      },

      async RefuseDevis() {
        try {
          const response = await axiosInstance.post(`/dashboard-parents/Demandes/${this.demandeId}/devis/refuse`);
          this.showRefusalForm = true;
        } catch (error) {
          console.error('Erreur lors de la validation du devis:', error);
        }
      },



      async submitRefusal() {
        if (this.refusalReason.trim()) {
          try {
            const response = await axiosInstance.post(`/dashboard-parents/Demandes/${this.demandeId}/devis/refuse/motif`, {
              motif: this.refusalReason
            });
            this.$router.push({ name: 'DemandesP'});
          } catch (error) {
            console.error('Erreur lors de la soumission du motif de refus:', error);
          }
        } else {
          alert("Veuillez entrer un motif de refus.");
        }
      }
    }
  };
</script>
  
<style scoped>
  
    .card-header h3 {
      font-family: revert-layer, sans-serif;
      color: orange;
    }
  
  table, th, td {
  border: 1px solid #e9ecef;
  border-collapse: collapse;
  }
  th {
    background-color: #00000005;
  }
  th, td {
    padding-inline: 20px;
    padding-block: 7px;
    text-align: left;
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
    background-color: navy;
    color: white;
  }
  .actions-buttons {
    display: flex;
    gap: 20px;
    align-items: center;
  }
  
  .accept-button {
    background-color: green;
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