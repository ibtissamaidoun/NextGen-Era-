<template>
    <div class="card">
      <div class="card-header pb-0 table-responsive p-6">
        <h4 class="text-center mb-4">Tables des heures</h4>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0" >
          <table class="table align-items-center  mb-0">
            <thead>
              <tr>
                <th  class="text-uppercase text-secondary opacity-7">Horaires disponibles </th>
                
                <th
                  class="text-center  text-secondary  opacity-7"
                >
                  Choisir
                </th>
                
                <th class="text-secondary opacity-7"> Editer</th>
                <th class="text-secondary opacity-7">Supprimer</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(activity, index) in horaires" :key="index" class="bg-gray-100">
                <td class="text-center">
                  <div>
                    <h6>{{ activity.horairedispo }}</h6>
                  </div>
                </td>
                
                <td class="align-middle text-center">
                  <i class="ni ni-check-bold" style="color:orange"></i>
                </td>
               
                
                <td class="align-middle">

                <button
                  class="btn btn-link text-danger text-gradient px-3 mb-0"
                 
                >
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </button>
              
              </td>
                <td class="align-middle">
                  <button
                  class="btn btn-link text-danger text-gradient px-3 mb-0"
                 @click="deleteAnimateur( activity.id,index)"
                  >
                  <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
                </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>

  <style scoped>
  h4{
    font-family: Georgia, 'Times New Roman', Times, serif;
    color:orange;
  }
  h6{
    font-family: Georgia, 'Times New Roman', Times, serif;
    color:#000080;
  }

  </style>
    <script>
    /* eslint-disable */ 
    import axiosInstance from '@/main';

    export default {
      data() {
        return {
          horaires: [
          { 
          horairedispo:"9:00"
          },
          { 
          horairedispo:"18:00"
          },
          { 
          horairedispo:"19:30"
          },
          { 
          horairedispo:"10:30",
          },
          { 
          horairedispo:"12:00",
          },

          ]
        }},
      
        async created(){
          try {
          let response = await axiosInstance.get("animateur/horaires");
          this.horaires = response.data;
          console.log(response.data);
        }
        catch (error) {
      console.error('Erreur lors de la récupération des horaires:', error);
    }
    },
    
        
    methods: {
    async deleteAnimateur(horaire_id, index) {

      try {
        this.horaires.splice(index, 1); // Supprime l'entrée du tableau local
        await axiosInstance.delete("animateur/horaires/"+horaire_id); // Remplacez par l'URL correcte
        
      } catch (error) {
        console.error('Erreur lors de la suppression de l\'animateur:', error);
      }}}}
  
   
   
    </script>