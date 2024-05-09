<script setup>
import AuthorsTable from "./components/GestionParent.vue";
import Gestionadmin from "./components/Gestionadmin.vue";
import Gestionanim from "./components/Gestionanim.vue";

</script>
<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-12">
        <authors-table /> 
      </div>
    </div>
    <div class="mt-4 row">
      <div class="col-12">
        <Gestionadmin />
      </div>
    </div>
    <div class="mt-4 row">
      <div class="col-12">
        <Gestionanim />
      </div>
    </div>
  </div>
</template>
