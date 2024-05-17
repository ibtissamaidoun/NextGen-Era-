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
                <th
                  class="text-uppercase text-secondary opacity-7"
                >
                  Heures disponibles 
                </th>
                
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
                    <h6>{{ activity.heure }}</h6>
                  </div>
                </td>
                
               
                <td class="align-middle text-center">
                  <i class="ni ni-check-bold" style="color:orange"></i>
                </td>
              
                
                <td class="align-middle">
                <a
                  class="btn btn-link text-danger text-gradient px-3 mb-0"
                  href="javascript:;"
                >
                <i class="fa fa-pencil" aria-hidden="true"></i>
                </a>
              
              </td>
                <td class="align-middle">
                  <a
                    class="btn btn-link text-warning text-gradient px-3 mb-0"
                    href="javascript:;"
                  >
                  <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
                  </a>
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
    export default {
      data() {
        return {
          horaires: [
            {
              heure: "12:00-13:30",
            },
            {
              heure: "13:30-15:00", 
            },
            {
              heure: "10:30-12:00"
            },
            {
              heure: "18:00-19:30"
            },
            {
              heure: "19:30-21:00"
            },
            {
              heure: "16:30-18:00"
            },
            {
              heure: "21:00-22:00"
            },
            {
              heure: "21:00-22:00"
            },
            
            
            
          ]
        };
      }
    };
    </script>