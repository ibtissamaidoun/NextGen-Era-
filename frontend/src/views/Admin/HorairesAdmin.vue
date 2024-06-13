<script setup>
import GestionHeures from "../components/GestionHeures.vue";
import AjoutHeure from "../components/AjoutHeure.vue"
</script>

<template>
  <div class="py-4 container-fluid">
    <!-- POP UP EDITER -->
    <div class="mt-4 row">
      <div class="col-12">
       <ajoutHeure /> 
      </div>
    </div> 
    <div class="mt-4 row">
      <div class="col-12">
       <GestionHeures /> 
      </div>
    </div>  
    
  </div>
</template>