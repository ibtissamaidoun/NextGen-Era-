<script setup>

import Pack from "./components/PackParents.vue";
import Factures from "./components/Factures.vue";
import Devis from "./components/Devis.vue"

</script>
<template>
  <div class="py-4 container-fluid">
    <div class="mt-4 row">
      <div class="col-12">
        <pack />
      </div>
  </div>
    <div class="mt-4 row">
      <div class="col-12">
        <factures />
      </div>
  </div>
  <div class="mt-4 row">
      <div class="col-12">
        <devis />
      </div>
  </div>

  </div>
</template>