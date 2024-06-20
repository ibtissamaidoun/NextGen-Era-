<template>
    <div id="features" class="accordion-1">
   <div class="container">
       <div class="row">
           <div class="col-xl-12">
               <h2 class="h2-heading">{{ activite.titre }}</h2>
               <p class="p-heading">{{ activite.description }}</p>
               <h5>OBJÉCTIFES</h5>
               <p class="p-heading">{{ activite.objectifs }}</p>
           </div> 
       </div>
                <h5>DÉTAILS</h5>
                <table>
                    <tr>
                        <th>Domaine d'activité</th>
                        <td>{{ activite.domaine_activite }}</td>
                    </tr>
                    <tr>
                        <th>Type d'activité</th>
                        <td>{{ activite.type_activite }}</td>
                    </tr>
                    <tr>
                        <th>Plage d'Age</th>
                        <td>de {{ activite.age_min }} à {{ activite.age_max }} ans</td>
                    </tr>
                    <tr>
                        <th>Nombre de séances</th>
                        <td>{{ activite.nbr_seances_semaine }} séances par semaine</td>
                    </tr>
                    <tr>
                        <th>Effectif min. - max.</th>
                        <td>de {{ activite.effectif_min }} à {{ activite.effectif_max }} places</td>
                    </tr>
                    <tr>
                        <th>Effectif actuel</th>
                        <td>{{ activite.effectif_actuel }} places rempli</td>
                    </tr>
                    <tr>
                        <th>Tarif</th>
                        <td>{{ activite.tarif }} MAD</td>
                    </tr>
                </table>
                <h5>LES HORAIRES D'ÉTUDE</h5>
                <table>
                        <thead>
                            <tr>
                                <th scope="col">Jour</th>
                                <th scope="col">Heure de début</th>
                                <th scope="col">Heure de fin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="horaire in horaires" :key="horaire.id" >
                                <td>{{ horaire.jour_semaine }}</td>
                                <td>{{ horaire.heure_debut }}</td>
                                <td>{{ horaire.heure_fin }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <h5>LES OPTION DE PAIEMENTS DISPONIBLES</h5>
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">Intitulé</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="Op in mode_paiements" :key="Op.id">
                                <td>{{ Op.option_paiement }}</td>
                            </tr>
                        </tbody>
                    </table>
         <h5>VIDÉO</h5>
        <iframe width="560" height="315" :src="getYoutubeEmbedUrl(activite.lien_youtube)" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <h5 style="margin-block-start: 20px;">SELECTIONNER VOUS ENFANTS :</h5>
        <div>
            <ul>
                <li v-for="e in enfants" :key="e.id">
                <input type="checkbox" :id="e.id" :value="e.id" v-model="selectedEnfants">
                <label :for="e.id" style="font-size: 1.1rem;">{{ e.nom }} {{ e.prenom }}</label>
                </li>
            </ul>
            <button @click="addToCart(selectedEnfants)">Ajouter au panier</button>
        </div>
    </div> 
 </div> 
</template>

<script>
import axiosInstance from '@/axios-instance';
import 'vue3-toastify/dist/index.css';

export default {
  data() {
    return {
        activite: [],
        horaires: [],
        mode_paiements: [],
        enfants: [],
        selectedEnfants: []
    };
  },
  computed: {
    activiteId() {
        return this.$route.params.id;
    }
  },
  created() {
    this.getData();

  },
  methods:{
    async getData() {
        const responce1 = await axiosInstance.get(`/dashboard-parents/Activites/${this.activiteId}`);
        this.activite = responce1.data.activite;
        this.horaires = responce1.data.hoaraires;
        this.mode_paiements = responce1.data.mode_paiements;

        const responce2 = await axiosInstance.get('/dashboard-parents/Enfants');
        this.enfants = responce2.data.enfants;
    },

    getYoutubeEmbedUrl(url) {
    if (!url) {
      return ''; // Return an empty string or a default embed URL if the URL is not defined
    }
    const urlParts = url.split('v=');
    if (urlParts.length > 1) {
      const videoId = urlParts[1].split('&')[0]; // Split by '&' to handle additional query parameters
      return `https://www.youtube.com/embed/${videoId}`;
    } else {
      return '';
    }
  },

  addToCart(selectedEnfants) {
    axiosInstance.post(`/dashboard-parents/Activite/${this.activiteId}/add`, {
        enfants: selectedEnfants
        });
  }
  }
};
</script>

<style scoped>
    p {
        text-align: justify;
        padding-block-end: 20px;
    }

    .accordion-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px; /* Ajouter une marge inférieure pour espacer les items */
    }

    .accordion-item h5 {
        margin-left: 10px; /* Espace entre l'icône et le texte */
    }
    .accordion-item span {
        padding-inline-end: 10px; /* Espace entre l'icône et le texte */
    }
    table {
    border-collapse: collapse;
    width: 100%;
    margin-block-end: 35px;
  }

  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }

  th {
    background-color: #f0f0f0;
  }

  tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  tr:hover {
    background-color: #ccc;
  }
  ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

li {
  margin-bottom: 10px;
}

input[type="checkbox"] {
  margin-right: 10px;
}
button {
  background-color: #4CAF50;
  color: #ffffff;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button:hover {
  background-color: #3e8e41;
}


</style>