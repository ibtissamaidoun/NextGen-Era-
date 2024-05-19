<template>
    <!-- <div class="card pb-5 "> -->

      <div >
        <h4 class=" mt-5 text-center" >Les détails des activtés</h4>
      </div>
      <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center"> 
        <table class="table table-bordered  align-items-center">
        <thead>
          <tr>
            <th class="text-center text-primary opacity-7">
              Id
            </th>
            <th class="text-center text-primary opacity-7">
              Titre
            </th>
            <th class="text-center text-primary opacity-7">
              Type d'activté
            </th>
            <th class="text-center text-primary opacity-7">
              Domaine d'activité
            </th>
            <th class="text-center text-primary opacity-7">
              Heure de début
            </th>
            <th class="text-center text-primary opacity-7">
              Heure de la fin
            </th>
            <th class="text-center text-primary opacity-7">
              Jour de la semaine 
            </th>
            <th class="text-center text-primary opacity-7">
              Remise
            </th>
            <th class="text-center text-primary opacity-7">
              Choisir
            </th>  
            <th class="text-center text-primary opacity-7">
              Supprimer
            </th>     
            <th class="text-center text-primary opacity-7">
              Option de paiement 
            </th>
            
          </tr>
        </thead>
        <tbody>
          <tr v-for="(activity, index) in affectes" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
            <td>
              <h6 class="mb-2 text-center">{{ activity.id }}</h6>
            </td> 
            <td class="text-center">  
                <span class="text-s">{{ activity.titre }}</span>
              </td> 
              <td class="text-center">  
                <span class="text-s">{{ activity.typeactivite }}</span>
              </td> 
              <td class="text-center">  
                <span class="text-s">{{ activity.domaineactivite }}</span>            
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ activity.heuredebut }}</span>
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ activity.heurefin }}</span>
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ activity.joursemaine }}</span>
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ activity.remise }}</span>
            </td>
            <td class="align-middle text-center">
                  <i class="ni ni-check-bold" style="color:orange"></i>
                </td>
                <td class="align-middle">
                  <a
                    class="btn btn-link text-warning text-gradient px-3 mb-0"
                    href="javascript:;"
                  >
                  <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
                  </a>
                </td>
            <td class="text-center">
              <select v-model="activity.optionpaiement" class="form-control">
                <option value="Option 1">Betcoin</option>
                <option value="Option 2">Master card</option>
                <option value="Option 3">Visa card</option>
              </select>
            </td>

          </tr>
        </tbody>
      </table>
    </div>
    <!-- </div> -->
  </template>
  
  <script>
  /* eslint-disable */

  export default {
    data() {
      return {
        affectes: [
        {
          id: "1",
          titre: "Oulad Maalem", 
          typeactivite: "Ayoub",
          domaineactivite: "ayoub@example.com",
          heuredebut: "0612345678",
          heurefin: "0123456789",
          joursemaine: "Informatique",
          optionpaiement: "9h - 17h",
          remise: "9h - 17h",

        },
        {
          id: "1",
          titre: "Oulad Maalem", 
          typeactivite: "Ayoub",
          domaineactivite: "ayoub@example.com",
          heuredebut: "0612345678",
          heurefin: "0123456789",
          joursemaine: "Informatique",
          optionpaiement: "9h - 17h",
          remise: "9h - 17h",

        },
        {
          id: "1",
          titre: "Oulad Maalem", 
          typeactivite: "Ayoub",
          domaineactivite: "ayoub@example.com",
          heuredebut: "0612345678",
          heurefin: "0123456789",
          joursemaine: "Informatique",
          optionpaiement: "9h - 17h",
          remise: "9h - 17h",

        },
        {
          id: "1",
          titre: "Oulad Maalem", 
          typeactivite: "Ayoub",
          domaineactivite: "ayoub@example.com",
          heuredebut: "0612345678",
          heurefin: "0123456789",
          joursemaine: "Informatique",
          optionpaiement: "9h - 17h",
          remise: "9h - 17h",

        },
        {
          id: "1",
          titre: "Oulad Maalem", 
          typeactivite: "Ayoub",
          domaineactivite: "ayoub@example.com",
          heuredebut: "0612345678",
          heurefin: "0123456789",
          joursemaine: "Informatique",
          optionpaiement: "9h - 17h",
          remise: "9h - 17h",

        },
        ],
        
      };
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
  </style>
  